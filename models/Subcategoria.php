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
    }
?>