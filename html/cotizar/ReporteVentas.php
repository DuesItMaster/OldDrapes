<?php require_once '../../conexion/cnx.php'; ?>
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/jquery.dataTables.css?1423553989" />
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.colVis.css?1423553990" />
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/DataTables/extensions/dataTables.tableTools.css?1423553990" />
<link type="text/css" rel="stylesheet" href="../../assets/css/datepicker3.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/reporte_ventas.css">
<link type="text/css" rel="stylesheet" href="../../assets/css/tabla_reporte_vent.css?v=1">
<?php $idUsuario = $_SESSION['login_user'];?>
<script type="text/javascript">
	function MostrarValor(){
	

		// --- Obtenemos todos los valores de los filtros ---
		distribuidor = $("#Dis option:selected").val();
		ord1 = $("#ord1").val();
		ord2 = $("#ord2").val();
		fecha2 = $("#fecha2").val();
		fecha1 = $("#fecha1").val();
		folio = $("#folio").val();
		
		vPro = ValorProceso();
		Pro = (vPro == "TRUE") ? "SI" : "";
		
		vVe = ValorVerificar();
		Ve = (vVe == "TRUE") ? "SI" : "";
		
		vGua = ValorGuardado();
		Gua = (vGua == "TRUE") ? "SI" : "";

		var lu = '<?php echo $_SESSION['login_user'];?>';
		var lp = '<?php echo $_SESSION['perfil'];?>';
		ord1 = ord1 + " " + ord2;
		
		var urlDescarga = 'descargar.php?distribuidor=' + distribuidor + 
						  '&fecha1=' + fecha1 + 
						  '&fecha2=' + fecha2 + 
						  '&Pro=' + Pro + 
						  '&Ve=' + Ve + 
						  '&Gua=' + Gua +
						  '&folio=' + folio;

		$("#descargarExcelLink").attr("href", urlDescarga);
		
		$.post("ReporteVentasResultado.php", {distribuidor:distribuidor,fecha1:fecha1,fecha2:fecha2,Ve:Ve,Pro:Pro,Gua:Gua,lu:lu,lp:lp,folio:folio,ord:ord1}, function(data2){
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
	function ValorGuardado() {
		var Devolver = 'FALSE';
		$("input[type=checkbox]:checked").each(function(){
			if($(this).val() == "GUARDADO"){ 
				Devolver = 'TRUE';
			}
		});
		return Devolver;
	}
	function DevolverCotizacion(id,correo,nombre,cliente,Justificacion,FolioCotizacion){
		var idUsuario = "<?php echo $idUsuario; ?>";
		$.post("../fnc/ReporteVentasEstado.php", {idUsuario:idUsuario, id:id,correo:correo,nombre:nombre,cliente:cliente,Justificacion:Justificacion,FolioCotizacion:FolioCotizacion}, function(data2){}); 	
		MostrarValor();
	}
	function AutorizarEstado(id2){
		var idUsuario = "<?php echo $idUsuario; ?>";
		$.post("../fnc/ReporteVentasEstado.php", {id2:id2, idUsuario: idUsuario}, function(data2){
			$('#simpleModal').modal('hide');
			MostrarValor();
		}); 
	}
	function AutorizarParaPedido(id3) {
		var idUsuario = "<?php echo $idUsuario; ?>";
		$.post("../fnc/ReporteVentasEstado.php", {id3:id3,idUsuario:idUsuario}, function(data2){
		}); 
		MostrarValor();
	}
	function ord(tipo){
		ord1 = $("#ord1").val();
		ord2 = $("#ord2").val();
		if(ord1 == tipo){
			if (ord2 == "DESC")
				$("#ord2").val("ASC")
			else
				$("#ord2").val("DESC")
		}else{
			$("#ord2").val("ASC")
		}
		ord1 = $("#ord1").val(tipo);
		$("#folio").html("Folio");
		$("#fecha").html("Fecha");
		$("#cliente").html("Cliente");
		$("#subtotal").html("Subtotal");
		$("#descuento").html("Descuento");
		$("#iva").html("IVA");
		$("#total").html("Total");
		$("#estatus").html("Estatus");
		$("#fechaembarque").html("Fecha Embarque");
		$("#estado").html("Estado");
		switch (ord1) {
			case 'ID_COTIZACION':
				if($("#ord2").val() == "ASC")
					$("#folio").html("Folio⭡");
				else
					$("#folio").html("Folio⭣");
				break;
			case 'c.FECHA_ALTA':
				if($("#ord2").val() == "ASC")
					$("#fecha").html("Fecha⭡");
				else
					$("#fecha").html("Fecha⭣");
				break;
			case 'us.NOMBRE':
				if($("#ord2").val() == "ASC")
					$("#cliente").html("Cliente⭡");
				else
					$("#cliente").html("Cliente⭣");
				break;
			case 'SUBTOTAL':
				if($("#ord2").val() == "ASC")
					$("#subtotal").html("Subtotal⭡");
				else
					$("#subtotal").html("Subtotal⭣");
				break;
			case 'DESCUENTO':
				if($("#ord2").val() == "ASC")
					$("#descuento").html("Descuento⭡");
				else
					$("#descuento").html("Descuento⭣");
				break;
			case 'IVA':
				if($("#ord2").val() == "ASC")
					$("#iva").html("IVA⭡");
				else
					$("#iva").html("IVA⭣");
				break;
			case 'TOTAL':
				if($("#ord2").val() == "ASC")
					$("#total").html("Total⭡");
				else
					$("#total").html("Total⭣");
				break;
			case 'ESTATUSt':
				if($("#ord2").val() == "ASC")
					$("#estatus").html("Estatus⭡");
				else
					$("#estatus").html("Estatus⭣");
				break;
		}
		MostrarValor();
	}
</script>
<?php 
	$cons = "";
	if ($_SESSION['perfil']==3){ 	
		$cons = " and  ID_USUARIOALTA=" .$_SESSION['login_user'] ;
	}
	$sql = "SELECT ID_USUARIO, NOMBRE from usuario WHERE ID_TIPOUSUARIO = 4 " . $cons . "
			union select '' as ID_USUARIO, '.Seleccione distribuidor para busqueda' as NOMBRE order by nombre;";
	$result = mysqli_query($GLOBALS["db"], $sql);
?>
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<div class="menubar-hoverable header-fixed">
	<section class="reporte-distribuidores">
		<h1>B&uacute;squeda de cotizaciones</h1>
		<div class="col-lg-12">
			<form class="form-inline">
				<div class="card">
					<div class="card-body">
						<div class="form-group col-sm-6">
							<select class="inputs cliente" name="Dis" id="Dis">
								<?php
									$result = mysqli_query($GLOBALS["db"], $sql);
									if (mysqli_num_rows($result) > 0) {
										while($row = mysqli_fetch_assoc($result)) {
											echo '<option value="'.$row["ID_USUARIO"].'">'.$row["NOMBRE"].'</option>';
										}
									} 										
								?>
							</select>
						</div>
						<div class="form-group col-sm-6">
							<input  type="text" class="inputs" placeholder="FECHA INICIO"  id="fecha1" name="fecha1"> 
							A 
							<input  type="text" class="inputs" placeholder="FECHA FINAL "  id="fecha2" name="fecha2">
							<button type="button" class="btn-primary" onclick="MostrarValor()">Buscar</button>
						</div> 	
						<div class="form-group col-sm-6">
							<div class="checkbox checkbox-styled">
								<label>
									<input type="checkbox" id="busproce" value="PROCESO">
									<span>Sin revisión</span>
								</label>
							</div>
							<div class="checkbox checkbox-styled">
								<label>
									<input type="checkbox" id="busveri" value="VERIFICAR">
									<span>Creado en SAP</span>
								</label>
							</div>
							<div class="checkbox checkbox-styled">
								<label>
									<input type="checkbox" id="busguardado" value="GUARDADO">
									<span>Guardados (sin envio)</span>
								</label>
							</div>
						</div>
						<input  type="hidden" class="ord1" placeholder=""  id="ord1" name="ord1" value="ID_COTIZACION">
						<input  type="hidden" class="ord2" placeholder=""  id="ord2" name="ord2" value="DESC">
						<div class="form-group col-sm-6">
							<input required type="text" name="folio" id="folio" class="inputs folio" placeholder="Buscar Folio" onchange="MostrarValor()">
						</div>
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
					</div></div></form>
		</div>
		<div class="section-body">
			<h2>Cotizaciones</h2>
			<div class="row">
				<div class="col-lg-12">
					<div class="table-responsive">
					<?php
						echo '<div class="col-sm-3">
								<a id="descargarExcelLink" href="#">
									Descargar Excel <img src="../../assets/img/excelicon.png" height="27px">
								</a>
							  </div>';
					?>
					<div class="table_container">
						<div class="col-lg-12">
							<div class="thead">
								<label class="empty" for=""></label>
								<label class="empty" for=""></label>
								<label class="empty" for=""></label>
								<label onclick="ord('ID_COTIZACION')" id="folio" class="folio" for="">Folio</label>
								<label onclick="ord('c.FECHA_ALTA')" id="fecha" class="fecha" for="">Fecha</label>
								<label onclick="ord('us.NOMBRE')" id="cliente" class="cliente" for="">Distribuidor</label>
								<label onclick="ord('SUBTOTAL')" id="subtotal" class="subtotal" for="">Subtotal</label>
								<label onclick="ord('DESCUENTO')" id="descuento" class="descuento" for="">Descuento</label>
								<label onclick="ord('IVA')" id="iva" class="iva" for="">IVA</label>
								<label onclick="ord('TOTAL')" id="total" class="total" for="">Total</label>
								<label onclick="ord('ESTATUSt')" id="estatus" class="estatus" for="">Estatus</label>
								<label class="estatus" for="">Devolver</label>
								<label class="estatus" for="">Aprobar</label>
								<label class="estatus" for="">Enviar Cotizador</label>
							</div>
							<div class="table_scroll">
								<div id="Reporte" class="tbody"></div> 		
							</div>
						</div>
					</div>
				</div>
			</div>				
			<hr class="ruler-xxl"/>
			
			
						
						</div>
					</div></div></div><div class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="simpleModalLabel">Cambiar estatus</h4>
						</div>
						<div class="modal-body">
							<p>¿Estas seguro que deseas APROBAR esta cotización?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" value="Cancelo" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary" id="Acepto" value="SI" >Estoy seguro</button> 				
						</div>
					</div></div></div><div class="modal fade" id="simpleModal2" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="simpleModalLabel">Cambiar estatus</h4>
						</div>
						<div class="modal-body">
							<p>¿Estas seguro que desea Rechazar y devolver esta cotización al distribuidor?</p>
							<div class="form-group">
								<textarea name="Justificacion" id="Justificacion" class="form-control" rows="2" placeholder="" maxlength="990"></textarea>
								<label for="localidad" class="control-label"></label>
								<p class="help-block">Motivo de la devolución</p>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary" id="AceptoCancelar" value="SI" >Estoy seguro</button> 				
						</div>
					</div></div></div><div class="modal fade" id="simpleModalPedido" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title" id="simpleModalLabel">Cambiar estatus</h4>
						</div>
						<div class="modal-body">
							<p>¿Estas seguro que deseas enviar esta cotizacion al Cotizador Local para creación de pedido?</p>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" value="Cancelo" data-dismiss="modal">Cancelar</button>
							<button type="button" class="btn btn-primary" id="AceptoPedido" value="SI" >Estoy seguro</button> 				
						</div>
					</div></div></div><script>
				function Autorizar(id){
					var myEl = document.getElementById('Acepto');
					myEl.addEventListener('click', function() {
					AutorizarEstado(id);
					}, false); 
				}

				function AutorizarPedido(id){
					var myEl = document.getElementById('AceptoPedido');
					myEl.addEventListener('click', function() {
					AutorizarParaPedido(id);
					}, false); 
				}
				</script>

					<script>
				function Devolver(llega2,correo,nombre,cliente,FolioCotizacion){
					var myEl2 = document.getElementById('AceptoCancelar'); 		
					myEl2.addEventListener('click', function() {
						var Justi = document.getElementById('Justificacion').value;
					DevolverCotizacion(llega2,correo,nombre,cliente,Justi,FolioCotizacion);
					}, false); 
				}
				</script>

			<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
			<script src="../../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
			<script src="../../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
			<script src="../../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script> 		
			<script src="../../assets/js/core/demo/Demo.js"></script>
			<script src="../../assets/js/core/demo/DemoTableDynamic.js"></script>
            
            <script type="text/javascript">
                $(document).ready(function() {
                    // Esta línea hace que la modal de instrucciones aparezca al cargar la página.
                    $('#modalInstrucciones').modal('show');
                });
            </script>

		</div>
	</section>
</div>