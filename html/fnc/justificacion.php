<?php 
 include '../../conexion/cnx.php';
if (isset($_POST['IDCOTIZACION'])){ 
      $IDCOTIZACION=$_POST['IDCOTIZACION'];

    $sql = "SELECT justificacion FROM cotizacion where ID_COTIZACION=".$IDCOTIZACION.";";

	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {

		while($row = mysqli_fetch_assoc($result)) {
			$re = $row["justificacion"];
		}
	}
	if($re != ""){ 
		echo "<a style='cursor:pointer;cursor:click' data-toggle='modal' data-target='#simpleModal'>
		<p align='right'><font size='4' color='red'>Nota: <span class='fa fa-envelope-o fa-2x'></span></font></p></a>";
	}
}
?>

<div class="modal fade" id="simpleModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Observaciones del agente de ventas</h4>
			</div>
			<div class="modal-body">
				<?php echo "<p><font size='4' color='black'>".$re."</font></p>"; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>
								
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
