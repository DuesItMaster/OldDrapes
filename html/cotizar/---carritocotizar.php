<?php
	require_once '../fnc/CortinaFnc.php';

	$valor = $_GET['opc'];
	$Gancho = TRUE;
	$TipoTela ="";

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

					echo "<input type='hidden' id='opArea' value='".$producto["area"]."'>";

					echo "<input type='hidden' id='opAlto' value=".$producto["alto"].">";
					echo "<input type='hidden' id='opAncho' value=".$producto["ancho"].">";
					echo "<input type='hidden' id='opCantidad' value=".$producto["cantidad"].">";


					echo "<input type='hidden' id='optelaForro' value='".$producto["telaForro"]."'>";
					echo "<input type='hidden' id='opColorForro' value='".$producto["ColorForro"]."'>";

					echo "<input type='hidden' id='opAcoplamiento' value=".$producto["acoplamiento"].">";
					echo "<input type='hidden' id='opFijacion' value=".$producto["fijacion"].">";
					//echo "<br><br><br><br><br><br><br><br><br><br>";
					echo "<input type='hidden' id='opBajoplomo' value='".$producto["bajoplomo"]."'>";
					echo "<input type='hidden' id='opStiffener' value='".$producto["stiffener"]."'>";
					echo "<input type='hidden' id='opNeverlight' value='".$producto["neverlight"]."'>";
					echo "<input type='hidden' id='opGancho' value='".$producto["gancho"]."'>";

				}
			}
		}
	}


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
  	 
  	 <!--<script src="../fnc/cotizar.js" type="text/javascript"></script>-->

  	<!-- -->
  	<link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />

  	<!-- END STYLESHEETS -->
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
	<![endif]-->

	<script language="javascript">

		$(document).ready(function(){

			$("#Telas").change(function () {
				$("#colores").hide();
				$("#variables").hide();
				ColorVariable();				
			});

			$("#TelasForro").change(function () {
				$("#coloresforro").hide();
				$("#variables").hide();
				ColorVariableForro();				
			});


			$("#cortina").submit(function() {


				id = $("#opID").val(); 
			    //alert("id " + id);
				tela= $("#Telas option:selected").html();
				//alert(tela);
			    nombre = "Cortina " + $("#nombre").val();
			    //alert(nombre);
			    Color= $("input[name='color']:checked").val();
			    //alert(Color);
			    Cantidad = $("#cantidad").val();
			    //alert(Cantidad);
			    precioFinal = $("#PrecioFinal").val();
				//alert(precioFinal);
			    Codigo = $("#CodigoComodin").val();
			    //alert(Codigo);
			    CodigoTela = $("#CodigoTela").val();
			    //alert(CodigoTela);
			    PrecioTela = $("#PrecioTela").val();
			    //alert(PrecioTela);
			    Metraje = $("#Metraje").val();
			    //alert(Metraje);
			    Ancho = $("#ancho").val();
			    //alert(Ancho);
				Alto = $("#alto").val();
				//alert(Alto);
				CodigoMo = $("#CodigoMo").val();
				//alert(CodigoMo);
				PrecioMo = $("#PrecioMo").val();
				//alert(PrecioMo);
				MetrajeMo = $("#MetrajeMo").val();

			    telaForro = $("#TelasForro option:selected").html();
			    //alert("telaForro " + telaForro);
			    ColorForro = $("input[name='colorforro']:checked").val();
			    //alert("ColorForro " + ColorForro);
			    PrecioFinalForro = $("#PrecioFinalForro").val();
			    //alert("PrecioFinalForro " + PrecioFinalForro);
			    CodigoTelaForro = $("#CodigoTelaForro").val();
			    //alert("CodigoTelaForro " + CodigoTelaForro);
			    PrecioTelaForro = $("#PrecioTelaForro").val();
			    //alert("PrecioTelaForro " + PrecioTelaForro);
			    CodigoMoForro = $("#CodigoMoForro").val();
			    //alert("CodigoMoForro " + CodigoMoForro);
			    PrecioMoForro = $("#PrecioMoForro").val();
			    //alert("PrecioMoForro " + PrecioMoForro);
			    MetrajeForro = $("#MetrajeForro").val();
			    //alert("MetrajeForro " + MetrajeForro);
			    MetrajeMoForro = $("#MetrajeMoForro").val();

			    CodigoBajoPlomo = $("#CodigoBajoPlomo").val();
			    PrecioPlomo = $("#PrecioPlomo").val();
			    MetrajeBajoPlomo = $("#MetrajeBajoPlomo").val();

			    ruta = $("#ruta").val();	
			    //alert("ruta " + ruta);		    
			    
			    Fijacion= $("input[name='fijacion']:checked").val();
			    //alert("Fijacion " + Fijacion);		    
			    Acoplamiento= $("input[name='acoplamiento']:checked").val();
			    //alert("Acoplamiento " + Acoplamiento);		    
			    Tipo= $("#tipo").val();
			    //alert("Tipo " + Tipo);	

			    Sti = MostrarValor();
			    //alert("Sti " + Sti);	
				if (Sti == "TRUE"){ 
					Stiffener = "STIFFENER"; 
					CodigoStiffener = $("#CodigoStiffener").val();
					PrecioStiffener = $("#PrecioStiffener").val();
					 //alert("PrecioStiffener " + PrecioStiffener);	
				}
				else{ 	
					Stiffener = "";
					CodigoStiffener="";
					PrecioStiffener="0"; 
				}

				Bp = BajoPlomoValor();
				if (Bp == "TRUE"){ BajoPlomo = "BAJO PLOMO";  }//alert("BajoPlomo" +  BajoPlomo);
				else{ BajoPlomo = ""; }//alert("No bajo plomo");

				Gr = GanchoReforzadoValor();
				if (Gr == "TRUE"){ Gancho = "GANCHO REFORZADO"; }//alert("Gancho" +  Gancho);
				else{ Gancho = ""; }//alert("No Gancho");

				Nl = NeverlightValor();
				if (Nl == "TRUE"){ Never = "NEVER LIGHT"; }//alert("Never" +  Never);
				else{ Never = ""; } //alert("No Never");


				area = $("#autocomplete1").val(); 
			   //id=Tipo+'*'+Codigo+'*'+Ancho+'*'+Alto+'*'+Fijacion+'*'+Acoplamiento;
			  //alert("ColorForro" +  ColorForro);
 				
 				if (typeof area == "undefined" || area == null  ||  area == ""  ){
			    	 $("#modalcorreo").modal(); 
				    return false;
			    }

			    else{

				    if (typeof Color == "undefined" || Color == null || 
				    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
				    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
				    	typeof Alto == "undefined" || Alto == null || Alto == "") {
				    	alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
				    	return false;
				    } else {

				    	if (precioFinal == 0){

				    		CargarValor();
				    		return false;

				    	}else{

					    	if (typeof ColorForro == "undefined" || ColorForro === null) {

					    		$.post("LlenarCarrito.php", {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
							    								 	codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
							    								 	stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
							    								 	tipoarticulo:'cortina', ruta : ruta, CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo, 			  
							    								 	CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo}, function(data2){ });
					    	}
					    	else{
					    		
					    		//id = id + '*' + telaForro + '*' + ColorForro;

					    		//alert(" Cantidad: " + Cantidad + " .Preciofinal " + precioFinal + " Nombre: " + nombre + " id: " + id );
					    		if (PrecioFinalForro==0) {
					    			
					    		} else {

									id = id + '*' + telaForro + '*' + ColorForro;		    		
						    		precioFinal = parseFloat(precioFinal) + parseFloat(PrecioFinalForro); 

						    		$.post("LlenarCarrito.php", {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
										    								 codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
										    								 stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
										    								 tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,
										    								 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro, PrecioFinalForro : PrecioFinalForro,
										    								 CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro,
										    								 MetrajeForro:MetrajeForro, MetrajeMoForro:MetrajeMoForro,
										    								 CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo   }, function(data2){ });

									window.location.href = "index.php?opcion=terminar";

								}
					    	}
					    }

				    }
				}
			   
			});

		});

		function ColorVariable(){

			 $("#Telas option:selected").each(function () {
				    //elegido=$(this).val();
				    elegido=$("#Telas option:selected").html();
				   // elegidoForro = $("#TelasForro option:selected").html();
				    tipo = $(this).val();


				     Color = $("#opColor").val();
				    $("#"+Color+"").prop("checked", true);


					$.post("cotizarvariables.php", { tipo: tipo }, function(data){
					    $("#variables").html(data);
					    $("#variables").show();
			    	});

				   $.post("cotizarcolores.php", { elegido: elegido, Color:Color }, function(data1){
					    $("#colores").html(data1);
					    $("#colores").show();
			    	});

				   	/*$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});*/
  
			});
		}


		function ColorVariableForro(){

			 $("#TelasForro option:selected").each(function () {
				    //elegido=$(this).val();
				    //elegido=$("#Telas option:selected").html();
				    elegidoForro = $("#TelasForro option:selected").html();
				    tipo = $(this).val();
				    ColorForro = $("#opColorForro").val();

				   	$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro,ColorForro:ColorForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});
  
			});
		}


		function CargarValor(){
			
			Clave =  "<?php echo $valor; ?>";
			Tela=$("#Telas option:selected").html();
			TipoTela=$("#Telas option:selected").val();
			Color= $("input[name='color']:checked").val();
			Ancho = $("#ancho").val();
			Alto = $("#alto").val();
			Cantidad = $("#cantidad").val();
			//alert('Color '+Color);

			TelaForro=$("#TelasForro option:selected").html();
			TipoTelaForro=$("#TelasForro option:selected").val();
			ColorForro = $("input[name='colorforro']:checked").val();

			//alert('ColorForro '+ColorForro);

			Sti = MostrarValor();
			if (Sti == "TRUE"){
				Stiffener = "SI";
			}
			else{
				Stiffener = "NO";
			}

			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");


			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
		    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
		    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
		    	typeof Alto == "undefined" || Alto == null || Alto == ""){
		    	
		    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
		    		return false;

		    } else {

				$.post("cotizarprecio.php", { Color : Color, Tela : Tela, TipoTela : TipoTela, Clave : Clave, Ancho : Ancho,
											  Alto : Alto, Stiffener : Stiffener }, function(data2){
				   $("#precio").html(data2);
				   $("#precio").show();
				   $("#cargando").css("display", "none");
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

				$.post("cotizarprecioforro.php", {ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
												   Ancho : Ancho, Alto : Alto, Stiffener : "NO" }, function(data2){
				   $("#precioforro").html(data2);
				   $("#precioforro").show();
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");
				});	


				if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
						PrecioForro =0;

					}
					else{

						$.post("cotizarprecioforro.php", {ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
														   Ancho : Ancho, Alto : Alto, Stiffener : "NO", ForroX : "SI", BajoPlomo:BajoPlomo,CAFE:CAFE  }, function(data2){
						   	$("#precioforro").html(data2);
						   	$("#precioforro").show();
						   
						   	if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
						   		PrecioForro =0;

						   	}
						   	else{
							   	
							   	if (typeof PrecioFinalForro1 == "undefined" || PrecioFinalForro1 == null ||  PrecioFinalForro1 == "" ||
							   	typeof PrecioMoForro1 == "undefined" || PrecioMoForro1 == null ||  PrecioMoForro1 == "" ||
							   	typeof MetrajeMo1 == "undefined" || MetrajeMo1 == null ||  MetrajeMo1 == ""){

							   }
								else{

								}
							}

						   $("#cargando").css("display", "none");
						   $("#BtnD").css("display", "inline");

						});
					}		
			}

		}


		function MostrarValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "STIFFENER"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function BajoPlomoValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "BAJO PLOMO"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function GanchoReforzadoValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "GANCHO REFORZADO"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function NeverlightValor() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "NEVER LIGHT"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
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
             area = $("#opArea").val();
             

             $("#alto").val(alto);
             $("#ancho").val(ancho);
             $("#cantidad").val(cantidad);
             $("#autocomplete1").val(area);

		}

		function CambiarAcoplamiento(){
			

			acoplamiento = $("#opAcoplamiento").val();
			fijacion = $("#opFijacion").val();
			//alert("acoplamiento: "+acoplamiento);
				
			 $("#"+fijacion+"").prop("checked", true);
			 $("#"+acoplamiento+"").prop("checked", true);

			/*$('input:radio[name=acoplamiento]:nth(0)').attr('checked',true);*/

		}

		function CambiarForro(){
			TelaForro = $("#opTelaForro").val(); 

             $('#TelasForro option').filter(function () 
             	{ return $(this).html() == TelaForro; }).attr("selected", "selected");
		}

		function CambiarVariables(){
			Stiffener = $("#opStiffener").val(); 
			Gancho = $("#opGancho").val(); 
			BajoPlomo = $("#opBajoplomo").val(); 
			Neverlight = $("#opNeverlight").val(); 

			Stiffener = Stiffener.replace(/\s+/g, '');
			Gancho = Gancho.replace(/\s+/g, '');
			BajoPlomo = BajoPlomo.replace(/\s+/g, '');
			Neverlight = Neverlight.replace(/\s+/g, '');

			 $("#"+Stiffener+"").prop("checked", true);
			 $("#"+Gancho+"").prop("checked", true);
			 $("#"+BajoPlomo+"").prop("checked", true);
			 $("#"+Neverlight+"").prop("checked", true);
		}

	</script>
	

</head>


<body class="menubar-hoverable header-fixed ">
	<div id="content">
		<section>
			<div class="section-body contain-lg">
				<!-- BEGIN SECTION -->
				<form method="POST" action="index.php?opcion=terminar" id="cortina" name="cortina">
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
											<div class="card-body no-padding height-8">
												<a href="">
													<div class="img-backdrop" style="background-image: url('<?php echo $ruta; ?>')"></div>
												</a>
											</div>		
										</div>

										<div class="form-group">
											<div id="tiras"><h3>Área</h3></div>

											<div class="form-group">
												<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Área">
												<!--<label>Elije</label>-->
											</div>
										</div>

										<div class="form-group">
											<div id="tiras"><h3>Precio</h3></div>
											<div id="precio">
												<div class='form-group'> <input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00'  style='text-align: right;' readonly><label><b>PRECIO TOTAL:</b></label></div>
											</div>

									        <div id="precioforro">
									        	<div class='form-group'><input id='PrecioFinalForro' name='PrecioFinalForro' class='form-control' value='0.00' style='text-align: right;' readonly><label><b>PRECIO FORRO:</b></label></div>
									        </div>
									    </div>

										
										<div id="tiras"><h3>Cantidad</h3></div>
										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
												<div class="input-group-content">
													<input type="tel" class="form-control" id="cantidad" min="1" onkeypress="ValidaSoloNumeros()"  onkeypress="ValidaSoloNumeros()" onchange="CargarValor()" onkeyup="CargarValor()" required>
													<label for="dollars10">Cantidad de cortinas</label>
												</div>
												<span class="input-group-addon">unidad</span>
											</div>
										</div><!--end .form-group -->
										
										<br>
										
										<div id="tiras"><h3>Medida</h3></div>

										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-arrows-h"></i></span>
												<div class="input-group-content">
													<input type="text" class="form-control" id="ancho" name="ancho" min="1" step="0.1" onkeypress="return NumCheck(event, this)"  onchange="CargarValor()" onkeyup="CargarValor()" required> 
													<label for="dollars10">Ancho</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
										</div><!--end .form-group -->


										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
												<div class="input-group-content">
													<input type="text" class="form-control" id="alto" name="alto" min="1" step="0.1" onkeypress="return NumCheck(event, this)"  onchange="CargarValor()" onkeyup="CargarValor()" required>
													<label for="dollars10">Alto</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
										</div><!--end .form-group -->


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
												
													$ArregloTipoTela = TraerTipoTela($valor);
													$Filas = count($ArregloTipoTela);
													echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
														
														for( $i=0; $i<$Filas; $i++ ){
											               echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';
											        	}
											        echo "</select>";
											        //echo $valor;
											        //echo $ArregloTipoTela;
								        		?>
												
												<label>Selecciona el tipo de tela</label>
											</div>

											<script type="text/javascript">
											    CambiarCombo();
												ColorVariable();
											</script>
											<div id="colores"></div>
										</div>

										<div class="form">
											<div id="tiras"><h3>Forro</h3></div>
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
												CambiarForro();
												ColorVariableForro();
											</script>

											<div id="coloresforro"></div>

										</div>
									
											
											<div class="form-group">
												<div id="tiras"><h3>Fijación</h3></div>
												<table class="table table-condensed">
													<tr>
														<div class="input-group">
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="fijacion" value="Muro" id="Muro" checked><span>Muro</span>
																	<img src="../../assets/img/opciones/muro.png" style=""  width="80px" height="60px"/>
																</label>
															</td>
															
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="fijacion"  value="Techo" id="Techo" checked><span>Techo</span>
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

											<script type="text/javascript">
												CambiarAcoplamiento();
											</script>

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


								        		<script type="text/javascript">
													CambiarVariables();
												</script>

								        		<div id="variables"></div>

								        		

								        		

												<br>
												<div id="cargando" style="display:none; color: green;">Cargando...</div>
												<div id="BtnD" style="display:none;"><button type="submit" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;"   >Guardar cambios</button> <!--onclick="MostrarValor()"--></div>
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
		<script src="../../assets/js/core/source/App.js"></script>
		<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		
		<!-- END JAVASCRIPT -->

</body>
</html>

