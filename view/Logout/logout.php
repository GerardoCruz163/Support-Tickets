<?php
    require_once("../../config/conexion.php");
    session_destroy();
    header("Location:"."http://localhost:80/HelpDesk_Tecno/"."index.php");
    exit();
?>