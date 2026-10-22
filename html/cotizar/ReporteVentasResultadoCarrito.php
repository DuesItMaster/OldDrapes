<?php
	require_once '../../conexion/cnx.php'; 
	include_once '../clases/Carrito.class.php';
	session_start();

	$carrito = new Carrito();

	if (isset($_GET['id']) and $_GET['id']<>""){
		$id = $_GET['id'];
	}

	$carrito->destroy();


	$sql = "select CODIGO, CANTIDAD , NOMBRE, PRECIO,TIPOARTICULO,RUTA,ANCHO,ALTO,TIPOCORTINA,FIJACION,
					ACOPLAMIENTO,TELA,COLOR,GANCHO,BAJOPLOMO,STIFFENER,NEVERLIGHT,TELAFORRO,
					PRECIOTELA,CODIGOTELA,METRAJE,COLORFORRO,PRECIOFINALFORRO,CODIGOTELAFORRO,
					CODIGOMOFORRO,PRECIOTELAFORRO,PRECIOMOFORRO,CODIGOMO,PRECIOMO,METRAJEFORRO,CODIGOSTIFFENER,
					PRECIOSTIFFENER,TipoArticuloDetalle,area,CANTIDADHOJAS,CONTROL,DECORATIVO,PESO,REMATE,RESULTADOSISTEMA,SOPORTE,METRAJEMOFORRO,
					ARGOLLA,BASTON,COLORBASTON,RADIOMATERIAL,RADIOMEDIDA,PROYECCIONES,COPETE,METRAJEGALERIA,CODIGOMECANISMO,PRECIOMECANISMO,ID,ID_UNIQUE,METRAJEMO,
					CANTIDADBASTON,CODIGOBASTON,PRECIOBASTON, CODIGOBAJOPLOMO, PRECIOPLOMO, METRAJEBAJOPLOMO,
					CURVORECTO, CODIGOCURVA, CANTIDADCURVA, PRECIOCURVA
			from cotizacion_detalle where ID_COTIZACION = ".$id." ;"; //and id_usuario_alta=".$_session['']."

	$result = mysqli_query($GLOBALS['db'], $sql);

			if (mysqli_num_rows($result) > 0) {

				while($row = mysqli_fetch_assoc($result)) {

						  $articulo = array(
											"id"				=>		$row["ID"],
											"cantidad"			=>		$row["CANTIDAD"],
											"precio"			=>		$row["PRECIO"],
											"nombre"			=>		utf8_encode($row["NOMBRE"]),
											"tipoarticulo"		=>		$row["TIPOARTICULO"],
											"ruta"				=>		$row["RUTA"],
											"ancho"				=>		$row["ANCHO"],
											"codigo"			=>		$row["CODIGO"],
											"alto"				=>		$row["ALTO"],
											"tipocortina"		=>		$row["TIPOCORTINA"],
											"fijacion"			=>		$row["FIJACION"],
											"acoplamiento"		=>		$row["ACOPLAMIENTO"],
											"tela"				=>		$row["TELA"],
											"color"				=>		$row["COLOR"],
											"gancho"			=>		$row["GANCHO"],
											"bajoplomo"			=>		$row["BAJOPLOMO"],
											"stiffener"			=>		$row["STIFFENER"],
											"neverlight"		=>		$row["NEVERLIGHT"],
											"telaForro"			=>      $row["TELAFORRO"],
											"PrecioTela"		=>		$row["PRECIOTELA"],
											"CodigoTela"		=>		$row["CODIGOTELA"],
											"Metraje"			=>		$row["METRAJE"],
											"ColorForro"		=>		$row["COLORFORRO"],
											"PrecioFinalForro"	=>		$row["PRECIOFINALFORRO"],
											"CodigoTelaForro"	=>		$row["CODIGOTELAFORRO"],
											"CodigoMoForro"		=>		$row["CODIGOMOFORRO"],
											"PrecioTelaForro"	=>		$row["PRECIOTELAFORRO"],
											"PrecioMoForro"		=>		$row["PRECIOMOFORRO"],
											"CodigoMo"			=>		$row["CODIGOMO"],
											"PrecioMo"			=>		$row["PRECIOMO"],
											"MetrajeMo"			=>		$row["METRAJEMO"],
											"MetrajeForro"		=>		$row["METRAJEFORRO"],
											"MetrajeMoForro"	=>		$row["METRAJEMOFORRO"],
											"CodigoStiffener"	=>		$row["CODIGOSTIFFENER"],
											"PrecioStiffener"	=>		$row["PRECIOSTIFFENER"],
											"TipoArticuloDetalle"=>		$row["TipoArticuloDetalle"],
											"area"              =>		$row["area"],

											"CodigoBajoPlomo"	=>		$row["CODIGOBAJOPLOMO"],
											"PrecioPlomo"		=>		$row["PRECIOPLOMO"],
											"MetrajeBajoPlomo"  =>		$row["METRAJEBAJOPLOMO"],
											
											"cantidadHojas" 	=>      $row["CANTIDADHOJAS"],
											"control"       	=>      $row["CONTROL"],
											"decorativo"    	=>      $row["DECORATIVO"],
											"peso"          	=>      $row["PESO"],
											"remate"        	=>      $row["REMATE"],
										"resultadoSistema"  	=>      $row["RESULTADOSISTEMA"],
											"soporte"       	=>      $row["SOPORTE"],
											"argolla"       	=>      $row["ARGOLLA"],
											"baston"        	=>      $row["BASTON"],
											"colorBaston"   	=>      $row["COLORBASTON"],
											"radioMedida"   	=>      $row["RADIOMEDIDA"],
											"radioMaterial" 	=>      $row["RADIOMATERIAL"],
											"cantBaston"        =>      $row["CANTIDADBASTON"],
											"codigoBaston"      =>      $row["CODIGOBASTON"],
											"precioBaston"      =>      $row["PRECIOBASTON"],
											
											"proyecciones"  	=>      $row["PROYECCIONES"],
											"copete"        	=>      $row["COPETE"],
											"MetrajeGaleria"	=>		$row["METRAJEGALERIA"],

											"CodigoMecanismo"	=> 		$row["CODIGOMECANISMO"],
											"PrecioMecanismo"	=> 		$row["PRECIOMECANISMO"],

											// Curva (Glydea / Curvo KS)
											"curvoRecto"		=>		$row["CURVORECTO"],
											"codigoCurva"		=>		$row["CODIGOCURVA"] !== null ? utf8_encode($row["CODIGOCURVA"]) : "",
											"cantidadCurva"		=>		$row["CANTIDADCURVA"],
											"precioCurva"		=>		$row["PRECIOCURVA"]
											);

										$carrito->add($articulo);


			    }

			}




?>

<?php 
	require_once '../fnc/terminarIva.php';
	$iva = TraerIva();
?>

<head>
		<meta charset="utf-8">
		<title>Dues Drapes</title>
		<meta name="generator" content="PrestaShop">
		<meta name="robots" content="index,follow">
		<meta name="viewport" content="width=device-width, minimum-scale=0.25, maximum-scale=1.6, initial-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<link rel="icon" type="image/vnd.microsoft.icon" href="/theme6_1/prestashop/img/favicon.ico?1428853034">
		<link rel="shortcut icon" type="image/x-icon" href="/theme6_1/prestashop/img/favicon.ico?1428853034">
		<link rel="stylesheet" href="../../assets/css/animacion/terminar/global.css" type="text/css" media="all">
		<link rel="stylesheet" href="../../assets/css/animacion/terminar/highdpi.css" type="text/css" media="all">
		<link rel="stylesheet" href="../../assets/css/animacion/terminar/responsive-tables.css" type="text/css" media="all">
		<link rel="stylesheet" href="../../assets/css/animacion/terminar/uniform.default.css" type="text/css" media="all">
		<link rel="stylesheet" href="../../assets/css/animacion/terminar/blockcart.css" type="text/css" media="all">

		<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
		<!--<script>new WOW().init();</script>  -->
		<!--[if IE 8]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
		<![endif]-->
		<style type="text/css">.fancybox-margin{margin-right:17px;}</style>

		<script type="text/javascript">
			
			function CargarValor(){
				//alert("AQUI");
				$.post("terminarTabla.php", { Prueba : "Prueba" }, function(data2){
				   $("#precio").html(data2);
				   $("#precio").show();
				});	

			}


			function GuardarCarrito(){
				//alert('sii');
				$.post("../fnc/GuardarCarrito.php", { Prueba : "Prueba" }, function(data2){
				   $("#prueba").html(data2);
				   $("#prueba").show();
				});	

			}

			function Eliminar(id, precio, nombre){
				//alert("ELIMINAR: " + id);
				$.post("../fnc/TerminarFnc.php", { id : id, precio:precio, nombre: nombre, operacion : "ELIMINAR" }, function(data2){
					$("#VALOR").html(data2);
				    $("#VALOR").show();
				});	
				CargarValor();
			}

			function Agregar(id){
				//alert("AGREGAR " + id);
				operacion = "AGREGAR";
				//alert(operacion);
				$.post("../fnc/TerminarFnc.php", { id : id,  operacion : operacion}, function(data2){
					$("#VALOR").html(data2);
				    $("#VALOR").show();
				});	
				CargarValor();
			}

			function Suprimir(id){
				//alert("SUPIMIR" + id);
				operacion = "SUPRIMIR";
				//alert(operacion);
				$.post("../fnc/TerminarFnc.php", { id : id,  operacion : operacion}, function(data2){
					$("#VALOR").html(data2);
				    $("#VALOR").show();
				});	
				CargarValor();
			}
		</script>
</head>

<body id="order" class="order hide-left-column hide-right-column lang_en">
	<div id="page">
		<div class="columns-container">
			<div id="slider_row" class="row">
				<div id="top_column" class="center_column col-xs-12 col-sm-12"></div>
			</div>
			
			<div id="columns" class="container">	

				<div class="row" style="padding-top: 30px;">
						<!--<a href="javascript:window.history.back();" id="Btn"><i class="fa fa-chevron-left" style="padding-right: 15px;"></i> Volver </a>-->
					<div id="center_column" class="center_column col-xs-12 col-sm-12">

						<?php
							$carro = $carrito->get_content();	
						?>
	
						<h1 id="cart_title" class="page-heading">Cotización
							<!--<span class="heading-counter">El total de productos cotizados son:
								<span id="summary_products_quantity">4 productos</span>
							</span>-->
						</h1>

						<!--<p id="emptyCartWarning" class="alert alert-warning unvisible">Your shopping cart is empty.</p>-->
						<script type="text/javascript">
							CargarValor();
						</script>
						
						<div id="precio"></div>
						<div id="VALOR"></div>
						<div id="prueba"></div>

						<div id="HOOK_SHOPPING_CART"></div>
						<button onclick="GuardarCarrito()">Guardar</button>
						<p class="cart_navigation clearfix">
							<a href="index.php?opcion=datos" class="button btn btn-default standard-checkout button-medium" title="Terminar" style="">
								<span>Siguiente<i class="icon-chevron-right right"></i></span>
							</a>
							<a href=""  title="Continuar" style="float:left; line-height:27px;">
								<span><i class="icon-chevron-left left"></i>Seguir cotizando</span> 
							</a>
						</p>
	
					</div><!-- #center_column -->
				</div><!-- .row -->
			</div><!-- #columns -->
		</div><!-- .columns-container -->
	</div><!-- #page -->
</body>
