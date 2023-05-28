<div>
    <h6 >Detalles de {{ $deudor->nombre . ' ' . $deudor->apellido }}</h6>

    <div class="row justify-content-center pt-4">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header" style="background-color: #ffffa2">
                    <h3 class="card-title">Lista de deudas</h3>

                    {{-- <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div> --}}

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Objetos</th>
                                <th>Fecha</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($deudas as $deuda)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $deuda->items}}</td>
                                    <td>{{ \Carbon\Carbon::parse($deuda->created_at)->diffForHumans() }}
                                    </td>
                                    <td>${{ number_format($deuda->total, 2) }}
                                    </td>
                                    <td>
                                        {{-- <button class="btn {{$deuda->estatus == 'PENDIENTE' ? 'btn-danger' : 'btn-secondary'}}">
                                            {{ $deuda->estatus }}
                                        </button> --}}

                                        @if($deuda->estatus=='PENDIENTE')

                                            <button style="background-color: #ff5830; color: white" class="btn btn-default">PENDIENTE</button>
                                        @else

                                            <button class="btn btn-success">COMPLETADO</button>

                                        @endif

                                    </td>
                                    <td class="text-right">
                                        @if ($deuda->estatus == 'PENDIENTE')

                                            <button class="btn btn-success btn-sm" onclick="pagarDeuda('{{$deuda->id}}')">
                                                <i class="fas fa-money-bill-wave"></i>
                                            </button>
                                        @endif

                                        <button class="btn btn-dark btn-sm" data-toggle="modal" data-target="#modalDetalles" wire:click.prevent="cargarModal('{{$deuda->id}}')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <h3 class="text-center">No hay deudas registradas</h3>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">

                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>

    @include('deudas.form')

</div>
