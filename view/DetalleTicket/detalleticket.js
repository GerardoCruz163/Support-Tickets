function init(){
    $('#usuario_form').on("submit", function(e){
        insertarseguidores(e);
    });
}

function insertarseguidores(e){
    e.preventDefault();

    $("#seguidores").val($("#seguidores").select2('val'));

    var formData = new FormData($("#usuario_form")[0]);
    
    
    //TOMA LOS SEGUIDORES SELECCIONADOS
    var seguidores = $("#seguidores").val(); 
    console.log("Seguidores seleccionados:", seguidores);

    console.log("Ticket ID:", $("#tick_id").val());

    $.ajax({
        url: "../../controller/ticket.php?op=insert_seguidor",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){
            swal("¡Listo!", "Has asignado seguidor/es.", "success");
            console.log(data );
        }
    });
    $('#modalseguidorticket').modal('hide');
}

            // SOCKET IO RUTA

//const socket = io("https://support-tracking.tecnologisticaaduanal.com:8082"); 
const socket = io("http://localhost:8082"); // O la IP si es red local

$(document).ready(function(){
    
    const url = window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    const tick_id = params.get("ID");
    const decoded_id =  decodeURIComponent(tick_id);
    const encodedCiphertext = encodeURIComponent(tick_id);
    const id = decoded_id.replace(/\s/g, '+'); 

    //AQUI LEO EL SESSION STORAGE
    const realTicketId = sessionStorage.getItem("ticket_id_real");

    //console.log(realTicketId);
    socket.on("connect", () => {
        console.log("Conectado al WebSocket");
    });
    socket.emit("join_ticket", realTicketId);

    socket.on("recibir_mensaje", (data)=> {
        // Solo refresca si el mensaje pertenece al mismo ticket
        if (data.ticketId === realTicketId) {
            console.log("Mensaje en tiempo real recibido:", data);
            mostraryvalidar(id); // ya está definida y actualiza los mensajes
        }
    });
    
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

    // $.post("../../controller/ticket.php?op=combo_usuarios_seg_detalle",function(data, status){ // aqui
    //     $('#mdltitulo').html('Añade seguidor/es al ticket');
    //     $('#seguidores').html(data);
    // });

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
            data : {tick_id:id},
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
    console.log("Tick ID enviado a listar:", id);

    mostraryvalidar(id);
});

function insertseguidor(e){
    e.preventDefault();

    var formData = new FormData($("#ticket_form")[0]);

}

$(document).on("click","#btnenviar",function(){
    const url = window.location.href;
    const params = new URLSearchParams(new URL(url).search);3
    const tick_id = params.get("ID");
    const decoded_id =  decodeURIComponent(tick_id);
    const id = decoded_id.replace(/\s/g, '+'); 
    console.log(id);

    const realTicketId = sessionStorage.getItem("ticket_id_real");

    //var tick_id = getUrlParameter('ID'); // Aqui
    var usu_id = $('#user_idx').val();
    var tickd_descrip = $('#tickd_descrip').val();

    // VERIFICA SI EL BOTON DE URGENCIA ESTA ACTIVO
    const esUrgente = $("#btnUrgente").hasClass("activo") ? 1 : 0; 

    //VERIFICA QUE NO QUEDE NINGUN CAMPO VACIO, MINIMO UNO DEBE TENER INFORMACION
    if ($('#tickd_descrip').summernote('isEmpty') && $('#fileElem')[0].files.length === 0){
        swal("¡Advertencia!", "No puedes dejar el campo vacio", "warning");
    }else{

        //CARGAMOS EL FORMDATA CON LA INFORMACION INTRODUCIDA
        var formData = new FormData();
        formData.append('tick_id',id);
        formData.append('usu_id',usu_id);
        formData.append('tickd_descrip',tickd_descrip);
        // CARGA EL ESTADO DEL BOTON DE URGENCIA
        formData.append('es_urgente', esUrgente);

        var totalFiles = $('#fileElem').val().length;
        for(var i = 0; i<totalFiles; i++){
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }

        $('#btnenviar').prop("disabled",true);
        $('#btnenviar').html('<i class="fa fa-spinner fa-spin"></i> Enviando...');

        $.ajax({
            url: "../../controller/ticket.php?op=insertdetalle",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){

                mostraryvalidar(id);
                $('#fileElem').val('');
                $('#tickd_descrip').summernote('reset');
                console.log(data);

                //listarDetalle(id);
                $('#btnenviar').prop("disabled",false);
                $('#btnenviar').html('<i class="fa fa-paper-plane" aria-hidden="true"></i> Enviar');  
                
                // io.to(ticketId).emit("recibir_mensaje", {
                //     ticketId: id,
                //     message: tickd_descrip,
                //     usuario: usu_id
                // });
                
                socket.emit("recibir_mensaje", {
                    ticketId: realTicketId,
                    message: tickd_descrip,
                    usuario: usu_id
                });
                
            }
        });
    }
});

$(document).on("click","#btnUrgente",function(){
    const $btn = $(this);
    $btn.toggleClass("activo");

    if ($btn.hasClass("activo")) {
        $btn.removeClass("btn-secondary").addClass("btn-danger");
        $btn.html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Marcado como Urgente');
    } else {
        $btn.removeClass("btn-danger").addClass("btn-secondary");
        $btn.html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Marcar como Urgente');
    }
});

$(document).on("click", "#btnseguidores", function(data,status){ //AQUI ABRE EL BOTON QUE NOS DA EL MODAL DE LOS SEGUIDORES
    const url = window.location.href;
    const params = new URLSearchParams(new URL(url).search);
    const tick_id = params.get("ID");
    const decoded_id = decodeURIComponent(tick_id);
    const id = decoded_id.replace(/\s/g, '+'); 

    $("#tick_id").val(id);
    
    // Título modal
    $('#mdltitulo').html('Añadir Seguidor/es a este ticket');
    $('#modalseguidorticket').modal('show');

    
    // Llamada AJAX para cargar usuarios disponibles
    $.post("../../controller/ticket.php?op=combo_usuarios_seg_detalle", { tick_id: id }, function (data) {
        $('#seguidores').html(data);

        console.log(tick_id);
    });
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
                swal.close();
                const url = window.location.href;
                const params = new URLSearchParams(new URL(url).search);
                const tick_id = params.get("ID");
                const decoded_id =  decodeURIComponent(tick_id);
                const id = decoded_id.replace(/\s/g, '+'); 
                //var usu_id = $('#user_idx').val();

                
                $.ajax({
                    url:"../../controller/ticket.php?op=update",
                    type: "POST",
                    data: {tick_id: id},
                    success: function(datos){
                        console.log(datos);

                        mostraryvalidar(id);

                        swal({
                            title: "Ticket cerrado",
                            text: "El ticket ha sido cerrado.",
                            type: "success",
                            confirmButtonClass: "btn-success"
                        });

                        
                        $.unblockUI();

                    },beforeSend: function(){
                        $.blockUI({
                            overlayCSS:  {
                                background: 'rgba(142, 159, 167, 0.3)',
                                opacity: 1,
                                cursor: 'wait'
                            },
                            css: {
                                width: 'auto',
                                top: '45%',
                                left: '45%'
                            },
                            message: '<div class="blockui-default-message">Cerrando ticket, espere...</div>',
                            blockMsgClass: 'block-msg-message-loader'
                        });
                    },
                });

                // $.post("../../controller/ticket.php?op=update", {tick_id: id}, function (data){
                    
                // });

                // $.post("../../controller/email.php?op=ticket_cerrado", {tick_id: id}, function (data){

                // });

                

                // $.post("../../controller/ticket.php?op=listardetalle", {tick_id: id}, function (data){
                //     $('#lbldetalle').html(data);
                // });
                //listarDetalle(id); 
                
            }
        }
    );
});

function mostraryvalidar(id){
    //console.log("mostraryvalidar ejecutado desde WebSocket con ID:", id);
    $.post("../../controller/ticket.php?op=listardetalle", {tick_id: id}, function (data){
        //console.log("Respuesta del detalle:", data);
        $('#lbldetalle').html(data);
        scrollToBottom();
    });

    $.post("../../controller/ticket.php?op=mostrar", {tick_id: id}, function (data){
        data=JSON.parse(data);
        console.log(data.tick_id); // aqui si muestra el id descifrado
        $('#lblestado').html(data.tick_estado);
        $('#lblnomusuario').html(data.usu_nom + ' ' + data.usu_ape);
        $('#lblarea').html(data.area_nom);
        $('#lblfechcrea').html(data.fech_crea);

        $('#lblfechcierre').val(data.fech_cierre);

        $('#lblnomidticket').html("Detalle ticket: "+data.tick_id);
        
        $('#cat_nom').val(data.cat_nom);
        $('#cats_nom').val(data.cats_nom);
        $('#tick_titulo').val(data.tick_titulo);
        $('#tickd_descripusu').summernote('code', data.tick_descrip);

        $('#prio_nom').val(data.prio_nom);

        //MOSTRAMOS USUARIOS SEGUIDORES
        if(data.seguidores == 0){
            $('#lblnomusuarioseg').html('No Hay Seguidores')
        }else{

            $("#lblnomusuarioseg").html(data.seguidores);
        }
        
        if(data.tick_estado_texto == 'Cerrado'){
            $('#pnldetalle').hide();
        }
    });
}

function scrollToBottom() {
    window.scrollTo({
        top: document.body.scrollHeight,
        behavior: 'smooth'
    });
}

init();