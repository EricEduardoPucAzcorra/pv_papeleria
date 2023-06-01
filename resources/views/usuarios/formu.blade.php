<div class="row">
    <div class="col-md-6 mt-2">
        <label>Nombres</label>
        <input type="text" class="form-control" placeholder="Ingrese sus nombres" wire:model.lazy="nombre">
        @error('nombre')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mt-2">
        <label>Apellidos</label>
        <input type="text" class="form-control" placeholder="Ingrese sus apellidos" wire:mode.lazy="apellido">
        @error('apellido')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-6 mt-2">
        <label>Email</label>
        <input type="text" class="form-control" placeholder="Ingrese su correo" wire:mode.lazy="email">
        @error('email')
        <small class="text-danger">{{ $message}}</small>
        @enderror
    </div>

    <div class="col-md-6 mt-2">
        <label>Telefono</label>
        <input type="text" class="form-control" placeholder="Ingrese su telefono" wire:mode.lazy="telefono">
        @error('telefono')
        <small class="text-danger">{{ $message}}</small>
        @enderror
    </div>

    <div class="col-md-6 mt-2">
        <label>Password</label>
        <input type="text" class="form-control" placeholder="Ingrese su contraseña" wire:mode.lazy="password">
        @error('password')
        <small class="text-danger">{{ $message}}</small>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label>Imagen</label>
        <input type="file" class="form-control" wire:model="imagen">
        @error('imagen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label>Estatus</label>
        <input type="file" class="form-control" wire:model="estatus">
        @error('estatus')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
</div>