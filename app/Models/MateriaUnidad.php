<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaUnidad extends Model
{
    use HasFactory;

    protected $table = 'materia_unidades';

    protected $fillable = ['materia_id', 'titulo', 'descripcion', 'orden'];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function recursos()
    {
        return $this->hasMany(MateriaRecurso::class, 'unidad_id')->orderBy('nombre_original');
    }
}
