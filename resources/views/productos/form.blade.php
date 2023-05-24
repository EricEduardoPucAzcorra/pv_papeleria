<div class="row">
    <div class="col-md-6">
        <label>SKU del producto</label>
        <input type="text" class="form-control" placeholder="Ingrese código de barras" wire:model.lazy="sku">
        @error('sku')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="col-md-6">
        <label>Nombre del producto</label>
        <input type="text" class="form-control" placeholder="Ingrese Nombre del producto" wire:model.lazy="nombre">
        @error('nombre')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="col-md-6 mt-2">
        <label>Costo inicial</label>
        <input type="number" class="form-control" placeholder="Ingrese precio de compra" wire:model.lazy="costo">
        @error('costo')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    
    <div class="col-md-6 mt-2">
        <label>Precio Venta</label>
        <input type="number" class="form-control" placeholder="Ingrese precio de venta" wire:model.lazy="precio">
        @error('precio')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4 mt-2">
        <label>Stock</label>
        <input type="number" class="form-control" placeholder="Ingrese Stock" wire:model.lazy="stock">
        @error('stock')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4 mt-2">
        <label>Inv. Min.</label>
        <input type="number" class="form-control" placeholder="Ingrese cantidad minima" wire:model.lazy="inv_min">
        @error('inv_min')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-md-4 mt-2">
        <label>Categoria</label>
        <select class="form-control" wire:model="categoria">
            <option disabled selected value="-1">Seleccione una categoria</option>
            
            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{$categoria->nombre}}</option>
            @endforeach
                
        </select>
        @error('categoria')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="col-12 mt-2">
        <label>Imagen</label>
        <input type="file" class="form-control" wire:model="imagen">
        @error('imagen')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

</div>