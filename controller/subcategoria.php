<?php
    require_once("../config/conexion.php");
    require_once("../models/Subcategoria.php");
    $subcategoria = new Subcategoria();

    switch($_GET["op"]){

        case "guardaryeditar":
            $datos= $subcategoria->get_subcategoria_x_nom($_POST["cats_nom"], $_POST["cat_id"]);
            if(count($datos)==0){
                if(empty($_POST["cats_id"])){
                    $subcategoria->insert_subcategoria($_POST["cat_id"],$_POST["cats_nom"]);     
                    echo "1";
                }else {
                    $subcategoria->update_subcategoria($_POST["cat_id"],$_POST["cats_nom"],$_POST["cats_id"]);
                    echo "2";
                }
            }else{
                echo "0";
            }
        break;

        case "listar":
            $datos=$subcategoria->get_subcategoria_all();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["cats_nom"];
                $sub_array[] = $row["cat_nom"].' ('.$row["area_nom"].')';
                $sub_array[] = '<button type="button" onClick="editar('.$row["cats_id"].');"  id="'.$row["cats_id"].'" class="btn btn-inline btn-warning btn-sm ladda-button"><i class="fa fa-edit"></i></button>';
                $sub_array[] = '<button type="button" onClick="eliminar('.$row["cats_id"].');"  id="'.$row["cats_id"].'" class="btn btn-inline btn-danger btn-sm ladda-button"><i class="fa fa-trash"></i></button>';
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
            $subcategoria->delete_subcategoria($_POST["cats_id"]);
            break;

        case "mostrar";
            $datos=$subcategoria->get_subcategoria_x_id($_POST["cats_id"]);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["cats_id"] = $row["cats_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["cats_nom"] = $row["cats_nom"];
                }
                echo json_encode($output);
            }
            break;

        case "combo":
            $datos = $subcategoria->get_subcategoria($_POST["cat_id"]);
            $html="";
            $html.="<option value=''>Seleccionar</option>";
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $html.= "<option value='".$row['cats_id']."'>".$row['cats_nom']."</option>";
                }
                echo $html;
            }
            break;
    }
?>