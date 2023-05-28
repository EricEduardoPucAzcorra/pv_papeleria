<!-- Modal -->
<div class="modal fade" wire:ignore.self id="modalDetalles" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff5830; color: white">
                <h5 class="modal-title" id="exampleModalLabel">Detalles de deuda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    wire:click.prevent="resetUI">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="col-12 text-center mt-2" wire:loading>
                    <div class="spinner-border text-primary"  role="status">
                        <span class="sr-only">Cargando...</span>
                    </div>
                </div>

                @if ($venta != [])
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-nowrap table-striped">
                                <thead>
                                    <tr>
                                        <th >ID</th>
                                        <th >Producto</th>
                                        <th >Cantidad</th>
                                        <th >Precio</th>
                                        <th >Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($venta->productos as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nombre }}</td>
                                            <td>{{ $item->pivot->cantidad }}</td>
                                            <td>${{ number_format($item->precio, 2) }}</td>
                                            <td>${{ number_format($item->pivot->cantidad * $item->precio, 2) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4"></td>
                                        <td>
                                            <strong>Total: ${{ number_format($venta->total, 2) }}</strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn"  style="background-color: #ff5830; color: white" data-dismiss="modal"
                    wire:click.prevent="resetUI">Cerrar</button>
                {{-- <button type="button" class="btn btn-danger">Cancelar Venta</button> --}}
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        window.livewire.on('modal', Msg => {
            $('#modalDetalles').modal(Msg);
        });

        //Confimar pago
        function pagarDeuda(deudaId) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas confirmar el pago de la deuda?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, confirmar pago!'
            }).then((result) => {
                if (result.value) {
                    //Enviar datos al componente
                    window.livewire.emit('pagarDeuda', deudaId);
                }
            })
        }
    </script>
@endpush
