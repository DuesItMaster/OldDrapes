<?php	
    $IdNombre =91;
	if (isset($_GET['opcion'])){ $opcion = $_GET['opcion']; }
	include '../../conexion/wsConsumeDrapes.php';
	$Nombre = "CCS";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/ccs.css" />

<form class="form" method="POST" action="index.php?opcion=terminar" id="ccs" name="ccs">
	<!-- PRIMERA COLUMA -->
	<div class="container-left">
		<div class="card card-outlined style-default-light">
			<div class="card-head">
				<h3><?php echo  $Nombre; ?></h3>
			</div>
			<div class="card-body no-padding height-7">
				<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/CCS.jpg')"></div>
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
					<input type="number" id="anchocortinero" name="ancho" onkeypress='return NumCheck(event, this)' onchange="obtenerValores()" onkeyup="obtenerValores()" min=".8" max="5" step ="0.01" value=".8" required>
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
										<input type="radio" id="insta" name="instalacion" value="MURO" id="Muro" onchange="validarSoporte();" checked><span>Muro </span>
										<img src="../../assets/img/opciones/muro.png"/>
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled">
										<input type="radio" id="insta" name="instalacion" value="TECHO" id="Techo" onchange="validarSoporte();"><span>Techo </span>
										<img src="../../assets/img/opciones/techo.png"/>
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
							<th><h4>Muro</h4></th>	
							<tr>
								<td>
									<label class="radio-inline radio-styled" id="soporteSenchillo">
										<input type="radio" name="soporte" id="fijacion" value="SENCILLO" onchange="obtenerValores();" checked ><span>Sencillo</span>
										<img src="../../assets/img/acce/cssencillo.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</label>
								</td>
								<td>
									<label class="radio-inline radio-styled" id="sopordoble">
										<input type="radio" name="soporte" id="fijacion" value="DOBLE" onchange="obtenerValores();"><span>Doble</span>
										<img src="../../assets/img/acce/csdoble.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									</label>
								</td>																										
							</tr>	
							<th><h4>Techo</h4></th>	
							<tr>
								<td>
									<label class="radio-inline radio-styled" id="soporteTecho">
										<input type="radio" name="soporte" id="fijacion" value="SENCILLO" onchange="obtenerValores();" disabled = 'false'><span>Sencillo</span>
										<img src="../../assets/img/acce/cssTecho.jpg"  width="80px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									<label>
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
										<img src="../../assets/img/cortineros/standard.png"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									<label>
								</td>
								<!--<td>
										<input type="radio" name="sistema" id="ONDULADO" value="ONDULADO" onchange="obtenerValores();"><span>Ondulado</span>
										<img src="../../assets/img/cortineros/ONDULADO.jpg"  width="100px" height="50px"/>&nbsp;&nbsp;&nbsp;&nbsp;
									<label>
								</td>-->																										
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
	<script>
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
	<script src="../js/ccs.js?v=1"></script>	
	<!-- END JAVASCRIPT -->		
</form>