<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tpetipospermisos extends Model
{
    protected $table = 'tpetipospermisos';
    protected $primaryKey = 'tpeid';
    
    protected $fillable = [
        'tpeid',
        'tpenombre'
    ];

    public function pempermisos()
    {
        return $this->hasMany('App\Models\pempermisos');
    }
}
