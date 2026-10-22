<?php


session_start();
header('Content-Type: application/json');

// --- 1️⃣ INCLUSIÓN SEGURA DE DEPENDENCIAS ---
$comprobacionPath = realpath(__DIR__ . '/../fnc/comprobacionInsumos.php');
if (!$comprobacionPath || !file_exists($comprobacionPath)) {
    echo json_encode(['error' => 'No se pudo incluir comprobacionInsumos.php']);
    exit;
}
require_once $comprobacionPath;

// --- 2️⃣ LECTURA Y VALIDACIÓN DE DATOS ---
$input = file_get_contents('php://input');
if (!$input) {
    echo json_encode(['error' => 'No se recibieron datos']);
    exit;
}

$data = json_decode($input, true);
if (!is_array($data) || empty($data['productos'])) {
    echo json_encode(['error' => 'Estructura JSON inválida o vacía']);
    exit;
}

$productos = $data['productos'];
$resultados = [];

// --- 3️⃣ PROCESAR CADA PRODUCTO ---
foreach ($productos as $producto) {
    $codigoSAP = $producto['codigoTela'] ?? null;
    $metraje   = isset($producto['metraje']) ? (float)$producto['metraje'] : 0;
    $cantidad  = isset($producto['cantidad']) ? (int)$producto['cantidad'] : 0;

    // Validación mínima
    if (!$codigoSAP) {
        $resultados[] = ['error' => 'Código no definido'];
        continue;
    }

    try {
        // Llamada a la función stock() original
        $mensajeHTML = stock($codigoSAP, $metraje, $cantidad, 0, 'temp_' . $codigoSAP);
        $resultados[$codigoSAP] = $mensajeHTML ?: '<span style="color:red;">Error interno</span>';
    } catch (Throwable $e) {
        // Captura cualquier fallo inesperado
        $resultados[$codigoSAP] = '<span style="color:red;">' . htmlspecialchars($e->getMessage()) . '</span>';
    }
}

// --- 4️⃣ DEVOLVER RESULTADO JSON ---
echo json_encode($resultados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
