<?php
    class Categoria extends Conectar{

        public function get_categoria(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_categoria
            JOIN tm_area on tm_categoria.area_id = tm_area.area_id
            WHERE est=1
            ORDER BY tm_categoria.area_id ASC;";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        // public function get_categoria(){
        //     $conectar= parent::conexion();
        //     parent::set_names();
        //     $sql="SELECT * FROM tm_categoria 
        //     Inner JOIN tm_area on tm_categoria.area_id = tm_area.area_id
        //     WHERE est=1;";
        //     $sql=$conectar->prepare($sql);
        //     $sql->execute();
        //     return $resultado=$sql->fetchAll();
        // }

        public function insert_categoria($cat_nom, $area_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_categoria (cat_id, cat_nom, area_id, est) VALUES (NULL,?,?,'1');";
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
            $sql="UPDATE tm_categoria set 
                cat_nom =?,
                area_id = ?
                WHERE
                cat_id =?";
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
            $sql="UPDATE tm_categoria 
                SET 
                est='0' 
                where cat_id=?";
            
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_categoria_x_id($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_categoria WHERE cat_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();    
            return $resultado=$sql->fetchAll();
        }

        public function get_categoria_x_nom($cat_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_categoria WHERE cat_nom = ? AND est = 1";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_nom);
            $sql->execute();    
            return $resultado=$sql->fetchAll();
        }

        public function get_categoria_x_nom_y_area($cat_nom, $area_id) {
            $conectar= parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM categoria WHERE cat_nom = ? AND area_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_nom);
            $sql->bindValue(2, $area_id);
            return $resultado=$sql->fetchAll();
        }
        
    }
?>