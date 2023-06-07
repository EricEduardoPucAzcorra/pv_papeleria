<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="input-group input-group-sm col-10">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search" wire:model="search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-2">
                        <button class="btn btn-primary btn-sm float-right" type="button" data-toggle="modal" data-target="#modal-opciones">Agregar</button>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="background-color: #ffffa2">IMAGEN</th>
                            <th style="background-color: #ffffa2">SKU</th>
                            <th style="background-color: #ffffa2">Nombre</th>
                            <th style="background-color: #ffffa2">Precio</th>
                            <th style="background-color: #ffffa2">Stock</th>
                            <th style="background-color: #ffffa2">Min.</th>
                            <th style="background-color: #ffffa2">Categoria</th>
                            <th style="background-color: #ffffa2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $item)

                            <tr>
                                <td>
                                    @if($item->imagen=="")

                                    <img src="{{asset('dist/img/aprendizaje.png')}}" width="36" height="36" class="" style="object-fit: cover; object-position: center">

                                    @else
                                    <img src="{{asset('storage/' . $item->imagen)}}" width="36" height="36" class="" style="object-fit: cover; object-position: center" alt="{{ $item->nombre }}">

                                    @endif

                                </td>

                                <td>{{$item->sku}}</td>
                                <td>{{$item->nombre}}</td>
                                <td>{{$item->costo}}</td>
                                <td><span class="{{ $item->minimo_stock >= $item->stock ? 'p-1 rounded' : '' }} " style="background-color:  #ff5830; color: white ">{{$item->stock}}</span></td>
                                <td class="">{{$item->minimo_stock}}</td>
                                <td>{{$item->categoria->nombre}}</td>
                                <td>
                                    <button class="btn btn-primary" wire:click.prevent="edit({{$item}})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn" style="background-color:  #ff5830; color: white" onclick="confimarEliminacion('{{$item->id}}')">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-warning">
                                        No hay productos registrados
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{$productos->links()}}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Ventana modal de opciones -->
    @include('modals.modal-header')
    @include('productos.form')
    @include('modals.modal-footer')

</section>
