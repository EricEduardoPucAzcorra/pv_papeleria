<div class="row justify-content-center pt-4">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header" style="background-color: #ffffa2">
                <h3 class="card-title">Lista de deudas</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Buscar" wire:model="search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Ultima Deuda</th>
                            <th>Cantidad</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($deudas as $deuda)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$deuda->nombre . ' ' . $deuda->apellido}}</td>
                                <td>{{$deuda->ventas->last() != null ? \Carbon\Carbon::parse($deuda->ventas->last()->created_at)->diffForHumans() : 'No disponible'}}</td>
                                <td>{{$deuda->ventas != null ? '$' . $this->calcularTotal($deuda) : 'No disponible'}}</td>
                                <td>
                                    <a href="{{route('deudas.show', $deuda)}}">
                                        <small>Ver detalles</small>
                                    </a>
                                </td>
                            </tr>
                        @empty 
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-primary">
                                        No se encuentran coincidencias
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                {{$deudas->links()}}
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>
