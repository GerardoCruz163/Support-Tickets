<?php
session_start();
 
class Conectar {
    /** @var PDO */
    protected $dbh;
 
    /**
     * Crea y retorna la conexión PDO a la base de datos helpdesk
     * utilizando charset y collation compatibles con las tablas.
     */
    protected function Conexion() {
        try {
            $dsn  = "mysql:host=192.168.10.69;port=3306;dbname=helpdesk;charset=utf8mb4";
            $user = "support_tracking";
            $pass = "3Sequ3Le7L4Su7r4";
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                // Se fuerza collation general_ci para evitar mezclas con utf8mb4_0900_ai_ci
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci"
                
            ];
 
            // Si usas SSL/TLS, descomenta y ajusta la ruta al certificado CA:
            // $options[PDO::MYSQL_ATTR_SSL_CA] = 'C:\\ruta\\a\\ca.pem';
 
            $this->dbh = new PDO($dsn, $user, $pass, $options);
            return $this->dbh;
        } catch (PDOException $e) {
            die("Error BD!: " . $e->getMessage());
        }
    }
 
    /**
     * Opcional: vuelve a establecer nombres y collation en la sesión activa
     */
    public function set_names() {
        return $this->dbh->exec(
            "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci"
        );
    }
 
    /**
     * Ruta base de la aplicación
     */
    public static function ruta() {
        return "https://support-tracking.tecnologisticaaduanal.com/";
    }
}
?>
