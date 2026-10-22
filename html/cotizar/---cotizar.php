<?php
	require_once '../fnc/CortinaFnc.php';

	$valor = $_GET['opc'];
	$Gancho = TRUE;
	$TipoTela ="";
	//$ValorFinalPrecio = 0 ;
?>

<!DOCTYPE html>
<html>
<head>
		
	<title>Cotizar</title>

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
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadminCliente.css?1425466319" />
	
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<!--<script src="//code.jquery.com/jquery-1.10.2.js"></script>-->
  	<!--<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
  	
  	<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  	<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>

  	<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js"></script>-->
	
  	<script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />

  	<!-- END STYLESHEETS -->
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
	<![endif]-->

	<script language="javascript">

		//var PrecioFinalCortina = 0 ;
		//var FinalForro=0;

		$(document).ready(function(){
			$("#Telas").change(function () {
				$("#colores").hide();
				$("#variables").hide();
				$("#PrecioFinal").val('0.00');
				$("#PrecioFinal2").val('0.00');
				ColorVariable();				
			});

			$("#TelasForro").change(function () {
				$("#coloresforro").hide();
				$("#variables").hide(); //PrecioFinalForro
				$("#PrecioFinalForro").val('0.00');
				$("#PrecioFinalForro2").val('0.00');
				ColorVariableForro();				
			});

			//$("#cortina").submit(function() {
		});



		function prueba(){
			tela= $("#Telas option:selected").html();
			    nombre = "Cortina " + $("#nombre").val();
			    Color= $("input[name='color']:checked").val();
 				//alert("Color " + Color);
			    Cantidad = $("#cantidad").val();
			    //alert("Cantidad " + Cantidad);
			    //alert(Cantidad);
			    
			    precioFinal = $("#PrecioFinal").val();
			    //precioFinal = PrecioFinalCortina; 
			    //alert(precioFinal);

			    Codigo = $("#CodigoComodin").val();

			    CodigoTela = $("#CodigoTela").val();
			    PrecioTela = $("#PrecioTela").val();
			    Metraje = $("#Metraje").val();
			    
			    Ancho = $("#ancho").val();
			    //alert("Ancho " + Ancho);
				Alto = $("#alto").val();
				//alert("Alto " + Alto);
				CodigoMo = $("#CodigoMo").val();
				PrecioMo = $("#PrecioMo").val();
				MetrajeMo = $("#MetrajeMo").val();
				
			    telaForro = $("#TelasForro option:selected").html();
			    ColorForro = $("input[name='colorforro']:checked").val();
			    PrecioFinalForro = $("#PrecioFinalForro").val();
			  	//PrecioFinalForro=FinalForro;
			    CodigoTelaForro = $("#CodigoTelaForro").val();
			    PrecioTelaForro = $("#PrecioTelaForro").val();
			    CodigoMoForro = $("#CodigoMoForro").val();
			    PrecioMoForro = $("#PrecioMoForro").val();
			    MetrajeForro = $("#MetrajeForro").val();
			    MetrajeMoForro = $("#MetrajeMoForro").val();

			    CodigoBajoPlomo = $("#CodigoBajoPlomo").val();
			    PrecioPlomo = $("#PrecioPlomo").val();
			    MetrajeBajoPlomo = $("#MetrajeBajoPlomo").val();

			    ruta = $("#ruta").val();			    
			    
			    Fijacion= $("input[name='fijacion']:checked").val();
			    Acoplamiento= $("input[name='acoplamiento']:checked").val();
			    Tipo= $("#tipo").val();

			    Sti = MostrarValor();
				if (Sti == "TRUE"){ 
					Stiffener = "STIFFENER"; 
					CodigoStiffener = $("#CodigoStiffener").val();
					PrecioStiffener = $("#PrecioStiffener").val();
				}
				else{ 	
					Stiffener = "";
					CodigoStiffener="";
					PrecioStiffener="0"; 
				}

				//alert(CodigoStiffener);

				Bp = BajoPlomoFnc();
				if (Bp == "TRUE"){ BajoPlomo = "BAJO PLOMO";} //alert('BP');}
				else{ BajoPlomo = "";}  //alert('BP');}

				Gr = GanchoReforzado();
				if (Gr == "TRUE"){ Gancho = "GANCHO REFORZADO"; }
				else{ Gancho = ""; }

				Nl = Neverlight();
				if (Nl == "TRUE"){ Never = "NEVER LIGHT"; }
				else{ Never = ""; }

				area = $("#autocomplete1").val(); 

			    id=Tipo+'*'+Codigo+'*'+Ancho+'*'+Alto+'*'+Fijacion+'*'+Acoplamiento+'*'+CodigoTela+'*'+Color;

			    //alert("Here");
			    if (typeof area == "undefined" || area == null  ||  area == ""  ){
			    	
			    	 $("#modalcorreo").modal(); 
				    return false;
			    }

			    else{

				    if (typeof Color == "undefined" || Color == null || 
				    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
				    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
				    	typeof Alto == "undefined" || Alto == null || Alto == ""){
				    	
				    		alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
				    		return false;

				    } else {

				    	if (precioFinal == 0){

				    		CargarValor();
				    		return false;

				    	}else{

					    	if (typeof ColorForro == "undefined" || ColorForro == null) {
					    		//alert(area);
					    		$.post("LlenarCarrito.php", {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
					    								 	codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
					    								 	stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
					    								 	tipoarticulo:'cortina', ruta : ruta, CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo, 			  
					    								 	CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo }, function(data2){ });

					    		//alert("true");
					    	
					    		 window.location.href = "index.php?opcion=terminar";
					    		}

					    	else{

					    		if (PrecioFinalForro==0){
					    			
					    		}else{
					    		
						    		id = id + '*' + telaForro + '*' + ColorForro;

						    		//alert(" Cantidad: " + Cantidad + " .Preciofinal " + precioFinal + " Nombre: " + nombre + " id: " + id );
						    		precioFinal = parseFloat(precioFinal) + parseFloat(PrecioFinalForro); //+  (parseFloat(MetrajeMo) * parseFloat(PrecioMoForro)) ;
						    		//alert(area);
									//alert("true 2");
						    		$.post("LlenarCarrito.php", {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
							    								 codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
							    								 stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
							    								 tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,
							    								 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro, PrecioFinalForro : PrecioFinalForro,
							    								 CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro,
							    								 MetrajeForro:MetrajeForro, MetrajeMoForro:MetrajeMoForro,
							    								 CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo  }
							    								 , function(data2){ });

						    		window.location.href = "index.php?opcion=terminar";
					    		}
					    	}
				    	}

				    }

			    }
		}

		

		function ColorVariable(){

			 $("#Telas option:selected").each(function () {
				    //elegido=$(this).val();
				    elegido=$("#Telas option:selected").html();
				   // elegidoForro = $("#TelasForro option:selected").html();
				    tipo = $(this).val();
				    //alert(elegido);

					$('#colores').html('<div><img src="../../assets/img/ajax-loader.gif"/></div>');
					$.post("cotizarvariables.php", { tipo: tipo,elegido:elegido }, function(data){
					    $("#variables").html(data);
					    $("#variables").show();
			    	});


				   $.post("cotizarcolores.php", { elegido: elegido }, function(data1){
				   		//$('#content').fadeIn(1000).html(data);
					    $("#colores").fadeIn(1000).html(data1);
					    $("#colores").show();
			    	});

				   	/*$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});*/
  
			});

		}

		function CambiarVariables(){
			//NO ELIMINAR ESTA FUNCION
		}


		function ColorVariableForro(){

			 $("#TelasForro option:selected").each(function () {
				    //elegido=$(this).val();
				    //elegido=$("#Telas option:selected").html();
				    elegidoForro = $("#TelasForro option:selected").html();
				    tipo = $(this).val();

				   	$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});
  
			});
		}



		function CargarValor(){

            /*anchoinicial=document.getElementById('ancho').value;
            if(anchoinicial >= 2.51){
            	document.getElementById("Ambos").checked=true;
            	document.getElementById("Ambos").disabled=false;
				document.getElementById("Derecha").disabled=true;
				document.getElementById("Izquierda").disabled=true;
            }
            else if(anchoinicial < 2.5){
            	document.getElementById("Ambos").disabled=true;
				document.getElementById("Derecha").disabled=false;
				document.getElementById("Izquierda").disabled=false;
				document.getElementById("Izquierda").checked=true;
            }
            else if (anchoinicial==2.5){
            	document.getElementById("Ambos").disabled=false;
				document.getElementById("Derecha").disabled=false;
				document.getElementById("Izquierda").disabled=false;	
            }*/


            
            var TipoCortina  = $("#nombre").val();
			
			Clave =  "<?php echo $valor; ?>";
			Tela=$("#Telas option:selected").html();
			TipoTela=$("#Telas option:selected").val();
			Color= $("input[name='color']:checked").val();
			Ancho = $("#ancho").val();
			Alto = $("#alto").val();
			Cantidad = $("#cantidad").val();
			TelaForro=$("#TelasForro option:selected").html();
			TipoTelaForro=$("#TelasForro option:selected").val();
			ColorForro = $("input[name='colorforro']:checked").val();



			if(TipoTela!="TRANSLUCIDA"){
			   	$("#forros2").css("display", "inline");
			} else{
			 	$("#forros2").css("display", "none");
			}


			if (TipoCortina=="Ojillos" && Ancho >= 2.3){

			 	document.getElementById("Ambos").disabled=false;
			 	document.getElementById("Ambos").checked=true;

				document.getElementById("Derecha").disabled=true;
				document.getElementById("Izquierda").disabled=true;

			 } else {

			 	document.getElementById("Ambos").disabled=false;
			 	document.getElementById("Ambos").checked=true;

				document.getElementById("Derecha").disabled=false;
				document.getElementById("Izquierda").disabled=false;

			}
					   


			Sti = MostrarValor();
			if (Sti == "TRUE"){
				Stiffener = "SI";
			}
			else{
				Stiffener = "NO";
			}

			Bp = BajoPlomoFnc();
			if (Bp == "TRUE"){ 
				BajoPlomo = "SI"; 
				//alert("SI");
			}
			else{ 
				BajoPlomo = "NO"; 
				//alert("NO");
			}

			OjiCafe = Ojillo();
			if (OjiCafe == "TRUE"){ 
				CAFE = "SI"; 
				//alert("SI");
			}
			else{ 
				CAFE = "NO"; 
				//alert("NO");
			}



			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");
			//$.blockUI({ message: '<h1><img src="busy.gif" /> Por favor espere...</h1>' });
			//Cantidad Color  Alto Ancho


			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
			    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
			    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
			    	typeof Alto == "undefined" || Alto == null || Alto == ""){
			    	
			    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
			    		return false;

			    } else {

					$.post("cotizarprecio.php", { Color : Color, Tela : Tela, TipoTela : TipoTela, Clave : Clave, Ancho : Ancho,
												  Alto : Alto, Stiffener : Stiffener, ForroX : "NO", BajoPlomo:BajoPlomo, CAFE:CAFE }, function(data2){
					   	$("#precio").html(data2);
					   	$("#precio").show();
					   	$("#cargando").css("display", "none");
					   	//PrecioFinalCortina = $("#PrecioFinal").val();
					   	$("#BtnD").css("display", "inline");

					   	Formula = $("#Formula").val();
					   	if (Formula =="Bajo Plomo"){
					   		$("#DIVBAJOPLOMO").css("display", "inline");
					   	}
					   	TelaBp = $("#TelaBajoPlomo").val();
					   	if (TelaBp =="SI"){
					   		$("#DIVBAJOPLOMO").css("display", "inline");
					   	}else
					   	{
					   		$("#DIVBAJOPLOMO").css("display", "none");
					   	}
					  					   
					});	


					//alert(BajoPlomo);
					if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
						PrecioForro =0;
						/*$("#PrecioFinalForro").val("0");	
						$("#PrecioFinalForro2").val("$ 0");*/
					}
					else{
						$.post("cotizarprecioforro.php", {ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
														   Ancho : Ancho, Alto : Alto, Stiffener : "NO", ForroX : "SI", BajoPlomo:BajoPlomo,CAFE:CAFE  }, function(data2){
						   	$("#precioforro").html(data2);
						   	$("#precioforro").show();
						   	//alert("si");
						   	/*FinalForro= $("#PrecioFinalForro").val();
						   	PrecioFinalForro1 =$("#PrecioFinalForro").val();
						   	PrecioMoForro1 = $("#PrecioMoForro").val();
						   	MetrajeMo1= $("#MetrajeMo").val();*/
						   
						   	if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
						   		PrecioForro =0;
						   		/*$("#PrecioFinalForro").val("0");	
								$("#PrecioFinalForro2").val("$ 0");*/
						   	}
						   	else{
							   	
							   	if (typeof PrecioFinalForro1 == "undefined" || PrecioFinalForro1 == null ||  PrecioFinalForro1 == "" ||
							   	typeof PrecioMoForro1 == "undefined" || PrecioMoForro1 == null ||  PrecioMoForro1 == "" ||
							   	typeof MetrajeMo1 == "undefined" || MetrajeMo1 == null ||  MetrajeMo1 == ""){
							   		
							   		//PrecioForro =0;
							   }
								else{

									//PrecioForro = parseFloat(PrecioFinalForro1) + (parseFloat(PrecioMoForro1) * parseFloat(MetrajeMo1));
								}
							}

						   //$("#PrecioFinalForro").val((PrecioForro).toFixed(3));	
						   //$("#PrecioFinalForro2").val("$ " + (PrecioForro).format(2));
						   $("#cargando").css("display", "none");
						   $("#BtnD").css("display", "inline");
						   //PrecioFinalForro2

						});
					}		

				}		

		}

		Number.prototype.format = function(n, x) {
		    var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
		    return this.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
		};


		
		function MostrarValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "STIFFENER"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function BajoPlomoFnc() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "BAJO PLOMO"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function GanchoReforzado() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "GANCHO REFORZADO"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function Neverlight() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "NEVER LIGHT"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function Ojillo() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "OjilloCafe"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

	</script>
	

</head>


<body class="menubar-hoverable header-fixed ">
	<div id="content">
		<section>
			<div class="section-body contain-lg">
				<!-- BEGIN SECTION -->
				<form  id="cortina" name="cortina"><!--method="POST" action="index.php?opcion=terminar"-->
					<div class="doc-section">
					
					<?php

					switch ($valor) {
						
						case 'pFr':
							$Nombre = "Plitz Francés"; $valor = 'pFr';
							$ruta = "../../assets/img/tipocortina/plitz frances.jpg";
							break;

						case 'pEs':
							$Nombre = "Plitz Español"; $valor = 'pEs';
							$ruta = "../../assets/img/tipocortina/plitz español.jpg";
							break;

						case 'pPo':
							$Nombre = "Plitz Portugues"; $valor = 'pPo';
							$ruta = "../../assets/img/tipocortina/plitz portugues.jpg";
							break;

						case 'Pre':
							$Nombre = "Presillas"; $valor = 'Pre';
							$ruta = "../../assets/img/tipocortina/presillas.jpg";
							//$Gancho =FALSE;
							break;

						case 'Oji':
							$Nombre = "Ojillos"; $valor = 'Oji';
							$ruta = "../../assets/img/tipocortina/ojillos.jpg";
							break;

						case 'Vis':
							$Nombre = "Visillos"; $valor = 'Vis';
							$ruta = "../../assets/img/tipocortina/visillo.jpg";
							break;

						case 'Ond':
							$Nombre = "Ondulada"; $valor = 'Ond';
							$ruta = "../../assets/img/tipocortina/ondulada.jpg";
							break;

						case 'Fru':
							$Nombre = "Cinta Fruncidora"; $valor = 'Fru';
							$ruta = "../../assets/img/tipocortina/cinta fruncidora.jpg";
							break;
						
						default:

							$valor = '';
							
							break;
					}

					echo '<input type="hidden"  id="tipo" value="'. $valor .'">';
					echo '<input type="hidden"  id="nombre" value="'. $Nombre .'">';
					echo '<input type="hidden"  id="ruta" value="'. $ruta .'">';

					?>

							<!-- PRIMERA COLUMA -->
							<div class="col-lg-offset-1 col-md-5 col-sm-6">
								<div class="card">
									<div class="card-body">
										<div class="card card-outlined style-default-light">
											<div class="card-head">
												<header>
													<h3 class="opacity-50" style="align=center"><?php echo  $Nombre; ?></h3>
												</header>
											</div>
											<div class="card-body no-padding height-7">
												
													<div class="img-backdrop" style="background-image: url('<?php echo $ruta; ?>')"></div>
												
											</div>		
										</div>

										
										<?php 	        	
										if ($valor == 'Oji'){
										echo '<div class="checkbox checkbox-styled tile-text">
											  	<label>
													<input type="checkbox" value="OjilloCafe"  onclick="CargarValor()">
													<span>
														OJILLO CAFE
													</span>
												</label>
											</div>';
										}
										?>

										<div class="form-group">
											<div id="tiras"><h3>Precio</h3></div>
											<div id="precio">
												<div class='form-group'> <input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>
											</div>

									        <div id="precioforro">
									        	<div class='form-group'><input id='PrecioFinalForro' name='PrecioFinalForro' class='form-control' value='0.00' style='text-align: right;' readonly><label><b>PRECIO FORRO:</b></label></div>
									        </div>
									    </div>

										<div class="form-group">


											<div id="tiras"><h3>Área</h3></div>

											<div class="form-group">
												<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Área" required>
												<!--<label>Elije</label>-->
											</div>
										</div>
										
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
									
										<div id="tiras"><h3>Medida</h3></div>

										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
												<div class="input-group-content">
													<input type="text" class="form-control" id="ancho" name="ancho" min="1" step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required><!--onchange="CargarValor()"-->
													<label for="dollars10">Ancho</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
										</div><!--end .form-group -->


										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
												<div class="input-group-content">
													<input type="text" class="form-control" id="alto" name="alto" min="1" step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
													<label for="dollars10">Alto</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
										</div><!--end .form-group -->
										<br>

										<!--<div id="tiras"><h3>Comentarios</h3></div>
												<div class="form-group floating-label">
													<div class="input-group">
														<span class="input-group-addon"><i class="fa fa-comment"></i></span>
														<div class="input-group-content">
															<input type="text" class="form-control" id="cantidad" min="1">
															<label for="dollars10">Comentario</label>
														</div>
														<span class="input-group-addon"></span>
													</div>
												</div><!--end .form-group -->
											
									</div><!--end .form-group -->
								</div><!--end .card-body -->
							</div><!--end .card -->


<!-- SEGUNDA COLUMNA!! ----------------------------------------------------------------- -->


							<div class="col-lg-offset-1 col-md-5 col-sm-6" style="margin-left: 0%;">
								<div class="card">
									<div class="card-body">
										<div class="form">
											<div id="tiras"><h3>Tela</h3></div>

											<div class="form-group">

												<?php

													//echo  date('Y-m-d H:i:s');
													
													$ArregloTipoTela = TraerTipoTela($valor);
													$Filas = count($ArregloTipoTela);
													echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
														
														for( $i=0; $i<$Filas; $i++ ){
															if (($valor=="pEs" or $valor=="pPo") and $ArregloTipoTela[$i]['nombre']=="LUXY"){
																
															} else {
											               		echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';	
											               }
											        	}
											        echo "</select>";
											        //echo $valor;
											        //echo $ArregloTipoTela;
											        //echo  phpinfo() ;
								        		?>
												
												<label>Selecciona el tipo de tela</label>
												
											</div>
											 

											<script type="text/javascript">
												ColorVariable();
											</script>
											<div id="colores"></div>
											<div>(<b>*</b>) Sujeto a disponibilidad</div>
										</div>

										<div id="forros2" class="form">
											<div id="tiras"><h3 style="margin-top: 10px;">Forro</h3></div>

											<div class="form-group">

												<?php
												
													$ArregloTipoTela = TraerForro("FORRO");
													$Filas = count($ArregloTipoTela);

													echo '<select class="form-control" data-placeholder="Select an item" name="TelasForro" id="TelasForro">';
														
														for( $i=0; $i<$Filas; $i++ ){
											               echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';
											        	}

											        echo "</select>";
								        		?>
												
												<label>Selecciona el forro</label>

											</div>
											 

											<script type="text/javascript">
												ColorVariableForro();
											</script>

											<div id="coloresforro"></div>
											<div>(<b>*</b>) Sujeto a disponibilidad</div>
										</div>
									
											
											<div class="form-group">
												<div id="tiras"><h3 style="margin-top: 10px;">Fijación</h3></div>
												<table class="table table-condensed">
													<tr>
														<div class="input-group">
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="fijacion" value="Muro" checked><span>Muro</span>
																	<img src="../../assets/img/opciones/muro.png" style=""  width="80px" height="60px"/>
																</label>
															</td>
															
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="fijacion"  value="Techo" checked><span>Techo</span>
																	<img src="../../assets/img/opciones/techo.png" style=""  width="80px" height="60px"/>
																</label>
															</td>
														</div>
													</tr>
												</table>
											</div>	


											<div class="form-group">
												<div id="tiras"><h3>Acoplamiento</h3></div>
												<table class="table table-condensed">
													<tr>
														<div class="input-group">
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="acoplamiento"  value="Izquierda" id="Izquierda" checked><span>Izquierda 1 hoja </span>
																	<img src="../../assets/img/opciones/izquierda.png" style="" width="50px" height="50px"/>
																</label>
															</td>
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="acoplamiento"  value="Derecha" id="Derecha"  ><span>Derecha 1 hoja </span>
																	<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px"/>
																</label>
															</td>
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="acoplamiento" value="Ambos" id="Ambos" ><span>Ambos 2 hojas</span>
																	<img src="../../assets/img/opciones/Ambas.png" style="" width="50px" height="50px"/>
																</label>
															</td>
														</div>
													</tr>
												</table>
											</div>

										
											<div>
												<div id="tiras"><h3>Variables</h3></div>

											
												<?php
												
													$ArregloAccesorio = TraerAccesorio($valor);

											        foreach($ArregloAccesorio as $ValorAccesorio){

											        	if ($ValorAccesorio['nombre'] == 'STIFFENER'){
											        		$Funcion = "onclick='CargarValor()'";
											        	}
											        	else{
											        		$Funcion ="";
											        	}
											        	
											        	echo '<div class="checkbox checkbox-styled tile-text" data-toggle="tooltip" data-placement="left" title="'.utf8_encode($ValorAccesorio['descripcion']).'">
															  	<label>
																	<input type="checkbox" value="'.$ValorAccesorio['nombre'].'" '. $Funcion .'>
																	<span>
																		'.$ValorAccesorio['nombre'].'
																	</span>
																</label>
															</div>';
											        }

												echo '';
								        		?>

								        		<div id="variables"></div>

								        		

								        		

												<br>
												<div id="cargando" style="display:none; color: green;">Cargando...</div>
												<div id="BtnD" style="display:none;"><button type="button" id="BotonEnviar" onclick="prueba()" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;"  >Agregar</button> <!--onclick="MostrarValor()"--></div>
												<!-- window.location.href='http://192.168.1.20/drapes/html/cotizar/index.php?opcion=terminar2' -->
											</div>
											<br>
										</div><!--end .form-group -->
									</div><!--end .card-body -->
								</div><!--end .card -->								
						</div>
					</div>
				</form>
			</div>
		</section>
	</div>

	<div class="modal fade" id="modalcorreo" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="simpleModalLabel">Información</h4>
				</div>
				<div class="modal-body">
					<p>El "<b>Área</b>" es un campo requerido para poder enviar la cotización. Favor de capturarlo</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

 
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

		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		
		<!-- END JAVASCRIPT -->

</body>
</html>

