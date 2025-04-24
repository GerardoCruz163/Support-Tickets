<?php
    class Ticket extends Conectar{

        public function insert_ticket($usu_id, $cat_id, $cats_id, $tick_titulo, $tick_descrip, $usu_asig, $prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="INSERT INTO tm_ticket (usu_id, cat_id, cats_id, tick_titulo, tick_descrip, tick_estado, fech_crea, usu_asig, fech_asig, prio_id,est) 
            VALUES (?,?,?,?,?,'Abierto',now(),?,now(),?,'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1,$usu_id);
            $sql->bindValue(2,$cat_id);
            $sql->bindValue(3,$cats_id);
            $sql->bindValue(4,$tick_titulo);
            $sql->bindValue(5,$tick_descrip);
            $sql->bindValue(6,$usu_asig);
            $sql->bindValue(7,$prio_id);
            $sql->execute();

            $sql1="select last_insert_id() as 'tick_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        public function listar_ticket_x_usu($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_area.area_nom,
                tm_categoria.cat_nom,
                tm_ticket.prio_id,
                tm_prioridad.prio_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_usuario.area_id = tm_area.area_id
                INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id
                WHERE
                tm_ticket.est = 1
                AND tm_usuario.usu_id=?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_x_id($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
            tm_ticket.tick_id,
            tm_ticket.usu_id,
            tm_ticket.cat_id,
            tm_ticket.cats_id,
            tm_ticket.tick_titulo,
            tm_ticket.tick_descrip,
            tm_ticket.tick_estado,
            tm_ticket.fech_crea,
            tm_ticket.fech_cierre,
            tm_ticket.tick_estre,
            tm_ticket.tick_coment,
            tm_area.area_nom,
            tm_usuario.usu_nom,
            tm_usuario.usu_ape,
            tm_usuario.usu_correo,
            tm_categoria.cat_nom,
            tm_subcategoria.cats_nom,
            tm_ticket.prio_id,
            tm_prioridad.prio_nom
            FROM 
            tm_ticket
            INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
            INNER join tm_subcategoria on tm_ticket.cats_id = tm_subcategoria.cats_id
            INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
            INNER join tm_area on tm_usuario.area_id = tm_area.area_id
            INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id
            WHERE
            tm_ticket.est = 1
            AND tm_ticket.tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                tm_ticket.tick_id,
                tm_ticket.usu_id,
                tm_ticket.cat_id,
                tm_ticket.tick_titulo,
                tm_ticket.tick_descrip,
                tm_ticket.tick_estado,
                tm_ticket.fech_crea,
                tm_ticket.fech_cierre,
                tm_ticket.usu_asig,
                tm_ticket.fech_asig,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_area.area_nom,
                tm_categoria.cat_nom,
                tm_ticket.prio_id,
                tm_prioridad.prio_nom
                FROM 
                tm_ticket
                INNER join tm_categoria on tm_ticket.cat_id = tm_categoria.cat_id
                INNER join tm_usuario on tm_ticket.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_usuario.area_id = tm_area.area_id
                INNER join tm_prioridad on tm_ticket.prio_id = tm_prioridad.prio_id

                WHERE
                tm_ticket.est = 1";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_tickdetalle_x_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                    td_ticketdetalle.tickd_id,
                    td_ticketdetalle.tickd_descrip,
                    td_ticketdetalle.fech_crea,
                    tm_usuario.usu_nom,
                    tm_usuario.usu_ape,
                    tm_usuario.rol_id
                FROM 
                    td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                WHERE 
                    tick_id =?
                    order by tickd_id";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle($tick_id,$usu_id,$tickd_descrip){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO td_ticketdetalle (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) VALUES (NULL,?,?,?,now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle_cerrar($tick_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="call sp_i_ticketdetalle_01(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle_cerrar_reabrir($tick_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
                $sql="INSERT INTO 
                td_ticketdetalle 
                (tickd_id,tick_id,usu_id,tickd_descrip,fech_crea,est) 
                VALUES 
                (NULL,?,?,'Ticket re-abierto',now(),'1');";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    tick_estado = 'Cerrado',
                    fech_cierre = now()
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function reabrir_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    tick_estado = 'Abierto'
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket_asignacion($tick_id,$usu_asig){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="UPDATE tm_ticket 
                set	
                    usu_asig = ?,
                    fech_asig = now()
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_total(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_ticket_totalabierto(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Abierto'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_totalcerrado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT COUNT(*) as TOTAL FROM tm_ticket where tick_estado='Cerrado'";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_grafico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT tm_categoria.cat_nom as nom,COUNT(*) AS total
                FROM   tm_ticket  JOIN  
                    tm_categoria ON tm_ticket.cat_id = tm_categoria.cat_id  
                WHERE    
                tm_ticket.est = 1
                GROUP BY 
                tm_categoria.cat_nom 
                ORDER BY total DESC";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function insert_encuesta($tick_id, $tick_estre, $tick_coment){  
            $conectar= parent::conexion();
            parent::set_names();
            $sql="update tm_ticket 
                set	
                    tick_estre = ?,
                    tick_coment = ?
                where
                    tick_id = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_estre);
            $sql->bindValue(2, $tick_coment);
            $sql->bindValue(3, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }

?>