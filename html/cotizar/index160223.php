<?php

header('Access-Control-Allow-Origin: *');
	header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	header("Allow: GET, POST, OPTIONS, PUT, DELETE");

		$method = $_SERVER['REQUEST_METHOD'];
	if($method == "OPTIONS") {
		die();
	}

include_once '../../conexion/cnx.php';
//include_once '../../conexion/conexionPDO.php';
include_once '../clases/Carrito.class.php';

//session_start();
if(!isset($_SESSION['login_user'])){
	header("Location: ../login/login.php");	
}
$carrito = new Carrito();
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Dues Drapes</title>
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="drapes,dues">
		<meta name="description" content="Cotizador Dues Drapes">
		<!-- END META -->

		<link rel="shortcut icon" href="../../assets/img/favicon.ico">

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466325" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<!-- END STYLESHEETS -->
		 <script src="../fnc/validaciones.js" type="text/javascript"></script>
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	<body class="menubar-hoverable header-fixed menubar-pin ">
		<!-- BEGIN HEADER-->
		<header id="header" >
			<div class="headerbar">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="headerbar-left">
					<ul class="header-nav header-nav-options">
						<li class="header-nav-brand" >
							<div class="brand-holder">
								<a href="">
									<span class="text-lg text-bold text-primary" class="img-responsive"><img src="../../assets/img/logo/LOGOS_SECCIONS_GENERALES.png" ></span>
								</a>
							</div>
						</li>
						<li>
							<a class="btn btn-icon-toggle menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
								<i class="fa fa-bars"></i>
							</a>
						</li>
					</ul>
				</div>
				<div class="headerbar-right">
					<ul class="header-nav header-nav-profile">
						<li class="dropdown">
							<a id="a" data-toggle="modal" data-target="#modalsalir" class=" ink-reaction" data-toggle="">
								<img src="../../assets/img/avatar/avatar1.jpg?1403934956" alt="" />
								<span class="profile-info">
									<?php ECHO $_SESSION['nombre_user']; ?>
									<small>Salir</small>
								</span>
							</a>
						</li><!--end .dropdown -->
					</ul><!--end .header-nav-profile -->
					<ul class="header-nav header-nav-toggle">
						<li>
						</li>
					</ul><!--end .header-nav-toggle -->
				</div><!--end #header-navbar-collapse -->
			</div>
		</header>
		<!-- END HEADER-->
		<!-- BEGIN BASE-->
		<div id="base">
			<div class="offcanvas"></div>
			<!-- BEGIN CONTENT-->
			<div id="content">
				<?php
					if (isset($_GET['opcion'])) {
						switch ($_GET['opcion']) {	
							case 'linea':
						         include("../cotizar/linea.php");
								//include("../cotizar/construccion.php");
						         break;

							case 'linea2':
						         include("../cotizar/linea2.php");
						         //include("../cotizar/construccion.php");
						         break;

						    case 'seleccion':
						        include("../cotizar/seleccion.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;
						    
						    case 'cs':
						         include("../cotizar/cs.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

						    
						    case 'ondulado':
						         include("../cotizar/ondulado.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

						    
						    case 'madera':
						         include("../cotizar/madera.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;


						    case 'hriel':
						        include("../cotizar/hriel.php"); //******
								//include("../cotizar/construccion.php");						    
						         break;

						    case 'glystro':
						         include("../cotizar/glystro.php"); //******
								//include("../cotizar/construccion.php");						    
								 break;
								 
							case 'movelite':
								include("../cotizar/movelite.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

							//Nuevos modulos agregados
							
							case 'dsxl':
								include("../cotizar/dsxl.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

							case 'mts':
								include("../cotizar/mts.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

							case 'cortineroccs':
								include("../cotizar/ccs.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

							case 'irismo':
								include("../cotizar/irismo.php"); //******
								//include("../cotizar/construccion.php");						    
								break;	

							case 'controles':
								include("../cotizar/controles.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

							case 'domotica':
								include("../cotizar/domotica.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

						    case 'gabin':
						         include("../cotizar/gabin.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

						    case 'curvoks':
						         include("../cotizar/curvoks.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

						    case 'tubular':
						        include("../cotizar/tubular.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

							case 'cortineroNuevo':
						        include("../cotizar/hrielNuevo.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;
							
							case 'ccortineroNuevo':
						        include("../cotizar/carritohrielNuevo.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;


						    case 'forest':
						         include("../cotizar/forest.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;


							case 'cotizar':
						         include("../cotizar/cotizar.php");
								//include("../cotizar/construccion.php");
						         break;

							case 'cortinero':
						         include("../cotizar/cortineros.php"); //******
								//include("../cotizar/construccion.php");
						         break;

						    case 'terminar':
						         include("../cotizar/terminar.php");
						    	//include("../cotizar/construccion.php");
						         break;	

						     case 'datos':
						         include("../cotizar/datos.php");
						         break;	

						     case 'persiana':
						         include("../cotizar/persianas.php");
						         break;	

						     case 'romana':
						         include("../cotizar/Romanacotizar.php");
						         break;	

						     case 'pacheto':
						         include("../cotizar/Pachetocotizar.php");
						         break;	

						  	case 'galeria':
						         include("../cotizar/Galeriacotizar.php");
						         break;

						    case 'RepD':
						         include("../cotizar/ReporteDistribuidor.php");
						         break;

						    case 'RCarr':
						    	include("../cotizar/ReporteDistribuidorResultadoCarrito.php");
						        break;

						    case 'REdit':
						    	include("../cotizar/ReporteVentasResultadoEditar.php");
						        break;

						    case 'RepVen':
						    	if ($_SESSION['perfil']==4){	
						    		
						    	}
						    	else {
						    		include("../cotizar/ReporteVentas.php");
						    	}
						        break;							        				 

						    case 'RepVenResCar':
						    	include("../cotizar/ReporteVentasResultadoCarrito.php");
						        break;							        

						    case 'CliForm':
						    	include("../cotizar/ClienteFormulario.php");
						        break;

						    case 'Mdire':
						    	include("../cotizar/MisDirecciones.php");
						        break;

						    case 'CliBus':
						    	include("../cotizar/busquedacliente.php");
						        break;

						    case 'CliEdi':
						    	include("../cotizar/ClienteEditar.php");
						        break;

						    case 'NueDis':
						    	include("../cotizar/NuevoDistribuidor.php");
						        break;

						    case 'NueDes':
						    	include("../cotizar/NuevoDescuento.php");
						        break;

						    case 'EditDis':
						         include("../cotizar/EditarDistribuidor.php");
						         break;  

						    case 'ccotizar':
						         include("../cotizar/carritocotizar.php");
						    	//include("../cotizar/construccion.php");
						         break;

						    case 'ctubular':
						        include("../cotizar/carritotubular.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

						    case 'condulado':
						         include("../cotizar/carritoondulado.php"); //******
						    	//include("../cotizar/construccion.php");
						         break;

						    case 'cmadera':
						         include("../cotizar/carritomadera.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;

						    case 'chriel':
						         include("../cotizar/carritohriel.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;

						    case 'cglystro':
						         include("../cotizar/carritoglystro.php"); //******
						    	 //include("../cotizar/construccion.php");
								 break;
								 
							case 'cmovelite':
						         include("../cotizar/carritomovelite.php"); //******
						    	 //include("../cotizar/construccion.php");
								 break;
							
							//Agregados
							case 'cdsxl':
						         include("../cotizar/carritodsxl.php"); //******
						    	 //include("../cotizar/construccion.php");
								 break;

							case 'cmts':
						         include("../cotizar/carritomts.php"); //******
						    	 //include("../cotizar/construccion.php");
								 break;

							case 'cirismo':
								include("../cotizar/carritoirismo.php"); //******
								//include("../cotizar/construccion.php");
								break;
							
							case 'ccontroles':
								include("../cotizar/carritocontroles.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

							case 'cDOMOTICA':
								include("../cotizar/carritodomotica.php"); //******
								//include("../cotizar/construccion.php");						    
								break;

						    case 'cgabin':
						         include("../cotizar/carritogabin.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;

						    case 'ccurvoks':
						         include("../cotizar/carritocurvoks.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;

						    case 'ccs':
						         include("../cotizar/carritocs.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;
							
							case 'cccs':
								include("../cotizar/carritoccs.php"); //******
								//include("../cotizar/construccion.php");
								break;

						    case 'cforest':
						         include("../cotizar/carritoforest.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;

						    case 'cpacheto':
						         include("../cotizar/carritoPachetocotizar.php"); //******
						    	 //include("../cotizar/construccion.php");
						         break;

						    case 'cromana':
						         include("../cotizar/carritoRomanacotizar.php"); //******
						         break;

						    case 'cgaleria':
						         include("../cotizar/carritoGaleriacotizar.php"); //******
						         break;

						    case 'correo':
						         include("EnviarCorreoSMTP.php"); //******
						         break;

						 	case 'inicio':
						         include("../cotizar/linea.php"); //******
						 		 //include("../cotizar/construccion.php");
						         break; 

						    case 'promos':
						         include("../cotizar/promociones.php"); //******
						         break; 

						     case 'gmail':
						         include("EnviarCorreoGmail.php"); //******
						         break; 

						     case 'videos':
						         include("../cotizar/videos.php"); //******
						         break; 

							case 'catalogos':
								include("../cotizar/catalogos.php"); //******
								break;
								
							case 'listasprecios':
								include("../cotizar/listasprecios.php"); //******
								break;

							case 'seguimiento':
								include("../cotizar/seguimientoPedido.php"); //******
								break;

							case 'APedido':
								include("../cotizar/Pedido.php"); //******
								break;

							case 'registro':
								include("../cotizar/registro.php"); //******
								break;

							case 'lista_registrados':
								include("../cotizar/lista_registrados.php"); //******
								break;
							
							case 'lista_interesados':
								include("../cotizar/lista_interesados.php"); //******
								break;

							case 'nuevo_evento':
								include("../cotizar/nuevo_evento.php"); //******
								break;
								
						     default:
						     	include("../cotizar/linea.php");
						     	//include("../cotizar/construccion.php");
						     	break; 
						}
					}	
					else{
						include("../cotizar/linea.php");
						//include("../cotizar/construccion.php");
						//include("../cotizar/timelineDrapes.html");
					}					
				?>
			</div><!--end .col -->
			<!-- BEGIN MENUBAR-->
			<a id="btnRegresar" class="btn btn-secondary" href="javascript: history.go(-1)">Regresar</a>
			<div id="menubar" class="menubar-inverse ">
				<div class="menubar-fixed-panel">
					<div>
						<a class="btn btn-icon-toggle btn-default menubar-toggle" data-toggle="menubar" href="javascript:void(0);">
							<i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="expanded">
						<a href="../../html/dashboards/dashboard.html">
							<span class="text-lg text-bold text-primary ">DUES&nbsp;DRAPES</span>
						</a>
					</div>
				</div>
				<div class="menubar-scroll-panel">
					<!-- BEGIN MAIN MENU -->
					<ul id="main-menu" class="gui-controls">
						<li>
							<a href="index.php?opcion=inicio" >
								<div class="gui-icon"><i class="md md-home"></i></div>
								<span class="title">Inicio</span>
							</a>
						</li><!--end /menu-li -->
						<li>
							<a href="index.php?opcion=promos" >
								<div class="gui-icon"><i class="md md-local-offer"></i></div>
								<span class="title">Promociones</span>
							</a>
						</li>
						
						<?php if ($_SESSION['perfil']==4 or $_SESSION['perfil']==1 or $_SESSION['perfil']==3) { ?>
						<li>
							<a href="index.php?opcion=linea" >
								<div class="gui-icon"><i class="md md-web"></i></div>
								<span class="title">Cotizar</span>
							</a>
						</li><!--end /menu-li -->
						<li>
							<a href="index.php?opcion=CliBus" >
								<div class="gui-icon"><i class="md md-account-child"></i></div>
								<span class="title">Clientes</span>
							</a>
						</li>
						<li>
							<a href="index.php?opcion=terminar" >
								<div class="gui-icon"><i class="fa fa-shopping-cart"></i></div>
								<span class="title">Mi carrito</span>
							</a>
						</li>
						<li > <!--class="gui-folder"-->
							<a href="index.php?opcion=RepD">
								<div class="gui-icon"><span class="glyphicon glyphicon-list-alt"></span></div>
								<span class="title">Mis cotizaciones</span>
							</a>
						</li>
						<?php } ?>
						<?php if ($_SESSION['perfil']==2 or $_SESSION['perfil']==3 or $_SESSION['perfil']==1) { ?>			
						<li class="gui-folder">
						 	<a>
								<div class="gui-icon"><span class="md md-group-add"></span></div>
								<span class="title">Distribuidores control</span>
							</a>
						  <ul>
							<li>
								<a href="index.php?opcion=NueDis">								
									<span class="title">Nuevo distribuidor</span>
								</a>							
							</li><!--end /menu-li -->
							 <li>
								<a href="index.php?opcion=NueDes">								
									<span class="title">Control descuentos</span>
								</a>							
							 </li><!--end /menu-li -->
						  </ul>
						</li>		
						<?php if($_SESSION['dues']==1){  ?>
						<li class="gui-folder">
						 	<a>
								<div class="gui-icon"><span class="md md-event"></span></div>
								<span class="title">Eventos</span>
							</a>
						  <ul>
							<li>
							<a href="index.php?opcion=nuevo_evento">								
								<span class="title">Crear Nuevo Evento</span>
							</a>							
							</li><!--end /menu-li -->
							<li>
								<a href="index.php?opcion=lista_registrados">								
									<span class="title">Usuarios Registrados</span>
								</a>							
							</li><!--end /menu-li -->
							<li>
								<a href="index.php?opcion=lista_interesados">								
									<span class="title">Usuarios Interesados</span>
								</a>							
							</li><!--end /menu-li -->
						  </ul>
						</li>
						<?php }  ?>
						<li > <!--class="gui-folder"-->
							<a href="index.php?opcion=RepVen">
								<div class="gui-icon"><span class="glyphicon glyphicon-list-alt"></span></div>
								<span class="title">Reportes cotizaciones</span>
							</a>							
						 </li><!--end /menu-li -->
						<?php } ?>	

						<li>
							<a href="index.php?opcion=catalogos" >
								<div class="gui-icon"><i class="md md-filter"></i></div>
								<span class="title">Catalogos</span>
							</a>
						</li>
						<!--<li>
							<a href="index.php?opcion=listasprecios" >
								<div class="gui-icon"><i class="md md-filter"></i></div>
								<span class="title">Listas de Precios</span>
							</a>
						</li>-->

						<li>
							<a href="index.php?opcion=videos" >
								<div class="gui-icon"><i class="md md-movie"></i></div>
								<span class="title">Tutoriales</span>
							</a>
						</li>

						<li class="gui-folder">
							<a>
								<div class="gui-icon"><span class="md md-person"></span></div>
								<span class="title">Mi cuenta</span>
							</a>
							<ul>
								 <li>
									<a href="index.php?opcion=EditDis" >
									 <span class="title">Editar cuenta</span>
								    </a>
								 </li>
							 <?php if ($_SESSION['perfil']==4 or $_SESSION['perfil']==1) { ?>
								 <li>
									<a href="index.php?opcion=Mdire" >									 
									 <span class="title">Nueva dirección</span>
								    </a>
								 </li>
								 <?php } ?>
							</ul>
						</li>
					</ul>
					<div class="menubar-foot-panel">
						<small class="no-linebreak hidden-folded">
							<span class="opacity-75"> 2015</span> <strong>DUES</strong>
						</small>
					</div>
				</div><!--end .menubar-scroll-panel-->
			</div><!--end #menubar-->
			<!-- END MENUBAR -->
		</div><!--end #base-->
		<!-- END BASE -->
		<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="margin: 1px auto;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
							<img src="../../assets/img/promociones/FEBRERO_2023_MODAL.jpg" style="width: 100%;">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Aceptar</button>	
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog" style="margin: 1px auto;">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<?php
					/* EVENTOS, ENCUESTAS A DISTRIBUIDORES
					if (isset($_SESSION['login_user'])) {
						$sql = "SELECT evento.*,evento_usuario.id_usuario FROM evento LEFT JOIN evento_usuario ON evento.id = evento_usuario.id_evento AND evento_usuario.id_usuario = ".$_SESSION['login_user']." WHERE convocatoria<=CURDATE() AND (fecha > CURDATE() OR (fecha=CURDATE() AND hora>CURTIME()));";
						$result = mysqli_query($GLOBALS['db'], $sql);
						$evento = mysqli_fetch_assoc($result);
						if (mysqli_num_rows($result) > 0 && !isset($evento["id_usuario"])) {
				?>
					<div class="modal-body">
						<a href="index.php?opcion=registro&evt=<?php echo $evento["id"]; ?>"><img src="../../assets/img/promociones/<?php echo $evento["imagen"]; ?>" style="width: 90%;"></a>
					</div>
				<?php
						}else{
							$sql = "SELECT * FROM interesado_evento WHERE id_usuario = ".$_SESSION['login_user'];
							$result = mysqli_query($GLOBALS['db'], $sql);
							if (mysqli_num_rows($result) == 0) {
					?>
						<div class="modal-body">
							<img src="../../assets/img/promociones/INVITACIÓN-TEAMS-DISTRIBUIDORES_2232.jpg" style="width: 90%;">
							<div class="pregunta_capacitaciones">
								<label class="label_capacitaciones">¿Te interesa formar parte de nuestras capacitaciones?</label>
								<button class="btn btn-secondary" onClick="interesado_evento(<?php echo $_SESSION['login_user']; ?>,0)">No</button>
								<button class="btn btn-success" onClick="interesado_evento(<?php echo $_SESSION['login_user']; ?>,1)">S&iacute;</button>
							</div>
						</div>
					<?php
							}else{*/
					?>
						<div class="modal-body">
							<img src="../../assets/img/promociones/MODAL-expo-2023.jpg?v=2" style="width: 90%;">
						</div>
					<?php
					/*
							}
						}
					}*/
				?>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Aceptar</button>	
					</div>
				</div>
			</div>
		</div>

		 <div class="modal fade" id="modalsalir" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h3 class="modal-title" id="simpleModalLabel">Terminar</h3>
					</div>
					<div class="modal-body">
						<p>¿Está seguro que desea cerrar sesión?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cancelar</button>
						<a href="../login/logout.php" ><button type="button"  class="btn btn-primary" id="esto" value="SI" >Salir</button></a>			
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/spin.js/spin.min.js"></script>				
		<script src="../../assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/core/source/AppNavigation.js"></script>
		<script src="../../assets/js/core/source/AppOffcanvas.js"></script>
		<script src="../../assets/js/core/source/AppCard.js"></script>
		<script src="../../assets/js/core/source/AppForm.js"></script>
		<script src="../../assets/js/core/source/AppNavSearch.js"></script>
		<script src="../../assets/js/core/source/AppVendor.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<!-- END JAVASCRIPT -->


		<script type="text/javascript">
			function setCookie(name, value, expires, path, domain, secure) {
				document.cookie = name + "=" + escape(value) +((expires == null) ? "" : "; expires=" + expires.toGMTString()) +
    				((path == null) ? "" : "; path=" + path) +((domain == null) ? "" : "; domain=" + domain) +
    				((secure == null) ? "" : "; secure");
			}
			// Leer
			function getCookie(name){
			    var cname = name + "=";
			    var dc = document.cookie;
			    if (dc.length > 0) {
			        begin = dc.indexOf(cname);
			        if (begin != -1) {
			            begin += cname.length;
			            end = dc.indexOf(";", begin);
			            if (end == -1) end = dc.length;
			                return unescape(dc.substring(begin, end));
			            }
			        }
			    return null;
			}
			//Borrar
			function delCookie (name,path,domain) {
			    if (getCookie(name)) {
			        document.cookie = name + "=" + ((path == null) ? "" : "; path=" + path) +
			        ((domain == null) ? "" : "; domain=" + domain) + "; expires=Thu, 01-Jan-70 00:00:01 GMT";
			    }
			}
		</script>

		<script type="text/javascript">
			let quitarModal = new Date(2023, 01, 18, 23, 59, 59); 
			let quitarModal2 = new Date(2023, 02, 28, 23, 59, 59); 
			let hoy = new Date();

			var comprobar = getCookie("avisooff1");
			if (comprobar != null) {
				if (window.location.href == "http://duestextil.fortiddns.com:8087/drapes/html/cotizar/index.php"){
					
					if (quitarModal.getTime() > hoy.getTime())
						$('#myModal').modal('show');
					if (quitarModal2.getTime() > hoy.getTime()) 
						$('#myModal2').modal('show');
				}
				console.log(window.location.href)
				if (window.location.href == "http://192.168.1.20/drapes/html/cotizar/index.php"){
					
					if (quitarModal.getTime() > hoy.getTime()) 
						$('#myModal').modal('show');
					if (quitarModal2.getTime() > hoy.getTime()) 
						$('#myModal2').modal('show');
				}
			}
			else {
				var expiration = new Date();
				expiration.setTime(expiration.getTime() + (60000*60*24*1));
				setCookie("avisooff1","1",expiration);
				
				if (quitarModal.getTime() > hoy.getTime()) 
					$('#myModal').modal('show');
				if (quitarModal2.getTime() > hoy.getTime()) 
						$('#myModal2').modal('show');
			}

			$('#button_promo').click(function() {
				
				if (quitarModal.getTime() > hoy.getTime()) 
					$('#myModal').modal('show');
				if (quitarModal2.getTime() > hoy.getTime()) 
						$('#myModal2').modal('show');
			});

			//Interesado en evento
			function interesado_evento(ref,respuesta) {
				$.post("../fnc/interesado_evento.php",{ref:ref,respuesta:respuesta}, function(data){
					if(data=="Success"){
						alert("¡Gracias por tu respuesta!");
						window.location.href = "index.php";
					}
				});
			}
		</script>


	</body>
</html>
