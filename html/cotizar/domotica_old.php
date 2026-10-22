<?php 
	$idInteo = 93;
	$Nombre = "Domotica";
 	include '../../conexion/wsConsumeDrapes.php';
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />
<link type="text/css" rel="stylesheet" href="../../assets/css/situo.css" />

<form class="form" method="POST" action="index.php?opcion=terminar" id="situo" name="situo">
	<!-- PRIMERA COLUMA -->
	<div class="container-left">
		<div class="card card-outlined style-default-light">
			<div class="card-head">
				<h3><?php echo  $Nombre; ?></h3>
			</div>
			<div class="card-body no-padding height-7">
				<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/domotica.jpg');background-position: 55%;"></div>
			</div>		
		</div>	

	</div>
	<div class="container-right">
		<div class="container-right-top">
			<div class="container-right-top-tab">
				<div class="col-sm-5">
					<label for="cantidad">Cantidad de articulos <span class="comentario_label">*Unidad</span></label>
					<div class="cantidades">
						<button type="button" id="btn_cantidad_1" onclick="seleccionarNumero('1')" class="btn_cantidad">1</button>
						<button type="button" id="btn_cantidad_2" onclick="seleccionarNumero('2')" class="btn_cantidad">2</button>
						<button type="button" id="btn_cantidad_3" onclick="seleccionarNumero('3')" class="btn_cantidad">3</button>
						<button type="button" id="btn_cantidad_4" onclick="seleccionarNumero('4')" class="btn_cantidad">4</button>
						<button type="button" id="btn_cantidad_5" onclick="seleccionarNumero('5')" class="btn_cantidad">5+</button>
						<input type="number" class="form-control" id="cantidadControles" name="cantidadControles" min="1" onkeypress="ValidaSoloNumeros()"  value="1" required></div>
					<label for="autocomplete1">Espacio</label>
					<input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
				</div>
				<div class="col-sm-3">
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
				<div class="doc-section">
					<h3>Tipo de control</h3>
					<div class="form-group">											
						<select class="form-control" id="SelectCanales" name="SelectCanales" onchange="precioControl(this.value)">												
						</select>
					</div>
					<div style='display:none;'>
						<div id="tiras">
							<h3>Tipo de control</h3>
						</div>
						<div class="form-group">											
							<select class="form-control" id="SelectControl" name="SelectControl" onchange="cambiarControl();">												
							<?php												   
								$controles=TipoControl($idInteo,0);	
									foreach ($controles as $valor) {														
										echo "<option value='". $valor["codigo"] ."'>".trim($valor["nombre"])."</option>";														
									}													
								?>
							</select>
							<label><b>Selecciona tipo de control</b></label>
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
			</div>
			<div class="panel_inferior">
				<div id="precios">
					<div id="precio_total" class="precio_total">
						<label class="label_total">Precio Total:</label>
						<label id="label_cantidad"><?php echo $precioP; ?></label>
						<div id="resultado">
							<div class='form-group'> <input id='Precio' class='form-control' name='Precio' value='<?php echo $precioP; ?>' style='text-align: right;' type="hidden" readonly></div>
						</div>
					</div>
				</div>
				<div id="cargando" style="display:none; color: green;">Cargando...</div>
				<div id="BtnD"><button type="button" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
			</div>
	</div>	

	<script>
		function seleccionarNumero(num) {
			$(".btn_cantidad").removeClass("active");
			$("#btn_cantidad_"+num).addClass("active");
			if(num<5){
				$(".cantidades #cantidadControles").css("display", "none");
				$(".cantidades #cantidadControles").val(num);
			}
			else{
				$(".cantidades #cantidadControles").css("display", "inline-block");
				$(".cantidades #cantidadControles").val("");
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
	<script src="../js/domotica.js"></script>
	<script src="../js/funcionesGenerales.js"></script>		
	<!-- END JAVASCRIPT -->		
</form>