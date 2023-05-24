<?php

namespace App\Http\Livewire\Ventas;

use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class CancelarVenta extends Component
{
    Use WithPagination;

    protected $listeners = ['cancelar-venta' => 'cancelarVenta', 'activar-venta' => 'activarVenta', 'pendiente-venta' => 'ventaPendiente'];

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $fechaIni = Carbon::now()->format('Y-m-d') . ' 00:00:00';
        $fechaFin = Carbon::now()->format('Y-m-d') . ' 23:59:59';

        $ventas = Venta::orderBy('created_at', 'desc')
                    ->wherebetween('created_at', [$fechaIni, $fechaFin])
                    ->paginate(20);

        return view('livewire.ventas.cancelar-venta', \compact('ventas'));
    }

    public function cancelarVenta(Venta $venta)
    {
        if ($venta->estatus == 'CANCELADO') {
            $this->emit('mostrar-alerta', 'La venta ya se encuentra cancelada');
            return;
        }

        DB::beginTransaction();

        try {
            // Cancelar venta
            $venta->update([
                'estatus' => 'CANCELADO',
            ]);

            // Actualizar inventario
            $venta->productos->each(function ($producto) {
                $producto->update([
                    'stock' => $producto->stock + $producto->pivot->cantidad,
                ]);
            });

            $this->emit('mostrar-alerta', 'La venta ha sido cancelada');
            
            DB::commit();
            //$this->emit('mostrar-alerta', 'Productos actualizados');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('mostrar-alerta', $e->getMessage());
        }
    }

    public function activarVenta(Venta $venta)
    {
        if ($venta->estatus == 'COMPLETADO') {
            $this->emit('mostrar-alerta', 'La venta ya se encuentra activa');
            return;
        }

        if ($venta->deudor_id != '') {
            $this->emit('mostrar-alerta', 'La venta no se puede ser actualizada');
            return;
        }

        DB::beginTransaction();

        try {
            // Activar venta
            $venta->update([
                'estatus' => 'COMPLETADO',
            ]);

            // Actualizar inventario
            $venta->productos->each(function ($producto) {
                $producto->update([
                    'stock' => $producto->stock - $producto->pivot->cantidad,
                ]);
            });

            $this->emit('mostrar-alerta', 'La venta ha sido activada');
            
            DB::commit();
            //$this->emit('mostrar-alerta', 'Productos actualizados');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('mostrar-alerta', $e->getMessage());
        }
    }

    public function ventaPendiente(Venta $venta) {
        if(!$venta->deudor_id != '') {
            $this->emit('mostrar-alerta', 'La venta no se puede marcar como pendiente');
            return;
        }

        if ($venta->estatus == 'PENDIENTE') {
            $this->emit('mostrar-alerta', 'La venta no se puede marcar como pendiente');
            return;
        }

        DB::beginTransaction();

        try {
            // Activar venta
            $venta->update([
                'estatus' => 'PENDIENTE',
            ]);

            // Actualizar inventario
            $venta->productos->each(function ($producto) {
                $producto->update([
                    'stock' => $producto->stock - $producto->pivot->cantidad,
                ]);
            });

            $this->emit('mostrar-alerta', 'La venta ha sido marcada como pendiente');
            
            DB::commit();
            //$this->emit('mostrar-alerta', 'Productos actualizados');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('mostrar-alerta', $e->getMessage());
        }
    }
}
