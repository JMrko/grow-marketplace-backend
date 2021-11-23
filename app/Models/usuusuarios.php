<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuusuarios extends Model
{
    protected $table = 'usuusuarios';
    protected $primaryKey = 'usuid';
    
    protected $fillable = [
        'usuid',
        'tpuid',
        'perid',
        'empid',
        'usuusuario',
        'usucontrasenia',
        'usuimagen',
    ];

    public function perpersonas()
    {
        return $this->belongsTo('App\Models\perpersonas');
    }

    public function tputiposusuarios()
    {
        return $this->belongsTo('App\Models\tputiposusuarios');
    }

    public function carcargasarchivos()
    {
        return $this->hasMany('App\Models\carcargasarchivos');
    }
}
