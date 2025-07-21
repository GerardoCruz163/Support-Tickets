var tabla;

function init(){
    $("#usuario_form").on("submit",function(e){
        guardaryeditar(e);
    });
}

//TOMAR ESTE EJEMPLO PARA CREACION DE NUEVO TICKET (AL DEJAR CAMPOS VACIOS)
function guardaryeditar(e){
    e.preventDefault();
	var formData = new FormData($("#usuario_form")[0]);
    $.ajax({
        url: "../../controller/categoria.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){   
            if(datos == 1){
                console.log("Respuesta del servidor:", datos); 
                $('#usuario_form')[0].reset();
                $("#modalmantenimiento").modal('hide');
                $('#usuario_data').DataTable().ajax.reload();
                
                swal({
                    title: "TLA Support Tracking",
                    text: "Registrado correctamente.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });   
            }else if(datos == 2){
                console.log("Respuesta del servidor:", datos); 
                $('#usuario_form')[0].reset();
                $("#modalmantenimiento").modal('hide');
                $('#usuario_data').DataTable().ajax.reload();
    
                swal({
                    title: "TLA Support Tracking",
                    text: "Actualizado correctamente.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });    
            }
            //  else if(datos== 0){
            //     $("#cat_nom").addClass("form-control-error");
            //     $("<small class='text-muted text-danger'>El nombre que introduciste ya existe.</small>").insertAfter("#cat_nom");
            // }
        }
    }); 
}

$(document).ready(function(){ 
    tabla=$('#usuario_data').dataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: 'Bfrtip',
        "searching": true,
        lengthChange: false,
        colReorder: true,
        buttons: [		          
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
                ],
        "ajax":{
            url: '../../controller/categoria.php?op=listar',
            type : "post",
            dataType : "json",							
            error: function(e){
                console.log(e.responseText);	
            }
        },
        "ordering": false,
        "bDestroy": true,
        "responsive": true,
        "bInfo":true,
        "iDisplayLength": 10,
        "autoWidth": false,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }     
    }).DataTable(); 
});


function editar(cat_id){
    $('#mdltitulo').html('Editar Categoria');

    $("#cat_nom").removeClass("form-control-error");

    $("#cat_nom + small").remove();

    $.post("../../controller/categoria.php?op=mostrar", {cat_id: cat_id}, function (data){
        data = JSON.parse(data);
        console.log(data);
        $('#cat_id').val(data.cat_id);
        $('#cat_nom').val(data.cat_nom);
        $('#area_id').val(data.area_id).trigger('change');
        console.log(data.area_id);
    });
    $('#modalmantenimiento').modal('show');
}

function eliminar(cat_id){
    swal(
        {
            title: "TLA Support Tracing",
            text: "¿Estas segur@ de eliminar esta categoria?",
            type: "error",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Si",
            cancelButtonText: "No",
            closeOnConfirm: false,
            
        },
        function(isConfirm) {
            if (isConfirm) {
                $.post("../../controller/categoria.php?op=eliminar", {cat_id: cat_id}, function (data){
                    
                });
                
                swal({
                    title: "TLA Support Tracing",
                    text: "Categoria eliminada.",
                    type: "success",
                    confirmButtonClass: "btn-success"
                });
                $('#usuario_data').DataTable().ajax.reload();
            }
        }
    );
}
$(document).on("click","#btnnuevo",function(){
    $('#mdltitulo').html('Nueva categoria');
    $('#usuario_form')[0].reset();

    $("#cat_nom").removeClass("form-control-error");
    $("#cat_nom + small").remove();

    $('#modalmantenimiento').modal('show');
});

init();