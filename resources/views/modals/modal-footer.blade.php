                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" style="background-color: #ff5830; color: white" class="btn btn-default" data-dismiss="modal"
                        wire:click.prevent="resetUI">Cerrar</button>

                    <div wire:loading>
                        <div class="spinner-border text-primary" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>

                    @if ($selected_id == -1)
                        <button type="button" class="btn btn" style="background-color: #48c26c; color: white" wire:click.prevent="store">Guardar</button>
                    @else
                        <button type="button" class="btn btn-primary"
                            wire:click.prevent="update('{{ $selected_id }}')">Editar</button>
                    @endif


                </div>
                </div>
                <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
                </div>
