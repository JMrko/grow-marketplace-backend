<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tcatiposcargasarchivos extends Model
{
    protected $table = 'tcatiposcargasarchivos';
    protected $primaryKey = 'tcaid';
    
    protected $fillable = [
        'tcaid',
        'tcanombre'
    ];

    public function carcargasarchivos()
    {
        return $this->hasMany('App\Models\carcargasarchivos');
    }
}
