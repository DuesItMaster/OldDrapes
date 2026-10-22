<?php
	include '../../conexion/cnx.php';
?>
<link type="text/css" rel="stylesheet" href="../../assets/css/distribuidores_form.css">
<div class="distribuidores_form">
	<h1>Nuevo distribuidor</h1>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body ">
				<form name="formulario" class="form floating-label">
					<h2>Nuevo</h2>
					<div id="nuevo">
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
							<input type="text" name="pass" id="pass" class="inputs contrasena" required placeholder="Contraseña">
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
					</div>
					<button type="button" class="btn ink-reaction btn-primary" onclick="guardar();">Registrar</button>
				</form>
			</div><!--end .card-body -->
		</div><!--end .card -->							
	</div><!--end .col -->						
</div><!--end .section-body -->
<!-- END CONTENT -->
<div class="modal fade" id="simpleModal2" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>Datos guardados correctamente</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalcorreo" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>La dirección de correo es incorrecta o vacia, es un campo requerido.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalUserIncorrecto" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>El usuario que desea dar de alta ya Existe. Favor de intentar con otro nombre de usuario</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modalUserFaltante" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>Favor de poner Nombre,Clave SAP, Usuario y Contraseña</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php $idAlta=$_SESSION['login_user'];?>	
<script>
	function guardar(){	
		var nombre=document.getElementById("nombre").value;
		var email=document.getElementById("email").value;
		var claveSap=document.getElementById("csap").value;
		var usuario=document.getElementById("usuario").value;
		var pass=document.getElementById("pass").value;
		var tipo=document.getElementById("SelectTipo").value;
		var lu = '<?php echo $_SESSION['login_user'];?>';
		if(typeof nombre == 'undefined' || nombre == null || nombre =="" || typeof usuario == 'undefined' || usuario == null || usuario =="" || typeof pass == 'undefined' || pass == null || pass =="" || typeof claveSap == 'undefined' || claveSap == null || claveSap ==""){ 
			$("#modalUserFaltante").modal(); 
			return false;
		}
		else{ 
			if (/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/.test(email)) {
				$.post("../fnc/usuariofnc.php",{nombre:nombre, email:email, claveSap:claveSap, usuario:usuario, pass:pass, tipo:tipo, lu:lu}, function(data){
					if (data == -1){
						$("#modalUserIncorrecto").modal(); 
						return false;
					}else{
						$("#simpleModal2").modal();
						setTimeout('document.formulario.reset()',100);
					}
					});
			} 
			else {
				$("#modalcorreo").modal(); 
			}   
		}
	}	
</script>