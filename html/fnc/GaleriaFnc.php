<?php
require_once '../../conexion/cnx.php';
require_once '../../conexion/wsConsumeDrapes.php';
require_once 'FormulasGaleria.php';
include_once '../clases/Carrito.class.php';

//FUNCION PARA MANDAR UN CONSOLE LOG EN PHP
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug: " . $output . "' );</script>";
}

	debug_to_console("prueba 1");

	function TraerTipoTela($Confeccion){ 
		$tipo = array();
		$sql = "SELECT tipo from tipotela t ;";
		
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

	function PrecioTotal2($Ancho,$Tela,$Color,$Fijacion,$Copete,$TipoTela){

		$ArregloPrecioTela = CostoTela($Tela,$Color);

		$Filas = count($ArregloPrecioTela);
		for( $i=0; $i<$Filas; $i++ ){
			$CodigoTela = $ArregloPrecioTela[$i]['codigo'];
			//$GLOBALS['AnchoTela'] = $ArregloPrecioTela[$i]['ancho']; 
			$GLOBALS['PrecioTela'] = $ArregloPrecioTela[$i]['precio'];
		}

		$ArregloPrecioMicroFibra = ConsultaMicroFibra("FORRO");
		$Filas = count($ArregloPrecioMicroFibra);
		for( $i=0; $i<$Filas; $i++ ){
			$CodigoMicroFibra = $ArregloPrecioMicroFibra[$i]['codigo'];
			$PrecioForro = $ArregloPrecioMicroFibra[$i]['precio'];
		}
		
		$ArregloMo = TipoManoObra("GALERIA", null, null, null);
		$Filas = count($ArregloMo);
		for( $i=0; $i<$Filas; $i++ ){

			$CodigoMO = $ArregloMo[$i]['codigo'];
			$GLOBALS['MO'] = $ArregloMo[$i]['precio'];
		}

		$ArregloCodigoComodin = Comodin("GALERIA");	
		$Filas = count($ArregloCodigoComodin);
		for( $i=0; $i<$Filas; $i++ ){

			$GLOBALS['CodigoComodin'] = $ArregloCodigoComodin[$i]['codigo'];
		}


		$sql =" SELECT FDESPGALERIA,BASTILLAGALERIA,PROYECCIONES,GALERIAMOCOPETE from varios ";

		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {

		    $row = mysqli_fetch_assoc($result);

			$GLOBALS['FactorDesp'] = $row["FDESPGALERIA"];
			$GLOBALS['Bastilla'] = $row["BASTILLAGALERIA"];
			$GLOBALS['PROYECCIONES'] = $row["PROYECCIONES"];
			$GLOBALS['GALERIAMOCOPETE'] = $row["GALERIAMOCOPETE"];
			
		}

		//NOTA IMPORTANTE: CORREGIR !!!! TRANSLICIDA !!!
		if ($TipoTela=='TRANSLUCIDA' or $TipoTela=='SEMITRANSLUCIDA'){
			$Frescura = "SI";
		} ELSE {
			$Frescura = "NO";
		}
	
		$Metraje = (($Ancho + $GLOBALS['PROYECCIONES'] + $GLOBALS['Bastilla']) * $GLOBALS['FactorDesp']);
		$PrecioFinal = CotizarGaleria($Ancho, $GLOBALS['PrecioTela'], $Fijacion, $PrecioForro, $GLOBALS['FactorDesp'], $GLOBALS['Bastilla'], $GLOBALS['PROYECCIONES'],
									  $Frescura, $GLOBALS['MO'], $Copete,$GLOBALS['GALERIAMOCOPETE']);

		return '<br> ANCHO:<input id="anchoVuelta" value="'.$Ancho.'" >'. 
			   '<br> ANCHO:<input id="CodigoTela"  value="'.$CodigoTela.'" >'. 
		       '<br> PrecioTela:<input id="PrecioTela"  value="'.$GLOBALS['PrecioTela'].'" >'.
		       '<br> Fijacion: <input id="fijacionVuelta"  value="'.$Fijacion.'" >'.
		       '<br> Tipo tela: <input id="tipoTela"  value="'.$TipoTela.'" >'.
		 	   '<br> Precio Forro: <input  id="PrecioForro"  value="'.$PrecioForro.'" >'.
		 	   '<br> FactorDesp: ' . $GLOBALS['FactorDesp'] .''.
		 	   '<br> Bastilla: ' . $GLOBALS['Bastilla'] .''.
		 	   '<br> Proyecciones: <input id="proyecciones"  value="'.$GLOBALS['PROYECCIONES'].'" >'.
		 	   '<br> Proyecciones: <input id="CodigoMo" value="'.$CodigoMO.'" >'.
		 	   '<br> Proyecciones: <input id="PrecioMo" value="'.$GLOBALS['MO'].'" >'.
			   '<br> Frescura: ' . $Frescura .''.
			   '<br> MO: ' . $GLOBALS['MO']. ''.
			   '<br> Copete: <input id="copete"  value="'.$Copete.'" >'. 
			   '<br> Galeria Copete: <input id="galeriamocopete" value="'.$GLOBALS['GALERIAMOCOPETE'].'" >'.
			   '<BR> PRECIO FINAL: <div class="form-group"><input class="form-control" id="precioFinal2" type="text" value="$ '.number_format($PrecioFinal, 2, '.', ', ').'" style="text-align: right;" readonly>MXP<label><b>PRECIO:</b></label></div>'.
			   '<input class="form-control" id="precioFinal"  value="'.$PrecioFinal.'" style="text-align: right;" readonly>'.
			   '<BR> CODIGO MICROFIBRA: --><input id="CodigoMicrofibra" type="text" value="'.$CodigoMicroFibra.'" >'.
			   '<BR> COMODIN --><input id="CodigoComodin"  value="'.$GLOBALS['CodigoComodin'].'" >'.
			   '<BR> METRAJE --><input id="metraje" value="'.$Metraje.'" >'; /*" <br>CodigoMicroFibra".$CodigoMicroFibra*/;

			   //'<input id="CodigoMicrofibra" type="text" value="'.$PrecioFinal.'" >'


	}

	function PrecioTotal($Ancho,$Tela,$Color,$Fijacion,$Copete,$TipoTela,$proyeccionIzquierda,$proyeccionDerecha,$medidaCopete,$alto,$Cantidad,$id,$ConsecAprov,$MetrajeReal,$MetrajeGaleria2,$CodigoTela2){

		$ArregloPrecioTela = CostoTela($Tela,$Color);

		$Filas = count($ArregloPrecioTela);
		for( $i=0; $i<$Filas; $i++ ){

			$CodigoTela = $ArregloPrecioTela[$i]['codigo'];
			$GLOBALS['AnchoTela'] = $ArregloPrecioTela[$i]['ancho']; 
			$GLOBALS['PrecioTela'] = $ArregloPrecioTela[$i]['precio'];
			$GLOBALS['tipoTela'] = $ArregloPrecioTela[$i]['tipoTela'];
		}

		//forro de galería: ADIVA BLANCO (CHP-280-MICRO-CHANG), en el catálogo del WS se llama MICROFIBRA.
		//ConsultaMicroFibra regresa FUJI WHITE, por eso se consulta como tela normal.
		$ArregloPrecioMicroFibra = CostoTela("MICROFIBRA", "BLANCO");
		$Filas = count($ArregloPrecioMicroFibra);
		for( $i=0; $i<$Filas; $i++ ){
			$CodigoMicroFibra = $ArregloPrecioMicroFibra[$i]['codigo'];
			$PrecioForro = $ArregloPrecioMicroFibra[$i]['precio'];
			$nombreTelaForro = "ADIVA BLANCO";
			$anchoTelaForro = $ArregloPrecioMicroFibra[$i]['ancho'];
		}
		
		//galería solo filtra por tipo de mano de obra; TipoTela, Cafe y Cinta van en null como antes de PHP 7.1 (faltarlos ahora es ArgumentCountError)
		$ArregloMo = TipoManoObra("GALERIA", null, null, null);
		$Filas = count($ArregloMo);

		$altoSeleccionado = 0;

		for($i=0; $i<$Filas; $i++ ){

			$altoMO = floatval($ArregloMo[$i]['ancho']);

			if($alto <= $altoMO && ($altoSeleccionado > $altoMO || $altoSeleccionado == 0)){
				$CodigoMO = $ArregloMo[$i]['codigo'];
				$GLOBALS['MO'] = $ArregloMo[$i]['precio'];
				$altoSeleccionado = $ArregloMo[$i]['ancho'];
			}
		}

		$ArregloCodigoComodin = Comodin("GALERIA");	
		$Filas = count($ArregloCodigoComodin);
		for( $i=0; $i<$Filas; $i++ ){

			$GLOBALS['CodigoComodin'] = $ArregloCodigoComodin[$i]['codigo'];
		}

		$sql =" SELECT FDESPGALERIA,BASTILLAGALERIA,PROYECCIONES,GALERIAMOCOPETE from varios ";

		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {

		    $row = mysqli_fetch_assoc($result);

			$GLOBALS['FactorDesp'] = $row["FDESPGALERIA"];
			$GLOBALS['Bastilla'] = $row["BASTILLAGALERIA"];
			$GLOBALS['PROYECCIONES'] = $row["PROYECCIONES"];
			$GLOBALS['GALERIAMOCOPETE'] = $row["GALERIAMOCOPETE"];
			
			//CONSTANTES ESTABLECIDAS EN CÓDIGO - PENDIENTE PASAR A LA TABLA varios
			$GLOBALS['distanciaEscuadras'] = 0.8;
			$GLOBALS['anchoMaximoGaleria'] = 4.5;
		}

		$ArregloEscuadras = ConsultaEscuadras("ESCUADRA");
		$Filas = count($ArregloEscuadras);
		for( $i=0; $i<$Filas; $i++ ){
			if($ArregloEscuadras[$i]['fijacion'] == strtoupper($Fijacion)){
				$codigoEscuadra = $ArregloEscuadras[$i]['codigo'];
				$precioEscuadra = $ArregloEscuadras[$i]['precio'];
			}
		}


		//CÁLCULOS GENERALES		
		//ceil: un ancho múltiplo exacto de anchoMaximoGaleria (9.0, 13.5...) no lleva pieza extra; igual que $divisiones de mano de obra
		$piezasDivideGaleria = max(1, ceil($Ancho/$GLOBALS['anchoMaximoGaleria']));

		$anchoGaleriaDivisiones = $Ancho / $piezasDivideGaleria;
		$piezasGaleriaDivisiones = $piezasDivideGaleria * $Cantidad;

		//CÁLCULO DE LAS CONSTANTES PRINCIPALES
		$corteAncho = $GLOBALS['Bastilla'] + $proyeccionIzquierda + $proyeccionDerecha + $anchoGaleriaDivisiones;
		$corteAlto = (($alto + $medidaCopete)*2)+$GLOBALS['Bastilla'];

		//CÁLCULO METRAJE TELA PRINCIPAL X LIENZO
		$corteAnchoEnAnchoTela = $GLOBALS['AnchoTela'] / $corteAncho;

		$valor1 = intval($corteAnchoEnAnchoTela);
		if($valor1 == 0){$lienzoPiezasGalerias = 0;}
		else{$lienzoPiezasGalerias = $piezasGaleriaDivisiones / $valor1;}

		$valor2 = $lienzoPiezasGalerias - intval($lienzoPiezasGalerias);
		if($valor2 > 0){$lienzoPiezasGalerias2 = intval($lienzoPiezasGalerias) + 1;}
		else{$lienzoPiezasGalerias2 = intval($lienzoPiezasGalerias);}

		if(intval($corteAnchoEnAnchoTela) == 0){$metrajeTotalLienzo = 0;}
		else{$metrajeTotalLienzo=($corteAlto*$lienzoPiezasGalerias2 * $piezasDivideGaleria * $GLOBALS['FactorDesp']);}

		$metrajeUnitarioLienzo =  $metrajeTotalLienzo / $Cantidad;

		//CÁLCULO METRAJE TELA PRINCIPAL ML
		$corteAltoEnAltoTela = $GLOBALS['AnchoTela']  / $corteAlto;

		$valor = intval($corteAltoEnAltoTela);
		if($valor ==0){$lienzoPiezasGaleriasML1 = 0;}
		else{$lienzoPiezasGaleriasML1 = $piezasGaleriaDivisiones / $valor;}
		
		$lienzoPiezasGaleriasML2 = $lienzoPiezasGaleriasML1 - intval($lienzoPiezasGaleriasML1);

		if($lienzoPiezasGaleriasML2 > 0){$lienzoPiezasGaleriasML3 = intval($lienzoPiezasGaleriasML1) + 1;}
		else{$lienzoPiezasGaleriasML3 = intval($lienzoPiezasGaleriasML1);}

		if($valor == 0){$metrajeTotalML = 0;}
		else{$metrajeTotalML = ($corteAncho * $lienzoPiezasGaleriasML3 * $GLOBALS['FactorDesp']);}

		$metrajeUnitarioML = $metrajeTotalML / $Cantidad;
		
		if($TipoTela == "TRANSLUCIDA" || $TipoTela == "SEMITRANSLUCIDA"){
			//CÁLCULO METRAJE TELA FORRO X LIENZO
			$corteAnchoEnAnchoTelaForro = $anchoTelaForro / $corteAncho;

			$valor1Forro = intval($corteAnchoEnAnchoTelaForro);
			if($valor1Forro == 0){$lienzoPiezasGaleriasForro = 0;}
			else{$lienzoPiezasGaleriasForro = $piezasGaleriaDivisiones / $valor1Forro;}

			$valor2Forro = $lienzoPiezasGaleriasForro - intval($lienzoPiezasGaleriasForro);
			if($valor2Forro > 0){$lienzoPiezasGalerias2Forro = intval($lienzoPiezasGaleriasForro) + 1;}
			else{$lienzoPiezasGalerias2Forro = intval($lienzoPiezasGaleriasForro);}

			if(intval($corteAnchoEnAnchoTelaForro) == 0){$metrajeTotalLienzoForro = 0;}
			else{$metrajeTotalLienzoForro=($corteAlto*$lienzoPiezasGalerias2Forro * $piezasDivideGaleria * $GLOBALS['FactorDesp']);}

			$metrajeUnitarioLienzoForro =  $metrajeTotalLienzoForro / $Cantidad;

			//CÁLCULO METRAJE TELA FORRO ML
			$corteAltoEnAltoTelaForro = $anchoTelaForro  / $corteAlto;

			$valorForro = intval($corteAltoEnAltoTelaForro);
			if($valorForro ==0){$lienzoPiezasGaleriasML1Forro = 0;}
			else{$lienzoPiezasGaleriasML1Forro = $piezasGaleriaDivisiones / $valorForro;}
			
			$lienzoPiezasGaleriasML2Forro = $lienzoPiezasGaleriasML1Forro - intval($lienzoPiezasGaleriasML1Forro);

			if($lienzoPiezasGaleriasML2Forro > 0){$lienzoPiezasGaleriasML3Forro = intval($lienzoPiezasGaleriasML1Forro) + 1;}
			else{$lienzoPiezasGaleriasML3Forro = intval($lienzoPiezasGaleriasML1Forro);}

			if($valorForro == 0){$metrajeTotalMLForro = 0;}
			else{$metrajeTotalMLForro = ($corteAncho * $lienzoPiezasGaleriasML3Forro * $GLOBALS['FactorDesp']);}

			$metrajeUnitarioMLForro = $metrajeTotalMLForro / $Cantidad;
		}

		//CÁLCULO DEL RESTO DE VALORES
		$divisiones = ceil($Ancho/$GLOBALS['anchoMaximoGaleria']);
		$corteAnchoDivisiones = $Ancho / $divisiones;
		$MLManoObra = round(($corteAnchoDivisiones + $proyeccionDerecha + $proyeccionIzquierda) * $divisiones, 2, PHP_ROUND_HALF_UP);
		$MLManoObraTotales = $MLManoObra * $Cantidad;

		//igual que el Excel de galerías: INT((Ancho / distancia) + 1) + 1
		$escuadras = intval(($Ancho / $GLOBALS['distanciaEscuadras']) + 1) + 1;

		//OBTENER LOS PRECIOS FINALES
		if($metrajeUnitarioLienzo == 0 && $metrajeUnitarioML > 0){$metrajeFinal = $metrajeUnitarioML;}
		else if($metrajeUnitarioML == 0 && $metrajeUnitarioLienzo > 0){$metrajeFinal = $metrajeUnitarioLienzo;}
		else if($metrajeUnitarioLienzo < $metrajeUnitarioML){$metrajeFinal = $metrajeUnitarioLienzo;}
		else{$metrajeFinal = $metrajeUnitarioML;}
		$precioTelaPrincipal = $metrajeFinal * $GLOBALS['PrecioTela'];

		$precioManoObra = $MLManoObra * $GLOBALS['MO'];

		if($TipoTela == "TRANSLUCIDA" || $TipoTela == "SEMITRANSLUCIDA"){
			if($metrajeUnitarioLienzoForro == 0 && $metrajeUnitarioMLForro > 0){$metrajeFinalForro = $metrajeUnitarioMLForro;}
			else if($metrajeUnitarioMLForro == 0 && $metrajeUnitarioLienzoForro > 0){$metrajeFinalForro = $metrajeUnitarioLienzoForro;}
			else if($metrajeUnitarioLienzoForro < $metrajeUnitarioMLForro){$metrajeFinalForro = $metrajeUnitarioLienzoForro;}
			else{$metrajeFinalForro = $metrajeUnitarioMLForro;}

			$totalForro = $metrajeFinalForro * $PrecioForro;
			$totalMOForro = $precioManoObra * 0.5; //PENDIENTE PONER EN LA TABLA DE GENERALES
			$codigoMOForro = "CA-MANO-OBRA";//PENDIENTE TRAERLO DE SAP.

			$metrajeTotalForro = $metrajeFinalForro * $Cantidad;
		}
		else{
			$CodigoMicroFibra = "N/A";
			$PrecioForro = "N/A";
			$totalForro = 0;
			$totalMOForro = 0;
			$codigoMOForro = "N/A";
		}

		if($medidaCopete == 0){
			$totalCopete = 0;
			$codigoCopete = "N/A";
		}
		else{
			$totalCopete = $precioManoObra * 0.5; //PENDIENTE PONER % EN LA TABLA DE GENERALES
			$codigoCopete = "CA-MANO-OBRA"; //PENDIENTE TRAERLO DE SAP.
		} 
		
		$totalEscuadras = $precioEscuadra * $escuadras;
		$escuadrasTotales = $escuadras * $Cantidad;

		$PrecioUnitario =  ($precioTelaPrincipal + $precioManoObra + $totalForro + $totalMOForro + $totalCopete + $totalEscuadras);

		//echo '<script language="javascript">alert("Tela Principal: '.$precioTelaPrincipal.', Mano de Obra: '.$precioManoObra.', Tela Forro '.$totalForro.', MO Forro: '.$totalMOForro.', Copete: '.$totalCopete.', Escuadras: '.$totalEscuadras.'");</script>';

		//print($Cantidad." - ");
		//print($PrecioFinal);
		$PrecioFinal = $PrecioUnitario * $Cantidad;

		//echo'<script type="text/javascript"> alert('.$Cantidad.'); window.location.href="index.php"; </script>';
		//echo'<script type="text/javascript"> alert('.$PrecioFinal.'); window.location.href="index.php"; </script>';
		

		$Metraje = (($Ancho + $GLOBALS['PROYECCIONES'] + $GLOBALS['Bastilla']) * $GLOBALS['FactorDesp']);
		//$PrecioFinal = CotizarGaleria($Ancho, $GLOBALS['PrecioTela'], $Fijacion, $PrecioForro, $GLOBALS['FactorDesp'], $GLOBALS['Bastilla'], $GLOBALS['PROYECCIONES'],
									  //$Frescura, $GLOBALS['MO'], $Copete,$GLOBALS['GALERIAMOCOPETE']);

		$metrajeTotal = $metrajeFinal * $Cantidad;

		//APROVECHAMIENTO METRAJE
		$metrajeReal = $metrajeTotal;

		if($Cantidad == 1 && $piezasDivideGaleria == 1 && $metrajeTotal == $metrajeTotalML){
			$AplicaAprov = "SI";
			$AprovTela = $corteAlto;
			$SobAnchoTela = $GLOBALS['AnchoTela'] - $AprovTela;

			if($MetrajeGaleria2 <> 0 && $CodigoTela2 == $CodigoTela){
			//REASIGNA CON EL QUE YA ESTÁ RELACIONADO
				$array = recalcularAprovechamiento($CodigoTela,$GLOBALS['AnchoTela'],$AprovTela,$metrajeTotal,$id,$ConsecAprov);
			
			}else{
				//BUSCA UNA RELACIÓN
				$array = agregarGaleriaAprovechamiento($CodigoTela,$GLOBALS['AnchoTela'],$AprovTela,$metrajeTotal,$id);
			}

			if($array == 0){
				$idProductoAprovechamiento = "N/A";
				$metrajeAprovechamiento = "N/A";
			}else{
				$ahorroPrecio = ($metrajeTotal - $array[1]) * $GLOBALS['PrecioTela'];
				$PrecioFinal = $PrecioFinal - $ahorroPrecio;
				$PrecioUnitario = $PrecioFinal;
				$metrajeTotal = $array[1];
				$metrajeFinal = $array[1];
				$precioTelaPrincipal = $metrajeFinal * $GLOBALS['PrecioTela'];
				//$PrecioUnitario = $precioTelaPrincipal;
				$idProductoAprovechamiento = $array[0];
				$metrajeAprovechamiento = $array[1];
			}
		}else{
				//NO APLICA AHORRO POR SUS CARACTERÍSTICAS
				$AplicaAprov = "NO";
				$AprovTela = "N/A";
				$SobAnchoTela = "N/A";
				$idProductoAprovechamiento = "N/A";
				$metrajeAprovechamiento = "N/A";
		}





		/*if($MetrajeGaleria == $MetrajeReal){
			if($Cantidad == 1 && $piezasDivideGaleria == 1 && $metrajeTotal == $metrajeTotalML){
				$AplicaAprov = "SI";
				$AprovTela = $corteAlto;
				$SobAnchoTela = $GLOBALS['AnchoTela'] - $AprovTela;

				$array = agregarGaleriaAprovechamiento($CodigoTela,$GLOBALS['AnchoTela'],$AprovTela,$metrajeTotal,$id);

				//alert($array);

				if($array == 0){
					$idProductoAprovechamiento = "N/A";
					$metrajeAprovechamiento = "N/A";
				}else{
					$ahorroPrecio = ($metrajeTotal - $array[1]) * $GLOBALS['PrecioTela'];
					$PrecioFinal = $PrecioFinal - $ahorroPrecio;
					$PrecioUnitario = $PrecioFinal;
					$metrajeTotal = $array[1];
					$metrajeFinal = $array[1];
					$precioTelaPrincipal = $metrajeFinal * $GLOBALS['PrecioTela'];
					//$PrecioUnitario = $precioTelaPrincipal;
					$idProductoAprovechamiento = $array[0];
					$metrajeAprovechamiento = $array[1];
				}
			}else{
				$AplicaAprov = "NO";
				$AprovTela = "N/A";
				$SobAnchoTela = "N/A";
				$idProductoAprovechamiento = "N/A";
				$metrajeAprovechamiento = "N/A";
			}

		}else{
			$AplicaAprov = "SI";
			$AprovTela = $MetrajeGaleria;
			$SobAnchoTela = $GLOBALS['AnchoTela'] - $AprovTela;
			$idProductoAprovechamiento = $ConsecAprov;
			$metrajeAprovechamiento = $MetrajeGaleria;

			$ahorroPrecio = ($metrajeTotal - $array[1]) * $GLOBALS['PrecioTela'];
			$PrecioFinal = $PrecioFinal - $ahorroPrecio;
			$PrecioUnitario = $PrecioFinal;
			$metrajeTotal = $array[1];
			$metrajeFinal = $array[1];
			$precioTelaPrincipal = $metrajeFinal * $GLOBALS['PrecioTela'];
		}*/

		return //'<br> <h4>PARÁMETROS</h4>'. 
			   '<input type="hidden" id="divisiones" value="'.$GLOBALS['anchoMaximoGaleria'].'" >'. 
			   '<input type="hidden" id="divisiones" value="'.$GLOBALS['Bastilla'] .'" >'. 
			   '<input type="hidden" id="divisiones" value="'.$proyeccionDerecha.'" >'. 
			   '<input type="hidden" id="divisiones" value="'.$proyeccionIzquierda.'" >'. 
			   '<input type="hidden" id="AnchoTela" value="'.$GLOBALS['AnchoTela'] .'" >'. 
			   '<input type="hidden" id="tipoTela" value="'.$TipoTela.'" >'. 
			   '<input type="hidden" id="nombreTelaForro" value="'.$nombreTelaForro.'" >'. 
			   '<input type="hidden" id="AnchoTelaForro" value="'.$anchoTelaForro.'" >'. 
			   //'<br> <h4>CÁLCULO EN CUANTAS PIEZAS SE HARÁN LAS GALERÍAS</h4>'. 
			   '<input type="hidden" id="piezasDivideGaleria" value="'.$piezasDivideGaleria.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$anchoGaleriaDivisiones.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$piezasGaleriaDivisiones.'" >'.
			   //'<br> <h4>CORTE GALERÍAS</h4>'. 
			   '<input type="hidden" id="divisiones" value="'.$corteAncho.'" >'. 
			   '<input type="hidden" id="corteAlto" value="'.$corteAlto.'" >'.
			   //'<br> <h4>CÁLCULO METRAJE 1 X LIENZO (ANCHO TELA = ANCHO GALERÍA)</h4>'. 
			   '<input type="hidden" id="divisiones" value="'.$corteAnchoEnAnchoTela.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGalerias.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGalerias2.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$metrajeTotalLienzo.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$metrajeUnitarioLienzo.'" >'.
			   //'<br> <h4>CÁLCULO METRAJE 2 X ML (ANCHO TELA = ALTO GALERÍA)</h4>'. 
			   '<input type="hidden" id="divisiones" value="'.$corteAltoEnAltoTela.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasML1.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasML2.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasML3.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$metrajeTotalML.'" >'.
			   '<input type="hidden" id="metrajeUnitarioML" value="'.$metrajeUnitarioML.'" >'.
			   //'<br> <h4>CÁLCULO METRAJE 1 X LIENZO - FORRO (ANCHO TELA = ANCHO GALERÍA)</h4>'. 
			   '<input type="hidden" id="divisiones" value="'.$corteAnchoEnAnchoTelaForro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasForro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGalerias2Forro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$metrajeTotalLienzoForro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$metrajeUnitarioLienzoForro.'" >'.
			   //'<br> <h4>CÁLCULO METRAJE 2 X ML - FORRO(ANCHO TELA = ALTO GALERÍA)</h4>'. 
			   '<input type="hidden" id="divisiones" value="'.$corteAltoEnAltoTelaForro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasML1Forro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasML2Forro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$lienzoPiezasGaleriasML3Forro.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$metrajeTotalMLForro.'" >'.
			   '<input type="hidden" id="metrajeUnitarioML" value="'.$metrajeUnitarioMLForro.'" >'.
			   //'<br> <h4>CÁLCULO DEL RESTO DE VALORES</h4>'.
			   '<input type="hidden" id="divisionesGaleria" value="'.$divisiones.'" >'.
			   '<input type="hidden" id="divisiones" value="'.$corteAnchoDivisiones.'" >'.
			   '<input type="hidden" id="MLManoObra" value="'.$MLManoObra.'" >'.
			   '<input type="hidden" id="TotalEscuadras" value="'.$escuadras.'" >'.
			   //'<br> <h4>TOTALES FINALES</h4>'.
			   '<input type="hidden" id="metraje"  value="'.$metrajeFinal.'" >'.
			   '<input type="hidden" id="metrajeTotal"  value="'.$metrajeTotal.'" >'.
			   '<input type="hidden" id="metrajeReal"  value="'.$metrajeReal.'" >'.
			   '<input type="hidden" id="metraje"  value="'.$metrajeFinalForro.'" >'.
			   '<input type="hidden" id="metrajeTotalForro"  value="'.$metrajeTotalForro.'" >'.
			   '<input type="hidden" id="MLManoObraTotales" value="'.$MLManoObraTotales.'" >'.
			   '<input type="hidden" id="escuadrasTotales" value="'.$escuadrasTotales.'" >'.
			   '<input type="hidden" id="CodigoTela"  value="'.$CodigoTela.'" >'. 
			   '<input type="hidden" id="PrecioTela"  value="'.$GLOBALS['PrecioTela'].'" >'. 
			   '<input type="hidden" id="TTP"  value="'.$precioTelaPrincipal.'" >'. 
			   '<input type="hidden" id="CodigoMo"  value="'.$CodigoMO.'" >'. 
			   '<input type="hidden" id="PMO"  value="'.$GLOBALS['MO'].'" >'. 
			   '<input type="hidden" id="TMO"  value="'.$precioManoObra.'" >'. 
			   '<input type="hidden" id="CodigoMicrofibra"  value="'.$CodigoMicroFibra.'" >'. 
			   '<input type="hidden" id="PrecioForro"  value="'.$PrecioForro.'" >'. 
			   '<input type="hidden" id="TotalForro"  value="'.$totalForro.'" >'.
			   '<input type="hidden" id="CodigoMoForro"  value="'.$codigoMOForro.'" >'. 
			   '<input type="hidden" id="PrecioMo"  value="'.$totalMOForro.'" >'.
			   '<input type="hidden" id="CodigoCopete"  value="'.$codigoCopete.'" >'.
			   '<input type="hidden" id="TotalForro"  value="'.$totalCopete.'" >'.
			   '<input type="hidden" id="CodigoEscuadras"  value="'.$codigoEscuadra.'" >'. 
			   '<input type="hidden" id="PE"  value="'.$precioEscuadra.'" >'. 
			   '<input type="hidden" id="TotalForro"  value="'.$totalEscuadras.'" >'.
			   '<input type="hidden" id="PrecioUnitarioGaleria"  value="'.$PrecioUnitario.'" >'.
			   '<input type="hidden" id="CodigoComodin" value="'.$GLOBALS['CodigoComodin'].'" >'.
			   //'<br> <h4>SOBRANTE PARA SACAR MÁS GALERÍAS</h4>'.
			   '<input type="hidden" id="AplicaAprov" value="'.$AplicaAprov.'" >'.
			   '<input type="hidden" id="AprovTela" value="'.$AprovTela.'" >'.
			   '<input type="hidden" id="AprovTela" value="'.$SobAnchoTela.'" >'.
			   //'<br> <h4>AHORRO POR APROVECHAMIENTO</h4>'. 
			   '<input type="hidden" id="idProductoAprovechamiento" value="'.$idProductoAprovechamiento.'" >'. 
			   '<input type="hidden" id="nuevoMetraje" value="'.$metrajeAprovechamiento.'" >'.
			   //'<br> Array:<input id="nuevoMetraje2" value="'.$array.'" >'.
			   //'<br> Id Enviado:<input id="nuevoMetraje2" value="'.$ConsecAprov.'" >'.
			   //'<br> <h4>CÁLCULO ANTERIOR</h4>'.  
			   //'<br> ANCHO:<input id="anchoVuelta" value="'.$Ancho.'" >'. 
			   //'<br> Código Tela:<input id="CodigoTela"  value="'.$CodigoTela.'" >'. 
		       //'<br> PrecioTela:<input id="PrecioTela"  value="'.$GLOBALS['PrecioTela'].'" >'.
		       //'<br> Fijacion: <input id="fijacionVuelta"  value="'.$Fijacion.'" >'.
		       //'<br> Tipo tela: <input id="tipoTela"  value="'.$TipoTela.'" >'.
		 	   //'<br> Precio Forro: <input  id="PrecioForro"  value="'.$PrecioForro.'" >'.
		 	   //'<br> FactorDesp: ' . $GLOBALS['FactorDesp'] .''.
		 	   //'<br> Proyecciones: <input id="proyecciones"  value="'.$GLOBALS['PROYECCIONES'].'" >'.
		 	   //'<br> Proyecciones: <input id="CodigoMo" value="'.$CodigoMO.'" >'.
		 	   //'<br> Proyecciones: <input id="PrecioMo" value="'.$GLOBALS['MO'].'" >'.
			   //'<br> Frescura: ' . $Frescura .''.
			   //'<br> MO: ' . $GLOBALS['MO']. ''.
			   //'<br> Copete: <input id="copete"  value="'.$Copete.'" >'. 
			   //'<br> Galeria Copete: <input id="galeriamocopete" value="'.$GLOBALS['GALERIAMOCOPETE'].'" >'.
			   '<label class="label_total">Precio Total</label><label id="PrecioFinal2" name="PrecioFinal2" class="label_cantidad">$'.number_format($PrecioFinal, 2, '.', '').'MXP</label>'.
			   '<input type="hidden" class="form-control" id="precioFinal"  value="'.$PrecioFinal.'" style="text-align: right;" readonly>';
			   //'<BR> CODIGO MICROFIBRA: --><input id="CodigoMicrofibra" type="text" value="'.$CodigoMicroFibra.'" >'.
			   //'<BR> COMODIN --><input id="CodigoComodin"  value="'.$GLOBALS['CodigoComodin'].'" >'.
			   //'<BR> METRAJE --><input id="metraje" value="'.$Metraje.'" >'; /*" <br>CodigoMicroFibra".$CodigoMicroFibra*/

			   //'<input id="CodigoMicrofibra" type="text" value="'.$PrecioFinal.'" >'


	}

	function agregarGaleriaAprovechamiento($CodigoTela,$AnchoTela,$AprovTela,$MetrajeGaleria,$id){
		//session_start();
		$carrito = new Carrito();
		$carro = $carrito->get_content();

		if($carro) { 
			function cmp($a, $b) { return strcasecmp($a["area"], $b["area"]); }
			usort($carro, "cmp");
					
			foreach($carro as $producto) {
				//echo '<script language="javascript">alert("Entró");</script>';
				if($CodigoTela == $producto["CodigoTela"] && $producto["ConsecAprov"] == "N/A" && $producto["AplicaAprov"] == "SI" && $producto["id"] <> $id){
					//Verificar si juntos caben en el ancho de la tela,
					$AprovTotal = $AprovTela + $producto["AprovTela"];
					if($AprovTotal <= $AnchoTela){
						//Si sí, asignar: id en ConsecAprov, cambiar metraje entre dos, recalcular precio.
						if($MetrajeGaleria > $producto["MetrajeGaleria"]){
							$nuevoMetraje = $MetrajeGaleria / 2;
						}else{
							$nuevoMetraje = $producto["MetrajeGaleria"] / 2;
						}
						//$nuevoMetraje =  $AprovTotal;
						//$nuevoMetraje =  $producto["MetrajeGaleria"];

						//Return $producto["id"].','.$nuevoMetraje;

						$array = [$producto["id"], $nuevoMetraje];

						//return '<br> <h4>COINCIDENCIAS EN EL CARRITO</h4>'. 
			   			//'<br> Id Producto:<input id="idProducto" value="'.$producto["id"].'" >'. 
			   			//'<br> Nuevo metraje:<input id="nuevoMetraje" value="'.$nuevoMetraje.'" >';

			   			return $array;

						break;
					} 
				}
			}

			return 0;
		}

	}

	function recalcularAprovechamiento($CodigoTela,$AnchoTela,$AprovTela,$MetrajeGaleria,$id,$idRelacionado){
		//session_start();
		$carrito = new Carrito();
		$carro = $carrito->get_content();

		if($carro) { 
			function cmp($a, $b) { return strcasecmp($a["area"], $b["area"]); }
			usort($carro, "cmp");
					
			foreach($carro as $producto) {
				//echo '<script language="javascript">alert("Entró");</script>';
				if($producto["id"] == $idRelacionado){
					//Verificar si juntos caben en el ancho de la tela,
					$AprovTotal = $AprovTela + $producto["AprovTela"];
					if($AprovTotal <= $AnchoTela){
						//Si sí, asignar: id en ConsecAprov, cambiar metraje entre dos, recalcular precio.
						if($MetrajeGaleria > $producto["MetrajeReal"]){
							$nuevoMetraje = $MetrajeGaleria / 2;
						}else{
							$nuevoMetraje = $producto["MetrajeReal"] / 2;
						}
						//$nuevoMetraje =  $AprovTotal;
						//$nuevoMetraje =  $producto["MetrajeGaleria"];

						//Return $producto["id"].','.$nuevoMetraje;

						$array = [$producto["id"], $nuevoMetraje];

						//return '<br> <h4>COINCIDENCIAS EN EL CARRITO</h4>'. 
			   			//'<br> Id Producto:<input id="idProducto" value="'.$producto["id"].'" >'. 
			   			//'<br> Nuevo metraje:<input id="nuevoMetraje" value="'.$nuevoMetraje.'" >';

			   			return $array;

						break;
					} 
				}
			}

			return 0;
		}

	}

	function asignarAprovechamiento($idProducto,$MetrajeGaleria){
		return "Llegó asignar aprovechamiento";
	}

	function asignarAprovechamiento2($idProducto,$MetrajeGaleria){
		//session_start();
		echo "<script>alert('Entra');</script>";
		$carrito = new Carrito();
		$carro = $carrito->get_content();

		if($carro) { 
			function cmp($a, $b) { return strcasecmp($a["area"], $b["area"]); }
			usort($carro, "cmp");
					
			foreach($carro as $producto) {

				if($idProducto == $producto["id"]){
					$ahorroPrecio = ($producto["MetrajeGaleria"] - $MetrajeGaleria) * $producto["PrecioTela"];
					$precio = $producto["precio"] - $ahorroPrecio;

					//$validacionCarrito = 
					echo "<script>alert('Se manda a modificar: ".$idProducto."');</script>";
					$Mensaje = $carrito->modificar_precio_metraje($idProducto,$MetrajeGaleria,$precio);
					//$mensaje = $carrito->remove_producto($idProducto);
					echo "<script>alert('Despues de eliminar'".$Mensaje.");</script>";


					//update_carrito();

					return $precio;

					break;
				} 
			}
		}
	}


?>