<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class prppreciosproductos extends Model
{
    protected $table = 'prppreciosproductos';
    protected $primaryKey = 'prpid';
    
    protected $fillable = [
        'prpid',
        'proid',
        'fecid',
        'prpprecio',
        'prodate',
        'procodclientesi',
        'procodmaterial',
        'proexchangevalue2',
        'proexchangevalue3',
        'proexchangevalue4',
        'proexchangevalue5'
    ];

    public function carcargasarchivos()
    {
        return $this->hasMany('App\Models\carcargasarchivos');
    }
    public function proproductos()
    {
        return $this->belongsTo('App\Models\proproductos');
    }
    public function fecfechas()
    {
        return $this->belongsTo('App\Models\fecfechas');
    }
}
