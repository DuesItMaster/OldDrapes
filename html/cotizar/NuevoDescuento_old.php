<?php require_once '../../conexion/cnx.php'; 
$idUsuario = $_SESSION['login_user'];
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
		var IdDistri;
		function MostrarValor(){
			IdDistri=$("#SelectDis option:selected").val();
			$.post("../fnc/distribuidorDescuentos.php", {IdDistri:IdDistri}, function(data2){
			   $("#Reporte").html(data2);
			   $("#Reporte").show();
			});	
		}

		function insertarDesc(){
			var NuevoDescuento = $("#NuevoDescuento").val();
			$.post("../fnc/reporteDescuentos.php", {IdDistri:IdDistri,NuevoDescuento:NuevoDescuento}, function(data2){
			   $("#NuevoDescuento").val("");
			   $("#Reporte").html(data2);
			   $("#Reporte").show();
			});				
			MostrarValor();
		}

		function EliminarDescuento(IdUsuario,IdDescuento){
			$.post("../fnc/reporteDescuentos.php", {IdUsuario:IdUsuario,IdDescuento:IdDescuento}, function(data2){		
			});	

			MostrarValor();
		}

		</script>

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>
	
	<body class="menubar-hoverable header-fixed ">

		<?php 

			$sql = "SELECT id_cliente,nombre from cliente where id_usuario_alta=".$_SESSION['login_user']." where estatus=1 union select '' as id_cliente, 'Seleccione cliente para busqueda' as nombre order by id_cliente;";
			$result = mysqli_query($GLOBALS['db'], $sql);
				
		?>

			<div class="section-header"></div>
				<section class="style-default-bright">
					<div class="col-lg-12">
						<form class="form-inline">
							<div class="card">
								<div class="card-head style-primary">
									<header>Búsqueda de distribuidores</header>
								</div>
								<div class="card-body">	


								<div class="form-group" style="width:80%">	
								<select class="form-control" id="SelectDis" name="SelectDis" style="width:100%">
								  <?php

								  		$cons = "";
										if ($_SESSION['perfil']==3){	
											$cons = " and  ID_USUARIOALTA=" .$_SESSION['login_user'] ;
										}

									    $cons= "SELECT ID_USUARIO, NOMBRE FROM usuario WHERE ID_TIPOUSUARIO = 4 " . $cons . ";";
										$result = mysqli_query($GLOBALS['db'], $cons);
										   
										while($row = mysqli_fetch_array($result)) {							    	    
									    	echo "<option value='".$row["ID_USUARIO"]."''>".$row["NOMBRE"]."</option>";
									    }
								  ?>
								</select>
									<label><b>Selecciona un distribuidor</b></label>						
								</div>
																
								<button type="button" class="btn btn-raised btn-default-light ink-reaction" onclick="MostrarValor()">Buscar</button>
								 <br><br>
								  <div class="form-group" style="width:80%">
									  <input class="form-control" style="width:100%" type="text" id="NuevoDescuento">
									  <label for="NuevoDescuento"><b>Agrega un porcentaje de descuento</b></label>
								  </div><!--fin input -->
								<button type="button" class="btn btn-raised btn-default-light ink-reaction" onclick="insertarDesc()">Agregar</button>

								</div><!--end .card-body -->
							</div><!--end .card -->
							<!--<em class="text-caption">Inline layout</em>-->
						</form>
					</div><!--end .col -->

					<div class="section-header">
					</div>
					<div class="section-body">

						<h2 class="text-primary">Descuentos</h2>

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
