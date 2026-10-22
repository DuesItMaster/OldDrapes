<?php 
    $IdNombre= "29";
	$idsPermitidos = array("29", "28", "125");
	if (isset($_GET['idnombre']) && in_array($_GET['idnombre'], $idsPermitidos, true)) {
    $IdNombre = $_GET['idnombre'];
}
	//if (isset($_GET['opcion'])){ $opcion = $_GET['opcion']; }
 	include '../../conexion/wsConsumeDrapes.php';
	$Nombre = ($IdNombre == "28") ? "ONDULADO" : (($IdNombre == "125") ? "EASY WAVE" : "CS");
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cs.css" />
<!--<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.css"/>--> <!-- DRIVER.JS desactivado -->
<!--<script src="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js"></script>-->
<!--<script src="../../html/js/driverdrapes.js"></script>-->

<form class="form cortinero" method="POST" action="index.php?opcion=terminar" id="cs" name="cs">
	<!-- PRIMERA COLUMA -->
	<div class="container-left">
		<div class="card card-outlined style-default-light">
			<div class="card-head">
				<h3><?php 
					if ($IdNombre == "28") {
						echo "Cortinero CS Ondulado";
					}
					else if ($IdNombre == "29") {
						echo "Cortinero CS";
					}
					else if ($IdNombre == "125") {
						echo "Cortinero CS EasyWave";
					}
				
				
				?></h3>
			</div>
			<div class="card-body no-padding height-7">
				<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/<?php 
					if ($IdNombre == "28") {
						echo "ONDULADO.jpg";
					}
					else if ($IdNombre == "29") {
						echo "CORTINEROCS.jpg";
					}
					else if ($IdNombre == "125") {
						echo "EASYWAVEBACKDROP.jpg";
					}
				
				
				?>')"></div>
				
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
						<input type="number" class="form-control" id="cantidadcortinero" name="cantidadcortinero" min="1" onkeypress="ValidaSoloNumeros()" onchange="obtenerValores()" value="1" required></div>
					<label for="autocomplete1">Espacio</label>
					<input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
				</div>
				<div class="col-sm-3">
					<label for="cantidad">Ancho (mts)</label>
					<input type="number" id="anchocortinero" name="ancho" onkeypress='return NumCheck(event, this)' onchange="obtenerValores()" min=".8" max="5" step ="0.01" value="0.80" required>
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
								echo "<option value='" . htmlspecialchars($valor, ENT_QUOTES) . "'>" . trim($valor) . "</option>";														
							}													
						?>
					</select>
					<!-- El sistema se fija desde el menú de cortineros (idnombre); se conservan los radios ocultos para el cálculo -->
					<div class="form-group" style="display:none;">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" value="29" id="sistema29" onchange="cambiarSistema(this.value);"
										
										<?php echo $IdNombre === "29" ? "checked" : ""; ?>><span>Estandar</span>
										<img src="../../assets/img/cortineros/standard.png"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" value="28" id="sistema28" onchange="cambiarSistema(this.value);" <?php echo $IdNombre === "28" ? "checked" : ""; ?>><span>Ondulado</span>
										<img src="../../assets/img/cortineros/ONDULADO.jpg"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" value="125" id="sistema125" onchange="cambiarSistema(this.value);" <?php echo $IdNombre === "125" ? "checked" : ""; ?>><span>EasyWave</span>
										<img src="../../assets/img/cortineros/Nuevo/EASYWAVE.png"/>
									</label>
								</td>
							</tr>
						</table>
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
										<input type="radio" class="MURO" name="instalacion" id="Muro" value="MURO" onchange="obtenerValores();" checked><span>Muro </span>
										<img src="../../assets/img/opciones/muro.png"/>
									</label>
								</td>	
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" class="TECHO" name="instalacion" id="Techo" value="TECHO" onchange="obtenerValores();"><span>Techo </span>
										<img src="../../assets/img/opciones/techo.png"/>
									</label>
								</td>																																					
							</tr>													
						</table>
					</div>
				</div>
				<h3>Soporte</h3>
				<table class="table table-condensed acoplamiento">
					<tr>
						<td>
							<input type="radio" name="soporte" id="fijacion" value="SENCILLO" onchange="obtenerValores();" checked ><span>Sencillo</span>
							<img src="../../assets/img/acce/cssencillo.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
							<div id="sopordoble">
								<input type="radio" name="soporte" id="fijacion2" value="DOBLE" onchange="obtenerValores();"><span>Doble</span>
								<img src="../../assets/img/acce/csdoble.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
							</div>
						</td>																										
					</tr>	
				</table>							
				<h3>ACCESORIOS</h3>
				<h3>Bastón de Fibra de Vidrio</h3>
				<div class="checkbox checkbox-styled tile-text">
					<label>
					<input type="checkbox" id="chkbaston" onchange="obtenerValores();">
					<span>Bastón</span>
					</label>
				</div>	
				<TABLE>
					<tr>
						<td>												   
							<img src="../../assets/img/acce/bastonb.jpg"  width="10px" height="130px"/>
						</td>											
					</tr>
				</TABLE>								 
				<h3>Medida del bastón</h3>
				<TABLE>
					<tr>
						<td>
							<input type="radio" name="medida" id="bastonUnoP1" onchange="obtenerValores();" value=".9" checked><span>90cm</span>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
							<input type="radio" name="medida" id="bastonUnoP2" onchange="obtenerValores();" value="1.22" ><span>1.22m</span>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>	
						<td>
							<input type="radio" name="medida" id="bastonUnoP3" onchange="obtenerValores();" value="1.5" ><span>1.5m</span>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
							<input type="radio" name="medida" id="bastonUnoP4" onchange="obtenerValores();" value="1.83" ><span>1.83m</span>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
					</tr>	
				</TABLE>				
			</div>	
			<div class="panel_inferior" style="color: white;">
				<div id="precios">
					<div id="precio_total" class="precio_total" style="color: white;">
						<div id="resultado">
							<label class="label_total" style="color: white;">Precio Total</label>
							<label class="label_cantidad" style="color: white;">$0.00</label>
							<input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right; color: white;' type="hidden" readonly>
						</div>
					</div>
				</div>
				<div id="cargando" style="display:none; color: green;">Cargando...</div>
				<div class="msjModal" id="cargando2" style="display:none; color: red;">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>
				<div id="BtnD"><button type="button" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
			</div>
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
		
		function disabledRadiosBaston() {
			color = $("#SelectColor option:selected").val();
			if (color == 'BLANCO') {
				$('#1.83').attr('disabled', true);
			}
			else {
				$('#1.83').attr('disabled', false);
			}
		}

		function cambiarSistema(idNombre)
		{
			    // Actualizar imagen de fondo
				var imagenes = {
					"28": "../../assets/img/cortineros/cortineros2/CORTINEROCSONDULADO.jpg",
					"29": "../../assets/img/cortineros/cortineros2/CORTINEROCS.jpg",
					"125": "../../assets/img/cortineros/cortineros2/EASYWAVEBACKDROP.jpg"
				};
				$(".img-backdrop").css("background-image", "url('" + imagenes[idNombre] + "')");

				// Actualizar título
				var titulos = {
					"28": "Cortinero CS Ondulado",
					"29": "Cortinero CS",
					"125": "Cortinero CS EasyWave"
				};
				$(".card-head h3").text(titulos[idNombre]);

				// Actualizar rutaImg para el carrito
				rutaImg = imagenes[idNombre];

				// Recalcular precio con el nuevo sistema sin recargar página
				obtenerValores();
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
		var radioMedida;
		//var radioMaterial="Fibra de Vidrio";
		var radioMaterial="ACRILICO";
		var baston;
		var valorBaston;
		var colorBaston="BLANCO";
		var Color="N/A";
		/*var rutaImg="../../assets/img/cortineros/CS.jpg";*/
		const imagenesSistema = {
			"28": "../../assets/img/cortineros/cortineros2/CORTINEROCSONDULADO.jpg",
			"29": "../../assets/img/cortineros/cortineros2/CORTINEROCS.jpg",
			"125": "../../assets/img/cortineros/cortineros2/CORTINEROCSEASYWAVE.jpg"
		};
		var rutaImg = imagenesSistema[<?php echo $IdNombre; ?>];
		var tipolinea="N";
		var TipoArticuloDetalle;
		var area;
		var resultadoHojas;
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
			Nombre = $("input[name='sistema']:checked").val();
			if(Nombre == "125" && parseFloat(anchoinicial) <= 0.80){
				$("#anchocortinero").val("1.00");
				anchoinicial = 1.00;
			}

			if(Nombre == "28" || Nombre == "29"){
				if(parseFloat(anchoinicial) == 1.0){
					$("#anchocortinero").val("0.80");
					anchoinicial = 0.80;
				}
			}
			anchoinicial = parseFloat(anchoinicial).toFixed(2);
			anchomod = (Math.ceil(parseFloat(anchoinicial) * 10) / 10).toFixed(2);
			$("#anchocortinero").val(anchoinicial);
			Nombre = $("input[name='sistema']:checked").val();
			TipoArticuloDetalle = (Nombre == "125") ? "easywave" : ((Nombre == "28") ? "ondulado" : "cs");
			color= $("#SelectColor option:selected").html();
			var colorEnvio = color;
			argollaBool="N/A";
			resultadoRemate="N/A";
			resultadoSistema = (Nombre == "28") ? "ONDULADO" : (Nombre == "125") ? "EASY WAVE" : "ESTANDAR";
			decorativo="NO";
			peso=0;

			//obtener fijacion
		   var radioFijacion=document.getElementsByName("instalacion");
			for(var i=0;i<radioFijacion.length;i++){
		            if(radioFijacion[i].checked)
		               resultadoFijacion=radioFijacion[i].value;									               
		    }

		    if(resultadoFijacion=="TECHO"){
		    	$("#sopordoble").css("display", "none");
		    	$("#fijacion").prop("checked", true);									    	
		    }
		    else if(resultadoFijacion=="MURO"){
		    	$("#sopordoble").css("display", "inline");									    	
		    }
			
			var radioHojas=document.getElementsByName("hoja");
			for(var i=0;i<radioHojas.length;i++){
		            if(radioHojas[i].checked)
		               resultadoHojas=radioHojas[i].value;									               
		    }

			//OBTENER SOPORTE
			var radioSoporte=document.getElementsByName("soporte");
			for(var i=0;i<radioSoporte.length;i++){
		            if(radioSoporte[i].checked)
		               resultadoSoporte=radioSoporte[i].value;
		    }
		    radioMedida= $("input[name='medida']:checked").val();
		    baston=document.getElementById("chkbaston").checked;


		    if(baston==false){										  
		      valorBaston = "NO";
		    }
		    else {
		    	valorBaston = "SI";
		    }

		    if (color == 'NEGRO')
		    {
		    	colorBaston = 'NEGRO';
		    }
		    else
		    {
		    	colorBaston = 'BLANCO';
		    }

			/*if(color == 'BLANCO'){
				//$('#bastonUnoP4').attr('disabled',false);
			}else{
				$('#bastonUnoP4').attr('disabled',true);
				//$('#bastonUnoP4').attr('checked',false);
				//$('#bastonUnoP1').attr('checked',true);
			}*/

			//se implemento este cambio ya que en SAP no existen los bastones de 1.83 para el color Plata/Silver ni el Negro
			if(color === 'BLANCO'){
				$('#bastonUnoP4').attr('disabled',false);
			}else{
				$('#bastonUnoP4').attr('disabled',true);
				//$('#bastonUnoP4').attr('checked',false);
				//$('#bastonUnoP1').attr('checked',true);
			}

			if(color === 'NEGRO' || color === 'SILVER'){
				if($('#bastonUnoP4').is(':checked')){
					$('#bastonUnoP1').prop('checked', true);
				}
				$('#bastonUnoP4').attr('disabled',true);
			}
			

		    resHojas=$("input[name='control']:checked").val();
			radioMedida= $("input[name='medida']:checked").val();
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
				console.log("Para el caso de Easy Wave argolla envia 'NO' porque asi esta definido en SAP"); //WTF XDDDD estandaricen los templates de SAP
				console.log("Fijacion:", resultadoFijacion);
				console.log("Color Baston:", colorBaston);
				console.log("Radio Medida:", radioMedida);
				console.log("Radio Material:", radioMaterial);
				console.log("Decorativo:", decorativo);
				console.log("Peso:", peso);
				//console.log("Control Motorizado:", controles);
				//console.log("Nombre Control:", controlNombre);
				//console.log("Motor Lado:", resultadoMotor);
				//console.log("Codo Curveado:", codoCurveado);
				//console.log("Lado Motor:", resultadoMotor);
				//console.log("Cantidad Codos:", cantidadCodos);
				console.log(" Tipo (Curvo/Recto): ", $("input[name='curvoRecto']:checked").val() || "No definido (Se asumirá RECTO)");
				console.log("Tipo de soporte:", resultadoSoporte); 

					
        	/*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
			$.post("../fnc/cortinero.php", 
			{ 
			doblar:"SI", resHojas:resultadoHojas, ancho:anchomod, color:colorEnvio, tipo:Nombre,remate:resultadoRemate, resultadoSistema:resultadoSistema,
			soporte:resultadoSoporte,argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,
			radioMaterial:radioMaterial,baston:baston,valorBaston:valorBaston,decorativo:decorativo, peso:peso, resHojas:resHojas
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
							doblar:"SI", resHojas:resultadoHojas, ancho:anchomod, color:colorEnvio, tipo:Nombre,remate:resultadoRemate, 
							resultadoSistema:resultadoSistema, soporte:resultadoSoporte,argolla:argollaBool,fijacion:resultadoFijacion,
							colorBaston:colorBaston, radioMedida:radioMedida, radioMaterial:radioMaterial,baston:baston,valorBaston:valorBaston,
							decorativo:decorativo, peso:peso, resHojas:resHojas
						}, function(data)
						{
							$("#resultado").html(data);

							validacionesResultado();

							if (!bloqueado)
							{
								precioRecalculado2 = $("#resultadoSuma").val();

								if (precioRecalculado1 != precioRecalculado2 || costoFinal != precioRecalculado1)
								{	
									bloquearCotizar("Se detectaron problemas de conexi�n que podr�an afectar el c�lculo del costo de su cotizaci�n, favor de recargar la p�gina.", true);
								}
								else
								{	
									$("#cs").submit();
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
				bloquearCotizar("La configuraci�n actual del art�culo esta relacionada con dos c�digos de art�culo, favor de notificar a su agente de ventas.", true);
			}
			else if ($("#codigoBaston").val() == "multiBaston")
			{
				bloquearCotizar("La configuraci�n actual del art�culo esta relacionada con dos c�digos de bast�n, favor de notificar a su agente de ventas.", true);
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

			$("#cs").submit(function()
			{
				Cantidad = $("#cantidadcortinero").val();
			    precioFinal = costoFinal;//este es el precio final
				codigoBaston = $("#codigoBaston").val();
				precioBaston = $("#valorBaston").val();
				cantidadHojas=$("input[name='hoja']:checked").val();
				control= $("input[name='control']:checked").val();
				fijacion= $("input[name='instalacion']:checked").val();
			    nombreCorti = (Nombre == "28") ? "CORTINERO ONDULADO" : (Nombre == "125") ? "CORTINERO EASYWAVE" : "CORTINERO CS";
				tipoarticulo="cortinero";
				codigo = $("#CodigoCortinero").val();
				area=$("#autocomplete1").val();	
			    
			    id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoBaston;	

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
					tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:parseFloat(anchoinicial).toFixed(2), color:color, fijacion:fijacion,
					cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
					remate:resultadoRemate,resultadoSistema:resultadoSistema,
					soporte:resultadoSoporte,argolla:argollaBool,codigoBaston:codigoBaston,
					baston:baston, colorBaston:colorBaston, radioMedida:radioMedida,radioMaterial:"Fibra de Vidrio",tipolinea:tipolinea,
					TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston,
					cantidadBastonFija:cantidadBastonFija
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
</form>