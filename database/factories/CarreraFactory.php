<?php

namespace Database\Factories;

use App\Models\Carrera;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarreraFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carrera::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                 'descripcion' => $this->faker->sentence(3),
                 'anios' => $this->faker->numberBetween(2, 5),
                 'resolucion' => $this->faker->word,
                 'texto' => $this->faker->text(500),
                 'imagen' => 'default.jpg',
                 'nombre_carpeta' => $this->faker->slug,
             ];
    }
}
