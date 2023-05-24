<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Deudor;
use App\Models\Producto;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombre' => 'Danny',
            'email' => 'danny_2003@ovi.com',
            'password' => bcrypt('password'),
        ]);
        
        //User::factory(10)->create();

        //Categoria::factory(10)->create();

        //Crear lista de productos
        //Producto::factory(100)->create();

        //Deudor
        //Deudor::factory(10)->create();

        //Crear ventas
        //$ventas = Venta::factory(100)->create();

        //Asinar ventas con la tabla pivot
        /* foreach ($ventas as $venta) {
            $productos = Producto::inRandomOrder()->take(rand(1, 5))->get()->pluck('id')->toArray();

            $venta->productos()->attach(
                $productos,
                [
                    'cantidad' => rand(1, 5),
                    'precio' => rand(1, 100),
                ]
            );
        } */
        //Fin del foreach
    }
}
