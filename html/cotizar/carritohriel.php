<html>
<?php
    $IdNombre =39;
    if (isset($_GET['ancho']) && $_GET['ancho']<>"" ){
    			$anch=$_GET['ancho'];
    			$area=$_GET['area'];
    			$acoplamiento=$_GET['acoplamiento'];
    			$cantidad=$_GET['cantidad'];
    			$sistema=$_GET['sistema']; 
    			$fijacion=$_GET['fijacion'];
    			    
    				echo "<input type='hidden' id='opCortina' value='SI'>";

    				echo "<input type='hidden' id='opAncho' value='".$anch."'>";
					echo "<input type='hidden' id='opArea' value='".$area."'>";
					echo "<input type='hidden' id='opAcoplamiento' value='".$acoplamiento."'>";
					echo "<input type='hidden' id='opCantidad' value='".$cantidad."'>";
					echo "<input type='hidden' id='opSistema' value='".$sistema."'>";
					echo "<input type='hidden' id='opFijacion' value='".$fijacion."'>";
    		}


    if (isset($_GET['i']) && $_GET['i']<>"" ){
    	$yes = "SI";
		include_once '../clases/Carrito.class.php';
		$carrito = new Carrito();
		$carro = $carrito->get_content();

		if($carro){ 
			foreach($carro as $producto){
				if ($producto["id"]==$_GET['i']){					
					echo "<input type='hidden' id='opID' value='".$producto["id"]."'>";
					echo "<input type='hidden' id='opColor' value='".$producto["color"]."'>";
					echo "<input type='hidden' id='opAncho' value='".$producto["ancho"]."'>";
					echo "<input type='hidden' id='opArea' value='".$producto["area"]."'>";

					echo "<input type='hidden' id='opHojas' value=".$producto["cantidadHojas"].">";
					echo "<input type='hidden' id='opControl' value=".$producto["control"].">";
					echo "<input type='hidden' id='opFijacion' value='".$producto["fijacion"]."'>";					
					
					echo "<input type='hidden' id='opSoporte' value='".$producto["soporte"]."'>";
					echo "<input type='hidden' id='opSistema' value='".$producto["resultadoSistema"]."'>";

					echo "<input type='hidden' id='opBastonchk' value='".$producto["baston"]."'>";
					echo "<input type='hidden' id='opBastoncolor' value='".$producto["colorBaston"]."'>";					
					echo "<input type='hidden' id='opCantidad' value='".$producto["cantidad"]."'>";
					echo "<input type='hidden' id='opBastonmedida' value='".$producto["radioMedida"]."'>";
					
				}
			}
		}
	}
	else{
		echo "<input type='hidden' id='opID' value='nuevo'>";
	}
?>

<head>
	<?php include '../../conexion/wsConsumeDrapes.php';?>
	<script>
	
	function col(color){
		if(color=="ANTIQUE") {
			$("#CAFEOSCURO").prop("checked", true);
		}
		else if(color=="SATIN") {
			    $("#NATURAL").prop("checked", true);
		}
		//else if(color=="NEGRO") {
		//	$("#NEGRO").prop("checked", true);
		//}
	}	

	function CambiarCombo(){			
            Color = $("#opColor").val(); 

             $('#SelectColor option').filter(function () 
             	{ return $(this).html() == Color; }).attr("selected", "selected");

				 col(color);            
		}
		
		function CambiarNumber(){
			 ancho = $("#opAncho").val();
             cantidad = $("#opCantidad").val();
             AREA = $("#opArea").val();
 
             $("#anchocortinero").val(ancho);
             $("#cantidadcortinero").val(cantidad);
             $("#autocomplete1").val(AREA);
		}

		function CambiarRadio(){
			Fijacion = $("#opFijacion").val();
			Hojas = $("#opHojas").val();			
			Control = $("#opControl").val();			
		    BastonColor = $("#opBastoncolor").val();
			Soporte = $("#opSoporte").val();	
			Sistema = $("#opSistema").val();
			Acoplamiento = $("#opAcoplamiento").val();
			Fijacion = $("#opFijacion").val();
			Cortina = $("#opCortina").val();	

			BastonMedida = $("#opBastonmedida").val();
			if(BastonMedida=="1"){
			  $("#bastonUnoP1").prop("checked", true);	
			 }
			 if(BastonMedida=="1.2"){
			  $("#bastonUnoP2").prop("checked", true);	
			 }	
			 if(BastonMedida=="1.5"){
			  $("#bastonUnoP3").prop("checked", true);	
			 }						
				
			 //$("#"+Fijacion+"").prop("checked", true);	
			 $("#"+Hojas+"").prop("checked", true);
			 $("#"+Control+"").prop("checked", true);			 
			 $("#"+Soporte+"").prop("checked", true);
			 $("#"+Sistema+"").prop("checked", true);
			 
			 if(BastonColor=="CAFE OSCURO"){
			 	$("#CAFEOSCURO").prop("checked", true);
			 }	 
			  if(BastonColor=="NATURAL"){
			 	$("#NATURAL").prop("checked", true);
			 }
			 if(BastonColor=="NEGRO"){
			 	$("#NEGRO").prop("checked", true);
			 }

			 //alert("hriel");

			 //solo entra si---datos vienen de cortina
			 if(Cortina=="SI"){ 
				 if(Sistema=="Ond"){
			 	$("#ONDULADO").prop("checked", true);
			 	$("#ESTANDAR").attr('disabled', true);
			 }
			 else{
			 	$("#ESTANDAR").prop("checked", true);
			 	$("#ONDULADO").attr('disabled', true);
			   }
			 }

			 //bloquedo de fijación verificar si no afecta al editar carrito ya que esta es de llegada de cortinas
			 /*if(Fijacion=="MURO"){ 
				$("#Muro").prop("checked", true);
				$("#Techo").attr('disabled', true);
			}
			 else if(Fijacion=="TECHO"){ 
				 $("#Techo").prop("checked", true);
				 $("#Muro").attr('disabled', true);
			 }*/

			 if(Fijacion=="TECHO"){
				$("#Techo").prop("checked", true);
				$("#Muro").attr('disabled', true);
			    	$("#sopordoble").css("display", "none");
					$("#soportesencillo").css("display", "none");
					$("#soportesencillotecho").css("display", "inline");	
			    	$("#SENCILLOTECHO").prop("checked", true);									    	
			    }
			else if(Fijacion=="MURO"){
					$("#Muro").prop("checked", true);
					$("#Techo").attr('disabled', true);
			    	$("#sopordoble").css("display", "inline");	
					$("#soportesencillo").css("display", "inline");	
					$("#SENCILLO").prop("checked", true);	
					$("#soportesencillotecho").css("display", "none");						    	
			}


			if(Acoplamiento != undefined || "" || 0){
				if(Acoplamiento=="Izquierda"){
				    $("#1IZQUIERDA").prop("checked", true);//cant hojas
				    $("#1DERECHA").attr('disabled', true);//cant hojas
				    $("#2HOJAS").attr('disabled', true);//cant hojas
				 	
				 	$("#Derecha").prop("checked", true);//control
				 	$("#Izquierda").attr('disabled', true);
				 	$("#Ambos").attr('disabled', true);
				}
				else if(Acoplamiento=="Derecha"){
				 	$("#1DERECHA").prop("checked", true);//cant hojas
				 	$("#1IZQUIERDA").attr('disabled', true);//cant hojas
				 	$("#2HOJAS").attr('disabled', true);//cant hojas

				 	$("#Izquierda").prop("checked", true);//control
				 	$("#Derecha").attr('disabled', true);
				 	$("#Ambos").attr('disabled', true);
				}
				else if (Acoplamiento=="Ambos"){
				  	$("#Ambos").prop("checked", true);//control
				  	$("#2HOJAS").prop("checked", true);//cant hojas

				  	$("#Derecha").attr('disabled', true);
				  	$("#Izquierda").attr('disabled', true);
				  	$("#1IZQUIERDA").attr('disabled', true);//cant hojas
				  	$("#1DERECHA").attr('disabled', true);//cant hojas

				}	 
			}
		}

		function CambiarCheckbox(){			
			Bastonchk = $("#opBastonchk").val(); 
			
			//alert("tbn llega el baston loco"+Bastonchk);					
			
			if(Bastonchk=="true"){
			Bastonchk = Bastonchk.replace(/\s+/g, '');
			$("#chkbaston").prop("checked", true);
			}
			else if(Bastonchk=="false"){
			Bastonchk = Bastonchk.replace(/\s+/g, '');	
			$("#chkbaston").prop("checked", false);
			}			 
		}
</script>
		<title>H RIEL</title>

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
	<!-- <style>#slider { margin: 10px; }	</style>-->
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/typeahead/typeahead.css?1424887863" />
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/select2/select2.css?1424887856" />
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  	<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
  	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
  	

  	<!-- -->
  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
	</head>

<body class="menubar-hoverable header-fixed " onload="obtenerValores();">
	<form class="form" method="POST" action="index.php?opcion=terminar" id="hriel" name="hriel">

	<div id="content">

		<section>
			<div class="section-body contain-lg">
				<!-- BEGIN SECTION -->
				<div class="doc-section">
						<!--<a href="javascript:window.history.back();" id="Btn" style=""><i class="fa fa-chevron-left" style="padding-right: 15px;"></i> Volver </a>-->
	
							<div class="col-lg-offset-1 col-md-5 col-sm-6">
								<div class="card">
									<div class="card-body">
										
											
												<div class="form-group">
													<label for="regular1">Tipo de cortinero elegido: "H" RIEL -- Nuevo</label>
												</div>

												 <img class="img-responsive" src="../../assets/img/cortineros/H RIEL.jpg">

										
												<div class="form-group">											
												<select class="form-control" id="SelectColor" name="SelectColor" onchange="obtenerValores();">
	<?php										   
		$rescolor = colores($IdNombre);	
		foreach ($rescolor as $valor) {
			// Verificar que el valor no sea "NEGRO"
			if (trim($valor) !== "NEGRO") {
				echo "<option value='" . $valor . "'>" . trim($valor) . "</option>";														
			}
		}													
	?>
												</select>
												<label><b>Selecciona un color</b></label>
											<script type="text/javascript">
											  CambiarCombo();
										   </script>
										  </div>
											
									<div id="tiras"><h3>Espacio</h3></div>
											  <div class="form-group">
												<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio">
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
													<?php if($anch != 0){
														echo "<input type='number' readonly='readonly' class='form-control' id='anchocortinero' step ='0.01' value='".$anch."'>";
														//echo "<input type='number' class='form-control' id='an' step ='0.1' value='".$anch."'>";													
													}
													else {
														echo "<input type='number' onkeyup='obtenerValores();' class='form-control' id='anchocortinero' min='0.8' max='4.8' step ='0.01' value='0.8'>";
													}
													?>													
													<label for="anchocortinero">Ancho del cortinero</label>
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
												    <input type="radio" name="control" value="Derecha" id="Derecha" onchange="obtenerValores();" checked><span>&nbsp;Derecho&nbsp;</span>
													<img src="../../assets/img/opciones/derecha.png"  width="50px" height="50px"/>
													</td>
													<td>
												    <input type="radio" name="control" value="Ambos" id="Ambos" onchange="obtenerValores();" checked><span>&nbsp;Ambos&nbsp;</span>
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
													<input type="radio" id="Muro" name="instalacion" value="MURO" onchange="obtenerValores();" checked><span>Muro </span>
													<img src="../../assets/img/opciones/muro.png"  width="50px" height="50px"/>
													</td>
													<td>
												   	<input type="radio" id="Techo" name="instalacion" value="TECHO" onchange="obtenerValores();"><span>Techo </span>
													<img src="../../assets/img/opciones/techo.png"  width="50px" height="50px"/>
													</td>
																									
												</tr>													
											</TABLE>					
											</div>
										</div>										
									<div>										
								</div>
							</div><!--end .form-group -->
						</div><!--end .card-body -->
					  </div><!--end .card -->


							<div class="col-lg-offset-1 col-md-5 col-sm-6">
								<div class="card">
									<div class="card-body">
											
										<div id="tiras"><h3>Tipo de sistema</h3></div>		
											<TABLE>
												<tr>
													<td>
												    <input type="radio" name="sistema" id="ESTANDAR" value="ESTANDAR" onchange="obtenerValores();" checked><span>Estándar</span>
													<img src="../../assets/img/cortineros/standard.png"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td>
													<input type="radio" name="sistema" id="ONDULADO" value="ONDULADO" onchange="obtenerValores();" checked><span>Ondulado</span>
													<img src="../../assets/img/cortineros/ONDULADO.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>																										
												</tr>	
											 </TABLE>	

											<div id="tiras"><h3>Soporte</h3></div>
											<TABLE>
												<tr>
													<td>
														<div id="soportesencillo">
															<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" checked><span>Sencillo</span>
															<img src="../../assets/img/acce/sencillohriel.jpg"  width="110px" height="50px"/>
														</div>
													</td>													
													<td>
												      	<div id="sopordoble">
															<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();"><span>Doble</span>
															<img src="../../assets/img/acce/doblehriel.jpg"  width="150px" height="50px"/>
														</div>
													</td>																										
												</tr>	
												<tr>
													<td>
														<div id="soportesencillotecho">
															<input type="radio" name="soporte" id="SENCILLOTECHO" value="SENCILLO" onchange="obtenerValores();" checked><span>Sencillo Techo</span>
															<img src="../../assets/img/acce/sencillotechohriel.jpg"  width="100px" height="100px"/>
														<div>
													</td>
												</tr>	
											</TABLE>	
							
											        
                                                  			
													<div id="tiras"><h3>Bastón en acero inoxidable</h3></div> <br>
												   <div class="checkbox checkbox-styled tile-text">
													 <label>
														<input type="checkbox" id="chkbaston" onchange="obtenerValores();">
														<span>Bastón</span>
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
														<img src="../../assets/img/acce/bastonnegro.jpg"  width="10px" height="140px"/>&nbsp;&nbsp;&nbsp;&nbsp;
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
													<input type="number" class="form-control" id="cantidadcortinero" min="1" onchange="obtenerValores();" value="1">
													<label for="dollars10">Cantidad de cortineros</label>
												</div>
												<span class="input-group-addon">unidad</span>
											</div>
									</div>

									<script type="text/javascript">
											  CambiarRadio();
										   </script>

										   <script type="text/javascript">
											  CambiarNumber();
										   </script>										    

										   <script type="text/javascript">
											  CambiarCheckbox();
										   </script>

								    <div id="resultado4">	
									</div>	

									 	<?php 
									    echo"<div id='cargando' style='display:none; color: green;'>Cargando...</div>
									    	<div class='msjModal' id='cargando2' style='display:none; color: red;'>Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>";
									    	
									    	echo"<div class='modal fade' id='msj' tabindex='-1' role='dialog' aria-labelledby='simpleModalLabel' aria-hidden='true'>
												<div class='modal-dialog'>
													<div class='modal-content'>
														<div class='modal-header'>
															<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
															<h4 class='modal-title' id='simpleModalLabel'>Información</h4>
														</div>
														<div class='modal-body'>
															<p class='msjModal'>Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</p>
														</div>
														<div class='modal-footer'>
															<button type='button' class='btn btn-default' value='NEL' data-dismiss='modal'>Cerrar</button>													
														</div>
													</div><!-- /.modal-content -->
												</div><!-- /.modal-dialog -->
											</div><!-- /.modal -->";
										    echo"<div id='BtnD'><button type='button' id='BotonEnviar' class='btn btn-block ink-reaction btn-primary-light' style='font-weight: bolder';>Guardar cambios</button></div>";  
									    ?>
                                         </div>
										</div><!--end .form-group -->
									</div><!--end .card-body -->
								</div><!--end .card -->
							</div>
				</div>
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
		    var rutaImg="../../assets/img/cortineros/H RIEL.jpg";
		    var tipolinea="N";
		    var TipoArticuloDetalle="hriel";
		    var area;
		    var cantBaston=0;
			var cantidadBastonFija = 0;
		    var resHojas;

		    bloqueado = false;

		function obtenerValores(hacerRecalculo = false)
		{	
			permitirCotizar();

			if ($("#anchocortinero").val().length == 0)
			{
				bloquearCotizar("Favor de capturar el ancho deseado para el cortinero.", false);

				return;
			}

			radioHojasCheckedValue = $("input[name='hoja']:checked").val();
			disabledRadios(radioHojasCheckedValue);								
		    anchoinicial=document.getElementById('anchocortinero').value;
		    anchomod=Math.ceil( anchoinicial * 10 )/10;
		    Nombre = "<?php echo $IdNombre;?>" ;
		    //TipoArticuloDetalle	= "<?php echo $opcion;?>";										   
		    color=document.getElementById("SelectColor").value;
		    argollaBool="N/A";
		    resultadoRemate="N/A";
		    decorativo="SI";
		    peso=0;	
			col(color);	
	       //obtener fijacion
		   var radioFijacion=document.getElementsByName("instalacion");
			for(var i=0;i<radioFijacion.length;i++){
		            if(radioFijacion[i].checked)
		               resultadoFijacion=radioFijacion[i].value;									               
		    }

		    /*if(resultadoFijacion=="TECHO"){
		    	$("#sopordoble").css("display", "none");
		    	$("#SENCILLO").prop("checked", true);									    	
		    }
		    else if(resultadoFijacion=="MURO"){
		    	$("#sopordoble").css("display", "inline");									    	
		    }*/

			if(resultadoFijacion=="TECHO"){
			    $("#sopordoble").css("display", "none");
				$("#soportesencillo").css("display", "none");
				$("#soportesencillotecho").css("display", "inline");	
			    $("#SENCILLOTECHO").prop("checked", true);									    	
			}
			else if(resultadoFijacion=="MURO"){
			    $("#sopordoble").css("display", "inline");	
				$("#soportesencillo").css("display", "inline");	
				$("#soportesencillotecho").css("display", "none");	

				if($("#DOBLE").is(':checked')){
					$("#DOBLE").prop("checked", true);	
				} else {
					$("#SENCILLO").prop("checked", true);	
				}						    	
			}

		         //OBTENER SISTEMA
		    var radioSistema=document.getElementsByName("sistema");
			for(var i=0;i<radioSistema.length;i++){
		            if(radioSistema[i].checked)
		                resultadoSistema=radioSistema[i].value;
		    }
		        //OBTENER SOPORTE
		        var radioSoporte=document.getElementsByName("soporte");
			for(var i=0;i<radioSoporte.length;i++){
		            if(radioSoporte[i].checked)
		               resultadoSoporte=radioSoporte[i].value;
		    }
		   

		    Color= $("input[name='colorbaston']:checked").val();
		    baston=document.getElementById("chkbaston").checked;
		    radioMedida= $("input[name='medida']:checked").val();


		    if(baston==false){										  
		      valorBaston = "NO";
		    }
		    else {
		    	valorBaston = "SI";
		    }
		    resHojas=$("input[name='control']:checked").val();
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
							ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
							argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,
							baston:baston, valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
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
									$("#hriel").submit();
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

			$("#hriel").submit(function() 
			{
			    Cantidad = $("#cantidadcortinero").val();
			    precioFinal = costoFinal;//este es el precio final
			    codigoBaston = $("#codigoBaston").val();
			    precioBaston = $("#valorBaston").val();
			    cantidadHojas=$("input[name='hoja']:checked").val();
			    control= $("input[name='control']:checked").val();
			    fijacion= $("input[name='instalacion']:checked").val();
			    nombreCorti="CORTINERO DECORATIVO H RIEL";
			    tipoarticulo="cortinero";
			    codigo = $("#CodigoCortinero").val();
			    area=$("#autocomplete1").val();	
			    idllega=$("#opID").val();
				codigoBastonID ="";			
					
				if(codigoBaston != null){
					codigoBastonID = codigoBaston.replace("\"","");
				}
			    if(idllega=="nuevo"){
			    	id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoBaston;
			    }	
			    else {
			    	id=$("#opID").val();
			    }				
			    	

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

			    $.post("LlenarCarrito.php",{id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo,
			                                tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:anchoinicial, color:color, fijacion:fijacion,
			                                cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
			                                remate:resultadoRemate,resultadoSistema:resultadoSistema,
											soporte:resultadoSoporte,argolla:argollaBool,codigoBaston:codigoBaston,
											baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,tipolinea:tipolinea,
											TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston,
											cantidadBastonFija:cantidadBastonFija
										   }, function(){ });	   			  
			});
		});
					</script>


		<!-- BEGIN JAVASCRIPT -->
	    <script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		
		<!-- END JAVASCRIPT -->

</form>
</body>
</html>