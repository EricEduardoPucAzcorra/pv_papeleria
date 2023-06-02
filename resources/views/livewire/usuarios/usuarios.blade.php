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
                        <button class="btn btn-primary btn-sm float-right" type="button" wire:click="create()">Agregar</button>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="background-color: #ffffa2">Imagen</th>
                            <th style="background-color: #ffffa2">Nombres</th>
                            <th style="background-color: #ffffa2">Apellidos</th>
                            <th style="background-color: #ffffa2">Estatus</th>
                            <th style="background-color: #ffffa2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($usuarios as $item)
                            <tr>
                                <td>
                                    @if($item->imagen=="")
                                    <img src="{{asset('dist/img/user.png')}}" width="36" height="36" class="" style="object-fit: cover; object-position: center">

                                    @else
                                    <img src="{{asset('storage/' . $item->imagen)}}" width="36" height="36" class="" style="object-fit: cover; object-position: center" alt="{{ $item->nombre }}">

                                    @endif
                                </td>

                                <td>{{$item->nombre}}</td>
                                <td>{{$item->apellido}}</td>
                                <td>
                                    @if($item->estatus=='INACTIVO')
                                        <button style="background-color: #ff5830; color: white" class="btn btn-default">INACTIVO</button>
                                    @else
                                        <button class="btn btn-success">ACTIVO</button>
                                    @endif
                                </td>

                                <td>
                                    <button class="btn btn-primary" type="button" wire:click="edit({{$item}})" >
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{-- <div class="card-footer">
                {{$usuarios->links()}}
            </div> --}}
        </div>
    </div>
    <!-- Ventana modal de opciones -->

    @include('modals.modalusuarios')



</section>





