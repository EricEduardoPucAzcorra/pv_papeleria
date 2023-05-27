<div class="col-md-4 pt-2">
    <!-- Visor del total a pagar -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Total a pagar</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center">
                        <h3>
                            <span class="text-muted">$</span>
                            <span class="total">{{ number_format($total, 2)}}</span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>

    <!-- Cantidad ingresada y cambio -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Cantidad ingresada (F6)</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input type="number" class="form-control" id="cantidadPago" wire:model="cantidad"
                            wire:keydown.enter="$emit('pagar')" placeholder="0.00">
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6">
                    <h6>Cambio: <strong>{{number_format($this->calcular_cambio, 2)}}</strong></h6>
                </div>
                <div class="col-md-6">
                    <h6>Art: <strong> {{$this->items}} </strong></h6>
                </div>
            </div>
        </div>
    </div>


    <!-- Opciones de compra -->
    <div class="card card-primary card-outline">
        <div class="card-header">
            <h3 class="card-title">Operaciones</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button wire:click.prevent="$emit('agregar', $('#buscar').val())" class="btn btn-primary btn-block">
                        <i class="fas fa-plus"></i>
                        Agregar producto
                    </button>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button class="btn btn btn-block" style="background-color: #ff5830; color: white" wire:click.prevent="$emit('limpiar')">
                        <i class="fas fa-trash"></i>
                        Cancelar Venta (F4)
                    </button>
                </div>
            </div>
            @if ($total > 0)
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button class="btn btn-success btn-block" {{$cantidad >= $total ? '' : 'disabled'}} data-toggle="modal" data-target="#modal-opciones" >
                            <i class="fas fa-money-bill-wave"></i>
                            Pagar (F2)
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('modals.modal-header')
    @include('ventas.form')
    @include('modals.modal-footer')


    @push('js')
        <script>
            const cantidadPago = document.getElementById('cantidadPago');
            //Eventos de presionar botones
            var listener = new window.keypress.Listener();

            //Capturar el boton F2
            listener.simple_combo("f2", function() {
                $('#modal-opciones').modal('show');
            });
            
            //Capturar el boton F2
            listener.simple_combo("f4", function() {
                livewire.emit('limpiar');
            });

            listener.simple_combo("f6", function() {
                cantidadPago.focus();
            });
        </script>
    @endpush

</div>
