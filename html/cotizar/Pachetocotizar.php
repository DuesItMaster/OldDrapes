<?php 
require_once '../fnc/PersianaFnc.php';
?>
<html>
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
	<!--<link type="text/css" rel="stylesheet" href="../../assets/css/animacion/slider.css" />-->
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

  	<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
  	 
  	 <!--<script src="../fnc/cotizar.js" type="text/javascript"></script>-->

  	<!-- -->
  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />

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


			$("#pacheto").submit(function() {

				tela= $("#Telas option:selected").html();
			    nombre = "Cortina Pacheto ";
			    Color= $("input[name='color']:checked").val();

			    Cantidad = $("#cantidad").val();
			    precioFinal=FinalPrecio;
			    //precioFinal = $("#PrecioFinal").val();
			    
			    //ColorForro = $("input[name='colorforro']:checked").val();
			    ruta ='../../assets/img/tipopersiana/pacheto.jpg' //$("#ruta").val();
			    
			    Codigo = $("#CodigoComodin").val();

			    CodigoTela = $("#CodigoTela").val();
				PrecioTela = $("#PrecioTela").val();

				CodigoMecanismo = $("#CodigoMecanismo").val();
				PrecioMecanismo  = $("#PrecioMecanismo").val();

				Metraje = $("#Metraje").val(); 

			    Ancho = $("#ancho").val();
				Alto = $("#alto").val();
				
				area = $("#autocomplete1").val(); 
			    //Tipo= $("#tipo").val();

			    
			    id="pacheto*"+Codigo+'*'+Ancho+'*'+Alto+'*'+Codigo+'*'+Color;

			    //alert(Codigo + ' /Cantidad '  + Cantidad + ' /, Precio ' +precioFinal + ' /,id ' + id );

			    if (typeof Color == "undefined" || Color == null) {
			    	return false;
			    } else {

			    	var data = {area:area,Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, TipoArticuloDetalle:"pacheto",
			    								 codigo:Codigo, tela : tela, color : Color, CodigoTela : CodigoTela, PrecioTela:PrecioTela,
			    								 CodigoMecanismo: CodigoMecanismo, PrecioMecanismo:PrecioMecanismo,
			    								 tipoarticulo:'pacheto', ruta : ruta, Metraje: Metraje };
			    	if (CodigoMecanismo == null || CodigoMecanismo == "" || PrecioMecanismo == null || PrecioMecanismo == "" || PrecioMecanismo == "0"){
			    		delete data.CodigoMecanismo;
			    		delete data.PrecioMecanismo;
			    	}
			    	$.post("LlenarCarrito.php", data, function(data2){ });	
			    }
			   
			});

		});


  		function CargarValor(){
			
			Tela = $("#Telas option:selected").html();
			Color = $("input[name='color']:checked").val();
			
		    Ancho = $("#ancho").val();
			Alto = $("#alto").val();
			Cantidad = $("#cantidad").val();

			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");
			
			//alert("ENTRA " + Ancho + " alto: " + Alto);
		
			/*if((Ancho < 2) && (Alto < 2.6)){				
				var Errors="";
				if((Ancho > 1.6) && (Ancho < 1.7) && (Alto > 2.6)){
					alert("si entra");
					Errors="SI";
					alert("Ancho <= 1.6 alto > 2.6");
				}
				else if((Ancho > 1.7) && (Ancho <= 1.8 ) && (Alto > 2.3) && (Alto < 2.4)){
					Errors="SI";
					alert("Ancho == 1.7 alto > 2.3");
				}
				else if((Ancho > 1.8) && (Alto > 2.2)){
					Errors="SI";
					alert("Ancho > 1.8 alto > 2.2");
				}
				else if((Ancho > 1.9) && (Alto > 2.1)){
					Errors="SI";
					alert("Ancho > 1.9 alto > 2.1");
				}
				else if((Ancho > 2) && (Alto > 2)){
					Errors="SI";
					alert("Ancho > 2 alto > 2");
				}
				if(Errors=="SI"){
					$("#msj").modal();
					$("#cargando2").css("display", "inline");
					$("#BtnD").css("display", "none");
					$("#PrecioFinal2").val("0.00");
				}				
			}
			else if((Ancho > 2) && (Alto > 2.6)){
				$("#msj").modal();
				$("#cargando2").css("display", "inline");
				$("#BtnD").css("display", "none");
				$("#PrecioFinal2").val("0.00");
			}*/
			if((Ancho > 2) && (Alto > 2.6)){
				$("#msj").modal();
				$("#cargando2").css("display", "inline");
				$("#BtnD").css("display", "none");
				$("#PrecioFinal2").val("0.00");
			}
			else{
				if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
			    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
			    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
			    	typeof Alto == "undefined" || Alto == null || Alto == ""){
			    	
			    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
			    		return false;

				} 
				else {
					    arrAn = Ancho.split(".");
					    enteroAn = arrAn[0];
						decimalAn = arrAn[1];

						    if(decimalAn == 0 || "")
	                         { 
	                         	Ancho = enteroAn;
	                         }

                        arrAl = Alto.split(".");
					    enteroAl = arrAl[0];
						decimalAl = arrAl[1];

						    if(decimalAl == 0 || "")
	                         { 
	                         	Alto = enteroAl;
	                         }

						$.post("PachetoCotizarPrecio.php", { Alto : Alto, Ancho : Ancho, Tela : Tela, Varilla : "NO" , Color : Color}, function(data2){
						   $("#precio").html(data2);
						   FinalPrecio = $("#PrecioFinal").val();
						   PrecioMec = $("#PrecioMecanismo").val();								    			
				    			if(PrecioMec !=0 ){
				    				$("#cargando2").css("display", "none");
					    			$("#cargando").css("display", "none");
		                            $("#BtnD").css("display", "inline");						                            
				    			}
				    			else{				    												    				
				    				$("#cargando2").css("display", "inline");								    				
				    				$("#cargando").css("display", "none");
				    				$("#BtnD").css("display", "none");
				    			}
						});	
					
					}
			}		
		}



  		function ColorVariable(){

			 $("#Telas option:selected").each(function () {
				    //elegido=$(this).val();
				    	
				    elegido=$("#Telas option:selected").html();
				    tipo = $(this).val();


					/*$.post("cotizarvariables.php", { tipo: tipo }, function(data){
					    $("#variables").html(data);
					    $("#variables").show();
			    	});*/

				   $.post("cotizarcolores.php", { elegido: elegido }, function(data1){
					    $("#colores").html(data1);
					    $("#colores").show();
			    	});

  
			});
		}

  		</SCRIPT>

		
	</head>

<body class="menubar-hoverable header-fixed ">
	<form method="POST" id="pacheto" name="pacheto" action="index.php?opcion=terminar">
	<div id="content">
		<section>
			<div class="section-body contain-lg">
				<!-- BEGIN SECTION -->
				<div class="doc-section">
					<!--<a href="javascript:window.history.back();" id="Btn" style=""><i class="fa fa-chevron-left" style="padding-right: 15px;"></i> Volver </a>-->
					<div class="col-lg-offset-1 col-md-5 col-sm-6">
						<div class="card">
							<div class="card-body">
								<!--<div class="form">-->
									<div class="card card-outlined style-default-light">
										<div class="card-head">
											<header>
												<h3 class="opacity-50" style="align=center">Pacheto</h3>
											</header>
										</div>
										<div class="card-body no-padding height-8">
											<a >
												<div class="img-backdrop" style="background-image: url('../../assets/img/tipopersiana/pacheto.jpg')"></div>
											</a>
										</div>		
									</div>

									<div class="form-group">
										<div id="tiras"><h3>Precio</h3></div>
										<div id="precio">
											<div class='form-group'><input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>
										</div>
									</div>

									<!--<div class="form-group">
										<div id="tiras"><h3>Área</h3></div>

										<div class="input-group">
											<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Área">
											<!--<label>Elije</label>-->
										<!--</div>
									</div>-->

									<div class="form-group">
										<div id="tiras"><h3>Área</h3></div>
										
											<div class='form-group'><input type="text" id='autocomplete1' class='form-control'data-source="../../conexion/data/areas.json" ><label>Elije</label></div>
										
									</div>
									
									<div id="tiras"><h3>Medida</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
											<div class="input-group-content">
												<input type="tel" class="form-control" id="ancho" min="1" step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
												<label for="dollars10">Ancho</label>
											</div>
											<span class="input-group-addon">mts.</span>
										</div>
									</div><!--end .form-group -->


									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
											<div class="input-group-content">
												<input type="tel" class="form-control" id="alto" min="1" step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
												<label for="dollars10">Alto</label>
											</div>
											<span class="input-group-addon">mts.</span>
										</div>
									</div><!--end .form-group -->			
								<!--</div>-->

							</div>
					</div>
				</div>
			</div>

			<div class="col-lg-offset-1 col-md-5 col-sm-6" style="margin-left: 0%;">
						<div class="card">
							<div class="card-body">
								<div class="form">


								<div id="tiras"><h3>Cantidad</h3></div>
								<div class="form-group floating-label">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
										<div class="input-group-content">
											<input type="tel" class="form-control" id="cantidad" min="1" onkeypress="ValidaSoloNumeros()"  onchange="CargarValor()" onkeyup="CargarValor()" required>
											<label for="dollars10">Cantidad de cortinas</label>
										</div>
										<span class="input-group-addon">unidad</span>
									</div>
								</div><!--end .form-group -->


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
										ColorVariable();
									</script>
									<div id="colores"></div>
									<br>	
								<div id="precio"></div>
								<br>
								<div id="cargando" style="display:none; color: green;">Cargando...</div>
								<div id="BtnD" style="display:none;"><button type="submit" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;">Agregar</button></div>			
								<div id="cargando2" style="display:none; color: red;">Excede las medidas máximas, cambiar valores.</div>
					<div class="modal fade" id="msj" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
						<div class="modal-dialog">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
									<h4 class="modal-title" id="simpleModalLabel">Información</h4>
								</div>
								<div class="modal-body">
									<p>Excede las medidas máximas (2 x 2).</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>													
								</div>
							</div><!-- /.modal-content -->
						</div><!-- /.modal-dialog -->
					</div><!-- /.modal -->


								</div><!--end .form-group -->
							</div><!--end .card-body -->
						</div><!--end .card -->							
					</div>
				</div>
			</div>
		</section>
	</div>
	</form>

	<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>

        <script type="text/javascript">
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

                //Programatically call
                $('#open-image').click(function (e) {
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
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		<!-- END JAVASCRIPT -->

</body>
</html>
