<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../clases/Carrito.class.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$carrito = new Carrito();

$lado_cordon=""; $codoCurveado=""; $cantidadCodos=""; $curvoRecto="";
$id =""; $Cantidad =""; $precioFinal =""; $nombre =""; $tipoarticulo =""; $ruta =""; $ancho =""; $codigo =""; $alto =""; $tipocortina =""; $fijacion =""; $acoplamiento =""; $tela =""; $color =""; $gancho =""; $bajoplomo =""; $stiffener =""; $neverlight =""; $telaForro =""; $PrecioTela =""; $CodigoTela =""; $Metraje =""; $ColorForro =""; $PrecioFinalForro =""; $CodigoTelaForro =""; $CodigoMoForro =""; $PrecioTelaForro =""; $PrecioMoForro =""; $CodigoMo =""; $PrecioMo =""; $MetrajeMo =""; $MetrajeForro =""; $MetrajeMoForro =""; $CodigoStiffener =""; $PrecioStiffener =""; $TipoArticuloDetalle =""; $area =""; $CodigoBajoPlomo =""; $PrecioPlomo =""; $MetrajeBajoPlomo =""; $cantidadHojas =""; $control =""; $decorativo =""; $peso =""; $remate =""; $resultadoSistema =""; $soporte =""; $argolla =""; $baston =""; $colorBaston =""; $radioMedida =""; $radioMaterial =""; $cantBaston =""; $codigoBaston =""; $precioBaston =""; $cantidadBastonFija =""; $proyecciones =""; $copete =""; $MetrajeGaleria =""; $medidaProyeccion =""; $MLManoObra =""; $TotalEscuadras =""; $CodigoCopete =""; $CodigoEscuadras =""; $PrecioEscuadras =""; $AnchoTela =""; $AprovTela =""; $AplicaAprov =""; $ConsecAprov =""; $Varilla =""; $CodigoMecanismo =""; $PrecioMecanismo =""; $controlMot =""; $precioControl =""; $codigoControl =""; $nombreControl =""; $tipoControlMot =""; $idDrapesNombre =""; $CodigoArgolla =""; $CantidadArgolla =""; $PrecioArgolla =""; $MetrajeReal =""; $MetrajeMOReal =""; $PrecioReal =""; $PrecioMoReal =""; $MetrajeRealForro =""; $MetrajeMORealForro =""; $PrecioRealForro =""; $PrecioMoRealForro =""; $MetrajeBajoPlomoReal =""; $OrientacionRayaCortina =""; $colorCinta =""; $resultadoMotor =""; $cortinairregular =""; $hojaizquierda =""; $hojaderecha ="";

				/*$id ="";
				$Cantidad ="";
				$precioFinal ="";
				$nombre ="";
				$tipoarticulo ="";
				$ruta ="";
				$ancho ="";
				$codigo ="";
				$alto ="";
				$tipocortina ="";
				$fijacion ="";
				$acoplamiento ="";
				$tela ="";
				$color ="";
				$gancho ="";
				$bajoplomo ="";
				$stiffener ="";
				$neverlight ="";
				$telaForro ="";
				$PrecioTela ="";
				$CodigoTela ="";
				$Metraje ="";
				$ColorForro ="";
				$PrecioFinalForro ="";
				$CodigoTelaForro ="";
				$CodigoMoForro ="";
				$PrecioTelaForro ="";
				$PrecioMoForro ="";
				$CodigoMo ="";
				$PrecioMo ="";
				$MetrajeMo ="";
				$MetrajeForro ="";
				$MetrajeMoForro ="";
				$CodigoStiffener ="";
				$PrecioStiffener ="";
				$TipoArticuloDetalle ="";
				$area ="";
				$cantidadHojas ="";
				$control ="";
				$decorativo ="";
				$peso ="";
				$remate ="";
				$resultadoSistema ="";
				$soporte ="";
				$argolla ="";
				$baston ="";
				$colorBaston ="";
				$radioMedida ="";
				$radioMaterial ="";
				$cantBaston ="";
				$codigoBaston ="";
				$precioBaston ="";		
				$proyecciones ="";
				$copete ="";
				$MetrajeGaleria ="";
				$CodigoMecanismo ="";
				$PrecioMecanismo ="";*/

if (isset( $_SESSION['folio'] )){
	if( $_SESSION['estatus'] == 2 or $_SESSION['estatus'] == 0){
		
		$_SESSION['folio'] = null;
		$_SESSION['IdCliente'] =null;
		$_SESSION['NombreCliente'] = null;
		$_SESSION['estatus'] = null;
		$carrito->destroy();

	}
}

/* *********************** GENERAL ************************************ */

if (isset($_POST['id']) and $_POST['id'] <> ""){ $id = $_POST['id']; }
if (isset($_POST['Cantidad']) and $_POST['Cantidad'] <> ""){ $Cantidad = $_POST['Cantidad']; }
if (isset($_POST['precioFinal']) and $_POST['precioFinal'] <> ""){ $precioFinal = $_POST['precioFinal']; }
if (isset($_POST['nombre']) and $_POST['nombre'] <> ""){ $nombre = $_POST['nombre']; }
if (isset($_POST['codigo']) and $_POST['codigo'] <> ""){ $codigo = $_POST['codigo']; }
if (isset($_POST['tipoarticulo']) and $_POST['tipoarticulo'] <> ""){ $tipoarticulo = $_POST['tipoarticulo']; }
if (isset($_POST['ruta']) and $_POST['ruta'] <> ""){ $ruta = $_POST['ruta']; }

if (isset($_POST['ancho']) and $_POST['ancho'] <> ""){  $ancho = $_POST['ancho']; }
if (isset($_POST['color']) and $_POST['color'] <> ""){ $color = $_POST['color']; }
if (isset($_POST['fijacion']) and $_POST['fijacion'] <> ""){ $fijacion = $_POST['fijacion']; }

if (isset($_POST['TipoArticuloDetalle']) and $_POST['TipoArticuloDetalle'] <> ""){ $TipoArticuloDetalle = $_POST['TipoArticuloDetalle']; }

if (isset($_POST['area']) and $_POST['area'] <> ""){ 
    $area = $_POST['area']; 
    // Si viene la bandera 'encoded', significa que el área viene en Base64
    if (isset($_POST['encoded']) && $_POST['encoded'] == 1) {
        // Decodificamos Base64
        $decoded = base64_decode($area);
        // Validamos que la decodificación sea UTF-8 válida, si no, mantenemos el original
        if (mb_check_encoding($decoded, 'UTF-8')) {
            $area = $decoded;
        }
    }
}

/* *********************** GENERAL ************************************ */

if (isset($_POST['cortinairregular']) and $_POST['cortinairregular'] <> ""){  $cortinairregular = $_POST['cortinairregular']; }
if (isset($_POST['hojaizquierda']) and $_POST['hojaizquierda'] <> ""){  $hojaizquierda = $_POST['hojaizquierda']; }
if (isset($_POST['hojaderecha']) and $_POST['hojaderecha'] <> ""){  $hojaderecha = $_POST['hojaderecha']; }

/* *********************** CORTINA ************************************ */

if (isset($_POST['alto']) and $_POST['alto'] <> ""){  $alto = $_POST['alto']; }
if (isset($_POST['tipocortina']) and $_POST['tipocortina'] <> ""){ $tipocortina = $_POST['tipocortina']; }
if (isset($_POST['acoplamiento']) and $_POST['acoplamiento'] <> ""){  $acoplamiento = $_POST['acoplamiento']; }
if (isset($_POST['tela']) and $_POST['tela'] <> ""){  $tela = $_POST['tela']; }
if (isset($_POST['PrecioTela']) and $_POST['PrecioTela'] <> ""){  $PrecioTela = $_POST['PrecioTela']; }
if (isset($_POST['CodigoTela']) and $_POST['CodigoTela'] <> ""){  $CodigoTela = $_POST['CodigoTela']; }
if (isset($_POST['Metraje']) and $_POST['Metraje'] <> ""){  $Metraje = $_POST['Metraje']; }
//CodigoTela

if (isset($_POST['CodigoMo']) and $_POST['CodigoMo'] <> ""){  $CodigoMo = $_POST['CodigoMo']; }
if (isset($_POST['PrecioMo']) and $_POST['PrecioMo'] <> ""){  $PrecioMo = $_POST['PrecioMo']; }
if (isset($_POST['MetrajeMo']) and $_POST['MetrajeMo'] <> ""){  $MetrajeMo = $_POST['MetrajeMo']; } 
if (isset($_POST['MetrajeMoForro']) and $_POST['MetrajeMoForro'] <> ""){  $MetrajeMoForro = $_POST['MetrajeMoForro']; }

if (isset($_POST['telaForro']) and $_POST['telaForro'] <> ""){  $telaForro = $_POST['telaForro']; }
if (isset($_POST['ColorForro']) and $_POST['ColorForro'] <> ""){  $ColorForro = $_POST['ColorForro'];}
if (isset($_POST['PrecioTelaForro']) and $_POST['PrecioTelaForro'] <> ""){  $PrecioTelaForro = $_POST['PrecioTelaForro'];}

if (isset($_POST['PrecioFinalForro']) and $_POST['PrecioFinalForro'] <> ""){  $PrecioFinalForro = $_POST['PrecioFinalForro']; }
if (isset($_POST['CodigoTelaForro']) and $_POST['CodigoTelaForro'] <> ""){  $CodigoTelaForro = $_POST['CodigoTelaForro'];}
if (isset($_POST['CodigoMoForro']) and $_POST['CodigoMoForro'] <> ""){  $CodigoMoForro = $_POST['CodigoMoForro']; }
if (isset($_POST['PrecioMoForro']) and $_POST['PrecioMoForro'] <> ""){  $PrecioMoForro = $_POST['PrecioMoForro']; }
if (isset($_POST['MetrajeForro']) and $_POST['MetrajeForro'] <> ""){  $MetrajeForro = $_POST['MetrajeForro']; }

if (isset($_POST['CodigoBajoPlomo']) and $_POST['CodigoBajoPlomo'] <> ""){  $CodigoBajoPlomo = $_POST['CodigoBajoPlomo']; }
if (isset($_POST['PrecioPlomo']) and $_POST['PrecioPlomo'] <> ""){  $PrecioPlomo = $_POST['PrecioPlomo']; }
if (isset($_POST['MetrajeBajoPlomo']) and $_POST['MetrajeBajoPlomo'] <> ""){  $MetrajeBajoPlomo = $_POST['MetrajeBajoPlomo']; }

/* ******** son necesarias para asignar los metrajes y precios reales en SAP********* */
if (isset($_POST['MetrajeReal']) and $_POST['MetrajeReal'] <> ""){  $MetrajeReal = $_POST['MetrajeReal']; }
if (isset($_POST['MetrajeMOReal']) and $_POST['MetrajeMOReal'] <> ""){  $MetrajeMOReal = $_POST['MetrajeMOReal']; }
if (isset($_POST['PrecioReal']) and $_POST['PrecioReal'] <> ""){  $PrecioReal = $_POST['PrecioReal']; }
if (isset($_POST['PrecioMoReal']) and $_POST['PrecioMoReal'] <> ""){  $PrecioMoReal = $_POST['PrecioMoReal']; }
if (isset($_POST['MetrajeRealForro']) and $_POST['MetrajeRealForro'] <> ""){  $MetrajeRealForro = $_POST['MetrajeRealForro']; }
if (isset($_POST['MetrajeMORealForro']) and $_POST['MetrajeMORealForro'] <> ""){  $MetrajeMORealForro = $_POST['MetrajeMORealForro']; }
if (isset($_POST['PrecioRealForro']) and $_POST['PrecioRealForro'] <> ""){  $PrecioRealForro = $_POST['PrecioRealForro']; }
if (isset($_POST['PrecioMoRealForro']) and $_POST['PrecioMoRealForro'] <> ""){  $PrecioMoRealForro = $_POST['PrecioMoRealForro']; }
if (isset($_POST['MetrajeBajoPlomoReal']) and $_POST['MetrajeBajoPlomoReal'] <> ""){  $MetrajeBajoPlomoReal = $_POST['MetrajeBajoPlomoReal']; }

/* ******** variables ********* */
if (isset($_POST['gancho']) and $_POST['gancho'] <> ""){ $gancho = $_POST['gancho']; }
if (isset($_POST['bajoplomo']) and $_POST['bajoplomo'] <> ""){ $bajoplomo = $_POST['bajoplomo']; }
if (isset($_POST['stiffener']) and $_POST['stiffener'] <> ""){ $stiffener = $_POST['stiffener']; }
if (isset($_POST['neverlight']) and $_POST['neverlight'] <> ""){ $neverlight = $_POST['neverlight']; }

if (isset($_POST['CodigoStiffener']) and $_POST['CodigoStiffener'] <> ""){  $CodigoStiffener = $_POST['CodigoStiffener']; }
if (isset($_POST['PrecioStiffener']) and $_POST['PrecioStiffener'] <> ""){  $PrecioStiffener = $_POST['PrecioStiffener']; }

if(isset($_POST['colorCinta']) and $_POST['colorCinta'] <> "") { $colorCinta = $_POST['colorCinta']; }
/* ******** variables ********* */


if (isset($_POST['CodigoArgolla']) and $_POST['CodigoArgolla'] <> ""){ $CodigoArgolla = $_POST['CodigoArgolla']; }
if (isset($_POST['CantidadArgolla']) and $_POST['CantidadArgolla'] <> ""){ $CantidadArgolla = $_POST['CantidadArgolla']; }
if (isset($_POST['PrecioArgolla']) and $_POST['PrecioArgolla'] <> ""){ $PrecioArgolla = $_POST['PrecioArgolla']; }

/* *********************** CORTINA ************************************ */


/* *********************** CORTINERO ********************************** */

if (isset($_POST['cantidadHojas']) and $_POST['cantidadHojas'] <> ""){$cantidadHojas = $_POST['cantidadHojas'];}

if (isset($_POST['control']) and $_POST['control'] <> ""){$control = $_POST['control'];}

if (isset($_POST['decorativo']) and $_POST['decorativo'] <> ""){$decorativo = $_POST['decorativo'];}

if (isset($_POST['peso']) and $_POST['peso'] <> ""){$peso = $_POST['peso'];}

if (isset($_POST['remate']) and $_POST['remate'] <> ""){$remate = $_POST['remate'];}

if (isset($_POST['resultadoSistema']) and $_POST['resultadoSistema'] <> ""){$resultadoSistema = $_POST['resultadoSistema'];}

//Add codoCurveado variable capture from POST data
if (isset($_POST['codoCurveado']) and $_POST['codoCurveado'] <> ""){$codoCurveado = $_POST['codoCurveado'];}

//Add curvoRecto variable capture from POST data
if (isset($_POST['curvoRecto']) and $_POST['curvoRecto'] <> ""){$curvoRecto = $_POST['curvoRecto'];}

//Articulo de la curva (SERVICIO-CURV-KS o DT-CODO-GLYDEA90°), cantidad por cortinero y precio unitario
$codigoCurva = ""; $cantidadCurva = ""; $precioCurva = "";
if (isset($_POST['codigoCurva']) and $_POST['codigoCurva'] <> ""){$codigoCurva = $_POST['codigoCurva'];}
if (isset($_POST['cantidadCurva']) and $_POST['cantidadCurva'] <> ""){$cantidadCurva = $_POST['cantidadCurva'];}
if (isset($_POST['precioCurva']) and $_POST['precioCurva'] <> ""){$precioCurva = $_POST['precioCurva'];}

if (isset($_POST['cantidadCodos']) and $_POST['cantidadCodos'] <> ""){$cantidadCodos = $_POST['cantidadCodos'];}

if (isset($_POST['motor']) and $_POST['motor'] <> ""){$resultadoMotor = $_POST['motor'];}

if (isset($_POST['soporte']) and $_POST['soporte'] <> ""){$soporte = $_POST['soporte'];}

if (isset($_POST['argolla']) and $_POST['argolla'] <> ""){$argolla = $_POST['argolla'];}

/* ************************ BASTON ************************************* **/

if (isset($_POST['baston']) and $_POST['baston'] <> ""){$baston = $_POST['baston'];}//true or false

if (isset($_POST['colorBaston']) and $_POST['colorBaston'] <> ""){$colorBaston = $_POST['colorBaston'];}//color baston NATURAL,BLANCO,CAFE OSCURO,

if (isset($_POST['radioMedida']) and $_POST['radioMedida'] <> ""){$radioMedida = $_POST['radioMedida'];}//MEDIAS DEL BASTON

if (isset($_POST['radioMaterial']) and $_POST['radioMaterial'] <> ""){$radioMaterial = $_POST['radioMaterial'];}//MATERIAL ACERO INOXIDABLE O ACRILICO

if (isset($_POST['valorBaston']) and $_POST['valorBaston'] <> ""){$valorBaston = $_POST['valorBaston'];}// SI O NO

if (isset($_POST['cantBaston']) and $_POST['cantBaston'] <> ""){$cantBaston = $_POST['cantBaston'];}// CANTIDAD DE BASTONES POR CORTINERO 1,2,4

if (isset($_POST['codigoBaston']) and $_POST['codigoBaston'] <> ""){$codigoBaston = $_POST['codigoBaston'];}//CODIGO DEL BASTON

if (isset($_POST['precioBaston']) and $_POST['precioBaston'] <> ""){$precioBaston = $_POST['precioBaston'];}//PRECIO DEL BASTON 1,2,4 DEPENDIENDO DE LAS VARIABLES

if (isset($_POST['cantidadBastonFija']) and $_POST['cantidadBastonFija'] <> ""){$cantidadBastonFija = $_POST['cantidadBastonFija'];}//PRECIO DEL BASTON 1,2,4 DEPENDIENDO DE LAS VARIABLES
/* ************************ BASTON ************************************* **/

/* *********************** CORTINERO ********************************** */

/* ************************ CONTROL ************************************* **/

if (isset($_POST['controlMot']) and $_POST['controlMot'] <> ""){$controlMot = $_POST['controlMot'];}
if (isset($_POST['precioControl']) and $_POST['precioControl'] <> ""){$precioControl = $_POST['precioControl'];} 
if (isset($_POST['codigoControl']) and $_POST['codigoControl'] <> ""){$codigoControl = $_POST['codigoControl'];} 
if (isset($_POST['nombreControl']) and $_POST['nombreControl'] <> ""){$nombreControl = $_POST['nombreControl'];} 
if (isset($_POST['tipoControlMot']) and $_POST['tipoControlMot'] <> ""){$tipoControlMot = $_POST['tipoControlMot'];}  
if (isset($_POST['idDrapesNombre']) and $_POST['idDrapesNombre'] <> ""){$idDrapesNombre = $_POST['idDrapesNombre'];}

/* ************************ CONTROL ************************************* **/


/* ***********************  GALERIA  ********************************** */ 
if (isset($_POST['proyecciones']) and $_POST['proyecciones'] <> ""){$proyecciones = $_POST['proyecciones'];}

if (isset($_POST['copete']) and $_POST['copete'] <> ""){$copete = $_POST['copete'];}

if (isset($_POST['MetrajeGaleria']) and $_POST['MetrajeGaleria'] <> ""){$MetrajeGaleria = $_POST['MetrajeGaleria'];}

if (isset($_POST['medidaProyeccion']) and $_POST['medidaProyeccion'] <> ""){$medidaProyeccion = $_POST['medidaProyeccion'];}

if (isset($_POST['MLManoObra']) and $_POST['MLManoObra'] <> ""){$MLManoObra = $_POST['MLManoObra'];}

if (isset($_POST['TotalEscuadras']) and $_POST['TotalEscuadras'] <> ""){$TotalEscuadras = $_POST['TotalEscuadras'];}

if (isset($_POST['CodigoCopete']) and $_POST['CodigoCopete'] <> ""){$CodigoCopete = $_POST['CodigoCopete'];}

if (isset($_POST['CodigoMoForro']) and $_POST['CodigoMoForro'] <> ""){$CodigoMoForro = $_POST['CodigoMoForro'];}

if (isset($_POST['CodigoEscuadras']) and $_POST['CodigoEscuadras'] <> ""){$CodigoEscuadras = $_POST['CodigoEscuadras'];}

if (isset($_POST['PrecioEscuadras']) and $_POST['PrecioEscuadras'] <> ""){$PrecioEscuadras = $_POST['PrecioEscuadras'];}
/* ***********************  GALERIA  ********************************** */


/* ***********************  PERSIANA  ********************************** */
if (isset($_POST['CodigoMecanismo']) and $_POST['CodigoMecanismo'] <> ""){$CodigoMecanismo = $_POST['CodigoMecanismo'];}
if (isset($_POST['PrecioMecanismo']) and $_POST['PrecioMecanismo'] <> ""){$PrecioMecanismo = $_POST['PrecioMecanismo'];}
if (isset($_POST['AnchoTela']) and $_POST['AnchoTela'] <> ""){$AnchoTela = $_POST['AnchoTela'];}
if (isset($_POST['AprovTela']) and $_POST['AprovTela'] <> ""){$AprovTela = $_POST['AprovTela'];}
if (isset($_POST['AplicaAprov']) and $_POST['AplicaAprov'] <> ""){$AplicaAprov = $_POST['AplicaAprov'];}
if (isset($_POST['ConsecAprov']) and $_POST['ConsecAprov'] <> ""){$ConsecAprov = $_POST['ConsecAprov'];}
if (isset($_POST['Varilla'])) {
	$VarillaPost = strtoupper(trim((string)$_POST['Varilla']));
	$Varilla = ($VarillaPost === "SI") ? "SI" : "NO";
}
/* ***********************  PERSIANA  ********************************** */

/* ***********************  ORIENTACIÓN RAYA  ********************************** */
if (isset($_POST['OrientacionRayaCortina']) and $_POST['OrientacionRayaCortina'] <> ""){$OrientacionRayaCortina = $_POST['OrientacionRayaCortina'];}
/* ***********************  ORIENTACIÓN RAYA  ********************************** */
// --- AJUSTE DE FORRO (solo paga tela + 30% mano de obra) ---
if (isset($PrecioFinalForro) && $PrecioFinalForro > 0) {
    // Calculamos manualmente el forro ajustado
    $PrecioTelaForro = isset($PrecioTelaForro) ? floatval($PrecioTelaForro) : 0;
    $MetrajeForro = isset($MetrajeForro) ? floatval($MetrajeForro) : 1;
    $PrecioMoForro = isset($PrecioMoForro) ? floatval($PrecioMoForro) : 0;
    $MetrajeMoForro = isset($MetrajeMoForro) ? floatval($MetrajeMoForro) : 1;

    // Cálculo correcto
    $ForroAjustado = ($PrecioTelaForro * $MetrajeForro) + (($PrecioMoForro * $MetrajeMoForro) * 0.3);

    // Sobrescribimos el valor total del forro
    $PrecioFinalForro = round($ForroAjustado, 2);
}


if ($tipoarticulo === "romana") {
	$Varilla = (isset($_POST['Varilla']) && strtoupper(trim((string)$_POST['Varilla'])) === "SI") ? "SI" : "NO";
	// DEBUG: Ver qué se recibe y qué se guarda
	error_log("[DEBUG VARILLA] POST Varilla: " . (isset($_POST['Varilla']) ? $_POST['Varilla'] : 'NOT SET') . " => Final Varilla: " . $Varilla);
}

if (($precioFinal === "" || !is_numeric($precioFinal)) && isset($_POST['old_id']) && $_POST['old_id'] !== "") {
	$oldUniqueIdById = md5($_POST['old_id']);
	if (isset($_SESSION['carrito'][$oldUniqueIdById]) && isset($_SESSION['carrito'][$oldUniqueIdById]['precio'])) {
		$precioFinal = $_SESSION['carrito'][$oldUniqueIdById]['precio'];
	}
}

  $articulo = array(
					"id"				=>		$id,
					"cantidad"			=>		$Cantidad,
					"precio"			=>		$precioFinal,
					"nombre"			=>		$nombre,
					"tipoarticulo"		=>		$tipoarticulo,
					"ruta"				=>		$ruta,
					"ancho"				=>		$ancho,
					"codigo"			=>		$codigo,
					"alto"				=>		$alto,
					"tipocortina"		=>		$tipocortina,
					"fijacion"			=>		$fijacion,
					"acoplamiento"		=>		$acoplamiento,
					"tela"				=>		$tela,
					"color"				=>		$color,
					"gancho"			=>		$gancho,
					"bajoplomo"			=>		$bajoplomo,
					"stiffener"			=>		$stiffener,
					"neverlight"		=>		$neverlight,
					"telaForro"			=>      $telaForro,
					"PrecioTela"		=>		$PrecioTela,
					"CodigoTela"		=>		$CodigoTela,
					"Metraje"			=>		$Metraje,
					"ColorForro"		=>		$ColorForro,
					"PrecioFinalForro"	=>		$PrecioFinalForro,
					"CodigoTelaForro"	=>		$CodigoTelaForro,
					"CodigoMoForro"		=>		$CodigoMoForro,
					"PrecioTelaForro"	=>		$PrecioTelaForro,
					"PrecioMoForro"		=>		$PrecioMoForro,
					"CodigoMo"			=>		$CodigoMo,
					"PrecioMo"			=>		$PrecioMo,
					"MetrajeMo"			=>		$MetrajeMo,
					"MetrajeForro"		=>		$MetrajeForro,
					"MetrajeMoForro"	=>		$MetrajeMoForro, 
					"CodigoStiffener"	=>		$CodigoStiffener,
					"PrecioStiffener"	=>		$PrecioStiffener,
					"TipoArticuloDetalle"=>		$TipoArticuloDetalle,
					"area"				=> 		$area,
					"CodigoBajoPlomo"	=>		$CodigoBajoPlomo,
					"PrecioPlomo"		=>		$PrecioPlomo,
					"MetrajeBajoPlomo"	=> 		$MetrajeBajoPlomo,
					"cantidadHojas" 	=>      $cantidadHojas,
					"control"       	=>      $control,
					"decorativo"    	=>      $decorativo,
					"peso"          	=>      $peso,
					"remate"        	=>      $remate,
				"resultadoSistema"  	=>      $resultadoSistema,
					"soporte"       	=>      $soporte,
					"argolla"       	=>      $argolla,
					"baston"        	=>      $baston,
					"colorBaston"   	=>      $colorBaston,
					"radioMedida"   	=>      $radioMedida,
					"radioMaterial" 	=>      $radioMaterial,
					"cantBaston"        =>      $cantBaston,
					"codigoBaston"      =>      $codigoBaston,		
					"precioBaston"      =>      $precioBaston,	
				"cantidadBastonFija"    =>      $cantidadBastonFija, //Cantidad Fija para sumar bastones desde carrito'			
					"proyecciones"  	=>      $proyecciones,
					"copete"        	=>      $copete,
					"MetrajeGaleria"	=>		$MetrajeGaleria,
					"medidaProyeccion"	=>		$medidaProyeccion,
					"MLManoObra"	 	=>		$MLManoObra,
					"TotalEscuadras"	=>		$TotalEscuadras,
					"CodigoMoForro"		=>		$CodigoMoForro,
					"CodigoCopete"		=>		$CodigoCopete,
					"CodigoEscuadras"	=>		$CodigoEscuadras,
					"PrecioEscuadras"	=>		$PrecioEscuadras,
					"AnchoTela"			=>		$AnchoTela,
					"AprovTela"			=>		$AprovTela,
					"AplicaAprov"		=>		$AplicaAprov,
					"ConsecAprov"		=>		$ConsecAprov,
					"Varilla"			=>		$Varilla,
					"CodigoMecanismo"	=> 		$CodigoMecanismo,
					"PrecioMecanismo"	=> 		$PrecioMecanismo,
					"controlMot"		=>		$controlMot,
					"precioControl"		=>		$precioControl,
					"codigoControl"		=>		$codigoControl,
					"nombreControl"		=>		$nombreControl,
					"tipoControlMot"	=>		$tipoControlMot,
					"idDrapesNombre"	=>		$idDrapesNombre,
					"CodigoArgolla"		=>      $CodigoArgolla,
					"CantidadArgolla"   =>      $CantidadArgolla,
					"PrecioArgolla"     =>      $PrecioArgolla,
					"MetrajeReal"		=>		$MetrajeReal,
					"MetrajeMOReal"		=>		$MetrajeMOReal,
					"PrecioReal"		=>		$PrecioReal,
					"PrecioMoReal"		=>		$PrecioMoReal,
					"MetrajeRealForro"	=>		$MetrajeRealForro,
					"MetrajeMORealForro"=>		$MetrajeMORealForro,
					"PrecioRealForro"	=>		$PrecioRealForro,
					"PrecioMoRealForro"	=>		$PrecioMoRealForro,
					"MetrajeBajoPlomoReal"	=>	$MetrajeBajoPlomoReal,
					"OrientacionRayaCortina"	=>	$OrientacionRayaCortina,
					"colorCinta"		=>		$colorCinta,
					"lado_motor"         => $resultadoMotor,
					"cortinairregular"   => $cortinairregular,
					"hojaizquierda"      => $hojaizquierda,
					"hojaderecha"        => $hojaderecha,
					"codoCurveado"		=>		$codoCurveado,	
					"cantidadCodos"		=>		$cantidadCodos,
					"curvoRecto"		=>		$curvoRecto,
					"codigoCurva"		=>		$codigoCurva,
					"cantidadCurva"		=>		$cantidadCurva,
					"precioCurva"		=>		$precioCurva
					);

				// Manejo de actualización de ID al editar desde carrito.
				$oldId = isset($_POST['old_id']) ? $_POST['old_id'] : '';
				$oldUniqueId = isset($_POST['old_unique_id']) ? $_POST['old_unique_id'] : '';
				$newUniqueId = md5($id);

				// Si viene old_id, significa que se está editando desde el carrito
				// En este caso, siempre removemos el producto viejo con su unique_id
				if (!empty($oldId) && $oldId !== 'nuevo') {
					$oldUniqueIdById = md5($oldId);
					$uniqueIdToRemove = '';

					// Primero intenta con el old_unique_id si existe
					if (!empty($oldUniqueId) && isset($_SESSION['carrito'][$oldUniqueId])) {
						$uniqueIdToRemove = $oldUniqueId;
					} 
					// Si no, intenta con el md5 del oldId
					elseif (isset($_SESSION['carrito'][$oldUniqueIdById])) {
						$uniqueIdToRemove = $oldUniqueIdById;
					} 
					// Si aún no encuentra, busca en el carrito actual
					else {
						$carroActual = $carrito->get_content();
						if ($carroActual) {
							foreach ($carroActual as $productoActual) {
								if (isset($productoActual['id']) && $productoActual['id'] === $oldId && isset($productoActual['unique_id'])) {
									$uniqueIdToRemove = $productoActual['unique_id'];
									break;
								}
							}
						}
					}

					// Remueve el producto viejo
					if (!empty($uniqueIdToRemove) && isset($_SESSION['carrito'][$uniqueIdToRemove])) {
						$carrito->remove_producto($uniqueIdToRemove);
					}
				}

				$carrito->add($articulo,false);

				// DEBUG: Verificar qué se guardó en la sesión
				$newUniqueId = md5($articulo['id']);
				if (isset($_SESSION['carrito'][$newUniqueId])) {
					error_log("[DEBUG SAVED] Producto guardado en sesión con Varilla: " . $_SESSION['carrito'][$newUniqueId]['Varilla']);
				}

				require_once '../fnc/ahorroMetrajeGaleriasFnc.php';
				$resultado = VerificarAhorroTela();

?>
