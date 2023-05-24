<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'sku',
        'precio',
        'categoria_id',
        'costo',
        'stock',
        'minimo_stock',
        'imagen',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function ventas()
    {
        return $this->belongsToMany(Venta::class)
            ->withPivot('cantidad')
            ->withTimestamps();
    }


    //accesor para imagenes
    public function logo(): Attribute
    {
        return new Attribute(
            get: function () {
                //Validar si existe
                if ($this->imagen) {
                    //Regresar la ruta relativa
                    return Storage::url($this->imagen);
                } else {
                    //regresar una imagen por defecto
                    return asset('img.jpg');
                }
            },
        );
    }

    //Cantidad de veces que se ha vendido un producto

    public function vecesVendidos()
    {
        $veces = 0;

        $this->ventas->each(function ($venta) use (&$veces) {
            $veces += $venta->pivot->cantidad;
        });

        return $veces;
    }
}
