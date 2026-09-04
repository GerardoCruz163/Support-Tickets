<?php

    require_once "../config/conexion.php";
    require_once "../models/Usuario.php";

    $usuario = new Usuario();

    $code  = $_GET["code"] ?? "";
    $state = $_GET["state"] ?? "";

    // VALIDAR EL state (PROTECCION CSRF) CONTRA EL QUE SE GUARDO ANTES DE IR A TOOLBOX
    if (empty($state) || !isset($_SESSION["oauth_state"]) || !hash_equals($_SESSION["oauth_state"], $state)) {

        unset($_SESSION["oauth_state"]);

        exit("Estado inválido, intenta iniciar sesión de nuevo.");
    }

    unset($_SESSION["oauth_state"]);

    if (empty($code)) {
        exit("No se recibió el code de autorización.");
    }

    // CANJEAR EL code POR UN access_token EN TOOLBOX
    $ch = curl_init($_ENV["TOOLBOX_URL"] . "oauth/token.php");

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        "client_id"     => $_ENV["OAUTH_CLIENT_ID"],
        "client_secret" => $_ENV["OAUTH_CLIENT_SECRET"],
        "code"          => $code,
        "grant_type"    => "authorization_code"
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $token_response = curl_exec($ch);
    curl_close($ch);

    $token_data = json_decode($token_response, true);

    if (!isset($token_data["access_token"])) {
        exit("No se pudo obtener el access token de Toolbox.");
    }

    $access_token = $token_data["access_token"];

    // CONSULTAR LOS DATOS DEL USUARIO EN TOOLBOX
    $ch = curl_init($_ENV["TOOLBOX_URL"] . "oauth/userinfo.php");

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $access_token
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $userinfo_response = curl_exec($ch);
    curl_close($ch);

    $usuario_toolbox = json_decode($userinfo_response, true);

    if (!isset($usuario_toolbox["usu_correo"])) {
        exit("No se pudo obtener la información del usuario desde Toolbox.");
    }

    // BUSCAR AL USUARIO LOCAL POR CORREO
    $usu_data = $usuario->get_usuario_x_correo($usuario_toolbox["usu_correo"]);

    // APROVISIONAMIENTO JIT: primera vez que este usuario de Toolbox entra a Support-Tracking
    if (!$usu_data) {

        $usuario->crear_usuario_jit(
            $usuario_toolbox["usu_nom"],
            $usuario_toolbox["usu_ape"],
            $usuario_toolbox["usu_correo"]
        );

        $usu_data = $usuario->get_usuario_x_correo($usuario_toolbox["usu_correo"]);
    }

    $usu = $usu_data[0];

    // CREAR LA SESION LOCAL DE SUPPORT-TRACKING
    $_SESSION["usu_id"]  = $usu["usu_id"];
    $_SESSION["usu_nom"] = $usu["usu_nom"];
    $_SESSION["usu_ape"] = $usu["usu_ape"];
    $_SESSION["rol_id"]  = $usu["rol_id"];
    $_SESSION["suc_id"]  = $usu["suc_id"];
    $_SESSION["area_id"] = $usu["area_id"];
    $_SESSION["pic_num"] = $usu["pic_num"];

    header("Location: " . Conectar::ruta() . "view/Home/");
    exit();
?>
