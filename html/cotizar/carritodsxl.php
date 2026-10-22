<html>
<?php
if (isset($_GET['ancho']) && $_GET['ancho'] <> "") {
	$anch = $_GET['ancho'];
	$area = $_GET['area'];
	$acoplamiento = $_GET['acoplamiento'];
	$cantidad = $_GET['cantidad'];
	$sistema = $_GET['sistema'];
	$fijacion = $_GET['fijacion'];

	echo "<input type='hidden' id='opCortina' value='SI'>";

	echo "<input type='hidden' id='opAncho' value='" . $anch . "'>";
	echo "<input type='hidden' id='opArea' value='" . $area . "'>";
	echo "<input type='hidden' id='opAcoplamiento' value='" . $acoplamiento . "'>";
	echo "<input type='hidden' id='opCantidad' value='" . $cantidad . "'>";
	echo "<input type='hidden' id='opSistema' value='" . $sistema . "'>";
	echo "<input type='hidden' id='opFijacion' value='" . $fijacion . "'>";
}

if (isset($_GET['i']) && $_GET['i'] <> "") {
	include_once '../clases/Carrito.class.php';
	$carrito = new Carrito();
	$carro = $carrito->get_content();

	if ($carro) {
		foreach ($carro as $producto) {
			if ($producto["id"] == $_GET['i']) {
				echo "<input type='hidden' id='opID' value='" . $producto["id"] . "'>";
				echo "<input type='hidden' id='opColor' value='" . $producto["color"] . "'>";
				echo "<input type='hidden' id='opAncho' value='" . $producto["ancho"] . "'>";
				echo "<input type='hidden' id='opArea' value='" . $producto["area"] . "'>";

				echo "<input type='hidden' id='opHojas' value=" . $producto["cantidadHojas"] . ">";
				echo "<input type='hidden' id='opControl' value=" . $producto["control"] . ">";

				echo "<input type='hidden' id='opTiporemate' value='" . $producto["remate"] . "'>";
				echo "<input type='hidden' id='opSoporte' value='" . $producto["soporte"] . "'>";
				echo "<input type='hidden' id='opSistema' value='" . $producto["resultadoSistema"] . "'>";

				echo "<input type='hidden' id='opBastonchk' value='" . $producto["baston"] . "'>";
				echo "<input type='hidden' id='opCantidad' value='" . $producto["cantidad"] . "'>";
				echo "<input type='hidden' id='opBastonmedida' value='" . $producto["radioMedida"] . "'>";

				echo "<input type='hidden' id='opFijacion' value='" . $producto["fijacion"] . "'>";
			}
		}
	}
} else {
	echo "<input type='hidden' id='opID' value='nuevo'>";
}
?>

<head>
	<?php include '../../conexion/wsConsumeDrapes.php'; ?>

	<title>MTS</title>

	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<meta name="description" content="Short explanation about this website">
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css' />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap.css?1422792965" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/animacion/slider.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/back/back.css" />

	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466319" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
	<!-- <style>#slider { margin: 10px; }	</style>-->
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/typeahead/typeahead.css?1424887863" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/select2/select2.css?1424887856" />

	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
	<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>


	<!-- -->
	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
</head>


<body class="menubar-hoverable header-fixed" onload="obtenerValores();">
	<form class="form" method="POST" action="index.php?opcion=terminar" id="dsxl" name="dsxl">

		<div id="content">

			<section>
				<div class="section-body contain-lg">
					<!-- BEGIN SECTION -->
					<div class="doc-section">
						<div class="col-lg-offset-1 col-md-5 col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="form-group">
										<label for="regular1">Tipo de cortinero elegido: "DSXL" </label>
									</div>
									<img class="img-responsive" src="../../assets/img/cortineros/DSXL.jpg">
									<div id="tiras">
										<h3>Espacio</h3>
									</div>
									<div class="form-group">
										<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio" required>
									</div>
									<div id="tiras">
										<h3>Precio</h3>
									</div>
									<div id="resultado">
										<div class='form-group'> <input id='Precio' class='form-control' name='Precio' value='<?php echo $precioP; ?>' style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>
									</div>
									<div id="tiras">
										<h3>Ancho</h3>
									</div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<?php if ($anch != 0) {
													echo "<input type='number' readonly='readonly' class='form-control' id='anchocortinero' step ='0.01' value='" . $anch . "'>";
													//echo "<input type='number' class='form-control' id='an' step ='0.1' value='".$anch."'>";													
												} else {
													echo "<input type='number' onkeyup='obtenerValores();' class='form-control' id='anchocortinero' min='0.8' max='5' step ='0.01' value='0.8'>";
												}
												?>
												<label for="anchocortinero">Ancho del cortinero</label>
											</div>
											<span class="input-group-addon">mts</span>
										</div>
									</div>
									<div id="tiras">
										<h3>Cantidad de hojas</h3>
									</div>
									<div class="form-group">
										<div class="input-group">
											<TABLE>
												<tr>
													<td>
														<input type="radio" name="hoja" value="1IZQUIERDA" id="1IZQUIERDA" onchange="obtenerValores();" checked><span>1 Izquierda </span>
														<img src="../../assets/img/opciones/izquierda.png" width="50px" height="50px" />
													</td>
													<td>
														<input type="radio" name="hoja" value="1DERECHA" id="1DERECHA" onchange="obtenerValores();"><span> 1 Derecha </span>
														<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px" />
													</td>
													<td>
														<input type="radio" name="hoja" value="2HOJAS" id="2HOJAS" onchange="obtenerValores();"><span>2 Hojas </span>
														<img src="../../assets/img/opciones/Ambas.png" width="50px" height="50px" />
													</td>
												</tr>
											</TABLE>
										</div>
									</div>
									<div id="tiras">
										<h3>Control</h3>
									</div>
									<div class="form-group">
										<div class="input-group">
											<TABLE>
												<tr>
													<td>
														<input type="radio" name="control" value="Izquierda" id="Izquierda" onchange="obtenerValores();" checked><span>&nbsp;Izquierdo &nbsp;</span>
														<img src="../../assets/img/opciones/izquierda.png" width="50px" height="50px" />
													</td>
													<td>
														<input type="radio" name="control" value="Derecha" id="Derecha" onchange="obtenerValores();" checked><span>&nbsp;Derecho&nbsp;</span>
														<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px" />
													</td>
													<td>
														<input type="radio" name="control" value="Ambos" id="Ambos" onchange="obtenerValores();" checked><span>&nbsp;Ambos&nbsp;</span>
														<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px" />
													</td>
												</tr>
											</TABLE>
										</div>
									</div>
									<div id="tiras">
										<h3>Instalación</h3>
									</div>
									<div class="form-group">
										<div class="input-group">
											<TABLE>
												<tr>
													<!--<td>
														<input type="radio" name="instalacion" id="Muro" value="MURO" onchange="obtenerValores();" checked><span>Muro </span>
														<img src="../../assets/img/opciones/muro.png"  width="50px" height="50px"/>
													</td>-->
													<td>
														<input type="radio" name="instalacion" id="Techo" value="TECHO" onchange="obtenerValores();"><span>Techo </span>
														<img src="../../assets/img/opciones/techo.png" width="50px" height="50px" />
													</td>
												</tr>
											</TABLE>
										</div>
									</div>
								</div>
								<!--end .form-group -->
							</div>
							<!--end .card-body -->
						</div>
						<!--end .card -->

						<div class="col-lg-offset-1 col-md-5 col-sm-6">
							<div class="card">
								<div class="card-body">
									<div id="tiras">
										<h3>Soporte</h3>
									</div>
									<TABLE>
										<tr>
											<td>
												<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" checked><span>Sencillo</span>
												<img src="../../assets/img/acce/DSXLSoporteMuro.jpg" id="imagenSencillo" width="80px" height="50px" />&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
									</TABLE>

									<div id="tiras">
										<h3>Tipo de sistema</h3>
									</div>
									<TABLE>
										<tr>
											<td>
												<input type="radio" name="sistema" id="ESTANDAR" value="ESTANDAR" onchange="obtenerValores();" checked><span>Estándar</span>
												<img src="../../assets/img/cortineros/standard.png" width="100px" height="50px" />&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" name="sistema" id="ONDULADO" value="ONDULADO" onchange="obtenerValores();"><span>Ondulado</span>
												<img src="../../assets/img/cortineros/ONDULADO.jpg" width="100px" height="50px" />&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
										</tr>
									</TABLE>


									<!--	<div id="tiras"><h3>Soporte a techo</h3></div>
											<TABLE>
												<tr>
													<td>
												   <input type="radio" name="soporte" id="fijacion3" value="SENCILLO"><span>Sencillo</span>
													<img src="../../assets/img/acce/sopotecho.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>																																							
												</tr>	
											 </TABLE>-->

									<TABLE>
										<div id="tiras">
											<h3>Bastón de Fibra de Vidrio</h3>
										</div> <br>
										<div class="checkbox checkbox-styled tile-text">
											<label>
												<input type="checkbox" id="chkbaston" onchange="obtenerValores();" checked>
												<span>Bastón</span>
											</label>
										</div>

										<TABLE>
											<tr>
												<td>
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
												<td>
													<img src="../../assets/img/acce/bastonb.jpg" width="10px" height="130px" />&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
											</tr>
										</TABLE>

										<label><b>
												<h3>Medida del bastón</h3>
											</b></label> <br>

										<TABLE>

											<tr>
												<td>
													<input type="radio" name="medida" id="bastonUnoP1" onchange="obtenerValores();" value=".9" checked><span>90cm</span>&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
												<td>
													<input type="radio" name="medida" id="bastonUnoP2" onchange="obtenerValores();" value="1.22"><span>1.22m</span>&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
												<td>
													<input type="radio" name="medida" id="bastonUnoP3" onchange="obtenerValores();" value="1.5"><span>1.5m</span>&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
												<td>
													<input type="radio" name="medida" id="bastonUnoP4" onchange="obtenerValores();" value="1.83"><span>1.83m</span>&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
											</tr>
										</TABLE>
										<div id="tiras">
											<h3>Cantidad</h3>
										</div>
										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
												<div class="input-group-content">
													<input type="number" class="form-control" id="cantidadcortinero" min="1" onchange="obtenerValores();" value="1">
													<label for="dollars10">Cantidad de cortineros</label>
												</div>
												<span class="input-group-addon">unidad</span>
											</div>
										</div>

										<div id="resultado4"></div>										
										<?php
										echo "<div id='cargando' style='display:none; color: green;'>Cargando...</div>
									    	<div class='msjModal' id='cargando2' style='display:none; color: red;'>Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>";

										echo "<div class='modal fade' id='msj' tabindex='-1' role='dialog' aria-labelledby='simpleModalLabel' aria-hidden='true'>
												<div class='modal-dialog'>
													<div class='modal-content'>
														<div class='modal-header'>
															<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
															<h4 class='modal-title' id='simpleModalLabel'>Información</h4>
														</div>
														<div class='modal-body'>
															<p class='msjModal'>Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</p>
														</div>
														<div class='modal-footer'>
															<button type='button' class='btn btn-default' value='NEL' data-dismiss='modal'>Cerrar</button>													
														</div>
													</div><!-- /.modal-content -->
												</div><!-- /.modal-dialog -->
											</div><!-- /.modal -->";
										echo "<div id='BtnD'><button type='button' id='BotonEnviar' class='btn btn-block ink-reaction btn-primary-light' style='font-weight: bolder';>Guardar cambios</button></div>";
										?>
								</div>
							</div>
							<!--end .form-group -->
						</div>
						<!--end .card-body -->
					</div>
					<!--end .card -->
				</div>
		</div>
		</div>
		</section>
		</div>


		<!-- BEGIN JAVASCRIPT -->
		<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		<script src="../js/carritodsxl.js?v=1"></script>		
		<!-- END JAVASCRIPT -->

	</form>
</body>

</html>