<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mamarcas extends Model
{
    protected $table = 'marmarcas';
    protected $primaryKey = 'marid';
    
    protected $fillable = [
        'marid',
        'marnombre'
    ];

    public function dtpdatospaginas()
    {
        return $this->hasMany('App\Models\dtpdatospaginas');
    }
}
