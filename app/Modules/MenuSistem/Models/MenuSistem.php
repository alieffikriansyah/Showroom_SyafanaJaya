<?php

namespace App\Modules\MenuSistem\Models;

use Illuminate\Database\Eloquent\Model;

class MenuSistem extends Model
{
    protected $table      = 'menu_sistem';
    protected $primaryKey = 'id_menu';
    public    $timestamps = false;

    protected $fillable = [
        'nama_menu',
        'route_name',
        'icon',
        'parent_id',
        'urutan',
        'is_active',
    ];

    /**
     * Sub-menu (children)
     */
    public function children()
    {
        return $this->hasMany(MenuSistem::class, 'parent_id', 'id_menu')
                    ->orderBy('urutan');
    }

    /**
     * Parent menu
     */
    public function parent()
    {
        return $this->belongsTo(MenuSistem::class, 'parent_id', 'id_menu');
    }

    /**
     * Jabatan yang memiliki akses ke menu ini
     */
    public function jabatans()
    {
        return $this->belongsToMany(
            \App\Modules\Jabatan\Models\jabatan::class,
            'jabatan_menu',
            'menu_id_menu',
            'jabatan_id_jabatan'
        );
    }
}

