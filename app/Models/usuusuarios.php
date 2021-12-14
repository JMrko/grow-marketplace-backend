<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

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
        'usutoken',
        'usucorreo'
    ];

    // protected $hidden = [
    //     'usucontrasenia'
    // ];

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

    public function audauditorias()
    {
        return $this->hasMany('App\Models\audauditorias');
    }

}
