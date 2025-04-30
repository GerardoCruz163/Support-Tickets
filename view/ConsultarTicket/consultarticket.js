var tabla;
var usu_id=$('#user_idx').val();
var rol_id=$('#rol_idx').val();

function init(){
    $("#ticket_form").on("submit",function(e){
        guardar(e);
    });
}

$(document).ready(function(){
    
    
    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#cat_id').html(data);
    });

    $.post("../../controller/prioridad.php?op=combo",function(data, status){
        $('#prio_id').html(data);
    });
    $.post("../../controller/usuario.php?op=combo_usuarios", function (data){
        $('#usu_id').html(data);
    })

    $.post("../../controller/usuario.php?op=combo", function (data){
        $('#usu_asig').html(data);
    })

    if(rol_id == 1){/* SI EL ROL ES USUARIO, SOLO VERA SUS TICKETS GENERADOS */
        $('#viewuser').hide();
        tabla=$('#ticket_data').dataTable({
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
                url: '../../controller/ticket.php?op=listar_x_usu',
                type : "post",
                dataType : "json",	
                data:{ usu_id : usu_id },						
                error: function(e){
                    console.log(e.responseText);	
                }
            },
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
        

    }else{ /* SI EL ROL ES DE SOPORTE, VERA TODOS LOS TICKETS DE LOS USUARIOS */
        var tick_titulo = $('#tick_titulo').val();
        var cat_id = $('#cat_id').val();
        var prio_id = $('#prio_id').val();
        var usu_idt = $('#usu_id').val(); // se utiliza usu_idt para que no haga conflicto con la variable usu_id global

        listardatatable(tick_titulo, cat_id, prio_id, usu_idt);
        
    }

});

function ver(tick_id){
    window.open('http://localhost:80/HelpDesk_Tecno/view/DetalleTicket/?ID='+tick_id+'');
}

function asignar(tick_id){
    $.post("../../controller/ticket.php?op=mostrar", {tick_id : tick_id}, function (data){
        data = JSON.parse(data);
        $('#tick_id').val(data.tick_id);

        $('#mdltitulo').html('Asignar soporte');
        $("#modalasignar").modal('show');
    });
}

function guardar(e){
    e.preventDefault();
	var formData = new FormData($("#ticket_form")[0]);
    $.ajax({
        url: "../../controller/ticket.php?op=asignar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){
            var tick_id =$('#tick_id').val();
            $.post("../../controller/email.php?op=ticket_asignado", {tick_id: tick_id}, function (data){

            });

            $("#modalasignar").modal('hide');
            $('#ticket_data').DataTable().ajax.reload();
        }
    });
}

function CambiarEstado(tick_id){
    swal({
        title: "TLA Support Tracking",
        text: "¿Estas segur@ de reabrir este ticket?",
        type: "error",
        showCancelButton: true,
        confirmButtonClass: "btn-warning",
        confirmButtonText: "Si",
        cancelButtonText: "No",
        closeOnConfirm: false
    },
    function(isConfirm) {   
        if (isConfirm) {
            $.post("../../controller/ticket.php?op=reabrir", {tick_id: tick_id, usu_id:usu_id}, function (data){
                
            });
                
            console.log(tick_id);
            $('#ticket_data').DataTable().ajax.reload();
            
            swal({
                title: "TLA Support Tracking",
                text: "Ticket abierto.",
                type: "success",
                confirmButtonClass: "btn-success"
            });
        }
    });
}

$(document).on("click", "#btnfiltrar", function(){
    limpiar();
    var tick_titulo = $('#tick_titulo').val();
    var cat_id = $('#cat_id').val();
    var prio_id = $('#prio_id').val();
    var usu_id = $('#usu_id').val();

    listardatatable(tick_titulo, cat_id, prio_id, usu_id);
});

$(document).on("click", "#btntodo", function(){
    limpiar();
    $('#tick_titulo').val('');
    $('#cat_id').val('').trigger('change');
    $('#prio_id').val('').trigger('change');
    $('#usu_id').val('').trigger('change');

    listardatatable('', '', '', '');
});

function listardatatable(tick_titulo, cat_id, prio_id, usu_id){
    tabla=$('#ticket_data').dataTable({
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
            url: '../../controller/ticket.php?op=listar_filtro',
            type : "post",
            dataType : "json",	
            data:{ tick_titulo : tick_titulo, cat_id : cat_id, prio_id: prio_id, usu_id : usu_id},					
            error: function(e){
                console.log(e.responseText);	
            }
        },
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

}

function limpiar(){
    $('#table').html(
        "<table id='ticket_data' class='table table-bordered table-striped table-vcenter js-dataTable-full'>"+
            "<thead>"+
                "<tr>"+
                    "<th style='width: 2%;'>#</th>"+
                    "<th style='width: 8%;'>Categoria</th>"+
                    "<th class='d-none -sm-table-cell' style='width: 8%;'>Titulo</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 8%;'>Prioridad</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 4%;'>Creación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 7%;'>Solicitante</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Area</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 5%;'>Estado</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 2%;'>Asignación</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 2%;'>Cierre</th>"+
                    "<th class='d-none d-sm-table-cell' style='width: 4%;'>Soporte</th>"+
                    "<th class='text-center' style='width: 5%;'></th>"+
                "</tr>"+
            "</thead>"+
            "<tbody>"+

            "</tbody>"+
        "</table>"
    );
}
init();