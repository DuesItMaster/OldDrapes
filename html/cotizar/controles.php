<?php 
	$idSituo = 92;
	$idPared = 94;
	$Nombre = "Controles";
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
				<div class="img-backdrop" style="background-image: url('../../assets/img/cortineros/cortineros2/CONTROL_RTS.jpg');background-position: 55%;"></div>
			</div>		
		</div>	

	</div>
	<div class="container-right">
		<div class="container-right-top">
			<div class="container-right-top-tab">
				<div class="col-sm-5">
					<label for="cantidad">Cantidad de controles <span class="comentario_label">*Unidad</span></label>
					<div class="cantidades">
						<button type="button" id="btn_cantidad_1" onclick="seleccionarNumero('1')" class="btn_cantidad">1</button>
						<button type="button" id="btn_cantidad_2" onclick="seleccionarNumero('2')" class="btn_cantidad">2</button>
						<button type="button" id="btn_cantidad_3" onclick="seleccionarNumero('3')" class="btn_cantidad">3</button>
						<button type="button" id="btn_cantidad_4" onclick="seleccionarNumero('4')" class="btn_cantidad">4</button>
						<button type="button" id="btn_cantidad_5" onclick="seleccionarNumero('5')" class="btn_cantidad">5+</button>
						<input type="number" class="form-control" id="cantidadControles" name="cantidadControles" min="1" onkeypress="ValidaSoloNumeros()" value="1" required></div>
					<label for="autocomplete1">Espacio</label>
					<input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" onChange="cambiarControl()" required>
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
						<select class="form-control" id="SelectControl" name="SelectControl" onchange="cambiarControl();">												
							<?php												   
								$controles=TipoControl($idSituo, $idPared);	
								foreach ($controles as $valor) {														
									echo "<option value='". $valor["codigo"] ."'>".trim($valor["nombre"])."</option>";														
								}													
							?>
						</select>
						<label><b>Selecciona tipo de control</b></label>
					</div>				
					<br>		
					<div id="resultado4"></div>
					<h3>Canales</h3>
					<div class="form-group">											
						<select class="form-control" id="SelectCanales" name="SelectCanales" onchange="precioControl(this.value)">												
						</select>
					</div>
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
						<div id="resultado">
							<label class="label_total">Precio Total</label>
							<label id="label_cantidad" class="label_cantidad">$0.00</label>
							<div id="resultado">
								<div class='form-group'> <input id='Precio' class='form-control' name='Precio' value='<?php echo $precioP; ?>' style='text-align: right;' type="hidden" readonly></div>
							</div>
						</div>
					</div>
				</div>
				<div id="cargando" style="display:none; color: green;">Cargando...</div>
				<div id="BtnD"><button type="button" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
			</div>
	</div>	

	<script>
		$("#BotonEnviar").click(function()
		{
			if ($("#autocomplete1").val().length == 0){
				triggerModal("Favor de especificar el espacio.");
				return;
			}

			if ($("#cantidadControles").val() == 0){
				triggerModal("Favor de poner una cantidad mayor a 0.");
				return;
			}

			var id;
			var idDrapesNombre;
			var tipoArticulo;
			var area;
			var nombreControl;
			var codigoControl;
			var precio;
			var cantidad;
			var imgRuta;
			var nombreTipoControl;
		
			idDrapesNombre = $('#SelectControl').val();
			console.log(idDrapesNombre);
			tipoArticulo = $('#SelectControl option:selected').text();
			console.log(tipoArticulo);
			area = $("#autocomplete1").val();
			console.log(area);
			nombreControl = $('#SelectCanales option:selected').attr('nombre');
			console.log(nombreControl);
			codigoControl = $('#SelectCanales option:selected').attr('codigo');
			console.log(codigoControl);
			nombreTipoControl = $('#SelectCanales option:selected').attr('imgnombre');
			precio = $("#Precio").val();
			console.log(precio);
			cantidad = $("#cantidadControles").val();
			console.log(cantidad);
			imgRuta = "../../assets/img/cortineros/" + nombreTipoControl + ".jpg";
			console.log(imgRuta);

			if ( $("#opID").length > 0 ) {
				id = $("#opID").val();
			}
			else {
				id = idDrapesNombre+"*"+codigoControl+"*"+area;
			}
			console.log("hasta aqui llega");
			console.log("LlenarCarrito.php");
			$.post("LlenarCarrito.php",
			{
				id:id, Cantidad:cantidad, precioFinal:precio, nombre:nombreControl, codigo:codigoControl, tipoarticulo:tipoArticulo, ruta:imgRuta,area:area, TipoArticuloDetalle:tipoArticulo, idDrapesNombre:idDrapesNombre
			}, function(){

				console.log("hasta aqui llega2");
				$("#situo").submit();
			});	 		
		});
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
			cambiarControl();
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
</form>