<?php 
    $IdNombre = 126;
	if (isset($_GET['opcion'])) {
	    $opcion = $_GET['opcion'];
	}  
 	include '../../conexion/wsConsumeDrapes.php';
    $Nombre = "ELATIO"; // Variable para mostrar en título PHP
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/elatio.css" />

<form class="form" method="POST" action="index.php?opcion=terminar" id="elatio" name="elatio">
	<!-- PRIMERA COLUMA -->
	<div class="container-left">
		<div class="card card-outlined style-default-light">
			<div class="card-head">
				<h3><?php echo  $Nombre; ?></h3>
			</div>
			<div class="card-body no-padding height-7">
				<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/ELATIO.jpg')"></div>
			</div>		
		</div>	

	</div>
	<div class="container-right">
		<div class="container-right-top">
			<div class="container-right-top-tab">
				<div class="col-sm-5">
					<label for="cantidad">Cantidad de cortineros <span class="comentario_label">*Unidad</span></label>
					<div class="cantidades">
						<button type="button" id="btn_cantidad_1" onclick="seleccionarNumero('1')" class="btn_cantidad">1</button>
						<button type="button" id="btn_cantidad_2" onclick="seleccionarNumero('2')" class="btn_cantidad">2</button>
						<button type="button" id="btn_cantidad_3" onclick="seleccionarNumero('3')" class="btn_cantidad">3</button>
						<button type="button" id="btn_cantidad_4" onclick="seleccionarNumero('4')" class="btn_cantidad">4</button>
						<button type="button" id="btn_cantidad_5" onclick="seleccionarNumero('5')" class="btn_cantidad">5+</button>
						<input type="number" class="form-control" id="cantidadcortinero" name="cantidadcortinero" min="1" onkeypress="ValidaSoloNumeros()"  onchange="obtenerValores()" onkeyup="CargarValor()" value="1" required></div>
					<label for="autocomplete1">Espacio</label>
					<input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
				</div>
				<div class="col-sm-3">
					<label for="cantidad">Ancho (mts)</label>
					<input type="number" id="anchocortinero" name="ancho" onkeypress='return NumCheck(event, this)' onchange="obtenerValores()" onkeyup="obtenerValores()" min="1" max="5" step ="0.01" value="1.00" required>
				</div>
				<div class="col-sm-4">
					<label for="cantidad"></label>
					<div class="status"></div>
				</div>
			</div>
			<div class="tab-options">
				<button class="tablinks active" onclick="openTab(event,'1')" type="button">Datos Generales</button>
			</div>

			<div id="tab_1" class="tabcontent tab-bg" style="display:block;">
				<div>
					<div class="form-group">
					<h3>Selecciona un color</h3>								
					<select class="form-control" id="SelectColor" name="SelectColor" onchange="obtenerValores();">												
						<?php
							$rescolor=colores($IdNombre);	
							foreach ($rescolor as $valor) {
								?>
								<option value='<?php echo trim($valor); ?>'>
									<?php echo trim($valor); ?>
								</option>
								<?php
							}
						?>
					</select>
					</div>
					<h3>Cantidad de hojas</h3>
					<div class="">
						<div class="">
							<table class="table table-condensed acoplamiento">
								<tr>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" name="hoja" value="1IZQUIERDA" id="1IZQUIERDA" onchange="obtenerValores();" checked><span>1 Izquierda  </span>
											<img src="../../assets/img/opciones/izquierda.png"/>
										</label>
									</td>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" name="hoja" value="1DERECHA" id="1DERECHA" onchange="obtenerValores();"><span> 1 Derecha </span>
											<img src="../../assets/img/opciones/derecha.png"/>
										</label>
									</td>
									<td>
										<label class="radio-inline radio-styled">
											<input type="radio" name="hoja" value="2HOJAS" id="2HOJAS" onchange="obtenerValores();"><span>2 Hojas </span>
											<img src="../../assets/img/opciones/Ambas.png"/>
										</label>
									</td>													
								</tr>	
							</table>
						</div>
					</div>			
					<br>		
					<div id="resultado4"></div>
							
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
				<h3>VARIABLES</h3>
				<h3>Control</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="control" value="Izquierda" id="Izquierda" onchange="obtenerValores();" checked><span>&nbsp;Izquierdo &nbsp;</span>
										<img src="../../assets/img/opciones/izquierda.png"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="control" value="Derecha" id="Derecha" onchange="obtenerValores();"><span>&nbsp;Derecho&nbsp;</span>
										<img src="../../assets/img/opciones/derecha.png"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="control" value="Ambos" id="Ambos" onchange="obtenerValores();"><span>&nbsp;Ambos&nbsp;</span>
										<img src="../../assets/img/opciones/derecha.png"/>
									</label>
								</td>										
							</tr>													
						</table>                                                  
					</div>
				</div>
				<h3>Instalación</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" class="MURO" name="instalacion" value="MURO" onchange="obtenerValores();" checked><span>Muro </span>
										<img src="../../assets/img/opciones/muro.png"/>
									</label>
								</td>	
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" class="TECHO" name="instalacion" value="TECHO" onchange="obtenerValores();"><span>Techo </span>
										<img src="../../assets/img/opciones/techo.png"/>
									</label>
								</td>																																					
							</tr>													
						</table>
					</div>
				</div>
				<h3>Lado del motor</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" id="motor_right" name="motor_lado" value="Derecho" onchange="obtenerValores()" checked><span>Derecho </span>
										<img src="../../assets/img/opciones/lado_derecho.png"  width="70px" height="50px"/>
									</label>
								</td>	
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" id="motor_left" name="motor_lado" value="Izquierdo" onchange="obtenerValores()"><span>Izquierdo </span>
										<img src="../../assets/img/opciones/lado_izquierdo.png"  width="70px" height="50px"/>
									</label>
								</td>																																					
							</tr>													
						</table>
					</div>
				</div>
				<h3>Tipo de sistema</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" id="ESTANDAR" value="ESTANDAR" onchange="obtenerValores();" checked><span>Estándar</span>
										<img src="../../assets/img/cortineros/standard.png"  width="100px" height="50px"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" id="ONDULADO" value="ONDULADO" onchange="obtenerValores();"><span>Ondulado</span>
										<img src="../../assets/img/cortineros/ONDULADO.jpg"  width="100px" height="50px"/>
									</label>
								</td>
							</tr>
						</table>                        
					</div>
				</div>
				<div class="">
				<h3>Soporte</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<!--<th><h4>Muro</h4></th>-->
							<tr>
								<td>
									<!-- Opción Sencilla: value SENCILLO, data-descripcion SENCILLO -->
									<label class="radio-inline radio-styled" id="soporteSenchillo">
										<input type="radio" name="soporte" id="fijacionMuroSencillo" 
											value="SENCILLO" 
											data-descripcion="SENCILLO" 
											onchange="obtenerValores();" checked>
										<span>Sencillo</span>
										<img src="../../assets/img/acce/cssencillo.jpg" width="80px" height="50px"/>
									</label>
								</td>
								<!--<td>
									 Opción Doble: value SENCILLO (para el precio), data-descripcion DOBLE (para el texto) 
									<label class="radio-inline radio-styled" id="sopordoble">
										<input type="radio" name="soporte" id="fijacionMuroDoble" 
											value="SENCILLO" 
											data-descripcion="DOBLE" 
											onchange="obtenerValores();">
										<span>Doble</span>
										<img src="../../assets/img/acce/csdoble.jpg" width="100px" height="50px"/>
									</label>
								</td>-->
							</tr>
							<!-- ... resto del código ... -->
						</table>
					</div>
				</div>
					<h3>Codo</h3>
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="checkbox" name="codocurveado" id="codocurveado" onchange="obtenerValores();"><span>Codo Curveado</span>
										<img src="../../assets/img/acce/CODOCURVEADO.jpg"  width="80px" height="50px"/>
									</label>
								</td>
							</tr>
						</table>   
					</div>
					<div class="bloqueCodo" id="bloqueCodo">
					<h3>Cantidad de Codos</h3>
					<div class="form-group">											
						<select class="form-control" id="SelectCodo" onchange="obtenerValores();">												
							<optgroup label="Cantidad de Codos:">
								<!--<option value="0">0 Codos</option>-->   <!--Se desactivaron la opcion de 2 y 3 codos por solicitud de ventas-->
								<option value="1">1 Codo</option>
                                <!--<option value="2">2 Codos</option>-->	
								<!--<option value="3">3 Codos</option>-->								
							</optgroup>
						</select>
						<label><b>Selecciona la cantidad de codos</b></label>
					</div>
				</div>
				</div>
				<h3>Peso maximo</h3>
				<div class="form-group">											
					<select class="form-control" id="SelectPeso" onchange="obtenerValores();">												
						<optgroup label="Peso:">
							<option value="35">35 Kilos</option>
                            <option value="60">60 Kilos</option>								
						</optgroup>
					</select>
					<label><b>Selecciona un peso maximo</b></label>
				</div>
				<h3>Controles Remotos</h3>
				<div class="checkbox checkbox-styled tile-text">
					<label>
						<input type="checkbox" id="chkcontroles" onchange="obtenerValores();" checked>
						<span>Control Remoto</span>
					</label>
				</div>	
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="controlCortinero" value="CONTROL PARED" onchange="obtenerValores();" checked><span> Pared</span>
										<img src="../../assets/img/cortineros/CONTROL PARED.jpg"  width="100px" height="100px"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="controlCortinero" value="SITUO" onchange="obtenerValores();"><span> Situo</span>
										<img src="../../assets/img/cortineros/SITUO.jpg"  width="100px" height="100px"/>
									</label>
								</td>										
							</tr>
						</table>			
					</div>
				</div>
			</div>	
			<div class="panel_inferior">
				<div id="precios">
					<div id="precio_total" class="precio_total">
						<div id="resultado">
							<label class="label_total">Precio Total</label>
							<label class="label_cantidad">$0.00</label>
							<input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right;' type="hidden" readonly>
						</div>
					</div>
				</div>
				<div id="cargando" style="display:none; color: green;">Cargando...</div>
				<div class="msjModal" id="cargando2" style="display:none; color: red;">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>
				<div id="BtnD"><button type="button" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
			</div>
	</div>	
</form>
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
		var resultadoMotor;
		var decorativo;
		var peso;
		var	argollaBool;							    
		var resultadoRemate;
		//var resultadoSoporte;
		var radioMedida;
		var radioMaterial;
		var baston;
		var valorBaston;
		var colorBaston;
		var Color="N/A";
		var rutaImg="../../assets/img/cortineros/cortineros2/ELATIO.jpg";
		var tipolinea="N";
		var TipoArticuloDetalle;
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
			Nombre = "<?php echo $IdNombre;?>"; // Ajuste para enviar el nombre correcto
			TipoArticuloDetalle	= "<?php echo $_GET['opcion'];?>";										   
			//color=$("#SelectColor").val();
			color="BLANCO";
			/*color="GRIS";*/
			//argollaBool="N/A";
			argollaBool="NO";
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

			if (resultadoFijacion === 'TECHO') {
				$("#sopordoble").hide();
				$("#fijacionMuroDoble").prop("checked", false).prop("disabled", true);
				$("#fijacionMuroSencillo").prop("checked", true);
				} else {
				$("#sopordoble").show();
				$("#fijacionMuroDoble").prop("disabled", false);
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

			//OBTENER LADO DEL MOTOR
			var radioMotor=document.getElementsByName("motor_lado");
			for(var i=0;i<radioMotor.length;i++){
					if(radioMotor[i].checked)
						resultadoMotor=radioMotor[i].value;
			}
			// OBTENER CODOCURVEADO
			var codoCurveado = document.getElementById("codocurveado").checked ? "SI" : "NO";
			var cantidadCodos = 0;
			if(codoCurveado === "SI"){
				$("#bloqueCodo").show();
				cantidadCodos = parseInt(document.getElementById("SelectCodo").value, 10 ) || 0;	
			}else{
				$("#bloqueCodo").hide();
				$("#SelectCodo").val("0");
				cantidadCodos = 0;
			}

			
			if(codoCurveado === "SI" && resultadoFijacion === "MURO"){
				$("#sopordoble").hide();
			}

			$("#cargando").css("display", "inline");
                $("#BtnD").css("display", "none");

				console.log("--- Enviando datos a cortinero.php ---");
				console.log("Ancho Inicial:", anchoinicial);
				console.log("Ancho Modificado (enviado):", anchomod);
				console.log("Color:", color);
				console.log("ID Nombre (tipo):", Nombre);
				console.log("Remate:", resultadoRemate);
				console.log("Sistema:", resultadoSistema);
				console.log("Soporte:", resultadoSoporte);
				console.log("Argolla:", argollaBool);
				console.log("Fijacion:", resultadoFijacion);
				console.log("Color Baston:", colorBaston);
				console.log("Radio Medida:", radioMedida);
				console.log("Radio Material:", radioMaterial);
				console.log("Decorativo:", decorativo);
				console.log("Peso:", peso);
				console.log("Control Motorizado:", controles);
				console.log("Nombre Control:", controlNombre);
				console.log("Motor Lado:", resultadoMotor);
				console.log("Codo Curveado:", codoCurveado);
				console.log("Lado Motor:", resultadoMotor);
				console.log("Cantidad Codos:", cantidadCodos);
				console.log(" Tipo (Curvo/Recto): ", $("input[name='curvoRecto']:checked").val() || "No definido (Se asumirá RECTO)");
				console.log("Tipo de soporte:", resultadoSoporte); 
				console.log("Costo codo curveado: ", "$954.55");

				        /*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
				$.post("../fnc/cortinero.php", 
			{ 
					ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
					argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,radioMaterial:radioMaterial,
					decorativo:decorativo,peso:peso, controlMotorizado:controles, controlMotNombre:controlNombre, motor: resultadoMotor, codoCurveado:codoCurveado, cantidadCodos:cantidadCodos
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
								argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,radioMaterial:radioMaterial,
								decorativo:decorativo,peso:peso, controlMotorizado:controles, controlMotNombre:controlNombre, motor: resultadoMotor, codoCurveado:codoCurveado, cantidadCodos:cantidadCodos
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
									$("#elatio").submit();
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
			obtenerValores();
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

			$("#elatio").submit(function()
			{
				var cantidadCodos = parseInt(document.getElementById("SelectCodo").value, 10 ) || 0;
				var codoCurveado = $("#codocurveado").is(":checked") ? "SI" : "NO";
				Cantidad = $("#cantidadcortinero").val();
				precioFinal = costoFinal;//este es el precio final
				precioBaston = $("#valorBaston").val();
				codigoBaston = $("#codigoBaston").val();
				cantidadHojas=$("input[name='hoja']:checked").val();
				control= $("input[name='control']:checked").val();
				fijacion= $("input[name='instalacion']:checked").val();


				nombreCorti= $("input[name='sistema']:checked").data("descripcion") || $("input[name='sistema']:checked").val();
				if(nombreCorti==="ESTANDAR"){
					nombreCorti="CORTINERO MOTORIZADO ESTANDAR ELATIO";
					if(cantidadCodos > 0){
						nombreCorti= "CORTINERO MOTORIZADO ESTANDAR CURVEADO ELATIO";
						}
				}
				else if(nombreCorti==="ONDULADO"){
					nombreCorti="CORTINERO MOTORIZADO ONDULADO ELATIO";
					if(cantidadCodos > 0){
						nombreCorti= "CORTINERO MOTORIZADO ONDULADO CURVEADO ELATIO";
						}
				}
				


				tipoarticulo="cortinero";
				codigo = $("#CodigoCortinero").val();
				area=$("#autocomplete1").val();
				var soporteParaGuardar = $("input[name='soporte']:checked").data("descripcion");
				if(!soporteParaGuardar){
					soporteParaGuardar = $("input[name='soporte']:checked").val() || "SENCILLO";
				}
				var soporte = soporteParaGuardar;
				//soporte doble, aunque enviemos soporte sencillo nos basamos en data.descripcion para enviar un cortinero doble el soporte es meramente descriptivo
				//no existe el a techo doble
				var soporteInput = $("input[name='soporte']:checked");
				var soporteDescripcion = soporteInput.data("descripcion") || soporteInput.val();

				var Cantidad = $("#cantidadcortinero").val();

				if (soporteDescripcion === "DOBLE") {
					Cantidad = 2;
					$("#cantidadcortinero").val(2); // sincroniza UI
				}
				

				precioControl = $("#valorControl").val();
				codigoControl = $("#codigoControl").val();
				nombreControl = $("#nombreControl").val();
				
				id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoControl;	
		   
				$.post("LlenarCarrito.php",{id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo,
					tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:anchoinicial, color:color, fijacion:fijacion,
					cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
					remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:soporte,argolla:argollaBool,
					baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,tipolinea:tipolinea,
					TipoArticuloDetalle:TipoArticuloDetalle,area:area, controlMot:controlMot, precioControl:precioControl, 
					codigoControl:codigoControl, nombreControl:nombreControl, tipoControlMot:controlNombre, motor: resultadoMotor, codoCurveado:codoCurveado, cantidadCodos:cantidadCodos
				}, function(){ }); 			  
			});
		});
		function seleccionarNumero(num) {
			$(".btn_cantidad").removeClass("active");
			$("#btn_cantidad_"+num).addClass("active");
			if(num<5){
				$(".cantidades #cantidadcortinero").css("display", "none");
				$(".cantidades #cantidadcortinero").val(num);
			}
			else{
				$(".cantidades #cantidadcortinero").css("display", "inline-block");
				$(".cantidades #cantidadcortinero").val("");
			}
		}
		function openTab(evt, tab_num) {
			var i, tabcontent, tablinks;
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
			}
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
			}
			document.getElementById("tab_"+tab_num).style.display = "block";
			evt.currentTarget.className += " active";
		}
	</script>	
	<!-- BEGIN JAVASCRIPT -->
	<script src="../../assets/js/core/source/App.js"></script>
	<script src="../../assets/js/libs/select2/select2.min.js"></script>
	<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
	<script src="../../assets/js/core/demo/Demo.js"></script>
	<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
	<!-- END JAVASCRIPT -->		
