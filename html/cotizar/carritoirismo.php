<html>
<?php
	
    $IdNombre =95;
    if (isset($_GET['ancho']) && $_GET['ancho']<>"" ){
    			$anch=$_GET['ancho'];
    			$area=$_GET['area'];
    			$acoplamiento=$_GET['acoplamiento'];
    			$cantidad=$_GET['cantidad'];
    			$fijacion=$_GET['fijacion'];
    			$sistema=$_GET['sistema'];

    				echo "<input type='hidden' id='opCortina' value='SI'>";

    			    echo "<input type='text' id='opFijacion' value='".$fijacion."'>";
    				echo "<input type='hidden' id='opAncho' value='".$anch."'>";
					echo "<input type='hidden' id='opArea' value='".$area."'>";
					echo "<input type='hidden' id='opAcoplamiento' value='".$acoplamiento."'>";
					echo "<input type='hidden' id='opCantidad' value='".$cantidad."'>";
					echo "<input type='hidden' id='opSistema' value='".$sistema."'>";
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
					echo "<input type='hidden' id='opAncho' value='".$producto["ancho"]."'>";
					echo "<input type='hidden' id='opHojas' value=".$producto["cantidadHojas"].">";
					echo "<input type='hidden' id='opControl' value=".$producto["control"].">";
					echo "<input type='hidden' id='opFijacion' value='".$producto["fijacion"]."'>";	
					echo "<input type='hidden' id='opArea' value='".$producto["area"]."'>";				
					
					//echo "<input type='hidden' id='opSoporte' value='".$producto["soporte"]."'>";
					echo "<input type='hidden' id='opSistema' value='".$producto["resultadoSistema"]."'>";
					echo "<input type='hidden' id='opMotor' value='".$producto["lado_motor"]."'>";
					echo "<input type='hidden' id='opKilos' value='".$producto["peso"]."'>";					
					echo "<input type='hidden' id='opCantidad' value='".$producto["cantidad"]."'>";
					
					echo "<input type='hidden' id='opchkcontroles' value='".$producto["controlMot"]."'>";					
					echo "<input type='hidden' id='optipoControlMot' value='".$producto["tipoControlMot"]."'>";
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
	function CambiarCombo(){			
             Kilos = $("#opKilos").val();
             $('#SelectPeso option').filter(function () 
             	{ return $(this).html() == Kilos; }).attr("selected", "selected");
             //alert(Kilos);
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
			//Soporte = $("#opSoporte").val();	
			Sistema = $("#opSistema").val();
			Acoplamiento = $("#opAcoplamiento").val();
			Cortina = $("#opCortina").val();	

			controlMot = $("#opchkcontroles").val(); 	
			tipoControl =	$("#optipoControlMot").val(); 	
						
				
			 //$("#"+Fijacion+"").prop("checked", true);	
			 $("#"+Hojas+"").prop("checked", true);
			 $("#"+Control+"").prop("checked", true);			 
			 //$("#"+Soporte+"").prop("checked", true);
			 $("#"+Sistema+"").prop("checked", true);

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
			 if(Fijacion=="MURO"){ 
			 $("#Muro").prop("checked", true);
			 $("#Techo").attr('disabled', true);
			 }
			 else if(Fijacion=="TECHO"){ 
			 $("#Techo").prop("checked", true);
			 $("#Muro").attr('disabled', true);
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

			valMotor = $("#opMotor").val();
			if(valMotor == "Derecho"){
				$("#motor_right").prop("checked", true);
			}else{
				$("#motor_left").prop("checked", true);
			}

			if(controlMot == "true"){
				$("#chkcontroles").prop("checked", true);
				$("input[name=controlCortinero]").each(function() {					
					if(tipoControl == $(this).val()){
						$(this).prop("checked", true);
						
					}
				});

			}
		}
</script>
		<title>IRISMO WIREFREE</title>

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
  	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>

  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
	</head>
		

<body class="menubar-hoverable header-fixed" onload="obtenerValores();">
<form class="form" method="POST" action="index.php?opcion=terminar" id="irismo" name="irismo">
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
													<label for="regular1">Tipo de cortinero elegido: IRISMO WIREFREE	</label>
												</div>

												<img class="img-responsive" src="../../assets/img/cortineros/IRISMO.jpg">

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
														echo "<input type='number' onkeyup='obtenerValores();' class='form-control' id='anchocortinero' min='1' max='5' step ='0.01' value='1'>";
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
													<input type="radio" name="hoja" value="1DERECHA" id="1DERECHA" onchange="obtenerValores();" checked><span> 1 Derecha </span>
													<img src="../../assets/img/opciones/derecha.png"  width="50px" height="50px"/>
													</td>
													<td>
													<input type="radio" name="hoja" value="2HOJAS" id="2HOJAS" onchange="obtenerValores();" checked><span>2 Hojas </span>
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
														
										</div><!--end .form-group -->
									</div><!--end .card-body -->
								</div><!--end .card -->

									<div class="col-lg-offset-1 col-md-5 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div id="tiras"><h3>Instalación</h3></div>	
										      <div class="form-group">
													<div class="input-group">

											<TABLE>
												<tr>
													<td>
													<input type="radio" id="Muro" name="instalacion" value="MURO" onchange="obtenerValores();" checked><span>Muro </span>
													<img src="../../assets/img/opciones/muro.png"  width="70px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td>
												   	<input type="radio" id="Techo" name="instalacion" value="TECHO" onchange="obtenerValores();"><span>Techo </span>
													<img src="../../assets/img/opciones/techo.png"  width="70px" height="50px"/>
													</td>
																									
												</tr>													
											</TABLE>

														</div>
												</div>

									<div id="tiras"><h3>Lado del motor</h3></div>	
									<div class="form-group">
									<div class="input-group">
										<TABLE>
											<tr>
												<td>
													<input type="radio" id="motor_right" name="motor_lado" value="Derecho" onchange="" checked><span>Derecho </span>
													<img src="../../assets/img/opciones/lado_derecho_irismo.png"  width="70px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
													&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
												</td>
												<td>
													<input type="radio" id="motor_left" name="motor_lado" value="Izquierdo" onchange=""><span>Izquierdo </span>
													<img src="../../assets/img/opciones/lado_izquierdo_irismo.png"  width="70px" height="50px"/>
												</td>											
											</tr>												
										</TABLE>
									</div>
									</div>	

									<div id="tiras" style="display: none" ><h3>Soporte</h3></div>
									<TABLE style="display: none">
										<tr>
											<td>
										    	<input type="radio" name="soporte" id="fijacion" value="SENCILLO" onchange="obtenerValores();" checked ><span>Sencillo</span>
												<img src="../../assets/img/acce/cssencillo.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
											</td>
											<td>
												<!--<div id="sopordoble">
													<input type="radio" name="soporte" id="fijacion2" value="DOBLE" onchange="obtenerValores();"><span>Doble</span>
													<img src="../../assets/img/acce/csdoble.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
												</div>-->
											</td>																										
										</tr>	
									</TABLE>	                                        

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
											
											<div id="tiras"><h3>Controles Remotos</h3></div> <br>
											<div class="checkbox checkbox-styled tile-text">
												<label>
													<input type="checkbox" id="chkcontroles" onchange="obtenerValores();">
													<span>Control Remoto</span>
												</label>
											</div>	
											<TABLE>
												<tr>
													<td>
														<input type="radio" name="controlCortinero" value="CONTROL PARED" onchange="obtenerValores();"><span> Pared</span>
														<img src="../../assets/img/cortineros/CONTROL PARED.jpg"  width="100px" height="100px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>
													<td>
														<input type="radio" name="controlCortinero" value="SITUO" onchange="obtenerValores();"><span> Situo</span>
														<img src="../../assets/img/cortineros/SITUO.jpg"  width="100px" height="100px"/>&nbsp;&nbsp;&nbsp;&nbsp;
													</td>										
												</tr>
											</TABLE>

											 <div id="tiras"><h3>Peso maximo</h3></div>
											 <div class="form-group">											
												<select class="form-control" id="SelectPeso" name="SelectPeso" onchange="obtenerValores();">												
												 <optgroup label="Peso:">
														<option value="45">45</option>							
													</optgroup>
												</select>
												<label><b>Selecciona un peso maximo en kilos</b></label>
										<script type="text/javascript">
										  CambiarCombo();
										</script>
											</div>
										
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
										</div><!--end .form-group -->	
							</div>
				</div>
			</div>
			</div>
			</div>
		</section>
	</div>


       <script>
	   		/*function disabledRadios(radioHojasCheckedValue) {
				if (radioHojasCheckedValue == '2HOJAS') {
					$('#Derecha').attr('disabled', true);
					$('#Izquierda').attr('disabled', true);
					$("#Ambos").attr('checked', true);
				} else {
					$('#Derecha').attr('disabled', false);
					$('#Izquierda').attr('disabled', false);
				}
			}*/
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
			var resultadoMotor;
		    //var resultadoSoporte;
		    var radioMedida;
		    var radioMaterial;
		    var baston;
		    var valorBaston;
		    var colorBaston;
		    var Color="N/A";
		    var rutaImg="../../assets/img/cortineros/IRISMO.jpg";
		    var tipolinea="N";
		    var TipoArticuloDetalle="irismo";
		    var area;

			//Controles 
			var controlMot
			var controles
			var controlNombre

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
			    peso=document.getElementById("SelectPeso").value;								   
			    Nombre = "<?php echo $IdNombre;?>" ;
			    //TipoArticuloDetalle	= "<?php echo $opcion;?>";										   
			    color="BLANCO";
			    argollaBool="N/A";
			    resultadoRemate="N/A";								    
			    decorativo="NO";
			    valorBaston="NO";
			    radioMedida="N/A";
			    radioMaterial="N/A";
			    colorBaston="N/A";
			    baston=false;
				controlMot = false;	

		       //obtener fijacion
			   var radioFijacion=document.getElementsByName("instalacion");
				for(var i=0;i<radioFijacion.length;i++){
			            if(radioFijacion[i].checked)
			               resultadoFijacion=radioFijacion[i].value;									               
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

				//OBTENER Motor
			    var radioMotor=document.getElementsByName("motor_lado");
				for(var i=0;i<radioMotor.length;i++){
			            if(radioMotor[i].checked)
			                resultadoMotor=radioMotor[i].value;
			    }

				// OBTENER CONTROLES
				controlMot = document.getElementById("chkcontroles").checked;
				if(controlMot){
					controles = "SI"
					controlNombre = $("input[name='controlCortinero']:checked").val();
				}
				else {
					controles = "NO"
					controlNombre = "";
				}

			$("#cargando").css("display", "inline");
            $("#BtnD").css("display", "none");

				        /*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
				$.post("../fnc/cortinero.php", 
				{ 
					ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
					argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,radioMaterial:radioMaterial,
					decorativo:decorativo,peso:peso, controlMotorizado:controles, controlMotNombre:controlNombre, motor: resultadoMotor
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
								argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,
								decorativo:decorativo,peso:peso, controlMotorizado:controles, controlMotNombre:controlNombre, motor: resultadoMotor
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
										$("#irismo").submit();
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

				$("#irismo").submit(function() 
				{
				    Cantidad = $("#cantidadcortinero").val();
				    precioFinal = costoFinal;//este es el precio final
				    codigoBaston = $("#codigoBaston").val();
				    cantidadHojas=$("input[name='hoja']:checked").val();
				    control= $("input[name='control']:checked").val();
				    fijacion= $("input[name='instalacion']:checked").val();
				    nombreCorti="CORTINERO MOTORIZADO IRISMO WIREFREE";
				    tipoarticulo="cortinero";
				    codigo = $("#CodigoCortinero").val();
				    idllega=$("#opID").val();
				    area=$("#autocomplete1").val();		
					soporte = $("input[name='soporte']:checked").val();

					precioControl = $("#valorControl").val();
				    codigoControl = $("#codigoControl").val();
					nombreControl = $("#nombreControl").val();
				    
				    if(idllega=="nuevo"){
				    	id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoControl;
				    }	
				    else {
				    	id=$("#opID").val();
				    }			
				    						    		   
				    $.post("LlenarCarrito.php",{id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo,
				                                tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:anchoinicial, color:color, fijacion:fijacion,
				                                cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
				                                remate:resultadoRemate,resultadoSistema:resultadoSistema,soporte:soporte, argolla:argollaBool,												
												baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,tipolinea:tipolinea,
												TipoArticuloDetalle:TipoArticuloDetalle,area:area, controlMot:controlMot, precioControl:precioControl, 
												codigoControl:codigoControl, nombreControl:nombreControl, tipoControlMot:controlNombre, motor: resultadoMotor
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