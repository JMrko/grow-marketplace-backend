<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empempresas extends Model
{
    protected $table = 'empempresas';
    protected $primaryKey = 'empid';
    
    protected $fillable = [
        'empid',
        'empnombre'
    ];

    public function catcategopdpproductosdatospaginasrias()
    {
        return $this->hasMany('App\Models\pdpproductosdatospaginas');
    }

    public function proproductos()
    {
        return $this->hasMany('App\Models\proproductos');
    }

    public function carcargasarchivos()
    {
        return $this->hasMany('App\Models\carcargasarchivos');
    }

    public function tputiposusuarios()
    {
        return $this->hasMany('App\Models\tputiposusuarios');
    }

    public function audauditorias()
    {
        return $this->hasMany('App\Models\audauditorias');
    }

    public function usuusuarios()
    {
        return $this->hasMany('App\Models\usuusuarios');
    }
}
