<?php

namespace App\Http\Livewire\Precios;

use Livewire\Component;

class Precio extends Component
{
    public $precioPublico;
    public $precioCompra;
    public $impuesto;
    public $operacion;
    public $tipoCalculo;
    public $contenido;

    public function mount()
    {
        $this->operacion = 'MAY';
        $this->tipoCalculo = 'PUBLICO';
        $this->precioCompra = 10;
        $this->precioPublico = 10;
        $this->impuesto = 16;
        $this->contenido = 0;
    }

    public function render()
    {
        return view('livewire.precios.precio');
    }

    public function getPrecioProperty() 
    {
        $precio = 0;

        if($this->impuesto == '') {
            $this->impuesto = 0;
        }

        if ($this->precioCompra == '') {
            $this->precioCompra = 0;
        }

        if ($this->precioPublico == '') {
            $this->precioPublico = 0;
        }

        if ($this->tipoCalculo == 'PUBLICO') {

           if ($this->operacion == 'MAY') {
               $precio = ($this->precioCompra * $this->impuesto) / 100 ;
               $precio = $this->precioCompra + $precio;
           } else {
                $precio = ($this->precioCompra * $this->impuesto) / 100 ;
                $precio = $this->precioCompra + $precio;
                if ($this->contenido > 0) {
                    $precio = $precio / $this->contenido;
                } else {
                    $precio = 0;
                }
           }
        } else {
            //Precio == Compra
            if ($this->operacion == 'MAY') {
                $precio = $this->precioPublico / (100 + $this->impuesto) * 100;
            } else {
                //tipo de operacion == UNIT
                if ($this->contenido == null) {
                    $this->contenido = 0;
                }
                $precio = $this->precioPublico * $this->contenido;
                $precio = $precio / (100 + $this->impuesto) * 100;
            }

        }

        return $precio;
    }
}
