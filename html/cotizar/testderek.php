<?php
require_once '../../conexion/wsConsumeDrapes.php';

header('Content-Type: application/json; charset=utf-8');

function probarComodin($codigo) {
    $resultado = Comodin($codigo);

    $fault = isset($GLOBALS['cliente']->fault) ? $GLOBALS['cliente']->fault : null;
    $error = $GLOBALS['cliente']->getError();
    $rawResponse = isset($GLOBALS['cliente']->response) ? $GLOBALS['cliente']->response : null;

    $item = null;
    if (is_array($resultado)) {
        $item = isset($resultado[0]) && is_array($resultado[0]) ? $resultado[0] : (is_array($resultado) ? $resultado : null);
    }

    return [
        'codigo_consultado' => $codigo,
        'resultado' => $resultado,
        'item_detectado' => $item,
        'costoUni' => ($item && isset($item['CostoUni'])) ? (float)$item['CostoUni'] : null,
        'tipoArticulo' => ($item && isset($item['TipoArticulo'])) ? $item['TipoArticulo'] : null,
        'fault' => $fault,
        'error' => $error,
        'rawResponse' => $rawResponse
    ];
}

function probarPaquete($params) {
    $paquete = CostoCortineroCompleto(
        $params['tipoCortinero'], $params['remate'], $params['fijacion'], $params['soporte'], $params['sistema'],
        $params['decorativo'], $params['argolla'], $params['ancho'], $params['color'], $params['peso'],
        $params['materialBaston'], $params['medidaBaston'], $params['colorBaston'], '', ''
    );

    $fault = isset($GLOBALS['cliente']->fault) ? $GLOBALS['cliente']->fault : null;
    $error = $GLOBALS['cliente']->getError();
    $rawResponse = isset($GLOBALS['cliente']->response) ? $GLOBALS['cliente']->response : null;

    $servicio = null;
    if (is_array($paquete)) {
        foreach ($paquete as $row) {
            if (isset($row['codigo']) && trim($row['codigo']) === 'SERVICIO-CURV-KS') {
                $servicio = $row;
                break;
            }
        }
    }

    return [
        'paquete' => $paquete,
        'servicio_en_paquete' => $servicio,
        'costoUni' => ($servicio && isset($servicio['CostoUni'])) ? (float)$servicio['CostoUni'] : null,
        'tipoArticulo' => ($servicio && isset($servicio['TipoArticulo'])) ? $servicio['TipoArticulo'] : null,
        'fault' => $fault,
        'error' => $error,
        'rawResponse' => $rawResponse
    ];
}

$params = [
    'tipoCortinero' => isset($_GET['tipo']) ? $_GET['tipo'] : '30',
    'remate' => isset($_GET['remate']) ? $_GET['remate'] : 'N/A',
    'fijacion' => isset($_GET['fijacion']) ? $_GET['fijacion'] : 'MURO',
    'soporte' => isset($_GET['soporte']) ? $_GET['soporte'] : 'SENCILLO',
    'sistema' => isset($_GET['sistema']) ? $_GET['sistema'] : 'ESTANDAR',
    'decorativo' => isset($_GET['decorativo']) ? $_GET['decorativo'] : 'NO',
    'argolla' => isset($_GET['argolla']) ? $_GET['argolla'] : 'N/A',
    'ancho' => isset($_GET['ancho']) ? $_GET['ancho'] : '3.25',
    'color' => isset($_GET['color']) ? $_GET['color'] : 'BLANCO',
    'peso' => isset($_GET['peso']) ? $_GET['peso'] : '0',
    'materialBaston' => isset($_GET['materialBaston']) ? $_GET['materialBaston'] : 'ACRILICO',
    'medidaBaston' => isset($_GET['medidaBaston']) ? $_GET['medidaBaston'] : '1.00',
    'colorBaston' => isset($_GET['colorBaston']) ? $_GET['colorBaston'] : 'BLANCO'
];

$codigoArticulo = isset($_GET['codigo']) ? trim($_GET['codigo']) : 'SERVICIO-CURV-KS';
$barcode = isset($_GET['barcode']) ? trim($_GET['barcode']) : 'DT-01-50769';

$out = [
    'input' => [
        'codigo' => $codigoArticulo,
        'barcode' => $barcode,
        'params' => $params
    ],
    'comodin_por_codigo' => probarComodin($codigoArticulo),
    'comodin_por_barcode' => probarComodin($barcode),
    'paquete' => probarPaquete($params)
];

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);