<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correlativa extends Model
{
    use HasFactory;

    protected $fillable = ['materia_id', 'correlativa_id'];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function correlativa()
    {
        return $this->belongsTo(Materia::class, 'correlativa_id');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function anio()
    {
        return $this->belongsTo(Anio::class, 'anio_id');
    }
}   
