<?php
    class Subcategoria extends Conectar{

        public function get_subcategoria($cat_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_subcategoria WHERE cat_id = ? and est=1;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_subcategoria_all(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            tm_subcategoria.cats_id,
            tm_subcategoria.cat_id,
            tm_subcategoria.cats_nom,
            tm_categoria.cat_nom
            FROM tm_subcategoria INNER JOIN
            tm_categoria on tm_subcategoria.cat_id = tm_categoria.cat_id
            WHERE tm_subcategoria.est=1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Insert */
        public function insert_subcategoria($cat_id,$cats_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_subcategoria (cats_id,cat_id,cats_nom,est) VALUES (NULL,?,?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $cats_nom);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Update */
        public function update_subcategoria($cats_id,$cat_id,$cats_nom){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_subcategoria set
                cat_id = ?,
                cats_nom = ?
                WHERE
                cats_id = ?";
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
            $sql="UPDATE tm_subcategoria SET
                est = 0
                WHERE 
                cats_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cats_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        /* TODO:Registro x id */
        public function get_subcategoria_x_id($cats_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_subcategoria WHERE cats_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cats_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>