<?php
    require_once("config/conexion.php");

    // GENERAR STATE (proteccion CSRF) Y GUARDARLO EN SESION
    $state = bin2hex(random_bytes(16));
    $_SESSION["oauth_state"] = $state;

    // ESTA APP YA NO TIENE LOGIN PROPIO: SE REDIRIGE SIEMPRE AL LOGIN DE TOOLBOX (SSO)
    $toolbox_authorize = $_ENV["TOOLBOX_URL"] . "oauth/authorize.php"
        . "?client_id=" . urlencode($_ENV["OAUTH_CLIENT_ID"])
        . "&redirect_uri=" . urlencode($_ENV["URL_DOMAIN"] . "oauth/callback.php")
        . "&response_type=code"
        . "&state=" . urlencode($state);

    header("Location: " . $toolbox_authorize);
    exit();
?>
