<?php 
	require_once '../../conexion/cnx.php'; 
	if (isset($_GET['id']) and $_GET['id'] <> ""){
		$idCotizacion = $_GET['id'];
	} 


	$sql = "select FECHAEMBARQUE, ESTADOCOTIZACION from cotizacion where ID_COTIZACION =" .$idCotizacion;
	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {
	    	$fecha = $row["FECHAEMBARQUE"];
	    	$estado = $row["ESTADOCOTIZACION"];
	    }
	}else{
		$fecha = "";
	    $estado = "";
	}
?>

	<div class="menubar-hoverable header-fixed" >	
		<section>
			<div class="section-header"></div>
			<div class="section-body contain-lg">						
				<!-- BEGIN FORM WIZARD -->
				<div class="row">
					<div class="col-sm-8">
						<div class="card">
							<div class="card-body ">
								<form name="formulario" class="form floating-label">
									<div class="tab-content clearfix">
										<div class="tab-pane active" id="tab1">		 					 	
											<span><h1>Modificar Pedido</h1></span>
											<div id="nuevo">
												<div class="form-group">
													<input required type="text" name="cotizacion" id="cotizacion" value="<?php echo $idCotizacion; ?>" class="form-control" disabled>
													<label for="cotizacion" class="control-label">Num Cotizacion</label>
													<p class="help-block"></p>
												</div>
												<div class="form-group">
													<input required type="text" name="fecha" id="fecha" class="form-control" maxlength="50" value="<?php echo $fecha; ?>">
													<label for="fecha" class="control-label">Fecha prevista de embarque</label>
													<p class="help-block"></p>
												</div>						
												<div class="form-group">											
													<select class="form-control" id="SelectTipo" name="SelectTipo">	
														<option value='' <?php echo ($estado == '') ? 'selected' : '';  ?>></option>							
														<option value='EN PROCESO' <?php echo ($estado == 'EN PROCESO') ? 'selected' : '';  ?>>EN PROCESO</option>
														<option value='EMBARCADO' <?php echo ($estado == 'EMBARCADO') ? 'selected' : '';  ?>>EMBARCADO</option>
														<option value='BACK ORDER' <?php echo ($estado == 'BACK ORDER') ? 'selected' : '';  ?>>BACK ORDER</option>   
													</select>
													<label><b>Selecciona el estatus del pedido</b></label>						
												</div>
											</div>
											<button type="button" class="btn ink-reaction btn-primary-light" style="font-weight: bolder;"  onclick="guardar();">Guardar</button>
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

		<div class="modal fade" id="modalUserIncorrecto" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="simpleModalLabel">Información</h4>
					</div>
					<div class="modal-body">
						<p>No se actualizaron correctamente los campos, favor de verificar.</p>
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
						<p>Favor de poner la fecha prevista de embarque</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


		<?php //$idAlta=$_SESSION['login_user'];?>
		
		<script>
            function guardar(){	
              	var id=document.getElementById("cotizacion").value;
			  	var estatus=document.getElementById("SelectTipo").value;
			  	var fecha=document.getElementById("fecha").value;
			  	
				if(typeof id == 'undefined' || id == null || id =="" || typeof fecha == 'undefined' || fecha == null || fecha ==""){ 
					$("#modalUserFaltante").modal(); 
					return false;
				}
				else{ 
			    	$.post("../fnc/pedidofnc.php",{id:id, estatus:estatus, fecha:fecha}, function(data){
			    		if (data == "NO"){
			    			$("#modalUserIncorrecto").modal(); 
			    			//alert("El usuario ya existe"); //
			    			return false;
			    		}else{
			    			$("#simpleModal2").modal();
				  			//setTimeout('document.formulario.reset()',100);
				  		}
			    	});
				}
	   		}	
        </script>	
		</div>
