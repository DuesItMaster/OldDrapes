<?php 
	require_once '../../conexion/cnx.php'; 
	if (isset($_POST['idusuario']) and $_POST['idusuario'] <> ""){ 
		$idusuario = $_POST['idusuario'];
	}
	$Where = " where estatus<>0  AND c.id_usuario_alta=". $idusuario ." ";
	$order = " ORDER BY ID_COTIZACION DESC "; 
	if (isset($_POST['Cliente']) and $_POST['Cliente'] <> ""){ 
		$Cliente = $_POST['Cliente'];
		$Where = $Where . " AND c.id_cliente = " .$Cliente;
	}
	if (isset($_POST['folio']) and $_POST['folio'] <> ""){ 
		$folio = $_POST['folio'];
		$Where = $Where . " AND CAST(ID_COTIZACION as CHAR(50)) LIKE '%" .$folio . "%'";
	} else {
		$folio = "";
	}
	if (isset($_POST['fecha1']) and $_POST['fecha1'] <> ""){ 
		$fecha1 = $_POST['fecha1'];
		$Where = $Where . " AND date(c.FECHA_ALTA) >= '" .$fecha1 . "'";
	} else {
		$fecha1 = "";
	}
	if (isset($_POST['fecha2']) and $_POST['fecha2'] <> ""){ 
		$fecha2 = $_POST['fecha2'];
		$Where = $Where . " AND date(c.FECHA_ALTA) <= '" .$fecha2."'";
	} else {
		$fecha2 = "";
	}
	if (isset($_POST['ord']) and $_POST['ord'] <> ""){ 
		$ord = $_POST['ord'];
		$order =" ORDER BY ".$ord;
	} else {
		$ord = "";
	}
	if ((isset($_POST['Pro']) and $_POST['Pro'] <> "") and (isset($_POST['Ve']) and $_POST['Ve'] <> "")){
		$Where = $Where . " AND (c.ESTATUS = 2 or c.ESTATUS = 3) ";
	}elseif (isset($_POST['Pro']) and $_POST['Pro'] <> ""){ 
		$Where = $Where . " AND c.ESTATUS = 2";
	}elseif (isset($_POST['Ve']) and $_POST['Ve'] <> ""){ 
		$Where = $Where . " AND c.ESTATUS = 3";
	}
	$sql = "SELECT ID_COTIZACION,FolioCotizacion, cl.NOMBRE,c.FECHA_ALTA,SUBTOTAL,DESCUENTO,IVA, TOTAL,
				if(estatus = 1, 'GUARDADO',
					IF(ESTATUS=2 AND c.ESTADO=0,'EN REVISION', 
						if(ESTATUS=2 AND c.ESTADO=1,'APROBADO POR DUES',
							IF(ESTATUS=3,'VERIFICAR',
								IF(ESTATUS=4 AND c.ESTADO=1,'CONFIRMADO POR MI',
									IF(ESTATUS=4 AND c.ESTADO=3, 'AUTORIZADO', 
										IF(ESTATUS=4 AND c.ESTADO=4, 'PEDIDO CREADO',
											if(ESTATUS=2 AND c.ESTADO=2, 'REENVIADO A REVISION', 'CANCELADO')))))))) 
				AS ESTATUSt,ESTATUS, 
				c.ESTADO, FECHAEMBARQUE, ESTADOCOTIZACION  
				from cotizacion c INNER join cliente cl on (cl.id_cliente = c.id_cliente) ".$Where.$order." LIMIT 1000";
	$result = mysqli_query($GLOBALS["db"], $sql);
?>
							<?php
								if(mysqli_num_rows($result)>0){
									$str=false;
									while($row = mysqli_fetch_assoc($result)) {
										$backg="";
										if($str){
											$backg="str";
											$str=false;
										}else{
											$str=true;
										}
										$Enviar ="";
										if ($row["ESTATUS"]==1 or ($row["ESTATUS"]==3 and $row["ESTADO"]==2)) {
											$Enviar='<a style="cursor:pointer;cursor:click"
											data-toggle="modal" data-target="#simpleModal" onclick="revision('.$row["ID_COTIZACION"].',\''.$row["NOMBRE"].'\','.$row["TOTAL"].','.$row["FolioCotizacion"].', 1)">
											A Revisión <span class="glyphicon glyphicon-send"></span> </a>';
										}else if ($row["ESTATUS"]==2 and $row["ESTADO"]==1) {
											$Enviar='<a style="cursor:pointer;cursor:click"
											data-toggle="modal" data-target="#simpleModalEnvio"  onclick="revisionPedido('.$row["ID_COTIZACION"].',\''.$row["NOMBRE"].'\','.$row["TOTAL"].','.$row["FolioCotizacion"].', 2)">
											<span class="fa fa-check"></span> A Pedido </a>';
										}
										$Boton = '<label class="empty"></label>';
										if($row["ESTATUS"]==4 and $row["ESTADO"]==3){
											$Boton = '<label class="empty"><a href="index.php?opcion=seguimiento&id='.$row["ID_COTIZACION"].'"><span class="fa fa-tasks"></span></a></label>';
										}
										echo '<div class="line '.$backg.'">
												<label class="empty" style="text-align:center;"><a href="index.php?opcion=RCarr&id='.$row["ID_COTIZACION"].'"><span class="fa fa-search"></span></a></label>
												'.$Boton.'
												<label class="folio">'.$row["ID_COTIZACION"].'</label>
												<label class="fecha">'.$row["FECHA_ALTA"].'</label>
												<label class="cliente">'.$row["NOMBRE"].'</label>
												<label class="subtotal">$ '.number_format($row["SUBTOTAL"], 2, '.', ', ').'</label>																	
												<label class="descuento">$ '.number_format($row["DESCUENTO"], 2, '.', ', ').'</label>
												<label class="iva">$ '.number_format($row["IVA"], 2, '.', ', ').'</label>
												<label class="total">$ '.number_format($row["TOTAL"], 2, '.', ', ').'</label>
												<label class="estatus">'.$row["ESTATUSt"].'</label>
												<label class="enviar">'.$Enviar.'</label>
												<label class="fechaembarque">'.$row["FECHAEMBARQUE"].'</label>
												<label class="estado">'.$row["ESTADOCOTIZACION"].'</label>
											</div>';
									}
								}
							?>
<hr class="ruler-xxl"/>
<div class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Cambiar estatus</h4>
			</div>
			<div class="modal-body">
				<p><font size="4" color="black">¿Estas seguro que deseas enviar a REVISIÓN la cotización a DUES?</font>
					<font size="3">
					<br>Folio: <input style="border:none" type="value" id="idCotizacion" disabled> <!--Este input se agregó para mostrar el Id de la cotización en lugar del Folio de la cotización por el desface que hay en el id y el folio (Es solo informativo)-->
						<input style="border:none" id="FolioConfirmacionPedido" disabled type="hidden">
						<br>Total: $<input style="border:none"  type="value" id="FinalinputCotizacion" disabled>
					</font></p>
				<div class="checkbox checkbox-styled tile-text">
						<label>
						<input type="checkbox" id="terminosCotizacion" onchange="condiciones()" value="SI">
						<span><font size="3">Enviar  <font size="3" style="font-weight: 600;"> para REVISIÓN</font>
							(consulta de stock de insumos, etc.).</font></span>
						</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="SiCotizacion" value="SI" >Estoy seguro</button>				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="simpleModalEnvio" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Cambiar estatus</h4>
			</div>
			<div class="modal-body">
				<p><font size="4" color="black">¿Estas seguro que deseas enviar la cotización a DUES para generar un PEDIDO? </font>
					<font size="3">
					<br>Folio: <input style="border:none" type="value" id="idCotizacion" disabled> <!--Este input se agregó para mostrar el Id de la cotización en lugar del Folio de la cotización por el desface que hay en el id y el folio (Es solo informativo)-->
						<input style="border:none" id="FolioConfirmacionPedido" disabled type="hidden">
						<br>Total: $<input style="border:none"  type="value" id="FinalinputPedido" disabled>
					</font></p>
				<div class="checkbox checkbox-styled tile-text">
						<label>
						<input type="checkbox" id="terminosPedido" onchange="condicionesPedido()" value="SI">
						<span><font size="3">Al dar clic en la confirmación usted <font size="3" style="font-weight: 600;">esta AUTORIZANDO </font>
							convertir esta "Cotizacion" a "Pedido" en Dues.</font></span>
						</label>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="SiPedido" value="SI" >Estoy seguro</button>				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="simpleModa2" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>Guardado correctamente.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>													
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	function revision(folio,nombre,totalF,FolioCotizacion,Tipo){	
		document.getElementById("SiCotizacion").disabled = true;
		$("#idCotizacion").val(folio); //Este input se agregó para asignar el Id de la cotización en lugar del Folio de la cotización por el desface que hay en el id y el folio
		$("#FolioConfirmacionCotizacion").val(FolioCotizacion);
		$("#FinalinputCotizacion").val(totalF);
		var checkbtn = document.getElementById('terminosCotizacion');
		checkbtn.addEventListener('click', function() {
			condiciones();
		}, false);	
		var myEl = document.getElementById('SiCotizacion');
		myEl.addEventListener('click', function() {
			ActualizarEstado(folio,nombre,FolioCotizacion,Tipo);
			//ActualizarEstado(folio,nombre,FolioCotizacion);					   
		}, false); 
	}
	function condiciones(){
		check=document.getElementById("terminosCotizacion").checked;
		if(check==true){
			document.getElementById("SiCotizacion").disabled = false;					
		}
		else{
			document.getElementById("SiCotizacion").disabled = true;					
		}
	}
	function revisionPedido(folio,nombre,totalF,FolioCotizacion,Tipo){	
		document.getElementById("SiPedido").disabled = true;
		$("#FolioConfirmacionPedido").val(FolioCotizacion);
		$("#FinalinputPedido").val(totalF);
		var checkbtn = document.getElementById('terminosPedido');
		checkbtn.addEventListener('click', function() {
			condicionesPedido();
		}, false);	
		var myEl = document.getElementById('SiPedido');
		myEl.addEventListener('click', function() {
			ActualizarEstado(folio,nombre,FolioCotizacion,Tipo);
			//ActualizarEstado(folio,nombre,FolioCotizacion);					   
		}, false); 
	}
	function condicionesPedido(){
		check=document.getElementById("terminosPedido").checked;
		if(check==true){
			document.getElementById("SiPedido").disabled = false;					
		}
		else{
			document.getElementById("SiPedido").disabled = true;					
		}
	}
</script>
<script src="../../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
<script src="../../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>		
<script src="../../assets/js/core/demo/Demo.js"></script>
<script src="../../assets/js/core/demo/DemoTableDynamic.js"></script>