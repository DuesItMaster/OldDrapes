<?php 

include_once '../clases/Carrito.class.php';
include_once '../fnc/ahorroMetrajeGaleriasFnc.php';


$carrito = new Carrito();

$ID = isset($_POST['id']) ? $_POST['id'] : '';
$Operacion = isset($_POST['operacion']) ? $_POST['operacion'] : '';

// los botones + / - de terminarTabla.php envían el unique_id (llave del carrito en sesión)
$carro = $carrito->get_content();
$productoExistente = ($carro && isset($carro[$ID])) ? $carro[$ID] : null;


// ---------------------------------------------------------------------
//  ELIMINAR
// ---------------------------------------------------------------------
if ($Operacion == "ELIMINAR") {

    // aquí sí se elimina por unique_id (ID ya contiene unique_id)
    $carrito->remove_producto($ID);
}



// ---------------------------------------------------------------------
//  AGREGAR → suma 1 a la cantidad del producto
// ---------------------------------------------------------------------
elseif ($Operacion == "AGREGAR") {

    if ($productoExistente) {

        $articulo = $productoExistente;
        $articulo["cantidad"] = 1;   // add() lo suma a la cantidad actual
        if (is_numeric($productoExistente["cantidadBastonFija"])) {
            $articulo["cantidadBastonFija"] = abs($productoExistente["cantidadBastonFija"]);
        }

        $carrito->add($articulo);
    }
}



// ---------------------------------------------------------------------
//  SUPRIMIR → resta 1 a la cantidad del producto (mínimo 1; para quitarlo se usa ELIMINAR)
// ---------------------------------------------------------------------
elseif ($Operacion == "SUPRIMIR") {

    if ($productoExistente && $productoExistente["cantidad"] > 1) {

        $articulo = $productoExistente;
        $articulo["cantidad"] = -1;  // add() lo suma a la cantidad actual
        // negativo: add() resta los bastones de una unidad
        if (is_numeric($productoExistente["cantidadBastonFija"])) {
            $articulo["cantidadBastonFija"] = -abs($productoExistente["cantidadBastonFija"]);
        }

        $carrito->add($articulo);
    }
}

?>
