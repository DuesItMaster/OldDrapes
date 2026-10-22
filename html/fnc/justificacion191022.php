<!DOCTYPE html>
<html lang="en">
	<head>	
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap2.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadminCliente.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/wizard/wizard.css?1425466601" />
		<!-- END STYLESHEETS -->
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
	  	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
	  	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
	</head>

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
