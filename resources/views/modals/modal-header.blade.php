{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-opciones">
    Launch Large Modal
</button> --}}

<div class="modal fade" wire:ignore.self id="modal-opciones">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff5830; color: white">
                <h4 class="modal-title">{{$selected_id == -1 ? 'Nuevo' : 'Editar'}} | {{ $operationName }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" wire:click.prevent="resetUI">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            
