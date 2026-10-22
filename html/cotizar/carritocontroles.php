<?php	
	$idSituo = 92;
	$idPared = 94;
	
	if (isset($_GET['i']) && $_GET['i']<>"" ){
	include_once '../clases/Carrito.class.php';
	$carrito = new Carrito();
	$carro = $carrito->get_content();

	if($carro){ 
		foreach($carro as $producto){
			if ($producto["id"]==$_GET['i']){	
				
				echo "<input type='hidden' id='opidDrapesNombre' value='".$producto["idDrapesNombre"]."'>";
				echo "<input type='hidden' id='opID' value='".$producto["id"]."'>";
				echo "<input type='hidden' id='opCodigo' value='".$producto["codigo"]."'>";
				echo "<input type='hidden' id='opArea' value='".$producto["area"]."'>";							
				echo "<input type='hidden' id='opCantidad' value='".$producto["cantidad"]."'>";
			}
		}
	}
	}
	else{
		echo "<input type='hidden' id='opID' value='nuevo'>";
	}
	
?>

<head>
	<?php include '../../conexion/wsConsumeDrapes.php';?>
	<title>SITUO</title>

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
	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
	<!-- -->
	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	<link type="text/css" rel="stylesheet" href="../css/estilos.css">
</head>


<body class="menubar-hoverable header-fixed" onload=";">
	<form class="form" method="POST" action="index.php?opcion=terminar" id="situo" name="situo">
		<div id="content">
			<section>
				<div class="section-body contain-lg">
					<!-- BEGIN SECTION -->
					<div class="doc-section">
						<div class="col-lg-offset-1 col-md-5 col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="form-group">
										<label for="regular1">TIPO DE CONTROL </label>
									</div>
									<img class="img-responsive" src="../../assets/img/cortineros/controles.jpg">

									<div id="tiras">
										<h3>Tipo de control</h3>
									</div>
									<div class="form-group">											
										<select class="form-control" id="SelectControl" name="SelectControl" onchange="cambiarControl();">												
										   <?php												   
											   $controles=TipoControl($idSituo, $idPared);	
												foreach ($controles as $valor) {														
													echo "<option value='". $valor["codigo"] ."'>".trim($valor["nombre"])."</option>";														
												}													
										 	?>
										</select>
										<label><b>Selecciona tipo de control</b></label>
									</div>	
									
									<div id="tiras">
										<h3>Espacio</h3>
									</div>
									<div class="form-group">
										<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio" required>
									</div>

									<div id="tiras">
										<h3>Canales</h3>
									</div>

									<div class="form-group">											
										<select class="form-control" id="SelectCanales" name="SelectCanales" onchange="precioControl(this.value)">												
										</select>
									</div>

									<div id="tiras">
										<h3>Precio</h3>
									</div>
									<div id="resultado">
										<div class='form-group'> 
										<input id='Precio' class='form-control' name='Precio' value='0.0' style='text-align: right;' readonly>
										<label><b>PRECIO TOTAL:</b></label></div>										
									</div>

									<div id="tiras"><h3>Cantidad</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<input type="number" class="form-control" name="cantidadControles" id="cantidadControles" min="1" onchange="" value="1">
												<label for="dollars10">Cantidad de controles</label>
											</div>
											<span class="input-group-addon">unidad</span>
										</div>
									</div>
								</div>
								<div id="resultado4"></div>
									<div id="cargando" style="display:none; color: green;">Cargando...</div>
									<div class="msjModal" id="cargando2" style="display:none; color: red;">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>							
									<div id="BtnD"><button type="button" id="BotonEnviar" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder; margin-top:10px;" >Agregar</button></div>

									<div class="modal fade" id="msj" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="simpleModalLabel">Información</h4>
												</div>
												<div class="modal-body">
													<p class="msjModal">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>
												</div>
											</div><!-- /.modal-content -->
										</div><!-- /.modal-dialog -->
									</div><!-- /.modal -->
								</div>

								<!--end .form-group -->
							</div>
							<!--end .card-body -->
						</div>
						<!--end .card -->
					</div>					
			</section>
		</div>
		
	</form>							

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
		<script src="../js/domotica.js"></script>
		<script src="../js/funcionesGenerales.js"></script>
		<!-- END JAVASCRIPT -->
</body>