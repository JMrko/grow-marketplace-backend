<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pempermisos extends Model
{
    protected $table = 'pempermisos';
    protected $primaryKey = 'pemid';
    
    protected $fillable = [
        'pemid',
        'tpeid',
        'pemnombre',
        'pemdescripcion',
        'pemslug',
        'pemruta'
    ];

    public function tpetipospermisos()
    {
        return $this->belongsTo('App\Models\tpetipospermisos');
    }

    public function tputiposusuarios()
    {
        return $this->belongsToMany('App\Models\tputiposusuarios');
    }
}
