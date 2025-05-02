<div id="modalmantenimiento" class="modal fade bd-example-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <input type="hidden" id="cats_id" name="cats_id">
    
                    <div class="form-group">
                        <label class="form-label" for="cat_id">Categoria</label>
                        <select class="select2" id="cat_id" name="cat_id">
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="cats_nom">Nombre/s</label>
                        <input type="text" class="form-control" id="cats_nom" name="cats_nom" placeholder="Ingrese nueva subcategoria" required>
                    </div>
    
                    
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->