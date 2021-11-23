<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class perpersonas extends Model
{
    protected $table = 'perpersonas';
    protected $primaryKey = 'perid';
    
    protected $fillable = [
        'perid',
        'pernombrecompleto',
        'pernombre',
        'perapellpaterno',
        'perapellmaterno',
    ];

    public function usuusuarios()
    {
        return $this->hasMany('App\Models\usuusuarios');
    }
}
