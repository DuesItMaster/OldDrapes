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
					echo "<input type='hidden' id='opArea' value='".$producto["area"]."'>";
										
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
					//echo "<script>alert('".$producto["medidaProyeccion"]."');</script>";
					echo "<input type='hidden' id='opmedidaproyeccion' value=".$producto["medidaProyeccion"].">";
					echo "<input type='hidden' id='opconsec' value=".$producto["ConsecAprov"].">";
					echo "<input type='hidden' id='opmetrajereal' value=".$producto["MetrajeReal"].">";
					echo "<input type='hidden' id='opmetrajegaleria' value=".$producto["MetrajeGaleria"].">";
					echo "<input type='hidden' id='opcodigotela' value=".$producto["CodigoTela"].">";


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
					//copete = $("#copete").val();
				    Cantidad = $("#cantidadGaleria").val();
				    ancho = $("#ancho").val();
				    alto = $("#alto").val();
				    //precioFinal=FinalPrecio;
				    //precioFinal = $("#precioFinal").val();
				    precioFinal = $("#PrecioUnitarioGaleria").val();
				    //fijacion= $("#fijacionVuelta").val();

				    Color = $("input[name='color']:checked").val();
				     //precioFinal = $("#PrecioFinal").val();
				    //proyecciones= $("input[name='acoplamiento']:checked").val();

				    CodigoMo = $("#CodigoMo").val();
					PrecioMo = $("#PMO").val();
				    nombre="Galeria";
				    tipoarticulo="galeria";
				    tipoTela= $("#tipoTela").val();	
				    codigo= $("#CodigoComodin").val();	
				    PrecioTela = $("#PrecioTela").val();	  
				    //CodigoMicrofibra= $("#CodigoMicrofibra").val();
				    	
				    CodigoTela = $("#CodigoTela").val();
				    
				    CodigoTelaForro = $("#CodigoMicrofibra").val();
					PrecioForro = $("#PrecioForro").val();
					telaForro = $("#nombreTelaForro").val();

					fijacion = $("input[name='fijacion']:checked").val();

					//alert(PrecioTela);
					area = $("#autocomplete1").val();
					MetrajeGaleria = $("#metrajeTotal").val();
					MetrajeForro = $("#metrajeTotalForro").val();

					tela= $("#Telas option:selected").html();

					/*nombre = "Cortina " + $("#nombre").val();*/

				    //id="galeria*"+fijacion+"*"+CodigoTelaForro+"*"+tela+'*'+ancho;	
				    id = $("#opID").val(); 
				    //alert(id);										    
				    rutaImg="../../assets/img/galeria/galeria.jpg";	

				    if (fijacion == "Muro"){
				    	copete = $("#medida_copete").val();
				    }else{
				    	copete = 0.25;
				    }

				    if (document.getElementById('opc_proyeccion').checked)
					{
						proyecciones= $("input[name='acoplamiento']:checked").val();
					}else{
						proyecciones= "N/A";
					}

					medidaProyeccion = $("#medida_proyeccion").val();

					//AGREGAR LOS CODIGOS, PRECIOS Y TOTALES
					MLManoObra = $("#MLManoObraTotales").val(); 
					TotalEscuadras = $("#escuadrasTotales").val();
					CodigoMoForro = $("#CodigoMoForro").val();
					CodigoCopete = $("#CodigoCopete").val();
					CodigoEscuadras = $("#CodigoEscuadras").val();
					PrecioEscuadras = $("#PE").val();
					AnchoTela = $("#AnchoTela").val();
					MetrajeReal = $("#metrajeReal").val(); 

					AprovTela = $("#corteAlto").val();
					AprovTela = AprovTela / Cantidad;

					AplicaAprov = $("#AplicaAprov").val();
					ConsecAprov = $("#idProductoAprovechamiento").val(); 

					//alert(MLManoObra);

					if (typeof area == "undefined" || area == null  ||  area == ""  ){
		    	 		$("#modalEspacio").modal(); 
			    		return false;
		   			}else{
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
														    }, function(){ });	 

							}
						}
					}	   			  
				});

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
			Cantidad = $("#cantidadGaleria").val();
			tipoProyeccion = $("input[name='acoplamiento']:checked").val();;
			alto = $("#alto").val();
			medidaProyeccion = $("#medida_proyeccion").val();
			cantidad2 = $("#cantidadGaleria").val();
			id = $("#opID").val();
			ConsecAprov = $("#opconsec").val();
			MetrajeReal = $("#opmetrajereal").val();
			MetrajeGaleria = $("#opmetrajegaleria").val();
			CodigoTela = $("#opcodigotela").val();
			
			var x = document.getElementById("div_copete");

			if(Fijacion == "Muro"){
				if(!$("#div_copete").is(":visible")){
					x.style.display = "block";
					document.getElementById("medida_copete").focus();
				}

				medidaCopete = $("#medida_copete").val();
    		} else {
        		x.style.display = "none";

        		medidaCopete = 0;
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

			//ASIGNAR MEDIDAS DE LAS PROYECCIONES
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
			}

			//alert("Consec: " + ConsecAprov + "Metraje Real: " + MetrajeReal+ " MetrajeGaleria: " + MetrajeGaleria + " Codigo Tela: " + CodigoTela);
			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
			    typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
			    typeof Ancho == "undefined" || Ancho == null || Ancho == "" ){
			    	
			    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
			    		return false;

			} 
			else {
				$.post("GaleriaCotizarPrecio.php", { Fijacion : Fijacion, Copete : Copete,  Ancho : Ancho, Tela : Tela, Color : Color, 
													TipoTela:TipoTela,TipoArticuloDetalle:"galeria", proyeccionIzquierda : proyeccionIzquierda, proyeccionDerecha : proyeccionDerecha, medidaCopete : medidaCopete, alto : alto, Cantidad : Cantidad, id:id, ConsecAprov:ConsecAprov, MetrajeReal:MetrajeReal, MetrajeGaleria:MetrajeGaleria,CodigoTela:CodigoTela}, function(data2){
				   $("#precio").html(data2);
				   $("#precio").show();
				   $("#cargando").css("display", "none");
				   $("#cargando2").css("display", "none");
				   $("#BtnD").css("display", "inline");
				   $("#ahorroTela").css("display", "none");

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
					   	$("#notastock").html(dataInsumo);
						$("#notastock").show();
					});


				   	let divisionesGaleria = $("#divisionesGaleria").val();

					//alert(divisionesGaleria);

				    if(divisionesGaleria > 1){
				    	//alert('ENTRÓ');
						$("#cargando2").css("display", "inline");
						$("#divisionesModal").text(divisionesGaleria);

						let tamanioDivisiones = Ancho / divisionesGaleria;
						tamanioDivisiones = Number(tamanioDivisiones.toFixed(2));
						$("#tamanioDivisiones").text(tamanioDivisiones);

						//alert('Debido a la dimensión de la Galería, esta irá dividida en '+ divisionesGaleria +' pzas de ' + tamanioDivisiones + ' metros.');

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
             $("#cantidadGaleria").val(cantidad);

             area = $("#opArea").val();
             $("#autocomplete1").val(area);
             

		}

		function CambiarAcoplamiento(){
			fijacion = $("#opFijacion").val();				
			$("#"+fijacion+"").prop("checked", true);

			copete = $("#opcopete").val();
			$("#medida_copete").val(copete);

			proyecciones = $("#opProyeccion").val();
				

			//console.log(proyecciones);

			if(proyecciones != "N/A"){
				$("#"+proyecciones+"").prop("checked", true);

				medidaProyeccion = $("#opmedidaproyeccion").val();
				$("#medida_proyeccion").val(medidaProyeccion);
				
				$("#opc_proyeccion").prop("checked", true);
			}else{
				//$("#medida_proyeccion").val(0);
			}
		
				

			//if (copete=="SI"){
				 //$("#copetex").prop("checked", true);	
			//}
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
												<div class="img-backdrop" style="background-image: url('../../assets/img/galeria/GALERIA-ORIGINAL.jpg')"></div>
											</a>
										</div>		
									</div>

									<div id="tiras"><h3>Precio</h3></div>
									<div id="precio">
										<div class="form-group"><input class="form-control" id="precioFinal" type="text" value="0.00" style="text-align: right;" readonly><label><b>PRECIO:</b></label></div>
									</div>

									
											<div id="tiras"><h3>Espacio</h3></div>

											<div class="form-group">
												<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio">
												<!--<label>Elije</label>-->
											</div>
										


									<div id="tiras"><h3>Cantidad</h3></div>
									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
											<div class="input-group-content">
												<input type="tel" class="form-control" name="cantidadGaleria" id="cantidadGaleria" min="1" value="1" onkeyup="CargarValor()" required>
												<label for="dollars10">Cantidad de galerías</label>
											</div>
											<span class="input-group-addon">unidad</span>
										</div>
									</div>

									<div id="tiras"><h3>Medidas</h3></div>
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
									<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
												<div class="input-group-content">
													<input type="number" class="form-control" id="alto" name="alto" min="0.1" max="0.5" step="0.01" onkeypress="return NumCheck(event, this)" onchange="cambiaAlto(this,'0.1','0.5')" onkeyup="CargarValor()" required >
													<label for="dollars10">Alto</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
									</div>						
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
									<div id="notastock"></div>
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
															<input type="radio" name="fijacion" value="Muro" id = "Muro" onchange="CargarValor();"  checked><span>Muro</span>
															<img src="../../assets/img/opciones/muro.png"  style=""  width="80px" height="60px"/>
														</label>
													</td>
													
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="fijacion"  value="Techo" id="Techo" onchange="CargarValor();" checked><span>Techo</span>
															<img src="../../assets/img/opciones/techo.png" style=""   width="80px" height="60px"/>
														</label>
													</td>
												</div>
											</tr>
										</table>
										<div id = "div_copete">
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
									</div>	


									<div class="form-group">
										<div id="tiras"><h3>Proyección</h3></div>
										<div class="checkbox checkbox-styled tile-text">
											  <label>
												<input type="checkbox" id="opc_proyeccion" name="opc_proyeccion" value="PROYECCION" onchange='CargarValor()'>
												<span>
													Proyección
												</span>
											</label>
										</div>
										<table class="table table-condensed">
											<tr>
												<div class="input-group">
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="acoplamiento"  value="Izquierda" id="Izquierda" onchange="CargarValor();" checked><span>Izquierda</span>
															<img src="../../assets/img/galeria/galeria-proyeccion-izquierda.jpg" style="" width="50px" height="50px"/>
														</label>
													</td>
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="acoplamiento"  value="Derecha" id="Derecha" onchange="CargarValor();"><span>Derecha</span>
															<img src="../../assets/img/galeria/galeria-proyeccion-derecha.jpg" width="50px" height="50px"/>
														</label>
													</td>
													<td>
														<label class="radio-inline radio-styled">
															<input type="radio" name="acoplamiento" value="Ambos" id="Ambos" onchange="CargarValor();"><span>Ambos</span>
															<img src="../../assets/img/galeria/galeria-ambas-proyecciones.jpg" style="" width="50px" height="50px"/>
														</label>
													</td>
												</div>
											</tr>
										</table>
										<div>													
											<h4>Medida Proyección</h4>
										</div>
										<div class="input-group">
												<div class="input-group-content">
													<input type="number" class="form-control" id="medida_proyeccion" name="medida_proyeccion" min="0.10" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()"  value="0.25" required >
											</div>
												<span class="input-group-addon">mts.</span>
										</div>
									</div>

									

									<!--<div class="form-group">
										<div id="tiras"><h3>Copete</h3></div>

										<div class="checkbox checkbox-styled tile-text">
										  	<label>
												<input type="checkbox" id="copetex" name="copetex" value="COPETE" onchange='CargarValor()' onkeyup="CargarValor()" required>
												<span>
													 Incluir Copete
												</span>
											</label>
										</div>
										
									</div>-->

									<script type="text/javascript">
										CambiarAcoplamiento();
									</script>

									<div>
										<br>
										<div id="cargando" style="display:none; color: green;">Cargando...</div>
										<div id="ahorroTela" style="display:none; color: red;">Este producto está aplicando ahorro de tela, precio podría variar si existen cambios</div>
										<div id="cargando2" style="display:none; color: red;"><b>Debido a la dimensión de la Galería, esta irá dividida en <span id="divisionesModal"></span>
											<!--<SCRIPT TYPE="text/javascript">
												//divisionesGaleria = $("#divisionesGaleria").val();

												//document.write(divisionesGaleria);
											</SCRIPT>-->
											 pzas de <span id="tamanioDivisiones"></span> metros.
											</b></div>
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

	<div class="modal fade" id="modalEspacio" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
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

		<div class="modal fade" id="modalProyeccionCopete" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="simpleModalLabel">Información</h4>
					</div>
					<div class="modal-body">
						<p>La "<b>Medida Copete</b>" y "<b>Medida Proyección</b>" deben ser iguales. Favor de corregir.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->


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