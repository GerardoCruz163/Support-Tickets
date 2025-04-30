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
                    <input type="hidden" id="cat_id" name="cat_id">
    
                    <div class="form-group">
                        <label class="form-label" for="cat_nom">Nombre</label>
                        <input type="text" class="form-control" id="cat_nom" name="cat_nom" placeholder="Ingrese el nombre de la categoria" required>
                    </div>
    
                    
    
                    

                    <!-- <div class="form-group">
                        <label class="form-label" for="area_id">Area</label>
                        <select class="select2" id="area_id" name="area_id">
                            <option value="1">Sistemas</option>
                            <option value="2">Trafico</option>
                            <option value="3">Contabilidad</option>
                        </select>
                    </div> -->
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-rounded btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" name="action" id="#" value="add" class="btn btn-rounded btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div><!--.modal-->