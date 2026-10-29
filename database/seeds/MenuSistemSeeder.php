<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSistemSeeder extends Seeder
{
    /**
     * Isi tabel menu_sistem dengan semua menu yang sudah ada di aplikasi.
     * Superadmin tinggal assign ke jabatan via halaman Menu Sistem.
     */
    public function run()
    {
        DB::table('menu_sistem')->truncate();

        $menus = [
            // ── Struktur ──────────────────────────────────────────
            ['nama_menu' => 'Daftar Karyawan',   'route_name' => 'karyawan',              'icon' => 'typcn typcn-group',            'parent_id' => null, 'urutan' => 1,  'is_active' => 1],
            ['nama_menu' => 'Proyek',             'route_name' => 'proyek',                'icon' => 'typcn typcn-briefcase',        'parent_id' => null, 'urutan' => 2,  'is_active' => 1],
            ['nama_menu' => 'Unit',               'route_name' => 'unit',                  'icon' => 'typcn typcn-th-small',         'parent_id' => null, 'urutan' => 3,  'is_active' => 1],
            ['nama_menu' => 'Jabatan',            'route_name' => 'jabatan',               'icon' => 'typcn typcn-tags',             'parent_id' => null, 'urutan' => 4,  'is_active' => 1],

            // ── Presensi ──────────────────────────────────────────
            ['nama_menu' => 'Rekap Presensi',     'route_name' => 'rekap_presensi',        'icon' => 'typcn typcn-calendar-outline', 'parent_id' => null, 'urutan' => 5,  'is_active' => 1],

            // ── Wawancara ─────────────────────────────────────────
            ['nama_menu' => 'Wawancara Penilaian','route_name' => 'wwc_penilaian.index',   'icon' => 'typcn typcn-messages',         'parent_id' => null, 'urutan' => 6,  'is_active' => 1],

            // ── CBT ───────────────────────────────────────────────
            ['nama_menu' => 'Pengerjaan Ujian',   'route_name' => 'cbt_pengerjaan.index',  'icon' => 'typcn typcn-document-text',    'parent_id' => null, 'urutan' => 7,  'is_active' => 1],
            ['nama_menu' => 'Bank Soal',          'route_name' => 'cbt_bank_soal.index',   'icon' => 'typcn typcn-book',             'parent_id' => null, 'urutan' => 8,  'is_active' => 1],
            ['nama_menu' => 'Master Ujian',       'route_name' => 'cbt_ujian.index',       'icon' => 'typcn typcn-clipboard',        'parent_id' => null, 'urutan' => 9,  'is_active' => 1],

            // ── Hasil ─────────────────────────────────────────────
            ['nama_menu' => 'Hasil Keseluruhan',  'route_name' => 'hasil.keseluruhan',     'icon' => 'typcn typcn-chart-pie',        'parent_id' => null, 'urutan' => 10, 'is_active' => 1],
            ['nama_menu' => 'Hasil Presensi',     'route_name' => 'hasil.presensi',        'icon' => 'typcn typcn-calendar-outline', 'parent_id' => null, 'urutan' => 11, 'is_active' => 1],
            ['nama_menu' => 'Hasil Wawancara',    'route_name' => 'hasil.wawancara',       'icon' => 'typcn typcn-messages',         'parent_id' => null, 'urutan' => 12, 'is_active' => 1],
            ['nama_menu' => 'Hasil CBT',          'route_name' => 'hasil.cbt',             'icon' => 'typcn typcn-document-text',    'parent_id' => null, 'urutan' => 13, 'is_active' => 1],
        ];

        DB::table('menu_sistem')->insert($menus);

        $this->command->info('✅ MenuSistemSeeder: ' . count($menus) . ' menu berhasil dimasukkan.');
    }
}
