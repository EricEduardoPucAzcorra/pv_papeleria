<div class="row justify-content-md-center pt-4">
    <div class="col-md-10">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h5 class="card-title">
                    <i class="fas fa-dollar-sign"></i>
                    <span>Calcular precios</span>
                </h5>
            </div>
            <div class="card-body row">
                <!-- Tipo de operación -->
                <div class="col-md-4">
                    <label for="">Tipo de operación</label>
                    <div>
                        <input name="operacion" type="radio" class="ml-2" value="UNIT" wire:model="operacion">
                        <span>Unitario</span>
                        <input name="operacion" type="radio" class="ml-2" value="MAY" wire:model="operacion">
                        <span>Mayoreo</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="">Tipo de calculo</label>
                    <div>
                        <input name="tipoPrecio" type="radio" class="ml-2" value="COMPRA" wire:model="tipoCalculo">
                        <span>Precio Compra</span>
                        <input name="tipoPrecio" type="radio" class="ml-2" value="PUBLICO" wire:model="tipoCalculo">
                        <span>Precio Publico</span>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="">Impuesto (%)</label>
                    <input type="number" placeholder="Impuesto al precio" class="form-control" wire:model.lazy="impuesto">
                </div>

                <!-- Columna 2 -->
                @if ($tipoCalculo == 'PUBLICO')
                
                <div class="col-md-4">
                        <label for="">Precio Compra</label>
                        <input type="number" placeholder="Precio Compra" class="form-control" wire:model.lazy="precioCompra">
                    </div>
                
                @endif

                @if ($tipoCalculo == 'COMPRA')
                    
                    <div class="col-md-4">
                        <label for="">Precio Venta</label>
                        <input type="number" placeholder="Precio Venta" class="form-control" wire:model.lazy="precioPublico">
                    </div>

                @endif
                
                @if ($operacion == 'UNIT')
                    
                    <div class="col-md-4">
                        <label for="">Contenido Neto</label>
                        <input type="number" placeholder="Contenido del producto" class="form-control" value="1" wire:model.lazy="contenido">
                    </div>
                @endif

            </div>

            <div class="card-footer">
                <div class="">
                    <h3>El precio aproximado es de: <strong>${{number_format($this->precio, 2)}}</strong></h3>
                </div>
            </div>
        </div>
    </div>
</div>
