<?php 
	require_once '../../conexion/cnx.php'; 
	if (isset($_POST['IdDistri']) and $_POST['IdDistri'] <> ""){ 
		$IdDistri = $_POST['IdDistri'];

	}
	$sql = "SELECT U.ID_USUARIO, UD.ID_USUARIO_DESCUENTO,U.NOMBRE,UD.DESCUENTO FROM usuario U 
	INNER JOIN usuario_desc UD ON (U.ID_USUARIO = UD.ID_USUARIO) WHERE UD.ID_USUARIO = ".$IdDistri.";";
	$result = mysqli_query($GLOBALS['db'], $sql);
?>
<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
<div class="row">
	<div class="col-lg-12">
		<div class="table-responsive">
			<div class="table_container">
				<div class="col-lg-12">
					<div class="thead">
						<label class="distribuidor" for="">Distribuidor</label>
						<label class="descuentos" for="">Descuentos</label>
						<label class="eliminar" for="">Eliminar</label>
					</div>
					<div class="table_scroll">
						<div class="tbody">
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
										$Eliminar='<a style="cursor:pointer;cursor:click"
										data-toggle="modal" data-target="#simpleModal" onclick="revision('.$row["ID_USUARIO"].','.$row["ID_USUARIO_DESCUENTO"].')"><span class="fa fa-trash-o"></span></a>';
										echo '<div class="line '.$backg.'">
												<label class="distribuidor">'.$row["NOMBRE"].'</label>
												<label class="descuentos">'.number_format($row["DESCUENTO"], 2, '.', ', ').'</label>																	
												<label class="eliminar">'.$Eliminar.'</label>
											</div>';
									}
								}
							?>
						</div>
					</div>
				</div>
			</div>

		</div><!--end .table-responsive -->
	</div><!--end .col -->
</div><!--end .row -->
<hr class="ruler-xxl"/>
<div class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Eliminar desuentos</h4>
			</div>
			<div class="modal-body">
				<p>¿Estas seguro que deseas eliminar este descuento?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" id="quitdesc" value="SI" >Estoy seguro</button>				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
	function revision(IdUsuario,IdDescuento){	
		var resmodal = document.getElementById('quitdesc');
			resmodal.addEventListener('click', function() {
			EliminarDescuento(IdUsuario,IdDescuento);				   
		}, false); 
	}
</script>
<script src="../../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
<script src="../../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
<script src="../../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>		
<script src="../../assets/js/core/demo/Demo.js"></script>
<script src="../../assets/js/core/demo/DemoTableDynamic.js"></script>