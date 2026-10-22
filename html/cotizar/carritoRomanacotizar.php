<?php 
require_once '../fnc/PersianaFnc.php';


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
					echo "<input type='hidden' id='opCantidad' value=".$producto["cantidad"].">";echo "<input type='hidden' id='opArea' value='".(isset($producto["area"]) ? $producto["area"] : "")."'>";
					echo "<input type='hidden' id='opPrecio' value='".(isset($producto["precio"]) ? $producto["precio"] : "")."'>";
					echo "<input type='hidden' id='opPrecioForro' value='".(isset($producto["PrecioFinalForro"]) ? $producto["PrecioFinalForro"] : "")."'>";
					//echo "<br><br><br><br><br><br>";
					echo "<input type='hidden' id='optelaForro' value='".$producto["telaForro"]."'>";
					echo "<input type='hidden' id='opColorForro' value='".$producto["ColorForro"]."'>";
					echo "<input type='hidden' id='opVarilla' value='".$producto["Varilla"]."'>";
					echo "<input type='hidden' id='opHojas' value='".(isset($producto["hojas"]) ? $producto["hojas"] : (isset($producto["cantidadHojas"]) ? $producto["cantidadHojas"] : "1"))."'>";
					echo "<input type='hidden' id='opLadoCordon' value='".(isset($producto["lado_cordon"]) ? $producto["lado_cordon"] : "DERECHO")."'>";
					echo "<input type='hidden' id='opFijacion' value='".(isset($producto["fijacion"]) ? $producto["fijacion"] : "TECHO")."'>";

				}
			}
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
		<title>Cotizar Romana</title>
		<!-- BEGIN META -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="keywords" content="cotizador,dues">
		<meta name="description" content="Cotizador Dues Drapes">
		<!-- END META -->

		<!-- BEGIN STYLESHEETS -->
		<link href='http://fonts.googleapis.com/css?family=Roboto:300italic,400italic,300,400,500,700,900' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/bootstrap.css?1422792965" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/materialadmin.css?1425466319" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/font-awesome.min.css?1422529194" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/animacion/slider.css" />
		<style>#slider { margin: 10px; }	</style>
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/select2/select2.css?1424887856" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/jquery-ui/jquery-ui-theme.css" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/typeahead/typeahead.css?1424887863" />
		<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862" />
		


		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  		<script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
  		<script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>

		<!-- Tooltip Styling -->
		<style>
			#infoButtonTrigger {
				background: none;
				border: none;
				cursor: pointer;
				padding: 0 5px;
				vertical-align: middle;
				position: relative;
			}

			#infoButtonTrigger:hover {
				opacity: 0.7;
			}

			.info-tooltip {
				position: absolute;
				top: 50%;
				left: calc(100% + 15px);
				transform: translateY(-50%);
				background-color: #ffffff;
				opacity: 1 !important;
				border: 1px solid #ccc;
				border-radius: 4px;
				box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
				padding: 10px;
				display: none;
				z-index: 10000;
				min-width: 150px;
			}

			.info-tooltip.show {
				display: block;
			}

			.info-tooltip-content {
				text-align: center;
			}

			.info-tooltip-image {
				max-width: 146px;
				max-height: 212px;
				overflow: hidden;
				display: flex;
				align-items: center;
				justify-content: center;
				background-color: #ffffff;
			}

			.info-tooltip-image img {
				max-width: 100%;
				max-height: 100%;
				object-fit: contain;
			}

			.info-tooltip-text {
				margin-top: 10px;
				font-size: 12px;
				color: #333;
			}

			.info-tooltip-text p {
				margin: 5px 0;
				line-height: 1.4;
			}
		</style>

  		<SCRIPT TYPE="text/javascript">
		var colorInicialAplicado = false;
		var colorForroInicialAplicado = false;

  		$(document).ready(function(){
			//— Inicializar la lógica de cinta transparente XL al cargar la página
			var telaInicialSeleccionada = $("#Telas option:selected").html();
			var cortineroseasyInit = ['NALU', 'KAIRA', 'SAMARA', 'TALA'];
			if ($("#cinta").length) {
				if (cortineroseasyInit.includes(telaInicialSeleccionada)) {
					$("#cinta_blanco").hide();
					$("#cinta_negro").hide();
					$("#cinta_transparente").hide();
					$("#cinta_transparente_xl").show().prop('selected', true);
					$("#div_easywave").show();
				} else {
					$("#div_easywave").hide();
					$("#cinta_blanco").show();
					$("#cinta_negro").show();
					$("#cinta_transparente").show();
					$("#cinta_transparente_xl").hide();
				}
			}

			//— Tooltip hover
			var tooltip = $('#infoTooltip');
			var button = $('#infoButtonTrigger');

			button.mouseenter(function() {
				tooltip.addClass('show');
			});

			button.mouseleave(function() {
				tooltip.removeClass('show');
			});

			tooltip.mouseenter(function() {
				tooltip.addClass('show');
			});

			tooltip.mouseleave(function() {
				tooltip.removeClass('show');
			});

			$("#opc_varilla").change(function () {
				CargarValor();
			});


  			$("#pacheto").submit(function(e) {
				e.preventDefault();

				tela= $("#Telas option:selected").html();
			    nombre = "Cortina Romana ";
			    Color= $("input[name='color']:checked").val();

			    Cantidad = $("#cantidad").val();
			    precioFinal = $.trim($("#PrecioFinalMain").val() || "");
			    if (precioFinal === "" || isNaN(parseFloat(precioFinal)) || parseFloat(precioFinal) <= 0) {
			    	precioFinal = $.trim($("#opPrecio").val() || "");
			    }
			    
			    //ColorForro = $("input[name='colorforro']:checked").val();
			    Codigo = $("#CodigoComodin").val();

			    CodigoTela = $("#CodigoTela").val();
				PrecioTela = $("#PrecioTela").val();

				CodigoMecanismo = $("#CodigoMecanismo").val();
				PrecioMecanismo  = $("#PrecioMecanismo").val();
			    
			    Ancho = $("#ancho").val();
				Alto = $("#alto").val();
				area = $("#autocomplete1").val();
				Hojas = $("#hojas").val();
				LadoCordon = $("#lado_cordon").val();
				Fijacion = $("#fijacion").val();
				
				Var = VarillaValor();
				if (Var == "TRUE"){
					Varilla = "SI";
				}
				else{
					Varilla = "NO";
				}
				ruta = (Varilla === "SI") ? '../../assets/img/tipopersiana/romana.jpg' : '../../assets/img/tipopersiana/pacheto.jpg';

				telaForro = $("#TelasForro option:selected").html();
			    ColorForro = $("input[name='colorforro']:checked").val();
			    PrecioFinalForro = $("#PrecioFinalForro").val();
			    CodigoTelaForro = $("#CodigoTelaForro").val();
			    PrecioTelaForro = $("#PrecioTelaForro").val();
			    //alert(ColorForro);
			    //id="romana*"+Codigo+'*'+Ancho+'*'+Alto+'*'+Codigo+'*'+Color;
			     id = $("#opID").val(); 

			    if (typeof area == "undefined" || area == null || area == "") {
			    	alert("Favor de indicar el área.");
			    	return false;
			    }

			    if (typeof Color == "undefined" || Color == null ||
			    	typeof Cantidad == "undefined" || Cantidad == null || Cantidad == "" ||
			    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
			    	typeof Alto == "undefined" || Alto == null || Alto == "") {
			    	alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
			    	return false;
			    }

			    if (precioFinal === "" || isNaN(parseFloat(precioFinal)) || parseFloat(precioFinal) <= 0) {
			    	alert("No se pudo calcular el precio. Intenta cambiar tela o medidas para recalcular.");
			    	return false;
			    }

			    if (typeof ColorForro == "undefined" || ColorForro == null || ColorForro == "") {
				    	var data = {area:area,Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, TipoArticuloDetalle:"romana",
				    								 codigo:Codigo, tela : tela, color : Color, CodigoTela : CodigoTela, PrecioTela:PrecioTela,
				    								 CodigoMecanismo: CodigoMecanismo, PrecioMecanismo:PrecioMecanismo,
				    								 tipoarticulo:'romana', ruta : ruta, Varilla: Varilla, hojas: Hojas, lado_cordon: LadoCordon, fijacion: Fijacion, old_id: $("#opID").val() };
				    	if (CodigoMecanismo == null || CodigoMecanismo == "" || PrecioMecanismo == null || PrecioMecanismo == "" || PrecioMecanismo == "0"){
				    		delete data.CodigoMecanismo;
				    		delete data.PrecioMecanismo;
				    	}
				    	// VERIFICACIÓN: Log completo antes de enviar
				    	console.log('[ANTES DEL POST] Checkbox checked:', $("#opc_varilla").is(":checked"));
				    	console.log('[ANTES DEL POST] VarillaValor():', VarillaValor());
				    	console.log('[ANTES DEL POST] Variable Varilla:', Varilla);
				    	console.log('[DEBUG] POST data (sin forro):', JSON.stringify(data));
				    	$.post("LlenarCarrito.php", data, function(data2){
							console.log('[DEBUG] LlenarCarrito respuesta:', data2);
							window.location.href = "index.php?opcion=terminar";
						});	
				    }else{


				    	var precioBase = parseFloat(precioFinal) || 0;
				    	if (precioBase <= 0) {
				    		precioBase = parseFloat($.trim($("#opPrecio").val() || "0")) || 0;
				    	}
				    	var precioForro = parseFloat(PrecioFinalForro) || 0;
				    	precioFinal2=(precioBase + precioForro).toFixed(2);
				    	var data = {area:area,Cantidad : Cantidad, precioFinal : precioFinal2, nombre: nombre, id:id, ancho:Ancho, alto:Alto, TipoArticuloDetalle:"romana",
				    								 codigo:Codigo, tela : tela, color : Color, CodigoTela : CodigoTela, PrecioTela:PrecioTela,
				    								 CodigoMecanismo: CodigoMecanismo, PrecioMecanismo:PrecioMecanismo,
				    								 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro,
				    								 CodigoTelaForro:CodigoTelaForro,PrecioTelaForro:PrecioTelaForro,
				    								 tipoarticulo:'romana', ruta : ruta, Varilla: Varilla, hojas: Hojas, lado_cordon: LadoCordon, fijacion: Fijacion, old_id: $("#opID").val() };
				    	if (CodigoMecanismo == null || CodigoMecanismo == "" || PrecioMecanismo == null || PrecioMecanismo == "" || PrecioMecanismo == "0"){
				    		delete data.CodigoMecanismo;
				    		delete data.PrecioMecanismo;
				    	}
				    	// VERIFICACIÓN: Log completo antes de enviar
				    	console.log('[ANTES DEL POST] Checkbox checked:', $("#opc_varilla").is(":checked"));
				    	console.log('[ANTES DEL POST] VarillaValor():', VarillaValor());
				    	console.log('[ANTES DEL POST] Variable Varilla:', Varilla);
				    	console.log('[DEBUG] POST data (con forro):', JSON.stringify(data));
				    	$.post("LlenarCarrito.php", data, function(data2){
							console.log('[DEBUG] LlenarCarrito respuesta:', data2);
						window.location.href = "index.php?opcion=terminar";
					});

			    	}
			   
			});
			
			$("#Telas").change(function () {
				$("#colores").hide();
				// Conserva el precio actual hasta que termine el nuevo recálculo.
				//$("#PrecioFinal").val('0.00');
				//$("#variables").hide();
				//$("#cargando").show();
				
				// Cintas transparentes XL logic
				var telaSeleccionada = $(this).find('option:selected').html();
				var cortineroseasy = ['NALU', 'KAIRA', 'SAMARA', 'TALA'];
				if ($("#cinta").length) {
					if (cortineroseasy.includes(telaSeleccionada)) {
						$("#cinta_blanco").hide();
						$("#cinta_negro").hide();
						$("#cinta_transparente").hide();
						$("#cinta_transparente_xl").show().prop('selected', true);
						$("#div_easywave").show();
					} else {
						$("#div_easywave").hide();
						$("#cinta_blanco").show();
						$("#cinta_negro").show();
						$("#cinta_transparente").show();
						$("#cinta_transparente_xl").hide();
					}
				}
				
				ColorVariable();				
			})

			$("#TelasForro").change(function () {
				$("#coloresforro").hide();
				// Conserva el precio actual hasta que termine el nuevo recálculo.
				//$("#PrecioFinalForro").val('0.00');
				
				//$("#variables").hide();
				//$("#cargando").show();
				ColorVariableForro();				

			})

		});


		function VarillaValor() {
			var Devolver = 'FALSE';
			if ($("#opc_varilla").is(":checked")) {
				Devolver = 'TRUE';
			}
			return Devolver;
		}

		function InicializarPrecioDesdeCarrito(){
			var precioOriginal = $.trim($("#opPrecio").val() || "");
			var precioForroOriginal = $.trim($("#opPrecioForro").val() || "");

			if (precioOriginal !== "") {
				$("#PrecioFinalMain").val(precioOriginal);
			}
			if (precioForroOriginal !== "") {
				$("#PrecioFinalForro").val(precioForroOriginal);
			}
			MostrarPrecioPrincipal(true);
		}

		function FormatearMonedaMX(valor){
			var numero = parseFloat(valor);
			if (!isFinite(numero)) {
				numero = 0;
			}
			return numero.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
		}

		function ExtraerPrecioDesdeHtml(html, idHidden, idVisible){
			var $tmp = $("<div>").html(html);
			var n = parseFloat($.trim($tmp.find("#" + idHidden).val() || ""));
			if (isFinite(n) && n > 0) {
				return n;
			}

			var texto = $.trim($tmp.find("#" + idVisible).val() || "");
			if (texto !== "") {
				var limpio = texto.replace(/[^0-9.,-]/g, "").replace(/,/g, "");
				n = parseFloat(limpio);
				if (isFinite(n) && n > 0) {
					return n;
				}
			}
			return 0;
		}

		function ObtenerPrecioRecalculado(){
			var precioHidden = parseFloat($.trim($("#PrecioFinalMain").val() || ""));
			if (isFinite(precioHidden) && precioHidden > 0) {
				return precioHidden;
			}

			var precioFragmento = parseFloat($.trim($("#precio #PrecioFinal").val() || ""));
			if (isFinite(precioFragmento) && precioFragmento > 0) {
				return precioFragmento;
			}

			var precioTexto = $.trim($("#precio #PrecioFinal2").val() || "");
			if (precioTexto !== "") {
				var limpio = precioTexto.replace(/[^0-9.,-]/g, "");
				limpio = limpio.replace(/,/g, "");
				var precioVisible = parseFloat(limpio);
				if (isFinite(precioVisible) && precioVisible > 0) {
					return precioVisible;
				}
			}

			return 0;
		}

		function ObtenerCantidadActual(){
			var cantidad = parseInt($.trim($("#cantidad").val() || "1"), 10);
			if (!isFinite(cantidad) || cantidad <= 0) {
				cantidad = 1;
			}
			return cantidad;
		}

		function MostrarPrecioPrincipal(usarOriginalSiVacio){
			var precioUnitario = ObtenerPrecioRecalculado();
			if ((precioUnitario <= 0 || !isFinite(precioUnitario)) && usarOriginalSiVacio) {
				var precioOriginal = parseFloat($.trim($("#opPrecio").val() || "0"));
				if (isFinite(precioOriginal) && precioOriginal > 0) {
					precioUnitario = precioOriginal;
					$("#PrecioFinalMain").val(precioOriginal.toFixed(2));
				}
			}

			if (!isFinite(precioUnitario) || precioUnitario < 0) {
				precioUnitario = 0;
			}

			var cantidad = ObtenerCantidadActual();
			var precioTotal = precioUnitario * cantidad;

			var texto = "Precio Total $" + FormatearMonedaMX(precioTotal) + " MXP";
			if ($("#PrecioFinalVista").length === 0) {
				$("#precio").append("<div id='PrecioFinalVista' style='font-weight: bold; margin-top: 6px;'>" + texto + "</div>");
			} else {
				$("#PrecioFinalVista").text(texto);
			}
		}

		function AsegurarColorPrincipalSeleccionado(){
			var colorActual = $("input[name='color']:checked").val();
			if (!colorActual) {
				var primerColor = $("input[name='color']").first();
				if (primerColor.length) {
					primerColor.prop("checked", true);
					colorActual = primerColor.val();
				}
			}
			return colorActual;
		}

		function CargarValor(){
			
			Tela = $("#Telas option:selected").html();
			Color = AsegurarColorPrincipalSeleccionado();
			Ancho = $("#ancho").val();
			Alto = $("#alto").val();
			Cantidad = $("#cantidad").val();
			
			Var = VarillaValor();
			if (Var == "TRUE"){
				Varilla = "SI";
			}
			else{
				Varilla = "NO";
			}
			var rutaImagen = (Varilla === "SI") ? '../../assets/img/tipopersiana/romana.jpg' : '../../assets/img/tipopersiana/pacheto.jpg';
			$("#imagen_romana").css("background-image", "url('" + rutaImagen + "')");

			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");


			TelaForro=$("#TelasForro option:selected").html();
			TipoTelaForro=$("#TelasForro option:selected").val();
			ColorForro = $("input[name='colorforro']:checked").val();


			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
			    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
			    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
			    	typeof Alto == "undefined" || Alto == null || Alto == ""){
			    	
			    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
			    		return false;
			} 

			  else {

				$.post("PachetoCotizarPrecio.php", { Alto : Alto, Ancho : Ancho, Tela : Tela, Varilla : Varilla , Color : Color, Cantidad: 1, ForroX: "NO"}, function(data2){
				   var precioCalculado = ExtraerPrecioDesdeHtml(data2, "PrecioFinal", "PrecioFinal2");
				   if (isFinite(precioCalculado) && precioCalculado > 0) {
				   	$("#PrecioFinalMain").val(precioCalculado.toFixed(2));
				   	$("#opPrecio").val(precioCalculado.toFixed(2));
				   }
				   $("#precio").html(data2);
				   $("#precio").show();
				   MostrarPrecioPrincipal(false);
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");
				});	

				$.post("PachetoCotizarPrecioForro.php", { Alto : Alto, Ancho : Ancho, Tela : TelaForro, Varilla : Varilla , Color : ColorForro, Cantidad: 1, ForroX: "SI"}, function(data2){
				   $("#precioforro").html(data2);
				   $("#precioforro").show();
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");
				});

			}
		
		}



  		function ColorVariable(){

			 $("#Telas option:selected").each(function () {
				    //elegido=$(this).val();
				    	
				    elegido=$("#Telas option:selected").html();
				    //elegidoForro = $("#TelasForro option:selected").html();
				    tipo = $(this).val();


					/*$.post("cotizarvariables.php", { tipo: tipo }, function(data){
					    $("#variables").html(data);
					    $("#variables").show();
			    	});*/
			 		Color = $("input[name='color']:checked").val();
			 		if (!colorInicialAplicado) {
			 			var colorInicial = $.trim($("#opColor").val() || "");
			 			if (colorInicial !== "") {
			 				Color = colorInicial;
			 			}
			 			colorInicialAplicado = true;
			 		}

				   $.post("cotizarcolores.php", { elegido: elegido, Color:Color }, function(data1){
					    $("#colores").html(data1);
					    $("#colores").show();
					    if (Color && $("#" + Color).length){
					    	$("#" + Color).prop("checked", true);
					    } else {
					    	var primerColor = $("input[name='color']").first();
					    	if (primerColor.length) {
					    		primerColor.prop("checked", true);
					    	}
					    }
					    CargarValor();
			    	});

				  /* 	$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});*/
  
			});
		}


		 function ColorVariableForro(){

			 $("#TelasForro option:selected").each(function () {

				    elegidoForro = $("#TelasForro option:selected").html();
				    ColorForro = $("input[name='colorforro']:checked").val();
				    if (!colorForroInicialAplicado) {
				    	var colorForroInicial = $.trim($("#opColorForro").val() || "");
				    	if (colorForroInicial !== "") {
				    		ColorForro = colorForroInicial;
				    	}
				    	colorForroInicialAplicado = true;
				    }

				   	$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro,ColorForro:ColorForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
					    if (ColorForro && $("#" + ColorForro).length){
					    	$("#" + ColorForro).prop("checked", true);
					    }
					    CargarValor();
			    	});

  			});
		}


		function CambiarCombo(){
			
            Tela = $("#opTela").val(); 
            //alert(Tela);

             $('#Telas option').filter(function () 
             	{ return $(this).html() == Tela; }).attr("selected", "selected");


             alto = $("#opAlto").val();
             ancho = $("#opAncho").val();
             cantidad = $("#opCantidad").val();
             area = $("#opArea").val();
             
             $("#alto").val(alto);
             $("#ancho").val(ancho);
             $("#cantidad").val(cantidad);
             $("#autocomplete1").val(area);

		}

		function CambiarForro(){
			TelaForro = $("#optelaForro").val(); 
			//alert(TelaForro);

             $('#TelasForro option').filter(function () 
             	{ return $(this).html() == TelaForro; }).attr("selected", "selected");
		}

		function CambiarVarilla(){
			var Varilla = $.trim($("#opVarilla").val() || "").toUpperCase();
			$("#opc_varilla").prop("checked", Varilla === "SI");
		}

		function CambiarParametrosRomana(){
			var hojas = $.trim($("#opHojas").val() || "1");
			var lado = $.trim($("#opLadoCordon").val() || "DERECHO").toUpperCase();
			var fijacion = $.trim($("#opFijacion").val() || "TECHO").toUpperCase();

			$("#hojas").val(hojas);
			$("#lado_cordon").val(lado);
			$("#fijacion").val(fijacion);
		}

		

  		</SCRIPT>

				<!-- END STYLESHEETS -->

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script type="text/javascript" src="../../assets/js/libs/utils/html5shiv.js?1403934957"></script>
		<script type="text/javascript" src="../../assets/js/libs/utils/respond.min.js?1403934956"></script>
		<![endif]-->
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
								
								<div class="form">
									<div class="card card-outlined style-default-light">
										<div class="card-head">
											<header>
												<h3 class="opacity-50" style="align=center">Romana</h3>
											</header>
										</div>
										<div class="card-body no-padding height-8">
											<a href="">
												<div id="imagen_romana" class="img-backdrop" style="background-image: url('../../assets/img/tipopersiana/romana.jpg')"></div>
											</a>
										</div>		
									</div>

									<div id="tiras"><h3>Espacio</h3></div>

									<div class="form-group">
										<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio">
									</div>

									<div id="tiras"><h3>Precio</h3></div>
									<input type='hidden' id='PrecioFinalMain' value='0.00'>
									<div id="precio">
										<div class='form-group'>
											<input type='hidden' class='form-control' name='PrecioFinal' value='0.00' readonly>
											<label><b>PRECIO TOTAL:</b></label>
											<div id='PrecioFinalVista' style='font-weight: bold;'>Precio Total $0.00 MXP</div>
										</div>
									</div>
									<div id="precioforro">
										<div class='form-group'><input id='PrecioFinalForro' class='form-control' name='PrecioFinalForro' value='0.00' style='text-align: right;' readonly><label><b>PRECIO FORRO:</b></label></div>
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
												<input type="tel" class="form-control" id="ancho" step="0.1" min="1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
												<label for="dollars10">Ancho</label>
											</div>
											<span class="input-group-addon">mts.</span>
										</div>
									</div><!--end .form-group -->


									<div class="form-group floating-label">
										<div class="input-group">
											<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
											<div class="input-group-content">
												<input type="tel" class="form-control" id="alto" step="0.1" min="1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
												<label for="dollars10">Alto</label>
											</div>
											<span class="input-group-addon">mts.</span>
										</div>
									</div><!--end .form-group -->	

									
								</div>

								</div>
							</div>
						</div>
					</div>


					<div class="col-lg-offset-1 col-md-5 col-sm-6" style="margin-left: 0%;">
						<div class="card">
							<div class="card-body">
								< class="form">
								
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
										InicializarPrecioDesdeCarrito();
										ColorVariable();
									</script>
									<div id="colores"></div>

									<!-- CHECKBOX VARILLA -->
									<!--<div class="form-group">
										<div class="checkbox checkbox-styled">
											<label>
												<input type="checkbox" name="opc_varilla" id="opc_varilla" value="SI">
												<span>Incluir Varilla</span>
												<button type="button" id="infoButtonTrigger" style="margin-left: 10px; padding: 0; border: none; background: none; cursor: pointer; position: relative; vertical-align: middle;">
													<i class="bi bi-info-circle-fill" style="font-size: 1.2em; color: #0066cc;"></i>
													<div id="infoTooltip" class="info-tooltip">
														<div class="info-tooltip-content">
															<div class="info-tooltip-image">
																<img src="../../assets/img/tipoimagen/ImagenLateralEasyWave2.jpg" alt="Varilla" style="max-width: 100%; max-height: 100%;">
															</div>
														</div>
													</div>
												</button>
											</label>
										</div>
									</div>-->

									<!-- NUEVO CHECKBOX VARILLA-->
								<div class= "chekbox-styled title text">
									<label>
										<input type="checkbox" id="opc_varilla" name="opc_varilla" value="SI" onchange='CargarValor()'>
										<span>Incluir varilla</span>
										<button type="button" id="infoButtonTrigger" style="margin-left: 10px; padding: 0; border: none; background: none; cursor: pointer; position: relative; vertical-align: middle;">
											<i class="bi bi-info-circle-fill" style="font-size: 1.2em; color: #0066cc;"></i>
											<div id="infoTooltip" class="info-tooltip">
												<div class="info-tooltip-content">
													<div class="info-tooltip-image">
														<img src="../../assets/img/tipoimagen/ImagenLateralEasyWave2.jpg" alt="Varilla" style="max-width: 100%; max-height: 100%;">
													</div>
												</div>

											<div class="form-group" style="margin-top: 12px;">
												<label for="hojas">Hoja</label>
												<select id="hojas" name="hojas" class="form-control" onchange="CargarValor()">
													<option value="1">1 Hoja</option>
													<option value="2">2 Hojas</option>
												</select>
											</div>

											<div class="form-group">
												<label for="lado_cordon">Lado del Cordón/Mecanismo</label>
												<select id="lado_cordon" name="lado_cordon" class="form-control" onchange="CargarValor()">
													<option value="DERECHO">Derecho</option>
													<option value="IZQUIERDO">Izquierdo</option>
												</select>
											</div>

											<div class="form-group">
												<label for="fijacion">Tipo de Fijación</label>
												<select id="fijacion" name="fijacion" class="form-control" onchange="CargarValor()">
													<option value="TECHO">Techo</option>
													<option value="PARED">Pared</option>
												</select>
											</div>

									<script type="text/javascript">
										CambiarVarilla();
												CambiarParametrosRomana();
									</script>

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
										<label>Selecciona el tipo de tela</label>
									</div>

									<script type="text/javascript">
										CambiarForro();
										InicializarPrecioDesdeCarrito();
										ColorVariableForro();
									</script>

									<!-- Ribbon Options -->
									<div class="form-group">
										<select class="form-control" id="cinta" name="cinta" style="display: none;">
											<option id="cinta_blanco" value="Blanco">Cinta Blanca</option>
											<option id="cinta_negro" value="Negro">Cinta Negra</option>
											<option id="cinta_transparente" value="Transparente">Cinta Transparente</option>
											<option id="cinta_transparente_xl" value="Transparente XL">Cinta Transparente XL</option>
										</select>
										<div id="div_easywave" style="display: none; margin-top: 10px; padding: 10px; background-color: #f0f0f0; border-radius: 4px;">
											<strong>Sistema EasyWave activado</strong><br/>
											<small>Se ha seleccionado cinta transparente XL para este tipo de tela.</small>
										</div>
									</div>

									<div id="coloresforro"></div>
																	
								<br>	
								
								
								<br>
								<div id="cargando" style="display:none; color: green;">Cargando...</div>
								<div id="BtnD" style="display:none;"><button type="submit" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;">Guardar cambios</button></div>
								<!--<button type="button" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;"  onclick="window.location.href='http://192.168.1.20/drapes/html/cotizar/index.php?opcion=terminar2'" >Agregar</button>-->
							
							</div><!--end .card-body -->
						</div><!--end .card -->							
					</div>
				</div>
			</div>
		</section>
	</div>
	</form>

	 <script src="../../assets/js/imgmodal/ekko-lightbox.js"></div>

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
		<!--<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/core/source/App.js"></script>-->
		<script src="../../assets/js/core/source/App.js"></script>
		<!--<script src="../../assets/js/libs/bootstrap/bootstrap.min.js"></script>-->
		<script src="../../assets/js/libs/select2/select2.min.js"></script>
		<script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
		<script src="../../assets/js/core/demo/Demo.js"></script>
		<script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
		<!-- END JAVASCRIPT -->

</body>
</html>
