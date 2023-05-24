<div class="row">
    <div class="col-md-4">
        <label for="">Total Compra:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">$</span>
            </div>
            <input type="number" disabled class="form-control" wire:model="total">
        </div>
        @error('total')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4">
        <label for="">Objetos Comprados:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-calculator"></i></span>
            </div>
            <input type="number" disabled class="form-control" value="{{ $this->items }}">
        </div>
    </div>

    <div class="col-md-4">
        <label for="">Estado de compra</label>
        <select class="form-control" wire:model="estado">
            <option value="COMPLETADO" selected>Pagado</option>
            <option value="PENDIENTE">Pendiente</option>
        </select>
        @error('estado')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4 mt-2">
        <label for="">Cantidad Pago:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-money-bill-wave"></i></span>
            </div>
            <input type="number" class="form-control" wire:model="cantidad">
        </div>
        @error('cantidad')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4 mt-2">
        <label for="">Cantidad de cambio:</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-money-bill-alt"></i></span>
            </div>
            <input type="number" class="form-control" wire:model="cambio" readonly>
        </div>
        @error('cambio')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    @if ($estado == 'PENDIENTE')
        <div class="col-md-4 mt-2">
            <label for="">Existe deuda:</label>
            <select class="form-control" wire:model="deuda_id">
                <option value="-1" selected>No existe</option>
                @foreach ($deudas as $deuda)
                    <option value="{{ $deuda->id }}">{{ $deuda->nombre }} - {{ $deuda->apellido }}</option>
                @endforeach
            </select>
            @error('deuda_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mt-1 col-md-12">
            <h5>Detalles de deuda</h5>

            <div class="row">
                <div class="col-md-6">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control" placeholder="Nombre/s" wire:model.lazy="nombreDeudor">
                    @error('nombreDeudor')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="">Apellidos</label>
                    <input type="text" class="form-control" placeholder="Apellidos" wire:model.lazy="apellidoDeudor">
                    @error('apellidoDeudor')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="">Sobrenombre</label>
                    <input type="text" class="form-control" placeholder="Sobrenombre / Apodo"
                        wire:model.lazy="sobrenombreDeudor">
                    @error('sobrenombreDeudor')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="">Telefono</label>
                    <input type="text" class="form-control" placeholder="Número de teléfono"
                        wire:model.lazy="telefonoDeudor">
                    @error('telefonoDeudor')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="">Notas</label>
                    <textarea class="form-control" id="" rows="2" placeholder="Notas sobre la deuda"
                        wire:model.lazy="notasDeudor"></textarea>
                </div>
            </div>
        </div>
    @endif

</div>
