<div class="pt-2">

    @section('titulo', 'Reportes')

    <div class="row">
        <!-- Visor de estadisticas -->
        <div class="col-md-8 shadow mb-4 mb-md-0" style="height: 58vh; overflow-y: auto">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div wire:loading class="spinner-border text-primary float-right" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    
                    <h3 class="mb-n1">Generar reporte</h3>
                </div>
                <div class="card-body" style="overflow-y: auto">
                    <table class="table table-nowrap table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($this->reportes as $venta)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ \Carbon\Carbon::parse($venta->created_at)->translatedFormat('d-M-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($venta->created_at)->format('h:i A') }}</td>
                                    <td>{{ $venta->items }}</td>
                                    <td>${{ number_format($venta->total, 2) }}</td>
                                    <td>{{ $venta->estatus }}</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm" wire:click.prevent="verDetalles({{$venta}})">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No hay registros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>

                <!-- Spinner -->
                
            </div>
        </div>

        <!-- Menu de filtro por fechas -->
        <div class="col-md-4">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <!-- Boton recargar -->
                    <button class="btn btn-primary btn-sm float-right" wire:click.prevent="render()">
                        <i class="fas fa-redo"></i>
                    </button>
                    <h3 class="mb-n1">Opciones</h3>
                </div>
                <div class="card-body">
                    <div>
                        <label>Tipo de Reporte</label>
                        <div class="d-flex">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo1" value="DIARIO"
                                    wire:model="tipoReporte">
                                <label class="form-check-label" for="tipo1">Diario</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipo" id="tipo2" value="FECHA"
                                    wire:model="tipoReporte">
                                <label class="form-check-label" for="tipo2">Fechas</label>
                            </div>
                        </div>
                    </div>
                    <!-- Por Fechas -->
                    <div class="form-group">
                        <label>Fecha Inicio</label>
                        <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" wire:model="fechaInicio">
                    </div>
                    <div class="form-group">
                        <label>Fecha Fin</label>
                        <input type="date" class="form-control" name="fecha_fin" id="fecha_fin"  wire:model="fechaFin">
                    </div>

                    <!-- Exportar reportes -->
                    <div class="form-group">
                        <button class="btn btn-danger btn-block" wire:click.prevent="exportarPDF()">
                            <i class="fas fa-file-export"></i>
                            PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablero de detalles -->
    <div class="mt-3 mt-md-3">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="mb-n1">Detalles</h3>
            </div>
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-md-3">
                        <span>Productos Vendidos: <strong>{{$productosVendidos}}</strong></span>
                    </div>
                    <div class="col-md-3">
                        <span>Ventas realizadas: <strong>{{$venRealizadas}}</strong></span>
                    </div>
                    <div class="col-md-3">
                        <span>Ventas pendientes: <strong>{{$venPendientes}}</strong></span>
                    </div>
                    <div class="col-md-3">
                        <span>Ventas canceladas: <strong>{{$venCanceladas}}</strong></span>
                    </div>
                    <div class="col-md-3 mt-2">
                        <span>Ingresos de ventas: <strong>${{number_format($ingresosVentas, 2)}}</strong></span>
                    </div>
                    <div class="col-md-3 mt-2">
                        <span>Ingresos obtenidos: <strong>${{number_format($ingresosObtenidos, 2)}}</strong></span>
                    </div>
                    <div class="col-md-3 mt-2">
                        <span>Ingresos pendientes: <strong>${{number_format($ingresosPendientes, 2)}}</strong></span>
                    </div> 
                    <div class="col-md-3 mt-2">
                        <span>Ingresos cancelados: <strong>${{number_format($ingresosCancelados, 2)}}</strong></span>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('livewire.reportes.modal')
</div>
