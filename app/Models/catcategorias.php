<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class catcategorias extends Model
{
    protected $table = 'catcategorias';
    protected $primaryKey = 'catid';
    
    protected $fillable = [
        'catid',
        'catnombre'
    ];

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }

    public function proproductos()
    {
        return $this->hasMany('App\Models\proproductos');
    }
}
