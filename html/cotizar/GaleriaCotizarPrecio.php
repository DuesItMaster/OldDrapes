<?php

require_once '../fnc/GaleriaFnc.php';

if (isset($_POST['Fijacion']) and $_POST['Fijacion'] <> ""){ 
	$Fijacion = $_POST['Fijacion'];
}

if (isset($_POST['Copete']) and $_POST['Copete'] <> ""){ 
	$Copete = $_POST['Copete'];
}

if (isset($_POST['Ancho']) and $_POST['Ancho'] <> ""){ 
	$Ancho = $_POST['Ancho'];
}

if (isset($_POST['Tela']) and $_POST['Tela'] <> ""){ 
	$Tela = $_POST['Tela'];
}

if (isset($_POST['Color']) and $_POST['Color'] <> ""){ 
	$Color = $_POST['Color'];
}

if (isset($_POST['TipoTela']) and $_POST['TipoTela'] <> ""){ 
	$TipoTela = $_POST['TipoTela'];
}

if (isset($_POST['proyeccionIzquierda']) and $_POST['proyeccionIzquierda'] <> ""){ 
	$proyeccionIzquierda = $_POST['proyeccionIzquierda'];
}

if (isset($_POST['proyeccionDerecha']) and $_POST['proyeccionDerecha'] <> ""){ 
	$proyeccionDerecha = $_POST['proyeccionDerecha'];
}

if (isset($_POST['medidaCopete']) and $_POST['medidaCopete'] <> ""){ 
	$medidaCopete = $_POST['medidaCopete'];
}

if (isset($_POST['alto']) and $_POST['alto'] <> ""){ 
	$alto = $_POST['alto'];
}

if (isset($_POST['Cantidad']) and $_POST['Cantidad'] <> ""){ 
	$Cantidad = $_POST['Cantidad'];
}

if (isset($_POST['ConsecAprov']) and $_POST['ConsecAprov'] <> ""){ 
	$ConsecAprov = $_POST['ConsecAprov'];
}

if (isset($_POST['MetrajeReal']) and $_POST['MetrajeReal'] <> ""){ 
	$MetrajeReal = $_POST['MetrajeReal'];
}

if (isset($_POST['MetrajeGaleria']) and $_POST['MetrajeGaleria'] <> ""){ 
	$MetrajeGaleria = $_POST['MetrajeGaleria'];
}

if (isset($_POST['CodigoTela']) and $_POST['CodigoTela'] <> ""){ 
	$CodigoTela = $_POST['CodigoTela'];
}

if (isset($_POST['id']) and $_POST['id'] <> ""){ 
	$id = $_POST['id'];
}

	//echo "PRECIO TOTAL";
	//echo "Fijacion " . $Fijacion . " <br>Copete:" . $Copete . " <br>Ancho: " . $Ancho . " <br>Tela: " . $Tela. " <br>Color: " . $Color;
	
	$Precio = PrecioTotal($Ancho,$Tela,$Color,$Fijacion,$Copete,$TipoTela,$proyeccionIzquierda,$proyeccionDerecha,$medidaCopete,$alto,$Cantidad,$id,$ConsecAprov,$MetrajeReal,$MetrajeGaleria,$CodigoTela);

	echo $Precio;

	//echo "<div class='form-group'><input id='PrecioFinal' class='form-control' name='PrecioFinal' value='".$Precio."' style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>";
?>