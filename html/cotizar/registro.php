<?php
	include '../../conexion/cnx.php';
	session_start();

	if (!isset($_SESSION['login_user'])) {
		header('Location: index.php');
	}
	$sql = "SELECT * FROM evento WHERE id ='".$_GET['evt']."' AND (fecha > CURDATE() OR (fecha=CURDATE() AND hora > CURTIME()));";
	$result = mysqli_query($GLOBALS['db'], $sql);
	$evento = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) == 0) {
		header('Location: index.php');
	}
	$sql = "SELECT * FROM evento_usuario WHERE id_evento=".$evento["id"]." AND id_usuario=".$_SESSION['login_user'];
	$result = mysqli_query($GLOBALS['db'], $sql);
	$evento_usuario = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {
		header('Location: index.php');
	}
	$sql = "SELECT * FROM ciudad";
	$ciudades = mysqli_query($GLOBALS['db'], $sql);
?>
<section>
	<div class="section-header">						
	</div>
	<div class="section-body contain-lg">						
		<!-- BEGIN FORM WIZARD -->
		<div class="row">
			<div class="col-sm-9">
				<div class="card">
					<div class="card-body ">
						<form name="formulario" class="form floating-label">
							<div class="tab-content clearfix">
								<div class="tab-pane active" id="tab1">	
									<span><center><h1><?php echo $evento["nombre"]; ?></h1></center></span>
									<div class="modal-body">
										<img src="../../assets/img/promociones/<?php echo $evento["imagen"]; ?>" style="width: 90%;">
										<p class="form-control"><?php echo $evento["descripcion"]; ?></p>
									</div>
									<span><center><h2>Confirmar Asistencia</h2></center></span>
									<div id="nuevo">
									<input type="hidden" id="user" name="user" value="<?php echo $_SESSION["login_user"]; ?>" readonly>
									<input type="hidden" id="evento" name="evento" value="<?php echo $evento["id"]; ?>" readonly>
									<div class="form-group">
										<input required type="text" name="nombre" id="nombre" class="form-control" value="" required>
										<label for="nombre" class="control-label">Nombre</label>
									</div>									
									<div class="form-group">
										<input required type="text" name="empresa" id="empresa" class="form-control" value="">
										<label for="empresa" class="control-label">Empresa</label>
									</div>									
									<div class="form-group">
										<input list="ciudad" id="ciudad" type="text" class="form-control" required>
										<datalist name="ciudad">
											<?php 
											echo mysqli_num_rows($ciudades);
												if (mysqli_num_rows($ciudades) > 0) {
													while($row = mysqli_fetch_assoc($ciudades)){
											?>
												<option value="<?php echo $row["nombre"]; ?>"></option>
											<?php
													}
												}
											?>
										</datalist>
										<label for="empresa" class="control-label">Ciudad</label>	
									</div>
									<div class="form-group">
										<input type="phone" name="email" id="email" class="form-control" value="<?php echo $_SESSION["email_user"]; ?>" readonly>
										<label for="Telefono" class="control-label">Email</label>
										<p class="help-block"></p>
									</div>
									<div class="form-group">
										<input required type="text" name="fecha" id="fecha" class="form-control" value="<?php echo  date("d/m/Y", strtotime($evento["fecha"])); ?>" readonly>
										<label for="fecha" class="control-label">Fecha</label>
									</div>
									<div class="form-group">
										<input required type="text" name="hora" id="hora" class="form-control" value="<?php echo date('h:i A', strtotime($evento["hora"])); ?>" readonly>
										<label for="hora" class="control-label">Hora</label>
									</div>
								</div>
								<center><button type="button" class="btn ink-reaction btn-primary-light" style="font-weight: bolder;"  onclick="confirmar();">Confirmar mi asistencia</button></center>
								</div><!--end #tab1 -->					
								</div><!--end .tab-content -->
								</form>
							</div><!--end #rootwizard -->
						</div><!--end .card-body -->
					</div><!--end .card -->							
				</div><!--end .col -->						
		</div><!--end .section-body -->
	</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title" id="simpleModalLabel">Confirmar Asistencia</h3>
			</div>
			<div class="modal-body">
				<p>Presiona "Aceptar" para confirmar tu asistencia al evento.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cancelar</button>
				<button type="button" onClick="guardar()" class="btn btn-primary" id="si" value="SI" >Aceptar</button>		
			</div>
		</div><!-- /.modal-content -->
		<div class="modal-content modal-content2">
			<div class="modal-header">
				<h3 class="modal-title" id="simpleModalLabel">Hecho</h3>
			</div>
			<div class="modal-body">
				<p>Has sido registrado como asistente para este evento.</p>
			</div>
			<div class="modal-footer">
				<button type="button" onClick="salir()" class="btn btn-primary" id="si" value="SI" >Aceptar</button>		
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $idAlta=$_SESSION['login_user'];?>
<script>
	function confirmar(){	
		$('#myModal').modal('show');
	}
	function salir(){	
		window.location.href = "index.php";
	}
	function guardar(){	
		idalta = "<?php echo $idAlta; ?>" ;			    
		user=document.getElementById("user").value;
		evento=document.getElementById("evento").value;
		ciudad=document.getElementById("ciudad").value;
		empresa=document.getElementById("empresa").value;
		nombre=document.getElementById("nombre").value;
		$.post("../fnc/registro.php",{user:user,evento:evento,ciudad:ciudad,empresa:empresa,nombre:nombre}, function(data){
			console.log(data);
			if(data=="Success"){
				alert("Se ha registrado con éxito.")
				$(".modal-content").css("display","none");
				$(".modal-content2").css("display","block");
				setTimeout(function(){
					window.location.href = "index.php";
				}, 2000);
			}else{
				alert("Error. Completa los campos requeridos.");
			}
		});
	}	
</script>	
<!-- BEGIN JAVASCRIPT -->
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
<script src="../../assets/js/libs/spin.js/spin.min.js"></script>
<script src="../../assets/js/libs/autosize/jquery.autosize.min.js"></script>
<script src="../../assets/js/libs/nanoscroller/jquery.nanoscroller.min.js"></script>
<script src="../../assets/js/libs/jquery-validation/dist/jquery.validate.min.js"></script>
<script src="../../assets/js/libs/jquery-validation/dist/additional-methods.min.js"></script>
<script src="../../assets/js/libs/wizard/jquery.bootstrap.wizard.min.js"></script>
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