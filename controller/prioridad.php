<?php
    require_once("../config/conexion.php");
    require_once("../models/Prioridad.php");
    $prioridad=new Prioridad();

    switch($_GET["op"]){
        case "combo":
            $datos= $prioridad->get_prioridad();
            if(is_array($datos)==true and count($datos)>0){
                $html="<option></option>";
                foreach($datos as $row)
                {
                    $html.= "<option label='Seleccionar'></option>";
                    $html.= "<option value='".$row['prio_id']."'>".$row['prio_nom']."</option>";
                }
                echo $html;
            }
        break;

        case "guardaryeditar":
            if(empty($_POST["prio_id"])){
                $prioridad->insert_prioridad($_POST["prio_nom"]);  
            }else{
                $prioridad->update_prioridad($_POST["prio_id"],$_POST["prio_nom"]);
            }
        break;
    
        case "listar":
            $datos=$prioridad->get_prioridad();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["prio_nom"];
                
                $sub_array[] = '<button type="button" onClick="editar('.$row["prio_id"].');"  id="'.$row["prio_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["prio_id"].');"  id="'.$row["prio_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $prioridad->delete_prioridad($_POST["prio_id"]);
        break;
    
        case "mostrar";
            $datos=$prioridad->get_prioridad_x_id($_POST["prio_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["prio_id"] = $row["prio_id"];
                    $output["prio_nom"] = $row["prio_nom"];
                }
                echo json_encode($output);
            }   
        break;
    }

?>