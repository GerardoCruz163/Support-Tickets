<?php
    class Categoria extends Conectar{

        public function get_categoria(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_categorias";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }


        public function insert_categoria($cat_nom, $area_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_insert_categoria(?, ?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_nom);
            $sql->bindValue(2, $area_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // UPDATE
        public function update_categoria($cat_id,$cat_nom,$area_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_categoria(?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_nom);
            $sql->bindValue(2, $area_id);
            $sql->bindValue(3, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // DELETE
        public function delete_categoria($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_delete_categoria(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_categoria_x_id($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_cat_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();    
            return $resultado=$sql->fetchAll();
        }

        public function get_categoria_x_nom($cat_nom, $area_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_cat_x_nom(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_nom);
            $sql->bindValue(2, $area_id);
            $sql->execute();    
            return $resultado=$sql->fetchAll();
        }

        public function get_categoria_x_nom_y_area($cat_nom, $area_id) {
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "call sp_get_cat_x_nom_y_area(?, ?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_nom);
            $sql->bindValue(2, $area_id);
            return $resultado=$sql->fetchAll();
        }
        
    }
?>