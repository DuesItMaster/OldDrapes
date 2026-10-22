<?php
require_once '../../conexion/wsConsumeDrapes.php';
require_once '../../conexion/cnxCostosProduccion.php';
require_once '../../conexion/cnx.php';
include_once '../clases/Carrito.class.php';


/**
 * NOTAS DE OPTIMIZACIÓN:
 * - Se agregaron caches locales por ejecución para evitar llamadas repetidas a BD/SAP.
 * - No se cambia la lógica de negocio ni los mensajes.
 * - Se agregaron checks defensivos para evitar notices.
 */

// =========================
// Entrada directa (endpoint)
// =========================
if (
    php_sapi_name() !== 'cli' // no consola
    && basename($_SERVER['SCRIPT_FILENAME']) === basename(__FILE__) // llamado directamente
    && !empty($_POST['metraje']) 
    && !empty($_POST['cantidad'])
    && !empty($_POST['codigotela'])
) {
    $metraje  = (float) $_POST['metraje'];
    $cantidad = (float) $_POST['cantidad'];
    $codigotela = trim((string) $_POST['codigotela']);
    $codigoArticuloCarrito = isset($_POST['idCarrito']) ? (string) $_POST['idCarrito'] : "";

    $stockfinal = stock($codigotela, $metraje, $cantidad, 0, $codigoArticuloCarrito);
    echo "<b>Mensaje: " . $stockfinal . "</b>";
    exit;
}

// ==================================
// Cache local por ejecución (global)
// ==================================
$__cacheStockMsg = [];            // cache de la función stock() por combinación de parámetros
$__cacheStockTela = [];           // cache de StockTela(codigoSAP)
$__cacheCambiosTelas = [];        // cache de cambiosTelas(codigoSAP)
$__cachePedidosNoCreados = [];    // cache de PedidosNoCreadosSAP(codigoSAP)
$__cacheCompras = [];             // cache de Compras(codigoSAP)
$__cachePorcentaje = null;        // cache de ObtenerPorcentaje()
$__cacheCarrito = [];             // cache de ObtenerStockCarrito(codigotela|articuloCarrito)

// ====================================================
// Función principal: calcula el mensaje de disponibilidad
// ====================================================
function stock($codigoSAP, $metraje, $cantidad, $CotizacionGuardada = 1, $articuloCarrito = "") {
    global $__cacheStockMsg;

    // Cache por combinación exacta de parámetros
    $cacheKey = $codigoSAP . "|" . $metraje . "|" . $cantidad . "|" . $CotizacionGuardada . "|" . $articuloCarrito;
    if (isset($__cacheStockMsg[$cacheKey])) {
        return $__cacheStockMsg[$cacheKey];
    }

    // ==== 1) Stock base ====
    $stock = StockTela($codigoSAP);
    $stockTotal = 0;
    if (is_array($stock) && isset($stock[0]['total'])) {
        $stockTotal = (float)$stock[0]['total'];
    }

    // ==== 2) Cálculo de necesidad ====
    $telaNecesaria = (float)$metraje * (float)$cantidad;
    $telaNecesariaCarrito = ObtenerStockCarrito($codigoSAP, $articuloCarrito);

    // Si la cotización NO está guardada, se suma lo del artículo con lo que ya está en carrito
    // Si sí está guardada, solo cuenta lo del carrito (tu lógica original).
    $telaNecesariaTotal = ($CotizacionGuardada == 0)
        ? ($telaNecesaria + $telaNecesariaCarrito)
        : $telaNecesariaCarrito;

    // ==== 3) Ajustes por cambios ====
    $cambios = cambiosTelas($codigoSAP);
    $telaAumenta = isset($cambios[0]['telaAumenta']) ? (float)$cambios[0]['telaAumenta'] : 0.0;
    $telaDisminuye = isset($cambios[0]['telaDisminuye']) ? (float)$cambios[0]['telaDisminuye'] : 0.0;

    $stockFinal = $stockTotal + $telaAumenta - $telaDisminuye;

    // ==== 4) Pedidos no creados en SAP (autorizados fuera) ====
    $pedidosnocreados = PedidosNoCreadosSAP($codigoSAP);
    $stockFinal -= (float)$pedidosnocreados;

    // ==== 5) Lógica de mensaje ====
    if ($stockFinal < $telaNecesariaTotal) {
        $mensaje = fechallegada($codigoSAP, $stockFinal, $telaNecesariaTotal);
    } else {
        $porcentajepermitido = ObtenerPorcentaje();
        $porcentajepermitido = is_numeric($porcentajepermitido) ? (float)$porcentajepermitido : 100.0;

        // Evitar división entre cero
        $den = ($stockFinal == 0.0) ? 1.0 : $stockFinal;
        $calculoPorcentaje = (float)round(($telaNecesariaTotal * 100) / $den, 0);

        if ($calculoPorcentaje >= $porcentajepermitido) {
            $mensaje = '<div style="color: #bdbd29;">Esta cotización requiere del ' . $calculoPorcentaje . '% del metraje disponible</div>';
        } else {
            if ($stockFinal <= 20) {
                $mensaje = '<div style="color: #bdbd29;">Insumo con stock bajo. Favor de comunicarse con su ejecutiv@ para confirmar stock</div>';
            } else {
                $mensaje = '<div style="color: green;">Insumos en stock</div>';
                // Mantener info oculta de depuración que ya tenías
                $mensaje .= '<div style="display: none;">stock_final=' . $stockFinal
                    . '<br>stock_total=' . $stockTotal
                    . '<br>stock_telaAumenta=' . $telaAumenta
                    . '<br>stock_telaDisminuye=' . $telaDisminuye
                    . '</div>';
            }
        }
    }

    // Cachear resultado final para la misma combinación de parámetros
    $__cacheStockMsg[$cacheKey] = $mensaje;
    return $mensaje;
}

// ==========================================================
// Calcula mensaje cuando falta tela: usa compras en tránsito
// ==========================================================
function fechallegada($codigoSAP, $stock, $telaNecesaria) {
    $compras = Compras($codigoSAP);
    $telaFaltante = (float)$telaNecesaria - (float)$stock;

    if (!empty($compras) && is_array($compras)) {
        $telaCompra = 0.0;
        foreach ($compras as $compra) {
            $telaCompra += isset($compra['total']) ? (float)$compra['total'] : 0.0;
            if ($telaFaltante <= $telaCompra) {
                $fecha = isset($compra['fecha']) ? $compra['fecha'] : '';
                return '<div style="color: #ff9800;">Insumo en tránsito: Llegada prevista ' . htmlspecialchars($fecha) . '</div>';
            }
        }
    }

    return '<div style="color: red;">Insumos insuficientes.</div>';
}

// ==========================================================
// Cambios de telas (aumenta/disminuye) con cache por tela
// ==========================================================
function cambiosTelas($codigoSAP) {
    global $__cacheCambiosTelas;

    if (isset($__cacheCambiosTelas[$codigoSAP])) {
        return $__cacheCambiosTelas[$codigoSAP];
    }

    $telaAumenta = 0.0;
    $telaDisminuye = 0.0;
    $cambiosInsumos = [];
    $condicion = " ";

    $pedidosSinEntrega = cambiosTelaEntregadosSAP($codigoSAP);
    if ($pedidosSinEntrega != " ") {
        $condicion = " and  ordenVenta in (" . $pedidosSinEntrega . ")";
    }

    $sql = "SELECT codArticulo, codArticuloCambio, cantidad, ordenVenta
            FROM CambioTela
            WHERE (codArticulo='" . mysqli_real_escape_string($GLOBALS['dbC'], $codigoSAP) . "'
               OR  codArticuloCambio='" . mysqli_real_escape_string($GLOBALS['dbC'], $codigoSAP) . "')
            " . $condicion;

    $result = mysqli_query($GLOBALS["dbC"], $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $cant = isset($row["cantidad"]) ? (float)$row["cantidad"] : 0.0;
            $codArt = isset($row["codArticulo"]) ? $row["codArticulo"] : null;
            $codCambio = isset($row["codArticuloCambio"]) ? $row["codArticuloCambio"] : null;

            if ($codArt !== $codCambio) {
                if ($codCambio === $codigoSAP) {
                    $telaDisminuye += $cant;
                } else {
                    $telaAumenta += $cant;
                }
            }
        }
    }

    $cambiosInsumos[] = ['telaAumenta' => $telaAumenta, 'telaDisminuye' => $telaDisminuye];

    // cache
    $__cacheCambiosTelas[$codigoSAP] = $cambiosInsumos;
    return $cambiosInsumos;
}

// ===================================================================
// Filtra cambios de tela por pedidos no entregados (consulta a SAP)
// ===================================================================
function cambiosTelaEntregadosSAP($codigoSAP) {
    $sql = "SELECT codArticulo, codArticuloCambio, cantidad, ordenVenta
            FROM CambioTela
            WHERE codArticulo='" . mysqli_real_escape_string($GLOBALS['dbC'], $codigoSAP) . "'
               OR codArticuloCambio='" . mysqli_real_escape_string($GLOBALS['dbC'], $codigoSAP) . "'";

    $busqueda = "";
    $PedidosSinEntrega = " ";
    $or = " ";

    $result = mysqli_query($GLOBALS["dbC"], $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $codArt = isset($row["codArticulo"]) ? $row["codArticulo"] : null;
            $codCambio = isset($row["codArticuloCambio"]) ? $row["codArticuloCambio"] : null;
            $orden = isset($row["ordenVenta"]) ? (int)$row["ordenVenta"] : null;

            if ($codArt && $codCambio && $codArt != $codCambio && $orden) {
                if ($codArt == $codigoSAP) {
                    $busqueda .= $or . " (T0.docnum = " . $orden . " and T1.itemcode = '" . mysqli_real_escape_string($GLOBALS['dbC'], $codCambio) . "')";
                } elseif ($codCambio == $codigoSAP) {
                    $busqueda .= $or . " (T0.docnum = " . $orden . " and T1.itemcode = '" . mysqli_real_escape_string($GLOBALS['dbC'], $codCambio) . "')";
                }
                $or = " or ";
            }
        }
    }

    if ($busqueda != "") {
        $pedidos = PedidosEntregados($busqueda);
        if (!empty($pedidos) && is_array($pedidos)) {
            $next = " ";
            foreach ($pedidos as $entregados) {
                if (isset($entregados['EstadoEntrega']) && $entregados['EstadoEntrega'] == "No Entregado") {
                    $pedidoNum = isset($entregados['Pedido']) ? $entregados['Pedido'] : null;
                    if ($pedidoNum !== null) {
                        $PedidosSinEntrega .= $next . $pedidoNum;
                        $next = ", ";
                    }
                }
            }
        }
    }

    return $PedidosSinEntrega;
}

// =====================================================
// Pedidos autorizados que aún no están creados en SAP
// =====================================================
function PedidosNoCreadosSAP($codigotela) {
    global $__cachePedidosNoCreados;

    if (isset($__cachePedidosNoCreados[$codigotela])) {
        return $__cachePedidosNoCreados[$codigotela];
    }

    $metraje = 0.0;

    /*$sql = "SELECT c.ID_COTIZACION,
                   cd.CODIGOTELA,
                   SUM(cd.cantidad * cd.METRAJE) AS METRAJE
            FROM cotizacion c
            INNER JOIN cotizacion_detalle cd ON cd.ID_COTIZACION = c.ID_COTIZACION
            WHERE c.ESTATUS=4
              AND c.ESTADO=3
              AND YEAR(c.FECHA_ALTA) > 2022
              AND cd.CODIGOTELA='" . mysqli_real_escape_string($GLOBALS['db'], $codigotela) . "'
            GROUP BY c.ID_COTIZACION;";*/
    $sql="SELECT c.ID_COTIZACION, d.CODIGOTELA, SUM(d.cantidad * d.METRAJE) AS METRAJE
		FROM cotizacion AS c
		INNER JOIN cotizacion_detalle AS d ON d.ID_COTIZACION = c.ID_COTIZACION
		WHERE
			c.ESTATUS = 4 AND c.ESTADO = 3
			AND c.FECHA_ALTA >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)  -- desde hace 1 año
			AND d.CODIGOTELA = '".$codigotela."'
		GROUP BY
			c.ID_COTIZACION;";

    $result = mysqli_query($GLOBALS["db"], $sql);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $folio = isset($row["ID_COTIZACION"]) ? $row["ID_COTIZACION"] : null;
            $metrajeFila = isset($row["METRAJE"]) ? (float)$row["METRAJE"] : 0.0;

            if ($folio !== null) {
                $resultado = ConsultaFoliosEnPedido($folio);
                if (empty($resultado)) {
                    $metraje += $metrajeFila;
                }
            }
        }
    }

    // cache
    $__cachePedidosNoCreados[$codigotela] = $metraje;
    return $metraje;
}

// ===================================================
// Suma de metraje en carrito por tela (con cache)
// ===================================================
function ObtenerStockCarrito($codigotela, $articuloCarrito) {
    global $__cacheCarrito;

    $key = $codigotela . '|' . $articuloCarrito;
    if (isset($__cacheCarrito[$key])) {
        return $__cacheCarrito[$key];
    }

    $carrito = new Carrito();
    $carro = $carrito->get_content();

    $stock = 0.0;

    if (!empty($carro) && is_array($carro)) {
        foreach ($carro as $producto) {
            $codigo = isset($producto["CodigoTela"]) ? $producto["CodigoTela"] : null;
            if ($codigo === $codigotela) {
                $id = isset($producto["id"]) ? (string)$producto["id"] : "";
                if ($id !== (string)$articuloCarrito) {
                    $metraje = isset($producto["Metraje"]) ? (float)$producto["Metraje"] : 0.0;
                    $cant = isset($producto["cantidad"]) ? (float)$producto["cantidad"] : 0.0;
                    $stock += ($metraje * $cant);
                }
            }
        }
    }

    $__cacheCarrito[$key] = $stock;
    return $stock;
}

// =====================================
// Porcentaje permitido (cache simple)
// =====================================
function ObtenerPorcentaje() {
    global $__cachePorcentaje;

    if ($__cachePorcentaje !== null) {
        return $__cachePorcentaje;
    }

    $Porcentaje = 0;
    $sql = "SELECT PORCENTAJEINSUMOS FROM varios LIMIT 1;";
    $result = mysqli_query($GLOBALS["db"], $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        if ($row = mysqli_fetch_assoc($result)) {
            $Porcentaje = isset($row["PORCENTAJEINSUMOS"]) ? (float)$row["PORCENTAJEINSUMOS"] : 0.0;
        }
    }

    $__cachePorcentaje = $Porcentaje;
    return $Porcentaje;
}

