<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiencia extends Model
{

    protected $table = 'experiencias_laborales';


    use HasFactory;


    use HasFactory;

    use HasFactory;


    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'usuario_id',
        'puesto',
        'empresa',
        'horario',
        'año_inicio',
        'año_fin',
        'descripcion',

    ];
}
   


