<?php

require_once '../fnc/GaleriaFnc.php'; 

if (isset($_POST['Operacion']) and $_POST['Operacion'] <> ""){ 
	$Operacion = $_POST['Operacion'];
}

if (isset($_POST['CodigoTela']) and $_POST['CodigoTela'] <> ""){ 
	$CodigoTela = $_POST['CodigoTela'];
}

if (isset($_POST['AnchoTela']) and $_POST['AnchoTela'] <> ""){ 
	$AnchoTela = $_POST['AnchoTela'];
}

if (isset($_POST['AprovTela']) and $_POST['AprovTela'] <> ""){ 
	$AprovTela = $_POST['AprovTela'];
}

if (isset($_POST['MetrajeGaleria']) and $_POST['MetrajeGaleria'] <> ""){ 
	$MetrajeGaleria = $_POST['MetrajeGaleria'];
}

if (isset($_POST['idProducto']) and $_POST['idProducto'] <> ""){ 
	$idProducto = $_POST['idProducto'];
}

/*if (isset($_POST['proyeccionIzquierda']) and $_POST['proyeccionIzquierda'] <> ""){ 
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
}*/


	if($Operacion == 'AGREGAR'){
		$prueba = agregarGaleriaAprovechamiento($CodigoTela,$AnchoTela,$AprovTela,$MetrajeGaleria);
		echo $prueba;
		//echo '<script language="javascript">alert("'.$prueba.'");</script>';
	}else if($Operacion == 'ASIGNAR_APROVECHAMIENTO'){
		$prueba = asignarAprovechamiento($idProducto,$MetrajeGaleria);
		echo $prueba;
	}
	//echo "PRECIO TOTAL";

	//echo "Fijacion " . $Fijacion . " <br>Copete:" . $Copete . " <br>Ancho: " . $Ancho . " <br>Tela: " . $Tela. " <br>Color: " . $Color;
	
	//$Precio = PrecioTotal($Ancho,$Tela,$Color,$Fijacion,$Copete,$TipoTela,$proyeccionIzquierda,$proyeccionDerecha,$medidaCopete,$alto,$Cantidad);

	//echo $Precio;

	//echo "<div class='form-group'><input id='PrecioFinal' class='form-control' name='PrecioFinal' value='".$Precio."' style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>";

	

?>