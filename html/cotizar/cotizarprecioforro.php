<?php
require_once '../fnc/CortinaFnc.php';
require_once '../../conexion/cnx.php';
require_once '../../conexion/wsConsumeDrapes.php';
require_once '../fnc/FormulasCortina.php';

// =================== CAPTURA DE VARIABLES POST =================== //
if (isset($_POST['Clave']) and $_POST['Clave'] <> "") { $Clave = $_POST['Clave']; }
if (isset($_POST['Ancho']) and $_POST['Ancho'] <> "") { $Ancho = $_POST['Ancho']; }
if (isset($_POST['Alto']) and $_POST['Alto'] <> "") { $Alto = $_POST['Alto']; }
if (isset($_POST['ColorForro']) and $_POST['ColorForro'] <> "") { $Color = $_POST['ColorForro']; }
if (isset($_POST['TelaForro']) and $_POST['TelaForro'] <> "") { $Tela = $_POST['TelaForro']; }
if (isset($_POST['TipoTelaForro']) and $_POST['TipoTelaForro'] <> "") { $TipoTela = $_POST['TipoTelaForro']; }
if (isset($_POST['Stiffener']) and $_POST['Stiffener'] <> "") { $Stiffener = $_POST['Stiffener']; }
if (isset($_POST['ForroX']) and $_POST['ForroX'] <> "") { $ForroX = $_POST['ForroX']; }
if (isset($_POST['BajoPlomo']) and $_POST['BajoPlomo'] <> "") { $BajoPlomo = $_POST['BajoPlomo']; }
if (isset($_POST['CAFE']) and $_POST['CAFE'] <> "") { $CAFE = $_POST['CAFE']; }
if (isset($_POST['Argolla']) and $_POST['Argolla'] <> "") { $Argolla = $_POST['Argolla']; }
if (isset($_POST['Cinta']) and $_POST['Cinta'] <> "") { $Cinta = $_POST['Cinta']; }

// 💥 Traer datos del forro desde CortinaFnc.php
$valor = TraerPrecioTela($Clave, $TipoTela, $Alto, $Ancho, $Color, $Tela, $Stiffener, $ForroX, $BajoPlomo, $CAFE, $Argolla, $Cinta);

// =================== AJUSTE DEL FORRO =================== //
// El forro solo paga su tela + 30% de la mano de obra
$soloTela = $valor[0]['PrecioTela'] * $valor[0]['Metraje'];
$soloMO = ($valor[0]['PrecioMo'] * $valor[0]['MetrajeMo']) * 0.3;
$nuevoPrecioForro = $soloTela + $soloMO;

// Sobrescribimos el precio final recibido
$valor[0]['PrecioFinal'] = round($nuevoPrecioForro, 2);
$_POST['PrecioFinalForro'] = $valor[0]['PrecioFinal'];

// =================== SALIDA HTML =================== //
echo '<label class="label_total">Precio Forro</label>';
echo '<label id="PrecioFinal2" name="PrecioFinal2" class="label_cantidad">$' . number_format($valor[0]['PrecioFinal'], 2, '.', '') . ' MXP</label>';

echo "<!-- Campos ocultos -->";
echo "<input type='hidden' id='PrecioFinalForro' name='PrecioFinalForro' value='" . $valor[0]['PrecioFinal'] . "'>";
echo "<input type='hidden' id='CodigoTelaForro' name='CodigoTelaForro' value='" . $valor[0]['CodigoTela'] . "'>";
echo "<input type='hidden' id='PrecioTelaForro' name='PrecioTelaForro' value='" . $valor[0]['PrecioTela'] . "'>";
echo "<input type='hidden' id='CodigoMoForro' name='CodigoMoForro' value='" . $valor[0]['CodigoMo'] . "'>";
echo "<input type='hidden' id='PrecioMoForro' name='PrecioMoForro' value='" . $valor[0]['PrecioMo'] . "'>";
echo "<input type='hidden' id='MetrajeForro' name='MetrajeForro' value='" . $valor[0]['Metraje'] . "'>";
echo "<input type='hidden' id='LienzoTotalForro' name='LienzoTotalForro' value='" . $valor[0]['LienzoTotal'] . "'>";
echo "<input type='hidden' id='AlturaForro' name='AlturaForro' value='" . $valor[0]['Altura'] . "'>";
echo "<input type='hidden' id='Formula' name='Formula' value='" . $valor[0]['TipoFormula'] . "'>";
echo "<input type='hidden' id='MetrajeMoForro' name='MetrajeMoForro' value='" . $valor[0]['MetrajeMo'] . "'>";

?>
