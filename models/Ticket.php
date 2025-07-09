<?php
    class Ticket extends Conectar{

        public function insert_ticket($usu_id, $cat_id, $cats_id, $tick_titulo, $tick_descrip, $usu_asig, $prio_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_insert_ticket(?,?,?,?,?,?,?)";
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
            $sql="call sp_listar_ticket_x_usu(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_x_id($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_ticket_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_asig_x_usu($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_ticket_asig_x_usu(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_ticket";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
   
        public function listar_tickdetalle_x_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_tickdetalle_x_ticket(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function insert_ticketdetalle($tick_id,$usu_id,$tickd_descrip){
            $conectar= parent::conexion();
            parent::set_names();
            //OBTENER EL USUARIO ASIGNADO
            $ticket = new Ticket();
            $datos = $ticket->listar_ticket_x_id($tick_id);
            foreach($datos as $row){
                $usu_asig = $row["usu_asig"];
                $usu_crea = $row["usu_id"];
            }

            //si el usuario es quien fue asignado al ticket, la notificacion va para el que la creo
            if($_SESSION["usu_id"]== $usu_asig){
                //GUARDAR NOTIFICACION DE NUEVO COMENTARIO
                $sql0="call sp_guardar_notificacion($usu_crea, $tick_id)";
                $sql0=$conectar->prepare($sql0);
                $sql0->execute();

            //si el usuario es quien creó el ticket, la notificacion va para quien fue asignado
            }else if($_SESSION["usu_id"]== $usu_crea){
                //GUARDAR NOTIFICACION DE NUEVO COMENTARIO
                $sql0="call sp_guardar_notificacion($usu_asig, $tick_id)";
                $sql0=$conectar->prepare($sql0);
                $sql0->execute();
                
            }

            // TODO: Devuelve el ultimo ID ticket ingresado
            $sql="call sp_insert_ticketdetalle(?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute();
            
            $sql1="select last_insert_id() as 'tickd_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();

            
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
            
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
                $sql="call sp_insert_ticketdetalle_cerrar_reabrir(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_ticket_cerrar(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function reabrir_ticket($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_reabrir_ticket(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_ticket_asignacion($tick_id,$usu_asig){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_ticket_asignacion(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_asig);
            $sql->bindValue(2, $tick_id);
            $sql->execute();

            //GUARDAR NOTIFICACION EN LA TABLA DE NOTIFICACION 
            $sql1="INSERT INTO tm_notificacion (not_id,usu_id, not_mensaje,tick_id,est) VALUES(null, ?,'Se te asigno en el ticket #',?, 2)";
            $sql1=$conectar->prepare($sql1);
            $sql1->bindValue(1, $usu_asig);
            $sql1->bindValue(2, $tick_id);
            $sql1->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_total(){ // CONTEO TOTAL GENERAL DE TICKETS (ADMINISTRADOR)
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_total";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_total_sup($area_id, $suc_id){ // CONTEO TOTAL DE TICKETS X AREA Y SUCURSAL (SUPERVISOR)
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_total_sup(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function get_ticket_totalabierto(){ // CONTEO GENERAL DE TICKETS ABIERTOS (ADMINISTRADOR)
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_totalabierto";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_totalabierto_sup($area_id, $suc_id){ // CONTEO DE TICKETS ABIERTOS X AREA Y SUCURSAL (SUPERVISOR)
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_totalabierto_sup(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }        

        public function get_ticket_totalcerrado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_totalcerrado";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_ticket_totalcerrado_sup($area_id, $suc_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_totalcerrado_sup(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_ticket_grafico(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_grafico";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function get_ticket_grafico_sup($area_id, $suc_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_ticket_grafico_sup(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function insert_encuesta($tick_estre, $tick_coment,$tick_id){  
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_insert_encuesta(?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_estre);
            $sql->bindValue(2, $tick_coment);
            $sql->bindValue(3, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //VERA TODOS LOS TICKETS (ADMINSITRADOR)
        public function filtrar_ticket_admin($tick_titulo,$cat_id,$prio_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call filtrar_ticket_admin(?,?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, '%'.$tick_titulo.'%');
            $sql->bindValue(2, $cat_id);
            $sql->bindValue(3, $prio_id);
            $sql->bindValue(4, $usu_id);
           
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        //VERA SOLAMENTE LOS DEL AREA Y SUCURSAL (SUPERVISOR)
        public function filtrar_ticket($tick_titulo,$cat_id,$prio_id, $usu_id, $suc_id, $area_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call filtrar_ticket_sup (?,?,?,?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, '%'.$tick_titulo.'%');
            $sql->bindValue(2, $cat_id);
            $sql->bindValue(3, $prio_id);
            $sql->bindValue(4, $usu_id);
            $sql->bindValue(5, $suc_id);
            $sql->bindValue(6, $area_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        public function filtrar_ticket_x_usu_asig($tick_titulo,$cat_id,$prio_id, $usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call filtrar_ticket (?,?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, '%'.$tick_titulo.'%');
            $sql->bindValue(2, $cat_id);
            $sql->bindValue(3, $prio_id);
            $sql->bindValue(4, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_calendar_all(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_calendar_all";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function get_calendar_sup($area_id, $suc_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_calendar_sup(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $area_id);
            $sql->bindValue(2, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function get_calendar_usu($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_calendar_usu(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 
    }

?>