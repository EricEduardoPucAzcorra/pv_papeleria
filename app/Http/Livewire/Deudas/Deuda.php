<?php

namespace App\Http\Livewire\Deudas;

use App\Models\Deudor;
use Livewire\Component;
use Livewire\WithPagination;

class Deuda extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search;

    public function render()
    {
        if ($this->search) {
            $deudas = Deudor::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('apellido', 'like', '%' . $this->search . '%')
                ->paginate(10);
        } else {
            $deudas = Deudor::orderBy('nombre', 'asc')->paginate(10);
        }
        

        return view('livewire.deudas.deuda', \compact('deudas'));
    }

    public function calcularTotal(Deudor $deudor)
    {
        $total = 0;

        foreach ($deudor->ventas()->where('estatus', 'PENDIENTE')->get() as $venta) {
            $total += $venta->total;
        }

        return $total;
    }
}
