<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proproductos extends Model
{
    protected $table = 'proproductos';
    protected $primaryKey = 'proid';
    
    protected $fillable = [
        'proid',
        'catid',
        'empid',
        'tpmid',
        'pronombre',
        'proprecio',
        'proimagen',
        'prosku' 
    ];

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }

    public function dtpdatospaginasManytoMany()
    {
        return $this->belongsToMany('App\Models\dtpdatospaginas');
    }

    public function catcategorias()
    {
        return $this->belongsTo('App\Models\catcategorias');
    }

    public function empempresas()
    {
        return $this->belongsTo('App\Models\empempresas');
    }

    public function tpmtiposmonedas()
    {
        return $this->belongsTo('App\Models\tpmtiposmonedas');
    }
}
