<?php
    require_once("../config/conexion.php");
    require_once("../models/Categoria.php");
    $categoria=new Categoria();

    switch($_GET["op"]){
        case "combo":
            $datos= $categoria->get_categoria();
            if(is_array($datos)==true and count($datos)>0){
                $html="<option></option>";
                foreach($datos as $row)
                {
                    $html.= "<option label='Seleccionar'></option>";
                    $html.= "<option value='".$row['cat_id']."'>".$row['cat_nom']."</option>";
                }
                echo $html;
            }
        break;

        case "guardaryeditar":
            if(empty($_POST["cat_id"])){
                $categoria->insert_categoria($_POST["cat_nom"]);  
            }else{
                $categoria->update_categoria($_POST["cat_id"],$_POST["cat_nom"]);
            }
        break;
    
        case "listar":
            $datos=$categoria->get_categoria();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cat_nom"];
                // $sub_array[] = $row["area_nom"];
                $sub_array[] = '<button type="button" onClick="editar('.$row["cat_id"].');"  id="'.$row["cat_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["cat_id"].');"  id="'.$row["cat_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $categoria->delete_categoria($_POST["cat_id"]);
        break;
    
        case "mostrar";
            $datos=$categoria->get_categoria_x_id($_POST["cat_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["cat_id"] = $row["cat_id"];
                    $output["cat_nom"] = $row["cat_nom"];
                }
                echo json_encode($output);
            }   
        break;
    }
?>