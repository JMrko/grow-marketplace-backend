<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tpatiposauditorias extends Model
{
    protected $table = 'tpatiposauditorias';
    protected $primaryKey = 'tpaid';
    
    protected $fillable = [
        'tpaid',
        'tpanombre'
    ];

    public function audauditorias()
    {
        return $this->hasMany('App\Models\audauditorias');
    }
}
