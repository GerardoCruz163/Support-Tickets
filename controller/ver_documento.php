<?php
require __DIR__ . '/../vendor/autoload.php'; 
require_once dirname(__DIR__,1) . "/config/config.php";

use Dotenv\Dotenv;
$config = App\Config::getInstance();
$dotenv = Dotenv::createImmutable($config->getEnvPath(), '.env.' . $config->getEnvironment());
$dotenv->load();

$id = $_GET['id'];
$archivos = $_GET['archivo'];

// Ruta absoluta en el servidor
$ruta = $_ENV["URL_DOCS"]. "$id/$archivos";
echo $ruta;
//$ruta = "/var/www/support-tracking-documentos/document/$id/$archivo";

// Verifica si existe
if (file_exists($ruta)) {
    // Detecta tipo MIME automáticamente
    $mime = mime_content_type($ruta);
    header("Content-Type: $mime");
    //echo '<title>'. $archivo.'</title>';
    header('Content-Disposition: inline; filename="' . basename($archivo) . '"');
    readfile($ruta);
    exit;
} else {
    http_response_code(404);
    echo "Archivo no encontrado en: " . htmlspecialchars($ruta);
}
?>

