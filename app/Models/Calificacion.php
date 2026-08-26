<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    protected $table = 'calificaciones';

    protected $fillable = [
        'usuario_id',
        'materia_id',
        'mesa_id',
        'nota',
        'aprobado',
        'fecha',
        'cuatrimestre',
        'numero_nota',
        'tipo',
    ];

    protected $casts = [
        'aprobado' => 'boolean',
        'fecha' => 'date',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function mesa()
    {
        return $this->belongsTo(Mesa::class);
    }
}
