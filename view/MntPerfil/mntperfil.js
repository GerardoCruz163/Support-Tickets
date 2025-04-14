
$(document).on("click","#btnactualizar",function(){
    var pass = $("#txtpass").val();
    var newpass = $("#txtpassnew").val();

    if(pass.length == 0 || newpass.length == 0){
        swal("Campos vacíos", "Debes llenar los campos", "error")
    }else{
        if(pass==newpass){
            console.log("Contraseña actualizada");
            var usu_id =$('#user_idx').val();
            $.post("../../controller/usuario.php?op=password", {usu_id : usu_id, usu_pass : newpass}, function (data){
                swal("Contraseña actualizada", "Anotala en un lugar seguro", "success")
            });

        }else{
            swal("Error", "Las contraseñas no coinciden", "error")
        }
    }   
});