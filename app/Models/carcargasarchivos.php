<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carcargasarchivos extends Model
{
    protected $table = 'carcargasarchivos';
    protected $primaryKey = 'carid';
    
    protected $fillable = [
        'carid',
        'usuid',
        'tcaid',
        'fecid',
        'empid',
        'carnombre',
        'carextension',
        'carurl',
        'carexito'
    ];

    public function usuusuarios()
    {
        return $this->belongsTo('App\Models\usuusuarios');
    }

    public function tcatiposcargasarchivos()
    {
        return $this->belongsTo('App\Models\tcatiposcargasarchivos');
    }

    public function fecfechas()
    {
        return $this->belongsTo('App\Models\fecfechas');
    }

    public function empempresas()
    {
        return $this->belongsTo('App\Models\empempresas');
    }
}
