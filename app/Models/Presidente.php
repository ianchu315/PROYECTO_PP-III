<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrera;
use App\Models\Materia;

class Presidente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_id', 'apellido_id', 'materia', 'horario'];

    public function nombre()
    {
        return $this->belongsTo(Profesor::class, 'nombre_id');
    }
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function apellido()
    {
        return $this->belongsTo(Profesor::class, 'apellido_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

}