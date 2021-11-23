<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tpmtiposmonedas extends Model
{
    protected $table = 'tpmtiposmonedas';
    protected $primaryKey = 'tpmid';
    
    protected $fillable = [
        'tpmid',
        'tpmnombre',
        'tpmsigno'
    ];

    public function pagpaginas()
    {
        return $this->hasMany('App\Models\pagpaginas');
    }

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }

    public function proproductos()
    {
        return $this->hasMany('App\Models\proproductos');
    }
}
