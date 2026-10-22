<?php 
require_once '../fnc/GaleriaFnc.php';

if (isset($_GET['i']) && $_GET['i']<>"" ){

		include_once '../clases/Carrito.class.php';
		$carrito = new Carrito();
		$carro = $carrito->get_content();

		if($carro){ 
			foreach($carro as $producto){
				if ($producto["id"]==$_GET['i']){

					echo "<input type='hidden' id='opID' value='".$producto["id"]."'>";
										
					echo "<input type='hidden' id='opTela' value='".$producto["tela"]."'>";
					echo "<input type='hidden' id='opColor' value='".$producto["color"]."'>";

					echo "<input type='hidden' id='opAlto' value=".$producto["alto"].">";
					echo "<input type='hidden' id='opAncho' value=".$producto["ancho"].">";
					echo "<input type='hidden' id='opCantidad' value=".$producto["cantidad"].">";


					//echo "<input type='hidden' id='optelaForro' value='".$producto["telaForro"]."'>";
					//echo "<input type='hidden' id='opColorForro' value='".$producto["ColorForro"]."'>";

					//echo "<input type='hidden' id='opAcoplamiento' value=".$producto["acoplamiento"].">";
					echo "<input type='hidden' id='opFijacion' value=".$producto["fijacion"].">";

					//echo "<br><br><br><br><br><br><br><br>";
					echo "<input type='hidden' id='opProyeccion' value=".$producto["proyecciones"].">";
					echo "<input type='hidden' id='opcopete' value=".$producto["copete"].">";

					//copete

					//echo "<input type='hidden' id='opBajoplomo' value='".$producto["bajoplomo"]."'>";
					//echo "<input type='hidden' id='opStiffener' value='".$producto["stiffener"]."'>";
					//echo "<input type='hidden' id='opNeverlight' value='".$producto["neverlight"]."'>";
					//echo "<input type='hidden' id='opGancho' value='".$producto["gancho"]."'>";

				}
			}
		}
	}
?>
<!DOCTYPE html>
<head>
	<!-- BEGIN META -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="cotizador,dues">
	<meta name="description" content="Cotizador Dues Drapes">
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

	<!-- END STYLESHEETS -->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
	<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
	<![endif]-->

  		<SCRIPT TYPE="text/javascript">
  		
  		$(document).ready(function(){
			
			$("#Telas").change(function () {
				$("#colores").hide();
				$("#variables").hide();
				//$("#cargando").show();
				ColorVariable();				
			});


			$("#galeria").submit(function() {
					copete = $("#copete").val();
				    Cantidad = $("#cantidadGaleria").val();
				    ancho = $("#anchoVuelta").val();
				    precioFinal = $("#precioFinal").val();
				    fijacion= $("#fijacionVuelta").val();
				    Color = $("input[name='color']:checked").val();
				     //precioFinal = $("#PrecioFinal").val();
				    proyecciones= $("input[name='acoplamiento']:checked").val();
				    CodigoMo = $("#CodigoMo").val();
					PrecioMo = $("#PrecioMo").val();
				    nombre="Galeria";
				    tipoarticulo="galeria";
				    tipoTela= $("#tipoTela").val();	
				    codigo= $("#CodigoComodin").val();	
				     PrecioTela = $("#PrecioTela").val();	  
				    //CodigoMicrofibra= $("#CodigoMicrofibra").val();
				    	
				    CodigoTela = $("#CodigoTela").val();
				    
				    CodigoTelaForro = $("#CodigoMicrofibra").val();
					PrecioForro = $("#PrecioForro").val();

					//alert(PrecioTela);

					tela= $("#Telas option:selected").html();

					area = $("#autocomplete1").val(); 
					/*nombre = "Cortina " + $("#nombre").val();*/

				    //id="galeria*"+fijacion+"*"+CodigoTelaForro+"*"+tela+'*'+ancho;	
				    id = $("#opID").val(); 
				    //alert(id);										    
				    rutaImg="../../assets/img/galeria/galeria.jpg";								    										    		   
				    $.post("LlenarCarrito.php",{area:area,id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombre,codigo:codigo,PrecioTela:PrecioTela,
				                                tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:ancho, color:Color, fijacion:fijacion, tela:tela,CodigoTela:CodigoTela,
				                                proyecciones:proyecciones, copete:copete, CodigoMo : CodigoMo, PrecioMo : PrecioMo, CodigoTelaForro:CodigoTelaForro, 
				                                 PrecioTelaForro:PrecioForro										                               
											    }, function(){ });	   			  
				});

		});


  		function CargarValor(){
			
			Tela = $("#Telas option:selected").html();
			TipoTela=$("#Telas option:selected").val();
			Color = $("input[name='color']:checked").val();
			Ancho = $("#ancho").val();
			Fijacion = $("input[name='fijacion']:checked").val();
			Cantidad = $("#cantidadGaleria").val();

			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");
		
			Cop = MostrarValor();
			if (Cop == "TRUE"){
				Copete = "SI";
			}
			else{
				Copete = "NO";
			}

			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
			    typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
			    typeof Ancho == "undefined" || Ancho == null || Ancho == "" ){
			    	
			    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
			    		return false;

			} 
			else {
			
				$.post("GaleriaCotizarPrecio.php", { Fijacion : Fijacion, Copete : Copete,  Ancho : Ancho, Tela : Tela, Color : Color, TipoTela:TipoTela,TipoArticuloDetalle:"galeria"}, function(data2){
				   $("#precio").html(data2);
				   $("#precio").show();
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");
				});	

			}
		
		}


		function MostrarValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				//cada elemento seleccionado
				//alert($(this).val());
				if($(this).val() == "COPETE"){
					//return "SI";
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}



  		function ColorVariable(){

			 $("#Telas option:selected").each(function () {
				    //elegido=$(this).val();
				    	
				    elegido=$("#Telas option:selected").html();
				    tipo = $(this).val();

				    Color = $("#opColor").val();
				    $("#"+Color+"").prop("checked", true);


					/*$.post("cotizarvariables.php", { tipo: tipo }, function(data){
					    $("#variables").html(data);
					    $("#variables").show();
			    	});*/

				   $.post("cotizarcolores.php", { elegido: elegido, Color:Color }, function(data1){
					    $("#colores").html(data1);
					    $("#colores").show();
			    	});

  
			});
		}


		function CambiarCombo(){
			
            Tela = $("#opTela").val(); 
            //alert(Tela);

             $('#Telas option').filter(function () 
             	{ return $(this).html() == Tela; }).attr("selected", "selected");

             //$("#ancho").val() =$("#opAncho").val();

             alto = $("#opAlto").val();
             ancho = $("#opAncho").val();
             cantidad = $("#opCantidad").val();
             
             $("#alto").val(alto);
             $("#ancho").val(ancho);
             $("#cantidad").val(cantidad);

		}

		function CambiarAcoplamiento(){

			fijacion = $("#opFijacion").val();				
			$("#"+fijacion+"").prop("checked", true);

			proyecciones = $("#opProyeccion").val();				
			$("#"+proyecciones+"").prop("checked", true);		

			copete = $("#opcopete").val();
			if (copete=="SI"){
				 $("#copetex").prop("checked", true);	
			}
		}

  		</SCRIPT>

	</head>

<body class="menubar-hoverable header-fixed ">
 <form method="POST" action="index.php?opcion=terminar" id="galeria" name="galeria">
	<div id="content">
		<section>
			<div class="section-body contain-lg">
				<!-- BEGIN SECTION -->
				<div class="doc-section">
					<!--<a href="javascript:window.history.back();" id="Btn" style=""><i class="fa fa-chevron-left" style="padding-right: 15px;"></i> Volver </a>-->
					<div class="col-lg-offset-1 col-md-5 col-sm-6">
						<div class="card">
							<div class="card-body">
								
								<div class="form">
									<div class="card card-outlined style-default-light">
										<div class="card-head">
											<header>
												<h3 class="opacity-50" style="align=center">Galeria</h3>
											</header>
										</div>
										<div class="card-body no-padding height-8">
											<a href="">
												<div class="img-backdrop" style="background-image: url('../../assets/img/galeria/galeria.jpg')"></div>
											</a>
										</div>		
									</div>

									<div id="tiras"><h3>Precio</h3></div>
									<div id="precio">
										<div class="form-group"><input class="form-control" id="precioFinal" type="text" value="0.00" style="text-align: right;" readonly><label><b>PRECIO:</b></label></div>
									</div>

									
											<div id="tiras"><h3>Área</h3></div>

											<div class="form-group">
												<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Área">
												<!--<label>Elije</label>-->
											</div>
										


									<div id="tiras"><h3>Cantidad</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<input type="tel" class="form-control" name="cantidadGaleria" id="cantidadGaleria" min="1" value="1" onkeyup="CargarValor()" required>
												<label for="dollars10">Cantidad de galeria</label>
											</div>
											<span class="input-group-addon">unidad</span>
										</div>
									</div>

									<div id="tiras"><h3>Medida</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
											<div class="input-group-content">
												<input type="tel" class="form-control" id="ancho" min="1"   step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
												<label for="dollars10">Ancho</label>
											</div>
											<span class="input-group-addon">mts.</span>
										</div>
									</div><!--end .form-group -->
															
								</div><!--end .card-body -->
							</div><!--end .card -->	
						</div>
					</div>

					<div class="col-lg-offset-1 col-md-5 col-sm-6" style="margin-left: 0%;">
						<div class="card">
							<div class="card-body">
								<div class="form">


									<div id="tiras"><h3>Tela</h3></div>
									<div class="form-group">
										<?php
										$ArregloTipoTela = TraerTipoTela("PACHETO");
										$Filas = count($ArregloTipoTela);
										echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
											for( $i=0; $i<$Filas; $i++ ){
										        echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';
											}
										echo "</select>";
									    ?>		
										<label>Selecciona el tipo de tela</label>
									</div>

									<script type="text/javascript">
										CambiarCombo();
										ColorVariable();
									</script>
									<div id="colores"></div>
									<div class="form-group">
										<div id="tiras"><h3>Fijación</h3></div>
										<table class="table table-condensed">
											<tr>
												<div class="input-group">
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="fijacion" onchange="CargarValor();" value="Muro" checked><span>Muro</span>
															<img src="../../assets/img/opciones/muro.png"  style=""  width="80px" height="60px"/>
														</label>
													</td>
													
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="fijacion"  value="Techo" onchange="CargarValor();" checked><span>Techo</span>
															<img src="../../assets/img/opciones/techo.png" style=""   width="80px" height="60px"/>
														</label>
													</td>
												</div>
											</tr>
										</table>
									</div>	


									<div class="form-group">
										<div id="tiras"><h3>Proyecciones</h3></div>
										<table class="table table-condensed">
											<tr>
												<div class="input-group">
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="acoplamiento"  value="Izquierda" id="Izquierda" checked><span>Izquierda</span>
															<img src="../../assets/img/opciones/izquierda.png" style="" width="50px" height="50px"/>
														</label>
													</td>
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="acoplamiento"  value="Derecha" id="Derecha" ><span>Derecha</span>
															<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px"/>
														</label>
													</td>
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="acoplamiento" value="Ambos" id="Ambos" ><span>Ambos</span>
															<img src="../../assets/img/opciones/Ambas.png" style="" width="50px" height="50px"/>
														</label>
													</td>
												</div>
											</tr>
										</table>
									</div>

									

									<div class="form-group">
										<div id="tiras"><h3>Copete</h3></div>

										<div class="checkbox checkbox-styled tile-text">
										  	<label>
												<input type="checkbox" id="copetex" name="copetex" value="COPETE" onchange='CargarValor()' onkeyup="CargarValor()" required>
												<span>
													 Incluir Copete
												</span>
											</label>
										</div>
										
									</div>

									<script type="text/javascript">
										CambiarAcoplamiento();
									</script>

									<div>
										<br>
										<div id="cargando" style="display:none; color: green;">Cargando...</div>
										<div id="BtnD" style="display:none;"><button type="submit" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;" >Guardar cambios</button></div>

									</div>
									<br>
								</div><!--end .form-group -->
							</div><!--end .card-body -->
						</div>
					</div>					
				</div>
			</div>
		</section>
	</div>


		<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>

        <script type="text/javascript">
            $(document).ready(function ($) {
                // delegate calls to data-toggle="lightbox"
                $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                    event.preventDefault();
                    //alert("img");
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

                //Programatically call
                $('#open-image').click(function (e) {
                	//alert("img a");
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });
                $('#open-youtube').click(function (e) {
                    e.preventDefault();
                    $(this).ekkoLightbox();
                });

        // navigateTo
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


		<!-- BEGIN JAVASCRIPT -->
		<!--<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
		<script src="../../assets/js/libs/jquery/jquery-migrate-1.2.1.min.js"></script>
		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>-->
		<!--<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>
		<!--<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>-->
		<!--<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<!--<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>-->

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