function init(){

}

$(document).ready(function() {
	
});

$(document).on("click", "#btnsoporte", function(){

    if($('#rol_id').val()==1){
        $('#lbltitulo').html("Acceso para soporte");
        $('#btnsoporte').html("Acceso usuario");
        $('#rol_id').val(2);
        $('#imgtipo').attr("src","public/img/2.png")
    }else{
        $('#lbltitulo').html("Acceso usuario");
        $('#btnsoporte').html("Acceso para soporte");
        $('#rol_id').val(1);
        
        $('#imgtipo').attr("src","public/img/1.png")
    }
    
});

init();