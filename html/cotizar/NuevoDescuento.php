
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/datepicker3.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/reporte_distribuidor.css">
	<link type="text/css" rel="stylesheet" href="../../assets/css/tabla_reporte_dist.css">``
	<script type="text/javascript">
		var IdDistri;
		function MostrarValor(){
			IdDistri=$("#SelectDis2 option:selected").val();
			//$.post("../fnc/distribuidorDescuentos.php", {IdDistri:IdDistri}, function(data2){
			$.post("NuevoDescuentoResultado.php", {IdDistri:IdDistri}, function(data2){
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
		$(document).ready ( function () {
			$("#NuevoDescuento").keypress(function(e){
				if(e.which == 13){
				MostrarValor()
				return false;
				}
			});
		});
	</script>
	<div class="menubar-hoverable header-fixed ">
		<?php 

			$sql = "SELECT id_cliente,nombre from cliente where id_usuario_alta=".$_SESSION['login_user']." where estatus=1 union select '' as id_cliente, 'Seleccione cliente para busqueda' as nombre order by id_cliente;";
			$result = mysqli_query($GLOBALS['db'], $sql);
				
		?>
		<section class="reporte-distribuidores">
			<h1>B&uacute;squeda de distribuidores</h1>
			<div class="col-lg-12">
				<form class="form-inline">
					<div class="card">
						<div class="card-body">	
							<div class="form-group col-sm-5">
								<select class="inputs cliente" id="SelectDis" name="SelectDis" style="width:100%">
									<?php
										$cons = "";
										if ($_SESSION['perfil']==3){	
											$cons = " and  ID_USUARIOALTA=" .$_SESSION['login_user'] ;
										}
										$cons= "SELECT ID_USUARIO, NOMBRE FROM usuario WHERE ID_TIPOUSUARIO = 4 " . $cons . " ORDER BY NOMBRE;";
										$result = mysqli_query($GLOBALS['db'], $cons);
										
										while($row = mysqli_fetch_array($result)) {							    	    
											echo "<option value='".$row["ID_USUARIO"]."''>".ucwords(strtolower($row["NOMBRE"]))."</option>";
										}
									?>
								</select>
							</div>
							<div class="form-group col-sm-7">
								<input class="inputs" type="text" id="NuevoDescuento" placeholder="Agrega un % de descuento">
								<button type="button" class="btn-success" onclick="insertarDesc()">Agregar</button>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="section-body">
				<h2 class="text-primary">Descuentos</h2>
				<div class="form-group col-sm-10">
					<select class="inputs cliente select_dist" id="SelectDis2" name="SelectDis2" style="width:100%">
						<?php
							$cons = "";
							if ($_SESSION['perfil']==3){	
								$cons = " and  ID_USUARIOALTA=" .$_SESSION['login_user'] ;
							}
							$cons= "SELECT ID_USUARIO, NOMBRE FROM usuario WHERE ID_TIPOUSUARIO = 4 " . $cons . " ORDER BY NOMBRE;";
							$result = mysqli_query($GLOBALS['db'], $cons);
							
							while($row = mysqli_fetch_array($result)) {							    	    
								echo "<option value='".$row["ID_USUARIO"]."''>".ucwords(strtolower($row["NOMBRE"]))."</option>";
							}
						?>
					</select>
				</div>
				<div class="form-group col-sm-2">
					<button type="button" class="btn-primary" onclick="MostrarValor()">Buscar</button>
				</div>
				<div id="Reporte"></div>						
			</div>
		</section>
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
	</div>