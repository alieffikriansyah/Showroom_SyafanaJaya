<?php

namespace App\Modules\Jabatan\Models;

use Illuminate\Database\Eloquent\Model;

class jabatan extends Model
{
    protected $table      = 'jabatan';
    protected $primaryKey = 'id_jabatan';
    public    $timestamps = false;

    /**
     * Menu yang diizinkan untuk jabatan ini
     */
    public function menus()
    {
        return $this->belongsToMany(
            \App\Modules\MenuSistem\Models\MenuSistem::class,
            'jabatan_menu',
            'jabatan_id_jabatan',
            'menu_id_menu'
        );
    }
}
