<?php
// Limpia cualquier basura previa (incluyendo "1" de otros require)
while (ob_get_level() > 0) { @ob_end_clean(); }

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json; charset=utf-8');
error_reporting(0); // quitamos warnings / notices para evitar fugas de texto

// Cargar dependencias sin preocuparse por su output
@require_once '../../conexion/wsConsumeDrapes.php';
@require_once '../../conexion/cnxCostosProduccion.php';
@require_once '../../conexion/cnx.php';
@require_once '../clases/Carrito.class.php';

// Cargar comprobador
$comprobacionPath = realpath(__DIR__ . '/../fnc/comprobacionInsumos.php');
if (!$comprobacionPath) {
    echo json_encode(['error' => 'No se encontró lógica de stock']);
    exit;
}
@require_once $comprobacionPath;

// Leer entrada
$input = file_get_contents('php://input');
$data  = json_decode($input, true);

if (!$data || !isset($data['productos']) || !is_array($data['productos'])) {
    echo json_encode(['error' => 'JSON inválido']);
    exit;
}

$resultados = [];
foreach ($data['productos'] as $p) {
    $codigo   = $p['codigotela'] ?? null;
    $metraje  = isset($p['metraje']) ? (float)$p['metraje'] : 0;
    $cantidad = isset($p['cantidad']) ? (int)$p['cantidad'] : 0;
    
    if (!$codigo) continue;

    // Si stock regresa HTML o texto, lo convertimos a "SI" o "NO"
    $resultado = stock($codigo, $metraje, $cantidad, 0, "");
    $texto = strip_tags($resultado); // quitamos HTML

    if (stripos($texto, 'insuf') !== false) {
        $resultados[$codigo] = "NO HAY INSUMOS";
    } else {
        $resultados[$codigo] = "HAY INSUMOS";
    }
}

// Limpia cualquer cosa que se haya impreso al final
while (ob_get_level() > 0) { @ob_end_clean(); }

// RESPUESTA JSON FINAL
echo json_encode($resultados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
exit;
