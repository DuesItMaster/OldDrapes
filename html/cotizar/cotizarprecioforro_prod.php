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

if (isset($_POST['ColorForro']) and $_POST['ColorForro'] <> ""){ 
	$Color = $_POST['ColorForro'];
}

if (isset($_POST['TelaForro']) and $_POST['TelaForro'] <> ""){ 
	$Tela = $_POST['TelaForro'];
}

if (isset($_POST['TipoTelaForro']) and $_POST['TipoTelaForro'] <> ""){ 
	$TipoTela = $_POST['TipoTelaForro'];
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


	$valor = TraerPrecioTela($Clave,$TipoTela,$Alto,$Ancho,$Color,$Tela,$Stiffener,$ForroX,$BajoPlomo,$CAFE,$Argolla,$Cinta);

	/*$valor[0]['PrecioMoReal'] = $valor[0]['PrecioMoReal'] * $valor[0]['MetrajeMOReal'];
	$valor[0]['PrecioReal'] = $valor[0]['PrecioReal'] - $valor[0]['PrecioMoReal'];*/

	echo "<div class='form-group'> 
		<input type='hidden' id='PrecioFinalForro' name='PrecioFinalForro' class='form-control' value='".$valor[0]['PrecioFinal']."' style='text-align: right;' readonly>
		<input id='PrecioFinalForro2' name='PrecioFinalForro2' class='form-control' value='$ ".number_format($valor[0]["PrecioFinal"], 2, '.', ', ')."' style='text-align: right;' readonly>MXP
		<label><b>PRECIO FORRO:</b></label></div>";
	echo "<!-- <br>CodigoTelaForro--><input type='hidden' id='CodigoTelaForro' name='CodigoTelaForro' value='".$valor[0]['CodigoTela']."'>";
	echo "<!-- <br>PrecioTelaForro--><input  type='hidden' id='PrecioTelaForro' name='PrecioTelaForro' value='".$valor[0]['PrecioTela']."'>";
	echo "<!-- <br>CodigoMoForro--><input type='hidden' id='CodigoMoForro' name='CodigoMoForro' value='".$valor[0]['CodigoMo']."'>";
	echo "<!-- <br>PrecioMoForro--><input type='hidden' id='PrecioMoForro' name='PrecioMoForro' value='".$valor[0]['PrecioMo']."'>";
	echo "<!-- <br> METRAJE: --><input type='hidden' id='MetrajeForro' name='MetrajeForro' value='".$valor[0]['Metraje']."'>";
	echo "<!-- <br> LienzoTotal: --><input type='hidden' id='LienzoTotalForro' name='LienzoTotalForro' value='".$valor[0]['LienzoTotal']."'>";
	echo "<!-- <br> Altura: --><input type='hidden' id='AlturaForro' name='AlturaForro' value='".$valor[0]['Altura']."'>";
	echo "<!-- <br> Tipo Formula: --><input type='hidden' id='Formula' name='Formula' value='".$valor[0]['TipoFormula']."'>";
	echo "<!-- <br> MetrajeMOForro: --><input type='hidden' id='MetrajeMoForro' name='MetrajeMoForro' value='".$valor[0]['MetrajeMo']."'>"; 
	echo "<!--<br> MetrajeRealForro:--><input type='hidden' id='MetrajeRealForro' name='MetrajeRealForro' value='".$valor[0]['MetrajeReal']."'>";
	echo "<!--<br> MetrajeMORealForro:--><input type='hidden' id='MetrajeMORealForro' name='MetrajeMORealForro' value='".$valor[0]['MetrajeMOReal']."'>";
	echo "<!--<br> PrecioRealForro:--><input type='hidden' id='PrecioRealForro' name='PrecioRealForro' value='".$valor[0]['PrecioReal']."'>";
	echo "<!--<br> PrecioMoRealForro:--><input type='hidden' id='PrecioMoRealForro' name='PrecioMoRealForro' value='".$valor[0]['PrecioMoReal']."'>";

/*echo "Clave: " . $Clave . " Tipo tela: " . $TipoTela . " Alto: " . $Alto  . "Ancho: " . $Ancho . " Color: " . $Color . " Tela: " . $Tela . " Stifener: " .$Stiffener;
//echo "<br><br><br><br><br>".$valor;

echo " <br>Clave: " . $Clave . 
	 " <br> Tipo: " .	$TipoTela .
	 " <br> Tela: " .	$Tela .
	 " <br> Medida " . $Ancho . " x " . $Alto .
	 " <br> Color: " .	$Color . 
	 " <br> Stiffener: " . $Stiffener;*/



//				$Clave,  $Tipo,  $Alto,$Ancho,$TipoTela,$Color,$Tela
	 
	 


?>