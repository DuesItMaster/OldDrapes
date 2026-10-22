<?php
require_once '../fnc/CortinaFnc.php'; 

if (isset($_POST['Clave']) and $_POST['Clave'] <> ""){ 
	$Clave = $_POST['Clave'];
}

if (isset($_POST['Ancho']) and $_POST['Ancho'] <> ""){ 
	$Ancho = $_POST['Ancho'];
}

if (isset($_POST['Alto']) and $_POST['Alto'] <> ""){ 
	$Alto = $_POST['Alto'];
}

if (isset($_POST['Color']) and $_POST['Color'] <> ""){ 
	$Color = $_POST['Color'];
}

if (isset($_POST['Tela']) and $_POST['Tela'] <> ""){ 
	$Tela = $_POST['Tela'];
}

if (isset($_POST['TipoTela']) and $_POST['TipoTela'] <> ""){ 
	$TipoTela = $_POST['TipoTela'];
}

if (isset($_POST['Stiffener']) and $_POST['Stiffener'] <> ""){ 
	$Stiffener = $_POST['Stiffener'];
}

if (isset($_POST['ForroX']) and $_POST['ForroX'] <> ""){ 
	$ForroX = $_POST['ForroX'];
}

if (isset($_POST['BajoPlomo']) and $_POST['BajoPlomo'] <> ""){ 
	$BajoPlomo = $_POST['BajoPlomo'];
}

if (isset($_POST['CAFE']) and $_POST['CAFE'] <> ""){ 
	$CAFE = $_POST['CAFE'];
}

if (isset($_POST['Argolla']) and $_POST['Argolla'] <> ""){ 
	$Argolla = $_POST['Argolla'];
}

if (isset($_POST['Cinta']) and $_POST['Cinta'] <> ""){ 
	$Cinta = $_POST['Cinta'];
}



	//$valor = array();
	$valor = TraerPrecioTela($Clave,$TipoTela,$Alto,$Ancho,$Color,$Tela,$Stiffener,$ForroX,$BajoPlomo,$CAFE,$Argolla,$Cinta);

	/*if ($Alto > 3) {
		$PrecioFinal = $valor[0]["Precio"] + ($valor[0]['PrecioMo'] * ($valor[0]['MetrajeMo']/2));
		//$PrecioFinalReal = $valor[0]["PrecioReal"] + ($valor[0]['PrecioMoReal'] * ($valor[0]['MetrajeMOReal']/2));
	} else {
		$PrecioFinal = $valor[0]["Precio"] ;
		//$PrecioFinalReal = $valor[0]["PrecioReal"];
	}*/
/*
	if ($Argolla == "SI"){
		//print_r($valor[0]["PrecioArgolla"]);
		$PrecioFinal = $PrecioFinal + ($valor[0]["PrecioArgolla"] * $valor[0]["CantidadArgolla"]); //* $CantidadArgolla
		print_r($PrecioFinal);
	}
*/
/*
	$valor[0]['PrecioMoReal'] = $valor[0]['PrecioMoReal'] * $valor[0]['MetrajeMOReal'];
	$valor[0]['PrecioReal'] = $valor[0]['PrecioReal'] - $valor[0]['PrecioMoReal'];*/


	/*if ($Ancho > 3) {

		$PrecioFinal = $valor[0]["Precio"] + ($valor[0]['PrecioMo'] / 2);

	}*/
	//echo $valor;
	//echo " Valores de Cortina: <br>";

	//$ManoObraForro = $valor[0]['PrecioMo']/2;

	//$GLOBALS[ValorFinalPrecio]  = $valor[0]['Precio'];
	

	///////AGREGADO TELLAS RAYADAS//////////////
	//IDENTIFICA SI LA TELA ES RAYADA Y EN SU CASO, LA ORIENTACIÓN QUE TIENE LA RAYA	
	if(strtoupper($valor[0]['rapportVert']) == 'INFINITO'){
		$orientaciónRaya = 'Vertical';
	}elseif(strtoupper($valor[0]['rapportHor']) == 'INFINITO'){
		$orientaciónRaya = 'Horizontal';
	}else{
		$orientaciónRaya = 'N/A';
	}

	if($orientaciónRaya <> 'N/A'){
		//IDENTIFICA EL TIPO DE CÁLCULO DE ACUERDO A LA FÓRMULA UTILIZADA
		if($valor[0]['TipoFormula'] == 'Cortina Atravezada con Rapport' ||  $valor[0]['TipoFormula'] == 'Cortina Atravezada' || $valor[0]['TipoFormula'] == 'Bajo Plomo'){
			$tipoCalculo = 'ML';
		}elseif($valor[0]['TipoFormula'] == 'Medio Lienzo' ||  $valor[0]['TipoFormula'] == 'Normal' ||  $valor[0]['TipoFormula'] == 'Medio Lienzo con rapport' || $valor[0]['TipoFormula'] == 'Normal Rapport'){
			$tipoCalculo = 'LZO';
		}
	
		//IDENTIFICA LA ORIENTACIÓN FINAL DE LA CORTINA DE ACUERDO A LA ORIENTACIÓN DE LA RAYA Y EL TIPO DE CÁLCULO UTILIZADO
		if($orientaciónRaya == 'Vertical'){
			if($tipoCalculo == 'ML'){
				$orientacionCortina = 'Horizontal';
			}elseif($tipoCalculo == 'LZO'){
				$orientacionCortina = 'Vertical';
			}
		}elseif($orientaciónRaya == 'Horizontal'){
			if($tipoCalculo == 'ML'){
				$orientacionCortina = 'Vertical';
			}elseif($tipoCalculo == 'LZO'){
				$orientacionCortina = 'Horizontal';
			}
		}
	}
	///////AGREGADO TELLAS RAYADAS//////////////

	echo "<div class='form-group'><input type='hidden' id='PrecioFinal' class='form-control' name='PrecioFinal' value='".number_format($valor[0]['PrecioFinal'], 2, '.', '')."' style='text-align: right;' readonly>
									<input id='PrecioFinal2' class='form-control' name='PrecioFinal2' value='$ ".number_format($valor[0]['PrecioFinal'], 2, '.', ', ')."' style='text-align: right;' readonly>MXP<label><b>PRECIO TOTAL:</b></label></div>";
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