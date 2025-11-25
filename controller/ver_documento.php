<?php
$id = $_GET['id'];
$archivo = $_GET['archivo'];

// Ruta absoluta en el servidor
$ruta = "/var/www/support-tracking-documentos/document/$id/$archivo";

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

