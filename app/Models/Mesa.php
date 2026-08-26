<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrera;
use App\Models\Horario;
use App\Models\Profesor;
use App\Models\Materia;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';

    protected $fillable = ['materia_id', 'carrera_id', 'anio_id', 'profesor_id', 'vocal_id', 'fecha', 'horario', 'comision', 'salon_id','inscriptos', 'resolucion_id'];

    public $timestamps = false;
    
    public function profesor()
    {
        return $this->belongsTo(Profesor::class, 'profesor_id');
    }
    
    public function salon()
    {
        return $this->belongsTo(Salon::class, 'salon_id');
    }

    public function vocal()
    {
        return $this->belongsTo(Profesor::class, 'vocal_id');
    }

    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function resolucion()
    {
        return $this->belongsTo(Resolucion::class);
    }

    public function inscripciones()
    {
        return $this->hasMany(MesaInscripcion::class);
    }

}
