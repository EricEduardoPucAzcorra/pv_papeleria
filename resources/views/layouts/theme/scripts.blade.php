<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('dist/js/adminlte.js')}}"></script>

<!-- OnKeyscan js -->
<script src="{{asset('plugins/onkeyscan/onscan.min.js')}}"></script>

<!-- Livewire -->
@livewireScripts

<!-- OPTIONAL SCRIPTS -->
<script src="{{asset('plugins/chart.js/Chart.min.js')}}"></script>

<!-- Lista de tablas dashboard -->
<script src="{{asset('dist/js/charts.js')}}"></script>

<!-- SweetAlert2 -->
<script src="{{asset('plugins/sweetalert2/sweetalert2.js')}}"></script>
<!-- Snackbar -->
<script src="{{asset('plugins/snackbar/snackbar.min.js')}}"></script>

<!-- Alpine Js -->
<script src="{{asset('plugins/alpine/alpine.min.js')}}"></script>

<!-- KeyPress -->
<script src="{{asset('plugins/keypress/keypress.js')}}"></script>


<script>
    //Escuchar evento abrir modal
    livewire.on('modal-operaciones', function (modal) {
        $('#modal-opciones').modal(modal);
    })

    livewire.on('usuarios', function (modal) {
        $('#modaluser').modal(modal);
    })


    //Escuchar evento / Confirmar eliminación
    function confimarEliminacion(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Sí, eliminar!'
        }).then((result) => {
            if (result.value) {
                console.log(id);
                //Eliminar
                livewire.emit('eliminar-objeto', id);

                //Mostrar mensaje
                Swal.fire(
                    '¡Eliminado!',
                    'El registro ha sido eliminado.',
                    'success'
                )
            }
        })
    }

    //Escuchar evento de mostrar alerta
    livewire.on('mostrar-alerta', function(Msg) {
        //llamar a la función de Snackbar
        notificacion(Msg, 'sucess');
    })

    //Notificacion con snackbar
    function notificacion(mensaje, tipo) {
        //Tipos: success, error, info, warning
        Snackbar.show({
            pos: 'top-right',
            text: mensaje,
            actionText: 'OK',
            actionTextColor: '#fff',
            backgroundColor: '#333',
            showAction: true,
            duration: 5000,
            customClass: 'notificacion-' + tipo
        });
    }

    //Escuchar eventos del escaner de código de barras
    onScan.attachTo(document);

    document.addEventListener('scan', function (sku) {
        //console.log(sku.detail.scanCode);
        livewire.emit('agregar', sku.detail.scanCode);
    })


</script>


