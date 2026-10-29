<?php

namespace App\Modules\MenuSistem\Models;

use Illuminate\Database\Eloquent\Model;

class JabatanMenu extends Model
{
    protected $table      = 'jabatan_menu';
    protected $primaryKey = 'id';
    public    $timestamps = false;

    protected $fillable = [
        'jabatan_id_jabatan',
        'menu_id_menu',
    ];
}

