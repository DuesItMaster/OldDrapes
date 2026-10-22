<?php

function CotizarGaleria($Ancho,$PrecioTela,$Fijacion,$PrecioForro,$FactorDesp,$Bastilla,$Proyecciones,$Frescura,$ManoObra,$Copete,$GaleriaMoCopete){

	$MetrajeTela = (($Ancho + $Proyecciones + $Bastilla) * $FactorDesp);

	if ($Fijacion == "MURO"){
		$ManoObra = $ManoObra * $GaleriaMoCopete;
	}
	
	$TotalPrecio = ($MetrajeTela * $PrecioTela) + ($ManoObra * $Ancho);

	If ($Frescura == "SI"){
		$MetrajeForro = ($Ancho + $Proyecciones + $Bastilla) * $FactorDesp;
		$TotalPrecio  = $TotalPrecio + ($MetrajeForro * $PrecioForro);
	}

	return $TotalPrecio . "<BR> Metraje: " . $MetrajeTela  . "<BR> MetrajeForro: " . $MetrajeForro;
}
?>