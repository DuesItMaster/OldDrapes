<?php 
    $IdNombre =30;
	if (isset($_GET['opcion'])) {
	    $opcion = $_GET['opcion'];
	}  
 	include '../../conexion/wsConsumeDrapes.php';
	$Nombre = "Curvo KS";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/curvoks.css" />

<form class="form" method="POST" action="index.php?opcion=terminar" id="curvoks" name="curvoks">
	<!-- PRIMERA COLUMA -->
	<div class="container-left">
		<div class="card card-outlined style-default-light">
			<div class="card-head">
				<h3><?php echo  $Nombre; ?></h3>
			</div>
			<div class="card-body no-padding height-7">
				<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/CURVOKS.jpg')"></div>
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
					<input type="number" id="anchocortinero" name="ancho" onkeypress='return NumCheck(event, this)' onchange="obtenerValores()" onkeyup="obtenerValores()" min=".8" max="4.9" step ="0.01" value=".8" required>
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
				<h3>Tipo de sistema</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" onchange="obtenerValores();" value="ESTANDAR" id="ESTANDAR" checked><span>Estándar</span>
										<img src="../../assets/img/cortineros/standard.png"  width="100px" height="50px"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="sistema" onchange="obtenerValores();" value="ONDULADO" id="ONDULADO"><span>Ondulado</span>
										<img src="../../assets/img/cortineros/ONDULADO.jpg"  width="100px" height="50px"/>
									</label>
								</td>													
							</tr>	
						</table>                        
					</div>
				</div>
				<h3>Soporte</h3>
				<div class="">
					<div class="">
						<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="soporte" id="SENCILLO" value="SENCILLO" onchange="obtenerValores();" checked ><span>Sencillo</span>
										<img src="../../assets/img/acce/cssencillo.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</label>
								</td>
								<td>
									<label id="sopordoble" class="radio-inline radio-styled">
										<input type="radio" name="soporte" id="DOBLE" value="DOBLE" onchange="obtenerValores();"><span>Doble</span>
										<img src="../../assets/img/acce/csdoble.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</label>
								</td>																										
							</tr>	
						</table>   
					</div>
				</div>
				<h3>Curvo o Recto</h3>
				<table class="table table-condensed acoplamiento">
							<tr>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="curvoRecto" id="RECTO" value="RECTO" onchange="obtenerValores(); "checked><span>Recto</span>
										<img src="../../assets/img/acce/Cortinero_KS_Recto.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</label>
								</td>
									<td>
									<label class="radio-inline radio-styled">
										<input type="radio" name="curvoRecto" id="CURVO" value="CURVO" onchange="obtenerValores();" ><span>Curvo</span>
										<img src="../../assets/img/acce/Cortinero_KS_Curvo.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</label>
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
				<table>
					<tr>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						</td>
						<td>
							<img src="../../assets/img/acce/bastonb.jpg"  width="10px" height="130px"/>&nbsp;&nbsp;&nbsp;&nbsp;
						</td>												
					</tr>
				</table>								 
				<h3>Medida del bastón</h3>
				<table>
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
				</table>				
				<b>Nota:</b> El cliente debe enviar plantilla.
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
		var decorativo;
		var peso;
		var	argollaBool;	
		var radioMedida;						    
		var resultadoRemate;
		var resultadoSoporte;
		var radioMaterial="ACRILICO";
		var baston;
		var valorBaston;
		var colorBaston="BLANCO";
		var Color="N/A";
		var rutaImg="../../assets/img/cortineros/CURVOKS.jpg";
		var tipolinea="N";
		var TipoArticuloDetalle;
		var area;
		var cantBaston=0;
		var cantidadBastonFija = 0;
		var resHojas;
		var resultadoHojas;

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
			TipoArticuloDetalle	= "<?php echo $opcion;?>";										   
			color="BLANCO";
			argollaBool="N/A";
			resultadoRemate="N/A";								   
			decorativo="NO";
			peso=0;							
			//obtener fijacion
			var radioFijacion=document.getElementsByName("instalacion");
				for(var i=0;i<radioFijacion.length;i++){
					if(radioFijacion[i].checked)
						resultadoFijacion=radioFijacion[i].value;									               
			}
			var radioHojas=document.getElementsByName("control");
			for(var i=0;i<radioHojas.length;i++){
					if(radioHojas[i].checked)
						resultadoHojas=radioHojas[i].value;									               
			}
					//OBTENER SISTEMA
			var radioSistema=document.getElementsByName("sistema");
			for(var i=0;i<radioSistema.length;i++){
					if(radioSistema[i].checked)
						resultadoSistema=radioSistema[i].value;
			}

			if(resultadoFijacion=="TECHO"){
				$("#sopordoble").css("display", "none");
				$("#SENCILLO").prop("checked", true);									    	
			}
			else if(resultadoFijacion=="MURO"){
				$("#sopordoble").css("display", "inline");									    	
			}

			//OBTENER SOPORTE
			var radioSoporte=document.getElementsByName("soporte");
			for(var i=0;i<radioSoporte.length;i++){
				if(radioSoporte[i].checked)
					resultadoSoporte=radioSoporte[i].value;
			}

			radioMedida= $("input[name='medida']:checked").val();
			
			var resultadoCurvoRecto = $("input[name='curvoRecto']:checked").val();
			//esta parte del codigo es solo con fines demostrativos para la documentación

			baston=document.getElementById("chkbaston").checked;
			if(baston==false){										  
			valorBaston = "NO";
			}
			else {
				valorBaston = "SI";
			}
			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");
					
			/*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
			$.post("../fnc/cortinero.php", 
			{ 
				doblar:"SI", ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema,
				soporte:resultadoSoporte,argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,
				radioMaterial:radioMaterial,baston:baston,valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resultadoHojas,
				curvoRecto:resultadoCurvoRecto
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
							doblar:"SI", ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema,
							soporte:resultadoSoporte,argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,
							radioMaterial:radioMaterial,baston:baston,valorBaston:valorBaston,decorativo:decorativo, peso:peso,
							resHojas:resultadoHojas,curvoRecto:resultadoCurvoRecto
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
									$("#curvoks").submit();
								}
							}
						});
					}
					else
					{
						costoFinal = $("#resultadoSuma").val();

						permitirCotizar();
					}
					if(resultadoCurvoRecto == "CURVO"){
				console.log("SERVICIO CURVORECTO LLAMADO")
				console.log($("#resultadoSuma").val());
				}else{
				console.log("SERVICIO CURVORECTO NO LLAMADO")
				console.log($("#resultadoSuma").val());}
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

			$("#curvoks").submit(function()
			{
				Cantidad = $("#cantidadcortinero").val();
				precioFinal = costoFinal;//este es el precio final
				codigoBaston = $("#codigoBaston").val();
				precioBaston = $("#valorBaston").val();
				cantidadHojas=$("input[name='hoja']:checked").val();
				control= $("input[name='control']:checked").val();
				fijacion= $("input[name='instalacion']:checked").val();
				nombreCorti="CORTINERO CURVO KS";
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
					tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:anchoinicial, color:color, fijacion:fijacion,
					cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
					remate:resultadoRemate,resultadoSistema:resultadoSistema,
					soporte:resultadoSoporte,argolla:argollaBool,codigoBaston:codigoBaston,
					baston:baston, colorBaston:colorBaston, radioMedida:radioMedida,radioMaterial:"Fibra de Vidrio",tipolinea:tipolinea,
					TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston,
					cantidadBastonFija:cantidadBastonFija,
					// Servicio de curveado (SERVICIO-CURV-KS) para guardarlo como renglon aparte del kit
					codigoCurva:$("#codigoCurva").val() || "", cantidadCurva:$("#cantidadCurva").val() || "", precioCurva:$("#precioCurva").val() || ""
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
		<script>
  (function () {
    function logControlesContexto(origen) {
      console.log("[CONTROLES]", origen, {
        url: window.location.href,
        ts: new Date().toISOString()
      });
    }

    document.addEventListener("DOMContentLoaded", function () {
      logControlesContexto("DOMContentLoaded");

      if (typeof obtenerValores === "function") {
        console.log("[CONTROLES] obtenerValores() existe: OK");
      } else {
        console.log("[CONTROLES] obtenerValores() NO existe en esta pantalla");
      }
    });

    window.addEventListener("load", function () {
      logControlesContexto("window.load");
    });
  })();
</script>
	<!-- END JAVASCRIPT -->