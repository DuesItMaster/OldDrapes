<?php/*
// arreglo_domotica.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
header('Content-Type: application/json');

// Funci�n para loguear errores
function logDebug($mensaje, $datos = []) {
    error_log("DOMOTICA_DEBUG: " . $mensaje . " - " . json_encode($datos));
}

try {
    logDebug("=== INICIO ARREGLO_DOMOTICA ===");
    logDebug("POST recibido", $_POST);

    // Validar campos cr�ticos
    $camposRequeridos = ['id', 'Cantidad', 'precioFinal', 'nombre', 'codigoControl', 'tipoarticulo', 'area', 'idDrapesNombre'];
    
    foreach ($camposRequeridos as $campo) {
        if (!isset($_POST[$campo]) || $_POST[$campo] === "") {
            throw new Exception("Campo requerido faltante: " . $campo);
        }
    }

    // Asignar y validar datos
    $id = $_POST['id'];
    $Cantidad = floatval($_POST['Cantidad']);
    $precioFinal = floatval($_POST['precioFinal']);
    $nombre = $_POST['nombre'];
    $codigoControl = $_POST['codigoControl'];
    $tipoarticulo = $_POST['tipoarticulo'];
    $area = $_POST['area'];
    $idDrapesNombre = $_POST['idDrapesNombre'];

    // Validaciones espec�ficas
    if ($Cantidad <= 0) {
        throw new Exception("La cantidad debe ser mayor a 0");
    }

    if ($precioFinal < 0) {
        throw new Exception("El precio no puede ser negativo");
    }

    // Construir el array del art�culo para dom�tica
    $articuloDomotica = [
        "id" => $id,
        "Cantidad" => $Cantidad,
        "precioFinal" => $precioFinal,
        "nombre" => $nombre,
        "codigo" => $codigoControl,
        "codigoControl" => $codigoControl,
        "tipoarticulo" => $tipoarticulo,
        "area" => $area,
        "idDrapesNombre" => $idDrapesNombre,
        "TipoArticuloDetalle" => $tipoarticulo
    ];

    // Campos opcionales
    $camposOpcionales = ['ruta', 'nombreControl', 'imgnombre'];
    foreach ($camposOpcionales as $campo) {
        if (isset($_POST[$campo]) && $_POST[$campo] !== "") {
            $articuloDomotica[$campo] = $_POST[$campo];
        }
    }

    // Si viene ruta de imagen, usarla, sino construirla
    if (!isset($articuloDomotica['ruta']) && isset($_POST['imgnombre'])) {
        $articuloDomotica['ruta'] = "../../assets/img/cortineros/" . $_POST['imgnombre'] . ".jpg";
    }

    logDebug("Art�culo de dom�tica preparado", $articuloDomotica);

    // Incluir y llamar a LlenarCarrito.php
    include_once 'LlenarCarrito.php';

    // Respuesta de �xito
    echo json_encode([
        'success' => true,
        'message' => 'Art�culo de dom�tica procesado correctamente',
        'data' => [
            'id' => $id,
            'nombre' => $nombre,
            'cantidad' => $Cantidad,
            'precio' => $precioFinal
        ]
    ]);

} catch (Exception $e) {
    logDebug("ERROR: " . $e->getMessage());
    
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'error_type' => 'domotica_validation_error'
    ]);
    exit;
}
?>