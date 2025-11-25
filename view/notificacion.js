$(document).ready(function(){
    mostrar_notificacion();
});


function mostrar_notificacion(){

    var formData = new FormData();
    formData.append('usu_id',$('#user_idx').val());

    let audio = document.getElementById("notif_sound");

    $.ajax({
        url: "../../controller/notificacion.php?op=mostrar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(data){

            if(!data || data.trim() === ""){
                return; // no hay notificación
            }else{

                if (audio) {
                    audio.play().catch(() => {
                    });
                }
                
                data = JSON.parse(data);
                $.notify({
                    icon: 'glyphicon glyphicon-star',
                    message: data.not_mensaje,
                    //url: "https://support-tracking.tecnologisticaaduanal.com/view/DetalleTicket/?ID=" + data.tick_id //NOS REDIRIGE AL DETALLE DEL TICKET
                })
                //console.log("ID REAL",data.tick_id_real);fergg4t
                //sessionStorage.setItem("ticket_id_real", data.tick_id_real);

                $.post("../../controller/notificacion.php?op=actualizar", {not_id: data.not_id}, function (data){
                
                });

            }
        }
    });

}



setInterval(function(){
    mostrar_notificacion();
}, 5000);