<?php

function CotizarPersiana($Alto, $Ancho, $Varilla, $PrecioMecanismo, $PrecioTela, $CantidadTelaVarilla, $Bastilla, $FactorDesp){

	if ($Varilla == "SI"){
		//Checar bien aqui el redondeoo !!!!!!!!!!!!!!! ******************************
		$NumVarilla = (($Alto / .25) - 1);
	
	}else{

		$NumVarilla = 0 ;
	}

	$Metraje = (($Alto + $Bastilla) * $FactorDesp) + ($NumVarilla * $CantidadTelaVarilla);

	$TotalTela = $Metraje * $PrecioTela;

	$PrecioTotal = $TotalTela + $PrecioMecanismo;

	/*return $PrecioTotal . "<br> Metraje " . $Metraje . " <br> Total Tela : " . $TotalTela . 
	"<br> Bastilla: " . $Bastilla . "<br> Num Varilla: " . $NumVarilla . "<br> Cantidad tela varilla " . $CantidadTelaVarilla . "<br>";*/

	//return $PrecioTotal;
	$arreglo = array();
	array_push($arreglo, array('PrecioTotal'=>$PrecioTotal,'Metraje'=>$Metraje));
	return $arreglo;
}


function CotizarPersianaForro($Alto, $Ancho, $Varilla, $PrecioTela, $CantidadTelaVarilla, $Bastilla, $FactorDesp){

	if ($Varilla == "SI"){
		//Checar bien aqui el redondeoo !!!!!!!!!!!!!!! ******************************
		$NumVarilla = (($Alto / .25) - 1);
	
	}else{

		$NumVarilla = 0 ;
	}

	$Metraje = (($Alto + $Bastilla) * $FactorDesp) + ($NumVarilla * $CantidadTelaVarilla);
	$TotalTela = $Metraje * $PrecioTela;
	$PrecioTotal = $TotalTela ;

	/*return $PrecioTotal . "<br> Metraje " . $Metraje . " <br> Total Tela : " . $TotalTela . 
	"<br> Bastilla: " . $Bastilla . "<br> Num Varilla: " . $NumVarilla . "<br> Cantidad tela varilla " . $CantidadTelaVarilla . "<br>";*/
	
	//return $PrecioTotal;

	$arreglo = array();
	array_push($arreglo, array('PrecioTotal'=>$PrecioTotal,'Metraje'=>$Metraje));
	return $arreglo;
}
?>