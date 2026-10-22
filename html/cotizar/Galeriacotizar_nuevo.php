 <?php
	require_once '../fnc/GaleriaFnc.php';  
	$Nombre = "Galer&iacute;a";
?>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
  	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
  	<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
  	<link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />

  	<!-- END STYLESHEETS -->
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
	<![endif]-->

	<SCRIPT TYPE="text/javascript">
  		var FinalPrecio=0;
  		$(document).ready(function(){
			$("#Telas").change(function () {
				$("#colores").hide();
				$("#variables").hide();
				//$("#cargando").show();
				ColorVariable();				
			})
		});

  		function cambiaAlto(element, min, max){
			if($("#alto").val() < min || $("#alto").val() > max){
				alert("El alto de la galería permitido es entre " + min + " y " + max + " mts");
				$("#alto").val(0.25);
			}
			CargarValor();
		}

  		function CargarValor(){ 
			Tela = $("#Telas option:selected").html();
			TipoTela=$("#Telas option:selected").val();
			Color = $("input[name='color']:checked").val();
			Ancho = $("#ancho").val();
			Fijacion = $("input[name='fijacion']:checked").val();
			Cantidad = $("#cantidad").val();
			tipoProyeccion = $("input[name='acoplamiento']:checked").val();
			alto = $("#alto").val();
			medidaProyeccion = $("#medida_proyeccion").val();
			var x = document.getElementById("div_copete");
			if(Fijacion == "Muro"){
				if(!$("#div_copete").is(":visible")){
					x.style.display = "block";
					document.getElementById("medida_copete").focus();
				}

				medidaCopete = $("#medida_copete").val();

				if (typeof medidaCopete == "undefined" || medidaCopete == null ||  medidaCopete == ""){
					medidaCopeteCorrecta = false;
				}else{
					medidaCopeteCorrecta = true;
				}
    		} else {
        		x.style.display = "none";
        		medidaCopete = 0;
        		medidaCopeteCorrecta = true;
    		}
			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");
			Cop = MostrarValor();
			if (Cop == "TRUE"){
				Copete = "SI";
			}
			else{
				Copete = "NO";
			}
			proyeccionDerecha = 0;
			proyeccionIzquierda = 0;

			if(document.getElementById('opc_proyeccion').checked){
				switch (tipoProyeccion) {
  					case "Izquierda":
  						proyeccionIzquierda = medidaProyeccion;
    				break;
  					case "Derecha":
  						proyeccionDerecha = medidaProyeccion;
  					break;
  					case "Ambos":
  						proyeccionDerecha = medidaProyeccion;
  						proyeccionIzquierda = medidaProyeccion; 
    				break;
				}

				if (typeof medidaProyeccion == "undefined" || medidaProyeccion == null ||  medidaProyeccion == ""){
					medidaProyeccionCorrecta = false;
				}else{
					medidaProyeccionCorrecta = true;
				}

			}else{
				medidaProyeccionCorrecta = true;
			}

			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
			    typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
			    typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
			    typeof alto == "undefined" || alto == null || alto == "" || medidaCopeteCorrecta == false ||medidaProyeccionCorrecta == false){
					return false;
			} 
			else {
				$.post("GaleriaCotizarPrecio.php", { Fijacion : Fijacion, Copete : Copete,  Ancho : Ancho, Tela : Tela, Color : Color, 
													TipoTela:TipoTela,TipoArticuloDetalle:"galeria", proyeccionIzquierda : proyeccionIzquierda, proyeccionDerecha : proyeccionDerecha, medidaCopete : medidaCopete, alto : alto, Cantidad : Cantidad, ConsecAprov:0, MetrajeReal:0, MetrajeGaleria:0,CodigoTela:"N/A"}, function(data2){
					$("#precio_total").html(data2);
				   $("#precio_total").show();
				   FinalPrecio = $("#precioFinal").val();
				//    FinalPrecio2 = $("#precioFinal2").val();
				//    $("#PrecioFinalReal").val(""+FinalPrecio);
				//    $("#label_cantidadFinal2").html(""+FinalPrecio2);
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");
				   $("#cargando2").css("display", "none");
				   $("#ahorroTela").css("display", "none");
						console.log("Entro GaleriaCotizarPrecio");

				   $.post("../fnc/comprobacionInsumos2.php", 
					{
						metraje : $("#metraje").val(),
						codigotela : $("#CodigoTela").val(),
						cantidad : Cantidad,
						Tela: $("#Telas option:selected").html(),
						TipoTela:$("#Telas option:selected").val(),
						//TipoCortina:$("#nombre").val(),
						TipoCortina:"galeria",
						Color:$("input[name='color']:checked").val(),
						Clave : "galeria", 
						Ancho : Ancho,
						Alto : alto,
						Stiffener : "NO",
						ForroX : "NO",
						BajoPlomo:"NO", 
						CAFE:"NO"
					}, function(dataInsumo)
					{
						console.log("Entro comprobacionInsumos2");
					   	$("#notastock").html(dataInsumo);
						$("#notastock").show();
					});
				   	let divisionesGaleria = $("#divisionesGaleria").val();

				    if(divisionesGaleria > 1){
						console.log("Entro divisionesGaleria > 1");
						$("#cargando2").css("display", "inline");
						$("#divisionesModal").text(divisionesGaleria);

						let tamanioDivisiones = Ancho / divisionesGaleria;
						tamanioDivisiones = Number(tamanioDivisiones.toFixed(2));
						$("#tamanioDivisiones").text(tamanioDivisiones);
					}

					let metrajeTotal2 = $("#metrajeTotal").val();
					let metrajeReal2 = $("#metrajeReal").val();

					if(metrajeTotal2 != metrajeReal2){
						$("#ahorroTela").css("display", "inline");
					}
				});
			}
		}

		function MostrarValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "COPETE"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

  		function ColorVariable(){
			 $("#Telas option:selected").each(function () {

				elegido=$("#Telas option:selected").html();
				tipo = $(this).val();

				$.post("cotizarcolores.php", { elegido: elegido }, function(data1){
					$("#colores").html(data1);
					$("#colores").show();
				});
			});
		}
	</script>
	<form method="POST" action="index.php?opcion=terminar" id="cortina" name="galeria">
			<input type="hidden"  id="tipo" value="<?php echo $valor; ?>">
			<input type="hidden"  id="nombre" value="<?php echo $Nombre; ?>">
			<input type="hidden"  id="ruta" value="../../assets/img/galeria/GALERIA-ORIGINAL.jpg">
<!-- PRIMERA COLUMA -->
			<div class="container-left">
				<div class="card card-outlined style-default-light">
					<div class="card-head">
						<h3><?php echo  $Nombre; ?></h3>
					</div>
					<div class="card-body no-padding height-7">
						<div class="img-backdrop" style="background-image: url('../../assets/img/galeria/GALERIA-ORIGINAL.jpg')"></div>
					</div>		
				</div>	

			</div>
<!-- SEGUNDA COLUMNA -->
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
								<input type="number" class="form-control" id="cantidad" min="1" onkeypress="ValidaSoloNumeros()" onchange="CargarValor()" onkeyup="CargarValor()" required ></div>
							<label for="autocomplete1">Espacio</label>
							<input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
						</div>
						<div class="col-sm-3">
							<label for="cantidad">Ancho (mts)</label>
							<input type="number" id="ancho" name="ancho" class="medidas" min="0.1" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required >
							<label for="dollars10">Alto (mts)</label>
							<input type="number" id="alto" name="alto" class="medidas" min="0.1" step="0.01" onkeypress="return NumCheck(event, this)" onchange="cambiaAlto(this,'0.1','2.0')" onkeyup="CargarValor()" required >
						</div>
						<div class="col-sm-4">
							<div id="notastock" class="status"></div>
							<div id="notasTela" style="font-weight:bold;"></div>
						</div>
					</div>
					<div class="tab-options">
						<button class="tablinks active" onclick="openTab(event,'1')" type="button">DATOS GENERALES</button>
						<!-- <button class="tablinks" onclick="openTab(event,'2')" type="button">VARIABLES</button>
						<button class="tablinks" onclick="openTab(event,'3')" type="button">ACCESORIOS</button> -->
					</div>
					<div id="tab_1" class="tabcontent tab-bg row" style="display:block;">
						<div class="col-sm-6">	
							<label>SELECCIONA EL TIPO DE TELA</label>
							<?php
								$ArregloTipoTela = TraerTipoTela("PACHETO");
								$Filas = count($ArregloTipoTela);
								echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
									for( $i=0; $i<$Filas; $i++ ){
										echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';
									}
								echo "</select>";
							?>
							<div>(<b>*</b>) Sujeto a disponibilidad</div>
						</div>
						<div class="col-sm-6">	
							<!-- <label>SUSTITUTO RECOMENDADO</label>
							<?php
								// //  Descomentar en productivo
								// //$ArregloTipoTela = array();
								// $ArregloTipoTela = TraerTipoTela($valor);
								// $Filas = count($ArregloTipoTela);
								// echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
								// 	for( $i=0; $i<$Filas; $i++ ){
								// 		if (($valor=="pEs" or $valor=="pPo") and $ArregloTipoTela[$i]['nombre']=="LUXY"){
								// 		} else {
								// 			echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';	
								// 		}
								// 	}
								// echo "</select>";
							?> -->
							<div id="colores"></div>
							<script type="text/javascript">
								ColorVariable();
							</script>
						</div>	
							<div id="variables"></div><br>
							<h3 style="margin-top: 10px;">Fijación</h3>
							<div class="">
								<div class="">
									<table class="table table-condensed acoplamiento">
										<tr>
											<td>
												<label class="radio-inline radio-styled">
													<input type="radio" name="fijacion" value="Muro" onchange="CargarValor()" checked><span>Muro</span>
													<img src="../../assets/img/opciones/muro.png"/>
												</label>
											</td>
											<td>
												<label class="radio-inline radio-styled">
													<input type="radio" name="fijacion"  value="Techo" onchange="CargarValor()" checked><span>Techo</span>
													<img src="../../assets/img/opciones/techo.png"/>
												</label>
											</td>
										</tr>
									</table>
								</div>
							</div>	
							<div id="div_copete" class="col-sm-6">
								<div>													
									<h4>Medida Copete</h4>
								</div>
								<div class="input-group">
									<div class="input-group-content">
										<input type="number" class="form-control" id="medida_copete" name="medida_copete" min="0.10" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()"  value="0.25" required >
									</div>
									<span class="input-group-addon">mts.</span>
								</div>
							</div>
							<h3 class="col-sm-12">Proyección</h3>
							<div class="checkbox checkbox-styled tile-text">
								<label>
									<input type="checkbox" id="opc_proyeccion" name="opc_proyeccion" value="PROYECCION" onchange='CargarValor()'>
									<span>
											Proyección
									</span>
								</label>
							</div>
							<table class="table table-condensed acoplamiento">
								<tr>
									<div class="input-group">
										<td>
											<label class="radio-inline radio-styled">
												<input type="radio" name="acoplamiento" onchange="CargarValor()" value="" checked><span>Izquierda</span>
												<img src="../../assets/img/galeria/galeria-proyeccion-izquierda.jpg"/>
											</label>
										</td>
										<td>
											<label class="radio-inline radio-styled">
												<input type="radio" name="acoplamiento" onchange="CargarValor()" value="" checked><span>Derecha</span>
												<img src="../../assets/img/galeria/galeria-proyeccion-derecha.jpg"/>
											</label>
										</td>
										<td>
											<label class="radio-inline radio-styled">
												<input type="radio" name="acoplamiento" onchange="CargarValor()" value="Ambos" checked><span>Ambos</span>
												<img src="../../assets/img/galeria/galeria-ambas-proyecciones.jpg"/>
											</label>
										</td>
									</div>
								</tr>
							</table>
							<div>													
								<h4>Medida Proyección</h4>
							</div>
							<div id="div_proyeccion" class="input-group col-sm-6">
								<div tabindex="10" class="input-group-content">
									<input type="number" class="form-control" id="medida_proyeccion" name="medida_proyeccion" min="0.10" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()"  value="0.25" required >
								</div>
								<span class="input-group-addon">mts.</span>
							</div>
							<div id="ahorroTela" style="display:none; color: red;">Este producto está aplicando ahorro de tela, precio podría variar si existen cambios</div>
							<div id="cargando2" style="display:none; color: red;"><b>Debido a la dimensión de la Galería, esta irá dividida en <span id="divisionesModal"></span>
							<!--<SCRIPT TYPE="text/javascript">
								//divisionesGaleria = $("#divisionesGaleria").val();
	
								//document.write(divisionesGaleria);
							</SCRIPT>-->
								pzas de <span id="tamanioDivisiones"></span> metros.
							</b></div>
						</div>
						
					</div>
					<div id="tab_2" class="tabcontent tab-bg">
						<h3>VARIABLES</h3>	
					</div>
					<div id="tab_3" class="tabcontent tab-bg">
						<h3>ACCESORIOS</h3>
					</div>
				</div>
				<div></div>	
				<div></div>
				<br>
			<div class="panel_inferior">
				<div id="precio" style="display:none;"></div>
				<div id="precios">
					<div id="precio_total" class="precio_total">
						<label class="label_total">Precio Total</label>
						<label id="label_cantidadFinal2" class="label_cantidad">$0.00</label>
						<input id='PrecioFinalReal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right;' type="hidden" readonly>
					</div>
				</div>
				<div id="cargando" style="display:none; color: green;">Cargando...</div>
				<div id="BtnD" style="display:none;"><button type="submit" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
			</div>
			</div><!--end .card-body -->
	</form>
	</div>
	<div class="modal fade" id="modalcorreo" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="simpleModalLabel">Información</h4>
				</div>
				<div class="modal-body">
					<p>El "<b>Espacio</b>" es un campo requerido para poder enviar la cotización. Favor de capturarlo</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
    <script type="text/javascript">
			$(document).ready(function(){
				$("#cortina").submit(function() {
				    Cantidad = $("#cantidad").val();
				    ancho = $("#ancho").val();
				    alto = $("#alto").val();
				    precioFinal = $("#PrecioUnitarioGaleria").val();
				    Color = $("input[name='color']:checked").val();
				    CodigoMo = $("#CodigoMo").val();
					PrecioMo = $("#PMO").val();
				    nombre="Galeria";
				    tipoarticulo="galeria";
				    tipoTela= $("#tipoTela").val();	
				    codigo= $("#CodigoComodin").val();	
				    PrecioTela = $("#PrecioTela").val();	  
				    CodigoTela = $("#CodigoTela").val();
				    CodigoTelaForro = $("#CodigoMicrofibra").val();
					PrecioForro = $("#PrecioForro").val();
					telaForro = $("#nombreTelaForro").val();
					fijacion = $("input[name='fijacion']:checked").val();
					area = $("#autocomplete1").val(); 
					MetrajeGaleria = $("#metrajeTotal").val(); 
					MetrajeForro = $("#metrajeTotalForro").val();  
					tela= $("#Telas option:selected").html();
				    id="galeria*"+fijacion+"*"+Color+"*"+CodigoTelaForro+"*"+tela+'*'+ancho;	
				    rutaImg="../../assets/img/galeria/galeria.jpg";	
				    if (fijacion == "Muro"){
				    	copete = $("#medida_copete").val();
				    } else{
				    	copete = 0.25;
				    }
				    if (document.getElementById('opc_proyeccion').checked) {
						proyecciones= $("input[name='acoplamiento']:checked").val();
					} else{
						proyecciones= "N/A";
					}
					medidaProyeccion = $("#medida_proyeccion").val();
					MLManoObra = $("#MLManoObraTotales").val(); 
					TotalEscuadras = $("#escuadrasTotales").val();
					CodigoMoForro = $("#CodigoMoForro").val();
					CodigoCopete = $("#CodigoCopete").val();
					CodigoEscuadras = $("#CodigoEscuadras").val();
					PrecioEscuadras = $("#PE").val();
					piezasDivideGaleria = $("#piezasDivideGaleria").val();
					metrajeUnitarioML = $("#metrajeUnitarioML").val();
					ConsecAprov = $("#idProductoAprovechamiento").val();
					AnchoTela = $("#AnchoTela").val();
					MetrajeReal = $("#metrajeReal").val(); 
					AprovTela = $("#corteAlto").val();
					AprovTela = AprovTela / Cantidad;
					AplicaAprov = $("#AplicaAprov").val(); 
					if (typeof area == "undefined" || area == null  ||  area == ""  ){
		    	 		$("#modalEspacio").modal(); 
			    		return false;
		   			} else{
			   			if (typeof Color == "undefined" || Color == null) {
				    		return false; 
				    	} else {
					    	if(proyecciones != "N/A" && fijacion == "Muro" && medidaProyeccion != copete){
					    		$("#modalProyeccionCopete").modal(); 
			    				return false;
							}else{
									$.post("LlenarCarrito.php",{area:area, id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombre,codigo:codigo,PrecioTela:PrecioTela,
							                                tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:ancho, alto:alto, color:Color, fijacion:fijacion, tela:tela,CodigoTela:CodigoTela,
							                                proyecciones:proyecciones, CodigoMo : CodigoMo, PrecioMo : PrecioMo, CodigoTelaForro:CodigoTelaForro, 
							                                 PrecioTelaForro:PrecioForro,telaForro:telaForro,MetrajeGaleria:MetrajeGaleria,copete:copete, medidaProyeccion:medidaProyeccion,MetrajeMo:MLManoObra,TotalEscuadras:TotalEscuadras,CodigoMoForro:CodigoMoForro,CodigoCopete:CodigoCopete,CodigoEscuadras:CodigoEscuadras,PrecioEscuadras:PrecioEscuadras,AnchoTela:AnchoTela,AprovTela:AprovTela,AplicaAprov:AplicaAprov,ConsecAprov:ConsecAprov,MetrajeReal:MetrajeReal,MetrajeForro:MetrajeForro								                               
														    }, function(data){ 
														    });	
							}
						}
			   		}
				});
			});
			function modificarCarrito(ConsecAprov,MetrajeGaleria){
				$.post("GaleriaAprovechamientoTela.php",{Operacion:'ASIGNAR_APROVECHAMIENTO',idProducto:ConsecAprov, MetrajeGaleria:MetrajeGaleria}, function(data){ 
						alert(data);
				});
			}
			function seleccionarNumero(num) {
				$(".btn_cantidad").removeClass("active");
				$("#btn_cantidad_"+num).addClass("active");
				if(num<5){
					$(".cantidades #cantidad").css("display", "none");
					$(".cantidades #cantidad").val(num);
				}
				else{
					$(".cantidades #cantidad").css("display", "inline-block");
					$(".cantidades #cantidad").val("");
				}
				CargarValor();
			}
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {
                            if (window.console) {
                                return console.log('Checking our the events huh?');
                            }
                        },
						onNavigate: function(direction, itemIndex) {
										if (window.console) {
											return console.log('Navigating '+direction+'. Current item: '+itemIndex);
										}
						}
                    });
                });
                $('#open-image').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                $('#open-youtube').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
              $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                    event.preventDefault();
                    return $(this).ekkoLightbox({
                        onShown: function() {

              var a = this.modal_content.find('.modal-footer a');
              if(a.length > 0) {

                a.click(function(e) {

                  e.preventDefault();
                  this.navigateTo(2);

                }.bind(this));
              }
                        }
                    });
                });
            });
		</script>
 		<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
	<!-- BEGIN JAVASCRIPT -->
	<script src="../../assets/js/core/source/App.js"></script>
	<script src="../../assets/js/libs/select2/select2.min.js"></script>
	<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
	<script src="../../assets/js/core/demo/Demo.js"></script>
	<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
	<!-- END JAVASCRIPT -->