<?php
    class Subcategoria extends Conectar{

        public function get_subcategoria($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_subcategoria(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_subcategoria_all(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_subcategoria_all";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Insert */
        public function insert_subcategoria($cat_id,$cats_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_insert_subcategoria(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cats_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_subcategoria($cat_id,$cats_nom,$cats_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_subcategoria(?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cats_nom);
            $sql->bindValue(3, $cats_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Delete */
        public function delete_subcategoria($cats_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_delete_subcategoria(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cats_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_subcategoria_x_id($cats_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_subcategoria_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cats_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_subcategoria_x_nom($cats_nom, $cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_subcategoria_x_nom(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cats_nom);
            $sql->bindValue(2, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>