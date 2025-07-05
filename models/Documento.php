<?php
    class Documento extends Conectar{
        public function insert_documento($tick_id, $doc_nom){
            $conectar= parent::conexion();
            $sql ="call sp_insert_documento(?,?)";

            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->bindParam(2,$doc_nom);
            $sql->execute();
        }

        public function get_documento_x_ticket($tick_id){
            $conectar= parent::conexion();

            $sql="call sp_get_documento_x_ticket(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }
        public function insert_documento_detalle($tickd_id, $det_nom){
            $conectar= parent::conexion();
            $sql ="call sp_insert_documento_detalle(?,?)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tickd_id);
            $sql->bindParam(2,$det_nom);
            $sql->execute();
        }

        public function get_documento_detalle_x_ticketd($tickd_id){
            $conectar= parent::conexion();

            $sql="call sp_get_documento_detalle_x_ticketd(?)";
            $sql = $conectar->prepare($sql);
            $sql->bindParam(1,$tickd_id);
            $sql->execute();
            return $resultado=$sql->fetchAll(pdo::FETCH_ASSOC);
        }
    }


?>