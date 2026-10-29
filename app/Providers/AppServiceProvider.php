<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (!function_exists('base_url')) {
            function base_url($path = '') {
                return url($path);
            }
        }

        spl_autoload_register(function ($class) {
            if (strpos($class, 'App\\') === 0) {
                $relative = substr($class, 4);
                if (!strpos($relative, '\\')) {
                    $candidates = [
                        app_path($relative . '.php'),
                        app_path(lcfirst($relative) . '.php'),
                        app_path(strtolower($relative) . '.php'),
                    ];
                    foreach ($candidates as $file) {
                        if (file_exists($file)) {
                            require_once $file;
                            return;
                        }
                    }
                }
            }
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        /*
        |-----------------------------------------------------------------------
        | View Composer: $sidebarMenus & $allowedMenus
        |-----------------------------------------------------------------------
        | Mengambil menu_sistem secara dinamis dari database untuk navigasi sidebar.
        | - Admin / Non-karyawan: menampilkan seluruh menu_sistem aktif.
        | - Karyawan: memfilter menu & sub-menu berdasarkan tabel pivot jabatan_menu.
        */
        View::composer('*', function ($view) {
            if (!Auth::check()) {
                $view->with([
                    'sidebarMenus' => [],
                    'allowedMenus' => [],
                ]);
                return;
            }

            $user = Auth::user();

            try {
                // 1. Tentukan hak akses menu ID untuk user
                if (!$user->karyawan) {
                    // Admin / Non-karyawan: akses penuh ke seluruh menu
                    $allowedMenuIds = null;
                    $allowedRoutes  = null;
                } else {
                    $idJabatan = DB::table('karyawan')
                        ->where('user_id_user', $user->id)
                        ->value('jabatan_id_jabatan');

                    $hasConfig = DB::table('jabatan_menu')
                        ->where('jabatan_id_jabatan', $idJabatan)
                        ->exists();

                    if ($hasConfig) {
                        $allowedMenuIds = DB::table('jabatan_menu')
                            ->where('jabatan_id_jabatan', $idJabatan)
                            ->pluck('menu_id_menu')
                            ->map(function ($val) { return (int) $val; })
                            ->toArray();
                    } else {
                        // Default: seluruh modul KECUALI yang tergolong admin
                        $adminRoutes = ['admin', 'log', 'menu_sistem.index'];
                        $adminIds = DB::table('menu_sistem')
                            ->whereIn('route_name', $adminRoutes)
                            ->orWhere('nama_menu', 'Admin')
                            ->pluck('id_menu')
                            ->toArray();

                        $allowedMenuIds = DB::table('menu_sistem')
                            ->where('is_active', 1)
                            ->whereNotIn('id_menu', $adminIds)
                            ->where(function ($q) use ($adminIds) {
                                $q->whereNull('parent_id')
                                  ->orWhereNotIn('parent_id', $adminIds);
                            })
                            ->pluck('id_menu')
                            ->map(function ($val) { return (int) $val; })
                            ->toArray();
                    }

                    $allowedRoutes = DB::table('menu_sistem')
                        ->whereIn('id_menu', $allowedMenuIds)
                        ->where('is_active', 1)
                        ->pluck('route_name')
                        ->toArray();
                }

                // 2. Ambil seluruh data menu_sistem yang aktif dari DB
                $rawMenus = DB::table('menu_sistem')
                    ->where('is_active', 1)
                    ->orderBy('urutan')
                    ->get();

                // Kelompokkan children berdasarkan parent_id
                $childrenMap = [];
                foreach ($rawMenus as $m) {
                    if (!empty($m->parent_id)) {
                        $childrenMap[$m->parent_id][] = $m;
                    }
                }

                // Susun tree menu untuk sidebar
                $sidebarMenus = [];
                foreach ($rawMenus as $m) {
                    if (is_null($m->parent_id)) {
                        $children = $childrenMap[$m->id_menu] ?? [];

                        if (is_null($allowedMenuIds)) {
                            // Admin: tampilkan semua menu dan anak-anaknya
                            $m->children = $children;
                            $sidebarMenus[] = $m;
                        } else {
                            // Karyawan:
                            if (!empty($children)) {
                                $permittedChildren = [];
                                foreach ($children as $child) {
                                    if (in_array((int)$child->id_menu, $allowedMenuIds)) {
                                        $permittedChildren[] = $child;
                                    }
                                }
                                if (!empty($permittedChildren)) {
                                    $m->children = $permittedChildren;
                                    $sidebarMenus[] = $m;
                                }
                            } else {
                                // Menu tunggal
                                if (in_array((int)$m->id_menu, $allowedMenuIds)) {
                                    $m->children = [];
                                    $sidebarMenus[] = $m;
                                }
                            }
                        }
                    }
                }
            } catch (\Exception $e) {
                $sidebarMenus = [];
                $allowedRoutes = [];
            }

            $view->with([
                'sidebarMenus' => $sidebarMenus,
                'allowedMenus' => $allowedRoutes,
            ]);
        });
    }
}
