<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class dtpdatospaginas extends Model
{
    protected $table = 'dtpdatospaginas';
    protected $primaryKey = 'dtpid';
    
    protected $fillable = [
        'dtpid',
        'pagid',
        'pagidexcel',
        'proid',
        'fecid',
        'catid',
        'marid',
        'tpmid',
        'tumid',
        'dtpnombre',
        'dtpprecioreal',
        'dtpprecioactual',
        'dtpurl',
        'dtpimagen',
        'dtppagina',
        'dtpdesclarga',
        'dtpsigv',
        'dtpcategoria',
        'dtpsku',
        'dtpskuhomologado',
        'dtpmarca',
        'dtpstock',
        'dtpmecanica',
        'dtpunidadmedida',
        'dtpmercadolibre',
        'dtpenviogratis',
        'dtpmercadoenvio',
        'dtpestado',
        'dtpexposicion',
        'dtpmercadopago',
        'dtprepublicada',
        'dtpventaenpesoschilenos',
        'dtpventaenunid',
        'dtpdiaspublicada',
        'dtpconversion',
        'dtpticketpromedio',
        'dtppromventaxdia',
        'dtpvisitaacumulada',
        'dtpean',
        'dtpcatalogo',
        'dtpventasenpesoschilenosxperiodo',
        'dtpvisitasxperiodo',
        'dtpventasenunidxperiodo',
        'dtpconversionxperiodo',
        'dtpidproducto',
        'dtppromediodeventas',
        'dtppreciopromedio',
        'dtpfulfillment',
        'dtpdescuento',
        'dtptipopublicacion',
        'dtpcondicion',
        'dtppalabraclave'
    ];

    public function proproductos()
    {
        return $this->belongsTo('App\Models\proproductos');
    }

    public function pagpaginas()
    {
        return $this->belongsTo('App\Models\pagpaginas');
    }

    public function catcategorias()
    {
        return $this->belongsTo('App\Models\catcategorias');
    }

    public function fecfechas()
    {
        return $this->belongsTo('App\Models\fecfechas');
    }

    public function mamarcas()
    {
        return $this->belongsTo('App\Models\mamarcas');
    }

    public function pdpproductosdatospaginas()
    {
        return $this->belongsToMany('App\Models\proproductos');
    }

    public function tpmtiposmonedas()
    {
        return $this->belongsTo('App\Models\tpmtiposmonedas');
    }

    public function tumtiposunidadesmedidas()
    {
        return $this->belongsTo('App\Models\tumtiposunidadesmedidas');
    }
}
