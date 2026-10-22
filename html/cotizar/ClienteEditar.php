<?php
	include '../../conexion/cnx.php';
	if (isset($_GET['id'])){ 
		$id = $_GET['id'];
		echo "<input type='hidden' id='idd' value='".$id."'>";
		$sql = "SELECT * FROM cliente WHERE ID_CLIENTE =".$id.";";
		$result = mysqli_query($GLOBALS['db'], $sql);
	}
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {	    	
			echo "<input type='hidden' id='opNombre' value='".utf8_encode($row["NOMBRE"])."'>";
			echo "<input type='hidden' id='opTelefono' value='".$row["TELEFONO"]."'>";
			echo "<input type='hidden' id='opEmail' value='".$row["EMAIL"]."'>";
			echo "<input type='hidden' id='opEstado' value='".utf8_encode($row["ESTADO"])."'>";
			echo "<input type='hidden' id='opMunicipio' value='".utf8_encode($row["MUNICIPIO"])."'>";
			echo "<input type='hidden' id='opLocalidad' value='".utf8_encode($row["LOCALIDAD"])."'>";
			echo "<input type='hidden' id='opColonia' value='".utf8_encode($row["COLONIA"])."'>";
			echo "<input type='hidden' id='opCalle' value='".utf8_encode($row["CALLE"])."'>";
			echo "<input type='hidden' id='opNumero' value='".$row["NUMERO"]."'>";
			echo "<input type='hidden' id='opCp' value='".$row["CP"]."'>";
			echo "<input type='hidden' id='opReferencias' value='".utf8_encode($row["REFERENCIAS"])."'>";
			echo "<input type='hidden' id='opAtencion' value='".utf8_encode($row["ATENCION"])."'>";
			echo "<input type='hidden' id='opSucursal' value='".utf8_encode($row["SUCURSAL"])."'>";
			echo "<input type='hidden' id='opHora' value='".$row["HORA_ENTRADA"]."'>";
			echo "<input type='hidden' id='opContacto' value='".utf8_encode($row["CONTACTO"])."'>";	
		}
	}
?>
<script>
	function Cambiar(){
		NOMBRE = $("#opNombre").val();
		TELEFONO = $("#opTelefono").val();
		EMAIL = $("#opEmail").val();
		ESTADO = $("#opEstado").val();
		MUNICIPIO = $("#opMunicipio").val();
		LOCALIDAD = $("#opLocalidad").val();
		COLONIA = $("#opColonia").val();
		CALLE = $("#opCalle").val();
		NUMERO = $("#opNumero").val();
		CP = $("#opCp").val();
		REFERENCIAS = $("#opReferencias").val();
		SUCURSAL = $("#opSucursal").val();
		HORA = $("#opHora").val();
		ATENCION = $("#opAtencion").val();
		CONTACTO = $("#opContacto").val();
		//alert(NOMBRE);

		$("#cliente").val(NOMBRE);
		$("#telefono").val(TELEFONO);
		$("#email").val(EMAIL);
		$("#estado").val(ESTADO);
		$("#ciudad").val(MUNICIPIO);
		$("#localidad").val(LOCALIDAD);
		$("#colonia").val(COLONIA);
		$("#calle").val(CALLE);
		$("#numero").val(NUMERO);
		$("#cp").val(CP);
		$("#referencias").val(REFERENCIAS);
		$("#sucursal").val(SUCURSAL);
		$("#hora").val(HORA);
		$("#atencion").val(ATENCION);
		$("#contacto").val(CONTACTO);
	}
</script>
<link type="text/css" rel="stylesheet" href="../../assets/css/clientes_form.css">
<div class="clientes_form">
	<h1>Editar Cliente</h1>				
	<div class="row">
		<div class="col-sm-11">
			<div class="cliente_form">
				<div class="card-body ">
					<form name="formulario" class="form floating-label">
						<div class="tab-content clearfix">
							<div class="tab-pane active" id="tab1">	
								<h2>Cliente Final.</h2>
								<div id="nuevo">
									<div class="form-group">
										<input  type="text" name="cliente" id="cliente" class="nombre inputs" maxlength="100" required pattern="[A-Za-z0-9]+" onkeypress="return check(event)" placeholder="Nombre Completo...">
										<input type="phone" name="telefono" id="telefono" class="telefono inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Telefono">
										<input type="email" name="email" id="email" class="correo inputs" required  placeholder="Correo">
									</div>
									<h2>Dirección de entrega</h2>
									<div class="form-group">
										<input type="text" name="estado" id="estado" class="estado inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Estado">
										<input type="text" name="ciudad" id="ciudad" class="ciudad inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Ciudad">
										<input type="text" name="localidad" id="localidad" class="localidad inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Localidad">
										<input type="text" name="colonia" id="colonia" class="colonia inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Colonia">
									</div>
									<div class="form-group">
										<input type="text" name="calle" id="calle" class="calle inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Calle">
										<input type="text" name="numero" id="numero" class="numero inputs" required pattern="[A-Za-z0-9]+" maxlength="45" onkeypress="return check(event)" placeholder="Num.">
										<input type="text" name="cp" id="cp" class="cp inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="C.P.">
									</div>		
									<div class="form-group">
										<input type="text" name="referencias" id="referencias" class="nombre inputs" required pattern="[A-Za-z0-9]+" maxlength="200"  onkeypress="return check(event)" placeholder="Referencias">
									</div>
									<div class="separador"></div>
									<div class="form-group">
										<input type="text" name="sucursal" id="sucursal" class="sucursal inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Sucursal">
										<input type="text" name="hora" id="hora" class="hora inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Hora de entrada">
										<input type="text" name="atencion" id="atencion" class="atencion inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Atencion">
										<input type="text" name="contacto" id="contacto" class="contacto inputs" required pattern="[A-Za-z0-9]+" maxlength="45"  onkeypress="return check(event)" placeholder="Contacto en Dues">
									</div>
									<button type="button" class="btn ink-reaction btn-primary" onclick="guardar();">Guardar</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	Cambiar();
</script>
<div class="modal fade" id="simpleModal2" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="simpleModalLabel">Información</h4>
			</div>
			<div class="modal-body">
				<p>Cambios guardados correctamente</p>
			</div>
		</div>
	</div>
</div>
<?php $idAlta=$_SESSION['login_user'];?>
<script>
	function guardar(){	
		console.log("Entro");
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
		id=document.getElementById("idd").value;
		if(typeof cliente == 'undefined' || cliente == null || cliente ==""){ 
			return false;
		}
		else{ 
			if (/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/.test(email)){	
				$.post("../fnc/datosUpd.php",{cliente:cliente, calle:calle, numero:numero, colonia:colonia, localidad:localidad,
										estado:estado, atencion:atencion, hora:hora, ciudad:ciudad, telefono:telefono, cp:cp,
										contacto:contacto, sucursal:sucursal, referencias:referencias, email:email, idalta:idalta,id:id}, function(){ });
				$("#simpleModal2").modal();
				setTimeout(function(){
					window.history.go(-1);
				}, 1000);
			} 
			else{
				alert("La dirección de email es incorrecta.");
			}   
		}
	}	
</script>	