<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deudor>
 */
class DeudorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'nombre' => $this->faker->word,
            'apellido' => $this->faker->name,
            'telefono' => $this->faker->phoneNumber,
            'sobrenombre' => $this->faker->word,
            'notas' => $this->faker->text,
        ];
    }
}
