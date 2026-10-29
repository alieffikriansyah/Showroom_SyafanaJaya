<?php

namespace App\Modules\MenuSistem\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Modules\MenuSistem\Models\MenuSistem;
use App\Modules\MenuSistem\Models\JabatanMenu;
use App\Modules\Jabatan\Models\jabatan;
use Auth;
use Exception;

class MenuSistemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Pastikan hanya user tanpa data karyawan (admin / superadmin) yang bisa akses
     */
    private function authorizeAccess()
    {
        if (Auth::user()->karyawan) {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengelola Menu Sistem.');
        }
    }

    /**
     * Halaman utama Menu Sistem
     */
    public function index()
    {
        $this->authorizeAccess();

        // Mengurutkan parent diikuti oleh anak-anaknya secara hierarkis
        $menus = MenuSistem::orderByRaw('IFNULL(parent_id, id_menu), parent_id IS NOT NULL, urutan')->get();
        $parentMenus = MenuSistem::whereNull('parent_id')->orderBy('urutan')->get();
        $jabatan = jabatan::orderBy('nama_jabatan')->get();

        return view('menu_sistem', compact('menus', 'parentMenus', 'jabatan'));
    }

    /**
     * Tambah menu baru
     */
    public function tambah(Request $request)
    {
        $this->authorizeAccess();

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi'         => 'Tambah Menu Sistem',
                'fitur'        => 'menu_sistem',
            ]);

            $urutan = MenuSistem::where('parent_id', $request->parent_id ?: null)->max('urutan') + 1;

            MenuSistem::create([
                'nama_menu'  => $request->nama_menu,
                'route_name' => $request->route_name ?: '#',
                'icon'       => $request->icon ?: 'typcn typcn-document',
                'parent_id'  => $request->parent_id ?: null,
                'urutan'     => $urutan,
                'is_active'  => 1,
            ]);

            DB::commit();
            return back()->with('success', 'Menu berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan menu: ' . $e->getMessage());
        }
    }

    /**
     * Get data menu by id (untuk modal ubah, via AJAX)
     */
    public function getUbah($id_menu)
    {
        $this->authorizeAccess();
        $menu = MenuSistem::findOrFail($id_menu);
        return response()->json($menu);
    }

    /**
     * Ubah data menu
     */
    public function ubah(Request $request)
    {
        $this->authorizeAccess();

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi'         => 'Ubah Menu Sistem',
                'fitur'        => 'menu_sistem',
            ]);

            $menu = MenuSistem::findOrFail($request->id_menu);
            $menu->nama_menu  = $request->nama_menu;
            $menu->route_name = $request->route_name ?: '#';
            $menu->icon       = $request->icon ?: $menu->icon;
            $menu->parent_id  = $request->parent_id ?: null;
            $menu->is_active  = $request->is_active ?? $menu->is_active;
            if ($request->has('urutan')) {
                $menu->urutan = $request->urutan;
            }
            $menu->save();

            DB::commit();
            return back()->with('success', 'Menu berhasil diubah.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal mengubah menu: ' . $e->getMessage());
        }
    }

    /**
     * Hapus menu
     */
    public function hapus($id_menu)
    {
        $this->authorizeAccess();

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi'         => 'Hapus Menu Sistem',
                'fitur'        => 'menu_sistem',
            ]);

            // Hapus referensi di pivot jabatan_menu terlebih dahulu
            DB::table('jabatan_menu')->where('menu_id_menu', $id_menu)->delete();

            // Set null parent_id untuk sub-menu yang merujuk ke menu ini
            DB::table('menu_sistem')->where('parent_id', $id_menu)->update(['parent_id' => null]);

            MenuSistem::findOrFail($id_menu)->delete();

            DB::commit();
            return back()->with('success', 'Menu berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus menu: ' . $e->getMessage());
        }
    }

    /**
     * Toggle aktif / nonaktif menu
     */
    public function toggleAktif($id_menu)
    {
        $this->authorizeAccess();

        $menu            = MenuSistem::findOrFail($id_menu);
        $menu->is_active = $menu->is_active ? 0 : 1;
        $menu->save();

        $status = $menu->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Menu \"{$menu->nama_menu}\" berhasil {$status}.");
    }

    /**
     * GET: ambil daftar menu yang sudah di-assign ke jabatan (AJAX)
     */
    public function getMenuJabatan($id_jabatan)
    {
        $this->authorizeAccess();

        $hasConfig = JabatanMenu::where('jabatan_id_jabatan', $id_jabatan)->exists();

        if ($hasConfig) {
            $assigned = JabatanMenu::where('jabatan_id_jabatan', $id_jabatan)
                                   ->pluck('menu_id_menu')
                                   ->map(function ($val) { return (int) $val; })
                                   ->toArray();
        } else {
            // Default: seluruh modul KECUALI menu admin
            $adminRoutes = ['admin', 'log', 'menu_sistem.index'];
            $adminIds = MenuSistem::whereIn('route_name', $adminRoutes)
                                  ->orWhere('nama_menu', 'Admin')
                                  ->pluck('id_menu')
                                  ->toArray();

            $assigned = MenuSistem::where('is_active', 1)
                                  ->whereNotIn('id_menu', $adminIds)
                                  ->where(function ($q) use ($adminIds) {
                                      $q->whereNull('parent_id')
                                        ->orWhereNotIn('parent_id', $adminIds);
                                  })
                                  ->pluck('id_menu')
                                  ->map(function ($val) { return (int) $val; })
                                  ->toArray();
        }

        return response()->json($assigned);
    }

    /**
     * POST: simpan hak akses menu untuk jabatan tertentu
     */
    public function simpanHakAkses(Request $request)
    {
        $this->authorizeAccess();

        DB::beginTransaction();
        try {
            \App\Modules\Log\Models\log::create([
                'user_id_user' => Auth::user()->id,
                'aksi'         => 'Ubah Hak Akses Menu Jabatan id=' . $request->jabatan_id,
                'fitur'        => 'menu_sistem',
            ]);

            $jabatanId   = $request->jabatan_id;
            $menuChecked = $request->menu_ids ?? [];

            // Pastikan integer
            $menuChecked = array_map('intval', $menuChecked);

            // Jika ada child yang dicentang, sertakan juga parent_id-nya agar dropdown bisa terbuka
            if (!empty($menuChecked)) {
                $parentIds = MenuSistem::whereIn('id_menu', $menuChecked)
                    ->whereNotNull('parent_id')
                    ->pluck('parent_id')
                    ->map(function ($val) { return (int) $val; })
                    ->unique()
                    ->toArray();

                $menuChecked = array_unique(array_merge($menuChecked, $parentIds));
            }

            // Hapus semua hak akses lama untuk jabatan ini
            JabatanMenu::where('jabatan_id_jabatan', $jabatanId)->delete();

            // Insert hak akses baru
            $insertRows = [];
            foreach ($menuChecked as $menuId) {
                $insertRows[] = [
                    'jabatan_id_jabatan' => $jabatanId,
                    'menu_id_menu'       => $menuId,
                ];
            }

            if (!empty($insertRows)) {
                JabatanMenu::insert($insertRows);
            }

            DB::commit();
            return back()->with('success', 'Hak akses menu berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan hak akses: ' . $e->getMessage());
        }
    }
}
