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



	$valor = PrecioTotal($Alto,$Ancho,$Tela,$Varilla,$Color,TRUE);


	//echo "color forro: " . $_POST['Color'];
	
	if (isset($_POST['Color']) and $_POST['Color'] <> ""){ 
		echo "<div class='form-group'>
			<input  class='form-control' id='PrecioFinalForro2' name='PrecioFinalForro' value='$ ".number_format($valor[0]['Precio'], 2, '.', ', ')."' style='text-align: right;' readonly>MXP
			<input  type='hidden' class='form-control' id='PrecioFinalForro' name='PrecioFinalForro' value='".$valor[0]['Precio']."' style='text-align: right;' readonly>
		<label><b>PRECIO FORRO:</b></label>
		</div>";	
	}
	else{
		echo "<div class='form-group'>
			<input  class='form-control' id='PrecioFinalForro' name='PrecioFinalForro' value='$ 0.00' style='text-align: right;' readonly>MXP
			<label><b>PRECIO FORRO:</b></label>
			</div>";	
	}

	
	echo "<!--<br>CodigoTela--><input type='hidden' id='CodigoTelaForro' name='CodigoTelaForro' value='".$valor[0]['CodigoTela']."'>";
	echo "<!--<br>CodigoMecanismo--><input type='hidden' id='CodigoMecanismo' name='CodigoMecanismo' value='".$valor[0]['CodigoMecanismo']."'>";
	echo "<!--<br>PrecioTela--><input type='hidden' id='PrecioTelaForro' name='PrecioTelaForro' value='".$valor[0]['PrecioTela']."'>";
	echo "<!--<br>Metraje--><input type='hidden' id='MetrajeForro' name='MetrajeForro' value='".$valor[0]['Metraje']."'>";

	//echo "<br> PRECIO : " .$Precio;
	//echo '<input id="PrecioFinal" name="PrecioFinal" value="'.$Precio.'">';

	/*echo "ENTRO";
	echo "<BR> PRECIO: " . $Precio;*/




?>