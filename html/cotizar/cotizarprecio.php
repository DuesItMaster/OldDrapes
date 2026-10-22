<?php

require_once '../fnc/CortinaFnc.php';

// 1️⃣ Primero recibir todos los POST
if (isset($_POST['Clave']) && $_POST['Clave'] <> "") { $Clave = $_POST['Clave']; }
if (isset($_POST['Ancho']) && $_POST['Ancho'] <> "") { $Ancho = $_POST['Ancho']; }
if (isset($_POST['Alto']) && $_POST['Alto'] <> "") { $Alto = $_POST['Alto']; }
if (isset($_POST['Color']) && $_POST['Color'] <> "") { $Color = $_POST['Color']; }
if (isset($_POST['Tela']) && $_POST['Tela'] <> "") { $Tela = $_POST['Tela']; }
if (isset($_POST['TipoTela']) && $_POST['TipoTela'] <> "") { $TipoTela = $_POST['TipoTela']; }
if (isset($_POST['Stiffener']) && $_POST['Stiffener'] <> "") { $Stiffener = $_POST['Stiffener']; }
if (isset($_POST['ForroX']) && $_POST['ForroX'] <> "") { $ForroX = $_POST['ForroX']; }
if (isset($_POST['BajoPlomo']) && $_POST['BajoPlomo'] <> "") { $BajoPlomo = $_POST['BajoPlomo']; }
if (isset($_POST['CAFE']) && $_POST['CAFE'] <> "") { $CAFE = $_POST['CAFE']; }
if (isset($_POST['Argolla']) && $_POST['Argolla'] <> "") { $Argolla = $_POST['Argolla']; }
if (isset($_POST['Cinta']) && $_POST['Cinta'] <> "") { $Cinta = $_POST['Cinta']; }
$numHojas = isset($_POST['numHojas']) ? $_POST['numHojas'] : 1;

// 2️⃣ Luego sí, calcular precio
$valor = TraerPrecioTela($Clave, $TipoTela, $Alto, $Ancho, $Color, $Tela, $Stiffener, $ForroX, $BajoPlomo, $CAFE, $Argolla, $Cinta, $numHojas);

// 3️⃣ Y de inmediato ajustar si tiene forro
if (isset($ForroX) && strtoupper(trim($ForroX)) === "SI") {
    // Aplica ajuste especial para cortinas con forro
    $soloTela = $valor[0]['PrecioTela'] * $valor[0]['Metraje'];
    $soloMO   = ($valor[0]['PrecioMo'] * $valor[0]['MetrajeMo']) * 0.3;

    // 🔥 Aplica el nuevo precio total
    $valor[0]['PrecioFinal'] = $soloTela + $soloMO;

    // También actualiza el campo PrecioForro si existe
    $valor[0]['PrecioForro'] = $soloMO;
} else {
    // Normal

    // Cargo por Altura  mayor o igual a  3m en una hoja
    if ($Alto >= 3.00) {
        $valor[0]['PrecioFinal'] += ($valor[0]['PrecioMo'] * ($valor[0]['MetrajeMo']/2));
    }

    // Cargo por Ancho mayor o igual a  5m en una hoja
    if ($Ancho >= 5.00) {
        $valor[0]['PrecioFinal'] += ($valor[0]['PrecioMo'] * ($valor[0]['MetrajeMo']/2));
    }
}

error_log("ForroX recibido: '$ForroX'"); 

if (isset($ForroX) && strtoupper(trim($ForroX)) === "SI") {
    echo '<label class="label_total" style="color:#9be29b;">Precio Total (con forro)</label>';
    echo '<label id="PrecioFinal2" name="PrecioFinal2" class="label_cantidad" style="color:#9be29b;">$'.number_format($valor[0]['PrecioFinal'], 2, '.', ',').' MXP</label>';
} else {
    echo '<label class="label_total">Precio Total</label>';
    echo '<label id="PrecioFinal2" name="PrecioFinal2" class="label_cantidad">$'.number_format($valor[0]['PrecioFinal'], 2, '.', ',').' MXP</label>';
}

	echo "<input type='hidden' id='PrecioFinal' class='form-control' name='PrecioFinal' value='".number_format($valor[0]['PrecioFinal'], 2, '.', '')."' style='text-align: right;' readonly>";
	
	echo "<!--<br> CODIGO TELA:--><input type='hidden' id='CodigoTela' name='CodigoTela' value='".$valor[0]['CodigoTela']."'>";
	echo "<!--<br> PRECIO TELA:--><input type='hidden' id='PrecioTela' name='PrecioTela' value='".$valor[0]['PrecioTela']."'>";
	echo "<!--<br> CODIGO MO:--><input id='CodigoMo' type='hidden' name='CodigoMo' value='".$valor[0]['CodigoMo']."'>";
	echo "<!--<br> PRECIO MO:--> <input type='hidden' id='PrecioMo' name='PrecioMo' value='".$valor[0]['PrecioMo']."'>";
	//echo "<br>CodigoMoForro<input type='text' id='CodigoMoForro' name='CodigoMoForro' value='".$valor[0]['CodigoMo']."'>";
	//echo  "<br>PrecioMoForro<input id='PrecioMoForro' name='PrecioMoForro' value='".number_format($ManoObraForro, 2, '.', ', ')."'>";
	echo "<!--<br> PRECIO COMODIN:--><input type='hidden' id='CodigoComodin' name='CodigoComodin' value='".$valor[0]['CodigoComodin']."'>";
	echo "<!--<br> METRAJE:--><input id='Metraje' type='hidden' name='Metraje' value='".$valor[0]['Metraje']."'>";
	echo "<!--<br> LienzoTotal:--><input id='LienzoTotal' type='hidden' name='LienzoTotal' value='".$valor[0]['LienzoTotal']."'>";
	echo "<!--<br> Altura:--><input id='Altura' type='hidden' name='Altura' value='".$valor[0]['Altura']."'>";
	echo "<!--<br> CodigoStiffener:--><input type='hidden' id='CodigoStiffener' name='CodigoStiffener' value='".$valor[0]['CodigoStiffener']."'>";
	echo "<!--<br> PrecioStiffener:--><input type='hidden' id='PrecioStiffener' name='PrecioStiffener' value='".$valor[0]['PrecioStiffener']."'>";
	echo "<!--<br> Tipo Formula:--><input id='Formula' type='hidden' name='Formula' value='".$valor[0]['TipoFormula']."'>";
	echo "<!--<br> Metraje MO:--><input id='MetrajeMo' type='hidden' name='MetrajeMo' value='".$valor[0]['MetrajeMo']."'>";
	echo "<!--<br> TipoManoObra:--><input id='TipoManoObra' type='hidden' name='TipoManoObra' value='".$valor[0]['TipoManoObra']."'>";
	echo "<!--<br> Tipo:--><input type='hidden' id='Tipo' name='Tipo' value='".$valor[0]['Tipo']."'>";
	echo "<!--<br> rapportAltura:--><input type='hidden' id='rapportAltura' name='rapportAltura' value='".$valor[0]['rapportAltura']."'>";
	echo "<!--<br> rapportVert:--><input type='hidden' id='rapportVert' name='rapportVert' value='".$valor[0]['rapportVert']."'>";
	echo "<!--<br> rapportHor:--><input type='hidden' id='rapportHor' name='rapportHor' value='".$valor[0]['rapportHor']."'>";
	echo "<!--<br> Orientacion Raya Cortina:--><input type='hidden' id='orientacionCortina' name='orientacionCortina' value='".$orientacionCortina."'>";
	echo "<!--<br> Precio Bplomo:--><input type='hidden' id='PrecioPlomo' name='PrecioPlomo' value='".$valor[0]['PrecioPlomo']."'>";
	echo "<!--<br> Bplomo:--><input type='hidden' id='TelaBajoPlomo' name='TelaBajoPlomo' value='".$valor[0]['TelaBajoPlomo']."'>";
	echo "<!--<br> CodigoBajoPlomo:--><input type='hidden' id='CodigoBajoPlomo' name='CodigoBajoPlomo' value='".$valor[0]['CodigoBajoPlomo']."'>";
	echo "<!--<br> MetrajeBajoPlomo:--><input type='hidden' id='MetrajeBajoPlomo' name='MetrajeBajoPlomo' value='".$valor[0]['MetrajeBajoPlomo']."'>";
	echo "<!--<br> MetrajeReal:--><input id='MetrajeReal' type='hidden'  name='MetrajeReal' value='".$valor[0]['MetrajeReal']."'>";
	echo "<!--<br> MetrajeMOReal:--><input id='MetrajeMOReal' type='hidden' name='MetrajeMOReal' value='".$valor[0]['MetrajeMOReal']."'>";
	echo "<!--<br> PrecioReal:--><input type='hidden' id='PrecioReal' name='PrecioReal' value='".$valor[0]["PrecioReal"]."'>";
	echo "<!--<br> PrecioMoReal: --><input id='PrecioMoReal' type='hidden' name='PrecioMoReal' value='".$valor[0]['PrecioMoReal']."'>";
	echo "<!--<br> CodigoArgolla:--><input type='hidden' id='CodigoArgolla' name='CodigoArgolla' value='".$valor[0]["CodigoArgolla"]."'>";
	echo "<!--<br> PrecioArgolla:--><input type='hidden' id='PrecioArgolla' name='PrecioArgolla' value='".$valor[0]['PrecioArgolla']."'>";
	echo "<!--<br> CantidadArgolla:--><input type='hidden' id='CantidadArgolla' name='CantidadArgolla' value='".$valor[0]['CantidadArgolla']."'>";
	echo "<!--<br> MetrajeBajoPlomoReal:--><input type='hidden' id='MetrajeBajoPlomoReal' name='MetrajeBajoPlomoReal' value='".$valor[0]['MetrajeBajoPlomoReal']."'>";

	//echo " <br>Aqui termina<br>";
	//echo "PRECIO FINAL: " . $valor;

/*echo " <br> Clave: " . $Clave . 
	 " <br> Tipo: " .	$TipoTela .
	 " <br> Tela: " .	$Tela .
	 " <br> Medida " . $Ancho . " x " . $Alto .
	 " <br> Color: " .	$Color . 
	 " <br> Stiffener: " . $Stiffener;*/

//$Clave,  $Tipo,  $Alto,$Ancho,$TipoTela,$Color,$Tela
?>