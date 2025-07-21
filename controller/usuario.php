<?php
    require_once("../config/conexion.php");
    require_once("../models/Usuario.php");
    $usuario=new Usuario();

    require_once("../models/Email.php");
    $email=new Email();

    //ENCRIPTADO DE LA CONTRASEÑA 
    $key = "mi_key_secret";
    $cipher = "aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch($_GET["op"]){
        case "guardaryeditar":
            $datos= $usuario->get_usuario_x_correo($_POST["usu_correo"]);

            if(empty($_POST["usu_id"])){
                // Agregar nuevo usuario
                if(count($datos) == 0){
                    $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["area_id"], $_POST["suc_id"]);
                    echo "1";
                }else {
                    echo "0"; // correo ya existe
                }
            } else {
                // Editar usuario existente
                // Verificar si el correo pertenece a otro usuario
                if($datos[0]["usu_id"] == $_POST["usu_id"]){
                    $usuario->update_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["area_id"], $_POST["suc_id"], $_POST["usu_id"]);
                    echo "2";
                } else {
                    echo "0"; // correo duplicado en otro usuario
                }
            }

            // if(count($datos)==0){
            //     if(empty($_POST["usu_id"])){
            //         $usuario->insert_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["area_id"], $_POST["suc_id"]);  
            //         echo "1";
            //     } else {
            //         $usuario->update_usuario($_POST["usu_nom"],$_POST["usu_ape"],$_POST["usu_correo"],$_POST["usu_pass"],$_POST["rol_id"],$_POST["area_id"], $_POST["suc_id"], $_POST["usu_id"]);
            //         echo "2";
            //     }
            // }else{
            //     echo "0";
            // }
        break;

        case "listar":
            $datos=$usuario->get_usuario();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["usu_nom"];
                $sub_array[] = $row["usu_ape"];
                $sub_array[] = $row["usu_correo"];
                $sub_array[] = $row["usu_pass"];
                
                if($row["rol_id"]=="1"){
                    $sub_array[] = '<span class="label label-pill label-primary">Usuario</span>';
                }else if($row["rol_id"]=="2"){
                    $sub_array[] = '<span class="label label-pill label-info aquamarine">Supervisor</span>';
                }else{
                    $sub_array[] = '<span class="label label-pill label-default ">Administrador</span>';
                }

                if($row["suc_id"] == "1"){
                    $sub_array[] = 'Nuevo Laredo';
                }else if($row["suc_id"] == "2"){
                    $sub_array[] = 'Manzanillo';
                }else if($row["suc_id"] == "3"){
                    $sub_array[] = 'Veracruz';
                }else if($row["suc_id"] == "4"){
                    $sub_array[] = 'Altamira';
                }else if($row["suc_id"] == "5"){
                    $sub_array[] = 'AICM';
                }else if($row["suc_id"] == "6"){
                    $sub_array[] = 'AIFA';
                }
                $sub_array[] = $row["area_nom"];

                $sub_array[] = '<button type="button" onClick="editar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["usu_id"].');"  id="'.$row["usu_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "eliminar":
            $usuario->delete_usuario($_POST["usu_id"]);
        break;

        case "mostrar";
            $datos=$usuario->get_usuario_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["usu_id"] = $row["usu_id"];
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["usu_correo"] = $row["usu_correo"];

                    $iv_dec = substr(base64_decode($row["usu_pass"]), 0, openssl_cipher_iv_length($cipher));
                    $cifradoSinIV = substr(base64_decode($row["usu_pass"]), openssl_cipher_iv_length($cipher));
                    $descifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                    $output["usu_pass"] = $descifrado;
                    $output["rol_id"] = $row["rol_id"];
                    $output["area_id"] = $row["area_id"];
                    $output["suc_id"] = $row["suc_id"];
                }
                echo json_encode($output);
            }   
        break;

        case "total";
            $datos=$usuario->get_usuario_total_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output); 

            }
        break;

        case "totalabierto";
            $datos=$usuario->get_usuario_totalabierto_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output); 

            }
        break;

        case "totalcerrado";
            $datos=$usuario->get_usuario_totalcerrado_x_id($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output); 

            }
        break;

        case "grafico";
            $datos=$usuario->get_usuario_grafico($_POST["usu_id"]);  
            echo json_encode($datos);
        break;

        case "combo";
            $datos = $usuario->get_usuario_x_rol();
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['usu_id']."'>".$row['usu_nom'].' '.$row['usu_ape']."</option>";
                }
                echo $html;
            }
        break;

        case "combo_usuarios";
            $datos = $usuario->get_usuario();
            if(is_array($datos)==true and count($datos)>0){
                $html.= "<option label='Seleccionar'></option>";
                foreach($datos as $row){
                    $html.= "<option value='".$row['usu_id']."'>".$row['usu_nom'].' '.$row['usu_ape']."</option>";
                }
                echo $html;
            }
        break;
        
        case "combo_soporte":

            $datos = $usuario->get_usuario_x_area_cat($_POST["cat_id"], $_POST["usu_id"]);
            $html = "<option label='Seleccionar'></option>";
            if(is_array($datos) && count($datos) > 0){
                foreach($datos as $row){
                    $html .= "<option value='".$row['usu_id']."'>".$row['usu_nom']." ".$row['usu_ape']."</option>";
                }
            }
            echo $html;
        break;
        
        //CONTROLLER PARA ACTUALIZAR LA CONTRASENA
        case "password":
            $cifrado = openssl_encrypt($_POST["usu_pass"], $cipher, $key,OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $usuario->update_usuario_pass($textoCifrado,$_POST["usu_id"]);
        break;

        case "correo";
            $datos=$usuario->get_usuario_x_correo($_POST["usu_correo"]);  
            if(is_array($datos)==true and count($datos)>0){
                echo "Existe";
            }else{
                echo "error";
            }
        break;
    }
?>