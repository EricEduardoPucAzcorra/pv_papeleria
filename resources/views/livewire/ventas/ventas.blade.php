<section class="col-md-8">

    <div class="py-2 position-relative">
        <input id="buscar" type="text" placeholder="Buscar" wire:model="buscar" wire:keydown.enter="$emit('agregar', $('#buscar').val())"
            class="form-control px-2">
        @if ($buscar)
            <div class="position-absolute bg-white px-3 col-12" style="z-index: 10;">
                <ul class="list-group">
                    @foreach ($buscarProducto as $producto)
                        <li class="list-group-item d-flex justify-content-between align-items-center"
                            wire:click="agregarProducto({{ $producto->sku }})" style="cursor: pointer;">
                            {{ $producto->nombre }}
                            <span class="badge badge-primary badge-pill">${{ $producto->precio }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12" style="overflow-y:hidden">
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body table-responsive p-0 rounded"
                    style="overflow-x: hidden; height: 75vh; z-index: 0;">
                    <table class="table table-striped table-head-fixed text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th style="width: 20%">Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($productos as $producto)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $producto->nombre }}</td>
                                    <td>{{ number_format($producto->precio) }}</td>
                                    <td class="d-flex">

                                        <button wire:click.prevent="reducirItem('{{ $producto->sku }}')"
                                            class="btn btn-primary btn-sm">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                        <span class="mx-3">{{ $producto->cantidad }}</span>

                                        <button wire:click.prevent="aumentarItem('{{ $producto->sku }}')"
                                            class="btn btn-dark btn-sm">
                                            <i class="fas fa-plus"></i>
                                        </button>

                                    </td>
                                    <td class="text-right">
                                        <button class="btn btn-danger btn-sm"
                                            wire:click.prevent="eliminarProducto('{{ $producto->sku }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay productos</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

    @push('js')
        <script>
            //Reiniciar campo de busqueda
            livewire.on('agregar', () => {
                $('#buscar').val('');
            });
        </script>
    @endpush

</section>
