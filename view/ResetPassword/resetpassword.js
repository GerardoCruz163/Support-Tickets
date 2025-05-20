$(document).on("click","#btnenviar",function(){
    var usu_correo = $("#usu_correo").val();

    if(usu_correo.length == 0){
        swal("Campo vacio...", "Escribe un correo electronico valido", "warning")
    }else{
        $.post("../../controller/usuario.php?op=correo", {usu_correo : usu_correo}, function (data){
            console.log(data);
            if(data == "Existe"){
                $.post("../../controller/email.php?op=recuperar_contrasena", {usu_correo: usu_correo}, function (data){
                    console.log(data);//
                    
                });
                swal("Verifica tu correo.", "Se le ha enviado un correo electrónico", "success");
            }else{
                swal("Correo no encontrado.", "El correo que ingresaste no esta registrado en el sistema.", "error");
            }
        });

    }

});