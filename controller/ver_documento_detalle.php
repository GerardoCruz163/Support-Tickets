<?php
require_once dirname(__DIR__ ,1) . '/config/conexion.php';
require __DIR__ . '/../vendor/autoload.php'; 
require_once dirname(__DIR__, 1) . '/config/config.php';

use Dotenv\Dotenv;
$config = App\Config::getInstance();
$dotenv = Dotenv::createImmutable($config->getEnvPath(), '.env.' . $config->getEnvironment());
$dotenv->load();
// Ruta base donde se guardan los documentos de detalle
$basePath = $_ENV["URL_DOCSD"];
//$basePath = "/var/www/support-tracking-documentos/document_detalle/";

// Obtener parámetros
$id = isset($_GET['id']) ? basename($_GET['id']) : null;
$archivo = isset($_GET['archivo']) ? basename($_GET['archivo']) : null;

// Validar parámetros
if (!$id || !$archivo) {
    http_response_code(400);
    echo "Parámetros inválidos.";
    exit;
}

// Construir ruta completa
$ruta = $basePath. "$id/$archivo";

// Verificar si el archivo existe
if (file_exists($ruta)) {
    // Detectar tipo MIME automáticamente
    $mime = mime_content_type($ruta);
    header("Content-Type: $mime");
    header('Content-Disposition: inline; filename="' . basename($archivo) . '"');
    readfile($ruta);
    exit;
} else {
    http_response_code(404);
    echo "Archivo no encontrado en: " . htmlspecialchars($ruta);
}
?>
