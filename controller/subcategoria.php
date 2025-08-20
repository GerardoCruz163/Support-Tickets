<?php
    require_once("../config/conexion.php");
    require_once("../models/Subcategoria.php");
    $subcategoria = new Subcategoria();

    switch($_GET["op"]){

        //VERIFICACION SI EL TICKET SE AGREGA O SE MODIFICA
        case "guardaryeditar":
            //SE CONSULTA SI EXISTE LA SUBCATEGORIA CON LOS DATOS ENVIADOS
            $datos= $subcategoria->get_subcategoria_x_nom($_POST["cats_nom"], $_POST["cat_id"]); 
            if(count($datos)==0){   // SI NO EXISTE LA SUBCATEGORIA CON ESOS DATOS
                //ENTONCES
                if(empty($_POST["cats_id"])){ // LOS DATOS QUE ENVIAS ¿NO CONTIENEN UN cats_id?
                    // SI ES ASI, ENTONCES AGREGA UNA NUEVA SUBCATEGORIA
                    $subcategoria->insert_subcategoria($_POST["cat_id"],$_POST["cats_nom"]);     
                    echo "1"; //EMITE 1
                }else { // SI CONTIENEN UN cats_id, ENTONCES SOLO SE EDITARÁ
                    $subcategoria->update_subcategoria($_POST["cat_id"],$_POST["cats_nom"],$_POST["cats_id"]);
                    echo "2"; //EMITE 2
                }
            }else{// SI EXISTE LA SUBCATEGORIA CON ESOS DATOS
                echo "0";// EMITE 0 (EVITA DUPLICADOS) (DESACTIVADO POR EL MOMENTO)
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