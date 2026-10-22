
<?php
	include '../../conexion/cnx.php';
	$sql = "SELECT ID_USUARIO, NOMBRE, EMAIL, CLAVESAP, ID_TIPOUSUARIO, USUARIO FROM usuario WHERE ID_USUARIOALTA =".$_SESSION['login_user']." and ESTATUS = 1;";
	$result = mysqli_query($GLOBALS['db'], $sql);

	$colaboradores = [];

	while($row = mysqli_fetch_assoc($result)) {
		array_push($colaboradores, $row);
	}
?>

<script>
	var colaboradores = <?= json_encode($colaboradores); ?>;
</script>

<link type="text/css" rel="stylesheet" href="../../assets/css/distribuidores_form.css">
<div class="distribuidores_form">
	<h1>Editar Usuarios y Distribuidores</h1>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body ">
				<form name="formulario" class="form floating-label">
					<div id="nuevo">
						<div class="form-group">
							<select name="colaborador" id="colaborador" class="inputs">
								<option value="-">Selecciona al colaborador</option>
								<?php foreach($colaboradores as $colaborador) : ?>
									<option value="<?= $colaborador["ID_USUARIO"];?>"> <?= $colaborador["NOMBRE"];?> | <?= $colaborador["EMAIL"];?></option>
								<?php endforeach; ?>
							</select>
							<p class="help-block"></p>
						</div>

						<div class="fullForm" style="display:none;">
							<div class="form-group">
								<input required type="text" name="nombre" id="nombre" class="inputs nombre" placeholder="Nombre">
								<p class="help-block"></p>
							</div>
							<div class="form-group">
								<input required type="text" name="email" id="email" class="inputs correo" placeholder="Correo">
								<input required type="number" max="99999" name="csap" id="csap" class="inputs clavesap" required placeholder="Clave SAP">
								<p class="help-block"></p>
							</div>						
							<div class="form-group">
								<input type="text" name="usuario" id="usuario" class="inputs usuario" required placeholder="Usuario">
								<p class="help-block"></p>
							</div>
							<div class="form-group">											
								<select class="inputs tipo" id="SelectTipo" name="SelectTipo">	
									<option value="0">Selecciona un tipo de usuario</option>											
									<?php
									if ($_SESSION['perfil']==2 or $_SESSION['perfil']==1) {
										$cons= "SELECT ID_TIPOUSUARIO, TIPO FROM tipousuario order by ID_TIPOUSUARIO desc;";
										$result = mysqli_query($GLOBALS['db'], $cons);
											
										while($row = mysqli_fetch_array($result)) {							    	    
											echo "<option value='".$row["ID_TIPOUSUARIO"]."''>".$row["TIPO"]."</option>";
										}
									}
									if ($_SESSION['perfil']==3) {
										$cons= "SELECT ID_TIPOUSUARIO, TIPO FROM tipousuario WHERE ID_TIPOUSUARIO=4;";
										$result = mysqli_query($GLOBALS['db'], $cons);
											
										while($row = mysqli_fetch_array($result)) {							    	    
											echo "<option value='".$row["ID_TIPOUSUARIO"]."''>".$row["TIPO"]."</option>";
										}
									}
									?>
								</select>
							</div>
							<div class="checkbox checkbox-styled tile-text">
								<label>
									<span>Cambiar contraseña?</span>
									<input type="checkbox" id="chkpass" name="chkpass" onchange="mostrar();">
								</label>
							</div>
							<div id="mostrarPass" style="display:none;">
								<div class="form-group">
									<input type="password" name="pass" id="pass" class="inputs contrasena" required placeholder="Contraseña">
									<p class="help-block"></p>
								</div>
							</div>
						</div>
					</div>
					<button type="button" class="btn ink-reaction btn-primary" onclick="guardar();">Guardar cambios</button>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="simpleModal2" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>Actualización guardada correctamente</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<script>
	var chk;
	$("#colaborador").change(function(){
		let dsp = $(this).val() != "-" && "block" || "none";
		$(".fullForm").css("display", dsp);

		if(dsp == "block") {
			loadColaborador($(this).val());
		}
	});

	function mostrar(){
		chk=$("input[name='chkpass']:checked").val();
		let dsp = chk == "on" && "inline" || "none";
		$("#mostrarPass").css("display", dsp);
	}

	function loadColaborador(id) {
		var colaborador = colaboradores.filter(function(c){
			return c.ID_USUARIO === id
		})[0];
		console.log(colaborador);
		$("#nombre").val(colaborador.NOMBRE);
		$("#email").val(colaborador.EMAIL);
		$("#csap").val(colaborador.CLAVESAP);
		$("#usuario").val(colaborador.USUARIO);
		$("#SelectTipo").val(colaborador.ID_TIPOUSUARIO);
	}
	
	function guardar(){
		var colaborador = colaboradores.filter(function(c){
			return c.ID_USUARIO == $("#colaborador").val()
		})[0];

		if(colaborador == undefined || colaborador == null) return false;

		colaborador.NOMBRE = $("#nombre").val();
		colaborador.EMAIL = $("#email").val();
		colaborador.CLAVESAP = $("#csap").val();
		colaborador.USUARIO = $("#usuario").val();
		colaborador.ID_TIPOUSUARIO = $("#SelectTipo").val();
		
		if(chk == "on") {
			colaborador['PASS'] = $("#pass").val();
			if(colaborador.PASS.length <= 0) return false;
		}

		if($("#colaborador").val() != "-"){
			$.post("../fnc/colaboradorUpd.php",colaborador, function(){ });
			$("#simpleModal2").modal();
			setTimeout('document.formulario.reset()',100);
		}
	}
</script>
