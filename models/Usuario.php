<?php

    $key = "mi_key_secret";
    $cipher = "aes-256-cbc";
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
    class Usuario extends Conectar{
        public function login(){
            $conectar=parent::conexion();   
            parent::set_names();
            if(isset($_POST["enviar"])){
                $correo = $_POST["usu_correo"];
                $pass = $_POST["usu_pass"];
                //$rol = $_POST["rol_id"];
                if(empty($correo) and empty($pass)){
                    header("Location:".conectar::ruta()."index.php?m=2");
                    exit();
                }else{
                    $sql = "call sp_login(?)";
                    $stmt=$conectar->prepare($sql);
                    $stmt->bindValue(1, $correo);
                    $stmt->execute();
                    $resultado = $stmt->fetch();

                    if($resultado){
                        $textocifrado = $resultado["usu_pass"];

                        $key = "mi_key_secret";
                        $cipher = "aes-256-cbc";
                        $iv_dec = substr(base64_decode($textocifrado), 0, openssl_cipher_iv_length($cipher));
                        $cifradoSinIV = substr(base64_decode($textocifrado), openssl_cipher_iv_length($cipher));
                        $descifrado = openssl_decrypt($cifradoSinIV, $cipher, $key, OPENSSL_RAW_DATA, $iv_dec);

                        if($descifrado == $pass){
                            if(is_array($resultado) and count($resultado)> 0){
                                $_SESSION["usu_id"] = $resultado["usu_id"];
                                $_SESSION["usu_nom"] = $resultado["usu_nom"];
                                $_SESSION["usu_ape"] = $resultado["usu_ape"];
                                $_SESSION["rol_id"] = $resultado["rol_id"];
                                $_SESSION["suc_id"] = $resultado["suc_id"];
                                $_SESSION["area_id"] = $resultado["area_id"];
                                $_SESSION["pic_num"] = $resultado["pic_num"];

                                header("Location:".Conectar::ruta()."view/Home/");
                                exit();
                            }else{
                                header("Location:".Conectar::ruta()."index.php?m=1");
                                exit();
                            }
                        }
                    }
                }
            }
        }

        public function insert_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id, $area_id, $suc_id){

            //ENCRIPTADO DE LA CONTRASEÑA 
            $key = "mi_key_secret";
            $cipher = "aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key,OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_insert_usuario(?,?,?,?,?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape); 
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $textoCifrado);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $area_id);
            $sql->bindValue(7, $suc_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function update_usuario($usu_nom,$usu_ape,$usu_correo,$usu_pass,$rol_id,$area_id, $suc_id, $usu_id){
            //ENCRIPTADO DE LA CONTRASEÑA 
            $key = "mi_key_secret";
            $cipher = "aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key,OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);

            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_usuario(?,?,?,?,?,?,?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_nom);
            $sql->bindValue(2, $usu_ape);
            $sql->bindValue(3, $usu_correo);
            $sql->bindValue(4, $textoCifrado);
            $sql->bindValue(5, $rol_id);
            $sql->bindValue(6, $area_id);
            $sql->bindValue(7, $suc_id);
            $sql->bindValue(8, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function delete_usuario($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_delete_usuario(?)";
            
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_01()";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
        
        public function get_usuario_x_rol(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_x_rol";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_area_cat($cat_id, $usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_x_area_cat(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $cat_id);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_l_usuario_02(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_total_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_total_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalabierto_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_totalabierto_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalcerrado_x_id($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_totalcerrado_x_id(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalabierto(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_totalabierto";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_totalcerrado(){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_totalcerrado";
            $sql=$conectar->prepare($sql);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_grafico($usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_usuario_grafico(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        } 

        public function update_usuario_pass($usu_pass,$usu_id){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_update_usuario_pass(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_pass);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_usuario_x_correo($usu_correo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="SELECT * FROM tm_usuario Where usu_correo = ?";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function get_cambiar_contra_recuperar($usu_correo){
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_get_cambiar_contra_recuperar(?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $usu_correo);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }

        public function encriptar_nueva_contra($usu_pass,$usu_id){
            //ENCRIPTADO DE LA CONTRASEÑA 
            $key = "mi_key_secret";
            $cipher = "aes-256-cbc";
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
            $cifrado = openssl_encrypt($usu_pass, $cipher, $key,OPENSSL_RAW_DATA, $iv);
            $textoCifrado = base64_encode($iv . $cifrado);
    
            $conectar= parent::conexion();
            parent::set_names();
            $sql="call sp_encriptar_nueva_contra(?,?)";
            $sql=$conectar->prepare($sql);
            $sql->bindValue(1, $textoCifrado);
            $sql->bindValue(2, $usu_id);
            $sql->execute();
            return $resultado=$sql->fetchAll();
        }
    }
?>