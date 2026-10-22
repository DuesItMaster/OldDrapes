<?php 
    $IdNombre =31;
	if (isset($_GET['opcion'])){  $opcion = $_GET['opcion']; } 
?>

<head>
	<?php include '../../conexion/wsConsumeDrapes.php';?>
	<script>
		function col(color){
			if(color=="CAFE OSCURO") {
			    	$("#CAFEOSCURO").prop("checked", true);
			    	$("#ARGCAFEOSCURO").prop("checked", true);
					$("#chkbaston").attr('disabled', false);
		    }
		    else if(color=="NATURAL") {
			    	$("#NATURAL").prop("checked", true);
			    	$("#ARGNATURAL").prop("checked", true);
					$("#chkbaston").attr('disabled', false);
		    	}
			else if(color=="NEGRO") {
			    	$("#NEGRO").prop("checked", true);
			    	$("#ARGNEGRO").prop("checked", true);
					$("#chkbaston").attr('disabled', false); //esta opcion estaba en true 200722, 200922 se actualiza a false
		    }
			else if(color=="DORADO") {
			    	$("#DORADO").prop("checked", true);
			    	$("#ARGDORADO").prop("checked", true);
					$("#chkbaston").attr('disabled', true); //esta opcion estaba en true 200722
					$("#chkbaston").prop("checked", false);
		    }

			}
	</script>

	<title>TUBULAR</title>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="your,keywords">
	<meta name="description" content="Short explanation about this website">
	<!-- END META -->

	<!-- BEGIN STYLESHEETS -->
	<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap.css?1422792965" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/animacion/slider.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/back/back.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466319" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/typeahead/typeahead.css?1424887863" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/select2/select2.css?1424887856" />
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
</head>

<body class="menubar-hoverable header-fixed " onload="obtenerValores();">
	<form class="form" method="POST" action="index.php?opcion=terminar" id="tubularsoe" name="tubularsoe">
	   <div id="content">
			<section>
				<div class="section-body contain-lg">
					<!-- BEGIN SECTION -->
					<div class="doc-section">
						<div class="col-lg-offset-1 col-md-5 col-sm-6">
							<div class="card">
								<div class="card-body">
									<div class="form-group">													
										<label for="regular1">Tipo de cortinero elegido: "TUBULAR"	</label>												
									</div>
									<img class="img-responsive" src="../../assets/img/cortineros/TUBULARES.jpg">
									<div class="form-group">
									<label><b>Selecciona un color</b></label>								
										<select class="form-control" id="SelectColor" name="SelectColor" onchange="obtenerValores();">												
										   <?php										   
											   $rescolor=colores($IdNombre);	
												foreach ($rescolor as $valor) {														
													echo "<option value='". $valor."'>".trim($valor)."</option>";														
												}													
										 	?>
										</select>
									</div>							
									<div id="tiras"><h3>Espacio</h3></div>
									<div class="form-group">
										<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio" required>
									</div>
									<div id="tiras"><h3>Precio</h3></div>							
									<div id="resultado">
										<div class='form-group'> <input id='Precio' class='form-control' name='Precio' value='<?php echo $precioP; ?>' style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>
									</div>
									<div id="tiras"><h3>Ancho</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<input type="number" onchange="obtenerValores();" class="form-control" id="anchocortinero" onkeyup="obtenerValores();" min="1" max="5" step ="0.01" value="1">
												<label for="dollars10">Ancho del cortinero</label>
											</div>
											<span class="input-group-addon">mts</span>
										</div>
									</div>	
									<div id="tiras"><h3>Cantidad de hojas</h3></div>
									<div class="form-group">
										<div class="input-group">
											<TABLE>
												<tr>
													<td>
														<input type="radio" name="hoja" value="1IZQUIERDA" id="1IZQUIERDA" onchange="obtenerValores();" checked><span>1 Izquierda  </span>
														<img src="../../assets/img/opciones/izquierda.png"  width="50px" height="50px"/>
													</td>
													<td>
														<input type="radio" name="hoja" value="1DERECHA" id="1DERECHA" onchange="obtenerValores();"><span> 1 Derecha </span>
														<img src="../../assets/img/opciones/derecha.png"  width="50px" height="50px"/>
													</td>
													<td>
														<input type="radio" name="hoja" value="2HOJAS" id="2HOJAS" onchange="obtenerValores();"><span>2 Hojas </span>
														<img src="../../assets/img/opciones/Ambas.png"  width="50px" height="50px"/>
													</td>													
												</tr>	
											</TABLE>
										</div>
									</div>											
	                                <div id="tiras"><h3>Control</h3></div>
									<div class="form-group">
										<div class="input-group">
											<TABLE>
											    <tr>
													<td>
														<input type="radio" name="control" value="Izquierda" id="Izquierda" onchange="obtenerValores();" checked><span>&nbsp;Izquierdo &nbsp;</span>
														<img src="../../assets/img/opciones/izquierda.png"  width="50px" height="50px"/>
													</td>
													<td>
													    <input type="radio" name="control" value="Derecha" id="Derecha" onchange="obtenerValores();"><span>&nbsp;Derecho&nbsp;</span>
														<img src="../../assets/img/opciones/derecha.png"  width="50px" height="50px"/>
													</td>
													<td>
													    <input type="radio" name="control" value="Ambos" id="Ambos" onchange="obtenerValores();"><span>&nbsp;Ambos&nbsp;</span>
														<img src="../../assets/img/opciones/derecha.png"  width="50px" height="50px"/>
													</td>										
												</tr>													
											</TABLE>                                                  
										</div>
									</div>

									<div id="tiras"><h3>Instalación</h3></div>	
									<div class="form-group">
										<div class="input-group">
											<TABLE>
												<tr>
													<td>
														<input type="radio" class="MURO" name="instalacion" value="MURO" onchange="validarSoportes();" checked><span>Muro </span>
														<img src="../../assets/img/opciones/muro.png"  width="50px" height="50px"/>
													</td>	
													<td>
														<input type="radio" class="TECHO" name="instalacion" value="MURO" onchange="validarSoportes();"><span>Techo </span>
														<img src="../../assets/img/opciones/techo.png"  width="50px" height="50px"/>
													</td>																																					
												</tr>													
											</TABLE>
										</div>
									</div>
									<br>		
								</div><!--end .form-group -->
							</div><!--end .card-body -->
						</div><!--end .card -->
						<div class="col-lg-offset-1 col-md-5 col-sm-6">
							<div class="card">
								<div class="card-body">
									<div id="tiras"><h3>Tipo de remate</h3></div> <br>		
				                    <div class="form-group">
										<div class="input-group">	
											<TABLE>
												<tr>
													<td>
														<input type="radio" name="remate" value="TAPON" id="TAPON" onchange="obtenerValores();" checked ><span>Tapón</span>
														<img src="../../assets/img/acce/tapon.jpg"  width="50px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td>
														<input type="radio" name="remate" value="ESFERA" id="ESFERA" onchange="obtenerValores();" ><span>Esfera</span>
														<img src="../../assets/img/acce/esfera.jpg"  width="50px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>	
													<td>
														<input type="radio" name="remate" value="CILINDRO" id="CILINDRO" onchange="obtenerValores();" ><span>Cilindro</span>
														<img src="../../assets/img/acce/cilindro.jpg"  width="60px" height="50px"/>
													</td>
												</tr>
												<tr>	
													<td>
														<input type="radio" name="remate" value="DISCO" id="DISCO" onchange="obtenerValores();" ><span>Disco</span>
														<img src="../../assets/img/acce/disco.jpg"  width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td>
														<input type="radio" name="remate" value="TAMBOR" id="TAMBOR" onchange="obtenerValores();" ><span>Tambor</span>
														<img src="../../assets/img/acce/tambor.jpg"  width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td>
														<input type="radio" name="remate" value="BARREL" id="BARREL" onchange="obtenerValores();" ><span>Barrel</span>
														<img src="../../assets/img/acce/barrel.jpg"  width="60px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>											
												</tr>
											</TABLE>                        
									  </div>
									</div>
									<div id="tiras"><h3>Soporte</h3></div>
									<TABLE>	
										<th><h3>Sencillo</h3></th>								
										<tr>											
											<td>
												<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOESTANDAR" checked><span>Estandar</span>
												<img src="../../assets/img/acce/sencillotub.jpg"  width="50px" height="60px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOSAUL"><span>Saul</span>
												<img src="../../assets/img/acce/sencilloSaul.jpg"  width="50px" height="60px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOEDGAR"><span>Edgar</span>
												<img src="../../assets/img/acce/sencilloEdgar.jpg"  width="50px" height="60px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>																																
										</tr>
										<tr>
											<td>
												<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" class= "SENCILLOESTANDARTECHO" disabled = "true"><span>Estandar Techo</span>
												<img src="../../assets/img/acce/sencilloTechoTubular.jpg"  width="50px" height="60px"/>
											</td>
										</tr>
										<th><h3>Doble</h3></th>
										<tr>
											<td>
												<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();" class= "DOBLEESTANDAR"><span>Estandar</span>
												<img src="../../assets/img/acce/dobletub.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											
											<td>
												<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();" class= "DOBLESAUL" ><span>Saul</span>
												<img src="../../assets/img/acce/dobleSaul.jpg"  width="50px" height="70px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>	
											<td>
												<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();" class= "DOBLEEDGAR" ><span>Edgar</span>
												<img src="../../assets/img/acce/dobleEdgar.jpg"  width="50px" height="70px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>	
										</tr>										
									</TABLE>         			
									<div id="tiras"><h3>Argolla 2"</h3></div> <br>
									<div class="checkbox checkbox-styled tile-text">
										<label>
											<input type="checkbox" id="chkargolla" onchange="obtenerValores();">
											<span>Argolla</span>
										</label>
									</div>		
									<TABLE>
										<tr>
											<td>
												<input type="radio" id="ARGNATURAL" name="argolla" value="NATURAL" onchange="obtenerValores();" checked><span>Natural</span>
												<img src="../../assets/img/acce/argollanat.jpg"  width="50px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" id="ARGCAFEOSCURO" name="argolla" onchange="obtenerValores();" value="CAFE OSCURO"><span>Café oscuro</span>
												<img src="../../assets/img/acce/argollacaf.jpg"  width="50px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>	
											<td>
												<input type="radio" id="ARGNEGRO" name="argolla" onchange="obtenerValores();" value="NEGRO"><span>Negro</span>
												<img src="../../assets/img/acce/argollanegro.jpg"  width="50px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" id="ARGDORADO" name="argolla" onchange="obtenerValores();" value="DORADO"><span>Dorado</span>
												<img src="../../assets/img/acce/argolladorado.jpg"  width="50px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>																									
										</tr>
									</TABLE>
								   <div id="tiras"><h3>Bastón en acero inoxidable</h3></div> <br>
								   <div class="checkbox checkbox-styled tile-text">
									 <label>
										<input type="checkbox" id="chkbaston" onchange="obtenerValores();">
										<span>Bastón</span><p>Nota: El bastón no es funcional si no lleva argolla</p>
									 </label>
								   </div>	
									<TABLE>
										<tr>
											<td>
											    <input type="radio" name="colorbaston" id="NATURAL" value="NATURAL" onchange="obtenerValores();" checked><span>Natural</span>
												<img src="../../assets/img/acce/bastonb.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" name="colorbaston" id="CAFEOSCURO" value="CAFE OSCURO" onchange="obtenerValores();"><span>Café oscuro</span>
												<img src="../../assets/img/acce/bastoncaf.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>	
											<td>
												<input type="radio" name="colorbaston" id="NEGRO" value="NEGRO" onchange="obtenerValores();"><span>Negro</span>
												<img src="../../assets/img/acce/bastonnegro.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" name="colorbaston" id="DORADO" value="DORADO" onchange="obtenerValores();"><span>Dorado</span>
												<img src="../../assets/img/acce/bastondorado.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>										
										</tr>
									</TABLE>								 
									<label><b><h3>Medida del bastón</h3></b></label> <br>
									<TABLE>
										<tr>
											<td>
										    	<input type="radio" name="medida" id="bastonUnoP1" onchange="obtenerValores();" value="1" checked><span>1m</span>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<input type="radio" name="medida" id="bastonUnoP2" onchange="obtenerValores();" value="1.2" ><span>1.2m</span>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>	
											<td>
												<input type="radio" name="medida" id="bastonUnoP3" onchange="obtenerValores();" value="1.5" ><span>1.5m</span>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>																				
										</tr>	
									 </TABLE>
									<div id="tiras"><h3>Cantidad</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<input type="number" class="form-control" name="cantidadcortinero" id="cantidadcortinero" min="1" onchange="obtenerValores();" value="1">
												<label for="dollars10">Cantidad de cortineros</label>
											</div>
											<span class="input-group-addon">unidad</span>
										</div>
									</div>								
									<div id="resultado4"></div>
									<div id="cargando" style="display:none; color: green;">Cargando...</div>
									<div class="msjModal" id="cargando2" style="display:none; color: red;">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>
									<div id="BtnD" ><button type="button" id="BotonEnviar" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;">Agregar</button></div>
											
									<div class="modal fade" id="msj" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
										<div class="modal-dialog">
											<div class="modal-content">
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
													<h4 class="modal-title" id="simpleModalLabel">Información</h4>
												</div>
												<div class="modal-body">
													<p class="msjModal">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</p>
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>													
												</div>
											</div><!-- /.modal-content -->
										</div><!-- /.modal-dialog -->
									</div><!-- /.modal -->			
								</div>
							</div><!--end .form-group -->
						</div><!--end .card-body -->
					</div><!--end .card -->
				</div>
			</section>
		</div>	

		<script>	
			function disabledRadios(radioHojasCheckedValue) {
				if (radioHojasCheckedValue == '2HOJAS') {
					$('#Derecha').attr('disabled', true);
					$('#Izquierda').attr('disabled', true);
					$('#Ambos').attr('disabled', false);
					$("#Ambos").attr('checked', true);
				} 
				else if(radioHojasCheckedValue == '1DERECHA'){
					$('#Derecha').attr('disabled', true);
					$('#Ambos').attr('disabled', true);
					$('#Izquierda').attr('disabled', false);
					$("#Izquierda").attr('checked', true);
				}
				else if(radioHojasCheckedValue == '1IZQUIERDA'){
					$('#Ambos').attr('disabled', true);
					$('#Izquierda').attr('disabled', true);
					$('#Derecha').attr('disabled', false);
					$("#Derecha").attr('checked', true);
				}

			}	

		    var costoFinal=0;
		    precioRecalculado1 = 0;
			precioRecalculado2 = 0;					  

		    var costoCortinero=0;
		    var anchoinicial=0;
		    var Nombre;
		    var color;
		    var resultadoSistema;
		    var decorativo;
		    var peso;
		    var	argollaBool;							    
		    var resultadoRemate;
		    var resultadoSoporte;
		    //var radioMedida="1.2";
		    var radioMaterial="ACERO INOXIDABLE";
		    var baston;
		    var valorBaston;
		    var rutaImg="../../assets/img/cortineros/TUBULARES.jpg";
		    var tipolinea="N";
		    var TipoArticuloDetalle;
		    var area;
		    var cantBaston=0;
			var cantidadBastonFija = 0;
		    var resHojas;

		    bloqueado = false;
		    
			function validarSoportes()
			{				
				/*resultadoFijacion =  $("input[name='instalacion']:checked").parent().text();
				resultadoFijacion = resultadoFijacion.trim();*/

				   //obtener fijacion
				var radioFijacion=document.getElementsByName("instalacion");
				for(var i=0;i<radioFijacion.length;i++) {
		            if(radioFijacion[i].checked)
		                resultadoFijacion=radioFijacion[i].className;
				}

				/*Alejandro*/
				if (resultadoFijacion == 'MURO') {
				    $("input[class='SENCILLOESTANDAR']").attr("disabled",false);
					$("input[class='SENCILLOSAUL']").attr("disabled",false);
					$("input[class='SENCILLOEDGAR']").attr("disabled",false);
					$("input[class='DOBLEESTANDAR']").attr("disabled",false);
					$("input[class='DOBLESAUL']").attr("disabled",false);
					$("input[class='DOBLEEDGAR']").attr("disabled",false);
					$("input[class='SENCILLOESTANDARTECHO']").attr("disabled",true);
					$("input[class='SENCILLOESTANDAR']").prop('checked', 'cheked');
					/*$(this).find('input[type="radio"]').prop('checked','checked');*/
			    }
				if (resultadoFijacion == 'TECHO'){
					$("input[class='SENCILLOESTANDAR']").attr("disabled",true);
					$("input[class='SENCILLOSAUL']").attr("disabled",true);
					$("input[class='SENCILLOEDGAR']").attr("disabled",true);
					$("input[class='DOBLEESTANDAR']").attr("disabled",true);
					$("input[class='DOBLESAUL']").attr("disabled",true);
					$("input[class='DOBLEEDGAR']").attr("disabled",true);
					$("input[class='SENCILLOESTANDARTECHO']").attr("disabled", false);		
					$("input[class='SENCILLOESTANDARTECHO']").prop('checked', 'cheked');	
				}
				obtenerValores();
			}
			function obtenerValores(hacerRecalculo = false)
			{						
				permitirCotizar();

				if ($("#anchocortinero").val().length == 0)
				{
					bloquearCotizar("Favor de capturar el ancho deseado para el cortinero.", false);

					return;
				}

				if ($("#anchocortinero").val() >= 2.31)
				{
					if ($("input[name='hoja']:checked").val() != "2HOJAS"){
							
							bloquearCotizar("En medidas superiores a 2.3 mt no es posible tener una sola hoja...", false);

							return;
						}
					
				}

				radioHojasCheckedValue = $("input[name='hoja']:checked").val();
				disabledRadios(radioHojasCheckedValue);						
				color= $("#SelectColor option:selected").html();
				col(color);						   									
			    anchoinicial=document.getElementById('anchocortinero').value;
			    anchomod=Math.ceil( anchoinicial * 10 )/10;
			    Nombre = "<?php echo $IdNombre;?>";
			    TipoArticuloDetalle	= "<?php echo $opcion;?>";									    								   
			    //color=document.getElementById("SelectColor").value;
			    resultadoSistema="ESTANDAR";
			    decorativo="SI";
			    peso=0;		

			    //obtener argolla checada
			    var argollaChecada=document.getElementById("chkargolla").checked;	
			  	if (argollaChecada==true){
				    argollaBool="SI";										    
			  	} else{
			  		argollaBool="NO";	    
			  	}
			       //obtener fijacion
				var radioFijacion=document.getElementsByName("instalacion");
				for(var i=0;i<radioFijacion.length;i++) {
		            if(radioFijacion[i].checked)
		                resultadoFijacion=radioFijacion[i].value;
				}

				   //obtener remate
			    var radioRemate=document.getElementsByName("remate");
				for(var i=0;i<radioRemate.length;i++) {
		            if(radioRemate[i].checked)
		                resultadoRemate=radioRemate[i].value;
			    }
				        //OBTENER SOPORTE
				var radioSoporte=document.getElementsByName("soporte");
				for(var i=0;i<radioSoporte.length;i++) {
		            if(radioSoporte[i].checked)
		                resultadoSoporte=radioSoporte[i].value;
		            //alert(resultadoSoporte);
				}
				        //OBTENER ARGOLLA
			    var radioArgolla=document.getElementsByName("argolla");
				for(var i=0;i<radioArgolla.length;i++) {
		            if(radioArgolla[i].checked)
		                resultadoArgolla=radioArgolla[i].value;
			    }


			    Color= $("input[name='colorbaston']:checked").val();
			    radioMedida= $("input[name='medida']:checked").val();
			    baston=document.getElementById("chkbaston").checked;


			    if(baston==false){
			      valorBaston = "NO";
			    }
			    else {
			    	valorBaston = "SI";
			    }

				resHojas=$("input[name='control']:checked").val();
				console.log(resHojas);
			   $("#cargando").css("display", "inline");
               $("#BtnD").css("display", "none");
						
				/*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
				$.post("../fnc/cortinero.php", 
				{ 
					ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
					argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,baston:baston,
					valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
				}, function(data)
				{
	    			$("#resultado").html(data);

					validacionesResultado();

			    	if (!bloqueado)
			    	{
			    		if (hacerRecalculo)
		    			{
		    				precioRecalculado1 = $("#resultadoSuma").val();

		    				$.post("../fnc/cortinero.php", 
							{ 
								ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema,
								soporte:resultadoSoporte, argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,
								radioMaterial:radioMaterial,baston:baston, valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
							}, function(data)
							{
						    	$("#resultado").html(data);

						    	validacionesResultado();

						    	if (!bloqueado)
						    	{
						    		precioRecalculado2 = $("#resultadoSuma").val();

						    		if (precioRecalculado1 != precioRecalculado2 || costoFinal != precioRecalculado1)
									{	
										bloquearCotizar("Se detectaron problemas de conexión que podrían afectar el cálculo del costo de su cotización, favor de recargar la página.", true);
									}
									else
									{	
										$("#tubularsoe").submit();
									}
						    	}
					    	});
		    			}
		    			else
		    			{
		    				costoFinal = $("#resultadoSuma").val();

		    				permitirCotizar();
		    			}
			    	}
	    		});									    												 
			}

			function validacionesResultado()
			{
				if ($("#CodigoCortinero").val() == "multiCortinero")
	    		{
	    			bloquearCotizar("La configuración actual del artículo esta relacionada con dos códigos de artículo, favor de notificar a su agente de ventas.", true);
	    		}
	    		else if ($("#codigoBaston").val() == "multiBaston")
	    		{
	    			bloquearCotizar("La configuración actual del artículo esta relacionada con dos códigos de bastón, favor de notificar a su agente de ventas.", true);
	    		}
	    		else if ($("#resultadoVacio").val() == 0)
	    		{
	    			bloquearCotizar("Este articulo no se encuentra dado de alta, favor de notificar a su agente de ventas.");
	    		}
			}

			function bloquearCotizar(mensaje, mostrarModal = false)
			{
				$(".msjModal").html(mensaje);
				$("#cargando").css("display", "none");
				$("#BtnD").css("display", "none");

				if (mostrarModal)
				{
					$("#msj").modal();
				}

				$("#cargando2").css("display", "inline");

				bloqueado = true;
			}

			function triggerModal(mensaje)
			{
				$(".msjModal").html(mensaje);

				$("#msj").modal();
			}

			function permitirCotizar()
			{
				bloqueado = false;

				$("#cargando2").css("display", "none");
    			$("#cargando").css("display", "none");
                $("#BtnD").css("display", "inline");
			}

			$(document).ready(function()
			{
				$("#BotonEnviar").click(function()
				{
					if ($("#autocomplete1").val().length == 0)
					{
						triggerModal("Favor de especificar el espacio.");

						return;
					}

					obtenerValores(true);
				});

				$("#msj").on('hidden.bs.modal', function()
				{
					$("#autocomplete1").focus();
			    });

				$("#tubularsoe").submit(function() 
				{
				    Cantidad = $("#cantidadcortinero").val();
				    precioBaston = $("#valorBaston").val();
				    precioFinal = costoFinal;//este es el precio final
				    codigoBaston = $("#codigoBaston").val();
				    cantidadHojas=$("input[name='hoja']:checked").val();
				    control= $("input[name='control']:checked").val();
				    fijacion= $("input[name='instalacion']:checked").parent().text();
				    nombreCorti="CORTINERO TUBULAR";
				    tipoarticulo="cortinero";
				    codigo = $("#CodigoCortinero").val();
				    area=$("#autocomplete1").val();
					textoSoporte =  $("input[name='soporte']:checked").parent().text();
					textoSoporte = textoSoporte.trim();
					fijacion = fijacion.trim();
					fijacion =  fijacion.toUpperCase();
					codigoBastonID ="";			
					
					if(codigoBaston != null){
						codigoBastonID = codigoBaston.replace("\"","");
					}
				    id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoBastonID;				  	

				    if(baston==true){
					    if(cantidadHojas == "2HOJAS"){
					    	cantBaston=2;
					    	if(resultadoSoporte=="DOBLE"){
					    		cantBaston=4;
					    	}
					    }
					    else{
					    	cantBaston=1;
					    	if(resultadoSoporte=="DOBLE"){
					    		cantBaston=2;
					    	}
					    }
				    }

					cantidadBastonFija = cantBaston;
				    cantBaston=cantBaston * Cantidad;
				    precioBaston=precioBaston * Cantidad;
					resultadoSoporte = resultadoSoporte + " " + textoSoporte.toUpperCase();					
				    $.post("LlenarCarrito.php",
				    {
				    	id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo, tipoarticulo:tipoarticulo, ruta:rutaImg,
				    	ancho:anchoinicial, color:color, fijacion:fijacion, cantidadHojas:cantidadHojas, control:control, decorativo:decorativo,
				    	peso:peso, remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,argolla:argollaBool,
				    	codigoBaston:codigoBaston, baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,
				    	tipolinea:tipolinea, TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston,
						cantidadBastonFija:cantidadBastonFija
					}, function(){ });	 			  
				});
			});
		</script>	
		<!-- BEGIN JAVASCRIPT -->
	    <script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>		
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		
		<!-- END JAVASCRIPT -->		
	</form>
</body>