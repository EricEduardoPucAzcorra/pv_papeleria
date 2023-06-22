<section class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">

                <div class="row">
                    <div class="input-group input-group-sm col-10">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search"
                            wire:model="search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <div class="col-2">
                        <button class="btn btn-primary btn-sm float-right" type="button" data-toggle="modal"
                            data-target="#modal-opciones">Agregar</button>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-2">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th style="background-color: #ffffa2">ID</th>
                            <th style="background-color: #ffffa2">Nombre</th>
                            <th style="background-color: #ffffa2">Usos</th>
                            <th style="background-color: #ffffa2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $categoria->nombre }}</td>
                                <td> {{ $categoria->productos->count() }} </td>
                                <td class="text-right">
                                    <button class="btn btn-primary"  wire:click="edit({{ $categoria }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if ($categoria->productos->count() == 0)
                                        <button class="btn btn" style="background-color: #ff5830; color: white"
                                            onclick="confimarEliminacion('{{ $categoria->id }}')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No hay registros</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $categorias->links() }}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Ventana modal de opciones -->
    @include('modals.modal-header')

    <div>
        <label for="">Nombre de la categoría</label>
        <input type="text" class="form-control" wire:model.lazy="nombre">
    </div>

    @include('modals.modal-footer')

</section>
