
<div class="modal fade"  wire:ignore.self id="modaluser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
    <div class="modal-header" style="background-color: #ff5830; color: white">
        <h5 class="modal-title" id="exampleModalLabel">
          @if($bandera=='nuevo')
            Nuevo Usuario
          @else
            Editar usuario
          @endif
        </h5>
        <button type="button" class="close" wire:click.prevent="closeform">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        @include('usuarios.formu')


    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" wire:click.prevent="closeform" style="background-color: #ff5830; color: white">Cancelar</button>
        @if($bandera=='nuevo')
        <button type="button" class="btn btn-primary" wire:click="store()">Guardar</button>
          @else
          <button type="button" class="btn btn-primary" wire:click="update()">Editar</button>
          @endif

    </div>
    </div>
</div>
</div>

