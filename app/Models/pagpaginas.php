<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pagpaginas extends Model
{
    protected $table = 'pagpaginas';
    protected $primaryKey = 'pagid';
    
    protected $fillable = [
        'pagid',
        'tpmid',
        'pagnombre',
        'paglink'
    ];

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }

    public function tpmtiposmonedas()
    {
        return $this->belongsTo('App\Models\tpmtiposmonedas');
    }

}
