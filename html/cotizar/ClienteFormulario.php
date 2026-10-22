<?php
	include '../../conexion/cnx.php';
?>
<link type="text/css" rel="stylesheet" href="../../assets/css/clientes_form.css">
<div class="clientes_form">
	<h1>Nuevo Cliente</h1>				
	<div class="row">
		<div class="col-sm-11">
			<div class="cliente_form">
				<div class="card-body ">
					<form name="formulario" class="form floating-label">
						<div class="tab-content clearfix">
							<div class="tab-pane active" id="tab1">	
								<h2>Cliente Final</h2>
								<div id="nuevo">
									<div class="form-group">
										<input type="text" name="cliente" id="cliente" class="nombre inputs" maxlength="100" required pattern="[A-Za-z0-9]+" onkeypress="return check(event)" placeholder="Nombre completo">
										<input type="phone" name="telefono" id="telefono" class="telefono inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Tel&eacute;fono">
										<input type="email" name="email" id="email" class="correo inputs" required placeholder="Correo electr&oacute;nico">
									</div>
									<h2>Dirección de entrega</h2>
									<div class="form-group">
										<input type="text" name="estado" id="estado" class="estado inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Estado">
										<input type="text" name="ciudad" id="ciudad" class="ciudad inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Ciudad">
										<input type="text" name="localidad" id="localidad" class="localidad inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Localidad">
										<input type="text" name="colonia" id="colonia" class="colonia inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Colonia">
									</div>
									<div class="form-group">
										<input type="text" name="calle" id="calle" class="calle inputs" required pattern="[A-Za-z0-9]+" maxlength="200"  onkeypress="return check(event)" placeholder="Calle">
										<input type="text" name="numero" id="numero" class="numero inputs" required pattern="[A-Za-z0-9]+" maxlength="45" onkeypress="return check(event)" placeholder="Numero">
										<input type="text" name="cp" id="cp" class="cp inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="C&oacute;digo postal">
									</div>
									<div class="form-group">
										<input type="text" name="referencias" id="referencias" class="nombre inputs" required pattern="[A-Za-z0-9]+" maxlength="200"  onkeypress="return check(event)" placeholder="Referencias">
									</div>
									<div class="separador"></div>
									<div class="form-group">
										<input type="text" name="sucursal" id="sucursal" class="sucursal inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Sucursal">
										<input type="text" name="hora" id="hora" class="hora inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Hora de entrada">
										<input type="text" name="atencion" id="atencion" class="atencion inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Atenci&oacute;n">
										<input type="text" name="contacto" id="contacto" class="contacto inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Contacto en Dues">
									</div>
									<button type="button" class="btn ink-reaction btn-primary" onclick="guardar();">Registrar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
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
				<p>Datos guardados correctamente</p>
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
<?php $idAlta=$_SESSION['login_user'];?>
<script>
	function guardar(){	
		idalta = "<?php echo $idAlta; ?>" ;
		cliente=document.getElementById("cliente").value;
		calle=document.getElementById("calle").value;
		numero=document.getElementById("numero").value;
		colonia=document.getElementById("colonia").value;
		localidad=document.getElementById("localidad").value;
		estado=document.getElementById("estado").value;
		atencion=document.getElementById("atencion").value;
		hora=document.getElementById("hora").value;
		ciudad=document.getElementById("ciudad").value;
		telefono=document.getElementById("telefono").value;
		cp=document.getElementById("cp").value;
		contacto=document.getElementById("contacto").value;
		sucursal=document.getElementById("sucursal").value;
		referencias=document.getElementById("referencias").value;
		email=document.getElementById("email").value;
		if(typeof cliente == 'undefined' || cliente == null || cliente ==""){ 
			return false;
		}
		else{ 
			if (/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/.test(email)){
				$.post("../fnc/datosfnc.php",{cliente:cliente, calle:calle, numero:numero, colonia:colonia, localidad:localidad,
										estado:estado, atencion:atencion, hora:hora, ciudad:ciudad, telefono:telefono, cp:cp,
										contacto:contacto, sucursal:sucursal, referencias:referencias, email:email, idalta:idalta}, function(){ });
				$("#simpleModal2").modal();
				setTimeout(function(){
					window.history.go(-1);
				}, 1000);
			} 
			else{
				$("#modalcorreo").modal(); 
			}   
		}				
	}
	function check(e) {
		tecla = (document.all) ? e.keyCode : e.which;
		if (tecla == 8) {
			return true;
		}
		patron = /[A-Za-z0-9\s]/;
		tecla_final = String.fromCharCode(tecla);
		return patron.test(tecla_final);
	}	
</script>	
