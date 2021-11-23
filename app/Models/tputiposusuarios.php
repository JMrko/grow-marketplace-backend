<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tputiposusuarios extends Model
{
    protected $table = 'tputiposusuarios';
    protected $primaryKey = 'tpuid';
    
    protected $fillable = [
        'tpuid',
        'empid',
        'tpunombre',
        'tpuprivilegio',
    ];

    public function usuusuarios()
    {
        return $this->hasMany('App\Models\usuusuarios');
    }

    public function pempermisos()
    {
        return $this->belongsToMany('App\Models\pempermisos');
    }
    
    public function empempresas()
    {
        return $this->belongsTo('App\Models\empempresas');
    }
}
