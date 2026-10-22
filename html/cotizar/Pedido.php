<?php

	header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	header("Allow: GET, POST, OPTIONS, PUT, DELETE");

		$method = $_SERVER['REQUEST_METHOD'];
	if($method == "OPTIONS") {
		die();
	}

//include_once '../clases/Carrito.class.php';
require_once '../../conexion/cnx.php'; 
require_once '../../conexion/cnx_sap_cotizador.php'; 
require_once '../fnc/terminarDescuento.php';
require_once '../fnc/terminarIva.php';
require_once '../../conexion/wsConsumeDrapes.php';
//require_once 'EnviarCorreoGmail.php';

$cotizacionArray = array();
$ArrayDetalles = array();

if (isset($_GET['id']) and $_GET['id']<>""){
	$id = $_GET['id'];

	echo "<input type='hidden' id='id' name='id' value='".$id."'>";
}


$iva = TraerIvaPorId($id);
$DescuentoProducto = TraerDescuentoPorID($id);
$TotalPorcentaje =  GenerarPorcentajePorId($id);

$descuentoGeneral = 0;
$subtotalGeneral = 0;
$subtotalGeneralSinDescuento = 0;
$ivaGeneral = 0;
$totalGeneral = 0;
$usuario = "";
$claveSAP = "";
$nombreDistribuidor = "";
$nombreCotizacion = "";
// Mayor a 3 metros cargo extra
$PrecioTotalMoCargo = 0;
$TotalMoCargo = 0;
$PrecioFinalMoCargo = 0;
// Forro
$anchoTelaForro ="";
$tipotelaForro="";
$TotalMetrajeForro ="";
$PrecioTotalTelaForro = "";
$PrecioFinalMetrajeForro = "";
$PrecioTotalMoForro = "";
$TotalMoForro = "";
$PrecioFinalMoForro = "";
$PRECIOMOFORRO="";
// Stiffener
$importeTotalStiffener = "";
$PrecioFinalStiffener = "";

$PrecioTotalBajoPlomo="";
$TotalMetrajeBajoPlomo=0;
$MetrajeBajoPlomo=0;

//$Iniciales = array[];


?>
<body class="menubar-hoverable header-fixed">
<section class="style-default-bright" style="width: 90%;margin-left: 8%;margin-top: 2%; margin-bottom: 2%;">
	<div class="col-lg-12">
		<h2>Cotización numero: <?php echo $id; ?></h2>
	</div>
	<div class="row">
		<div class="col-md-12"></div><!--end .col -->
			<div class="col-lg-12">	
					<?php
					/*$sql="SELECT  Descuento, Subtotal, Iva, Total, 
							CASE WHEN CLAVESAP = '' THEN '00127' WHEN CLAVESAP = ' ' THEN '00127' ELSE ifnull(CLAVESAP,'00127') END as CLAVESAP,   
							(SELECT usuariocotizador FROM usuario WHERE ID_USUARIO=".$_SESSION['login_user'].") as usuariocotizador, Nombre, IMPORTEUNITARIO
							FROM cotizacion  INNER JOIN usuario ON usuario.ID_USUARIO= cotizacion.ID_USUARIO_ALTA 
							WHERE id_cotizacion=".$id.";";*/

					$sql="SELECT  Descuento, Subtotal, Iva, Total, 
							CASE WHEN CLAVESAP = '' THEN '00127' WHEN CLAVESAP = ' ' THEN '00127' ELSE ifnull(CLAVESAP,'00127') END as CLAVESAP,   
							(SELECT usuariocotizador FROM usuario WHERE ID_USUARIO=".$_SESSION['login_user'].") as usuariocotizador, Nombre, IMPORTEUNITARIO, cotizacion_crm.idcrm, cotizacion_crm.oportunidad
							FROM cotizacion  INNER JOIN usuario ON usuario.ID_USUARIO= cotizacion.ID_USUARIO_ALTA 
							LEFT JOIN cotizacion_crm ON cotizacion_crm.id_cotizacion = cotizacion.id_cotizacion
							WHERE cotizacion.id_cotizacion=".$id.";";
						
							

					$result = mysqli_query($GLOBALS["db"], $sql);
					if (mysqli_num_rows($result) > 0) {

						$row = $result->fetch_row();
						$descuentoGeneral = $row[0];
						$subtotalGeneral = $row[1];
						$ivaGeneral = $row[2];
						$totalGeneral = $row[3];
						$claveSAP = $row[4];
						$usuario = $row[5];
						$nombreDistribuidor = $row[6];
						$subtotalGeneralSinDescuento = $row[7];
						$idcrm = $row[8];
						$oportunidad = $row[9];
						$nombreCotizacion = "Cotizacion Drapes Folio: " .$id;

						
					}

					/*$arrayCliente = Email($claveSAP);
					//print_r($arrayCliente);
					$NombreCliente = utf8_decode($arrayCliente[0]['NombreCliente']);
					$Email = $arrayCliente[0]['Email'];
					$Nombre = utf8_decode($arrayCliente[0]['Nombre']);*/

					?>
					<div class="card-body">
						<div class="form-group">
							<label class="control-label col-sm-4" style="font-size: 14px;opacity: 1;">
								<span><b>Distribuidor:</b> </span> <?php echo $nombreDistribuidor; ?><br>
								<span><b>Codigo SAP:</b> </span> <?php echo $claveSAP; ?><br>
								<span><b>ID CRM:</b> </span> <?php echo $idcrm; ?><br>
								<span><b>ID Oportunidad CRM:</b> </span> <?php echo $oportunidad; ?><br>
								<span><b>Ejecutivo de Venta:</b> <select class="form-control" name="Usuarios" id="Usuarios">
									<option value="N/A">Seleccione Ejecutivo de Venta</option>
									<?php get_usuarios(); ?>
								</select></span>
								<!--<span>Agente Venta: </span> <?php //echo $Nombre; ?><br>
								<span>Email: </span> <?php //echo $Email; ?><br>
								<span>Nombre SAP: </span> <?php //echo $NombreCliente; ?><br>-->
							</label>
						</div>
						<div class="form-group">
							<div class="col-sm-2"> 
								<button type="button" id="grabar" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;" onclick="Guardar()">Guardar en cotizador</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="form-group">
							<span id="idCotizacion"></span> <br>
							<span id="idUsuario"></span> 
							<span id="GuardadoCRM"></span> 
						</div>
						<div class="form-group" id="RespuestaCotizador"></div>
						
					</div>
					<div class="table-responsive">
					<?php

					$sqldetalle = "SELECT cotizacion_detalle.*,confeccion.nombre as CONFECCION, confeccion.manoobra as CONFECCIONMO 
									FROM cotizacion_detalle 
									LEFT JOIN confeccion ON confeccion.clave = cotizacion_detalle.tipoarticulodetalle 
									WHERE id_cotizacion=".$id." order by cotizacion_detalle.area asc,cotizacion_detalle.tipoarticulo desc;";


					$resultdetalle = mysqli_query($GLOBALS["db"], $sqldetalle);
					if (mysqli_num_rows($resultdetalle) > 0) {

						?>
						<table id="datatable1" class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="">Tipo Linea</th>
									<th class="">Cantidad</th>
									<th class="">Codigo</th>
									<th class="">Descripcion</th>
									<th class="">Precio Unit</th>
									<th class="">Descuento</th>
									<th class="">Importe</th>
								</tr>
							</thead>
							<tbody>
							<?php
						    while($row = mysqli_fetch_assoc($resultdetalle)) {
								
						    	if ($row["TIPOARTICULO"] == "cortina"){
						    		
						    		//Nota: se agrego el campo U_DD_TIPO_TELA en WSPruebas
						    		$arrayTela = CostoTela($row["TELA"], $row["COLOR"]);
									$anchoTela = $arrayTela[0]['ancho'];
						    		$tipotela  =  $arrayTela[0]['tipotela'];

						    		$hojas = ($row["ACOPLAMIENTO"] == "Ambos") ? 2 : 1;

						    		$tipoTelaCotizador = ($tipotela == 'TRANSLUCIDA' || $tipotela == 'SEMITRANSLUCIDA' || $tipotela == 'OPACA') ? 'DECORATIVA/FRESCURA' :  'BLACOUT';

						    		$tipoConfeccion = ($row["CONFECCION"]=='PLITZ FRANCES' || $row["CONFECCION"]=='PLITZ ESPANOL' || $row["CONFECCION"]=='PLITZ PORTUGUES') ? 'PLITZ FRANCES / ESPANOL' : $row["CONFECCION"];
					  		

						    		$sqlMedidas ="SELECT PLITZ, DESP, BASTILLA, MEDIDAPLOMO FROM confeccion_det 
													inner join confeccion on confeccion.ID_CONFECCION = confeccion_det.ID_CONFECCION
													INNER JOIN tipotela on tipotela.ID_TIPOTELA = confeccion_det.ID_TIPOTELA
													WHERE confeccion.NOMBRE ='".$row["CONFECCION"]."' and tipotela.TIPO='".$tipotela."'";

									$resultMedidas = mysqli_query($GLOBALS["db"], $sqlMedidas);
									if (mysqli_num_rows($resultMedidas) > 0) {
										while($rowMedidas = mysqli_fetch_assoc($resultMedidas)) {

											$plitz = $rowMedidas["PLITZ"];	
											$desperdicio = $rowMedidas["DESP"];	
											$bastilla = $rowMedidas["BASTILLA"];	
											$medidaplomo = $rowMedidas["MEDIDAPLOMO"];	    
										}
									}

									//No está en el otro
									// Paréntesis explícitos para PHP 8, conservando la evaluación que hacía PHP 5 (asociativa a la izquierda)
									$controlCortina = (($rowMedidas["ACOPLAMIENTO"] == "Izquierda") ? " Control Derecho" : ($rowMedidas["ACOPLAMIENTO"] == " Derecha")) ? " Control Izquierdo" : "";
						    		
						    		$PrecioUnitC = number_format(($row["PRECIO"] - GenerarCantidadFinal($TotalPorcentaje,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');
									$Nombre = strtoupper ("" . utf8_encode($row["NOMBRE"]) . " Tela: " . $row["TELA"] . " color: " . $row["COLOR"] . " med: " . $row["ANCHO"] . " x " . $row["ALTO"] . " " . $hojas."H" . $controlCortina . " A " . $row["FIJACION"]);
									$importe = number_format(($row["PRECIO"] - GenerarCantidadFinal($TotalPorcentaje,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * $row["CANTIDAD"], 2, '.', '');

									?>
									<tr>
										<td style="text-align:center;">K</td>
										<td><?php echo $row["CANTIDAD"]; ?></td>
										<td><?php echo $row["CODIGO"]; ?></td>
										<td><?php echo $Nombre; ?></td>
										<td style="text-align:right;"><?php echo $PrecioUnitC; ?></td>
										<td style="text-align:right;"><?php echo "0"; ?></td>
										<td style="text-align:right;"><?php echo $importe; ?></td>
									</tr>

									<?php

									$TotalMetraje = number_format($row["METRAJE"] * $row["CANTIDAD"], 2, '.', ''); 
									$PrecioTotalTela = number_format($TotalMetraje * $row["PRECIOTELA"], 2, '.', '');
									$PrecioTotalTelaFinal = number_format(($PrecioTotalTela - GenerarCantidadFinal($TotalPorcentaje,$PrecioTotalTela,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');

									?>
									<tr>
										<td style="text-align:center;">I</td>
										<td><?php echo $TotalMetraje; ?></td>
										<td><?php echo $row["CODIGOTELA"]; ?></td>
										<td><?php echo $row["TELA"]; ?></td>
										<td style="text-align:right;"><?php echo $row["PRECIOTELA"]; ?></td>
										<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
										<td style="text-align:right;"><?php echo $PrecioTotalTelaFinal; ?></td>
									</tr>
									<?php


									$PrecioTotalMo = number_format(($row["METRAJEMO"]* $row["CANTIDAD"]) *$row["PRECIOMO"], 2, '.', '');
									$TotalMo = number_format($row["METRAJEMO"] *  $row["CANTIDAD"], 2, '.', '');
									$PrecioFinalMo = number_format(($PrecioTotalMo - GenerarCantidadFinal($TotalPorcentaje,$PrecioTotalMo,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');

									?>
									<tr>
										<td style="text-align:center;">IO</td>
										<td><?php echo $TotalMo; ?></td>
										<td><?php echo $row["CODIGOMO"]; ?></td>
										<td><?php echo 'Mano de Obra ' . $row["CONFECCIONMO"]; ?></td>
										<td style="text-align:right;"><?php echo $row["PRECIOMO"]; ?></td>
										<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
										<td style="text-align:right;"><?php echo $PrecioFinalMo; ?></td>
									</tr>
									<?php

									// Mayor a 3 metros cargo extra
									if ($row["ALTO"]>3) {
										$PrecioTotalMoCargo = number_format(($row["METRAJEMO"]* ($row["CANTIDAD"]/2)) * $row["PRECIOMO"], 2, '.', '');	
										$TotalMoCargo =  number_format($row["METRAJEMO"] *  ($row["CANTIDAD"]/2), 2, '.', '');
										$PrecioFinalMoCargo = number_format(($PrecioTotalMoCargo - GenerarCantidadFinal($TotalPorcentaje,$PrecioTotalMoCargo,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');

										?>
										<tr>
											<td style="text-align:center;">IO</td>
											<td><?php echo $TotalMoCargo; ?></td>
											<td><?php echo $row["CODIGOMO"]; ?></td>
											<td><?php echo 'Mano de Obra ' . $row["CONFECCIONMO"]; ?></td>
											<td style="text-align:right;"><?php echo $row["PRECIOMO"]; ?></td>
											<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
											<td style="text-align:right;"><?php echo $PrecioFinalMoCargo; ?></td>
										</tr>
										<?php
									}

									// Forro
						    		if (isset($row["TELAFORRO"])) {
						    			$arrayTelaForro = CostoTela($row["TELAFORRO"], $row["COLORFORRO"]);
										$anchoTelaForro = $arrayTelaForro[0]['ancho'];
							    		$tipotelaForro  =  $arrayTelaForro[0]['tipotela'];

							    		$TotalMetrajeForro = number_format($row["METRAJEFORRO"] * $row["CANTIDAD"], 2, '.', '');
										$PrecioTotalTelaForro = number_format($TotalMetrajeForro * $row["PRECIOTELAFORRO"], 2, '.', '');
										$PrecioFinalMetrajeForro = number_format(($PrecioTotalTelaForro - GenerarCantidadFinal($TotalPorcentaje,$PrecioTotalTelaForro,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');

										?>
										<tr>
											<td style="text-align:center;">I</td>
											<td><?php echo $TotalMetrajeForro; ?></td>
											<td><?php echo $row["CODIGOTELAFORRO"]; ?></td>
											<td><?php echo $row["TELAFORRO"]; ?></td>
											<td style="text-align:right;"><?php echo $row["PRECIOTELAFORRO"]; ?></td>
											<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
											<td style="text-align:right;"><?php echo $PrecioFinalMetrajeForro; ?></td>
										</tr>
										<?php
										

										//Mano Obra Forro
										$PrecioTotalMoForro = number_format(($row["METRAJEMOFORRO"]* $row["CANTIDAD"]) * $row["PRECIOMOFORRO"], 2, '.', '');
										$TotalMoForro = number_format($row["METRAJEMOFORRO"] *  $row["CANTIDAD"], 2, '.', '');
										$PrecioFinalMoForro = number_format(($PrecioTotalMoForro - GenerarCantidadFinal($TotalPorcentaje,$PrecioTotalMoForro,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');

										?>
										<tr>
											<td style="text-align:center;">IO</td>
											<td><?php echo $TotalMoForro; ?></td>
											<td><?php echo $row["CODIGOMOFORRO"]; ?></td>
											<td><?php echo "Mano de obra Forro"; ?></td>
											<td style="text-align:right;"><?php echo $row["PRECIOMOFORRO"]; ?></td>
											<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
											<td style="text-align:right;"><?php echo $PrecioFinalMoForro; ?></td>
										</tr>
										<?php
										
						    		}


						    		// Stiffener
						    		if (isset($row["CODIGOSTIFFENER"])) { //CodigoStiffener
										$importeTotalStiffener = number_format($row["PRECIOSTIFFENER"] * $row["CANTIDAD"], 2, '.', ''); //PrecioStiffener
										$PrecioFinalStiffener = number_format(($importeTotalStiffener - GenerarCantidadFinal($TotalPorcentaje,$importeTotalStiffener,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');

										?>
										<tr>
											<td style="text-align:center;">I</td>
											<td><?php echo $row["CANTIDAD"]; ?></td>
											<td><?php echo $row["CODIGOSTIFFENER"]; ?></td>
											<td><?php echo "STIFFENER"; ?></td>
											<td style="text-align:right;"><?php echo $row["PRECIOSTIFFENER"]; ?></td>
											<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
											<td style="text-align:right;"><?php echo $PrecioFinalStiffener; ?></td>
										</tr>
										<?php
									}

									if (($row["METRAJEBAJOPLOMO"])>0){

										$MetrajeBajoPlomo =$row["METRAJEBAJOPLOMO"];

										$TotalMetrajeBajoPlomo = number_format($row["METRAJEBAJOPLOMO"] * $row["CANTIDAD"], 2, '.', ''); 
										$PrecioTotalBajoPlomo = number_format($TotalMetrajeBajoPlomo * $row["PRECIOPLOMO"], 2, '.', '');

										?>
										<tr>
											<td style="text-align:center;">IO</td>
											<td><?php echo $TotalMetrajeBajoPlomo; ?></td>
											<td><?php echo $row["CODIGOBAJOPLOMO"]; ?></td>
											<td><?php echo "Bajo Plomo Rapport"; ?></td>
											<td style="text-align:right;"><?php echo $row["PRECIOPLOMO"]; ?></td>
											<td style="text-align:right;"><?php echo $TotalPorcentaje; ?></td>
											<td style="text-align:right;"><?php echo $PrecioTotalBajoPlomo; ?></td>
										</tr>
										<?php

									}


						    		array_push($ArrayDetalles, array(
												'tipoProducto'=> 'CORTINA',
												'Codigo'=>  $row["CODIGO"],
												'TituloCortina'=> $Nombre,
												'Cantidad'=> $row["CANTIDAD"],
												'Tela'=> $row["TELA"],
												'PrecioTela'=> $row["PRECIOTELA"],
												'ImporteTela'=> $PrecioTotalTelaFinal,
												'CodigoTela'=> $row["CODIGOTELA"],
												'AnchoTela'=> $anchoTela,
												'AnchoCortina'=> $row["ANCHO"],
												'AltoCortina'=> $row["ALTO"],
												'Hojas'=> $hojas,
												'TipoTela'=> $tipoTelaCotizador,
												'DescuentoTela'=>$TotalPorcentaje,
												'Mo'=> 'Mano de Obra ' . $row["CONFECCIONMO"],
												'MoCodigo' => $row["CODIGOMO"],
												'MoPrecio'=> $row["PRECIOMO"],
												'MoImporte'=>$PrecioFinalMo,
												'MoEstilo'=>$tipoConfeccion,
												'MoCalculo'=>'ML',
												'MoBastilla'=>$bastilla,
												'MoFactPlizaj'=>$plitz,
												'MoFactDesp'=>$desperdicio,
												'MoDescuento'=>$TotalPorcentaje,
												'ForroTela'=>$row["TELAFORRO"],
												'ForroCodigo'=>$row["CODIGOTELAFORRO"],
												'ForroPrecio'=>$row["PRECIOTELAFORRO"],
												'ForroAnchoTela'=>$anchoTelaForro,
												'ForroLienzos'=>$row["METRAJEMOFORRO"],
												'ForroMetraje'=>$TotalMetrajeForro,
												'ForroDescuento'=>$TotalPorcentaje,
												'ForroPrecioFinal'=>$row["PRECIOFINALFORRO"],
												'Lienzos'=>$row["METRAJEMO"],
												'TotalMo'=>$TotalMo,
												'Metraje'=>$row["METRAJE"],
												'TotalMetraje' => $TotalMetraje,
												'Cargos'=>'0',
												'Descuento'=>$TotalPorcentaje,
												'Importe'=>$importe,
												'PrecioUnitario'=>$PrecioUnitC,
												'Descripcion'=>'',
												'PrecioPlomo' =>$row["PRECIOPLOMO"],
												'MetrajeBajoPlomo' =>$TotalMetrajeBajoPlomo,
												'CodigoBajoPlomo' =>$row["CODIGOBAJOPLOMO"],
												'DescuentoBajoPlomo' =>$row["CODIGOBAJOPLOMO"],
												'Mo3Mts' => $row["CODIGOMO"],
												'MetrajeMo3Mts' => $TotalMoCargo,
												'PrecioMo3Mts' =>$PrecioTotalMoCargo,
												'DescuentoMo3Mts' =>$TotalPorcentaje,
												'CodigoStiffener'=>$row["CODIGOSTIFFENER"],
												'PrecioStiffener'=>$row["PRECIOSTIFFENER"],
												'importeStiffener'=>$PrecioFinalStiffener,
												'CodigoMoForro'=>$row["CODIGOMOFORRO"],
												'ImporteBajoPlomo' =>$PrecioTotalBajoPlomo,
												'TotalMoForro' => $TotalMoForro,
												'PrecioFinalMoForro' => $PrecioFinalMoForro,
												'PRECIOMOFORRO' => $PRECIOMOFORRO,
												'DESCUENTOMOFORRO'=>$TotalPorcentaje,
												'COMODINCORTINERO'=>"",
												'PRECIOUNITARIOKITCORTINERO'=>0,
												'IMPORTEKITCORTINERO'=>0,
												'BASTON'=>0,
												'CODIGOBASTON'=>"",
												'PRECIOBASTONUNITARIO'=>0,
												'IMPORTEBASTON'=>0,
												'CANTIDADBASTON' => 0,
												'DESCRIPCIONBASTON' => ""

						    		));

						    		?>
									<tr>
										<td style="text-align:center;">S</td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:right;"></td>
										<td style="text-align:right;"></td>
										<td style="text-align:right;"></td>
									</tr>
									<?php
						    	}

						    	if ($row["TIPOARTICULO"] == "cortinero"){


						    		$PorcentajeDescuentoCortinero = ($row["TIPOARTICULODETALLE"]=="glystro" || $row["TIPOARTICULODETALLE"] == "gabin" || $row["TIPOARTICULODETALLE"] == "forest" || $row["TIPOARTICULODETALLE"] == "movelite" || $row["TIPOARTICULODETALLE"] == "irismo") ?  GenerarPorcentajeCortineroMotorizado($TotalPorcentaje) : $TotalPorcentaje;

						    		$hojas = ($row["CANTIDADHOJAS"]=="2HOJAS" || $row["CANTIDADHOJAS"]=="2") ? 2 :1;

						    		/*$PrecioUnitKitCortinero = number_format(($row["PRECIO"] - GenerarCantidadFinal($PorcentajeDescuentoCortinero,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');*/
						    		$control = ( $row["CONTROL"] == "Ambos") ? "" :  " Control " . $row["CONTROL"];
									$NombreKitCortinero = strtoupper ("" . utf8_encode($row["NOMBRE"])  . " COLOR: ". $row["COLOR"] . " MED " . $row["ANCHO"] . " " . $hojas . "H " . $control . " A " . $row["FIJACION"] . " ");
									$importeKitCortinero = number_format(($row["PRECIO"] - GenerarCantidadFinal($TotalPorcentaje,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * $row["CANTIDAD"], 2, '.', '');
									$PrecioUnitKitCortinero = $importeKitCortinero;

									?>
										<tr>
											<td style="text-align:center;">K</td>
											<td>1</td>
											<td>CA-CORTINERO</td>
											<td><?php echo $NombreKitCortinero; ?></td>
											<td style="text-align:right;"><?php echo $PrecioUnitKitCortinero; ?></td>
											<td style="text-align:right;"><?php echo "0"; ?></td>
											<td style="text-align:right;"><?php echo $importeKitCortinero; ?></td>
										</tr>
									<?php

									$PreciosinBastonCortinero = ($row["BASTON"]=="true") ? (($row["PRECIO"]* $row["CANTIDAD"]) -  $row["PRECIOBASTON"])/$row["CANTIDAD"] :  $row["PRECIO"] ;
									$PreciosinBastonCortinero =  ($row["SOPORTE"] == "DOBLE") ? number_format(($PreciosinBastonCortinero/2), 2, '.', '') : number_format($PreciosinBastonCortinero, 2, '.', '');
									$PreciosinBastonCortinero = ($row["CONTROLMOT"]=="true") ? $PreciosinBastonCortinero - $row["PRECIOCONTROL"] :  $PreciosinBastonCortinero ;

									$importeCortineroDoble = ($row["BASTON"]=="true") ? ($PreciosinBastonCortinero - GenerarCantidadFinal($TotalPorcentaje,$PreciosinBastonCortinero,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"]))* $row["CANTIDAD"] : ($row["PRECIO"] - GenerarCantidadFinal($TotalPorcentaje,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"]))* $row["CANTIDAD"];									
									
									$importeCortineroDoble = ($row["CONTROLMOT"]=="true") ? $importeCortineroDoble - ($row["PRECIOCONTROL"] * $row["CANTIDAD"] - (GenerarCantidadFinal($TotalPorcentaje,$row["PRECIOCONTROL"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])* $row["CANTIDAD"])) : $importeCortineroDoble;

									$importeCortineroDoble = number_format($importeCortineroDoble, 2, '.', '');

									$cantidadcortinero = ($row["SOPORTE"] == "DOBLE") ? $row["CANTIDAD"] * 2 : $row["CANTIDAD"];

									

									?>
										<tr>
											<td style="text-align:center;">I</td>
											<td><?php echo $cantidadcortinero; ?></td>
											<td><?php echo $row["CODIGO"]; ?></td>
											<td><?php echo $row["NOMBRE"]; ?></td>
											<td style="text-align:right;"><?php echo $PreciosinBastonCortinero; ?></td>
											<td style="text-align:right;"><?php echo $PorcentajeDescuentoCortinero; ?></td>
											<td style="text-align:right;"><?php echo $importeCortineroDoble; ?></td>
										</tr>
									<?php
									
									$existebaston=0;
									$precioBaston=0;
									$importeBaston=0;
									$descripcionbaston = "";
									$cantidadbaston = 0;

									if ($row["BASTON"]=="true"){
										$existebaston=1;
										$precioBaston=$row["PRECIOBASTON"]/$row["CANTIDADBASTON"];
										$importeBaston = ($precioBaston - GenerarCantidadFinal($TotalPorcentaje,$precioBaston,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"]))* $row["CANTIDADBASTON"];
										$descripcionbaston = strtoupper ("Baston Color: " . $row["COLORBASTON"] . " Material: " . $row["RADIOMATERIAL"]);
										$cantidadbaston = $row["CANTIDADBASTON"];


									?>
										<tr>
											<td style="text-align:center;">I</td>
											<td><?php echo $cantidadbaston; ?></td>
											<td><?php echo $row["CODIGOBASTON"]; ?></td>
											<td><?php echo $descripcionbaston; ?></td>
											<td style="text-align:right;"><?php echo $precioBaston; ?></td>
											<td style="text-align:right;"><?php echo $PorcentajeDescuentoCortinero; ?></td>
											<td style="text-align:right;"><?php echo $importeBaston; ?></td>
										</tr>
									<?php
										
									}

									$existecontrol=0;
									$precioControl=0;
									$importeControl=0;
									$cantidadControl=0;

									if ($row["CONTROLMOT"]=="true"){
										$existecontrol=1;
										$cantidadControl = $row["CANTIDAD"];
										$precioControl=$row["PRECIOCONTROL"];
										$importeControl = ($precioControl - GenerarCantidadFinal($TotalPorcentaje,$precioControl,1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"]))* $cantidadControl;
										
										$arrayTela = CanalesControl($row["CODIGOCONTROL"]);
										$descripcionControl = strtoupper ("CONTROL REMOTO: " . $row["TIPOCONTROL"] . " " .$arrayTela[0]['canales'] . " CANAL");

									?>
										<tr>
											<td style="text-align:center;">I</td>
											<td><?php echo $cantidadControl; ?></td>
											<td><?php echo $row["CODIGOCONTROL"]; ?></td>
											<td><?php echo $descripcionControl; ?></td>
											<td style="text-align:right;"><?php echo $precioControl; ?></td>
											<td style="text-align:right;"><?php echo $PorcentajeDescuentoCortinero; ?></td>
											<td style="text-align:right;"><?php echo $importeControl; ?></td>
										</tr>
									<?php

										$existebaston = $existecontrol;
										$precioBaston = $precioControl;
										$importeBaston = $importeControl;
										$cantidadBaston = $cantidadControl;
										$descripcionbaston = $descripcionControl;
										
									}

									$codigoCortinero = str_replace('"','\\"',$row["CODIGO"]); 
									$codigBaston = str_replace('"','\\"',$row["CODIGOBASTON"]);
									if ($row["CONTROLMOT"]=="true"){
										$codigBaston = str_replace('"','\\"',$row["CODIGOCONTROL"]);
									}

									array_push($ArrayDetalles, array(
												'tipoProducto'=> 'CORTINERO',
												'Codigo'=>  $codigoCortinero,
												'TituloCortina'=> $NombreKitCortinero,
												'Cantidad'=> $cantidadcortinero,
												'Tela'=> $row["TELA"],
												'PrecioTela'=> $row["PRECIOTELA"],
												'ImporteTela'=> 0,
												'CodigoTela'=> $row["CODIGOTELA"],
												'AnchoTela'=> 0,
												'AnchoCortina'=> $row["ANCHO"],
												'AltoCortina'=> 0,
												'Hojas'=> $hojas,
												'TipoTela'=> "",
												'DescuentoTela'=>0,
												'Mo'=> "",
												'MoCodigo' => $row["CODIGOMO"],
												'MoPrecio'=> $row["PRECIOMO"],
												'MoImporte'=>0,
												'MoEstilo'=>"",
												'MoCalculo'=>"",
												'MoBastilla'=>"",
												'MoFactPlizaj'=>"",
												'MoFactDesp'=>"",
												'MoDescuento'=>"",
												'ForroTela'=>$row["TELAFORRO"],
												'ForroCodigo'=>$row["CODIGOTELAFORRO"],
												'ForroPrecio'=>$row["PRECIOTELAFORRO"],
												'ForroAnchoTela'=>0,
												'ForroLienzos'=>$row["METRAJEMOFORRO"],
												'ForroMetraje'=>$row["METRAJEFORRO"],
												'ForroDescuento'=>0,
												'ForroPrecioFinal'=>$row["PRECIOFINALFORRO"],
												'Lienzos'=>$row["METRAJEMO"],
												'TotalMo'=>0,
												'Metraje'=>$row["METRAJE"],
												'TotalMetraje' => 0,
												'Cargos'=>'0',
												'Descuento'=>$PorcentajeDescuentoCortinero,
												'Importe'=>$importeCortineroDoble,
												'PrecioUnitario'=>$PreciosinBastonCortinero,
												'Descripcion'=>$row["NOMBRE"],
												'PrecioPlomo' =>"",
												'MetrajeBajoPlomo' =>0,
												'CodigoBajoPlomo' =>"",
												'DescuentoBajoPlomo' =>"",
												'Mo3Mts' => "",
												'MetrajeMo3Mts' => "",
												'PrecioMo3Mts' =>"",
												'DescuentoMo3Mts' =>"",
												'CodigoStiffener'=>"",
												'PrecioStiffener'=>"",
												'importeStiffener'=>"",
												'CodigoMoForro'=>"",
												'ImporteBajoPlomo' =>"",
												'TotalMoForro' => "",
												'PrecioFinalMoForro' => "",
												'PRECIOMOFORRO' => "",
												'DESCUENTOMOFORRO'=>"",
												'COMODINCORTINERO'=>"CA-CORTINERO",
												'PRECIOUNITARIOKITCORTINERO'=>$PrecioUnitKitCortinero,
												'IMPORTEKITCORTINERO'=>$importeKitCortinero,
												'BASTON'=>$existebaston,
												'CODIGOBASTON'=>$codigBaston,
												'PRECIOBASTONUNITARIO'=>$precioBaston,
												'IMPORTEBASTON'=>$importeBaston,
												'CANTIDADBASTON' => $cantidadbaston,
												'DESCRIPCIONBASTON' => $descripcionbaston
						    				));

						    		?>
									<tr>
										<td style="text-align:center;">S</td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:right;"></td>
										<td style="text-align:right;"></td>
										<td style="text-align:right;"></td>
									</tr>
									<?php

									
						    	}

								if ($row["TIPOARTICULO"] == "SITUO" || $row["TIPOARTICULO"] == "CONTROL PARED" || $row["TIPOARTICULO"] == "DOMOTICA"){


						    		$PorcentajeDescuentoCortinero = GenerarPorcentajeCortineroMotorizado($TotalPorcentaje);
						    							    		
						    		/*$PrecioUnitKitCortinero = number_format(($row["PRECIO"] - GenerarCantidadFinal($PorcentajeDescuentoCortinero,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * 1, 2, '.', '');*/
									//$NombreKitCortinero = strtoupper ("" . utf8_encode($row["NOMBRE"]));
									$importeKitCortinero = number_format(($row["PRECIO"] - GenerarCantidadFinal($TotalPorcentaje,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"])) * $row["CANTIDAD"], 2, '.', '');
									$PrecioUnitKitCortinero = $importeKitCortinero;
									
									$arrayTela = CanalesControl($row["CODIGO"]);									
									if($row["TIPOARTICULO"] == "DOMOTICA"){
										$NombreKitCortinero = strtoupper ($row["NOMBRE"]);
									}
									else{
										if($arrayTela[0]['canales'] > 1){
											$NombreKitCortinero = strtoupper ("CONTROL REMOTO: " . $row["TIPOARTICULO"] . " " .$arrayTela[0]['canales'] . " CANALES");
										}else{
											$NombreKitCortinero = strtoupper ("CONTROL REMOTO: " . $row["TIPOARTICULO"] . " " .$arrayTela[0]['canales'] . " CANAL");
										}
										
									}
									

									?>
										<tr>
											<td style="text-align:center;">K</td>
											<td>1</td>
											<td>AR-COMODIN</td>
											<td><?php echo $NombreKitCortinero; ?></td>
											<td style="text-align:right;"><?php echo $PrecioUnitKitCortinero; ?></td>
											<td style="text-align:right;"><?php echo "0"; ?></td>
											<td style="text-align:right;"><?php echo $importeKitCortinero; ?></td>
										</tr>
									<?php

									$PreciosinBastonCortinero =  $row["PRECIO"] ;

									$PreciosinBastonCortinero = number_format($PreciosinBastonCortinero, 2, '.', '');

									$importeCortinero = ($row["PRECIO"] - GenerarCantidadFinal($TotalPorcentaje,$row["PRECIO"],1,$row["TIPOARTICULO"],$row["TIPOARTICULODETALLE"]))* $row["CANTIDAD"];

									$importeCortinero = number_format($importeCortinero, 2, '.', '');

									?>
										<tr>
											<td style="text-align:center;">I</td>
											<td><?php echo $row["CANTIDAD"]; ?></td>
											<td><?php echo $row["CODIGO"]; ?></td>
											<td><?php echo $NombreKitCortinero; ?></td>
											<td style="text-align:right;"><?php echo $PreciosinBastonCortinero; ?></td>
											<td style="text-align:right;"><?php echo $PorcentajeDescuentoCortinero; ?></td>
											<td style="text-align:right;"><?php echo $importeCortinero; ?></td>
										</tr>
									<?php
									
								
									$codigoCortinero = str_replace('"','\\"',$row["CODIGO"]); 

									array_push($ArrayDetalles, array(
												'tipoProducto'=> 'CORTINERO',
												'Codigo'=>  $codigoCortinero,
												'TituloCortina'=> $NombreKitCortinero,
												'Cantidad'=> $row["CANTIDAD"],
												'Tela'=> $row["TELA"],
												'PrecioTela'=> $row["PRECIOTELA"],
												'ImporteTela'=> 0,
												'CodigoTela'=> $row["CODIGOTELA"],
												'AnchoTela'=> 0,
												'AnchoCortina'=> $row["ANCHO"],
												'AltoCortina'=> 0,
												'Hojas'=> $hojas,
												'TipoTela'=> "",
												'DescuentoTela'=>0,
												'Mo'=> "",
												'MoCodigo' => $row["CODIGOMO"],
												'MoPrecio'=> $row["PRECIOMO"],
												'MoImporte'=>0,
												'MoEstilo'=>"",
												'MoCalculo'=>"",
												'MoBastilla'=>"",
												'MoFactPlizaj'=>"",
												'MoFactDesp'=>"",
												'MoDescuento'=>"",
												'ForroTela'=>$row["TELAFORRO"],
												'ForroCodigo'=>$row["CODIGOTELAFORRO"],
												'ForroPrecio'=>$row["PRECIOTELAFORRO"],
												'ForroAnchoTela'=>0,
												'ForroLienzos'=>$row["METRAJEMOFORRO"],
												'ForroMetraje'=>$row["METRAJEFORRO"],
												'ForroDescuento'=>0,
												'ForroPrecioFinal'=>$row["PRECIOFINALFORRO"],
												'Lienzos'=>$row["METRAJEMO"],
												'TotalMo'=>0,
												'Metraje'=>$row["METRAJE"],
												'TotalMetraje' => 0,
												'Cargos'=>'0',
												'Descuento'=>$PorcentajeDescuentoCortinero,
												'Importe'=>$importeCortinero,
												'PrecioUnitario'=>$PreciosinBastonCortinero,
												'Descripcion'=>$row["NOMBRE"],
												'PrecioPlomo' =>"",
												'MetrajeBajoPlomo' =>0,
												'CodigoBajoPlomo' =>"",
												'DescuentoBajoPlomo' =>"",
												'Mo3Mts' => "",
												'MetrajeMo3Mts' => "",
												'PrecioMo3Mts' =>"",
												'DescuentoMo3Mts' =>"",
												'CodigoStiffener'=>"",
												'PrecioStiffener'=>"",
												'importeStiffener'=>"",
												'CodigoMoForro'=>"",
												'ImporteBajoPlomo' =>"",
												'TotalMoForro' => "",
												'PrecioFinalMoForro' => "",
												'PRECIOMOFORRO' => "",
												'DESCUENTOMOFORRO'=>"",
												'COMODINCORTINERO'=>"AR-COMODIN",
												'PRECIOUNITARIOKITCORTINERO'=>$PrecioUnitKitCortinero,
												'IMPORTEKITCORTINERO'=>$importeKitCortinero,
												'BASTON'=>0,
												'CODIGOBASTON'=>"",
												'PRECIOBASTONUNITARIO'=>0,
												'IMPORTEBASTON'=>0,
												'CANTIDADBASTON' => 0,
												'DESCRIPCIONBASTON' => ""
						    				));

						    		?>
									<tr>
										<td style="text-align:center;">S</td>
										<td></td>
										<td></td>
										<td></td>
										<td style="text-align:right;"></td>
										<td style="text-align:right;"></td>
										<td style="text-align:right;"></td>
									</tr>
									<?php

									
						    	}
						    }


						    //$productos[] = $ArrayDetalles;
						    array_push($cotizacionArray, array(
								'Nombre'=> $nombreCotizacion,
								'Origen'=> 2,
								'CodigoCliente'=> $claveSAP,
								'ImporteGral'=> $subtotalGeneral,
								'DescuentoGral'=> 0,
								'SubtotalGral'=> $subtotalGeneral,
								'IVAGral'=> $ivaGeneral,
								'TotalGral'=> $totalGeneral,
								'username'=> $usuario,
								'idCRM'=> $idcrm,
								'IdOfertaVentaSAP'=> $oportunidad,
								'folioDrapes'=> $id,
								'DetalleCotizacion'=>$ArrayDetalles
							));

							//echo "<script>var ArrayCotizacion = " . json_encode($cotizacionArray) . "; </script>";


						     ?>
						    <tr class="cart_total_delivery">
						    	<td colspan="6" class="text-right" style="padding: 5px 5px;"><b>Subtotal: </b></td>
						    	<td style="text-align:right;padding: 5px 5px;"><?php echo $subtotalGeneralSinDescuento; ?></td>
						    </tr>
						    <tr class="cart_total_delivery">
						    	<td colspan="6" class="text-right" style="padding: 5px 5px;"><b>Descuento: </b></td>
						    	<td style="text-align:right;padding: 5px 5px;"><?php echo $descuentoGeneral; ?></td>
						    </tr>
						    <tr class="cart_total_delivery">
						    	<td colspan="6" class="text-right" style="padding: 5px 5px;"><b>Iva: </b></td>
						    	<td style="text-align:right;padding: 5px 5px;"><?php echo $ivaGeneral; ?></td>
						    </tr> 
						    <tr class="cart_total_delivery">
						    	<td colspan="6" class="text-right" style="padding: 5px 5px;"><b>Total: </b></td>
						    	<td style="text-align:right;padding: 5px 5px;"><?php echo $totalGeneral; ?></td>
						    </tr>


						</tbody>
					</table> <?php
				} else echo "<P><B>FAVOR DE VERIFICAR EL NUMERO DE COTIZACION</B><P>"; ?>
			</div>
		</div>
	</div>
</section>
</body>

<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>

<script language="javascript">

	$(document).ready(function(){

		RevisarEstadoPedido();
		ObtenerIniciales();

	});
	//RespuestaCotizador
	
	function Guardar() {

		var Nombre= "<?php echo $nombreCotizacion; ?>";
		var Origen = 2;
		var CodigoCliente = "<?php echo $claveSAP; ?>";
		var ImporteGral= "<?php echo $subtotalGeneral; ?>";
		var DescuentoGral= 0;
		var SubtotalGral= "<?php echo $subtotalGeneral;?>";
		var IVAGral= "<?php echo $ivaGeneral; ?>";
		var TotalGral= "<?php echo $totalGeneral; ?>";
		var username=  $("#Usuarios option:selected").html();
		var idCRM= "<?php echo $idcrm; ?>";
		var IdOfertaVentaSAP= "<?php echo $oportunidad; ?>";
		var folioDrapes= "<?php echo $id; ?>";
		var DetalleCotizacion= <?php echo json_encode($ArrayDetalles); ?>;


		//var ArrayCotizacion = 

		let ArrayCotizacion = [
			{
			"Nombre": Nombre,
			"Origen": Origen,
			"CodigoCliente":CodigoCliente,
			"ImporteGral": ImporteGral,
			"DescuentoGral": DescuentoGral,
			"SubtotalGral": SubtotalGral,
			"IVAGral": IVAGral,
			"TotalGral":TotalGral,
			"username": username,
			"idCRM": idCRM,
			"IdOfertaVentaSAP": IdOfertaVentaSAP,
			"folioDrapes": folioDrapes,
			"DetalleCotizacion": DetalleCotizacion
			}
		];

		console.log((JSON.stringify(ArrayCotizacion[0])));
		if(username == "Seleccione Ejecutivo de Venta"){
			alert("Seleccione Ejecutivo de Venta");
		}
		else{
			$.post("http://189.199.126.254:8086/DuesIntegradorCRM/Cotizacion/AddDrapes", (JSON.stringify(ArrayCotizacion[0])), 
				function (data) {

					var content = data;
					
					id = $("#id").val(); 
					
					if (content.hasOwnProperty('Id_CotGral')) {
						document.getElementById('idCotizacion').innerHTML = 'Cotizacion: ' + content.Id_CotGral;
						document.getElementById('idUsuario').innerHTML = 'Usario: ' + content.idUsuario;
						document.getElementById('GuardadoCRM').innerHTML = 'Respuesta CRM: ' + content.respuesta;
						document.getElementById("grabar").disabled = true;
						var emailDistribuidor = "";//"<?php //echo $Email; ?>" ;
						var nombreDistribuidor = "<?php echo $nombreDistribuidor; ?>" ;

						$.post("../fnc/AutorizarPedido.php",{id : id, IdCotizador:content.Id_CotGral, IdUsuarioCotizador :content.idUsuario, emailDistribuidor:emailDistribuidor,nombreDistribuidor:nombreDistribuidor, username:username  }, function(data2)
						{
							alert(data2);
						});
						var datos_endiados = JSON.stringify(ArrayCotizacion[0]);
						var respuesta_1 = JSON.stringify(data);
						$.post("../fnc/logPedido.php",{folio:folioDrapes,datos:datos_endiados,respuesta:respuesta_1}, function(data2){
							console.log("Log_Success")
						});
					} else{
						alert(content.error);
						var datos_endiados = JSON.stringify(ArrayCotizacion[0]);
						var respuesta_1 = content.error;
						$.post("../fnc/logPedido.php",{folio:folioDrapes,datos:datos_endiados,respuesta:respuesta_1}, function(data2){
							console.log("Log_Success")
						});
					}
				})
				.fail(function() {
					alert( "No se pudo grabar la cotizacion" );
			});
		}
	}


	function RevisarEstadoPedido() {

		id = $("#id").val();

		//alert(id);
		$.post("../fnc/ConsultarEstadoCotizacion.php",{id : id}, function(data2)
		{
			$("#RespuestaCotizador").html(data2);
			$("#RespuestaCotizador").show();

			idCotizador = $("#IdCotizador").val();
			idUsuario = $("#IdUsuarioCotizador").val();

			if (idCotizador == "undefined" || idCotizador == null ||  idCotizador == "" ||  idCotizador == 0)
			{

			}else{

				document.getElementById('idCotizacion').innerHTML = 'Cotizacion: ' + idCotizador;
    			document.getElementById('idUsuario').innerHTML = 'Uusario: ' + idUsuario;
    			document.getElementById("grabar").disabled = true;
			}

		}); 

	}



	function ObtenerIniciales() {

		$.post("http://189.199.126.254:8086/DuesIntegradorCRM/Cotizacion/GetUsuarios",{}, function(data2)
		//$.post("http://192.168.1.20/DuesIntegradorCRM/Cotizacion/GetUsuarios",{}, function(data2)
		{

			var $dropdown = $("#Usuarios");
			$dropdown.append($("<option />").val("N/A").text("Seleccione Ejecutivo de Venta"));
			$.each(data2, function() {
			    $dropdown.append($("<option />").val(this.Siglas).text(this.Siglas));
			});

		}); 

	}

</script>

