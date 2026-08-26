<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    use HasFactory;

    /**
     * Define los atributos de la oferta que pueden ser asignados masivamente.
     */
    protected $fillable = [
        'titulo',
        'empresa',
        'descripcion',
        'ubicacion',
        'modalidad_id',
        'horario_id',
        'salario',
        'experiencia_id',
        'carrera_id',
        'año_academico_id',
        'estado_id',
        'foto_empresa',
        'fecha_publicacion',
        'fecha_expiracion',
        'años_experiencia',
        'imagen',
    ];



    /**
     * Relación uno a muchos: obtiene los requisitos asociados a la oferta.
     */
    public function requisitos()
    {
        return $this->hasMany(RequisitoOferta::class, 'oferta_id');
    }


    /**
     * Relación uno a muchos: obtiene los beneficios asociados a la oferta.
     */
    public function beneficios()
    {
        return $this->hasMany(BeneficioOferta::class, 'oferta_id');
    }

    public function palabras()
    {
        return $this->hasMany(PalabraClave::class, 'oferta_id');
    }

    /**
     * Define la relación de pertenencia entre Oferta y Carrera.
     */
    public function carrera()
    {
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    /**
     * Define la relación de pertenencia entre Oferta y AñoAcademico.
     */
    public function añoAcademico()
    {
        return $this->belongsTo(AñoAcademico::class, 'año_academico_id');
    }

    /**
     * Define la relación de pertenencia entre Oferta y Modalidad.
     */
    public function modalidad()
    {
        return $this->belongsTo(Modalidad::class);
    }

    /**
     * Define la relación de pertenencia entre Oferta y Horario.
     */
    public function horario()
    {
        return $this->belongsTo(Time::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }


    /**
     * Define la relación muchos a muchos entre Oferta y HabilidadesBlandas.
     */
    public function habilidadesBlandas()
    {
        return $this->belongsToMany(HabilidadesBlandas::class, 'habilidades_blandas_ofertas', 'oferta_id', 'habilidad_blanda_id');
    }

    /**
     * Define la relación muchos a muchos entre Oferta e IdiomasDisponibles.
     */
    public function idiomasDisponibles()
    {
        return $this->belongsToMany(IdiomasDisponibles::class, 'idiomas_ofertas', 'oferta_id', 'idioma_id');
    }

    /**
     * Relación uno a muchos con PalabraClave.
     * Obtiene las palabras clave asociadas a la oferta.
     */
    public function palabrasClave()
    {
        return $this->hasMany(PalabraClave::class);
    }

    public function preguntas()
    {
        return $this->hasMany(PreguntaOferta::class); // o el modelo que corresponda
    }
    /**
     * Define la relación de pertenencia entre Oferta y Salario.
     */


    /**
     * Define la relación de pertenencia entre Oferta y ExperienciaRequerida.
     */

    public function idiomas()
    {
        return $this->belongsToMany(
            \App\Models\IdiomasDisponibles::class,
            'idiomas_ofertas',
            'oferta_id',
            'idioma_id'
        )->withTimestamps();
    }





    // Relación con las postulaciones realizadas a esta oferta
    public function postulaciones()
    {
        return $this->hasMany(\App\Models\Postulacion::class, 'oferta_id');
    }

    // Usuarios que postularon a esta oferta (muchos a muchos a través de postulaciones)
    public function usuariosQuePostularon()
    {
        return $this->belongsToMany(
            \App\Models\Usuario::class,
            'postulaciones',
            'oferta_id',
            'usuario_id'
        )->withPivot('estado_postulacion', 'fecha_postulacion');
    }

    // Usuarios que guardaron esta oferta
    public function usuariosQueGuardaron()
    {
        return $this->belongsToMany(
            \App\Models\Usuario::class,
            'ofertas_guardadas',
            'oferta_id',
            'usuario_id'
        )->withTimestamps();
    }
}
