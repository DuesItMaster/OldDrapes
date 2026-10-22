
<?php
	include '../../conexion/cnx.php';
?>
<link type="text/css" rel="stylesheet" href="../../assets/css/distribuidores_form.css">
<div class="distribuidores_form">
	<h1>Nueva dirección</h1>
	<div class="col-sm-8">
		<div class="card">
			<div class="card-body ">
				<form name="formulario" class="form floating-label">
					<div id="nuevo">
						<div class="form-group">
							<input required type="text" name="cliente" id="cliente" class="inputs nombre" placeholder="Nombre">
							<p class="help-block">Nombre identificador de su nueva dirección</p>
						</div>
						<div class="form-group">
							<input required type="text" name="telefono" id="telefono" class="inputs nombre" placeholder="Telefono">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="estado" id="estado" class="inputs nombre" placeholder="Estado">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="ciudad" id="ciudad" class="inputs nombre" placeholder="Ciudad/Municipio">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="localidad" id="localidad" class="inputs nombre" placeholder="Localidad">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="colonia" id="colonia" class="inputs nombre" placeholder="Colonia">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="calle" id="calle" class="inputs nombre" placeholder="Calle">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="numero" id="numero" class="inputs nombre" placeholder="Número">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="referencias" id="referencias" class="inputs nombre" placeholder="Referencias">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="cp" id="cp" class="inputs nombre" placeholder="C.P.">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="sucursal" id="sucursal" class="inputs nombre" placeholder="Sucursal">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="hora" id="hora" class="inputs nombre" placeholder="Hora de entrada">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="atencion" id="atencion" class="inputs nombre" placeholder="Atención">
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input required type="text" name="contacto" id="contacto" class="inputs nombre" placeholder="Contacto en dues">
							<p class="help-block"></p>
						</div>
					</div>
					<button type="button" class="btn ink-reaction btn-primary" onclick="guardar();">Guardar</button>
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
		$.post("../fnc/NuevaDir.php",{cliente:cliente, calle:calle, numero:numero, colonia:colonia, localidad:localidad,
								estado:estado, atencion:atencion, hora:hora, ciudad:ciudad, telefono:telefono, cp:cp,
								contacto:contacto, sucursal:sucursal, referencias:referencias,idalta:idalta}, function(){ });
		$("#simpleModal2").modal();
		setTimeout('document.formulario.reset()',100);	
	}	
</script>	
