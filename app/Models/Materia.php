<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Carrera;
use App\Models\Horario;
use App\Models\Anio;
use App\Models\Categoria;
use App\Models\Resolucion;


//llama a las tablas, funciones y modelos de categoria, carrera, anio, programa
//profesor y horario para utilizarlo en el algoritmo de las mesas 
class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'materia',
        'profesor_usuario_id',
        'vocal_usuario_id',
    ];


    public function categoria(){
        return $this->belongsTo(categoria::class, 'categoria_id');
    }

    public function deCarrera(){
        return $this->belongsTo(Carrera::class, 'carrera_id');
    }

    public function deAnio(){
        return $this->belongsTo(Anio::class, 'anio_id');
    }

    public function deprograma(){
        return $this->belongsTo(Programa::class, 'programa_id');
    }

    public function deProfesor(){
        return $this->belongsTo(Profesor::class,'profesor_id');
    }

    // Profesor (usuario logueado, guard "usuarios", rol=profesor) a cargo de la materia
    // para el módulo de carga de notas.
    public function profesorUsuario()
    {
        return $this->belongsTo(Usuario::class, 'profesor_usuario_id');
    }

    // Cuenta de profesor que oficia de vocal de mesa para esta materia
    // (independiente de quién sea el titular/profesorUsuario).
    public function vocalUsuario()
    {
        return $this->belongsTo(Usuario::class, 'vocal_usuario_id');
    }

    public function alumnosInscriptos()
    {
        return $this->belongsToMany(Usuario::class, 'inscripcion_materia', 'materia_id', 'usuario_id')
            ->withPivot('fecha_inscripcion')
            ->withTimestamps();
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'materia_id');
    }

    public function unidades()
    {
        return $this->hasMany(MateriaUnidad::class, 'materia_id')->orderBy('orden');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'materia_id');
    }

    public function presidentes(){
        return $this->belongsTo(Presidente::class);
    }

    public function horario()
    {
        return $this->hasOne(Horario::class, 'materia_id');
    }

    
    public function resolucion()
    {
        return $this->belongsTo(\App\Models\Resolucion::class, 'resolucion_id');
    }

    public function mesas(){
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }

    public function correlativas()
    {
        return $this->belongsToMany(Materia::class, 'correlativas', 'materia_id', 'correlativa_id');
    }


}
