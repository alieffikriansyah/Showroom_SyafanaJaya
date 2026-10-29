<?php

use Illuminate\Support\Facades\Route;

// ── Menu Sistem ──────────────────────────────────────────────
Route::get('menu-sistem',                   'MenuSistemController@index')          ->name('menu_sistem.index');
Route::post('menu-sistem/tambah',           'MenuSistemController@tambah')         ->name('menu_sistem.tambah');
Route::get('menu-sistem/get-ubah/{id}',     'MenuSistemController@getUbah')        ->name('menu_sistem.getubah');
Route::post('menu-sistem/ubah',             'MenuSistemController@ubah')           ->name('menu_sistem.ubah');
Route::get('menu-sistem/hapus/{id}',        'MenuSistemController@hapus')          ->name('menu_sistem.hapus');
Route::get('menu-sistem/toggle/{id}',       'MenuSistemController@toggleAktif')    ->name('menu_sistem.toggle');

// ── Hak Akses per Jabatan ─────────────────────────────────────
Route::get('menu-sistem/jabatan/{id}',      'MenuSistemController@getMenuJabatan') ->name('menu_sistem.get_jabatan');
Route::post('menu-sistem/hak-akses',        'MenuSistemController@simpanHakAkses') ->name('menu_sistem.hak_akses');

