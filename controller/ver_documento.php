<?php
session_start();
require_once("../config/conexion.php"); // importa tu conexión PDO/Mysqli

if (!isset($_SESSION["usu_id"])) {
    http_response_code(403);
    exit("Acceso no autorizado");
}

$usu_id = $_SESSION["usu_id"];
$tick_id = $_GET["tick_id"] ?? "";
$det_nom = $_GET["det_nom"] ?? "";

// 1. Verificar si el usuario es creador o asignado
$sql = "SELECT COUNT(*) AS total
        FROM tm_ticket t
        WHERE t.tick_id = ? 
          AND (t.usu_id = ? OR t.usu_asig = ?)";

$stmt = $conexion->prepare($sql);
$stmt->execute([$tick_id, $usu_id, $usu_id]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$es_autorizado = ($row["total"] > 0);

// 2. Si no, revisar si es seguidor
if (!$es_autorizado) {
    $sql = "SELECT COUNT(*) AS total
            FROM td_ticket_seguidor ts
            WHERE ts.tick_id = ? 
              AND ts.usu_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([$tick_id, $usu_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $es_autorizado = ($row["total"] > 0);
}

// 3. Si no es autorizado, cortar aquí
if (!$es_autorizado) {
    http_response_code(403);
    exit("No tienes permisos para acceder a este documento");
}

// --- Aquí ya está autorizado ---
$ruta = "../public/document_detalle/$tick_id/$det_nom";

if (!file_exists($ruta)) {
    http_response_code(404);
    exit("Archivo no encontrado");
}

header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename=\"$det_nom\"");
header("Content-Length: " . filesize($ruta));
readfile($ruta);
exit;

