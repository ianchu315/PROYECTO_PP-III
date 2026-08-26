<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperienciaLaboral extends Model
{
    use HasFactory;

    protected $table = 'experiencias_laborales';
    protected $fillable = [
        'usuario_id',
        'empresa',
        'puesto',
        'ubicacion',
        'modalidad',
        'horario',   
        'logros',   
        'descripcion',
        'año_inicio',
        'año_fin',
    ];
    

    protected $casts = [
        'logros' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    
}

