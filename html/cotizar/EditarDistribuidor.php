
<?php
	include '../../conexion/cnx.php';
	$sql = "SELECT NOMBRE,EMAIL,USUARIO FROM usuario WHERE ID_USUARIO =".$_SESSION['login_user'].";";
	$result = mysqli_query($GLOBALS['db'], $sql);
		
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {	    	
			
			echo "<input type='hidden' id='opNombre' value='".$row["NOMBRE"]."'>";
			echo "<input type='hidden' id='opEmail' value='".$row["EMAIL"]."'>";
			echo "<input type='hidden' id='opUsuario' value='".$row["USUARIO"]."'>";
			echo "<input type='hidden' id='opSession' value='".$_SESSION['login_user']."'>";		    		
		}
	}
?>
<script>
	function Cambiar(){
		NOMBRE = $("#opNombre").val();
		EMAIL = $("#opEmail").val();
		USUARIO = $("#opUsuario").val();
		$("#nombre").val(NOMBRE);
		$("#email").val(EMAIL);
		$("#usuario").val(USUARIO);
	}
</script>
<link type="text/css" rel="stylesheet" href="../../assets/css/distribuidores_form.css">
<div class="distribuidores_form">
	<h1>Editar mi cuenta</h1>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body ">
				<form name="formulario" class="form floating-label">
					<div id="nuevo">
						<div class="form-group">
							<input required type="text" name="nombre" id="nombre" class="inputs nombre" placeholder="Nombre">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="email" id="email" class="inputs nombre" placeholder="Correo">
							<p class="help-block"></p>
						</div>						
						<div class="form-group">
							<input type="text" name="usuario" id="usuario" class="inputs usuario" required placeholder="Usuario">
							<p class="help-block"></p>
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
		</div>
	</div>
</div>
<script>
	Cambiar();
	var chk;
	function mostrar(){
		chk=$("input[name='chkpass']:checked").val();				  
		if(chk=="on"){
			$("#mostrarPass").css("display", "inline");		
		}
		else{
			$("#mostrarPass").css("display", "none");	
		}
	}
	function guardar(){	            	
		nombre=document.getElementById("nombre").value;
		email=document.getElementById("email").value;			 
		usuario=document.getElementById("usuario").value;
		pass=document.getElementById("pass").value;
		Session=document.getElementById("opSession").value;
		if(typeof nombre == 'undefined' || nombre == null || nombre ==""){ 
			return false;
		}
		else{ 
			if (/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/.test(email)){
				if(chk!="on"){ 
					control="no";
					$.post("../fnc/distUpd.php",{nombre:nombre, email:email, usuario:usuario, Session:Session, control:control}, function(){ });
					$("#simpleModal2").modal();
					setTimeout('document.formulario.reset()',100);
				}
				else{
					control="si";
					$.post("../fnc/distUpd.php",{nombre:nombre, email:email, usuario:usuario, pass:pass, Session:Session, control:control}, function(){ });
					$("#simpleModal2").modal();
					setTimeout('document.formulario.reset()',100);
				}
			}
			else{
				$("#modalcorreo").modal(); 
			}   
		}								
	}	
</script>	
