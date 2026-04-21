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
            $sql->execute(); // linea 16
            
            $sql1="select last_insert_id() as 'tick_id';";
            $sql1=$conectar->prepare($sql1);
            $sql1->execute();
            return $resultado=$sql1->fetchAll(pdo::FETCH_ASSOC);
        }

        // INSERTAR SEGUIDORES AL TICKET
        public function insert_ticket_seguidor($tick_id, $usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM td_ticket_seguidor WHERE tick_id = ? AND usu_id = ?;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();

            if ($sql->rowCount() == 0) {
                //Insertar solo si no existe
                $sql = "INSERT INTO td_ticket_seguidor(tick_id, usu_id, fech_agregado, est)
                        VALUES (?, ?, NOW(), 1);";
                $sql = $conectar->prepare($sql);
                $sql->bindValue(1, $tick_id);
                $sql->bindValue(2, $usu_id);
                $sql->execute();
            }
        }

        //METODOS PARA VERIFICAR SI HAY SEGUIDORES (CASO DE TICKET YA CREADO)
        public function get_ticket_seguidor($tick_id, $usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "SELECT * FROM td_ticket_seguidor WHERE tick_id = ? AND usu_id = ?;";
            $sql = $conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
        }

        public function insert_ticket_seguidor_2($tick_id, $usu_id){
            $conectar = parent::conexion();
            parent::set_names();
            $sql = "INSERT INTO td_ticket_seguidor(tick_id, usu_id, fech_agregado, est)
                        VALUES (?, ?, NOW(), 1);";
            $stmt = $conectar->prepare($sql);
            $stmt->bindValue(1, $tick_id);
            $stmt->bindValue(2, $usu_id);
            $stmt->execute();
        }
        
        public function get_seg_x_tick($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM td_ticket_seguidor
                LEFT JOIN tm_usuario on td_ticket_seguidor.usu_id = tm_usuario.usu_id
                WHERE tick_id = ?;";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
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
        public function listar_ticket_x_usu_cerrados($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_ticket_x_usu_cerrados(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_x_id($tick_id){
            $conectar= parent::conexion();
            parent::set_names();

            $tick_id = !empty($tick_id) ? (int)$tick_id : null;
            $sql="call sp_listar_ticket_x_id(?)"; 
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();//linea 95
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

        public function listar_ticket_asig_x_usu_cerrados($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_ticket_asig_x_usu_cerrados(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_seguidor($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM td_ticket_seguidor
                    LEFT JOIN tm_usuario on td_ticket_seguidor.usu_id = tm_usuario.usu_id
                    LEFT JOIN tm_ticket on td_ticket_seguidor.tick_id = tm_ticket.tick_id
                    WHERE td_ticket_seguidor.tick_id = ?;";    
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_ticket_seguidor_detalle($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_listar_ticket_seguidor_detalle(?)";    
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_seguidores($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM td_ticket_seguidor
                    LEFT JOIN tm_usuario on td_ticket_seguidor.usu_id = tm_usuario.usu_id
                    LEFT JOIN tm_ticket on td_ticket_seguidor.tick_id = tm_ticket.tick_id
                    WHERE td_ticket_seguidor.tick_id = ?;";    
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function listar_seguidores_not($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT 
                td_ticket_seguidor.seg_id,
                td_ticket_seguidor.tick_id,
                td_ticket_seguidor.usu_id AS seg_usu_id,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.usu_correo
                FROM td_ticket_seguidor
                LEFT JOIN tm_usuario 
                    ON td_ticket_seguidor.usu_id = tm_usuario.usu_id
                WHERE td_ticket_seguidor.tick_id =?";    
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
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

        public function get_ultimo_coment_tickdetalle($tick_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT
                td_ticketdetalle.tickd_id,
                td_ticketdetalle.tickd_descrip,
                td_ticketdetalle.fech_crea,
                tm_usuario.usu_nom,
                tm_usuario.usu_ape,
                tm_usuario.rol_id,
                tm_usuario.pic_num,
                tm_area.area_nom,
                tm_sucursal.suc_nom
                FROM 
                    td_ticketdetalle
                INNER join tm_usuario on td_ticketdetalle.usu_id = tm_usuario.usu_id
                INNER join tm_area on tm_usuario.area_id = tm_area.area_id
                INNER join tm_sucursal on tm_usuario.suc_id = tm_sucursal.suc_id
                WHERE 
                tick_id = ?
                AND td_ticketdetalle.fech_crea = (SELECT MAX(fech_crea) from td_ticketdetalle);";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
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
            $seguidor = $ticket->listar_seguidores_not($tick_id);
            foreach($datos as $row){
                $usu_asig = $row["usu_asig"];
                $usu_crea = $row["usu_id"];
            }

            //AQUI SE ENVIA AL SEGUIDOR
            foreach ($seguidor as $row) {
                $usu_seg = $row["seg_usu_id"];

                if($_SESSION["usu_id"] != $usu_seg){  // notificar a los demás, no a quien comenta
                    $sql0="call sp_guardar_notificacion_modificado($usu_seg, $tick_id)";
                    $sql0=$conectar->prepare($sql0);
                    $sql0->execute();
                }
            }

            //si el usuario es quien fue asignado al ticket, la notificacion va para el que la creo
            if($_SESSION["usu_id"]== $usu_asig){
                //GUARDAR NOTIFICACION DE NUEVO COMENTARIO
                $sql0="call sp_guardar_notificacion_modificado($usu_crea, $tick_id)";
                $sql0=$conectar->prepare($sql0);
                $sql0->execute();

            //si el usuario es quien creó el ticket, la notificacion va para quien fue asignado
            }else if($_SESSION["usu_id"]== $usu_crea){
                //GUARDAR NOTIFICACION DE NUEVO COMENTARIO
                $sql0="call sp_guardar_notificacion_modificado($usu_asig, $tick_id)";
                $sql0=$conectar->prepare($sql0);
                $sql0->execute();
                
            }

            // TODO: Devuelve el ultimo ID ticket ingresado
            $sql="call sp_insert_ticketdetalle(?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $tick_id);
            $sql->bindValue(2, $usu_id);
            $sql->bindValue(3, $tickd_descrip);
            $sql->execute(); // linea 211
            
            $mensaje = "Nuevo comentario en ticket $tick_id";

            file_get_contents("https://support-tracking.tecnologisticaaduanal.com:8082/notificar-ticket?tick_id=$tick_id&usu_id=$usu_seg&mensaje=" . urlencode($mensaje));
            // $sql1="select last_insert_id() as 'tickd_id';";
            // $sql1=$conectar->prepare($sql1);
            // $sql1->execute();

            $sql1 = "SELECT LAST_INSERT_ID() AS tickd_id, ? AS tick_id;";
            $sql1 = $conectar->prepare($sql1);
            $sql1->bindValue(1, $tick_id); // reutilizamos el tick_id que entró por parámetro
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

           // Limpiar valores antes de pasarlos al SP
            $cat_id  = ($cat_id === '' || $cat_id === 'Seleccionar') ? null : (int)$cat_id;
            $prio_id = ($prio_id === '' || $prio_id === 'Seleccionar') ? null : (int)$prio_id;
            $usu_id  = ($usu_id === '' || $usu_id === 'Seleccionar') ? null : (int)$usu_id;
            $tick_titulo = ($tick_titulo === '') ? null : $tick_titulo;

            $sql="call filtrar_ticket_admin(?,?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, '%'.$tick_titulo.'%');
            $sql->bindValue(2, $cat_id);
            $sql->bindValue(3, $prio_id);
            $sql->bindValue(4, $usu_id);

            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function filtrar_ticket_admin_cerrados($tick_titulo,$cat_id,$prio_id,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();

           // Limpiar valores antes de pasarlos al SP
            $cat_id  = ($cat_id === '' || $cat_id === 'Seleccionar') ? null : (int)$cat_id;
            $prio_id = ($prio_id === '' || $prio_id === 'Seleccionar') ? null : (int)$prio_id;
            $usu_id  = ($usu_id === '' || $usu_id === 'Seleccionar') ? null : (int)$usu_id;
            $tick_titulo = ($tick_titulo === '') ? null : $tick_titulo;

            $sql="call filtrar_ticket_admin_cerrados(?,?,?,?)";
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

            $cat_id = !empty($_POST['cat_id']) ? (int)$_POST['cat_id'] : null;
            $prio_id = !empty($_POST['prio_id']) ? (int)$_POST['prio_id'] : null;
            $usu_id = !empty($_POST['usu_id']) ? (int)$_POST['usu_id'] : null;

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
        //CERRADOS
        public function filtrar_ticket_cerrados($tick_titulo,$cat_id,$prio_id, $usu_id, $suc_id, $area_id){
            $conectar= parent::conexion();
            parent::set_names();

            $cat_id = !empty($_POST['cat_id']) ? (int)$_POST['cat_id'] : null;
            $prio_id = !empty($_POST['prio_id']) ? (int)$_POST['prio_id'] : null;
            $usu_id = !empty($_POST['usu_id']) ? (int)$_POST['usu_id'] : null;

            $sql="call filtrar_ticket_sup_cerrado (?,?,?,?,?,?)";
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