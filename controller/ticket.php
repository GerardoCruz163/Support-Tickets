<?php
    require_once("../config/conexion.php");
    require_once("../models/Ticket.php");
    $ticket=new Ticket();

    require_once("../models/Usuario.php");
    $usuario= new Usuario();

    require_once("../models/Documento.php");
    $documento= new Documento();

    $key = "mi_key_secret";
    $cipher = "aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));

    switch($_GET["op"]){

        case "insert":
            $datos=$ticket->insert_ticket($_POST["usu_id"],$_POST["cat_id"],$_POST["cats_id"],$_POST["tick_titulo"],$_POST["tick_descrip"], $_POST["usu_asig"], $_POST["prio_id"]);
                {
                foreach ($datos as $row){
                    $output["tick_id"] = $row["tick_id"];

                    if (!isset($_FILES['files']) || empty($_FILES['files']['name'][0])){

                    }else{
                        $countfiles = count($_FILES['files']['name']);
                        $ruta = "../public/document/".$output["tick_id"]."/";
                        $files_arr = array();

                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }

                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento( $output["tick_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
        break;

        case "update":
            $ticket->update_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrar($_POST["tick_id"], $_POST["usu_id"]);
        break;

        case "reabrir":
            $ticket->reabrir_ticket($_POST["tick_id"]);
            $ticket->insert_ticketdetalle_cerrar_reabrir($_POST["tick_id"], $_POST["usu_id"]);
        break;

        case "asignar":
            $ticket->update_ticket_asignacion($_POST["tick_id"],$_POST["usu_asig"]);
        break;

        case "listar_x_usu":
            $datos=$ticket->listar_ticket_x_usu($_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                
                if($row["prio_nom"] == "Bajo"){
                    $sub_array[] = '<span class="label label-pill label-success">Bajo</span>';
                }else if($row["prio_nom"] == "Medio"){
                    $sub_array[] = '<span class="label label-pill label-warning">Medio</span>';
                }else if($row["prio_nom"] == "Alto"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
                }

                $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_crea"]));
                $sub_array[] = $row["usu_nom"].' '.$row["usu_ape"];
                $sub_array[] = $row["area_nom"];
                if($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class="label label-pill label-success">ABIERTO</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">CERRADO</span></a>';
                }

                if($row["fech_asig"]==null){    
                    $sub_array[] = '<span class="label label-pill label-defualt">--/--/----</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_asig"]));
                }
                if($row["fech_cierre"]==null){
                    $sub_array[] = '<span class ="label label-pill label-default">Sin cerrar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_cierre"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<span class="label label-pill label-warning">Sin asignar</span>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].' '.$row1["usu_ape"].'</span>';
                    }
                }

                $cifrado = openssl_encrypt($row["tick_id"], $cipher, $key,OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);
                $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'"  id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-pencil"></i></button>';
                
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar":
            $datos=$ticket->listar_ticket();
            $data= Array();
            foreach($datos as $row){
                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if($row["prio_nom"] == "Bajo"){
                    $sub_array[] = '<span class="label label-pill label-success">Bajo</span>';
                }else if($row["prio_nom"] == "Medio"){
                    $sub_array[] = '<span class="label label-pill label-warning">Medio</span>';
                }else if($row["prio_nom"] == "Alto"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
                }

                $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_crea"]));
                $sub_array[] = $row["usu_nom"].' '.$row["usu_ape"];
                $sub_array[] = $row["area_nom"];

                if($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class ="label label-pill label-success">ABIERTO</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">CERRADO</span></a>';
                }

                if($row["fech_asig"]==null){
                    $sub_array[] = '--/--/---- --:--';
                }else{
                    $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_asig"]));
                }
                if($row["fech_cierre"]==null){
                    $sub_array[] = '<span class ="label label-pill label-default">Sin cerrar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_cierre"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning"><i class="fa fa-plus-circle" aria-hidden="true"></i> Asignar soporte</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].' '.$row1["usu_ape"].'</span>';
                    }
                }
                
                $sub_array[] = '<button type="button" onClick="ver('.$row["tick_id"].');"  id="'.$row["tick_id"].'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-pencil"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listar_filtro":
            $datos=$ticket->filtrar_ticket($_POST["tick_titulo"], $_POST["cat_id"],$_POST["prio_id"], $_POST["usu_id"]);
            $data= Array();
            foreach($datos as $row){
                

                $sub_array = array();
                $sub_array[] = $row["tick_id"];
                $sub_array[] = $row["cat_nom"];
                $sub_array[] = $row["tick_titulo"];

                if($row["prio_nom"] == "Bajo"){
                    $sub_array[] = '<span class="label label-pill label-success">Bajo</span>';
                }else if($row["prio_nom"] == "Medio"){
                    $sub_array[] = '<span class="label label-pill label-warning">Medio</span>';
                }else if($row["prio_nom"] == "Alto"){
                    $sub_array[] = '<span class="label label-pill label-danger">Alto</span>';
                }

                $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_crea"]));
                $sub_array[] = $row["usu_nom"].' '.$row["usu_ape"];
                $sub_array[] = $row["area_nom"];

                if($row["tick_estado"]=="Abierto"){
                    $sub_array[] = '<span class ="label label-pill label-success">ABIERTO</span>';
                }else{
                    $sub_array[] = '<a onClick="CambiarEstado('.$row["tick_id"].')"><span class="label label-pill label-danger">CERRADO</span></a>';
                }

                if($row["fech_asig"]==null){
                    $sub_array[] = '--/--/---- --:--';
                }else{
                    $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_asig"]));
                }
                if($row["fech_cierre"]==null){
                    $sub_array[] = '<span class ="label label-pill label-default">Sin cerrar</span>';
                }else{
                    $sub_array[] = date("d/m/Y H:i", strtotime($row["fech_cierre"]));
                }

                if($row["usu_asig"]==null){
                    $sub_array[] = '<a onClick="asignar('.$row["tick_id"].');"><span class="label label-pill label-warning"><i class="fa fa-plus-circle" aria-hidden="true"></i> Asignar soporte</span></a>';
                }else{
                    $datos1=$usuario->get_usuario_x_id($row["usu_asig"]);
                    foreach($datos1 as $row1){
                        $sub_array[] = '<span class="label label-pill label-success">'.$row1["usu_nom"].' '.$row1["usu_ape"].'</span>';
                    }
                }

                $cifrado = openssl_encrypt($row["tick_id"], $cipher, $key,OPENSSL_RAW_DATA, $iv);
                $textoCifrado = base64_encode($iv . $cifrado);

                $sub_array[] = '<button type="button" data-ciphertext="'.$textoCifrado.'"  id="'.$textoCifrado.'" class="btn btn-inline btn-primary btn-sm ladda-button"><i class="fa fa-pencil"></i></button>';
                $data[] = $sub_array;
            }

            $results = array(
                "sEcho"=>1,
                "iTotalRecords"=>count($data),
                "iTotalDisplayRecords"=>count($data),
                "aaData"=>$data);
            echo json_encode($results);
        break;

        case "listardetalle":
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $descifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$ticket->listar_tickdetalle_x_ticket($descifrado);
            ?>
                <?php
                    foreach($datos as $row){
                        ?>
                        <h1></h1>
                            <article class="activity-line-item box-typical">
                                <div class="activity-line-date">
                                    <?php echo date("d/m/Y H:i", strtotime($row["fech_crea"])); ?>
                                </div>
                                <header class="activity-line-item-header">
                                    <div class="activity-line-item-user">
                                        <div class="activity-line-item-user-photo">
                                            <a href="#">
                                                <img src="../../public/img/<?php echo $row['rol_id']?>.png" alt="">

                                            </a>
                                        </div>
                                        <div class="activity-line-item-user-name"><?php echo $row['usu_nom'].' '.$row['usu_ape']?></div>
                                        <div class="activity-line-item-user-status">
                                            
                                        <?php 
                                            if($row['rol_id']==1){
                                                echo 'Usuario';
                                            }else{
                                                echo 'Soporte';
                                            }
                                        ?>
                                        
                                        </div>

                                        
                                    </div>
                                </header>
                                <div class="activity-line-action-list">
                                    <section class="activity-line-action">
                                    <div class="time"><?php echo date("H:i", strtotime($row["fech_crea"])); ?></div>
                                    <div class="cont">
                                        <div class="cont-in">
                                            <p>
                                                <?php echo $row['tickd_descrip'];?>
                                            </p>	

                                            <br>
                                            
                                            <?php
                                                $datos_det= $documento->get_documento_detalle_x_ticketd($row["tickd_id"]);
                                                if(is_array($datos_det)==true and count($datos_det)>0){
                                                    ?>
                                                        <p><strong>Documentos adjuntos</strong></p>

                                                        <p>
                                                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 60%;">Nombre</th>
                                                                        <th style="width: 40%;"></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                        foreach($datos_det as $row_det){

                                                                        }
                                                                    ?>
                                                                    <td><i class="fa fa-paperclip" aria-hidden="true"></i>
                                                                        <?php echo $row_det["det_nom"];?>
                                                                    </td>
                                                                    <td>
                                                                        
                                                                        <a href="../../public/document_detalle/<?php echo $row_det["tickd_id"];?>/<?php echo $row_det["det_nom"];?>" target="_blank" class="btn btn-inline btn-primary btn-sm">
                                                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                                                            Ver
                                                                        </a>
                                                                    </td>

                                                                </tbody>
                                                            </table>
                                                        </p>  
                                                    <?php
                                                }
                                            ?>
                                            
                                        </div>
                                    </div>
                                </section><!--.activity-line-action-->

                                
                                </div>
                            </article>
                        <?php
                    }
                ?>
            <?php
        break;

        case "mostrar";
            $iv_dec = substr(base64_decode($_POST["tick_id"]), 0, openssl_cipher_iv_length($cipher));
            $cifradoSinIV = substr(base64_decode($_POST["tick_id"]), openssl_cipher_iv_length($cipher));
            $descifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

            $datos=$ticket->listar_ticket_x_id($descifrado);  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["tick_id"] = $row["tick_id"];
                    $output["usu_id"] = $row["usu_id"];
                    $output["cat_id"] = $row["cat_id"];
                    $output["tick_titulo"] = $row["tick_titulo"];
                    $output["tick_descrip"] = $row["tick_descrip"];

                    if ($row["tick_estado"]=="Abierto"){
                        $output["tick_estado"] = '<span class="label label-pill label-success">Abierto</span>';
                    }else{
                        $output["tick_estado"] = '<span class="label label-pill label-danger">Cerrado</span>';
                    }

                    $output["tick_estado_texto"] = $row["tick_estado"];
                    $output["area_nom"] = $row["area_nom"];

                    $output["fech_crea"] = date("d/m/Y H:i", strtotime($row["fech_crea"]));
                    $output["fech_cierre"] = date("d/m/Y H:i", strtotime($row["fech_cierre"]));
                    $output["usu_nom"] = $row["usu_nom"];
                    $output["usu_ape"] = $row["usu_ape"];
                    $output["cat_nom"] = $row["cat_nom"];
                    $output["cats_nom"] = $row["cats_nom"];
                    $output["tick_estre"] = $row["tick_estre"];
                    $output["tick_coment"] = $row["tick_coment"];
                    $output["prio_nom"] = $row["prio_nom"];
                }
                echo json_encode($output);
            }   
        break;

        case "insertdetalle":
            $datos=$ticket->insert_ticketdetalle($_POST["tick_id"],$_POST["usu_id"],$_POST["tickd_descrip"]);
            if (is_array($datos)==true and count($datos)>0){
                foreach($datos as $row){
                    //obtener tickd_id de $datos
                    $output["tickd_id"] = $row["tickd_id"];
                    //se verifica si hay archivos desde vista
                    if (!isset($_FILES['files']) || empty($_FILES['files']['name'][0])){

                    }else{
                        //contar registros
                        $countfiles = count($_FILES['files']['name']);
                        //ruta de los documentos
                        $ruta = "../public/document_detalle/".$output["tickd_id"]."/";
                        //arreglo de archivos
                        $files_arr = array();

                        //verifica si la ruta existe
                        if (!file_exists($ruta)) {
                            //en caso de no existir, la crea
                            mkdir($ruta, 0777, true);
                        }

                        //recorrer todos los registros
                        for ($index = 0; $index < $countfiles; $index++) {
                            $doc1 = $_FILES['files']['tmp_name'][$index];
                            $destino = $ruta.$_FILES['files']['name'][$index];

                            $documento->insert_documento_detalle( $output["tickd_id"],$_FILES['files']['name'][$index]);

                            move_uploaded_file($doc1,$destino);
                        }
                    }
                }
            }
            echo json_encode($datos);
        break;

        case "total";
            $datos=$ticket->get_ticket_total();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output); 

            }
        break;

        case "totalabierto":
            $datos=$ticket->get_ticket_totalabierto();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output); 

            }
        break;

        case "totalcerrado":
            $datos=$ticket->get_ticket_totalcerrado();  
            if(is_array($datos)==true and count($datos)>0){
                foreach($datos as $row)
                {
                    $output["TOTAL"] = $row["TOTAL"];
                }
                echo json_encode($output); 

            }
        break;

        case "grafico":
            $datos=$ticket->get_ticket_grafico();  
            echo json_encode($datos);
        break;

        case "encuesta":
            $datos=$ticket->insert_encuesta($_POST["tick_id"], $_POST["tick_estre"],$_POST["tick_coment"]);  
        break;
    }
?>