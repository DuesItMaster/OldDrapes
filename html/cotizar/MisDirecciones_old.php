<!DOCTYPE html>
<html lang="en">
	<head>	
		<?php
		include '../../conexion/cnx.php';
		?>

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
	</head>
	<body class="menubar-hoverable header-fixed" >	
		
				<section>
					<div class="section-header">						
					</div>
					

<div class="section-body contain-lg">						

	<!-- BEGIN FORM WIZARD -->
	<div class="row">
		<div class="col-sm-8">
			<div class="card">
				<div class="card-body ">
					
		<form name="formulario" class="form floating-label">
			<div class="tab-content clearfix">
				<div class="tab-pane active" id="tab1">	
						 					 	
					<span><center><h1>Nueva dirección</h1></center></span>

						<div id="nuevo">
						<div class="form-group">
							<input required type="text" name="cliente" id="cliente" class="form-control">
							<label for="cliente" class="control-label">Nombre</label>
							<p class="help-block">Nombre identificador de su nueva dirección</p>
						</div>
						<div class="form-group">
							<input type="phone" name="telefono" id="telefono" class="form-control" required>
							<label for="Telefono" class="control-label">Telefono</label>
							<p class="help-block"></p>
						</div>
						<!--<div class="form-group">
							<input type="email" name="email" id="email" class="form-control" required>
							<label for="email" class="control-label">Correo electronico</label>
							<p class="help-block"></p>							
						</div>
						<span><center><h2>Dirección de entrega</h2></center></span>-->
						<div class="form-group">
							<input type="text" name="estado" id="estado" class="form-control" required>
							<label for="estado" class="control-label">Estado</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="ciudad" id="ciudad" class="form-control" required>
							<label for="ciudad" class="control-label">Ciudad/Municipio</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="localidad" id="localidad" class="form-control" required>
							<label for="localidad" class="control-label">Localidad</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="colonia" id="colonia" class="form-control" required>
							<label for="colonia" class="control-label">Colonia</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="calle" id="calle" class="form-control" required>
							<label for="calle" class="control-label">Calle</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="numero" id="numero" class="form-control" required>
							<label for="numero" class="control-label">Número</label>
							<p class="help-block">Número exterior</p>
						</div>		
						<div class="form-group">
							<input type="text" name="referencias" id="referencias" class="form-control" required>
							<label for="referencias" class="control-label">Referencias</label>
							<p class="help-block"></p>
						</div>	
						<div class="form-group">
							<input type="text" name="cp" id="cp" class="form-control" required>
							<label for="cp" class="control-label">C.P.</label>
							<p class="help-block"></p>
						</div>			
						<div class="form-group">
							<input type="text" name="sucursal" id="sucursal" class="form-control" required>
							<label for="sucursal" class="control-label">Sucursal</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="hora" id="hora" class="form-control" required>
							<label for="hora" class="control-label">Hora de entrada</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="atencion" id="atencion" class="form-control" required>
							<label for="atencion" class="control-label">Atención</label>
							<p class="help-block"></p>
						</div>
						<div class="form-group">
							<input type="text" name="contacto" id="contacto" class="form-control" required>
							<label for="contacto" class="control-label">Contacto en dues</label>
							<p class="help-block"></p>
						</div>
					</div>
					<center><button type="button" class="btn ink-reaction btn-primary-light" style="font-weight: bolder;"  onclick="guardar();">Guardar</button></center>
					</div><!--end #tab1 -->					
				</div><!--end .tab-content -->
				
											</form>
										</div><!--end #rootwizard -->
									</div><!--end .card-body -->
								</div><!--end .card -->							
							</div><!--end .col -->						
					</div><!--end .section-body -->
				</section>
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

	</body>
</html>
