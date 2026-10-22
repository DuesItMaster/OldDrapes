<?php 

	require_once '../../conexion/cnx.php'; 

	if (isset($_POST['IdDistri']) and $_POST['IdDistri'] <> ""){ 
		$IdDistri = $_POST['IdDistri'];

	}


	$sql = "SELECT U.ID_USUARIO, UD.ID_USUARIO_DESCUENTO,U.NOMBRE,UD.DESCUENTO FROM usuario U 
	INNER JOIN usuario_desc UD ON (U.ID_USUARIO = UD.ID_USUARIO) WHERE UD.ID_USUARIO = ".$IdDistri.";";
	//echo $sql;

	$result = mysqli_query($GLOBALS['db'], $sql);
	//echo "<br><br><br>".$result;

?>
<style>
p {
line-height: 130%
}
</style>

						<div class="row">
							<div class="col-sm-7">
							</div><!--end .col -->
							<div class="col-sm-7">
								<div class="table-responsive">
									<table id="datatable1" class="table table-striped table-hover">
										<thead>
											<tr>												
												<th>Distribuidor</th>
												<th>Descuentos</th>												
												<th>Eliminar</th>
											</tr>
										</thead>
										<tbody>
											<?php
													
												if (mysqli_num_rows($result) > 0) {
													    while($row = mysqli_fetch_assoc($result)) {
															$Eliminar ="";
													    	
													    		$Eliminar='<a style="cursor:pointer;cursor:click"
													    		data-toggle="modal" data-target="#simpleModal"  onclick="revision('.$row["ID_USUARIO"].','.$row["ID_USUARIO_DESCUENTO"].')"><span class="fa fa-trash-o"></span></a>';
													    	
													    	echo '<tr class="gradeX">													    				
																		<td>'.$row["NOMBRE"].'</td>
																		<td>'.$row["DESCUENTO"].'</td>																		
																		<td>'.$Eliminar.'</td>
																	</tr>';
													    }
													}
											?>
										</tbody>
									</table>
								</div><!--end .table-responsive -->
							</div><!--end .col -->
						</div><!--end .row -->
						<!-- END DATATABLE 1 -->
						<hr class="ruler-xxl"/>

						  <!--modal para confirmación -->
					<div class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="simpleModalLabel">Eliminar desuentos</h4>
								</div>
								<div class="modal-body">
									<p><font size="4" color="black">¿Estas seguro que deseas eliminar este descuento?</font>
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
		
		<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
		<script src="../../assets/js/libs/DataTables/jquery.dataTables.min.js"></script>
		<script src="../../assets/js/libs/DataTables/extensions/ColVis/js/dataTables.colVis.min.js"></script>
		<script src="../../assets/js/libs/DataTables/extensions/TableTools/js/dataTables.tableTools.min.js"></script>		
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoTableDynamic.js"></script>