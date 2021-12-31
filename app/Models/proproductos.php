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
        'fecid',
        'tpmid',
        'pronombre',
        'proprecio',
        'proimagen',
        'prosku',
        'procodsalesorganization',
        'prosalesorganization',
        'procodbusiness',
        'probusiness',
        'procodmaterial',
        'procodcategoria',
        'procategoria',
        'procodsector',
        'prosector',
        'procodsegmentacion',
        'prosegmentacion',
        'procodpresentacion',
        'propresentacion',
        'procodmarca',
        'promarca',
        'procodformato',
        'proformato',
        'procodtalla',
        'protalla',
        'procodconteo',
        'proconteo',
        'procodclass9',
        'proclass9',
        'procodclass10',
        'proclass10',
        'propeso',
        'profactorabultos',
        'profactorapaquetes',
        'profactoraunidadminimaindivisible',
        'profactoratoneladas',
        'profactoramilesdeunidades',
        'proattribute7',
        'proattribute8',
        'proattribute9',
        'proattribute10' 
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

    public function prppreciosproductos()
    {
        return $this->hasMany('App\Models\prppreciosproductos');
    }
    
}
