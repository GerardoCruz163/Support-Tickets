<?php
session_start(); //linea 2

require '/var/www/support-tracking/vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable('/var/www');
$dotenv->load();
 
class Conectar {
    /** @var PDO */
    protected $dbh;
 
    /**
     * Crea y retorna la conexión PDO a la base de datos helpdesk
     * utilizando charset y collation compatibles con las tablas.
     */
    protected function Conexion() {
        try {

            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $name = $_ENV['DB_NAME'];
            $dsn  = "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4";
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                // Se fuerza collation general_ci para evitar mezclas con utf8mb4_0900_ai_ci
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci"
                
            ];
 
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
