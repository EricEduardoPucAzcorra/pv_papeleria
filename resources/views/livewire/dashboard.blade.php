<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-0" style="background-color: #ffffa2">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Productos por agotarse</h3>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-nowrap table-striped">
                    <thead>
                        <tr>
                            <th >Nombre</th>
                            <th>Cantidad</th>
                            <th>Minimo</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productosCortos as $producto)
                            <tr>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>{{ $producto->minimo_stock }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4">No hay productos por agotarse</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header border-0" style="background-color: #ffffa2">
                <h3 class="card-title">Productos más vendidos</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Precio</th>
                            <th>Ventas</th>
                            <th>Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productosMasVendidos as $producto)
                            <tr>
                                <td>
                                    {{$producto->nombre}}
                                </td>
                                <td>${{$producto->precio}}</td>
                                <td>
                                    {{$producto->ventas->count()}}
                                </td>
                                <td>
                                    {{$producto->stock}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4">No hay productos más vendidos</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col-md-6 -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header border-0" style="background-color: #ffffa2">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Últimas ventas</h3>
                    <a href="{{route('reportes')}}">Ver reporte</a>
                </div>
            </div>
            <div class="card-body">

                <table class="table table-nowrap table-striped">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Productos</td>
                            <td>Total</td>
                            <td>Hora</td>
                            <td>Pago</td>
                        </tr>
                        <tbody>
                            @forelse ($ultimasVentas as $venta)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        {{$venta->items}}
                                    </td>
                                    <td>${{$venta->total}}</td>
                                    <td>{{$venta->created_at->format('H:i')}}</td>
                                    <td>${{number_format($venta->pago, 2)}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No hay ventas hoy</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </thead>
                </table>

            </div>
        </div>
        <!-- /.card -->

        <div class="card">
            <div class="card-header border-0" style="background-color: #ffffa2">
                <h3 class="card-title">Deudas activas <small>(más antiguas)</small></h3>
            </div>
            <div class="card-body">
                <table class="table table-nowrap table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Notas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($deudasAntiguas as $deuda)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$deuda->deuda->nombre}}</td>
                                <td>${{$deuda->total}}</td>
                                <td>{{$deuda->created_at->format('d/m/Y')}}</td>
                                <td>{{$deuda->deuda->notas}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No hay deudas activas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-6 -->
</div>
