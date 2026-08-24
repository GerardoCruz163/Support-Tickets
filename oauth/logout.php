<?php

    require_once "../config/conexion.php";

    $next = $_GET["next"] ?? "";

    // DESTRUIR LA SESION LOCAL DE SUPPORT-TRACKING
    session_unset();
    session_destroy();

    // SOLO SE SIGUE LA CADENA SI EL "next" REGRESA A TOOLBOX (evita open redirect)
    if (!empty($next) && strpos($next, $_ENV["TOOLBOX_URL"]) === 0) {
        header("Location: " . $next);
        exit();
    }

    header("Location: " . Conectar::ruta() . "index.php");
    exit();
?>
