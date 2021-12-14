<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tumtiposunidadesmedidas extends Model
{
    protected $table = 'tumtiposunidadesmedidas';
    protected $primaryKey = 'tumid';
    
    protected $fillable = [
        'tumid',
        'tumnombre',
        'tumsigno'
    ];

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }
}
