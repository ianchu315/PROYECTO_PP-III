<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Relación alumno <-> materia: qué alumnos está cursando cada materia,
// cargada por el profesor a cargo. Es independiente de las mesas finales.
class InscripcionMateria extends Model
{
    use HasFactory;

    protected $table = 'inscripcion_materia';

    protected $fillable = [
        'usuario_id',
        'materia_id',
        'fecha_inscripcion',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}
