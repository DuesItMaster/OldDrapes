<?php
	include '../../conexion/cnx.php';
	if (!isset($_SESSION['login_user'])) {
		header('Location: index.php');
	}
	$desde = "";
	$where = "";
	$fecha_actual = date("Y-m-d");
	if (isset($_GET['desde'])) {
		$desde = $_GET['desde'];
		$where = " WHERE created BETWEEN '".$desde." 00:00:00'";
	}else{
		$desde = date("Y-m-d",strtotime($fecha_actual."- 30 days"));
		$where = " WHERE created BETWEEN '".$desde." 00:00:00'";
	}

	$hasta = "";
	if (isset($_GET['hasta'])) {
		$hasta = $_GET['hasta'];
		$where .= " AND '".$hasta." 23:59:59'";
	}else{
		$hasta = $fecha_actual;
		$where .= " AND '".$hasta." 23:59:59'";
	}
	$respuesta = "";
	if (isset($_GET['respuesta'])) {
		$respuesta = $_GET['respuesta'];
		$where .= " AND respuesta=".$respuesta;
	}
	$dist = "false";
	if (isset($_GET['dist'])) {
		$dist = $_GET['dist'];
		if($dist=="true")
			$where .= " AND email NOT LIKE '%@dues.com.mx%'";
	}else{
		$dist = "true";
		$where .= " AND email NOT LIKE '%@dues.com.mx%'";
	}

	if($_SESSION['dues']==0){
		header('Location: index.php');
	}
	if ($_SESSION['tipo_usuario']!=1 && $_SESSION['tipo_usuario']!=2) {
		header('Location: index.php');
	}


	$sql = "SELECT usuario.nombre,usuario.EMAIL,interesado_evento.created,interesado_evento.respuesta FROM interesado_evento INNER JOIN usuario ON interesado_evento.id_usuario = usuario.ID_USUARIO ".$where;
	
	$interesados = mysqli_query($GLOBALS['db'], $sql);
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
								<h1>Usuarios Interesados</h1>
								<div class="opciones_tabla_registrados">
									<label for="desde" class="label_input">Desde:</label>
									<input type="date" name="desde" id="desde" onchange="filtrar_resultados()" class="form-control" value="<?php echo $desde; ?>">
									<label for="desde" class="label_input">Hasta:</label>
									<input type="date" name="hasta" id="hasta" onchange="filtrar_resultados()" class="form-control" value="<?php echo $hasta; ?>">
									<label for="respuesta" class="label_input">Respuesta:</label>
									<select name="respuesta" id="respuesta" class="form-control" onchange="filtrar_resultados()">
										<option value="-1">Todas</option>
										<option value="1"<?php if($respuesta=="1") echo " selected"; ?>>S&iacute;</option>
										<option value="0"<?php if($respuesta=="0") echo " selected"; ?>>No</option>
									</select>
									<label for="solo_distribuidores" class="label_input">Solo distribuidores: </label>
									<input type="checkbox" name="solo_distribuidores" id="solo_distribuidores" onchange="filtrar_resultados()" <?php if($dist=="true") echo "checked"; ?>>
									<button id="btnExportar" class="btn btn-success" <?php if(mysqli_num_rows($interesados) == 0) echo "disabled"; ?>>
										<i class="fas fa-file-excel"></i> Exportar a Excel
									</button>
								</div>
								<div class="table-responsive tabla_registrados">
									<table id="tabla" class="table table-border table-striped table-hover table-bordered rounded">
										<thead>
											<tr>
												<th>#</th>
												<th>Nombre</th>
												<th>Email</th>
												<th>Respuesta</th>
												<th>Fecha/Hora</th>
											</tr>
										</thead>
										<tbody>
										<?php 
											$i=0;
											if (mysqli_num_rows($interesados) > 0) {
												while($row = mysqli_fetch_assoc($interesados)){
													$i++;
										?>
												<tr>
													<td><?php echo $i; ?></td>
													<td><?php echo $row["nombre"]; ?></td>
													<td><?php echo $row["EMAIL"]; ?></td>
													<td><?php if($row["respuesta"]==1) echo "<b>S&iacute;</b>";else echo "No"; ?></td>
													<td><?php echo date("d/m/Y  h:i A", strtotime($row["created"])); ?></td>
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
	function filtrar_resultados(){
		if(document.getElementById("respuesta").value!=(-1))
			window.location.href = "index.php?opcion=lista_interesados&desde="+document.getElementById("desde").value+"&hasta="+document.getElementById("hasta").value+"&respuesta="+document.getElementById("respuesta").value+"&dist="+document.getElementById("solo_distribuidores").checked;
		else
			window.location.href = "index.php?opcion=lista_interesados&desde="+document.getElementById("desde").value+"&hasta="+document.getElementById("hasta").value+"&dist="+document.getElementById("solo_distribuidores").checked;
	}
    const $btnExportar = document.querySelector("#btnExportar"),
        $tabla = document.querySelector("#tabla");

    $btnExportar.addEventListener("click", function() {
        let tableExport = new TableExport($tabla, {
            exportButtons: false, // No queremos botones
            filename: "Usuarios_interesados_en_capacitacion", //Nombre del archivo de Excel
            sheetname: "Usuarios", //Título de la hoja
        });
        let datos = tableExport.getExportData();
        let preferenciasDocumento = datos.tabla.xlsx;
        tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
    });
</script>
<!-- END JAVASCRIPT -->