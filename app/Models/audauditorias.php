<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class audauditorias extends Model
{
    protected $table = 'audauditorias';
    protected $primaryKey = 'audid';
    
    protected $fillable = [
        'audid',
        'tpaid',
        'fecid',
        'empid',
        'audip',
        'audjsonentrada',
        'audjsonsalida',
        'auddescripcion',
        'audaccion',
        'audruta',
        'audlog',
        'audpk'
    ];

    public function tpatiposauditorias()
    {
        return $this->belongsTo('App\Models\tpatiposauditorias');
    }

    public function empempresas()
    {
        return $this->belongsTo('App\Models\empempresas');
    }

    public function fecfechas()
    {
        return $this->belongsTo('App\Models\fecfechas');
    }
}
