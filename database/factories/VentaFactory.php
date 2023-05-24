<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Venta>
 */
class VentaFactory extends Factory
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
            'total' => $this->faker->numberBetween('10', '100'),
            'items' => $this->faker->numberBetween('1', '100'),
            'estatus' => 'COMPLETADO',
            'pago' => $this->faker->numberBetween('10', '100'),
            'cambio' => $this->faker->numberBetween('10', '100'),
            'user_id' => '1',

        ];
    }
}
