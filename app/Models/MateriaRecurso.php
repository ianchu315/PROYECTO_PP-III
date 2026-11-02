<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaRecurso extends Model
{
    use HasFactory;

    protected $table = 'materia_recursos';

    protected $fillable = ['unidad_id', 'nombre_original', 'ruta', 'tipo_mime', 'tamano_bytes'];

    public function unidad()
    {
        return $this->belongsTo(MateriaUnidad::class, 'unidad_id');
    }
}
