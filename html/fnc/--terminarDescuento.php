<?php

require_once '../../conexion/cnx.php';


function TraerDescuento($id_usuario){
	$Desc = Array();
	$sql = "SELECT descuento from usuario_desc where id_usuario=".$id_usuario." order by descuento desc;";
		
	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	    	array_push($Desc, $row["descuento"]);    
	    }
	} 

	return $Desc;

}



function GenerarDescuento($Importe){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuento($_SESSION['login_user']);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = $Importe;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		return $porcentaje;

	} else {

		return 0;
	}
}



function GenerarPorcentaje(){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuento($_SESSION['login_user']);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = 100;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		$porcentajeFinal = 100 - $porcentaje;
		return $porcentajeFinal;

	} else {

		return 0;
	}
}
// **************************************************************************************************

function GenerarCantidadFinal($TotalPorcentaje,$Precio,$Unidades){

	if ($TotalPorcentaje==0){
		return "0.00";
	}
	else{
		
		$valor = ($Unidades * $Precio) *  ($TotalPorcentaje / 100) ;
		return $valor;
	}
	
}


// *************************************************************************************************

function TraerDescuentoPorID($idCot){
	$Desc = Array();
	$sql = "SELECT descuento from cotizacion_descuento where id_cotizacion=".$idCot." order by descuento desc;";
		
	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	    	array_push($Desc, $row["descuento"]);    
	    }
	} 

	return $Desc;

}



function GenerarDescuentoPorID($Importe,$idCot){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuentoPorID($idCot);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = $Importe;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		return $porcentaje;

	} else {

		return 0;
	}
}



function GenerarPorcentajePorId($idCot){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuentoPorID($idCot);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = 100;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		$porcentajeFinal = 100 - $porcentaje;
		return $porcentajeFinal;

	} else {

		return 0;
	}
}


/*function SumarDescuento($Importe){

			//echo "ENTRO A DESCUENTO" ;
			$Descuento = TraerDescuento($_SESSION['login_user']);
			//$porcentaje = $carrito->precio_total();
			$porcentaje = $Importe;
			$valor = 0;
			
			if (count($Descuento)>0){
				foreach ($Descuento as $Desc) {
					$valor = $valor - ($porcentaje * ($Desc/100));
					$porcentaje  = $porcentaje -$valor;
				}

				return $valor;

			} else {

				return 0;
			}

		}*/

?>