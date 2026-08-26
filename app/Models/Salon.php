<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salon extends Model
{
    use HasFactory;

    protected $table = 'salones';
    protected $fillable = [
        'numero_salon',
        'capacidad',
        'carrera_id',
        'anio_id',
        'comision_id',
        'laboratorio'
    ];

    public function Carrera(){
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }   

    public function anio()
    {
        return $this->belongsTo(Anio::class, 'anio_id');
    }

    public function comision()
    {
        return $this->belongsTo(Comision::class, 'comision_id');
    }

    public function mesas()
    {
        return $this->hasMany(Mesa::class, 'salon_id');
    }


}

