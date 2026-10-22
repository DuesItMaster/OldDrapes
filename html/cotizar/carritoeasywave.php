<?php
	$IdNombre = "125";	
	if (isset($_GET['ancho']) && $_GET['ancho'] <> "") {
		$anch = $_GET['ancho'];
		$area = $_GET['area'];
		$acoplamiento = $_GET['acoplamiento'];
		$cantidad = $_GET['cantidad'];
		$fijacion = $_GET['fijacion'];

		echo "<input type='hidden' id='opCortina' value='SI'>";
		echo "<input type='hidden' id='opAncho' value='" . htmlspecialchars($anch, ENT_QUOTES) . "'>";
		echo "<input type='hidden' id='opArea' value='" . htmlspecialchars($area, ENT_QUOTES) . "'>";
		echo "<input type='hidden' id='opAcoplamiento' value='" . htmlspecialchars($acoplamiento, ENT_QUOTES) . "'>";
		echo "<input type='hidden' id='opCantidad' value='" . htmlspecialchars($cantidad, ENT_QUOTES) . "'>";
		echo "<input type='hidden' id='opFijacion' value='" . htmlspecialchars($fijacion, ENT_QUOTES) . "'>";
	}

	if (isset($_GET['i']) && $_GET['i'] <> "") {
		include_once '../clases/Carrito.class.php';
		$carrito = new Carrito();
		$carro = $carrito->get_content();
		$itemEncontrado = false;

		if ($carro) {
			foreach ($carro as $producto) {
				if ($producto['id'] == $_GET['i']) {
					$itemEncontrado = true;
					echo "<input type='hidden' id='opID' value='" . htmlspecialchars(isset($producto['id']) ? $producto['id'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opUniqueID' value='" . htmlspecialchars(isset($producto['unique_id']) ? $producto['unique_id'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opAncho' value='" . htmlspecialchars(isset($producto['ancho']) ? $producto['ancho'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opHojas' value='" . htmlspecialchars(isset($producto['cantidadHojas']) ? $producto['cantidadHojas'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opControl' value='" . htmlspecialchars(isset($producto['control']) ? $producto['control'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opFijacion' value='" . htmlspecialchars(isset($producto['fijacion']) ? $producto['fijacion'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opArea' value='" . htmlspecialchars(isset($producto['area']) ? $producto['area'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opCantidad' value='" . htmlspecialchars(isset($producto['cantidad']) ? $producto['cantidad'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opColor' value='" . htmlspecialchars(isset($producto['color']) ? $producto['color'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opSoporte' value='" . htmlspecialchars(isset($producto['soporte']) ? $producto['soporte'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opBaston' value='" . htmlspecialchars(isset($producto['baston']) ? $producto['baston'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opRadioMedida' value='" . htmlspecialchars(isset($producto['radioMedida']) ? $producto['radioMedida'] : '', ENT_QUOTES) . "'>";
					echo "<input type='hidden' id='opCodigoBaston' value='" . htmlspecialchars(isset($producto['codigoBaston']) ? $producto['codigoBaston'] : '', ENT_QUOTES) . "'>";
					break;
				}
			}
		}

		if (!$itemEncontrado) {
			echo "<input type='hidden' id='opID' value='nuevo'>";
			echo "<input type='hidden' id='opUniqueID' value=''>";
		}
	} else {
		echo "<input type='hidden' id='opID' value='nuevo'>";
		echo "<input type='hidden' id='opUniqueID' value=''>";
	}

	include '../../conexion/wsConsumeDrapes.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cs.css" />

<form class="form" method="POST" action="index.php?opcion=terminar" id="carritoeasywave" name="carritoeasywave">
	<div id="content">
		<section>
			<div class="section-body contain-lg">
				<div class="doc-section">
					<div class="col-lg-offset-1 col-md-5 col-sm-6">
						<div class="card">
							<div class="card-body">
								<div class="form-group">
									<label for="regular1">Tipo de cortinero elegido:
										<?php
											if ($IdNombre == "28") {
												echo '"ONDULADO"';
											}
											else if ($IdNombre == "29") {
												echo '"CS"';
											}
											else if ($IdNombre == "125") {
												echo '"EASYWAVE"';
											}
										?>
									</label>
								</div>

								<img class="img-responsive" id="imagenSistema" src="<?php
									if ($IdNombre == "28") {
										echo '../../assets/img/cortineros/ONDULADO.jpg';
									}
									else if ($IdNombre == "29") {
										echo '../../assets/img/cortineros/cortineros2/CS.jpg';
									}
									else if ($IdNombre == "125") {
										echo '../../assets/img/cortineros/Nuevo/EASYWAVE.png';
									}
								?>" height="75px" width="auto">

								<div id="tiras"><h3>Selecciona un color</h3></div>
								<div class="form-group">
									<select class="form-control" id="SelectColor" name="SelectColor" onchange="obtenerValores();">
										<?php
											$rescolor = colores($IdNombre);
											foreach ($rescolor as $valor) {
												echo "<option value='" . htmlspecialchars(trim($valor), ENT_QUOTES) . "'>" . trim($valor) . "</option>";
											}
										?>
									</select>
								</div>

								<div id="tiras"><h3>Espacio</h3></div>
								<div class="form-group">
									<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio">
								</div>

								<div id="tiras"><h3>Precio</h3></div>
								<div id="resultado">
									<div class='form-group'>
										<input id='Precio' class='form-control' name='Precio' value='0.00' style='text-align: right;' readonly>
										<label><b>PRECIO TOTAL:</b></label>
									</div>
								</div>

								<div id="tiras"><h3>Ancho</h3></div>
								<div class="form-group floating-label">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
										<div class="input-group-content">
											<input type="number" class="form-control" id="anchocortinero" name="ancho" onchange="obtenerValores()" min=".8" max="5" step="0.01" value="0.80" required>
											<label for="anchocortinero">Ancho del cortinero</label>
										</div>
										<span class="input-group-addon">mts</span>
									</div>
								</div>

								<div id="tiras"><h3>Cantidad de hojas</h3></div>
								<div class="form-group">
									<div class="input-group">
										<table>
											<tr>
												<td>
													<input type="radio" name="hoja" value="1IZQUIERDA" id="1IZQUIERDA" onchange="obtenerValores();" checked><span>1 Izquierda</span>
													<img src="../../assets/img/opciones/izquierda.png" width="50px" height="50px"/>
												</td>
												<td>
													<input type="radio" name="hoja" value="1DERECHA" id="1DERECHA" onchange="obtenerValores();"><span>1 Derecha</span>
													<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px"/>
												</td>
												<td>
													<input type="radio" name="hoja" value="2HOJAS" id="2HOJAS" onchange="obtenerValores();"><span>2 Hojas</span>
													<img src="../../assets/img/opciones/Ambas.png" width="50px" height="50px"/>
												</td>
											</tr>
										</table>
									</div>
								</div>

								<div id="tiras"><h3>Control</h3></div>
								<div class="form-group">
									<div class="input-group">
										<table>
											<tr>
												<td>
													<input type="radio" name="control" value="Izquierda" id="Izquierda" onchange="obtenerValores();" checked><span>&nbsp;Izquierdo&nbsp;</span>
													<img src="../../assets/img/opciones/izquierda.png" width="50px" height="50px"/>
												</td>
												<td>
													<input type="radio" name="control" value="Derecha" id="Derecha" onchange="obtenerValores();"><span>&nbsp;Derecho&nbsp;</span>
													<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px"/>
												</td>
												<td>
													<input type="radio" name="control" value="Ambos" id="Ambos" onchange="obtenerValores();"><span>&nbsp;Ambos&nbsp;</span>
													<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px"/>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

						<div class="col-lg-offset-1 col-md-5 col-sm-6">
							<div class="card">
								<div class="card-body">
									<div id="tiras"><h3>Instalación</h3></div>
									<div class="form-group">
										<div class="input-group">
											<table>
												<tr>
													<td>
														<input type="radio" id="Muro" name="instalacion" value="MURO" onchange="obtenerValores();" checked><span>Muro</span>
														<img src="../../assets/img/opciones/muro.png" width="70px" height="50px"/>
													</td>
													<td>
														<input type="radio" id="Techo" name="instalacion" value="TECHO" onchange="obtenerValores();"><span>Techo</span>
														<img src="../../assets/img/opciones/techo.png" width="70px" height="50px"/>
													</td>
												</tr>
											</table>
										</div>
									</div>

									<div id="tiras"><h3>Soporte</h3></div>
									<table>
										<tr>
											<td>
												<input type="radio" name="soporte" id="fijacion" value="SENCILLO" onchange="obtenerValores();" checked><span>Sencillo</span>
												<img src="../../assets/img/acce/cssencillo.jpg" width="80px" height="50px"/>
											</td>
											<td>
												<div id="sopordoble">
													<input type="radio" name="soporte" id="fijacion2" value="DOBLE" onchange="obtenerValores();"><span>Doble</span>
													<img src="../../assets/img/acce/csdoble.jpg" width="100px" height="50px"/>
												</div>
											</td>
										</tr>
									</table>

									<!--<div id="tiras"><h3>Tipo de sistema</h3></div>
									<table>
										<tr>
											<td>
												<input type="radio" name="sistema" value="29" id="sistema29" onchange="cambiarSistema(this.value);"><span>Estandar</span>
												<img src="../../assets/img/cortineros/standard.png" width="100px" height="50px"/>
											</td>
											<td>
												<input type="radio" name="sistema" value="28" id="sistema28" onchange="cambiarSistema(this.value);"><span>Ondulado</span>
												<img src="../../assets/img/cortineros/ONDULADO.jpg" width="100px" height="50px"/>
											</td>
											<td>
												<input type="radio" name="sistema" value="125" id="sistema125" onchange="cambiarSistema(this.value);" checked><span>EasyWave</span>
												<img src="../../assets/img/cortineros/Nuevo/EASYWAVE.png" width="100px" height="50px"/>
											</td>
										</tr>
									</table>-->

									<div id="tiras"><h3>Bastón de Fibra de Vidrio</h3></div>
									<div class="checkbox checkbox-styled tile-text">
										<label>
											<input type="checkbox" id="chkbaston" onchange="obtenerValores();">
											<span>Bastón</span>
										</label>
									</div>
									<table>
										<tr>
											<td>
												<img src="../../assets/img/acce/bastonb.jpg" width="10px" height="130px"/>
											</td>
										</tr>
									</table>

									<div id="tiras"><h3>Medida del bastón</h3></div>
									<table>
										<tr>
											<td><input type="radio" name="medida" id="bastonUnoP1" onchange="obtenerValores();" value=".9" checked><span>90cm</span></td>
											<td><input type="radio" name="medida" id="bastonUnoP2" onchange="obtenerValores();" value="1.22"><span>1.22m</span></td>
											<td><input type="radio" name="medida" id="bastonUnoP3" onchange="obtenerValores();" value="1.5"><span>1.5m</span></td>
											<td><input type="radio" name="medida" id="bastonUnoP4" onchange="obtenerValores();" value="1.83"><span>1.83m</span></td>
										</tr>
									</table>

									<div id="tiras"><h3>Cantidad</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<input type="number" class="form-control" id="cantidadcortinero" min="1" onchange="obtenerValores();" value="1">
												<label for="cantidadcortinero">Cantidad de cortineros</label>
											</div>
											<span class="input-group-addon">unidad</span>
										</div>
									</div>

									<div id="resultado4"></div>
									<div id="cargando" style="display:none; color: green;">Cargando...</div>
									<div class="msjModal" id="cargando2" style="display:none; color: red;">Este articulo no se encuentra dado de alta, notificar a su agente de ventas...</div>
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
											</div>
										</div>
									</div>
									<div id="BtnD"><button type="button" id="BotonEnviar" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;">Guardar cambios</button></div>
								</div>
							</div>
						</div>
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
				$('#Ambos').prop('checked', true);
			}
			else if (radioHojasCheckedValue == '1DERECHA') {
				$('#Derecha').attr('disabled', true);
				$('#Ambos').attr('disabled', true);
				$('#Izquierda').attr('disabled', false);
				$('#Izquierda').prop('checked', true);
			}
			else if (radioHojasCheckedValue == '1IZQUIERDA') {
				$('#Ambos').attr('disabled', true);
				$('#Izquierda').attr('disabled', true);
				$('#Derecha').attr('disabled', false);
				$('#Derecha').prop('checked', true);
			}
		}

		function cambiarSistema(idNombre)
		{
			var imagenes = {
				'28': '../../assets/img/cortineros/cortineros2/ONDULADO.jpg',
				'29': '../../assets/img/cortineros/cortineros2/CS.jpg',
				'125': '../../assets/img/cortineros/Nuevo/EASYWAVEBACKDROP.jpg'
			};
			var titulos = {
				'28': 'Cortinero CS Ondulado',
				'29': 'Cortinero CS',
				'125': 'Cortinero CS EasyWave'
			};

			$('.img-backdrop').css('background-image', "url('" + imagenes[idNombre] + "')");
			$('.card-head h3').text(titulos[idNombre]);
			rutaImg = imagenes[idNombre];

			obtenerValores();
		}

		function seleccionarNumero(num) {
			$('.btn_cantidad').removeClass('active');
			$('#btn_cantidad_' + num).addClass('active');
			if (num < 5) {
				$('.cantidades #cantidadcortinero').css('display', 'none');
				$('.cantidades #cantidadcortinero').val(num);
			} else {
				$('.cantidades #cantidadcortinero').css('display', 'inline-block');
				$('.cantidades #cantidadcortinero').val('');
			}
			obtenerValores();
		}

		function openTab(evt, tab_num) {
			var i;
			var tabcontent = document.getElementsByClassName('tabcontent');
			var tablinks = document.getElementsByClassName('tablinks');

			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = 'none';
			}
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(' active', '');
			}
			document.getElementById('tab_' + tab_num).style.display = 'block';
			evt.currentTarget.className += ' active';
		}

		function CambiarNumber() {
			var ancho = $('#opAncho').val();
			var cantidad = $('#opCantidad').val();
			var area = $('#opArea').val();

			if (ancho) {
				$('#anchocortinero').val(ancho);
			}
			if (cantidad) {
				$('#cantidadcortinero').val(cantidad);
				if (parseInt(cantidad, 10) >= 1 && parseInt(cantidad, 10) <= 4) {
					$('#btn_cantidad_' + cantidad).addClass('active');
					$('.cantidades #cantidadcortinero').css('display', 'none');
				} else if (cantidad) {
					$('#btn_cantidad_5').addClass('active');
					$('.cantidades #cantidadcortinero').css('display', 'inline-block');
				}
			}
			if (area) {
				$('#autocomplete1').val(area);
			}
		}

		function CambiarRadio() {
			var fijacion = $('#opFijacion').val();
			var hojas = $('#opHojas').val();
			var control = $('#opControl').val();
			var soporte = $('#opSoporte').val();
			var acoplamiento = $('#opAcoplamiento').val();
			var baston = $('#opBaston').val();
			var radioMedida = $('#opRadioMedida').val();
			var color = $('#opColor').val();

			if (fijacion) {
				$('#' + (fijacion === 'MURO' ? 'Muro' : 'Techo')).prop('checked', true);
			}
			if (hojas) {
				$('#' + hojas).prop('checked', true);
			}
			if (control) {
				$('#' + control).prop('checked', true);
			}
			if (soporte) {
				if (soporte === 'DOBLE') {
					$('#fijacion2').prop('checked', true);
				} else {
					$('#fijacion').prop('checked', true);
				}
			}
			if (color) {
				$('#SelectColor').val(color);
			}
			if (baston === true || baston === 'true' || baston === 'SI' || baston === '1') {
				$('#chkbaston').prop('checked', true);
			}
			if (radioMedida && radioMedida !== 'N/A') {
				$('input[name="medida"][value="' + radioMedida + '"]').prop('checked', true);
			}

			if (acoplamiento) {
				if (acoplamiento == 'Izquierda') {
					$('#1IZQUIERDA').prop('checked', true);
				}
				else if (acoplamiento == 'Derecha') {
					$('#1DERECHA').prop('checked', true);
				}
				else if (acoplamiento == 'Ambos') {
					$('#2HOJAS').prop('checked', true);
				}
			}
		}

		var costoFinal = 0;
		var precioRecalculado1 = 0;
		var precioRecalculado2 = 0;
		var anchoinicial = 0;
		var anchomod = '1.00';
		var Nombre = '125';
		var color;
		var resultadoSistema = 'EASY WAVE';
		var decorativo = 'NO';
		var peso = 0;
		var argollaBool = 'N/A';
		var resultadoRemate = 'N/A';
		var resultadoSoporte;
		var radioMedida;
		var radioMaterial = 'ACRILICO';
		var baston;
		var valorBaston;
		var colorBaston = 'BLANCO';
		var resultadoFijacion;
		const imagenesSistema = {
			'28': '../../assets/img/cortineros/cortineros2/ONDULADO.jpg',
			'29': '../../assets/img/cortineros/cortineros2/CS.jpg',
			'125': '../../assets/img/cortineros/Nuevo/EASYWAVEBACKDROP.jpg'
		};
		var rutaImg = imagenesSistema['125'];
		var tipolinea = 'N';
		var TipoArticuloDetalle = 'easywave';
		var area;
		var resultadoHojas;
		var cantBaston = 0;
		var cantidadBastonFija = 0;
		var resHojas;
		var bloqueado = false;

		function obtenerValores(hacerRecalculo = false)
		{
			permitirCotizar();

			if ($('#anchocortinero').val().length == 0) {
				bloquearCotizar('Favor de capturar el ancho deseado para el cortinero.', false);
				return;
			}

			var radioHojasCheckedValue = $('input[name="hoja"]:checked').val();
			disabledRadios(radioHojasCheckedValue);

			anchoinicial = parseFloat(document.getElementById('anchocortinero').value || 0.8);
			//Nombre = $('input[name="sistema"]:checked').val();
			Nombre = '125';

			if (Nombre == '125' && (isNaN(anchoinicial) || anchoinicial <= 0.80)) {
				anchoinicial = 1;
				$('#anchocortinero').val('1.00');
			}
			if ((Nombre == '28' || Nombre == '29') && (isNaN(anchoinicial) || anchoinicial < 0.8 || anchoinicial == 1)) {
				anchoinicial = 0.8;
				$('#anchocortinero').val('0.80');
			}

			anchoinicial = parseFloat(anchoinicial).toFixed(2);
			anchomod = (Math.ceil(parseFloat(anchoinicial) * 10) / 10).toFixed(2);
			$('#anchocortinero').val(anchoinicial);

			TipoArticuloDetalle = (Nombre == '125') ? 'easywave' : ((Nombre == '28') ? 'ondulado' : 'cs');
			color = $('#SelectColor option:selected').html();
			var colorEnvio = color;
			resultadoSistema = (Nombre == '28') ? 'ONDULADO' : ((Nombre == '125') ? 'EASY WAVE' : 'ESTANDAR');

			var radioFijacion = document.getElementsByName('instalacion');
			for (var i = 0; i < radioFijacion.length; i++) {
				if (radioFijacion[i].checked) {
					resultadoFijacion = radioFijacion[i].value;
				}
			}

			if (resultadoFijacion == 'TECHO') {
				$('#sopordoble').css('display', 'none');
				$('#fijacion').prop('checked', true);
				resultadoSoporte = 'SENCILLO';
			} else {
				$('#sopordoble').css('display', 'inline');
			}

			var radioHojas = document.getElementsByName('hoja');
			for (i = 0; i < radioHojas.length; i++) {
				if (radioHojas[i].checked) {
					resultadoHojas = radioHojas[i].value;
				}
			}

			var radioSoporte = document.getElementsByName('soporte');
			for (i = 0; i < radioSoporte.length; i++) {
				if (radioSoporte[i].checked) {
					resultadoSoporte = radioSoporte[i].value;
				}
			}

			radioMedida = $('input[name="medida"]:checked').val();
			baston = document.getElementById('chkbaston').checked;

			if (baston == false) {
				valorBaston = 'NO';
			} else {
				valorBaston = 'SI';
			}

			if (color == 'NEGRO') {
				colorBaston = 'NEGRO';
			} else {
				colorBaston = 'BLANCO';
			}

			//if (color == 'BLANCO') {
			//	$('#bastonUnoP4').attr('disabled', false);
			//} else {
			//	$('#bastonUnoP4').attr('disabled', true);
			//	if ($('#bastonUnoP4').is(':checked')) {
			//		$('#bastonUnoP1').prop('checked', true);
			//		radioMedida = $('#bastonUnoP1').val();
			//	}
			//}
			//se implemento este cambio ya que en SAP no existen los bastones de 1.83 para el color Plata/Silver ni el Negro						
			if(color === 'NEGRO' || color === 'SILVER'){
				if($('#cuatro').is(':checked')){
				$('#uno').prop('checked', true);
					}
				$('#cuatro').attr('disabled',true);
					}else{
					$('#cuatro').attr('disabled',false);
					}

			resHojas = $('input[name="control"]:checked').val();
			$('#cargando').css('display', 'inline');
			$('#BtnD').css('display', 'none');

			$.post('../fnc/cortinero.php',
			{
				doblar: 'SI',
				ancho: anchomod,
				color: colorEnvio,
				tipo: Nombre,
				remate: resultadoRemate,
				resultadoSistema: resultadoSistema,
				soporte: resultadoSoporte,
				argolla: argollaBool,
				fijacion: resultadoFijacion,
				colorBaston: colorBaston,
				radioMedida: radioMedida,
				radioMaterial: radioMaterial,
				baston: baston,
				valorBaston: valorBaston,
				decorativo: decorativo,
				peso: peso,
				resHojas: resHojas
			}, function(data)
			{
				$('#resultado').html(data);
				validacionesResultado();

				if (!bloqueado) {
					if (hacerRecalculo) {
						precioRecalculado1 = $('#resultadoSuma').val();

						$.post('../fnc/cortinero.php',
						{
							doblar: 'SI',
							ancho: anchomod,
							color: colorEnvio,
							tipo: Nombre,
							remate: resultadoRemate,
							resultadoSistema: resultadoSistema,
							soporte: resultadoSoporte,
							argolla: argollaBool,
							fijacion: resultadoFijacion,
							colorBaston: colorBaston,
							radioMedida: radioMedida,
							radioMaterial: radioMaterial,
							baston: baston,
							valorBaston: valorBaston,
							decorativo: decorativo,
							peso: peso,
							resHojas: resHojas
						}, function(data)
						{
							$('#resultado').html(data);
							validacionesResultado();

							if (!bloqueado) {
								precioRecalculado2 = $('#resultadoSuma').val();
								if (precioRecalculado1 != precioRecalculado2 || costoFinal != precioRecalculado1) {
									bloquearCotizar('Se detectaron problemas de conexion que podrian afectar el calculo del costo de su cotizacion, favor de recargar la pagina.', true);
								} else {
									$('#carritoeasywave').submit();
								}
							}
						});
					} else {
						costoFinal = $('#resultadoSuma').val();
						permitirCotizar();
					}
				}
			});
		}

		function validacionesResultado()
		{
			if ($('#CodigoCortinero').val() == 'multiCortinero') {
				bloquearCotizar('La configuracion actual del articulo esta relacionada con dos codigos de articulo, favor de notificar a su agente de ventas.', true);
			}
			else if ($('#codigoBaston').val() == 'multiBaston') {
				bloquearCotizar('La configuracion actual del articulo esta relacionada con dos codigos de baston, favor de notificar a su agente de ventas.', true);
			}
			else if ($('#resultadoVacio').val() == 0) {
				bloquearCotizar('Este articulo no se encuentra dado de alta, favor de notificar a su agente de ventas.');
			}
		}

		function bloquearCotizar(mensaje, mostrarModal = false)
		{
			$('.msjModal').html(mensaje);
			$('#cargando').css('display', 'none');
			$('#BtnD').css('display', 'none');

			if (mostrarModal) {
				$('#msj').modal();
			}

			$('#cargando2').css('display', 'inline');
			bloqueado = true;
		}

		function triggerModal(mensaje)
		{
			$('.msjModal').html(mensaje);
			$('#msj').modal();
		}

		function permitirCotizar()
		{
			bloqueado = false;
			$('#cargando2').css('display', 'none');
			$('#cargando').css('display', 'none');
			$('#BtnD').css('display', 'inline');
		}

		$(document).ready(function()
		{
			CambiarNumber();
			CambiarRadio();
			obtenerValores();

			$('#BotonEnviar').click(function()
			{
				if ($('#autocomplete1').val().length == 0) {
					triggerModal('Favor de especificar el espacio.');
					return;
				}

				obtenerValores(true);
			});

			$('#msj').on('hidden.bs.modal', function()
			{
				$('#autocomplete1').focus();
			});

			$('#carritoeasywave').submit(function()
			{
				var Cantidad = $('#cantidadcortinero').val();
				var precioFinal = costoFinal;
				var codigoBaston = $('#codigoBaston').val() || $('#opCodigoBaston').val() || '';
				if (codigoBaston === 'undefined' || typeof codigoBaston === 'undefined') {
					codigoBaston = '';
				}
				var precioBaston = $('#valorBaston').val() || 0;
				var cantidadHojas = $('input[name="hoja"]:checked').val();
				var control = $('input[name="control"]:checked').val();
				var fijacion = $('input[name="instalacion"]:checked').val();
				var nombreCorti = (Nombre == '28') ? 'CORTINERO ONDULADO' : ((Nombre == '125') ? 'CORTINERO EASYWAVE' : 'CORTINERO CS');
				var tipoarticulo = 'cortinero';
				var codigo = $('#CodigoCortinero').val();
				var idllega = $('#opID').val();
				var oldUniqueId = $('#opUniqueID').val() || '';
				area = $('#autocomplete1').val();
				var soporte = $('input[name="soporte"]:checked').val();

				var id = '*' + codigo + '*' + control + '*' + fijacion + '*' + cantidadHojas + '*' + anchoinicial + '*' + area + '*' + codigoBaston;
				var oldId = '';
				if (idllega != 'nuevo' && !/\*undefined$/i.test(idllega)) {
					oldId = idllega;
				}

				if (baston == true) {
					if (cantidadHojas == '2HOJAS') {
						cantBaston = 2;
						if (soporte == 'DOBLE') {
							cantBaston = 4;
						}
					} else {
						cantBaston = 1;
						if (soporte == 'DOBLE') {
							cantBaston = 2;
						}
					}
				} else {
					cantBaston = 0;
				}

				cantidadBastonFija = cantBaston;
				cantBaston = cantBaston * Cantidad;
				precioBaston = precioBaston * Cantidad;

				$.post('LlenarCarrito.php', {
					id: id,
					Cantidad: Cantidad,
					precioFinal: precioFinal,
					nombre: nombreCorti,
					codigo: codigo,
					tipoarticulo: tipoarticulo,
					ruta: rutaImg,
					ancho: parseFloat(anchoinicial).toFixed(2),
					color: color,
					fijacion: fijacion,
					cantidadHojas: cantidadHojas,
					control: control,
					decorativo: decorativo,
					peso: peso,
					remate: resultadoRemate,
					resultadoSistema: resultadoSistema,
					soporte: soporte,
					argolla: argollaBool,
					codigoBaston: codigoBaston,
					baston: baston,
					colorBaston: colorBaston,
					radioMedida: radioMedida,
					radioMaterial: 'Fibra de Vidrio',
					tipolinea: tipolinea,
					TipoArticuloDetalle: TipoArticuloDetalle,
					area: area,
					old_id: oldId,
					old_unique_id: oldUniqueId,
					cantBaston: cantBaston,
					precioBaston: precioBaston,
					cantidadBastonFija: cantidadBastonFija
				}, function() {});
			});
		});
	</script>
	<script src="../../assets/js/core/source/App.js"></script>
	<script src="../../assets/js/libs/select2/select2.min.js"></script>
	<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
	<script src="../../assets/js/core/demo/Demo.js"></script>
	<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
</form>