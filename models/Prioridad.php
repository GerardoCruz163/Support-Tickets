<?php
    class Prioridad extends Conectar{

        public function get_prioridad(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_prioridad";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // INSERT   
        public function insert_prioridad($prio_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_insert_prioridad(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // UPDATE
        public function update_prioridad($prio_nom,$prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_prioridad(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_nom);
            $sql->bindValue(2, $prio_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // DELETE
        public function delete_prioridad($prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_delete_prioridad(?)";
            
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_prioridad_x_id($prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_prioridad_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_id);
            $sql->execute();    
            return $resultado=$sql->fetchAll();
        }

        public function get_prioridad_x_nom($prio_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_prioridad_x_nom(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $prio_nom);
            $sql->execute();    // linea 64
            return $resultado=$sql->fetchAll();
        }
    }
?>