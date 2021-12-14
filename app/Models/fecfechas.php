<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class fecfechas extends Model
{
    protected $table = 'fecfechas';
    protected $primaryKey = 'fecid';
    
    protected $fillable = [
        'fecid',
        'fecfecha',
        'fecmesabreviacion',
        'fecdianumero',
        'fecmesnumero',
        'fecanionumero',
        'fecdiatexto',
        'fecmestexto',
        'fecaniotexto',
        'fecmesabierto'
    ];

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }

    public function audauditorias()
    {
        return $this->hasMany('App\Models\audauditorias');
    }
    
    public function carcargasarchivos()
    {
        return $this->hasMany('App\Models\carcargasarchivos');
    }

    public function prppreciosproductos()
    {
        return $this->hasMany('App\Models\prppreciosproductos');
    }
}