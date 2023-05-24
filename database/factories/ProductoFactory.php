<?php

namespace Database\Factories;

use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
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
            'sku' => $this->faker->numberBetween('11111111', '99999999'),
            'costo' => $this->faker->numberBetween('10', '100'),
            'precio' => $this->faker->numberBetween('10', '100'),
            'stock' => $this->faker->numberBetween('1', '100'),
            'minimo_stock' => '4',
            'categoria_id' => Categoria::all()->random()->id,
        ];
    }
}
