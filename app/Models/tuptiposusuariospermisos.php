<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tuptiposusuariospermisos extends Model
{
    protected $table = 'tuptiposusuariospermisos';
    protected $primaryKey = 'tupid';
    
    protected $fillable = [
        'tupid',
        'pemid',
        'tpuid'
    ];

}
