<div id="modalseguidorticket" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                    <i class="font-icon-close-2"></i>
                </button>
                <h4 class="modal-title" id="mdltitulo"></h4></h4>
            </div>

            <form method="post" id="usuario_form">
                <div class="modal-body">
                    <input type="hidden" id="tick_id" name="tick_id">
    
                    <label class="form-label semibold" for="">Los seguidores que añades también daran seguimiento al ticket.</label>
                    <select id="seguidores" name="seguidores[]" class="select2 select2-hidden-accessible" multiple="" tabindex="-1" aria-hidden="true">
                        
                    </select>
							
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" id="btnanadir" name="action" value="add" class="btn btn-rounded btn-primary">Añadir</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->