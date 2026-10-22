<?php require_once '../../conexion/cnx.php';
	$usr=$_SESSION['login_user'];
	echo "<input id='userlog' type='hidden' value='".$usr."'>";
 ?>
<link type="text/css" rel="stylesheet" href="../../assets/css/clientes.css">
<div class="clientes_container">
	<?php 
		$sql = "SELECT ID_CLIENTE, NOMBRE from cliente WHERE ID_USUARIO_ALTA ='".$_SESSION['login_user']."'     
				union select '' as ID_CLIENTE, 'Seleccione distribuidor para busqueda' as NOMBRE order by ID_CLIENTE;";
		$result = mysqli_query($GLOBALS["db"], $sql);
	?>
	<section class="style-default-bright">
		<div class="col-lg-12">
			<div>
				<h1>Clientes</h1>
				<div class="">
					<div class="buscar_container">
						<div class="tab-content clearfix">	
							<div class="form-group">
								<input type="text" name="entrada" id="entrada" class="form-control" placeholder="Buscar Clientes...">
								<a href="index.php?opcion=CliForm"><button type="button" class="btn btn-raised btn-default-light ink-reaction pull-right bg-primary btn_nuevo">Nuevo Cliente</button></a>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="section-body">
			<div id="Reporte"></div>
		</div>
	</section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript">
	function MostrarValor(){
		distribuidor=$("#entrada").val();
		us = $("#userlog").val();
		$.post("busquedaclienteResultado.php", {distribuidor:distribuidor,us:us/*,fecha1:fecha1,fecha2:fecha2,Ve:Ve,Pro:Pro*/}, function(data2){
			$("#Reporte").html(data2);
			$("#Reporte").show();
		});	
	}
	$(document).ready ( function () {
		MostrarValor();
		$("#entrada").keypress(function(e){
			if(e.which == 13){
				MostrarValor()
				return false;
			}
		});
	});
</script>	
