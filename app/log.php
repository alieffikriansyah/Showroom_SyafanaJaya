<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class log extends Model
{
    protected $table = "log";
    protected $primaryKey = 'id_log';
    protected $guarded = [];
    public $timestamps = true;
  
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id_user', 'id');
    }

    public function getWaktuAttribute()
    {
        return $this->created_at;
    }
}
