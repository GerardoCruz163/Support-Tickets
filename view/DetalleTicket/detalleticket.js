function init(){


}

$(document).ready(function(){
    var tick_id=getUrlParameter('ID');

    listarDetalle(tick_id);


    $('#tickd_descrip').summernote({
        height: 150,
        lang: "es-ES",
        callbacks: {
            onImageUpload: function(image) {
                console.log("Image detect...");
                myimagetreat(image[0]);
            },
            onPaste: function (e) {
                console.log("Text detect...");
            }
        },
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
    
    });

    $('#tickd_descripusu').summernote({
        height: 250,
        lang: "es-ES",
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
    });

    $('#tickd_descripusu').summernote('disable');

    tabla=$('#documentos_data').dataTable({
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
            url: '../../controller/documento.php?op=listar',
            type : "post",
            data : {tick_id:tick_id},
            dataType : "json",
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

    $(document).on("click","#btnenviar",function(){
        var tick_id = getUrlParameter('ID');
        var usu_id = $('#user_idx').val();
        var tickd_descrip = $('#tickd_descrip').val();

        if ($('#tickd_descrip').summernote('isEmpty')){
            swal("¡Advertencia!", "No puedes dejar el campo vacio", "warning");
        }else{

            $.post("../../controller/ticket.php?op=insertdetalle", {tick_id: tick_id, usu_id: usu_id, tickd_descrip: tickd_descrip}, function (data){
                listarDetalle(tick_id);
                // swal("Mensaje enviado", "Se ha enviado tu mensaje correctamente.","success");
                $('#tickd_descrip').summernote('reset');
            });
        }

    })

    $(document).on("click","#btncerrar",function(){
        swal(
            {
                title: "TLA Support Tracing",
                text: "¿Estas seguro de cerrar este ticket?",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-warning",
                confirmButtonText: "Si",
                cancelButtonText: "No",
                closeOnConfirm: false,
                
            },
            function(isConfirm) {
                if (isConfirm) {
                    var tick_id=getUrlParameter('ID');
                    var usu_id = $('#user_idx').val();
                    $.post("../../controller/ticket.php?op=update", {tick_id: tick_id, usu_id: usu_id}, function (data){
                        
                    });

                    $.post("../../controller/email.php?op=ticket_cerrado", {tick_id: tick_id}, function (data){

                    });
                    listarDetalle(tick_id);
                    
                    swal({
                        title: "Ticket cerrado",
                        text: "Gracias por atender.",
                        type: "success",
                        confirmButtonClass: "btn-success"
                    });
                }
            }
        );
    })

    function listarDetalle(tick_id){
        $.post("../../controller/ticket.php?op=listardetalle", {tick_id: tick_id}, function (data){
        
            $('#lbldetalle').html(data);
        });

        $.post("../../controller/ticket.php?op=mostrar", {tick_id: tick_id}, function (data){
            data=JSON.parse(data);
            $('#lblestado').html(data.tick_estado);
            $('#lblnomusuario').html(data.usu_nom + ' ' + data.usu_ape);
            $('#lblarea').html(data.area_nom);
            $('#lblfechcrea').html(data.fech_crea);
            $('#lblnomidticket').html("Detalle ticket: "+data.tick_id);
            
            $('#cat_nom').val(data.cat_nom);
            $('#cats_nom').val(data.cats_nom);
            $('#tick_titulo').val(data.tick_titulo);
            $('#tickd_descripusu').summernote('code', data.tick_descrip);
    
            $('#prio_nom').val(data.prio_nom);

            if(data.tick_estado_texto == 'Cerrado'){
    
                $('#pnldetalle').hide();
            }
        });
    }
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

init();