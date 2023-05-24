<div class="card">
    <div class="card-header">
        <h3 class="card-title">Todas las ventas</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body p-0">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 10px">#</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Items</th>
                    <th>Pago</th>
                    <th>Cambio</th>
                    <th>Total</th>
                    <th style="width: 40px">Estatus</th>
                    <th style="width: 80px"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $venta)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->created_at)->translatedFormat('d-M-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('h:i A') }}</td>
                        <td>
                            {{ $venta->items }}
                        </td>
                        <td>${{ number_format($venta->pago, 2) }}</td>
                        <td>${{ number_format($venta->cambio, 2) }}</td>
                        <td>${{ number_format($venta->total, 2) }}</td>
                        <td><span class="badge {{ $venta->estatus != 'COMPLETADO' ? 'bg-danger' : 'bg-success' }}">
                                {{ $venta->estatus }}
                            </span></td>
                        <td class="d-flex justify-content-between">
                            @if ($venta->estatus == 'CANCELADO')
                                <button class="btn btn-sm btn-success" onclick="activarVenta('{{ $venta->id }}')">
                                    <i class="fas fa-money-bill"></i>
                                </button>
                                @if ($venta->deudor_id)
                                    <button class="btn btn-sm btn-warning ml-1"
                                        onclick="pendienteVenta('{{ $venta->id }}')">
                                        <i class="fas fa-handshake-slash"></i>
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-sm btn-danger" onclick="cancelarVenta('{{ $venta->id }}')">
                                    <i class="fas fa-times"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No hay registros / Solo puedes cancelar las ventas del
                            dia</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer">
        {{ $ventas->links() }}
    </div>
    <!-- /.card-body -->

    @push('js')
        <script>
            function cancelarVenta(id) {

                swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡La venta sera cancelada!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, cancelar la venta!'
                }).then((result) => {
                    if (result.value) {
                        livewire.emit('cancelar-venta', id);
                    }
                })
            }

            function activarVenta(id) {

                swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡La venta sera activada!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, activar la venta!'
                }).then((result) => {
                    if (result.value) {
                        livewire.emit('activar-venta', id);
                    }
                })
            }

            function pendienteVenta(id) {

                swal.fire({
                    title: '¿Estas seguro?',
                    text: "¡La venta sera marcada como pendiente!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, marcar como pendiente!'
                }).then((result) => {
                    if (result.value) {
                        livewire.emit('pendiente-venta', id);
                    }
                })
            }
        </script>
    @endpush

</div>
