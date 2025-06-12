<?php
    require_once("../../config/conexion.php");
    session_destroy();

    if($_SESSION["rol_id"] == 1){
        header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");        
    } else if($_SESSION["rol_id"] == 2) {
        header("Location:"."http://localhost:80/HelpDesk_Tecno/"."view/accesosoporte/index.php"); 
    }
    exit();
?>