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
                // $sub_array[] = '<a href="../../public/document/'.$descifrado.'/'.$row["doc_nom"].'" target="_blank">'.$row["doc_nom"].'</a>';
                // $sub_array[] = '<a type="button" href="../../public/document/'.$descifrado.'/'.$row["doc_nom"].'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                $sub_array[] = '<a href="../../controller/ver_documento.php?id=' . $descifrado . '&archivo=' . urlencode($row["doc_nom"]) . '" target="_blank">' . $row["doc_nom"] . '</a>';

                $sub_array[] = '<a type="button" href="../../controller/ver_documento.php?id=' . $descifrado . '&archivo=' . urlencode($row["doc_nom"]).'" target="_blank" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-eye"></i></a>';
                
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
        
    }

?>