<?php

function Cotizar($Alto, 
				 $Ancho,
				 $FactorPlitz,
				 $FactorDesp, 
				 $Bastilla, 
				 $TamañoBajoPlomo, 
				 $Traslape, 
				 $PrecioBajoPlomo, 
				 $TelaBajoPlomo,
				 $AnchoTela,
				 $PrecioTela,
				 $ManoObraMu,
				 $ManoObraLz14,
				 $ManoObraLz28,
				 $NeverLight,
				 $TamañoNeverLight,
				 $Stiffener,
				 $PrecioStiffener,
				 $CodigoManoObraMu,
				 $CodigoManoObraLz14,
				 $CodigoManoObraLz28,
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
				$Alto = $Alto + $TamañoNeverLight;
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

		 	if ($AnchoTela>=2.8){

		 		$ManoObraLz = $ManoObraLz28;
		 		$ClaveMoLz = $CodigoManoObraLz28;
		 	}
		 	else{

		 		$ManoObraLz = $ManoObraLz14;
		 		$ClaveMoLz = $CodigoManoObraLz14;
		 	}

		 	$MetrajeBajoPlomo = 0;
		 	//$ClaveMo ="" ;
			if ($Alto >= 2 && $Alto + $Bastilla <= $AnchoTela){
					if($rapport == "SI"){
						$Formula = "Cortina Atravezada con Rapport"; 
						$rapportAltura = $AltoBastilla / $rapportVert;
						$rapportRound=ceil($rapportAltura);
						$PrecioFinal = FormulaAtravezadaRapportVertical($Traslape,$FactorDesp, $PrecioTela, $LienzoTotal, $ManoObraMu, $Ancho, $FactorPlitz, $rapportHor);
																		//$Traslape,$FactorDesp, $PrecioTela, $LienzoTotal, $ManoObraMu, $Ancho, $FactorPlitz, $rapportHor
						$Metraje = (($Ancho * $FactorPlitz) + $rapportHor) * $FactorDesp;
						$ClaveMo = $CodigoManoObraMu;
						$PrecioMo = $ManoObraMu;
						$MetrajeMo = ($Ancho * $FactorPlitz + $rapportHor);
						$TipoFormula="Cortina Atravezada con Rapport";
					}
					else{
						$Formula = "Cortina Atravezada"; 
						$PrecioFinal = FormulaCortinaAtravezada($Ancho,$FactorPlitz,$Traslape,$FactorDesp,$PrecioTela,$ManoObraMu);
						$Metraje = (($Ancho * $FactorPlitz + $Traslape) * $FactorDesp);
						$ClaveMo = $CodigoManoObraMu;
						$PrecioMo = $ManoObraMu;
						$MetrajeMo = ($Ancho * $FactorPlitz + $Traslape);
						$TipoFormula="Cortina Atravezada";
					}
				
			
			} elseif (($TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamañoBajoPlomo) <= $AnchoTela) && ($BajoPlomo=="SI")) {

				$Formula = "Bajo Plomo"; 
				$PrecioFinal = FormulaBajoPlomo($Ancho, $FactorPlitz, $Traslape, $FactorDesp, $PrecioTela, $ManoObraMu, $PrecioBajoPlomo);
				$Metraje = (($Ancho * $FactorPlitz + $Traslape) * $FactorDesp);
				$ClaveMo = $CodigoManoObraMu;
				$PrecioMo = $ManoObraMu;
				$MetrajeMo = ($Ancho * $FactorPlitz + $Traslape);
				$TipoFormula="Bajo Plomo";

			} elseif (($TelaBajoPlomo==TRUE) && ($Alto >=2) && ($Alto + ($Bastilla-$TamañoBajoPlomo) <= $AnchoTela) and $rapport == "SI" and $rapportPlomo=="SI" and $rapportTra=="SI") {

				$Formula = "Bajo Plomo"; 
				$PrecioFinal = FormulaBajoPlomo($Ancho, $FactorPlitz, $Traslape, $FactorDesp, $PrecioTela, $ManoObraMu, $PrecioBajoPlomo);
				$Metraje = (($Ancho * $FactorPlitz + $Traslape) * $FactorDesp);
				$ClaveMo = $CodigoManoObraMu;
				$PrecioMo = $ManoObraMu;
				$MetrajeMo = ($Ancho * $FactorPlitz + $Traslape);
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
					$Metraje = ($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp); //($AltoBastilla*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo= ($LienzoEntero + 0.5);
					$MetrajeBajoPlomo = ($rapportPlomo == "SI") ? (($Ancho*$FactorPlitz)) : 0 ;
					$TipoFormula="Medio Lienzo con rapport";					
				}
				else{
					$rapportRound=0;
					$Formula = "Medio Lienzo"; 
					$PrecioFinal = FormulaMedioLienzo($Altura,$LienzoTotal,$LienzoEntero,$ManoObraLz,$PrecioTela);
					$Metraje = ($Altura*$LienzoTotal);
					$ClaveMo = $ClaveMoLz;
					$PrecioMo = $ManoObraLz;
					$MetrajeMo= ($LienzoEntero + 0.5);
					$TipoFormula="Medio Lienzo";	
				}
				
			} else {

				if($rapport == "SI"){
					if($rapportVert == null){ $rapportVert = $rapportHor; }
					$Formula = "Normal Rapport";
					$rapportAltura = $AltoBastilla / $rapportVert;
					$rapportRound=ceil($rapportAltura);
					/*$PrecioFinal = FormulaNormalRapport($rapportRound,$rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo, $AltoBastilla);*/
					$PrecioFinal = FormulaNormalRapport($rapportPlomo,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$AltoBastilla,$rapportTra);
					$Metraje = ($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp); //($Alto*$LienzoTotal);
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


			if ($Stiffener == "SI"){
				$PrecioFinal = $PrecioFinal + $PrecioStiffener;
			}


			/*return "Formula: " . $Formula . "<br> Resultado: <b>" . round($PrecioFinal,2) . "</b>" . "<br> " .
			" Alto: " . $Alto . " Ancho: " . $Ancho . " " .
			"<br> Bastilla: " . $Bastilla . " Ancho tela: " . $AnchoTela .
			"<br> FactorPlitz: " . $FactorPlitz . " Factor Desp: " . $FactorDesp .
			"<br> Precio Tela: " . $PrecioTela . "   Mo Lz 1.4: " . $ManoObraLz14 .
			"<br> Mo Lz 2.8: " . $ManoObraLz28 . " Mo Mu: " . $ManoObraMu .
			"<br> MO utilizada : " . $ManoObraLz . 
			"<br> Valor Stiffener: " . $Stiffener . " Precio Stiffener: " . $PrecioStiffener .
			"<br> Lienzo total:  " . $LienzoTotal  . " Altura : " . $Altura; */

			$arreglo = array();
			array_push($arreglo, array('precioformula'=>$PrecioFinal,'CodigoManoObra'=>$ClaveMo,'PrecioMo'=>$PrecioMo,'Metraje'=>$Metraje,
										'LienzoTotal'=>$LienzoTotal,'Altura'=>$Altura,'TipoFormula'=>$TipoFormula,'MetrajeMo'=>$MetrajeMo,
										'rapportAltura'=>$rapportRound,'rapportVert'=>$rapportVert,'rapportHor'=>$rapportHor,'MetrajeBajoPlomo'=>$MetrajeBajoPlomo));
			return $arreglo;

			//return $PrecioMo;
			//return round($PrecioFinal,2);

}



function Altura($Alto, $Bastilla, $FactorDesp) {
	
	$Var = round((($Alto + $Bastilla) * $FactorDesp), 2);

		?> 
		<!--<script type="text/javascript">
			var Alto = "<?php echo $Alto; ?>" ;
			var Bastilla = "<?php echo $Bastilla; ?>" ; 
			var FactorDesp = "<?php echo $FactorDesp ; ?>" ;
						
			alert("( " + Alto + " + " + Bastilla +" ) * "+ FactorDesp+" )");
		</script>-->
	<?php
	
	return $Var;
}


function Lienzo($Ancho,$FactorPlitz,$Traslape,$AnchoTela) {

	$Var = round(((($Ancho * $FactorPlitz) + $Traslape) / $AnchoTela),2);
	
	return $Var;
}



// Formulas ////////////////////////////////////////////////////////////////////////////////////

function FormulaCortinaAtravezada($Ancho,$FactorPlitz,$Traslape,$FactorDesp,$PrecioTela,$ManoObraMu){

	$Valor = ((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp) * $PrecioTela) + 

			 ($ManoObraMu * ($Ancho * $FactorPlitz + $Traslape));

	return $Valor;
}


function FormulaBajoPlomo($Ancho,$FactorPlitz,$Traslape, $FactorDesp,$PrecioTela,$ManoObraMu,$PrecioBajoPlomo){

	$Valor = ((($Ancho * $FactorPlitz + $Traslape) * $FactorDesp) * $PrecioTela) + ($ManoObraMu * ($Ancho * $FactorPlitz + $Traslape)) + (($Ancho * $FactorPlitz) * $PrecioBajoPlomo);

	return $Valor;

}

function FormulaMedioLienzo($Altura, $Lienzo, $LienzoEntero,$ManoObraLz,$PrecioTela){

	$Valor = ($Altura * $Lienzo * $PrecioTela) + (($LienzoEntero + 0.5) * $ManoObraLz);

	return $Valor;
}

function FormulaNormal($Altura, $Lienzo,$ManoObraLz,$PrecioTela){

	$Valor = (($Altura * $Lienzo) * $PrecioTela) + ($Lienzo * $ManoObraLz);

	return $Valor;
}

//se ejecutara cuando la tela sea rapport y cobre medias manos de obra -> 
function FormulaMediasManosRapport($rapportPlomo,$LienzoEntero,$rapportRound, $rapportVert, $LienzoTotal, $FactorDesp, $PrecioTela, $ManoObraLz, $Ancho, $FactorPlitz, $PrecioBajoPlomo,$rapportTra){
	$PTELA=($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp) * $PrecioTela;
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
		$PTELA=($rapportRound * $rapportVert * $LienzoTotal * $FactorDesp) * $PrecioTela;
		$PCONFECCION=$LienzoTotal*$ManoObraLz;
		
		if ($rapportTra == "NO"){
			if ($rapportPlomo == "SI") {$PcBAJOPLOMO=($Ancho*$FactorPlitz)*$PrecioBajoPlomo;} ELSE { $PcBAJOPLOMO=0;}
		}
		
		$Valor=$PTELA+$PCONFECCION+$PcBAJOPLOMO;
	}
	else{
		$PTELA=($AltoBastilla*$LienzoTotal*$FactorDesp)*$PrecioTela;
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
			$PTELA=(($Ancho * $FactorPlitz + $rapportHor+$Traslape) * $FactorDesp ) * $PrecioTela; //preguntar a adriana por rapports en ambos sentidos -- eliminar esta nota al confirmar
			$PCONFECCION=$ManoObraMu * ($Ancho * $FactorPlitz + $rapportHor + $Traslape);

			$Valor=$PTELA+$PCONFECCION;
	    }
	    else{
	    	$PTELA=(($Ancho * $FactorPlitz +$Traslape) * $FactorDesp ) * $PrecioTela; //preguntar a adriana por rapports en ambos sentidos -- eliminar esta nota al confirmar
			$PCONFECCION=$ManoObraMu * ($Ancho * $FactorPlitz+$Traslape);

			$Valor=$PTELA+$PCONFECCION;	
	    }
		return $Valor;
}

// Fin de Formulas ////////////////////////////////////////////////////////////////////////////////


function round_up($value, $places) 
{
    $mult = pow(10, abs($places)); 
     return $places < 0 ?
    ceil($value / $mult) * $mult :
        ceil($value * $mult) / $mult;
}


?>

