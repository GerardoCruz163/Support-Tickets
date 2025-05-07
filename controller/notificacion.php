<?php
    require_once("../config/conexion.php");
    require_once("../models/Notificacion.php");
    $notificacion=new Notificacion();

    switch($_GET["op"]){
        case "mostrar";
            $datos=$notificacion->get_notificacion_x_usu($_POST["usu_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["not_id"] = $row["not_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["not_mensaje"] = $row["not_mensaje"]. ' ' . $row["tick_id"];
                    $output["tick_id"] = $row["tick_id"];
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
                $sub_array[] = $row["not_mensaje"]. ' ' . $row["tick_id"]   ;
                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-info btn-sm ladda-button"><i class="fa fa-eye"></i></button>';
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