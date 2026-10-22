<?php
require_once '../../conexion/cnx.php';

function TraerIva(){
	
	$sql = "SELECT iva from varios;";
		
		$result = mysqli_query($GLOBALS["db"], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	$iva = $row["iva"];    
		    }
		} else {
		    
		    $iva = 0;
		}

		return $iva;

}



function TraerIvaPorId($idCot){
	
	$sql = "SELECT iva from cotizacion_iva where id_cotizacion = ".$idCot." ;";
		
		$result = mysqli_query($GLOBALS["db"], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	$iva = $row["iva"];    
		    }
		} else {
		    
		    $iva = 0;
		}

		return $iva;

}




?>