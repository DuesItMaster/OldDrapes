<?php
	require_once '../../conexion/cnx.php'; 
	include_once '../clases/Carrito.class.php';
	session_start();

	$carrito = new Carrito();

	if (isset($_GET['id']) and $_GET['id']<>""){
		$id = $_GET['id'];

		echo "<input type='hidden' id='id' name='id' value='".$id."'>";
	} 

	$carrito->destroy();

	//echo "<br><br><br><br>folio".$carrito->TraerFolio();

	$sql = "select CODIGO, CANTIDAD , NOMBRE, PRECIO,TIPOARTICULO,RUTA,ANCHO,ALTO,TIPOCORTINA,FIJACION,
				   ACOPLAMIENTO,TELA,COLOR,GANCHO,BAJOPLOMO,STIFFENER,NEVERLIGHT,TELAFORRO,
				   PRECIOTELA,CODIGOTELA,METRAJE,COLORFORRO,PRECIOFINALFORRO,CODIGOTELAFORRO,
				   CODIGOMOFORRO,PRECIOTELAFORRO,PRECIOMOFORRO,CODIGOMO,PRECIOMO,METRAJEFORRO,CODIGOSTIFFENER,
				   PRECIOSTIFFENER,TipoArticuloDetalle,area,CANTIDADHOJAS,CONTROL,DECORATIVO,PESO,REMATE,RESULTADOSISTEMA,SOPORTE,
				   ARGOLLA,BASTON,COLORBASTON,RADIOMATERIAL,RADIOMEDIDA,PROYECCIONES,COPETE,METRAJEGALERIA,CODIGOMECANISMO,PRECIOMECANISMO,ID,ID_UNIQUE,METRAJEMO,METRAJEMOFORRO,
				   CANTIDADBASTON,CODIGOBASTON,PRECIOBASTON, CODIGOBAJOPLOMO, PRECIOPLOMO, METRAJEBAJOPLOMO,
				   (CANTIDADBASTON/CANTIDAD) AS cantidadBastonFija,CONTROLMOT,CODIGOCONTROL, NOMBRECONTROL,PRECIOCONTROL,TIPOCONTROL,IDDRAPESNOMBRE,COLORCINTA,CODIGOARGOLLA,CANTIDADARGOLLA,PRECIOARGOLLA,METRAJEREAL,METRAJEMOREAL,PRECIOREAL,PRECIOMOREAL,METRAJEREALFORRO,METRAJEMOREALFORRO,PRECIOREALFORRO,PRECIOMOREALFORRO,METRAJEBAJOPLOMOREAL,MEDIDAPROYECCION,CODIGOESCUADRAS, CANTIDADESCUADRAS, PRECIOESCUADRAS, CODIGOCOPETE,VARILLA, ANCHOTELA, APROVTELA, APLICAAPROV, CONSECAPROV, ORIENTACIONRAYACORTINA, LADO_MOTOR   
			from cotizacion_detalle where ID_COTIZACION = ".$id." ;"; //and id_usuario_alta=".$_session['']."3


	$result = mysqli_query($GLOBALS['db'], $sql);

	if (mysqli_num_rows($result) > 0) {

		while($row = mysqli_fetch_assoc($result)) {

			//echo "<script> alert('Metraje MO: ".$row["METRAJEMO"]."'); </script>";
			//echo "<script> alert('Código Escuadras: ".$row["CODIGOESCUADRAS"]."'); </script>";
			//echo "<script> alert('Precio Escuadras: ".$row["PRECIOESCUADRAS"]."'); </script>";
			//echo "<script> alert('Código Copete: ".$row["CODIGOCOPETE"]."'); </script>";

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
								"cantidadBastonFija"    =>		$row["cantidadBastonFija"],
								"proyecciones"  	=>      $row["PROYECCIONES"],
								"copete"        	=>      $row["COPETE"],
								"MetrajeGaleria"	=>		$row["METRAJEGALERIA"],
								"medidaProyeccion"	=>		$row["MEDIDAPROYECCION"],
								"CodigoEscuadras"	=>		$row["CODIGOESCUADRAS"],
								"TotalEscuadras"	=>		$row["CANTIDADESCUADRAS"],
								"PrecioEscuadras"	=>		$row["PRECIOESCUADRAS"],
								"CodigoCopete"	=>		$row["CODIGOCOPETE"],
								"Varilla"	=>		$row["VARILLA"],
								"AnchoTela"	=>		$row["ANCHOTELA"],
								"AprovTela"	=>		$row["APROVTELA"],
								"AplicaAprov"	=>		$row["APLICAAPROV"],
								"ConsecAprov"	=>		$row["CONSECAPROV"],
								"CodigoMecanismo"	=> 		$row["CODIGOMECANISMO"],
								"PrecioMecanismo"	=> 		$row["PRECIOMECANISMO"],
								"controlMot"		=>		$row["CONTROLMOT"],
								"precioControl"		=>		$row["PRECIOCONTROL"],
								"codigoControl"		=>		$row["CODIGOCONTROL"],
								"nombreControl"		=>		$row["NOMBRECONTROL"],
								"tipoControlMot"	=>		$row["TIPOCONTROL"],
								"idDrapesNombre"	=>		$row["IDDRAPESNOMBRE"],
								"colorCinta"		=>		$row["COLORCINTA"],
								"CodigoArgolla"     =>      $row["CODIGOARGOLLA"],
								"CantidadArgolla"   =>      $row["CANTIDADARGOLLA"],
								"PrecioArgolla"		=>      $row["PRECIOARGOLLA"],
								"MetrajeReal"	    =>		$row["METRAJEREAL"],
								"MetrajeMOReal"	    =>		$row["METRAJEMOREAL"],
								"PrecioReal"	    =>		$row["PRECIOREAL"],
								"PrecioMoReal"		=>		$row["PRECIOMOREAL"],
								"MetrajeRealForro"	=>		$row["METRAJEREALFORRO"],
								"MetrajeMORealForro"=>		$row["METRAJEMOREALFORRO"],
								"PrecioRealForro"	=>		$row["PRECIOREALFORRO"],
								"PrecioMoRealForro"	=>		$row["PRECIOMOREALFORRO"],
								"MetrajeBajoPlomoReal"	=>  $row["METRAJEBAJOPLOMOREAL"],
								"OrientacionRayaCortina"	=>  $row["ORIENTACIONRAYACORTINA"],
								"lado_motor"         => $row["LADO_MOTOR"]
							);

			$carrito->add($articulo);
		}
	}

	$sql = "SELECT c.id_cliente,nombre,estatus,c.id_usuario_alta, c.EJECUTIVO_COTIZADOR FROM cotizacion c left join cliente cl on (c.id_cliente = cl.id_cliente) where ID_COTIZACION=".$id.";";

	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {

		while($row = mysqli_fetch_assoc($result)) {

			$nombre = $row["nombre"];
			$idCliente = $row["id_cliente"];
			$estatus = $row["estatus"];
			$IdUsuarioAlta = $row["id_usuario_alta"];
			$Ejecutivo_Cotizador = $row["EJECUTIVO_COTIZADOR"];
		}
	}

	echo "<input type='hidden' id='idCliente' name='idCliente' value='".$idCliente."'>";
	echo "<input type='hidden' id='IdUsuarioAlta' name='IdUsuarioAlta' value='".$IdUsuarioAlta."'>";

	$carrito->AsignarFolio($id, $idCliente,$nombre,$estatus,$IdUsuarioAlta);

	$sqlOportunidad = "SELECT oportunidad FROM cotizacion_crm where id_cotizacion = ".$id." ;";
	$resultOportunidad = mysqli_query($GLOBALS["db"], $sqlOportunidad);
	$oportunidad = "No hay oportunidad asociada a esta cotizacion";
	if (mysqli_num_rows($resultOportunidad) > 0) {

		$rowOportunidad = $resultOportunidad->fetch_row();
		$oportunidad = $rowOportunidad[0];
	}



	$sqlUsuario = "SELECT Dues FROM usuario where id_usuario = ".$_SESSION['login_user']." ;";
	$resultUsuario = mysqli_query($GLOBALS["db"], $sqlUsuario);
	if (mysqli_num_rows($resultUsuario) > 0) {

		$rowUsuario = $resultUsuario->fetch_row();
		$usuarioDues = $rowUsuario[0];
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

			function fncValoresCliente(){
				//alert("si");				   
			    IdCliente1 = $("#idCliente").val();
			    IDCOTIZACION = $("#id").val(); 

			   $.post("../fnc/justificacion.php", { IDCOTIZACION: IDCOTIZACION }, function(data1){
				    $("#justificacion").html(data1);
				    $("#justificacion").show();
				});

			   	$.post("../fnc/datoscliente2.php", { client: IdCliente1 }, function(data1){
				    $("#ValoresCliente").html(data1);
				    $("#ValoresCliente").show();
				});


				$.post("../fnc/datosenvio.php", { IDCOTIZACION: IDCOTIZACION }, function(data1){
				    $("#Valoresenvio").html(data1);
				    $("#Valoresenvio").show();
				});
					
			}


			function Guardar(){
				IdCliente1 = $("#idCliente").val();

				//alert(IdCliente1);

				$.post("../fnc/ModificarCarrito.php", { AgregarDireccion:"NO", DireccionCliente:"NO", NuevoCliente:"NO",
													  DireccionCarrito:"SI",
													  idCliente:IdCliente1
													 }, function(data2){

				   $("#prueba").html(data2);
				   $("#prueba").show();
				});

			}

			/*function Duplicar(){
				<?php //$_SESSION['folio'] = null; ?>
				window.location.href = "index.php?opcion=terminar";
			}*/

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
						
						echo '<h1 id="cart_title" class="page-heading">Cotización Folio: '. $id . '. Cliente: ' . $nombre;
						//echo 'Descargar excel';
						//echo "<br>folio: " . $carrito->TraerFolio();
						if($usuarioDues == 1) {
							echo "<br>Num. de Oportunidad: " . $oportunidad;
							if ($oportunidad == "No hay oportunidad asociada a esta cotizacion"){
								// echo "";
							}else{
							echo '<span class="heading-counter" style="color: #f44336;float: none;"><a href="https://crm.zoho.com/crm/org722017379/tab/Potentials/'.trim($oportunidad).'"target="_blank"> Ir a Oportunidad CRM</a></span>';
							}
							echo "<br>Ejecutivo Cotizador: ". $Ejecutivo_Cotizador;
						}
						?>
							<!--<span class="heading-counter">El total de productos cotizados son:
								<span id="summary_products_quantity">4 productos</span>
							</span>-->
						</h1>
						<?php
						echo '<p class="cart_navigation clearfix" style="margin: 0 0 5px;">
     	 				Descargar excel: <b><a href="DescargarCotizacion.php?Nombre='.$nombre.'&op=1">Version Cliente</a></b>  -  <b><a href="DescargarCotizacion.php?Nombre='.$nombre.'&op=2">Version Distribuidor</a></b>';
						?>
						<!--<p id="emptyCartWarning" class="alert alert-warning unvisible">Your shopping cart is empty.</p>-->

						<script type="text/javascript">
							fncValoresCliente();
							CargarValor();
						</script>
						
						<div id="justificacion"></div>
						<div id="precio"></div>
						<div id="VALOR"></div>
						<div id="prueba"></div>
						<!--<div><a>Descargar</a></div>-->

						<?php if ( ($estatus == 1 or $estatus ==3) and $IdUsuarioAlta==$_SESSION['login_user']) { ?>
						<p class="cart_navigation clearfix">
							<a  class="button btn btn-default standard-checkout button-medium" onclick="Guardar()" title="Terminar" style="">
							<!--	<span>Guardar<i class="icon-save right"></i></span>-->
							</a>

						<!--	<a href="index.php?opcion=linea"  title="Continuar" class="button btn btn-default standard-checkout button-medium" style="float:left; line-height:27px;">-->
						<!--		<span><i class="icon-chevron-left left"></i>Agregar productos</span> -->
							</a>
						</p>
						<?php } ?>

						<h3 class="page-subheading">Cliente </h3>
						<div id="ValoresCliente"></div><br>
						<h2 class="page-subheading">Envio</h2>
						<div id="Valoresenvio"></div>
						
						<!--<button onclick="GuardarCarrito()">Guardar</button>-->
						<?php //if ( ($estatus == 1 or $estatus ==3) and $IdUsuarioAlta==$_SESSION['login_user']) { ?>
						<div id="HOOK_SHOPPING_CART"></div>
						
						<p class="cart_navigation clearfix">
							<!--<a href="index.php?opcion=datos" class="button btn btn-default standard-checkout button-medium" title="Terminar" style="">
								<span>Modificar Cliente y Envio<i class="icon-chevron-right right"></i></span>
							</a>-->

							<a href="limpiarcarrito.php" class="button btn btn-default standard-checkout button-medium" title="Terminar" style="">
							<!--	<span>Limpiar Carrito <i class="icon-shopping-cart"></i></span>-->
							</a>
							
						</p>
						<?php //} ?>
					</div><!-- #center_column -->
				</div><!-- .row -->
			</div><!-- #columns -->
		</div><!-- .columns-container -->
	</div><!-- #page -->
</body>

<link rel="stylesheet" href="../../assets/css/animacion/terminar/global.css" type="text/css" media="all">
<link rel="stylesheet" href="../../assets/css/carrito.css" type="text/css" media="all">
<style type="text/css">.fancybox-margin{margin-right:17px;}</style>


<script type="text/javascript">
	function CargarValor(){
		//alert("AQUI");
		$.post("terminarTabla.php", { estatus: "<?php echo $estatus; ?>", IdUsuarioAlta: "<?php echo $IdUsuarioAlta; ?>", usuarioDues: "<?php echo $usuarioDues; ?>", Folio: "<?php echo $id; ?>", Cliente: "<?php echo $nombre; ?>", Oportunidad: "<?php echo $oportunidad; ?>", Ejecutivo_Cotizador: "<?php echo $Ejecutivo_Cotizador; ?>" }, function(data2){
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
	function fncValoresCliente(){
		//alert("si");				   
		IdCliente1 = $("#idCliente").val();
		IDCOTIZACION = $("#id").val(); 
		$.post("../fnc/justificacion.php", { IDCOTIZACION: IDCOTIZACION }, function(data1){
			$("#justificacion").html(data1);
			$("#justificacion").show();
		});
		$.post("../fnc/datoscliente2.php", { client: IdCliente1 }, function(data1){
			$("#ValoresCliente").html(data1);
			$("#ValoresCliente").show();
		});
		$.post("../fnc/datosenvio.php", { IDCOTIZACION: IDCOTIZACION }, function(data1){
			$("#Valoresenvio").html(data1);
			$("#Valoresenvio").show();
		});
	}
	function Guardar(){
		IdCliente1 = $("#idCliente").val();
		$.post("../fnc/ModificarCarrito.php", { AgregarDireccion:"NO", DireccionCliente:"NO", NuevoCliente:"NO",
												DireccionCarrito:"SI",
												idCliente:IdCliente1
												}, function(data2){
			$("#prueba").html(data2);
			$("#prueba").show();
		});
	}
	CargarValor();
	fncValoresCliente();
</script>