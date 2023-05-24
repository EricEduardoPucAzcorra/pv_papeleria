<?php

namespace App\Http\Livewire\Deudas;

use App\Models\Deudor;
use App\Models\Venta;
use Livewire\Component;

class Detalles extends Component
{
    public $deudor;

    public $venta;

    protected $listeners = ['pagarDeuda'];

    public function mount()
    {
        $this->venta = [];

        $this->deudor = Deudor::find($this->deudor);
    }

    public function render()
    {
        $deudor = $this->deudor;

        $deudas = $deudor->ventas;

        return view('livewire.deudas.detalles', \compact('deudor', 'deudas'));
    }

    public function cargarModal(Venta $venta)
    {
        $this->venta = $venta;

        $this->emit('modal', 'show');
    }

    public function resetUI()
    {
        $this->venta = [];
    }
    
    public function pagarDeuda(Venta $venta)
    {
        $venta->estatus = 'COMPLETADO';

        $venta->save();

        $this->emit('modal', 'hide');
        $this->emit('mostrar-alerta', 'Deuda pagada con éxito');

        $this->deudor = Deudor::find($this->deudor->id);

        $this->resetUI();
    }
    
}
