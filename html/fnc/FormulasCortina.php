<?php
//FUNCION PARA MANDAR UN CONSOLE LOG EN PHP
function debug_to_console($data) {
    $output = $data;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug: " . $output . "' );</script>";
}

function Cotizar(
	$Alto, 
	$Ancho,
	$FactorPlitz,
	$FactorDesp, 
	$Bastilla, 
	$TamanoBajoPlomo, 
	$Traslape, 
	$PrecioBajoPlomo, 
	$TelaBajoPlomo,
	$AnchoTela,
	$PrecioTela,
	$ManoObraMu,
	$ManoObraLz14,
	$ManoObraLz28,
	$ManoObraLz3,
	$ManoObraLz32,
	$NeverLight,
	$TamanoNeverLight,
	$Stiffener,
	$PrecioStiffener,
	$CodigoManoObraMu,
	$CodigoManoObraLz14,
	$CodigoManoObraLz28,
	$CodigoManoObraLz3,
	$CodigoManoObraLz32,
	$BajoPlomo,
	$rapport, 
	$rapportPlomo,
	$rapportHor, 
	$rapportVert,
	$plomorapportMedida,
	$rapportTra
){
	$decimalAlto = explode(".",$Alto );

	// Nota: Checar si el decimal del ALTO es multiplo de 10, si no es asi redondear
	$Uno = 1;
	$Cero = 0;
	if ($decimalAlto[$Uno]%10!=0){
		$Alto = round_up($Alto, "1");
	}

	if ($NeverLight) {
		$Alto = $Alto + $TamanoNeverLight;
	}

	//este if se agrego porque el bajo plomo reduce 18 cm de tela que se necesitan para el alto
	//regularmente para telas con rapport que utilizan obligatoriamente bajo plomo (aldora, ramura, yaru)
	if($rapport == "SI" and $rapportPlomo=="SI" and $rapportTra=="NO"){
		$Bastilla = $Bastilla - $plomorapportMedida;
	} 

	$decimal = explode(".",$Ancho);
	// Nota: Checar si el decimal del Ancho es multiplo de 10, si no es asi redondear
	if ($decimal[$Uno]%10!=0){
		$Ancho = round_up($Ancho, "1");
	}
	
	$decimal = explode(".",$Ancho);

	// Nota: Checar si el decimal es multiplo de 20, si no es asi sumar 10 y convertirlo
	if (strlen($decimal[$Uno])==1){
		if (($decimal[$Uno]*10)%20!=0){
			$Ancho = $Ancho + 0.10; 
		}
	} else {
		if (($decimal[$Uno])%20!=0){
			$Ancho = $Ancho + 0.10; 
		}
	}

	// Funciones para Obtener la altura y el numero de lienzos
	$Altura = Altura($Alto,$Bastilla,$FactorDesp);
	$Lienzo = Lienzo($Ancho,$FactorPlitz,$Traslape,$AnchoTela);
	$AltoBastilla = Altura($Alto,$Bastilla,$FactorDesp);

	$decimal = explode(".",$Lienzo);
	// Redondear el lienzo, si el decimal es menor a .10 no se cobra otros lienzo.
	$LienzoTotalD = $Lienzo - $decimal[$Cero];
	
	//$LienzoTotalD = floatval($LienzoTotalD);
	if (($decimal[$Uno] == 1)) {
		$validar = "SI";
		$LienzoTotal = $Lienzo - $LienzoTotalD;
	}
	else if (($Lienzo - $decimal[$Cero] < 0.1) ){
		$validar = "SI";
			//$Lienzo - (($decimal[1]) / 100);
		$LienzoTotal = $Lienzo - $LienzoTotalD;
	}
	else{
		$validar = "NO";
		$LienzoTotal = ceil($Lienzo);
	}

	$decimales = explode(".",$Lienzo);
	$LienzoEntero = $decimales[$Cero];
	$LienzoDecimales = $decimales[$Uno];

	/*if ($AnchoTela>=2.8){

		$ManoObraLz = $ManoObraLz28;
		$ClaveMoLz = $CodigoManoObraLz28;
	}
	else{

		$ManoObraLz = $ManoObraLz14;
		$ClaveMoLz = $CodigoManoObraLz14;
	}*/

	if ($AnchoTela>=2.8 and $AnchoTela<2.9){
		$ManoObraLz = $ManoObraLz28;
		$ClaveMoLz = $CodigoManoObraLz28;
	}
	elseif ($AnchoTela>=2.9 and $AnchoTela<3.1) {
		$ManoObraLz = $ManoObraLz3;
		$ClaveMoLz = $CodigoManoObraLz3;
	}
	elseif ($AnchoTela>=3.1) {
		$ManoObraLz = $ManoObraLz32;
		$ClaveMoLz = $CodigoManoObraLz32;
	}
	else{
		$ManoObraLz = $ManoObraLz14;
		$ClaveMoLz = $CodigoManoObraLz14;
	}

	$MetrajeBajoPlomo = 0;
	//$ClaveMo ="" ;
	if ($AnchoTela == 2.9011 || $AnchoTela == 2.8011) {
		if (($LienzoEntero%2==0 || $LienzoEntero==1 || $LienzoEntero==3 || $LienzoEntero==5 || $LienzoEntero==7) && ($LienzoTotalD > .1 && $LienzoTotalD<=.55) && $validar == "NO") {
			//print_r('AQUI CAE LA VALIDACION DE LA TELA MARCIA CON FORMULA MEDIA TELA');
			$Formula = "Medio Lienzo 1"; 
			$PrecioFinal = FormulaMedioLienzo($Altura,$LienzoTotal,$LienzoEntero,$ManoObraLz,$PrecioTela);
			$Metraje = ($Altura*$LienzoTotal);
			$ClaveMo = $ClaveMoLz;
			$PrecioMo = $ManoObraLz;
			$MetrajeMo= ($LienzoEntero + 0.5);
			$TipoFormula="Medio Lienzo 1";
		}else{
			//print_r('AQUI CAE LA VALIDACION DE LA TELA MARCIA CON FORMULA NORMAL');
			$Formula = "Normal 1"; 
			$PrecioFinal = FormulaNormal($Altura,$LienzoTotal,$ManoObraLz,$PrecioTela);
			$Metraje = ($Altura*$LienzoTotal);
			$ClaveMo = $ClaveMoLz;
			$PrecioMo = $ManoObraLz;
			$MetrajeMo = $LienzoTotal;//$Lienzo;
			$TipoFormula="Normal 1";
		}
	debug_to_console($Alto);
	debug_to_console($Bastilla);
	debug_to_console($AnchoTela);
	}elseif ($Alto >= 2 && $Alto + $Bastilla <= $AnchoTela){
		if($rapport == "SI"){
			$Formula = "Cortina Atravezada con Rapport"; 
			$rapportAltura = $AltoBastilla / $rapportVert;
			$rapportRound=ceil($rapportAltura);
			$PrecioFinal = FormulaAtravezadaRapportVertical($Traslape,$FactorDesp, $PrecioTela, $LienzoTotal, $ManoObraMu, $Ancho, $FactorPlitz, $rapportHor);
			$Metraje = ($LienzoTotal>1) ? round((($Ancho * $FactorPlitz + $rapportHor+$Traslape) * $FactorDesp ),2) : round((($Ancho * $FactorPlitz +$Traslape) * $FactorDesp),2);
			$ClaveMo = $CodigoManoObraMu;
			$PrecioMo = $ManoObraMu;
			$MetrajeMo = round(($Ancho * $FactorPlitz + $rapportHor),2);
			$TipoFormula="Cortina Atravezada con Rapport";
		}
		else{
			$Formula = "Cortina Atravezada"; 
			$PrecioFinal = FormulaCortinaAtravezada($Ancho,$FactorPlitz,$Traslape,$FactorDesp,$PrecioTela,$ManoObraMu);
			$Metraje = round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2);
			$ClaveMo = $CodigoManoObraMu;
			$PrecioMo = $ManoObraMu;
			$MetrajeMo = round(($Ancho * $FactorPlitz + $Traslape),2);
			$TipoFormula="Cortina Atravezada";
		}

	} elseif (($TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamanoBajoPlomo) <= $AnchoTela) && ($BajoPlomo=="SI")) {
		$Formula = "Bajo Plomo"; 
		$PrecioFinal = FormulaBajoPlomo($Ancho, $FactorPlitz, $Traslape, $FactorDesp, $PrecioTela, $ManoObraMu, $PrecioBajoPlomo);
		$Metraje = round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2);
		$ClaveMo = $CodigoManoObraMu;
		$PrecioMo = $ManoObraMu;
		$MetrajeMo = round(($Ancho * $FactorPlitz + $Traslape),2);
		$TipoFormula="Bajo Plomo";

	} elseif (($TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamanoBajoPlomo) <= $AnchoTela) && $rapport == "SI" and $rapportPlomo=="SI" and $rapportTra=="SI") {
		$Formula = "Bajo Plomo"; 
		$PrecioFinal = FormulaBajoPlomo($Ancho, $FactorPlitz, $Traslape, $FactorDesp, $PrecioTela, $ManoObraMu, $PrecioBajoPlomo);
		$Metraje = round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2);
		$ClaveMo = $CodigoManoObraMu;
		$PrecioMo = $ManoObraMu;
		$MetrajeMo = round(($Ancho * $FactorPlitz + $Traslape),2);
		$TipoFormula="Bajo Plomo";
	
	} elseif (($LienzoEntero%2==0 || $LienzoEntero==1 || $LienzoEntero==3 || $LienzoEntero==5 || $LienzoEntero==7) && ($LienzoTotalD > .1 && $LienzoTotalD<=.55) && $validar == "NO"){
		if($rapport=="SI"){
			if($rapportVert == null){
				$rapportVert = $rapportHor;						
			}

			$Formula = "Medio Lienzo con rapport"; 
			$rapportAltura = $AltoBastilla / $rapportVert;
			$rapportRound=ceil($rapportAltura);
			$PrecioFinal = FormulaMediasManosRapport($rapportPlomo,$LienzoEntero,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$rapportTra);
			$Metraje = round(($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp),2); //($AltoBastilla*$LienzoTotal);
			$ClaveMo = $ClaveMoLz;
			$PrecioMo = $ManoObraLz;
			$MetrajeMo= ($LienzoEntero + 0.5);
			$MetrajeBajoPlomo = ($rapportPlomo == "SI") ? (($Ancho*$FactorPlitz)) : 0 ;
			$TipoFormula="Medio Lienzo con rapport";					
		}
		else{
			$rapportRound=0;
			$Formula = "Medio Lienzo 2.0";
			$PrecioFinal = FormulaMedioLienzo($Altura,$LienzoTotal,$LienzoEntero,$ManoObraLz,$PrecioTela);
			$Metraje = ($Altura*$LienzoTotal);
			$ClaveMo = $ClaveMoLz;
			$PrecioMo = $ManoObraLz;
			$MetrajeMo= ($LienzoEntero + 0.5);
			$TipoFormula="Medio Lienzo 2.0";	
		}
		
	} else {
		if($rapport == "SI"){
			if($rapportVert == null){ $rapportVert = $rapportHor; }
			$Formula = "Normal Rapport";
			$rapportAltura = $AltoBastilla / $rapportVert;
			$rapportRound=ceil($rapportAltura);
			/*$PrecioFinal = FormulaNormalRapport($rapportRound,$rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo, $AltoBastilla);*/
			$PrecioFinal = FormulaNormalRapport($rapportPlomo,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$AltoBastilla,$rapportTra);
			$Metraje= ($LienzoTotal>1) ? round(($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp),2) : round(($AltoBastilla*$LienzoTotal*$FactorDesp),2);
			$ClaveMo = $ClaveMoLz;
			$PrecioMo = $ManoObraLz;
			$MetrajeMo = $LienzoTotal;//$Lienzo;+	
			$MetrajeBajoPlomo = ($rapportPlomo == "SI") ? (($Ancho*$FactorPlitz)) : 0 ;				
			$TipoFormula="Normal Rapport";
		}
		else{				
			$rapportRound = 0 ;
			$Formula = "Normal"; 
			$PrecioFinal = FormulaNormal($Altura,$LienzoTotal,$ManoObraLz,$PrecioTela);
			$Metraje = ($Altura*$LienzoTotal);
			$ClaveMo = $ClaveMoLz;
			$PrecioMo = $ManoObraLz;
			$MetrajeMo = $LienzoTotal;//$Lienzo;
			$TipoFormula="Normal";
		}
	}

	if ($Stiffener == "SI" || $Stiffener == "STIFFENER"){
		$PrecioFinal = $PrecioFinal + $PrecioStiffener;
	}

	// ESTE ES EL CÓDIGO NUEVO QUE DEBES AGREGAR
	if ($BajoPlomo == "SI") {
		$MetrajeBajoPlomo = round(($Ancho * $FactorPlitz), 2);
		$CostoBajoPlomo = round($MetrajeBajoPlomo * $PrecioBajoPlomo, 2);
		$PrecioFinal = $PrecioFinal + $CostoBajoPlomo;
	}
	
	debug_to_console($TipoFormula);
	print_r($TipoFormula);

	$arreglo = array();
	array_push($arreglo, array('precioformula'=>$PrecioFinal,'CodigoManoObra'=>$ClaveMo,'PrecioMo'=>$PrecioMo,'Metraje'=>$Metraje,
							'LienzoTotal'=>$LienzoTotal,'Altura'=>$Altura,'TipoFormula'=>$TipoFormula,'MetrajeMo'=>$MetrajeMo,'rapportAltura'=>$rapportRound,'rapportVert'=>$rapportVert,
							'rapportHor'=>$rapportHor,'MetrajeBajoPlomo'=>$MetrajeBajoPlomo, 'MetrajeReal'=>$Metraje,'MetrajeMOReal'=>$MetrajeMo,'PrecioReal'=>$PrecioFinal,'PrecioMoReal'=>$PrecioMo,
							'MetrajeBajoPlomoReal'=>$MetrajeBajoPlomo));
			
/*
			array_push($arreglo, array('precioformula'=>$resultadoCalculado[0]['precioformula'],'CodigoManoObra'=>$resultadoCalculado[0]['CodigoManoObra'],'PrecioMo'=>$resultadoCalculado[0]['PrecioMo'],'Metraje'=>$resultadoCalculado[0]['Metraje'],
										'LienzoTotal'=>$resultadoCalculado[0]['LienzoTotal'],'Altura'=>$resultadoCalculado[0]['Altura'],'TipoFormula'=>$resultadoCalculado[0]['TipoFormula'],'MetrajeMo'=>$resultadoCalculado[0]['MetrajeMo'],
										'rapportAltura'=>$resultadoCalculado[0]['rapportAltura'],'rapportVert'=>$resultadoCalculado[0]['rapportVert'],'rapportHor'=>$resultadoCalculado[0]['rapportHor'],'MetrajeBajoPlomo'=>$resultadoCalculado[0]['MetrajeBajoPlomo'],'MetrajeReal'=>$resultadoReal[0]['Metraje'],'MetrajeMOReal'=>$resultadoReal[0]['MetrajeMo'],'PrecioReal'=>$resultadoReal[0]['precioformula'],'PrecioMoReal'=>$resultadoReal[0]['PrecioMo'],'MetrajeBajoPlomoReal'=>$resultadoReal[0]['MetrajeBajoPlomo']));*/


			return $arreglo;
}

function MetodoCotizar($Alto, 
				 $Ancho,
				 $FactorPlitz,
				 $FactorDesp, 
				 $Bastilla, 
				 $TamanoBajoPlomo, 
				 $Traslape, 
				 $PrecioBajoPlomo, 
				 $TelaBajoPlomo,
				 $AnchoTela,
				 $PrecioTela,
				 $ManoObraMu,
				 $ManoObraLz14,
				 $ManoObraLz28,
				 $ManoObraLz3,
				 $ManoObraLz32,
				 $NeverLight,
				 $TamanoNeverLight,
				 $Stiffener,
				 $PrecioStiffener,
				 $CodigoManoObraMu,
				 $CodigoManoObraLz14,
				 $CodigoManoObraLz28,
				 $CodigoManoObraLz3,
				 $CodigoManoObraLz32,
				 $BajoPlomo,
				 $rapport, 
				 $rapportPlomo,
				 $rapportHor, 
				 $rapportVert,
				 $plomorapportMedida,
				 $rapportTra,
				 $Argolla,
				 $PrecioArgolla,
				 $CantidadArgolla){

			$Uno = 1;
			$Cero = 0;


	//este if se agrego porque el bajo plomo reduce 18 cm de tela que se necesitan para el alto
			//regularmente para telas con rapport que utilizan obligatoriamente bajo plomo (aldora, ramura, yaru)
			if($rapport == "SI" and $rapportPlomo=="SI" and $rapportTra=="NO"){
				$Bastilla = $Bastilla - $plomorapportMedida;
			} 

	// Funciones para Obtener la altura y el numero de lienzos
			$Altura = Altura($Alto,$Bastilla,$FactorDesp);
			$Lienzo = Lienzo($Ancho,$FactorPlitz,$Traslape,$AnchoTela);
			$AltoBastilla = Altura($Alto,$Bastilla,$FactorDesp);

			$decimal = explode(".",$Lienzo);
			// Redondear el lienzo, si el decimal es menor a .10 no se cobra otros lienzo.
			
			$LienzoTotalD = $Lienzo - $decimal[$Cero];

			//$LienzoTotalD = floatval($LienzoTotalD);
			if (($decimal[$Uno] == 1)) {
				$validar = "SI";
				$LienzoTotal = $Lienzo - $LienzoTotalD;
			}
			else if (($Lienzo - $decimal[$Cero] < 0.1) ){
				$validar = "SI";
				  //$Lienzo - (($decimal[1]) / 100);
				$LienzoTotal = $Lienzo - $LienzoTotalD;
			}
			else{
				$validar = "NO";
				$LienzoTotal = ceil($Lienzo);
			}

			$decimales = explode(".",$Lienzo);
		 	$LienzoEntero = $decimales[$Cero];
		 	$LienzoDecimales = $decimales[$Uno];


		 	/*if ($AnchoTela>=2.8){

		 		$ManoObraLz = $ManoObraLz28;
		 		$ClaveMoLz = $CodigoManoObraLz28;
		 	}
		 	else{

		 		$ManoObraLz = $ManoObraLz14;
		 		$ClaveMoLz = $CodigoManoObraLz14;
		 	}*/

		 	if ($AnchoTela>=2.8 and $AnchoTela<2.9){

		 		$ManoObraLz = $ManoObraLz28;
		 		$ClaveMoLz = $CodigoManoObraLz28;
		 	}
		 	elseif ($AnchoTela>=2.9 and $AnchoTela<3.1) {

		 		$ManoObraLz = $ManoObraLz3;
		 		$ClaveMoLz = $CodigoManoObraLz3;
		 	}
		 	elseif ($AnchoTela>=3.1) {

		 		$ManoObraLz = $ManoObraLz32;
		 		$ClaveMoLz = $CodigoManoObraLz32;
		 	}
		 	else{

		 		$ManoObraLz = $ManoObraLz14;
		 		$ClaveMoLz = $CodigoManoObraLz14;
		 	}


		 	//$TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamanoBajoPlomo) <= $AnchoTela) and $rapport == "SI" and $rapportPlomo=="SI" and $rapportTra=="SI"

		 	$MetrajeBajoPlomo = 0;
		 	//$ClaveMo ="" ;
			 if ($AnchoTela == 2.9011 || $AnchoTela == 2.8011) {
				if (($LienzoEntero%2==0 || $LienzoEntero==1 || $LienzoEntero==3 || $LienzoEntero==5 || $LienzoEntero==7) && ($LienzoTotalD > .1 && $LienzoTotalD<=.55) && $validar == "NO") {
					print_r('AQUI CAE LA VALIDACION DE LA TELA MARCIA CON FORMULA MEDIA TELA');
					$Formula = "Medio Lienzo 1"; 
					$PrecioFinal = FormulaMedioLienzo($Altura,$LienzoTotal,$LienzoEntero,$ManoObraLz,$PrecioTela);
					$Metraje = ($Altura*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo= ($LienzoEntero + 0.5);
					$TipoFormula="Medio Lienzo 1";
				}else{
					print_r('AQUI CAE LA VALIDACION DE LA TELA MARCIA CON FORMULA NORMAL');
					$Formula = "Normal"; 
					$PrecioFinal = FormulaNormal($Altura,$LienzoTotal,$ManoObraLz,$PrecioTela);
					$Metraje = ($Altura*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo = $LienzoTotal;//$Lienzo;
					$TipoFormula="Normal";
				}
				
			}elseif ($Alto >= 2 && $Alto + $Bastilla <= $AnchoTela){
					if($rapport == "SI"){
						$Formula = "Cortina Atravezada con Rapport"; 
						$rapportAltura = $AltoBastilla / $rapportVert;
						$rapportRound=ceil($rapportAltura);
						$PrecioFinal = FormulaAtravezadaRapportVertical($Traslape,$FactorDesp, $PrecioTela, $LienzoTotal, $ManoObraMu, $Ancho, $FactorPlitz, $rapportHor);
																		//$Traslape,$FactorDesp, $PrecioTela, $LienzoTotal, $ManoObraMu, $Ancho, $FactorPlitz, $rapportHor
						//$Metraje = round((($Ancho * $FactorPlitz) + $rapportHor) * $FactorDesp,2);
						$Metraje = ($LienzoTotal>1) ? round((($Ancho * $FactorPlitz + $rapportHor+$Traslape) * $FactorDesp ),2) : round((($Ancho * $FactorPlitz +$Traslape) * $FactorDesp),2);
						$ClaveMo = $CodigoManoObraMu;
						$PrecioMo = $ManoObraMu;
						$MetrajeMo = round(($Ancho * $FactorPlitz + $rapportHor),2);
						$TipoFormula="Cortina Atravezada con Rapport";

						$MetrajeReal = ($AlturaReal*$LienzoReal);
						$MetrajeMoReal= $LienzoReal;
					}
					else{
						$Formula = "Cortina Atravezada"; 
						$PrecioFinal = FormulaCortinaAtravezada($Ancho,$FactorPlitz,$Traslape,$FactorDesp,$PrecioTela,$ManoObraMu);
						$Metraje = round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2);
						$ClaveMo = $CodigoManoObraMu;
						$PrecioMo = $ManoObraMu;
						$MetrajeMo = round(($Ancho * $FactorPlitz + $Traslape),2);
						$TipoFormula="Cortina Atravezada";
					}
				
			
			} elseif (($TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamanoBajoPlomo) <= $AnchoTela) && ($BajoPlomo=="SI")) {
				$Formula = "Bajo Plomo"; 
				$PrecioFinal = FormulaBajoPlomo($Ancho, $FactorPlitz, $Traslape, $FactorDesp, $PrecioTela, $ManoObraMu, $PrecioBajoPlomo);
				$Metraje = round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2);
				$ClaveMo = $CodigoManoObraMu;
				$PrecioMo = $ManoObraMu;
				$MetrajeMo = round(($Ancho * $FactorPlitz + $Traslape),2);
				$TipoFormula="Bajo Plomo";

			} elseif (($TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamanoBajoPlomo) <= $AnchoTela) and $rapport == "SI" and $rapportPlomo=="SI" and $rapportTra=="SI") {
				$Formula = "Bajo Plomo"; 
				$PrecioFinal = FormulaBajoPlomo($Ancho, $FactorPlitz, $Traslape, $FactorDesp, $PrecioTela, $ManoObraMu, $PrecioBajoPlomo);
				$Metraje = round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2);
				$ClaveMo = $CodigoManoObraMu;
				$PrecioMo = $ManoObraMu;
				$MetrajeMo = round(($Ancho * $FactorPlitz + $Traslape),2);
				$TipoFormula="Bajo Plomo";
			
			} elseif (($LienzoEntero%2==0 || $LienzoEntero==1 || $LienzoEntero==3 || $LienzoEntero==5 || $LienzoEntero==7) && ($LienzoTotalD > .1 && $LienzoTotalD<=.55) && $validar == "NO"){
				if($rapport=="SI"){
					if($rapportVert == null){
						$rapportVert = $rapportHor;						
					}

					$Formula = "Medio Lienzo con rapport"; 
					$rapportAltura = $AltoBastilla / $rapportVert;
					$rapportRound=ceil($rapportAltura);
					$PrecioFinal = FormulaMediasManosRapport($rapportPlomo,$LienzoEntero,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$rapportTra);
					$Metraje = round(($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp),2); //($AltoBastilla*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo= ($LienzoEntero + 0.5);
					$MetrajeBajoPlomo = ($rapportPlomo == "SI" && $rapportTra == "NO") ? (($Ancho*$FactorPlitz)) : 0 ;
					$TipoFormula="Medio Lienzo con rapport";					
				}
				else{
					$rapportRound=0;
					$Formula = "Medio Lienzo 2"; 
					$PrecioFinal = FormulaMedioLienzo($Altura,$LienzoTotal,$LienzoEntero,$ManoObraLz,$PrecioTela);
					$Metraje = ($Altura*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo= ($LienzoEntero + 0.5);
					$TipoFormula="Medio Lienzo 2";	
				}
				
			} else {

				if($rapport == "SI"){
					if($rapportVert == null){ $rapportVert = $rapportHor; }
					$Formula = "Normal Rapport";
					$rapportAltura = $AltoBastilla / $rapportVert;
					$rapportRound=ceil($rapportAltura);
					/*$PrecioFinal = FormulaNormalRapport($rapportRound,$rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo, $AltoBastilla);*/
					$PrecioFinal = FormulaNormalRapport($rapportPlomo,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$AltoBastilla,$rapportTra);
					$PrecioFinal = FormulaNormalRapport($rapportRound,$rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo, $AltoBastilla);
					$Metraje= ($LienzoTotal>1) ? round(($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp),2) : round(($AltoBastilla*$LienzoTotal*$FactorDesp),2);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo = $LienzoTotal;//$Lienzo;+	
					$MetrajeBajoPlomo = ($rapportPlomo == "SI" && $rapportTra == "NO") ? (($Ancho*$FactorPlitz)) : 0 ;				
					$TipoFormula="Normal Rapport";
				}
				else{				
					$rapportRound = 0 ;
					$Formula = "Normal"; 
					$PrecioFinal = FormulaNormal($Altura,$LienzoTotal,$ManoObraLz,$PrecioTela);
					$Metraje = ($Altura*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo = $LienzoTotal;//$Lienzo;
					$TipoFormula="Normal";
				}
			}

			if ($Stiffener == "SI"){
				$PrecioFinal = $PrecioFinal + $PrecioStiffener;
			}

			if ($Argolla == "SI"){
				$PrecioFinal = $PrecioFinal + $PrecioArgolla; //* $CantidadArgolla
			}

			print_r($TipoFormula);
			// AJUSTE PARA FORROS: quitar mano de obra completa
if (isset($GLOBALS["ForroX"]) && $GLOBALS["ForroX"] == "SI") {
    $PrecioFinal = $PrecioFinal - ($PrecioMo * $MetrajeMo);

    // Evitar negativos en caso de redondeos raros
    if ($PrecioFinal < 0) {
        $PrecioFinal = 0;
    }
}

	$arreglo = array();
	array_push($arreglo, array('precioformula'=>$PrecioFinal,'CodigoManoObra'=>$ClaveMo,'PrecioMo'=>$PrecioMo,'Metraje'=>$Metraje,
								'LienzoTotal'=>$LienzoTotal,'Altura'=>$Altura,'TipoFormula'=>$TipoFormula,'MetrajeMo'=>$MetrajeMo,
								'rapportAltura'=>$rapportRound,'rapportVert'=>$rapportVert,'rapportHor'=>$rapportHor,'MetrajeBajoPlomo'=>$MetrajeBajoPlomo));
	return $arreglo;
}



function Altura($Alto, $Bastilla, $FactorDesp) {
	
	$Var = round((($Alto + $Bastilla) * $FactorDesp), 2);
	
	return $Var;
}


function Lienzo($Ancho,$FactorPlitz,$Traslape,$AnchoTela) {
	$Var = round(((($Ancho * $FactorPlitz) + $Traslape) / $AnchoTela),2);
	return $Var;
}

// Formulas ////////////////////////////////////////////////////////////////////////////////////

function FormulaCortinaAtravezada($Ancho,$FactorPlitz,$Traslape,$FactorDesp,$PrecioTela,$ManoObraMu){

	$Valor = round((round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2) * $PrecioTela),2) + 

			 round(($ManoObraMu * round(($Ancho * $FactorPlitz + $Traslape),2)),2);

	return $Valor;
}


function FormulaBajoPlomo($Ancho,$FactorPlitz,$Traslape, $FactorDesp,$PrecioTela,$ManoObraMu,$PrecioBajoPlomo){

	$Valor = round((round((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp),2) * $PrecioTela),2) + round(($ManoObraMu * round(($Ancho * $FactorPlitz + $Traslape),2)),2) + round((round(($Ancho * $FactorPlitz),2) * $PrecioBajoPlomo),2);

	return $Valor;

}

function FormulaMedioLienzo($Altura, $LienzoTotal, $LienzoEntero,$ManoObraLz,$PrecioTela){
	$Valor = round(($Altura * $LienzoTotal * $PrecioTela),2) + round((($LienzoEntero + 0.5) * $ManoObraLz),2);
	return $Valor;
}

function FormulaNormal($Altura, $Lienzo,$ManoObraLz,$PrecioTela){

	$Valor = (($Altura * $Lienzo) * $PrecioTela) + ($Lienzo * $ManoObraLz);

	return $Valor;
}

//se ejecutara cuando la tela sea rapport y cobre medias manos de obra -> 
function FormulaMediasManosRapport($rapportPlomo,$LienzoEntero,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$rapportTra){
	$PTELA=round(round(($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp),2) * $PrecioTela,2);
	$PCONFECCION=$ManoObraLz * ($LienzoEntero + 0.5);//1.5;
	
	if ($rapportTra == "NO"){
		if ($rapportPlomo == "SI") {$PcBAJOPLOMO=($Ancho * $FactorPlitz) * $PrecioBajoPlomo;}else{$PcBAJOPLOMO=0;}	
	}
	
	$Valor=$PTELA+$PCONFECCION+$PcBAJOPLOMO;
	return $Valor;
}

//se ejecutara cuando la tela sea rapport -> 
function FormulaNormalRapport($rapportPlomo,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$AltoBastilla,$rapportTra){
	if($LienzoTotal>1){
		$PTELA=round(round(($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp),2) * $PrecioTela,2);
		$PCONFECCION=$LienzoTotal*$ManoObraLz;
		
		if ($rapportTra == "NO"){
			if ($rapportPlomo == "SI") {$PcBAJOPLOMO=($Ancho*$FactorPlitz)*$PrecioBajoPlomo;} ELSE { $PcBAJOPLOMO=0;}
		}
		
		$Valor=$PTELA+$PCONFECCION+$PcBAJOPLOMO;
	}
	else{
		$PTELA=round(round(($AltoBastilla*$LienzoTotal*$FactorDesp),2)*$PrecioTela,2);
		$PCONFECCION=$LienzoTotal*$ManoObraLz;

		if ($rapportTra == "NO"){
			if ($rapportPlomo == "SI") {$PcBAJOPLOMO=($Ancho*$FactorPlitz)*$PrecioBajoPlomo;} ELSE { $PcBAJOPLOMO=0;}
		}
		//$PcBAJOPLOMO=($Ancho*$FactorPlitz)*$PrecioBajoPlomo;
		$Valor=$PTELA+$PCONFECCION+$PcBAJOPLOMO;
	}
	return $Valor;
}

//se ejecutara cuando la tela sea rapport con medida vertical y sea costeada como atravezada -> 
function FormulaAtravezadaRapportVertical($Traslape,$FactorDesp, $PrecioTela, $LienzoTotal, $ManoObraMu, $Ancho, $FactorPlitz, $rapportHor){
		if($LienzoTotal>1){
			$PTELA=round(round((($Ancho * $FactorPlitz + $rapportHor+$Traslape) * $FactorDesp ),2) * $PrecioTela,2); //preguntar a adriana por rapports en ambos sentidos -- eliminar esta nota al confirmar
			$PCONFECCION=round($ManoObraMu * round(($Ancho * $FactorPlitz + $rapportHor + $Traslape),2),2);

			$Valor=$PTELA+$PCONFECCION;
	    }
	    else{
	    	$PTELA=round(round((($Ancho * $FactorPlitz +$Traslape) * $FactorDesp),2) * $PrecioTela,2); //preguntar a adriana por rapports en ambos sentidos -- eliminar esta nota al confirmar
			$PCONFECCION=round($ManoObraMu * round(($Ancho * $FactorPlitz+$Traslape),2),2);

			$Valor=$PTELA+$PCONFECCION;	
	    }
		return $Valor;
}

// Fin de Formulas ///////////////////////////////

function round_up($value, $places){
    $mult = pow(10, abs($places)); 
    return $places < 0 ?
    ceil($value / $mult) * $mult :
        ceil($value * $mult) / $mult;
}

?>