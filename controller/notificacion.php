<?php
    require_once dirname(__DIR__ ,1) . '/config/conexion.php';
    require_once dirname(__DIR__, 1) . '/config/config.php';
    require_once("../models/Notificacion.php");
    $notificacion=new Notificacion();

    $key = $_ENV['APP_ENCRIPT_KEY'];
    $cipher = "aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch($_GET["op"]){
        case "mostrar";

            $datos=$notificacion->get_notificacion_x_usu($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["not_id"] = $row["not_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["not_mensaje"] = $row["not_mensaje"];

                    

                    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
                    $cifrado = openssl_encrypt($row["tick_id"], $cipher, $key, OPENSSL_RAW_DATA, $iv);
                    $encrypted_id = base64_encode($iv . $cifrado);

                    $output["tick_id"] = $encrypted_id;
                    $output["tick_id_real"] = $row["tick_id"];
                }
                echo json_encode($output);
            }   
        break;

        case "actualizar":
            $notificacion->update_notificacion_estado($_POST["not_id"]);
        break;

        // case "leido":
        //     $notificacion->update_notificacion_estado_read($_POST["not_id"]);
        // break;

        case "listar":
            $datos=$notificacion->get_notificacion_x_usu2($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                // $sub_array[] = $row["not_mensaje"]. ' ' . $row["tick_id"];
                
                $cifrado = openssl_encrypt($row["tick_id"], $cipher, $key,OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);
                
                $sub_array[] = '<a href="../../view/DetalleTicket/?ID='.$textoCifrado.'" data-real-id="'.$row["tick_id"].'" target="_blank">'.$row["not_mensaje"].'</a>';

                $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'" data-real-id="'.$row["tick_id"].'"  id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-pencil"></i></button>';
                $data[] = $sub_array;
            }
    
            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;
    }

?>