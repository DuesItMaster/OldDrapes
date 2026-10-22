<?php
require_once '../../conexion/cnx.php';
require_once '../../conexion/wsConsumeDrapes.php';
require_once 'FormulasPersiana.php';


	function TraerTipoTela($Confeccion){

		if ($Confeccion=='PACHETO') { $Where = "  PACHETO = 1 "; }
							   else { $Where = "  ROMANA = 1 "; }
		
		$tipo = array();
		$sql = "SELECT tipo from  tipotela t where  " . $Where . ";";
		
		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	array_push($tipo, $row["tipo"]);    
		    }
		} else {
		    
		    $a = "No hay resultados";
		}


		$Cantidad = count($tipo);

		for($i=$Cantidad; $i<4; $i++ ){
			$tipo[$Cantidad]="";
		}

	
		$Telas = TraerTelas($tipo[0],$tipo[1],$tipo[2],$tipo[3]);
		$result->free();
		return $Telas;

	}



	function TraerTelas($Tela1,$Tela2,$Tela3,$Tela4){
		//$ArregloTela = array();
		$ArregloTela = Tela($Tela1,$Tela2,$Tela3,$Tela4);

		return $ArregloTela;
	}


	function TraerForro($Tela1){

		$ArregloTela1 = Forro($Tela1);

		return $ArregloTela1;

	}




	function PrecioTotal($Alto,$Ancho,$Tela,$Varilla,$Color,$ForroRomana = FALSE){
		$ArregloFinal =  array();

		$sql = "SELECT CANTIDADTELAVARILLA, BASTILLAPERSIANA, FDESPPERSIANA from varios ;";
		
		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {
		  	while($row = mysqli_fetch_assoc($result)) {
		    	 $CantidadTela = $row["CANTIDADTELAVARILLA"];
			     $Bastilla = $row["BASTILLAPERSIANA"] ;  
			     $FactorDesp = $row["FDESPPERSIANA"] ;
	    	}
	    }
	    else {
			$CantidadTela = 0;
		    $Bastilla = 0;  
		}

		
		//echo'<script type="text/javascript"> alert("'.$Alto.', '.$Ancho.', '.$Varilla.'");</script>';

		$ArregloPersiana = ConsultaMecanismoPersiana($Alto,$Ancho,$Varilla);
		$Filas = count($ArregloPersiana);

		//echo'<script type="text/javascript"> alert("'.$Filas.'");</script>';

		for( $i=0; $i<$Filas; $i++ ){

			$GLOBALS[CodigoMecanismo] = $ArregloPersiana[$i]['codigo'];
			$GLOBALS[PrecioMecanismo] = $ArregloPersiana[$i]['precio'];
		}
		
		$ArregloPrecioTela = CostoTela($Tela,$Color);

		$Filas = count($ArregloPrecioTela);
		
		for( $i=0; $i<$Filas; $i++ ){

			$CodigoTela = $ArregloPrecioTela[$i]['codigo'];
			$GLOBALS[PrecioTela] = $ArregloPrecioTela[$i]['precio'];
			$GLOBALS[AnchoTela] = $ArregloPrecioTela[$i]['ancho']; 
			$GLOBALS[tipoTela] = $ArregloPrecioTela[$i]['tipoTela'];
		}


		if ($Varilla=="NO"){ $Nom = "ROMANA SANFIN (sin varilla)"; }else{ $Nom = "ROMANA SANFIN (con varilla)"; }
		// Fallback o verificación opcional en BD (si es necesario)
		/*
		$sqlNombre = "SELECT nombre FROM confeccion WHERE UPPER(nombre)=UPPER('".$Nom."') LIMIT 1;";
		$resultNombre = mysqli_query($GLOBALS['db'], $sqlNombre);
		if ($resultNombre && mysqli_num_rows($resultNombre) > 0) {
			$rowNombre = mysqli_fetch_assoc($resultNombre);
			if (!empty($rowNombre["nombre"])) {
				$Nom = $rowNombre["nombre"];
			}
		}
		*/

		$ArregloCodigoComodin = Comodin($Nom);

		$Filas = count($ArregloCodigoComodin);
		for( $i=0; $i<$Filas; $i++ ){
			$GLOBALS[CodigoComodin] = $ArregloCodigoComodin[$i]['codigo'];
		}

		// FALLBACK: Si SAP devuelve vacío, usar códigos hardcodeados conocidos para Romana
		if (!isset($GLOBALS["CodigoComodin"]) || $GLOBALS["CodigoComodin"] == ""){
			if ($Nom == "ROMANA SANFIN (sin varilla)") {
				$GLOBALS["CodigoComodin"] = "ROMANA-SANFIN1"; 
			} elseif ($Nom == "ROMANA SANFIN (con varilla)") {
				$GLOBALS["CodigoComodin"] = "ROMANA-SANFIN";
			}
		}

		if (!isset($GLOBALS[CodigoComodin]) || $GLOBALS[CodigoComodin] == ""){
			$ArregloCodigoComodin = Comodin("ROMANA");
			$Filas = count($ArregloCodigoComodin);
			for( $i=0; $i<$Filas; $i++ ){
				$GLOBALS[CodigoComodin] = $ArregloCodigoComodin[$i]['codigo'];
			}
		}

		if ($ForroRomana == FALSE) {
			$PrecioFinal = CotizarPersiana($Alto, $Ancho, $Varilla,  $GLOBALS[PrecioMecanismo], $GLOBALS[PrecioTela], $CantidadTela, $Bastilla, $FactorDesp);
		}
		else{
			$PrecioFinal = CotizarPersianaForro($Alto, $Ancho, $Varilla, $GLOBALS[PrecioTela], $CantidadTela, $Bastilla, $FactorDesp);	
		}

		/*return "Precio final:" . $PrecioFinal . 
				"<br> Precio Mecanismo: " . $GLOBALS[PrecioMecanismo] . 
				"<br> Precio Tela: 	" .$GLOBALS[PrecioTela];*/

		array_push($ArregloFinal, array('Precio'=>$PrecioFinal[0]['PrecioTotal'],'CodigoTela'=> $CodigoTela,'CodigoMecanismo'=> $GLOBALS[CodigoMecanismo], 
										'PrecioTela' => $GLOBALS[PrecioTela],'PrecioMecanismo'=>$GLOBALS[PrecioMecanismo],'CodigoComodin'=>$GLOBALS[CodigoComodin],
										'Metraje'=>$PrecioFinal[0]['Metraje']));

		return $ArregloFinal;

		//return $PrecioFinal;
	}


?>
