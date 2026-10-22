<?php 
	require_once '../../conexion/cnx.php'; 
?>
<!-- <link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466319" /> -->
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
<link type="text/css" rel="stylesheet" href="../../assets/css/datepicker3.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/reporte_distribuidor.css">
<link type="text/css" rel="stylesheet" href="../../assets/css/tabla_reporte_dist.css">
<script type="text/javascript">

function MostrarValor(){
	//alert("si");
	Cliente=$("#Cliente option:selected").val();
	//alert(Cliente);
	fecha2 = $("#fecha2").val();
	fecha1 = $("#fecha1").val();
	idusuario = $("#idusuario").val();

	vPro = ValorProceso();
	if (vPro == "TRUE"){ Pro = "SI"; }
	else{ Pro = ""; }

	vVe = ValorVerificar();
	if (vVe == "TRUE"){ Ve = "SI"; }
	else{ Ve = ""; }

	$.post("ReporteDistribuidorResultado.php", {Cliente:Cliente,fecha1:fecha1,fecha2:fecha2,Ve:Ve,Pro:Pro,idusuario:idusuario}, function(data2){
	   $("#Reporte").html(data2);
	   $("#Reporte").show();
	});	
	
}

function ValorProceso() {
	var Devolver = 'FALSE';
	$("input[type=checkbox]:checked").each(function(){
		if($(this).val() == "PROCESO"){
			Devolver = 'TRUE';
		}
	});
	return Devolver;
}


function ValorVerificar() {
	var Devolver = 'FALSE';
	$("input[type=checkbox]:checked").each(function(){
		if($(this).val() == "VERIFICAR"){
			Devolver = 'TRUE';
		}
	});
	return Devolver;
}


function ActualizarEstado(id,nombre,FolioCotizacion,Tipo)
{
	//cambie una coma por :en nombre,nombre
	$.post("../fnc/ReporteDistribuidorEstado.php",
	{
		id:id, nombre:nombre, FolioCotizacion:FolioCotizacion, Tipo:Tipo
	}, function(data2)
	{
		//console.log(data2);
	});	

	MostrarValor();
}

</script>
<div class="menubar-hoverable header-fixed">
	<?php 
		$sql = "SELECT id_cliente,nombre from cliente where id_usuario_alta=".$_SESSION['login_user']." union select '' as id_cliente, 'Seleccione cliente' as nombre order by id_cliente;";
		$result = mysqli_query($GLOBALS['db'], $sql);
	?>
	<section class="reporte-distribuidores">
		<h1>B&uacute;squeda de cotizaciones</h1>
		<div class="col-lg-12">
			<form class="form-inline">
				<div class="card">
					<div class="card-body">
						<div class="form-group col-sm-5">
							<?php
								echo '<input type="hidden" id="idusuario" value="'.$_SESSION['login_user'].'">'; 
								echo '<select class="inputs cliente" name="Cliente" id="Cliente">';
								$result = mysqli_query($GLOBALS['db'], $sql);
								if (mysqli_num_rows($result) > 0) {
									while($row = mysqli_fetch_assoc($result)) {
										echo '<option value="'.$row["id_cliente"].'">'.$row["nombre"].'</option>';
									}
								}										
							?>
							</select>
						</div>
						<div class="form-group col-sm-7">
							<input  type="text" class="inputs" placeholder=""  id="fecha1" name="fecha1"> 
							A 
							<input  type="text" class="inputs" placeholder=""  id="fecha2" name="fecha2">
							<button type="button" class="btn-primary" onclick="MostrarValor()">Buscar</button>
						</div>	
						<div class="form-group col-sm-5">
							<div class="checkbox checkbox-styled">
								<label>
									<input type="checkbox" value="PROCESO">
									<span>En Proceso</span>
								</label>
							</div>
							<div class="checkbox checkbox-styled">
								<label>
									<input type="checkbox" value="VERIFICAR">
									<span>Verificar</span>
								</label>
							</div>
						</div>
						<input  type="hidden" class="ord1" placeholder=""  id="ord1" name="ord1" value="ID_COTIZACION">
						<input  type="hidden" class="ord2" placeholder=""  id="ord2" name="ord2" value="DESC">
						<div class="form-group col-sm-7">
							<input required type="text" name="folio" id="folio" class="inputs folio" placeholder="Buscar Folio" onchange="MostrarValor()">
						</div>
						<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
						<script src="../../assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
						<script type="text/javascript">
							$.noConflict();
							jQuery( document ).ready(function( $ ) {
								$('#fecha1').datepicker({
									format: "yyyy-mm-dd",
									language: "es",
									autoclose: true
								});  
									$('#fecha2').datepicker({
									format: "yyyy-mm-dd",
									language: "es",
									autoclose: true
								});  
							});							            
						</script>
					</div><!--end .card-body -->
				</div><!--end .card -->
			</form>
		</div>
		<div class="section-body">
			<h2 class="text-primary">Cotizaciones</h2>
			<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
					<?php
						echo '<div class="btn_excel_container"><img src="../../assets/img/excel_icon.png" height="27px"><a class="btn_descargar_excel" href="descargarDistribuidores.php?idusuario='.$idusuario.'&Cliente='.$Cliente.'&fecha1='.$fecha1.'&fecha2='.$fecha2.'&Pro='.$_GET['Pro'].'&Ve='.$_GET['Ve'].'&folio='.$_POST['folio'].'">Descargar Excel</a></div>';
					?>
						<div class="table_container">
							<div class="col-lg-12">
								<div class="thead">
									<label class="empty" for=""></label>
									<label class="empty" for=""></label>
									<label onclick="ord('ID_COTIZACION')" id="folio" class="folio" for="">Folio</label>
									<label onclick="ord('c.FECHA_ALTA')" id="fecha" class="fecha" for="">Fecha</label>
									<label onclick="ord('cl.NOMBRE')" id="cliente" class="cliente" for="">Cliente</label>
									<label onclick="ord('SUBTOTAL')" id="subtotal" class="subtotal" for="">Subtotal</label>
									<label onclick="ord('DESCUENTO')" id="descuento" class="descuento" for="">Descuento</label>
									<label onclick="ord('IVA')" id="iva" class="iva" for="">IVA</label>
									<label onclick="ord('TOTAL')" id="total" class="total" for="">Total</label>
									<label onclick="ord('ESTATUSt')" id="estatus" class="estatus" for="">Estatus</label>
									<label class="enviar" for="">Enviar</label>
									<label onclick="ord('FECHAEMBARQUE')" id="fechaembarque" class="fechaembarque" for="">Fecha Embarque</label>
									<label onclick="ord('ESTADOCOTIZACION')" id="estado" class="estado" for="">Estado</label>
								</div>
								<div class="table_scroll">
									<div id="Reporte" class="tbody"></div>	
									</div>
								</div>
							</div>
						</div>
					</div><!--end .table-responsive -->
				</div><!--end .col -->
			</div><!--end .row -->					
					</div><!--end .section-body -->
				</section>
			</div>
