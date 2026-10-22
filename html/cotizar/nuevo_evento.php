<?php
	include '../../conexion/cnx.php';
	if (!isset($_SESSION['login_user'])) {
		header('Location: index.php');
	}
	if($_SESSION['dues']==0){
		header('Location: index.php');
	}
	if ($_SESSION['tipo_usuario']!=1 && $_SESSION['tipo_usuario']!=2) {
		header('Location: index.php');
	}
?>
<section>
	<div class="section-header"></div>
	<div class="section-body contain-lg">						
		<div class="row">
			<div class="col-sm-8">
				<div class="card">
					<div class="card-body ">
						<form name="formulario" class="form floating-label"  enctype="multipart/form-data">
							<div class="tab-content clearfix">
								<div class="tab-pane active" id="tab1">	
									<span><center><h1>Nuevo Evento</h1></center></span>
									<div id="nuevo">
									<div class="form-group">
										<input required type="text" name="nombre" id="nombre" class="form-control">
										<label for="nombre" class="control-label">Nombre</label>
									</div>
									<div class="form-group">
										<textarea name="descripcion" id="descripcion" cols="30" rows="3" class="form-control"></textarea>
										<label for="descripcion" class="control-label">Descripci&oacute;n</label>
									</div>
									<div class="form-group">
										<input required type="date" name="fecha" id="fecha" class="form-control">
										<label for="fecha" class="control-label">Fecha</label>
									</div>
									<div class="form-group">
										<input required type="time" name="hora" id="hora" class="form-control">
										<label for="hora" class="control-label">Hora</label>
									</div>
									<div class="form-group">
										<input required type="date" name="fecha_convocatoria" id="fecha_convocatoria" class="form-control">
										<label for="fecha_convocatoria" class="control-label">Fecha de inicio de la convocatoria</label>
									</div>
								</div>
								<center><button type="button" class="btn ink-reaction btn-primary-light" style="font-weight: bolder;"  onclick="guardar();">Aceptar</button></center>
								</div><!--end #tab1 -->					
								</div><!--end .tab-content -->
								</form>
							</div><!--end #rootwizard -->
						</div><!--end .card-body -->
					</div><!--end .card -->							
				</div><!--end .col -->						
		</div><!--end .section-body -->
	</section>}
<?php $idAlta=$_SESSION['login_user'];?>
<script>
	function guardar(){			    
		nombre=document.getElementById("nombre").value;
		descripcion=document.getElementById("descripcion").value;
		fecha=document.getElementById("fecha").value;
		hora=document.getElementById("hora").value;
		fecha_convocatoria=document.getElementById("fecha_convocatoria").value;
		
		$.ajax({
			url: "../fnc/nuevo_evento.php",
			type: "POST",
			data: {nombre:nombre,descripcion:descripcion,fecha:fecha,hora:hora,fecha_convocatoria:fecha_convocatoria},
			success: function(data){
				console.log(data);
				if($.trim(data)=="Success"){
					alert("El evento ha sido creado con éxito.");
					window.location.href = "index.php";
				}else{
					alert("No se pudo crear el evento. Respuesta: " + data);
				}
			},
			error: function(xhr, status, error){
				console.log(xhr.responseText);
				alert("Error al crear evento (HTTP " + xhr.status + "). Detalle: " + (xhr.responseText || error));
			}
		});
	}	
</script>	
<!-- BEGIN JAVASCRIPT -->
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