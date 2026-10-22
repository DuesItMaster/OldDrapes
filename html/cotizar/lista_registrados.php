<?php
	include '../../conexion/cnx.php';
	if (!isset($_SESSION['login_user'])) {
		header('Location: index.php');
	}
	$evento = "";
	$where_evento = "";
	if (isset($_GET['evt'])) {
		$evento = $_GET['evt'];
		$where_evento = " WHERE evento.id = ".$_GET['evt'];
	}
	if($_SESSION['dues']==0){
		header('Location: index.php');
	}
	if ($_SESSION['tipo_usuario']!=1 && $_SESSION['tipo_usuario']!=2) {
		header('Location: index.php');
	}
	$sql = "SELECT * FROM evento";
	$eventos = mysqli_query($GLOBALS['db'], $sql);
	$sql = "SELECT evento.nombre AS nombre_evento,evento.fecha AS fecha_evento,evento.hora AS hora_evento,evento_usuario.created,evento.fecha,evento.hora,evento_usuario.nombre_usuario,ciudad.nombre AS ciudad,evento_usuario.empresa,usuario.EMAIL FROM evento INNER JOIN evento_usuario ON evento.id = evento_usuario.id_evento INNER JOIN usuario ON usuario.ID_USUARIO = evento_usuario.id_usuario INNER JOIN ciudad ON evento_usuario.ciudad = ciudad.id".$where_evento;
	$usuarios = mysqli_query($GLOBALS['db'], $sql);
?>
<section>
	<div class="section-header"></div>
	<div class="section-body registrados contain-lg">						
		<div class="row">
			<div class="col-sm-11">
				<div class="card">
					<div class="card-body ">
						<div class="tab-content clearfix">
							<div class="tab-pane active" id="tab1">	
								<h1>Usuarios Registrados</h1>
								<div class="opciones_tabla_registrados">
									<label for="evento" class="evento_label">Evento: </label>
									<select name="evento" id="evento" class="form-control sel_evento" onchange="sel_evento()">
										<option value="0">Todos</option>
										<?php 
											while($row = mysqli_fetch_assoc($eventos)){
										?>
												<option value="<?php echo $row["id"] ?>" <?php if($evento!="" && $evento==$row["id"]) echo "selected"; ?>><?php echo $row["nombre"] ?></option>
										<?php
											}
										?>
									</select>
									<button id="btnExportar" class="btn btn-success">
										<i class="fas fa-file-excel"></i> Exportar a Excel
									</button>
								</div>
								<div class="table-responsive tabla_registrados">
									<table id="tabla" class="table table-border table-striped table-hover table-bordered rounded">
										<thead>
											<tr>
												<th>#</th>
												<th>Evento</th>
												<th>Nombre</th>
												<th>Registro</th>
												<th>Empresa</th>
												<th>Ciudad</th>
												<th>Email</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											$i=0;
											if (mysqli_num_rows($usuarios) > 0) {
												while($row = mysqli_fetch_assoc($usuarios)){
													$i++;
										?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $row["nombre_evento"]; ?> (<?php echo date("d/m/Y", strtotime($row["fecha_evento"])); ?> <?php echo date("h:i A", strtotime($row["hora_evento"])); ?>)</td>
													<td><?php echo $row["nombre_usuario"]; ?></td>
													<td><?php echo date("d/m/Y h:i A", strtotime($row["created"])); ?></td>
													<td><?php echo $row["empresa"]; ?></td>
													<td><?php echo $row["ciudad"]; ?></td>
													<td><?php echo $row["EMAIL"]; ?></td>
												</tr>
										<?php
												}
											}
										?>
										</tbody>
									</table>
								</div><!--end #tab1 -->	
						</div><!--end .tab-content -->
					</div><!--end #rootwizard -->
				</div><!--end .card-body -->
			</div><!--end .card -->							
		</div><!--end .col -->						
	</div><!--end .section-body -->
</section>
<?php $idAlta=$_SESSION['login_user'];?>
<!-- BEGIN JAVASCRIPT -->
<script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
<script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
<script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
<script>
	function sel_evento() {
		if($("#evento").val()==0){
			window.location.href = "index.php?opcion=lista_registrados";
		}else{
			window.location.href = "index.php?opcion=lista_registrados&evt="+$("#evento").val();
		}
	}
    const $btnExportar = document.querySelector("#btnExportar"),
        $tabla = document.querySelector("#tabla");

    $btnExportar.addEventListener("click", function() {
        let tableExport = new TableExport($tabla, {
            exportButtons: false, // No queremos botones
            filename: "Usuarios_registrados_en_capacitacion", //Nombre del archivo de Excel
            sheetname: "Usuarios", //Título de la hoja
        });
        let datos = tableExport.getExportData();
        let preferenciasDocumento = datos.tabla.xlsx;
        tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
    });
</script>
<script src="../../assets/js/core/source/App.js"></script>
<script src="../../assets/js/core/source/AppNavigation.js"></script>
<script src="../../assets/js/core/source/AppOffcanvas.js"></script>
<script src="../../assets/js/core/source/AppCard.js"></script>
<script src="../../assets/js/core/source/AppForm.js"></script>
<script src="../../assets/js/core/source/AppNavSearch.js"></script>
<script src="../../assets/js/core/source/AppVendor.js"></script>
<script src="../../assets/js/core/demo/Demo.js"></script>
<script src="../../assets/js/core/demo/DemoFormWizard.js"></script>
<!-- END JAVASCRIPT -->