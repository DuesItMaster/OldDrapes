<?php 
require_once '../fnc/PersianaFnc.php';

if (isset($_POST['Alto']) and $_POST['Alto'] <> ""){  
	$Alto = $_POST['Alto'];
}

if (isset($_POST['Ancho']) and $_POST['Ancho'] <> ""){  
	$Ancho = $_POST['Ancho'];
}

if (isset($_POST['Tela']) and $_POST['Tela'] <> ""){ 
	$Tela = $_POST['Tela'];
}

if (isset($_POST['Varilla']) and $_POST['Varilla'] <> ""){ 
	$Varilla = $_POST['Varilla'];
}

if (isset($_POST['Color']) and $_POST['Color'] <> ""){ 
	$Color = $_POST['Color'];
}

if (isset($_POST['Cantidad']) and $_POST['Cantidad'] <> ""){ 
	$Cantidad = $_POST['Cantidad'];
}

	//echo "PRECIO TOTAL";

	echo "Alto " . $Alto . " <br>Ancho:" . $Ancho . " <br>Tela: " . $Tela . " <br>Varilla: " . $Varilla. " <br>Color: " . $Color;
	$valor = PrecioTotal($Alto,$Ancho,$Tela,$Varilla,$Color);

	$bastillaAncho = 0.15;//PENDIENTE poner la bastilla en base de datos.
	$bastillaAlto = 0.15;//PENDIENTE poner la bastilla en basse de datos.
	$bastillaVarilla = 0.03;
	$espacioEntreVarillas = 0.25;

	//CORTES
	$corteAncho = $Ancho + $bastillaAncho; 
	$corteAlto = $Alto + $bastillaAlto;

	if($Varilla == "SI"){
		$numVarillas = intval($Alto / $espacioEntreVarillas);
		$corteAlto = $corteAlto + ($numVarillas*$bastillaVarilla);
	}

	//CORTE X LIENZO (ANCHO TELA = ANCHO PERSIANA)

	$lienzoCorteAncho = intval($GLOBALS['AnchoTela'] / $corteAncho);

	if($lienzoCorteAncho > 0){$cabeCorteAncho = "SI";}else{$cabeCorteAncho = "NO";}

	if($lienzoCorteAncho == 0){$lienzoParaPersianas1 = 0;}else{$lienzoParaPersianas1 = $Cantidad / $lienzoCorteAncho;}

	$lienzoParaPersianas2 = intval($lienzoParaPersianas1);

	$lienzoParaPersianas3 = $lienzoParaPersianas1 - $lienzoParaPersianas2;

	if($lienzoParaPersianas3 <= 0){$lienzoParaPersianas4 = $lienzoParaPersianas2;}else{$lienzoParaPersianas4 = $lienzoParaPersianas2 + 1;}

	if($lienzoCorteAncho == 0){$metrajeUnitarioXLienzo = 0;}
	else{$metrajeUnitarioXLienzo = (($corteAlto * $lienzoParaPersianas4) / $Cantidad) * 1.03;}//PENDIENTE FACTOR DESPERDICIO POR BASE DE DATOS


	//CÁLCULO METRAJE CORTE ATRAVESADO (ANCHO TELA = ALTO PERSIANA)

	$lienzoCorteAlto = intval($GLOBALS['AnchoTela'] / $corteAlto);

	if($lienzoCorteAlto > 0){$cabeCorteAltoMl = "SI";}else{$cabeCorteAltoMl = "NO";}

	//echo'<script type="text/javascript"> alert("'.$Cantidad.'"); window.location.href="index.php"; </script>';
	//echo'<script type="text/javascript"> alert("'.$lienzoCorteAlto.'"); window.location.href="index.php"; </script>';

	if($lienzoCorteAlto == 0){$lienzoParaPersianasMl1 = 0;}else{$lienzoParaPersianasMl1 = $Cantidad / $lienzoCorteAlto;}

	$lienzoParaPersianasMl2 = intval($lienzoParaPersianasMl1);

	$lienzoParaPersianasMl3 = $lienzoParaPersianasMl1 - $lienzoParaPersianasMl2;

	if($lienzoParaPersianasMl3 <= 0){$lienzoParaPersianasMl4 = $lienzoParaPersianasMl2;}else{$lienzoParaPersianasMl4 = $lienzoParaPersianasMl2 + 1;}

	if($lienzoCorteAlto == 0){$metrajeUnitarioXML = 0;}
	else{$metrajeUnitarioXML = (($corteAncho * $lienzoParaPersianasMl4) / $Cantidad) * 1.03;}//PENDIENTE FACTOR DESPERDICIO POR BASE DE DATOS

	if($metrajeUnitarioXLienzo == 0 && $metrajeUnitarioXML == 0){$metrajeUnitarioFinal = 0;}
	elseif($metrajeUnitarioXLienzo == 0 || $metrajeUnitarioXML == 0){
		if($metrajeUnitarioXLienzo == 0){$metrajeUnitarioFinal = $metrajeUnitarioXML;}
		else{$metrajeUnitarioFinal = $metrajeUnitarioXLienzo;}
	}
	else{
		if($metrajeUnitarioXLienzo <= $metrajeUnitarioXML){$metrajeUnitarioFinal = $metrajeUnitarioXLienzo;}
		else{$metrajeUnitarioFinal = $metrajeUnitarioXML;}
	}
	//TOTALES FINALES
	$metrajeTotal = $metrajeUnitarioFinal * $Cantidad;

	$totalTela = $metrajeTotal * $valor[0]['PrecioTela'];

	$cantidadMecanismo = $Cantidad;
	$totalMecanismo = $cantidadMecanismo * $valor[0]['PrecioMecanismo'];

	$totalPacheto = $totalTela + $totalMecanismo;
	// Si el acoplamiento es a dos hojas, duplicamos el total
if (isset($_POST['Acoplamiento']) && strtoupper($_POST['Acoplamiento']) === 'AMBOS') {
    $totalPacheto *= 2;
}

	$precioUnitarioPacheto = $totalPacheto / $Cantidad;


	$ManoObraForro = $valor[0]['PrecioMo']/2;

	echo "<div style='display:none;' class='form-group'>
	<input id='PrecioFinal2' class='form-control' name='PrecioFinal2' value='$ ".number_format($precioUnitarioPacheto, 2, '.', ', ')."' style='text-align: right;' readonly>MXP
			<label><b>PRECIO TOTALl:</b></label>
		</div>
		  <input type = 'hidden' id='PrecioFinal' class='form-control' name='PrecioFinal' value='".$precioUnitarioPacheto."' style='text-align: right;' readonly>";
    echo "<!--<br><h3>PARÁMETROS</h3>-->";
    echo "<!--<br>Ancho Tela--><input type = 'hidden' id='AnchoTela' name='AnchoTela' value='".$GLOBALS['AnchoTela']."'>";
    echo "<!--<br>Tipo Tela--><input type = 'hidden' id='TipoTela2' name='TipoTela2' value='".$GLOBALS['tipoTela']."'>";
    echo "<!--<br><h3>BASTILLAS</h3>-->";
    echo "<!--<br>Bastilla Ancho--><input type = 'hidden' id='BAn' name='BA' value='".$bastillaAncho."'>";
	echo "<!--<br>Bastilla Alto--><input type = 'hidden' id='BAl' name='BAl' value='".$bastillaAlto."'>";
    echo "<!--<br><h3>CORTES</h3>-->";
	echo "<!--<br>Corte Ancho--><input type = 'hidden' id='CorteAncho' name='CorteAncho' value='".$corteAncho."'>";
	echo "<!--<br>Corte Alto--><input type = 'hidden' id='CorteAlto' name='CorteAlto' value='".$corteAlto."'>";
	echo "<!--<br><h3>CORTE X LIENZO (ANCHO TELA = ANCHO PERSIANA)</h3>-->";
	echo "<!--<br>Lienzos Corte Ancho--><input type = 'hidden' id='lca' name='lca' value='".$lienzoCorteAncho."'>";
	echo "<!--<br>Cabe Corte Ancho--><input type = 'hidden' id='cca' name='cca' value='".$cabeCorteAncho ."'>";	
	echo "<!--<br>Lienzos para persianas 1--><input type = 'hidden' id='lpp1' name='lpp1' value='".$lienzoParaPersianas1."'>"; 
	echo "<!--<br>Lienzos para persianas 2--><input type = 'hidden' id='lpp2' name='lpp1' value='".$lienzoParaPersianas2."'>";  
	echo "<!--<br>Lienzos para persianas 3--><input type = 'hidden' id='lpp3' name='lpp1' value='".$lienzoParaPersianas3."'>";  
	echo "<!--<br>Lienzos para persianas 4--><input type = 'hidden' id='lpp4' name='lpp1' value='".$lienzoParaPersianas4."'>";
	echo "<!--<br>Metraje Unitario X Lienzo--><input type = 'hidden' id='metrajeUnitarioXLienzo' name='metrajeUnitarioXLienzo' value='".$metrajeUnitarioXLienzo."'>";  
	echo "<!--<br><h3>CÁLCULO METRAJE METRO LINEAL (ANCHO TELA = ALTO PERSIANA)</h3>-->";
	echo "<!--<br>Lienzos Corte Alto --><input type = 'hidden' id='lcaMl' name='lcaMl' value='".$lienzoCorteAlto."'>";
	echo "<!--<br>Cabe Corte Alto <input type = 'hidden' id='ccaMl' name='ccaMl' value='".$cabeCorteAltoMl."'>";	
	echo "<!--<br>Lienzos para persianas 1 ML --><input type = 'hidden' id='lpp1Ml' name='lpp1Ml' value='".$lienzoParaPersianasMl1."'>"; 
	echo "<!--<br>Lienzos para persianas 2 ML --><input type = 'hidden' id='lpp2Ml' name='lpp1Ml' value='".$lienzoParaPersianasMl2."'>";  
	echo "<!--<br>Lienzos para persianas 3 ML --><input type = 'hidden' id='lpp3Ml' name='lpp1Ml' value='".$lienzoParaPersianasMl3."'>";  
	echo "<!--<br>Lienzos para persianas 4 ML --><input type = 'hidden' id='lpp4Ml' name='lpp1Ml' value='".$lienzoParaPersianasMl4."'>";   
	echo "<!--<br>Metraje Unitario X ML --><input type = 'hidden' id='metrajeUnitarioXML' name='metrajeUnitarioXML' value='".$metrajeUnitarioXML."'>";  
	echo "<!--<br><h3>RESULTADOS FINALES--></h3>";
	echo "<!--<br>Metraje Unitario Final --><input type = 'hidden' id='metrajeUnitarioFinal' name='metrajeUnitarioFinal' value='".$metrajeUnitarioFinal."'>"; 
	echo "<!--<br>Metraje Total --><input type = 'hidden' id='metrajeTotal' name='metrajeTotal' value='".$metrajeTotal."'>"; 
	echo "<!--<br>Codigo Tela --><input type = 'hidden' id='CodigoTela' name='CodigoTela' value='".$valor[0]['CodigoTela']."'>";
	echo "<!--<br>Precio Tela--><input type = 'hidden' id='PrecioTela' name='PrecioTela' value='".$valor[0]['PrecioTela']."'>";
	echo "<!--<br>Total Tela --><input type = 'hidden' id='totalTela' name='totalTela' value='".$totalTela."'>";
	echo "<!--<br>Cantidad Mecanismo --><input type = 'hidden' id='cantidadMecanismo' name='cantidadMecanismo' value='".$cantidadMecanismo."'>"; 
	echo "<!--<br>Codigo Mecanismo: --><input type = 'hidden' id='CodigoMecanismo' name='CodigoMecanismo' value='".$valor[0]['CodigoMecanismo']."'>";
	echo "<!--<br>Precio Mecanismo: --><input type = 'hidden' id='PrecioMecanismo' name='PrecioMecanismo' value='".$valor[0]['PrecioMecanismo']."'>";
	echo "<!--<br>Codigo Comodin --><input type = 'hidden' id='CodigoComodin' name='CodigoComodin' value='".$valor[0]['CodigoComodin']."'>";
	echo "<!--<br>Total Mecanismo: --><input type = 'hidden' id='totalMecanismo' name='totalMecanismo' value='".$totalMecanismo."'>";
	echo "<!--<br>Precio Total: --><input type = 'hidden' id='precioUnitarioPacheto' name='precioUnitarioPacheto' value='".$precioUnitarioPacheto."'>";
	//echo "<br><h3>CÁLCULO ANTERIOR</h3>";
	//echo "<br>CodigoTela <input id='CodigoTela' name='CodigoTela' value='".$valor[0]['CodigoTela']."'>";
	//echo "<br>CodigoMecanismo: <input id='CodigoMecanismo' name='CodigoMecanismo' value='".$valor[0]['CodigoMecanismo']."'>";
	//echo "<br>PrecioMecanismo: <input id='PrecioMecanismo' name='PrecioMecanismo' value='".$valor[0]['PrecioMecanismo']."'>";
	//echo "<br>PrecioTela<input id='PrecioTela' name='PrecioTela' value='".$valor[0]['PrecioTela']."'>";
	//echo "<br>CodigoComodin<input id='CodigoComodin' name='CodigoComodin' value='".$valor[0]['CodigoComodin']."'>";
	//echo "<br>Metraje<input id='Metraje' name='Metraje' value='".$valor[0]['Metraje']."'>";
	//echo "<br>CodigoMoForro<input id='CodigoMoForro' name='CodigoMoForro' value='".$valor[0]['CodigoMo']."'>";
	//echo "<br>PrecioMoForro<input id='PrecioMoForro' name='PrecioMoForro' value='".number_format($ManoObraForro, 2, '.', ', ')."'>";
	//echo "<br> PRECIO : " .$Precio;
	//echo '<input id="PrecioFinal" name="PrecioFinal" value="'.$Precio.'">';

	/*echo "ENTRO";
	echo "<BR> PRECIO: " . $Precio;*/
	//echo '<BR> <div class="form-group"><input class="form-control" id="precioFinal" type="text" value="$ '.number_format($totalPacheto, 2, '.', ', ').'" style="text-align: right;" readonly>MXP<label><b>PRECIO TOTAL:</b></label></div>'. ''.
			   //'<input type="hidden" class="form-control" id="precioFinal"  value="'.$totalPacheto.'" style="text-align: right;" readonly>';





?>

