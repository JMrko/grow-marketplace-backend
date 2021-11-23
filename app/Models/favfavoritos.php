<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class favfavoritos extends Model
{
    protected $table = 'favfavoritos';
    protected $primaryKey = 'favid';
    
    protected $fillable = [
        'favid',
        'usuid',
        'favnombre',
        'favurl',
        'favorden'
    ];

    public function usuusuarios()
    {
        return $this->belongsTo('App\Models\usuusuarios');
    }
}
