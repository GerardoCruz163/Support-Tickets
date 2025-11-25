function init(){
    $("#ticket_form").on("submit",function(e){
        guardaryeditar(e);
    });

}

var usu_id=$('#user_idx').val();

$(document).ready(function() {

    //console.log(usu_id);
	$('#tick_descrip').summernote({
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
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
          ]
    });

    $.post("../../controller/categoria.php?op=combo",function(data, status){
        $('#cat_id').html(data);
    });

    $("#cat_id").change(function(){
        cat_id =$(this).val();
        

        $.post("../../controller/subcategoria.php?op=combo",{cat_id : cat_id},function(data, status){
            $('#cats_id').html(data);
        });
        $.post("../../controller/usuario.php?op=combo_soporte", { cat_id: cat_id, usu_id: usu_id }, function(data){
            $('#usu_asig').html(data); 
        });
    });

    $.post("../../controller/prioridad.php?op=combo",function(data, status){
        $('#prio_id').html(data);
    });


    $.post("../../controller/usuario.php?op=combo_usuarios_seg",function(data, status){ // aqui
        $('#seguidores').html(data);
    });
});


function guardaryeditar(e){
    e.preventDefault();

    
    var formData = new FormData($("#ticket_form")[0]);
    formData.append("usu_id", usu_id); // esta es la variable que ya definiste arriba
    if ($('#tick_descrip').summernote('isEmpty') || $('#tick_titulo').val()=='' || $("#usu_asig").val()== '' || $("#cats_id").val()=='' || $("#prio_id").val()==''){
        swal("¡Advertencia!", "Campos vacios", "warning");
    }else{ 
       // var totalFiles = $('#fileElem').val().length;
        var totalFiles = $('#fileElem')[0].files.length;
        for(var i = 0; i<totalFiles; i++){
            formData.append("files[]", $('#fileElem')[0].files[i]);
        }
        
        $('#btnguardar').prop("disabled",true);
        $('#btnguardar').html('<i class="fa fa-spinner fa-spin"></i> Enviando...');
        
        //TOMA LOS SEGUIDORES SELECCIONADOS
        var seguidores = $("#seguidores").val(); 
        //console.log("Seguidores seleccionados:", seguidores);

        if (seguidores !== null) {
            seguidores.forEach((seg, i) => {
                formData.append("seguidores[]", seg);
            });
        }

        $.ajax({
            url: "../../controller/ticket.php?op=insert",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data){
                
                // data = JSON.parse(data);
                // console.log(data[0].tick_id);

                // $.post("../../controller/email.php?op=ticket_asignado", {tick_id: data[0].tick_id}, function (data){
                // });
                
                $('#tick_titulo').val('');
                $('#tick_descrip').summernote('reset');
                swal("¡Listo!", "Se ha guardado tu ticket correctamente.", "success");
                // $('#btnguardar').prop("disabled",false);
                // $('#btnguardar').html('<i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar y enviar');
                $('#btnguardar').prop("disabled",false);
                $('#btnguardar').html('<i class="fa fa-paper-plane" aria-hidden="true"></i> Guardar y enviar');   
            }
        });
        
    }
}

init();