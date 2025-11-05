<?php

// require('../vendor/autoload.php');
// $dotenv = Dotenv\Dotenv::createImmutable('../');
// $dotenv->load();
/* librerias necesarias para que el proyecto pueda enviar emails */
// require('class.phpmailer.php');
// include("class.smtp.php");

require '../include/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/* llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../Models/Ticket.php");
require_once("../Models/Usuario.php");

class Email extends PHPMailer{
    protected $gCorreo = 'logistica@tecnologisticaaduanal.com';
    protected $gContrasena = 'Tecno*Julio';

    public function ticket_abierto($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $area = $row["area_nom"];
            $titulo=$row["tick_titulo"];
            $categoria=$row["cat_nom"];
            $correo=$row["usu_correo"]; 
        }
        $this->isSMTP();
        $this->Host = 'vmail.globalpc.net';//Aqui el server
        $this->Port = 465;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'ssl';
        $this->FromName = $this->tu_nombre = $usu." haz generado un nuevo ticket: ".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Abierto";
        //Igual//
        $cuerpo = file_get_contents('../public/NuevoTicket.html'); /*ruta del template en formato HTML */
        /*parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblArea", $area, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Abierto");

        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function ticket_cerrado($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);
        foreach($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $area = $row["area_nom"];
            $titulo=$row["tick_titulo"];
            $categoria=$row["cat_nom"];
            $correo=$row["usu_correo"]; 
        }

        $usuario = new Usuario();
        $datos2 = $usuario->get_usuario_x_id($datos[0]["usu_asig"]); //USUARIO ASIGNADO AL TICKET


        $this->isSMTP();
        $this->Host = 'vmail.globalpc.net';//Aqui el server
        $this->Port = 465;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'ssl';
        $this->FromName = $this->tu_nombre = "Se ha cerrado tu ticket: ".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->addAddress($datos2[0]["usu_correo"]); // ENVIAR CORREO AL USUARIO QUE SE LE ASIGNO AL TICKET
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Cerrado";
        //Igual//
        $cuerpo = file_get_contents('../public/CerradoTicket.html'); /*ruta del template en formato HTML */
        /*parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblArea", $area, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");

        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function ticket_asignado_seguidor($tick_id){
        //OBTENER TICKETSEGUIDOR
        $ticketSeguidor = new Ticket();
        $datos = $ticketSeguidor->listar_ticket_seguidor($tick_id);

        foreach($datos as $row){
            $correoSeg = $row["usu_correo"];
            echo $correoSeg;
        }

        //OBTENER USUARIO QUE HIZO EL TICKET
        $ticket = new Ticket();
        $datos2 = $ticket->listar_ticket_x_id($tick_id);

        foreach($datos2 as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $ape = $row["usu_ape"];
            $area = $row["area_nom"];
            $titulo=$row["tick_titulo"];
            $categoria=$row["cat_nom"];
            //$correo=$row["usu_correo"]; 
        }

        $this->isSMTP();
        $this->Host = 'vmail.globalpc.net';//Aqui el server
        $this->Port = 465;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'ssl';
        $this->FromName = $this->tu_nombre = "Se le ha asignado a un ticket como seguidor: ".$id;
        $this->CharSet = 'UTF8';
        //$this->addAddress($correo);
        //$this->addAddress($datos[0]["usu_correo"]); // ENVIAR CORREO AL USUARIO QUE SE LE ASIGNO AL TICKET COMO SEGUIDOR

        //RECORRE LOS USUARIOS ASIGNADOS PARA ENVIAR EL CORREO DE UNO EN UNO
        foreach($datos as $row){
            $this->addAddress($row["usu_correo"]);
        }

        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Asignado";
        //Igual//
        $cuerpo = file_get_contents('../public/AsignarTicket.html'); /*ruta del template en formato HTML */
        /*parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblArea", $area, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        $cuerpo = str_replace("lblUsuSop", $usu, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");

        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }

    }

    public function ticket_asignado($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);

        $usuario = new Usuario();
        $datos2 = $usuario->get_usuario_x_id($datos[0]["usu_asig"]); //USUARIO ASIGNADO AL TICKET

        foreach($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $area = $row["area_nom"];
            $titulo=$row["tick_titulo"];
            $categoria=$row["cat_nom"];
            //$correo=$row["usu_correo"]; 
        }

        // foreach($datos2 as $row){
        //     $nom_usu= $row["usu_nom"];
        //     $ape_usu= $row["usu_ape"];
        // }

        $this->isSMTP();
        $this->Host = 'vmail.globalpc.net';//Aqui el server
        $this->Port = 465;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'ssl';
        $this->FromName = $this->tu_nombre = "Se ha asignado un ticket: ".$id;
        $this->CharSet = 'UTF8';
        //$this->addAddress($correo);
        $this->addAddress($datos2[0]["usu_correo"]); // ENVIAR CORREO AL USUARIO QUE SE LE ASIGNO AL TICKET
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket Asignado";
        //Igual//
        $cuerpo = file_get_contents('../public/AsignarTicket.html'); /*ruta del template en formato HTML */
        /*parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblArea", $area, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        //$cuerpo = str_replace("lblUsuSop", $nom_usu+' '+$ape_usu, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");

        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function ticket_comentario($tick_id){
        $ticket = new Ticket();
        $datos = $ticket->listar_ticket_x_id($tick_id);

        $usuario = new Usuario();
        $datos2 = $usuario->get_usuario_x_id($datos[0]["usu_asig"]); //USUARIO ASIGNADO AL TICKET

        $datoscoment = $ticket->get_ultimo_coment_tickdetalle($tick_id); // OBTENGO EL ULTIMO MENSAJE ENVIADO

        foreach($datos as $row){
            $id = $row["tick_id"];
            $usu = $row["usu_nom"];
            $area = $row["area_nom"];
            $titulo=$row["tick_titulo"];
            $categoria=$row["cat_nom"];
            $descripcion=$row["tick_descrip"];
            $correo=$row["usu_correo"]; 
        }

        foreach ($datoscoment as $row) {
            $usu_coment =  $row["usu_nom"] . " " . $row["usu_ape"];
            $tick_coment = $row["tickd_descrip"];
        }

        // foreach($datos2 as $row){
        //     $nom_usu= $row["usu_nom"];
        //     $ape_usu= $row["usu_ape"];
        // }

        $this->isSMTP();
        $this->Host = 'vmail.globalpc.net';//Aqui el server
        $this->Port = 465;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'ssl';
        $this->FromName = $this->tu_nombre = "Tienes una respuesta en el ticket: ".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
        $this->addAddress($datos2[0]["usu_correo"]); // ENVIAR CORREO AL USUARIO QUE SE LE ASIGNO AL TICKET
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "Ticket comentado";
        //Igual//
        $cuerpo = file_get_contents('../public/ComentarioTicket.html'); /*ruta del template en formato HTML */
        /*parametros del template a remplazar */
        $cuerpo = str_replace("xnroticket", $id, $cuerpo);
        $cuerpo = str_replace("lblNomUsu", $usu, $cuerpo);
        $cuerpo = str_replace("lblArea", $area, $cuerpo);
        $cuerpo = str_replace("lblTitu", $titulo, $cuerpo);
        $cuerpo = str_replace("lblCate", $categoria, $cuerpo);
        $cuerpo = str_replace("lblName", $usu_coment, $cuerpo);
        $cuerpo = str_replace("lblComent", $tick_coment, $cuerpo);
        //$cuerpo = str_replace("lblUsuSop", $nom_usu+' '+$ape_usu, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");

        try{
            $this->Send();
            return true;
        }catch(Exception $e){
            return false;
        }
    }

    public function recuperar_contrasena($usu_correo){
        $usuario = new Usuario();

        $usuario->get_cambiar_contra_recuperar($usu_correo);

        $datos = $usuario->get_usuario_x_correo($usu_correo);
        foreach($datos as $row){
            $usu_id = $row["usu_id"];
            $usu_ape = $row["usu_ape"];
            $usu_nom = $row["usu_nom"];
            $correo=$row["usu_correo"];
            $usu_pass= $row["usu_pass"]; 
        }
        $this->isSMTP();
        $this->Host = 'vmail.globalpc.net';//Aqui el server
        $this->Port = 465;//Aqui el puerto
        $this->SMTPAuth = true;
        $this->Username = $this->gCorreo;
        $this->Password = $this->gContrasena;
        $this->From = $this->gCorreo;
        $this->SMTPSecure = 'ssl';
        $this->FromName = $this->tu_nombre = $usu_nom." recupera tu contraseña.";
        $this->CharSet = 'UTF8';
        $this->addAddress($usu_correo);
        $this->WordWrap = 50;
        $this->IsHTML(true);
        $this->Subject = "TLA SuTra: Recuperación de contraseña.";
        //Igual//
        $cuerpo = file_get_contents('../public/RecuperarContra.html'); /*ruta del template en formato HTML */
        /*parametros del template a remplazar */
       
        $cuerpo = str_replace("xusunom", $usu_nom, $cuerpo);
        $cuerpo = str_replace("xusuape", $usu_ape, $cuerpo);
        $cuerpo = str_replace("xnuevopass", $usu_pass, $cuerpo);

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Recuperación de contraseña");

        try{
            $this->Send();

            $usuario-> encriptar_nueva_contra($usu_pass,$usu_id);
            return true;
        }catch(Exception $e){
            return false;
        }
    } 
}

?>
