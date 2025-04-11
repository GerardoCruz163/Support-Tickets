<?php

require('../vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();
/* librerias necesarias para que el proyecto pueda enviar emails */
require('class.phpmailer.php');
include("class.smtp.php");

/* llamada de las clases necesarias que se usaran en el envio del mail */
require_once("../config/conexion.php");
require_once("../Models/Ticket.php");

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
        return $this->Send();
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
        return $this->Send();
    }

    public function ticket_asignado($tick_id){
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
        $this->FromName = $this->tu_nombre = "Se ha asignado un ticket: ".$id;
        $this->CharSet = 'UTF8';
        $this->addAddress($correo);
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

        $this->Body = $cuerpo;
        $this->AltBody = strip_tags("Ticket Cerrado");
        return $this->Send();
    }
}

?>
