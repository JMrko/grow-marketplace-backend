<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pdpproductosdatospaginas extends Model
{
    protected $table = 'pdpproductosdatospaginas';
    protected $primaryKey = 'pdpid';
    
    protected $fillable = [
        'pdpid',
        'proid',
        'dtpid',
        'empid'
    ];

    public function empempresas()
    {
        return $this->belongsTo('App\Models\empempresas');
    }
}
