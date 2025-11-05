<?php

    require_once("../config/conexion.php");
    require_once("../models/Documento.php");
    $documento = new Documento();


    $key = "mi_key_secret";
    $cipher = "aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch($_GET["op"]){
        case "listar":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $descifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);
        
            $datos = $documento->get_documento_x_ticket($descifrado);
        
            $data = array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = '<a href="../../public/document/'.$descifrado.'/'.$row["doc_nom"].'" target="_blank">'.$row["doc_nom"].'</a>';
                
                $sub_array[] = '<a type="button" href="../../public/document/'.$descifrado.'/'.$row["doc_nom"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                $data[] = $sub_array;
            }
        
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data
            );
        
            // Solución: asegurarse que los strings estén en UTF-8
            array_walk_recursive($results, function (&$item) {
                if (is_string($item) && !mb_detect_encoding($item, 'UTF-8', true)) {
                    $item = utf8_encode($item);
                }
            });
        
            $json = json_encode($results, JSON_UNESCAPED_UNICODE);
        
            if ($json === false) {
                error_log("Error en json_encode: " . json_last_error_msg());
                http_response_code(500);
                echo json_encode(["error" => "Error al generar JSON"]);
                exit();
            }
        
            echo $json;
        break;

    
        // case "ver":
        //     if (!isset($_SESSION["usu_id"])) {
        //         header("Location: ../../index.php");
        //         exit();
        //     }
        
        //     $tick_id = intval($_GET["tick_id"]);
        //     $file = basename($_GET["file"]); 
        
        //     echo $file;
        //     echo $tick_id;
        //     require_once("../models/Ticket.php");
        //     $ticket = new Ticket();
        
        //     if ($ticket->verificar_usuario_en_ticket($_SESSION["usu_id"], $tick_id)) {
        //         $path = "../public/document_detalle/$tick_id/$file";
                
        //         if (file_exists($path)) {
        //             header('Content-Type: application/octet-stream');
        //             header('Content-Disposition: inline; filename="'.$file.'"');
        //             header('Content-Length: ' . filesize($path));
        //             readfile($path);
        //             exit();
        //         } else {
        //             echo "Archivo no encontrado.";
        //         }
        //     } else {
        //         header("Location: ../../index.php");
        //         exit();
        //     }
        // break;   

        case "ver":
            session_start();
            if (!isset($_SESSION["usu_id"])) {
                header("Location: ../index.php");
                exit();
            }
        
            $tick_id = intval($_GET["tick_id"]);
            $file = basename($_GET["file"]);
        
            require_once("../models/Ticket.php");
            $ticket = new Ticket();
        
            if ($ticket->verificar_usuario_en_ticket($_SESSION["usu_id"], $tick_id)) {
                $path = "../public/document_detalle/$tick_id/$file";
        
                if (file_exists($path)) {
                    // Detectar tipo MIME real
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $path);
                    finfo_close($finfo);
        
                    // Limpiar buffer para evitar archivos dañados
                    if (ob_get_length()) {
                        ob_end_clean();
                    }
        
                    // Configurar encabezados según tipo de archivo
                    if (str_contains($mime, 'pdf') || str_contains($mime, 'image')) {
                        header("Content-Type: $mime");
                        header('Content-Disposition: inline; filename="' . $file . '"');
                    } else {
                        header("Content-Type: application/octet-stream");
                        header('Content-Disposition: attachment; filename="' . $file . '"');
                    }
        
                    header('Content-Length: ' . filesize($path));
                    readfile($path);
                    exit();
                } else {
                    echo "Archivo no encontrado.";
                }
            } else {
                header("Location: ../index.php");
                exit();
            }
        break;
        
        
        
    }
?>