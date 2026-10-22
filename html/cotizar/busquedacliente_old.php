<?php require_once '../../conexion/cnx.php';
	$usr=$_SESSION['login_user'];
	echo "<input id='userlog' type='hidden' value='".$usr."'>";
 ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title></title>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
		<!-- END STYLESHEETS -->
		<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
		

		<script type="text/javascript">

		function MostrarValor(){
			distribuidor=$("#entrada").val();
			us = $("#userlog").val();

			$.post("respclientes.php", {distribuidor:distribuidor,us:us/*,fecha1:fecha1,fecha2:fecha2,Ve:Ve,Pro:Pro*/}, function(data2){
			   $("#Reporte").html(data2);
			   $("#Reporte").show();
			});	
			//alert(distribuidor+us);
		}

		</script>
	</head>
	
	<body class="menubar-hoverable header-fixed ">

		<?php 
			$sql = "SELECT ID_CLIENTE, NOMBRE from cliente WHERE ID_USUARIO_ALTA ='".$_SESSION['login_user']."'     
					union select '' as ID_CLIENTE, 'Seleccione distribuidor para busqueda' as NOMBRE order by ID_CLIENTE;";
			$result = mysqli_query($GLOBALS["db"], $sql);
				
		?>

			<div class="section-header"></div>
				<section class="style-default-bright">
					<div class="col-lg-12">
						<form class="form-inline">
							<div class="card">
								<div class="card-head style-primary">
									<header>Búsqueda de clientes</header>
								</div>
								<div class="card-body">
								<div class="tab-content clearfix">	
						<div class="form-group" style="width:80%">
							<input required type="text" name="entrada" id="entrada" class="form-control" style="width:100%">
							<label for="entrada" class="control-label">Nombre</label>
							<p class="help-block">Busqueda</p>
						</div>	
								<a href="index.php?opcion=CliForm"><button type="button" class="btn btn-raised btn-default-light ink-reaction pull-right">Nuevo</button></a>
								<button type="button" class="btn btn-raised btn-default-light ink-reaction pull-right" onclick="MostrarValor()">Buscar</button>

								</div>
								</div><!--end .card-body -->
							</div><!--end .card -->
							<!--<em class="text-caption">Inline layout</em>-->
						</form>
					</div><!--end .col -->

					<div class="section-header">

					</div>
					<div class="section-body">

						<h2 class="text-primary">Clientes</h2>

						<div id="Reporte"></div>


						
					</div><!--end .section-body -->
				</section>

		<!--</div><!--end #base-->
		<!-- END BASE -->

		<!-- BEGIN JAVASCRIPT -->
		<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/spin.js/spin.min.js"></script>
		<script src="../../assets/js/libs/autosize/jquery.autosize.min.js"></script>
		<script src="../../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
		<script src="../../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
		<script src="../../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>
		<script src="../../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/core/source/AppNavigation.js"></script>
		<script src="../../assets/js/core/source/AppOffcanvas.js"></script>
		<script src="../../assets/js/core/source/AppCard.js"></script>
		<script src="../../assets/js/core/source/AppForm.js"></script>
		<script src="../../assets/js/core/source/AppNavSearch.js"></script>
		<script src="../../assets/js/core/source/AppVendor.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoTableDynamic.js"></script>
		<!-- END JAVASCRIPT -->

	</body>
</html>
