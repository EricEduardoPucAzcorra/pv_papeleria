<!-- Modal -->
<div class="modal fade" id="modalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de venta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Detalles de venta -->
                @if ($detalleVenta)
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($detalleVenta->productos as $producto)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ $producto->pivot->cantidad }}</td>
                                    <td>${{ number_format($producto->precio, 2) }}</td>
                                    <td>${{ number_format($producto->precio * $producto->pivot->cantidad, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay registros</td>
                                </tr>
                            @endforelse

                            @if ($venta)
                                <tr>
                                    <td colspan="4" class="text-right"><strong>Total</strong></td>
                                    <td>
                                        <strong>${{ number_format($venta->total, 2) }}</strong>
                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                @endif
                <!-- / Detalles de venta -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        Livewire.on('modal-detalles', Msg => {
            $('#modalDetalles').modal(Msg);
        })
    </script>
@endpush
