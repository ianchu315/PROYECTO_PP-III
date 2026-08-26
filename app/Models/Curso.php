<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'nombre',
        'institucion',
        'duracion',
        'fecha',
        'fecha_fin',
        'temas_principales',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
