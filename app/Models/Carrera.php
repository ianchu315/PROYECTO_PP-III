<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Noticia;
use App\Models\Materia;
use App\Models\Sede;
use App\Models\Usuario;
use App\Models\Oferta;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'descripcion',
    ];

    public function noticias()
    {
        return $this->hasMany(Noticia::class, 'carrera_id');
    }

    public function materias()
    {
        return $this->hasMany(Materia::class, 'carrera_id');
    }

    public function sedes()
    {
        return $this->belongsToMany(Sede::class, 'carrerasedes')
            ->withTimestamps()
            ->using(Carrerasede::class);
    }

    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }

    public function preceptores()
    {
        return $this->belongsToMany(Usuario::class, 'preceptor_carrera', 'carrera_id', 'usuario_id')
            ->withTimestamps();
    }

    public function usuariosHabilitados()
    {
        return $this->belongsToMany(Usuario::class, 'usuario_carrera', 'carrera_id', 'usuario_id')
            ->withTimestamps();
    }

    public function ofertas()
    {
        return $this->hasMany(Oferta::class);
    }
}
