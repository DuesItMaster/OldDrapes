<!DOCTYPE html>
<html lang="es">
	<head>	
		<?php 
		include '../../conexion/cnx.php';
		include '../fnc/datosusuario.php';

		if (isset($_POST['idCot'])){ 
		    $idCot = $_POST['idCot'];
		       }		
		?>

		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="your,keywords">
		<meta name="description" content="Short explanation about this website">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/material-design-iconic-font.min.css?1421434286" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/wizard/wizard.css?1425466601" />
		<!-- END STYLESHEETS -->
	</head>
	<body class="menubar-hoverable header-fixed" onload="checa();">	
		<section>
			<div class="section-header"></div>
			<div class="section-header"></div>
			<div class="section-body contain-lg">						
				<!-- BEGIN FORM WIZARD -->
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-body ">
								<div id="rootwizard1" class="form-wizard form-wizard-horizontal">
									<form class="form floating-label">
										<div class="form-wizard-nav">
											<div class="progress">
												<div class="progress-bar progress-bar-primary"></div>
											</div>
											<ul class="nav nav-justified" onchange="checa();">
												<li class="active" ><a href="#tab1" data-toggle="tab"><span class="step">1</span> <span class="title">CLIENTE</span></a></li>
												<li onchange="checa()" onclick="checa();"><a href="#tab2" data-toggle="tab" ><span class="step">2</span> <span class="title">LUGAR DE ENVIO</span></a></li>
												<li onchange="checa()" onclick="checa();"><a href="#tab3" data-toggle="tab" ><span class="step">3</span> <span class="title">CONFIRMAR</span></a></li>
											</ul>
										</div><!--end .form-wizard-nav -->
										<div class="tab-content clearfix">
											<div class="tab-pane active" id="tab1">
												<br/><br/>
												<label for="SelectCliente"><font size="5">Elegir un cliente final&nbsp;&nbsp;</font></label>
												<select id="SelectCliente" class="form-control" onchange="checa();">
												   	<?php
													   //$IdNombre="31";
													   $resCliente=datosCliente();
													    $Filas = count($resCliente);
											            for( $i=0; $i<$Filas; $i++ ){
															echo '<option value='.$resCliente[$i]['ID'].'>'.$resCliente[$i]['NOMBRE'].'</option>';
														}							
													?>
												</select>
											   	<br><br>
											   	<div class="checkbox checkbox-styled tile-text">
												 	<label>						 	
												 		<span><font size="4">Crear nuevo cliente final&nbsp;</font></span>
														<input type="checkbox" id="nuevo_cliente" onchange="checa();">
												 	</label>
											   	</div>					   
												<div id="nuevo">
													<div class="form-group">
														<input type="text" name="cliente" id="cliente" class="form-control">
														<label for="cliente" class="control-label">Nombre</label>
														<p class="help-block">Nombre del cliente</p>
													</div>
													<div class="form-group">
														<input type="text" name="telefono" id="telefono" class="form-control">
														<label for="Telefono" class="control-label">Telefono</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="email" id="email" class="form-control">
														<label for="email" class="control-label">Correo electronico</label>
														<p class="help-block"></p>							
													</div>
													<span><center><h2>Dirección de entrega del cliente final</h2></center></span>
													<div class="form-group">
														<input type="text" name="estado" id="estado" class="form-control">
														<label for="estado" class="control-label">Estado</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="ciudad" id="ciudad" class="form-control">
														<label for="ciudad" class="control-label">Ciudad/Municipio</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="localidad" id="localidad" class="form-control">
														<label for="localidad" class="control-label">Localidad</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="colonia" id="colonia" class="form-control">
														<label for="colonia" class="control-label">Colonia</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="calle" id="calle" class="form-control">
														<label for="calle" class="control-label">Calle</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="numero" id="numero" class="form-control">
														<label for="numero" class="control-label">Numero</label>
														<p class="help-block">Numero exterior</p>
													</div>
													<div class="form-group">
														<input type="text" name="referencias" id="referencias" class="form-control">
														<label for="referencias" class="control-label">Referencias</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="cp" id="cp" class="form-control">
														<label for="cp" class="control-label">C.P.</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="sucursal" id="sucursal" class="form-control">
														<label for="sucursal" class="control-label">Sucursal</label>
														<p class="help-block"></p>
													</div>
													<div class="form-group">
														<input type="text" name="hora" id="hora" class="form-control">
														<label for="hora" class="control-label">Hora de entrada</label>
														<p class="help-block"></p>
													</div>	
													<div class="form-group">
														<input type="text" name="atencion" id="atencion" class="form-control">
														<label for="atencion" class="control-label">Atención</label>
														<p class="help-block"></p>
													</div>	
													<div class="form-group">
														<input type="text" name="contacto" id="contacto" class="form-control">
														<label for="contacto" class="control-label">Contacto</label>
														<p class="help-block"></p>
													</div>						
												</div>
												<div id="mostab1" class="table-responsive"></div>
											</div><!--end #tab1 -->
											<div class="tab-pane" id="tab2">
												<br/><br/>
												<table style="width:100%">
													<tr>
														<td>
															<div class="checkbox checkbox-styled tile-text">
													 			<label>						 	
														 			<span><font size="5">Usar mi dirección&nbsp;</font></span>
																	<input type="radio" name="dire" id="mi" value="1" onchange="checa();">
													 			</label>
												   			</div>
												   			<td>
															   	<div class="checkbox checkbox-styled tile-text">
																 	<label>						 	
																 		<span><font size="5">Dirección del cliente final&nbsp;</font></span>
																		<input type="radio" name="dire" id="dir_cliente" value="2" onchange="checa();">
																 	</label>
															   	</div>	
															</td>
												   			<tr>
															   	<td>					   
																   	<div class="checkbox checkbox-styled tile-text">
																	 	<label>						 	
																		 	<span><font size="4">Nueva dirección&nbsp;</font></span>
																			<input type="radio" name="dire" id="nueva_dir" value="3" onchange="checa();">
																	 	</label>
																   </div>
															   </td>
												   			</tr>
														</td>
													</tr>
												</table>
												<div id="new_div_dir">
												  	<div class="form-group">
														<input type="text" name="nNombre" id="nNombre" class="form-control">
														<label for="nNombre" class="control-label">Nombre dirección</label>
														<p class="help-block"></p>							
												  	</div>
													<div class="form-group">
														<input type="text" name="nCalle" id="nCalle" class="form-control">
														<label for="nCalle" class="control-label">Calle</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nNumero" id="nNumero" class="form-control">
														<label for="nNumero" class="control-label">Número</label>
														<p class="help-block">Número exterior</p>							
													</div>
													<div class="form-group">
														<input type="text" name="nColonia" id="nColonia" class="form-control">
														<label for="nColonia" class="control-label">Colonia</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nLocalidad" id="nLocalidad" class="form-control">
														<label for="nLocalidad" class="control-label">Localidad</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nEstado" id="nEstado" class="form-control">
														<label for="nEstado" class="control-label">Estado</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nMunicipio" id="nMunicipio" class="form-control">
														<label for="nMunicipio" class="control-label">Municipio</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nTelefono" id="nTelefono" class="form-control">
														<label for="nTelefono" class="control-label">Telefono</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nReferencias" id="nReferencias" class="form-control">
														<label for="nReferencias" class="control-label">Referencias</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nAtencion" id="nAtencion" class="form-control">
														<label for="nAtencion" class="control-label">Atención</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nHora" id="nHora" class="form-control">
														<label for="nHora" class="control-label">Hora de atención</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nCiudad" id="nCiudad" class="form-control">
														<label for="nCiudad" class="control-label">Ciudad</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nContacto" id="nContacto" class="form-control">
														<label for="nContacto" class="control-label">Contacto en dues</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nSucursal" id="nSucursal" class="form-control">
														<label for="nSucursal" class="control-label">Sucursal</label>
														<p class="help-block"></p>							
													</div>
													<div class="form-group">
														<input type="text" name="nCp" id="nCp" class="form-control">
														<label for="nCp" class="control-label">C.P.</label>
														<p class="help-block"></p>							
													</div>
												</div>
												<div id="mostrar2" class="table-responsive"></div>
											</div><!--end #tab2 -->
											<div class="tab-pane" id="tab3">
												<br/><br/>
												<label for="mostrarfin"><H3>Datos del cliente</H3></label>
												<div id="mostrarfin" class="table-responsive"></div>
												<br><br><br>
												<label for="mostrarfin2"><H3>Datos de envio</H3></label>
												<div id="mostrarfin2" class="table-responsive"></div>		
												<center><button type="button" class="btn ink-reaction btn-primary-light" style="font-weight: bolder;" onclick="GuardarCarrito()" >Guardar</button></center><!--onclick="checa();"-->
												<div id="prueba"></div>
											</div><!--end #tab3 -->
										</div><!--end .tab-content -->
										<ul class="pager wizard">
											<!--<li class="previous first"><a class="btn-raised" href="javascript:void(0);" onclick="checa();">Principal</a></li>
											<li class="previous"><a class="btn-raised" href="javascript:void(0);" onclick="checa();">Anterior</a></li>
											<li class="next last"><a class="btn-raised" href="javascript:void(0);" onclick="checa();">Final</a></li>
											<li class="next"><a class="btn-raised" href="javascript:void(0);" onclick="checa();">Siguiente</a></li>-->
										</ul>
									</form>
								</div><!--end #rootwizard -->
							</div><!--end .card-body -->
						</div><!--end .card -->							
					</div><!--end .col -->
				</div><!--end .row -->
				  <!-- END FORM WIZARD -->
			</div><!--end .section-body -->
		</section>
			<!-- END CONTENT -->
		<div class="modal fade" id="simpleModal1" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="simpleModalLabel">Información</h4>
					</div>
					<div class="modal-body">
						<p>Datos guardados correctamente.</p>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

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
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade" id="simpleModal3" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="simpleModalLabel">Información</h4>
					</div>
					<div class="modal-body">
						<p>Debes ingresar por lo menos el nombre del nuevo cliente</p>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<div class="modal fade" id="modal4" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="simpleModalLabel">Información</h4>
					</div>
					<div class="modal-body">
						<p>Favor de seleccionar un cliente.</p>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<?php $idAlta=$_SESSION['login_user'];?>
		
		<script>
			var idcomo;
			function enviar(id,nombre,calle,numero,colonia,localidad,estado,telefono,referencias,atencion,contacto,sucursal,hora,cp,ciudad){					
			  	//alert("llegada del id"+id);
			  	idcomo=id;				  	
			  	document.getElementById("mostrarfin2").innerHTML ="<table class='table table-banded no-margin'><tr><th>Nombre</th><th>Telefono</th><th>Estado</th><th>CD/Municipio</th><th>Localidad</th><th>Colonia</th><th>Calle</th><th>Número</th><th>Referencias</th><th>C.P.</th><th>Sucursal</th><th>Hora de entrada</th><th>Atención</th><th>Contacto</th></tr><tr><td>"
			  		+nombre+"</td><td>"+telefono+"</td><td>"+estado+"</td><td>"+ciudad+"</td><td>"+localidad+"</td><td>"
			  		+colonia+"</td><td>"+calle+"</td><td>"+numero+"</td><td>"+referencias+"</td><td>"+cp+"</td><td>"+sucursal+"</td><td>"+hora+"</td><td>"+atencion+"</td><td>"+contacto+"</td></tr></table>";
			}

            function GuardarCarrito()
            {
				if(document.getElementById('nueva_dir').checked==true)
			 	{
			 		AgregarDireccion ="SI";
			 		DireccionCliente="NO";
					n_nombre=document.getElementById("nNombre").value;
					n_calle=document.getElementById("nCalle").value;
					n_numero=document.getElementById("nNumero").value;
					n_colonia=document.getElementById("nColonia").value;
					n_localidad=document.getElementById("nLocalidad").value;
					n_estado=document.getElementById("nEstado").value;
					n_municipio=document.getElementById("nMunicipio").value;
					n_telefono=document.getElementById("nTelefono").value;
					n_referencias=document.getElementById("nReferencias").value;
					n_atencion=document.getElementById("nAtencion").value;
					n_hora=document.getElementById("nHora").value;
					n_ciudad=document.getElementById("nCiudad").value;
					n_contacto=document.getElementById("nContacto").value;
					n_sucursal=document.getElementById("nSucursal").value;	  
					n_cp=document.getElementById("nCp").value;
					idCliente="";
				}
				else if(document.getElementById('dir_cliente').checked==true)
				{
					AgregarDireccion ="NO";
					DireccionCliente="SI";
					n_nombre="";
					n_calle="";
					n_numero="";
					n_colonia="";
					n_localidad="";
					n_estado="";
					n_municipio="";
					n_telefono="";
					n_referencias="";
					n_atencion="";
					n_hora="";
					n_ciudad="";
					n_contacto="";
					n_sucursal="";	  
					n_cp="";
					idCliente = $("#SelectCliente option:selected").val();
				}
				else
				{
					AgregarDireccion ="NO";
					DireccionCliente="NO";
					n_nombre="";
					n_calle="";
					n_numero="";
					n_colonia="";
					n_localidad="";
					n_estado="";
					n_municipio="";
					n_telefono="";
					n_referencias="";
					n_atencion="";
					n_hora="";
					n_ciudad="";
					n_contacto="";
					n_sucursal="";	  
					n_cp="";
					idCliente="";
				}

				var chk=document.getElementById("nuevo_cliente").checked;

				if(chk==true)
				{
					NuevoCliente ="SI";
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
				  	idCliente = "";
				}
				else
				{
				 	NuevoCliente ="NO";
				 	//alert("Es nuevo cliente?" + NuevoCliente);
			 		cliente="";
				  	calle="";
				  	numero="";
				  	colonia="";
				  	localidad="";
				  	estado="";
				  	atencion="";
				  	hora="";
				  	ciudad="";
				  	telefono="";
				  	cp="";
				  	contacto="";
				  	sucursal="";
				  	referencias="";
				  	email="";
				  	idCliente = $("#SelectCliente option:selected").val();

				  	if (idCliente == "")
				  	{
				  		$("#modal4").modal();

				  		return;
				  	}
				}

				re=revisar();
				
				if(re==true)
				{
					$.post("../fnc/GuardarCarrito.php", { idcomo:idcomo, AgregarDireccion:AgregarDireccion, DireccionCliente:DireccionCliente,n_nombre:n_nombre,
													  n_calle:n_calle,n_numero:n_numero,n_colonia:n_colonia,n_localidad:n_localidad,n_estado:n_estado,
													  n_municipio:n_municipio,n_telefono:n_telefono,n_referencias:n_referencias,n_atencion:n_atencion,
													  n_hora:n_hora,n_ciudad:n_ciudad,n_contacto:n_contacto,n_sucursal:n_sucursal,n_cp:n_cp,idCliente:idCliente,
													  NuevoCliente:NuevoCliente,
													  cliente:cliente, calle:calle, numero:numero, colonia:colonia, localidad:localidad,
						                              estado:estado, atencion:atencion, hora:hora, ciudad:ciudad, telefono:telefono, cp:cp,
						                              contacto:contacto, sucursal:sucursal, referencias:referencias, email:email
													 }, function(data2)
					{
				   		$("#prueba").html(data2);
				   		$("#prueba").show();				   
				   		$("#simpleModal1").modal();
				  		//alert("Guardado correctamente.");
					});				  
			       	//alert("datos guardados de la manera correcta forma1 nuevo cliente solo nombre no puuede ir vacio");
				}//fin de if revision
				else if((idCliente != null || 0 || undefined || "")&&(NuevoCliente=="NO"))
				{
					$.post("../fnc/GuardarCarrito.php", { idcomo:idcomo, AgregarDireccion:AgregarDireccion, DireccionCliente:DireccionCliente,n_nombre:n_nombre,
													  n_calle:n_calle,n_numero:n_numero,n_colonia:n_colonia,n_localidad:n_localidad,n_estado:n_estado,
													  n_municipio:n_municipio,n_telefono:n_telefono,n_referencias:n_referencias,n_atencion:n_atencion,
													  n_hora:n_hora,n_ciudad:n_ciudad,n_contacto:n_contacto,n_sucursal:n_sucursal,n_cp:n_cp,idCliente:idCliente,
													  NuevoCliente:NuevoCliente,
													  cliente:cliente, calle:calle, numero:numero, colonia:colonia, localidad:localidad,
						          		              estado:estado, atencion:atencion, hora:hora, ciudad:ciudad, telefono:telefono, cp:cp,
						                              contacto:contacto, sucursal:sucursal, referencias:referencias, email:email
													 }, function(data2)
					{
				   		$("#prueba").html(data2);
				   		$("#prueba").show();					   			   
				   		//alert("Guardado correctamente.");
				   		$("#simpleModal2").modal();
					});
				   	//$("#simpleModal2").modal();
				   	//alert("datos guardados de la manera correcta forma2 el cliente ya estaba dado de alta");
				}
				else
				{
					//alert("DEBES INGRESAR POR LO MENOS EL NOMBRE DEL NUEVO CLIENTE");
					$("#simpleModal3").modal();
		        }
			}

		    var idalta = "<?php echo $idAlta; ?>";

		        function revisar(){		        	
		        		nombrecli=document.getElementById("cliente").value;
		        	  if(nombrecli!=""||null||0){
		        	  	return true;
		        	  }
		        	  else {return false;}
		        }

				function checa(){ 
					var chk=document.getElementById("nuevo_cliente").checked;
					  
				  	radioDireccion=document.getElementsByName("dire");
					
					for(var i=0;i<radioDireccion.length;i++){
				            if(radioDireccion[i].checked)
				                radioDireccion=radioDireccion[i].value;
				    }

					if(radioDireccion==3){
						document.getElementById('new_div_dir').style.display='block';   
						document.getElementById("mostrar2").style.display='none';
					 	if(document.getElementById('nueva_dir').checked==true)	{	
						
							n_nombre=document.getElementById("nNombre").value;
							n_calle=document.getElementById("nCalle").value;
							n_numero=document.getElementById("nNumero").value;
							n_colonia=document.getElementById("nColonia").value;
							n_localidad=document.getElementById("nLocalidad").value;
							n_estado=document.getElementById("nEstado").value;
							n_municipio=document.getElementById("nMunicipio").value;
							n_telefono=document.getElementById("nTelefono").value;
							n_referencias=document.getElementById("nReferencias").value;
							n_atencion=document.getElementById("nAtencion").value;
							n_hora=document.getElementById("nHora").value;
							n_ciudad=document.getElementById("nCiudad").value;
							n_contacto=document.getElementById("nContacto").value;
							n_sucursal=document.getElementById("nSucursal").value;	  
							n_cp=document.getElementById("nCp").value;

						  	document.getElementById("mostrarfin2").innerHTML ="<table class='table table-banded no-margin'><tr><th>Nombre</th><th>Telefono</th><th>Correo</th><th>Estado</th><th>CD/Municipio</th><th>Localidad</th><th>Colonia</th><th>Calle</th><th>Número</th><th>Referencias</th><th>C.P.</th><th>Sucursal</th><th>Hora de entrada</th><th>Atención</th><th>Contacto</th></tr><tr><td>"
					  		+n_nombre+"</td><td>"+n_telefono+"</td><td>"+n_estado+"</td><td>"+n_ciudad+"</td><td>"+n_localidad+"</td><td>"
					  		+n_colonia+"</td><td>"+n_calle+"</td><td>"+n_numero+"</td><td>"+n_referencias+"</td><td>"+n_cp+"</td><td>"+n_sucursal+"</td><td>"+n_hora+"</td><td>"+n_atencion
					  		+"</td><td>"+n_contacto+"</td></tr></table>";	  	  
					  		  	

						} 
					} 
					else {
							document.getElementById('new_div_dir').style.display='none';
					}

					if(radioDireccion==2){
						document.getElementById("mostrar2").style.display='block';				  	
				  		
				  		if(chk==true){
						  	
						  	//traer los datos del formulario cliente
						  	clienteA=document.getElementById("cliente").value;
							calleA=document.getElementById("calle").value;
							numeroA=document.getElementById("numero").value;
							coloniaA=document.getElementById("colonia").value;
							localidadA=document.getElementById("localidad").value;
							estadoA=document.getElementById("estado").value;
							atencionA=document.getElementById("atencion").value;
							horaA=document.getElementById("hora").value;
							ciudadA=document.getElementById("ciudad").value;
							telefonoA=document.getElementById("telefono").value;
							cpA=document.getElementById("cp").value;
							contactoA=document.getElementById("contacto").value;
							sucursalA=document.getElementById("sucursal").value;
							referenciasA=document.getElementById("referencias").value;
							emailA=document.getElementById("email").value;


							//mostrar datos cliente nuevo en tab2
					  		//document.getElementById("mostrar2").innerHTML = clienteA+"<br>"+telefonoA+"<br>"+emailA+"<br>"+estadoA+"<br>"+ciudadA+"<br>"+localidadA+"<br>"
					  		//+coloniaA+"<br>"+calleA+"<br>"+numeroA+"<br>"+referenciasA+"<br>"+cpA+"<br>"+sucursalA+"<br>"+horaA+"<br>"+atencionA+"<br>"+contactoA+"<br>";
					  		document.getElementById("mostrar2").innerHTML ="<table class='table table-banded no-margin'><tr><th>Nombre</th><th>Telefono</th><th>Correo</th><th>Estado</th><th>CD/Municipio</th><th>Localidad</th><th>Colonia</th><th>Calle</th><th>Número</th><th>Referencias</th><th>C.P.</th><th>Sucursal</th><th>Hora de entrada</th><th>Atención</th><th>Contacto</th></tr><tr><td>"
					  		+clienteA+"</td><td>"+telefonoA+"</td><td>"+emailA+"</td><td>"+estadoA+"</td><td>"+ciudadA+"</td><td>"+localidadA+"</td><td>"
					  		+coloniaA+"</td><td>"+calleA+"</td><td>"+numeroA+"</td><td>"+referenciasA+"</td><td>"+cpA+"</td><td>"+sucursalA+"</td><td>"+horaA+"</td><td>"+atencionA+"</td><td>"+contactoA+"</td></tr></table>";	  	  
					  	
					  				
					  		//aqui datos del cliente nuevo abajo
					  		document.getElementById("mostrarfin2").innerHTML ="<table class='table table-banded no-margin'><tr><th>Nombre</th><th>Telefono</th><th>Correo</th><th>Estado</th><th>CD/Municipio</th><th>Localidad</th><th>Colonia</th><th>Calle</th><th>Número</th><th>Referencias</th><th>C.P.</th><th>Sucursal</th><th>Hora de entrada</th><th>Atención</th><th>Contacto</th></tr><tr><td>"
					  		+clienteA+"</td><td>"+telefonoA+"</td><td>"+emailA+"</td><td>"+estadoA+"</td><td>"+ciudadA+"</td><td>"+localidadA+"</td><td>"
					  		+coloniaA+"</td><td>"+calleA+"</td><td>"+numeroA+"</td><td>"+referenciasA+"</td><td>"+cpA+"</td><td>"+sucursalA+"</td><td>"+horaA+"</td><td>"+atencionA+"</td><td>"+contactoA+"</td></tr></table>";	  	  
					  	
				  		}
				  		else if(chk==false){
						  	//traer los datos por medio del id del select
						  	if(document.getElementById('dir_cliente').checked==true){
							      client=document.getElementById("SelectCliente").value;					     
							  	  $.post("../fnc/datoscliente.php", {client:client}, function(data){
								    $("#mostrar2").html(data);
								    $("#mostrarfin2").html(data);						   
								       });
							}
				  		}
					}

				  	if(radioDireccion==1){
				  		document.getElementById("mostrar2").style.display='block';
				  		var id_session="<?php echo $idAlta; ?>";
				  		var idos="<?php echo $idos; ?>";
				  		if(document.getElementById('mi').checked==true){ 			  	
				  			$.post("../fnc/datosusuario.php", {id_session:id_session}, function(data){
								    $("#mostrar2").html(data);
								    //$("#mostrarfin2").html(data);
									});
								
						}
										  	
				  	}

				 	if(chk==true){
				 		document.getElementById("mostab1").hidden=true;
				   	 	document.getElementById('nuevo').style.display='block';
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

					  
				 		document.getElementById("mostrarfin").innerHTML ="<table class='table table-banded no-margin'><tr><th>Nombre</th><th>Telefono</th><th>Correo</th><th>Estado</th><th>CD/Municipio</th><th>Localidad</th><th>Colonia</th><th>Calle</th><th>Número</th><th>Referencias</th><th>C.P.</th><th>Sucursal</th><th>Hora de entrada</th><th>Atención</th><th>Contacto</th></tr><tr><td>"
					  		+cliente+"</td><td>"+telefono+"</td><td>"+email+"</td><td>"+estado+"</td><td>"+ciudad+"</td><td>"+localidad+"</td><td>"
					  		+colonia+"</td><td>"+calle+"</td><td>"+numero+"</td><td>"+referencias+"</td><td>"+cp+"</td><td>"+sucursal+"</td><td>"+hora+"</td><td>"+atencion+"</td><td>"+contacto+"</td></tr></table>";	  	  
					  	
				 	}

				//mostrar en tab 1 el cliente que sale de seleccionar en el combo
				else if(chk==false){
				 		document.getElementById("mostab1").hidden=false;
				   		document.getElementById('nuevo').style.display='none';
					    client=document.getElementById("SelectCliente").value;					     
					  	
					  	$.post("../fnc/datoscliente.php", {client:client}, function(data){
						    $("#mostab1").html(data);
						    $("#mostrarfin").html(data);						   
						       });
				}
		}//fin funcion llenar carrito


			    //DATOS DE CONFIRMACIÓN//
			    if(document.getElementById('nueva_dir').checked==true)	{
			    	  n_nombre=document.getElementById("nNombre").value;
					  n_calle=document.getElementById("nCalle").value;
					  n_numero=document.getElementById("nNumero").value;
					  n_colonia=document.getElementById("nColonia").value;
					  n_localidad=document.getElementById("nLocalidad").value;
					  n_estado=document.getElementById("nEstado").value;
					  n_municipio=document.getElementById("nMunicipio").value;
					  n_telefono=document.getElementById("nTelefono").value;
					  n_referencias=document.getElementById("nReferencias").value;
					  n_atencion=document.getElementById("nAtencion").value;
					  n_hora=document.getElementById("nHora").value;
					  n_ciudad=document.getElementById("nCiudad").value;
					  n_contacto=document.getElementById("nContacto").value;
					  n_sucursal=document.getElementById("nSucursal").value;	  
					  n_cp=document.getElementById("nCp").value;
					
					document.getElementById("mostrarfin2").innerHTML = n_nombre+"<BR>"+n_calle+"<BR>"+n_numero+"<BR>"+n_colonia+"<BR>"+n_localidad+"<BR>"+
				  		n_estado+"<BR>"+n_municipio+"<BR>"+n_telefono+"<BR>"+n_referencias+"<BR>"+n_referencias+"<BR>"+n_atencion+"<BR>"+n_hora+"<BR>"+n_ciudad+"<BR>"+n_contacto
				  		+"<BR>"+n_sucursal+"<BR>"+n_cp;


			   }
		
    </script>	

	<?php
//FUNCIÓN PARA TRAER LOS DATOS DEL SELECT PRINCIPAL
	   function datosCliente(){
			$sql = "SELECT ID_CLIENTE, NOMBRE FROM cliente WHERE ID_USUARIO_ALTA= ".$_SESSION['login_user']." 
					union select '' as ID_CLIENTE, 'Seleccione un cliente' as NOMBRE order by ID_CLIENTE ;";
			// if($_SESSION['login_user']=="2"){
			// 	$sql = "SELECT ID_CLIENTE, NOMBRE FROM cliente order by NOMBRE ASC;";
			// }else{
			// 	$sql = "SELECT ID_CLIENTE, NOMBRE FROM cliente WHERE ID_USUARIO_ALTA= ".$_SESSION['login_user']." order by NOMBRE ASC;";
			// }
			$nombreR = array();
			$result = mysqli_query($GLOBALS['db'], $sql);
			//array_push($nombreR,array('ID'=> "",'NOMBRE'=> 'Seleccione un cliente'));   

			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
			    	array_push($nombreR,array('ID'=> $row["ID_CLIENTE"],'NOMBRE'=> $row["NOMBRE"]));    
			    }
			} else {
			    
			    $a = "No hay resultados";
			}
			return $nombreR;
	    }
    ?>
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
