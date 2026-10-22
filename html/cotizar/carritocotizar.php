<?php
	require_once '../fnc/CortinaFnc.php'; 

	$tipoArticuloDetalle = $_GET['opc'];
	$valor = $tipoArticuloDetalle;
	if ($tipoArticuloDetalle == 'Easy') {
		$valor = 'Ond';
	}
	$Gancho = TRUE;
	$TipoTela ="";

	//VALIDACION DIMENSIONES//
	$medidasmaximas = TraerMedidasMaximas($valor);

	$cantMed = 0;

	foreach($medidasmaximas as $medidas){
		$medidasVal[$cantMed][0] = $medidas['anchomax'];
		$medidasVal[$cantMed][1] = $medidas['altomax'];
		$cantMed = $cantMed + 1;
	}

	$medidasValJson = json_encode($medidasVal);
	//VALIDACION DIMENSIONES//

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
					echo "<input type='hidden' id='opColorCinta' value='".$producto["colorCinta"]."'>";
					echo "<input type='hidden' id='opCortinaIrregular' value='".(isset($producto["cortinairregular"]) ? $producto["cortinairregular"] : "0")."'>";
					echo "<input type='hidden' id='opHojaIzquierda' value='".(isset($producto["hojaizquierda"]) ? $producto["hojaizquierda"] : "")."'>";
					echo "<input type='hidden' id='opHojaDerecha' value='".(isset($producto["hojaderecha"]) ? $producto["hojaderecha"] : "")."'>";
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

				function toggleCortinaIrregular(show){
			var cortinaIrregularContainer = document.getElementById("cortinaIrregularContainer");
			var cortinaIrregular = document.getElementById("cortinaIrregular");
			if (!cortinaIrregularContainer) {
				return;
			}
			cortinaIrregularContainer.style.display = show ? "block" : "none";
			if (!show) {
				var hojaIzquierda = document.getElementById("hojaIzquierda");
				var hojaDerecha = document.getElementById("hojaDerecha");
				if (cortinaIrregular) {
					cortinaIrregular.checked = false;
				}
				if (hojaIzquierda) {
					hojaIzquierda.value = "";
				}
				if (hojaDerecha) {
					hojaDerecha.value = "";
				}
				setIrregularFieldsEnabled(false);
			}
			toggleHojaFields();
		}

		function setIrregularFieldsEnabled(enabled){
			var hojaIzquierda = document.getElementById("hojaIzquierda");
			var hojaDerecha = document.getElementById("hojaDerecha");
			if (!hojaIzquierda || !hojaDerecha) {
				return;
			}
			hojaIzquierda.disabled = !enabled;
			hojaDerecha.disabled = !enabled;
			if (!enabled) {
				hojaIzquierda.setCustomValidity("");
				hojaDerecha.setCustomValidity("");
			}
		}

		function toggleHojaFields(){
			var hojaFields = document.getElementById("hojaFields");
			var cortinaIrregular = document.getElementById("cortinaIrregular");
			var cortinaIrregularContainer = document.getElementById("cortinaIrregularContainer");
			if (!hojaFields || !cortinaIrregular) {
				return;
			}
			var activa = cortinaIrregular.checked && cortinaIrregularContainer && cortinaIrregularContainer.style.display !== "none";
			hojaFields.style.display = activa ? "block" : "none";
			setIrregularFieldsEnabled(activa);
		}

		function autoFillHojaDerecha(){
			var anchoInicial = parseFloat(document.getElementById("ancho").value) || 0;
			var hojaIzquierda = parseFloat(document.getElementById("hojaIzquierda").value) || 0;
			var hojaDerechaField = document.getElementById("hojaDerecha");
			if (!hojaDerechaField) {
				return;
			}
			var hojaDerechaValue = Math.round((anchoInicial - hojaIzquierda) * 100) / 100;
			if (hojaIzquierda > anchoInicial) {
				hojaDerechaField.value = "";
				return;
			}
			hojaDerechaField.value = hojaDerechaValue;
		}

		function esEasyWave(){
			var tipo = $.trim($("#tipo").val() || "").toLowerCase();
			var nombre = $.trim($("#nombre").val() || "").toLowerCase();
			return tipo === "easy" || nombre === "easywave";
		}

		function aplicarRestriccionCinta(){
			var $cintaSelect = $("select#cinta").first();
			if ($cintaSelect.length === 0) {
				return;
			}

			var $opcionBlanco = $cintaSelect.find("option[value='1']");
			var $opcionTransparente = $cintaSelect.find("option[value='2']");
			var $opcionNegro = $cintaSelect.find("option[value='3']");
			var $opcionXL = $cintaSelect.find("option[value='4']");

			if (esEasyWave()) {
				$opcionBlanco.prop("hidden", true).hide();
				$opcionTransparente.prop("hidden", true).hide();
				$opcionNegro.prop("hidden", true).hide();
				$opcionXL.prop("hidden", false).show();
				$cintaSelect.val("4");
			} else {
				$opcionBlanco.prop("hidden", false).show();
				$opcionTransparente.prop("hidden", false).show();
				$opcionNegro.prop("hidden", false).show();
				$opcionXL.prop("hidden", false).show();
			}
		}


		$(document).ready(function(){

			$("#Telas").change(function () {
				$("#colores").hide();
				$("#variables").hide();
				//NUEVO
				$("#PrecioFinal").val('0.00');
				$("#PrecioFinal2").val('0.00');
				ColorVariable();

				//NUEVO VALIDACION DE BORRAR DATOS CUANDO CAMBIA DE TELA//
				document.getElementById("opColorForro").value ="";
				$("#coloresforro").hide();
				$("#PrecioFinalForro").val('0.00');
				$("#PrecioFinalForro2").val('0.00');
			ColorVariableForro();
			
			// Ejecutar CargarValor para ocultar/mostrar forros según el tipo de tela
			CargarValor();

			});

			var cortinaIrregularActiva = $("#opCortinaIrregular").val();
			var hojaIzquierdaActual = $("#opHojaIzquierda").val();
			var hojaDerechaActual = $("#opHojaDerecha").val();
			$("#hojaIzquierda").val(hojaIzquierdaActual);
			$("#hojaDerecha").val(hojaDerechaActual);
			$("#cortinaIrregular").prop("checked", cortinaIrregularActiva === "1");
			toggleCortinaIrregular($("#Ambos").is(":checked"));
			if ($("#Ambos").is(":checked") && cortinaIrregularActiva === "1") {
				$("#cortinaIrregular").prop("checked", true);
				toggleHojaFields();
			}
			$("input[name='acoplamiento']").on("change", function(){
				toggleCortinaIrregular($("#Ambos").is(":checked"));
			});
			$("#cortinaIrregular").on("change", function(){
				toggleHojaFields();
			});
			$("#hojaIzquierda").on("input", function(){
				autoFillHojaDerecha();
			});

			// HANDLER DEL SUBMIT - Guardar cambios al carrito
			$("form#cortina").submit(function(e) {
				e.preventDefault();

				var FactorPlizaje = 2.5;
				var TipoCortina  = $("#nombre").val();

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
			    MetrajeReal = $("#MetrajeReal").val();
			    MetrajeMOReal = $("#MetrajeMOReal").val();
			    PrecioReal = $("#PrecioReal").val();
			    PrecioMoReal = $("#PrecioMoReal").val();
			    MetrajeBajoPlomoReal = $("#MetrajeBajoPlomoReal").val();
			    MetrajeRealForro = $("#MetrajeRealForro").val();
			    MetrajeMORealForro = $("#MetrajeMORealForro").val();
			    PrecioRealForro = $("#PrecioRealForro").val();
			    PrecioMoRealForro = $("#PrecioMoRealForro").val();

			    ruta = $("#ruta").val();	
			    //alert("ruta " + ruta);		    
			    
			    Fijacion= $("input[name='fijacion']:checked").val();
			    //alert("Fijacion " + Fijacion);		    
			    Acoplamiento= $("input[name='acoplamiento']:checked").val();
			    //alert("Acoplamiento " + Acoplamiento);		    
			    Tipo= $("#tipo").val();
			    TipoCalculo= $("#tipocalculo").val();
			    if ($("#nombre").val() == "Easywave") { Tipo = "Easy"; TipoCalculo = "Ond"; }
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
				if (Gr == "TRUE"){ Gancho = "GANCHO METALICO"; }//alert("Gancho" +  Gancho);
				else{ Gancho = ""; }//alert("No Gancho");

				Nl = NeverlightValor();
				if (Nl == "TRUE"){ Never = "NEVER LIGHT"; }//alert("Never" +  Never);
				else{ Never = ""; } //alert("No Never");

				if(TipoCalculo == "Ond"){
				aplicarRestriccionCinta();
				colorCinta = $("select#cinta option:selected").val();
				if (colorCinta == "1") {
					colorCinta = "Blanco";
				} else if (colorCinta == "2") {
					colorCinta = "Transparente";
				} else if (colorCinta == "3") {
					colorCinta = "Negra";
				} else if (colorCinta == "4") {
					colorCinta = "Transparente XL";
				}
				}else{
					colorCinta = "";
				}

				if (esEasyWave() && colorCinta !== "Transparente XL") {
					alert("Para Easy Wave solo está permitida la cinta Transparente XL.");
					aplicarRestriccionCinta();
					return false;
				}

				area = $("#autocomplete1").val(); 
			   //id=Tipo+'*'+Codigo+'*'+Ancho+'*'+Alto+'*'+Fijacion+'*'+Acoplamiento;
			  //alert("ColorForro" +  ColorForro);

			  //ORIENTACION RAYAS
		      OrientacionRayaCortina = $("#orientacionCortina").val();
		      //ORIENTACION RAYAS
		      cortinairregular = $("#cortinaIrregular").is(":checked") ? "1" : "0";
		      hojaizquierda = cortinairregular === "1" ? $("#hojaIzquierda").val() : "";
		      hojaderecha = cortinairregular === "1" ? $("#hojaDerecha").val() : "";

			  CantidadArgolla = "";
			  CodigoArgolla = "";
			  PrecioArgolla = "";
			  if(TipoCortina=="Ojillos"){
					CantidadArgolla = $("#CantidadArgolla").val();
					CodigoArgolla = $("#CodigoArgolla").val();
					PrecioArgolla = $("#PrecioArgolla").val();
				}
 				
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
					    	if (Sti == "TRUE" && (CodigoStiffener == null || CodigoStiffener == "" || PrecioStiffener == null || PrecioStiffener == "")) {
					    		CargarValor();
					    		return false;
					    	}
					    	if (typeof ColorForro != "undefined" && ColorForro != null && ColorForro != "" && (CodigoTelaForro == null || CodigoTelaForro == "" || CodigoMoForro == null || CodigoMoForro == "" || PrecioTelaForro == null || PrecioTelaForro == "" || PrecioMoForro == null || PrecioMoForro == "")) {
					    		CargarValor();
					    		return false;
					    	}

					    	if (typeof ColorForro == "undefined" || ColorForro === null || ColorForro == "") {

					    		var data = {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
							    								 	codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
							    								 	stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
							    								 	tipoarticulo:'cortina', ruta : ruta, CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo, 			  
							    								 	CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo, colorCinta : colorCinta, CodigoArgolla: CodigoArgolla, CantidadArgolla: CantidadArgolla, PrecioArgolla: PrecioArgolla,MetrajeReal: MetrajeReal, MetrajeMOReal: MetrajeMOReal, PrecioReal: PrecioReal, PrecioMoReal: PrecioMoReal, MetrajeBajoPlomoReal: MetrajeBajoPlomoReal, OrientacionRayaCortina : OrientacionRayaCortina, cortinairregular: cortinairregular, hojaizquierda: hojaizquierda, hojaderecha: hojaderecha};
					    		if (Sti != "TRUE"){
					    			delete data.stiffener;
					    			delete data.CodigoStiffener;
					    			delete data.PrecioStiffener;
					    		}
$.post("LlenarCarrito.php", data, function(data2){ 
				    			window.location.href = "index.php?opcion=terminar";
				    		});

					    	}
					    	else{
					    		
					    		//id = id + '*' + telaForro + '*' + ColorForro;

					    		//alert(" Cantidad: " + Cantidad + " .Preciofinal " + precioFinal + " Nombre: " + nombre + " id: " + id );
					    		if (PrecioFinalForro==0) {
					    			// FIX: Aunque el precio del forro sea 0, si se seleccionó color de forro, debe guardarse
                                    // Esto permite agregar forro aunque por alguna regla de negocio valga 0, o si se acaba de agregar
                                    // Y también permite quitar forro (ColorForro undefined o null arriba maneja el caso de quitar)
                                    
                                    // Si llegamos aquí es porque ColorForro TIENE valor pero PrecioFinalForro es 0
                                    // Debemos guardar igual para reflejar el cambio (ej. agregar forro sin costo o actualización)
                                    
                                    var data = {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
                                        codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
                                        stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
                                        tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,
                                        telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro,
                                        CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro,
                                        MetrajeForro:MetrajeForro, MetrajeMoForro:MetrajeMoForro,
                                        CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo, CodigoArgolla: CodigoArgolla, CantidadArgolla: CantidadArgolla, PrecioArgolla: PrecioArgolla, MetrajeReal: MetrajeReal, MetrajeMOReal: MetrajeMOReal, PrecioReal: PrecioReal, PrecioMoReal: PrecioMoReal, MetrajeRealForro : MetrajeRealForro, MetrajeMORealForro : MetrajeMORealForro, PrecioRealForro : PrecioRealForro, PrecioMoRealForro : PrecioMoRealForro, MetrajeBajoPlomoReal: MetrajeBajoPlomoReal, colorCinta : colorCinta,OrientacionRayaCortina : OrientacionRayaCortina, cortinairregular: cortinairregular, hojaizquierda: hojaizquierda, hojaderecha: hojaderecha };
                                    if (Sti != "TRUE"){
                                    	delete data.stiffener;
                                    	delete data.CodigoStiffener;
                                    	delete data.PrecioStiffener;
                                    }
                                    $.post("LlenarCarrito.php", data, function(data2){ 
                                            window.location.href = "index.php?opcion=terminar";
                                        }); 
					    		} else {

									//id = id + '*' + telaForro + '*' + ColorForro;		    		
						    		precioFinal = parseFloat(precioFinal) + parseFloat(PrecioFinalForro); 

						    		var data = {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
										    								 codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
										    								 stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
										    								 tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,
										    								 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro, PrecioFinalForro : PrecioFinalForro,
										    								 CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro,
										    								 MetrajeForro:MetrajeForro, MetrajeMoForro:MetrajeMoForro,
										    								 CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo, CodigoArgolla: CodigoArgolla, CantidadArgolla: CantidadArgolla, PrecioArgolla: PrecioArgolla, MetrajeReal: MetrajeReal, MetrajeMOReal: MetrajeMOReal, PrecioReal: PrecioReal, PrecioMoReal: PrecioMoReal, MetrajeRealForro : MetrajeRealForro, MetrajeMORealForro : MetrajeMORealForro, PrecioRealForro : PrecioRealForro, PrecioMoRealForro : PrecioMoRealForro, MetrajeBajoPlomoReal: MetrajeBajoPlomoReal, colorCinta : colorCinta,OrientacionRayaCortina : OrientacionRayaCortina, cortinairregular: cortinairregular, hojaizquierda: hojaizquierda, hojaderecha: hojaderecha };
						    		if (Sti != "TRUE"){
						    			delete data.stiffener;
						    			delete data.CodigoStiffener;
						    			delete data.PrecioStiffener;
						    		}
						    		$.post("LlenarCarrito.php", data, function(data2){ 
				    			window.location.href = "index.php?opcion=terminar";
				    		});

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
				    ColorForro = $("#opColorForro").val(); //opColorForro

				   	$.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro,ColorForro:ColorForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});
  
			});
		}


		function CargarValor(){
			//VALIDACION DIMENSIONES//
			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");
			//VALIDACION DIMENSIONES//

			var Argolla = "NO";
			var FactorPlizaje = 2.5;
			var TipoCortina  = $("#nombre").val();
			Clave =  "<?php echo $valor; ?>";
			Tela=$("#Telas option:selected").html();
			TipoTela=$("#Telas option:selected").val();
			
			// OCULTAR/MOSTRAR FORROS AL INICIO - ANTES DE VALIDACIONES
			if (["TRANSLUCIDA","FRESCURA"].includes(TipoTela)) {
				$("#forros2").hide();
			} else {
				$("#forros2").show();
			}
			
			Color= $("input[name='color']:checked").val();
			Ancho = $("#ancho").val();
			Alto = $("#alto").val();
			Cantidad = $("#cantidad").val();
			//alert('Color '+Color);

			TelaForro=$("#TelasForro option:selected").html();
			TipoTelaForro=$("#TelasForro option:selected").val();
			ColorForro = $("input[name='colorforro']:checked").val();

			if (!$("#forros2").is(":visible")) {
				ColorForro = "";
				CodigoTelaForro = "";
				PrecioFinalForro = 0;
				$("#PrecioFinalForro").val('0.00');
				$("#PrecioFinalForro2").val('0.00');
				$("#precioforro").hide();
			}

			//NUEVO PARA CINTA RIPPLEFOLD
			if(Clave == "Ond"){
				$("select#cinta").closest("div[id='cinta']").css("display", "inline");
				aplicarRestriccionCinta();
				Cinta = $("select#cinta option:selected").val();
				console.log(Cinta);
			}else{
				Cinta = "";
				console.log(Cinta);
				$("select#cinta").closest("div[id='cinta']").css("display", "none");
			}

			//alert('ColorForro '+ColorForro);
			CantidadArgolla = $("#CantidadArgolla").val();
			CodigoArgolla = $("#CodigoArgolla").val();
			PrecioArgolla = $("#PrecioArgolla").val();

			if(TipoCortina=="Ojillos"){
				Argolla = "SI";
				/*CantidadArgolla = Math.ceil((Ancho * FactorPlizaje) / .18);
				if (CantidadArgolla%2 != 0){
					CantidadArgolla = CantidadArgolla + 1;
				}*/
			}

			Sti = MostrarValor();
			if (Sti == "TRUE"){
				Stiffener = "SI";
			}
			else{
				Stiffener = "NO";
			}

			Bp = BajoPlomoValor();
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

			//VALIDACION DIMENSIONES//

			Acoplamiento= $("input[name='acoplamiento']:checked").val();
			//var aplicanMedidas = true;	

			var numHojas = 1;

			if(Acoplamiento == "Ambos"){
				numHojas = 2;
			}

			var medidas = <?php echo $medidasValJson; ?>;
			var anchoHoja = parseFloat(Ancho) / numHojas;
			var aplicanMedidas = false;

			//alert(anchoHoja);
			if (medidas !== null && medidas !== undefined) {
				if(medidas.length > 0){
					medidas.forEach(function(elemento) {
						if(parseFloat(anchoHoja) <= elemento[0] && parseFloat(Alto) <= elemento[1]){
							aplicanMedidas = true;
						}
					});
				}
			}else{
				aplicanMedidas = true;
			}

			var x = document.getElementById("div_tamanio");

			//VALIDACION DIMENSIONES//

			$("#cargando").css("display", "inline");
			$("#BtnD").css("display", "none");


			if (typeof Color == "undefined" || Color == null ||  Color == ""  || 
		    	typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
		    	typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
		    	typeof Alto == "undefined" || Alto == null || Alto == ""){
		    	
		    		//alert("Favor de indicar la tela, la cantidad, el alto y ancho.");
		    		return false;
		    //VALIDACION DIMENSIONES//
		    }else if(aplicanMedidas == false){
				if(!$("#div_tamanio").is(":visible")){
					x.style.display = "block";
				}

				if(submit == true){
					$('#modalValidacionTamano').modal('show');
				}
				
				return false;
			}
			//VALIDACION DIMENSIONES//
		    else {
		    	//VALIDACION DIMENSIONES//
				x.style.display = "none";
				//VALIDACION DIMENSIONES//

				$.post("cotizarprecio.php", { Color : Color, Tela : Tela, TipoTela : TipoTela, Clave : Clave, Ancho : Ancho,
											  Alto : Alto, Stiffener : Stiffener, ForroX : "NO", BajoPlomo:BajoPlomo, CAFE:CAFE, Cinta:Cinta, Argolla: Argolla }, function(data2){
				   $("#precio").html(data2);
				   $("#precio").show();
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");

				   	//AGREGADO ORIENTACIÓN RAYAS
                    var x = document.getElementById("div_orientacion_vertical");
                    var y = document.getElementById("div_orientacion_horizontal");

            		orientacionCortina = $("#orientacionCortina").val();

            		console.log(orientacionCortina);

            		if(orientacionCortina == 'Horizontal'){
            			y.style.display = "block";
            			x.style.display = "none";
            		}else if(orientacionCortina == 'Vertical'){
            			x.style.display = "block";
            			y.style.display = "none";
            		}else{
            			y.style.display = "none";
            			x.style.display = "none";
            		}
					//AGREGADO ORIENTACIÓN RAYAS


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

				   	// *************** NUEVO NOTASTOCK
					$.post("../fnc/comprobacionInsumos2.php", 
					{
						metraje : $("#Metraje").val(),
						codigotela : $("#CodigoTela").val(),
						cantidad : $("#cantidad").val(),
						idCarrito :  $("#opID").val(),
						Tela: $("#Telas option:selected").html(),
						TipoTela:$("#Telas option:selected").val(),
						TipoCortina:$("#nombre").val(),
						Color:$("input[name='color']:checked").val(),
						Clave : Clave, 
						Ancho : Ancho,
						Alto : Alto,
						Stiffener : Stiffener,
						ForroX : "NO",
						BajoPlomo:BajoPlomo, 
						CAFE:CAFE
					}, function(dataInsumo)
					{
					   	$("#notastock").html(dataInsumo);
						$("#notastock").show();
					});
					//****************** NUEVO VALIDACION TELA
					
					$.post("validacionTela.php", 
					{
						tela:$("#Telas option:selected").html(),
						TipoTela:$("#Telas option:selected").val(),
						Ancho : $("#ancho").val(),
						Alto : $("#alto").val(),
						codigotela : $("#CodigoTela").val(),	
						
					
					}, function(dataInsumo)
					{
						
					   	$("#valTela").html(dataInsumo);
						$("#valTela").show();
						$('#valTela2').hide();
						// TEXTO PARA MOSTRAR EL TIPO DE TELA DE FORRO
						
						document.getElementById('nombreTelaForro').hidden = true;
					});
					// ***************

				});	

				/*$.post("cotizarprecioforro.php", {ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
												   Ancho : Ancho, Alto : Alto, Stiffener : "NO" }, function(data2){
				   $("#precioforro").html(data2);
				   $("#precioforro").show();
				   $("#cargando").css("display", "none");
				   $("#BtnD").css("display", "inline");
				});	*/


				if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
						PrecioForro =0;

				}
				else{

					$.post("cotizarprecioforro.php", {ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
													   Ancho : Ancho, Alto : Alto, Stiffener : "NO", ForroX : "SI", BajoPlomo:BajoPlomo,CAFE:CAFE, Argolla: Argolla, Cinta:Cinta }, function(data2){
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

					 
				   	// *************** NUEVO NOTA STOCK
				   	$.post("../fnc/comprobacionInsumos2.php", 
					{
						metraje : $("#Metraje").val(),
						codigotela : $("#CodigoTela").val(),
						cantidad : $("#cantidad").val(),
						idCarrito :  $("#opID").val(),
						Tela: $("#Telas option:selected").html(),
						TipoTela:$("#Telas option:selected").val(),
						TipoCortina:$("#nombre").val(),
						Color:$("input[name='color']:checked").val(),
						Clave : Clave, 
						Ancho : Ancho,
						Alto : Alto,
						Stiffener : Stiffener,
						ForroX : "NO",
						BajoPlomo:BajoPlomo, 
						CAFE:CAFE
					}, function(dataInsumo)
					{
					   	$("#notastock").html(dataInsumo);
						$("#notastock").show();
					});
					// ***************
					//******************NUEVO VALIDACION TELA
					
					$.post("validacionTela2.php", 
					{
						tela:$("#Telas option:selected").html(),
						TipoTela:$("#Telas option:selected").val(),
						Ancho : $("#ancho").val(),
						Alto : $("#alto").val(),
						codigotela : $("#CodigoTela").val(),
						ColorForro : $("input[name='colorforro']:checked").val(),					
					}, function(dataInsumo)
					{
								
					   	$("#valTela2").html(dataInsumo);
						$("#valTela2").show();
						$('#valTela').hide();
						// TEXTO PARA MOSTRAR EL TIPO DE TELA DE FORRO
						TelaForro=$("#TelasForro option:selected").html();
						ColorForro = $("input[name='colorforro']:checked").val();
						document.getElementById('nombreTelaForro').innerHTML='Tela Seleccionada: '+TelaForro+ '-'+ColorForro + '<p class="boton_personalizado2" onclick="test()">Desseleccionar Forro</p>';
						document.getElementById('nombreTelaForro').hidden = false;
					});
					// ***************
					});
				}		
			}
		}
//-------------------------------------------- NUEVO VALIDACION PARA DESACTIVAR EL COLOR DEL FORRO --------------------------------------//
		function test() {
			document.querySelectorAll('[name=colorforro]').forEach((x) => x.checked=false);
			$("#PrecioFinalForro").val('0.00');
			$("#PrecioFinalForro2").val('0.00');

			// FIX: Limpiar visualmente el precio del forro y ocultar la sección
			$("#precio_forro").html("");
			$("#precioforro").hide();

			CargarValor();
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
				if($(this).val() == "GANCHO METALICO"){
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

		function Ojillo() {
			var Devolver = 'FALSE';
			$("input[type=checkbox]:checked").each(function(){
				if($(this).val() == "OjilloCafe"){
					Devolver = 'TRUE';
				}
			});
			return Devolver;
		}

		function cintaRippleford(){
			var Delvolver = "FALSE";
			
			$("#cinta option:selected").each(function () {
			    elegido=$("#cinta option:selected").html();
			    Devolver = 'TRUE';
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
			TelaForro = $("#optelaForro").val(); //optelaForro

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

			colorCinta = $("#opColorCinta").val(); 
			colorCinta = $.trim(colorCinta);
			if (colorCinta !== ""){
				colorCintaLower = colorCinta.toLowerCase();
				cintaSeleccion = $('#cinta option').filter(function () 
            		{ return $.trim($(this).val()) == colorCinta; });
				if (cintaSeleccion.length == 0){
					cintaSeleccion = $('#cinta option').filter(function () 
            			{ return $.trim($(this).html()).toLowerCase() == colorCintaLower; });
				}
				if (cintaSeleccion.length > 0){
					cintaSeleccion.attr("selected", "selected");
				}
			}

			aplicarRestriccionCinta();
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
					switch ($tipoArticuloDetalle) {
						case 'pFr':
							$Nombre = "Plitz Francés"; $valor = 'pFr';
							$ruta = "../../assets/img/plitz frances.jpg";
							break;
						case 'pEs':
							$Nombre = "Plitz Español"; $valor = 'pEs';
							$ruta = "../../assets/img/plitz español.jpg";
							break;
						case 'pPo':
							$Nombre = "Plitz Portugues"; $valor = 'pPo';
							$ruta = "../../assets/img/plitz portugues.jpg";
							break;
						case 'Pre':
							$Nombre = "Presillas"; $valor = 'Pre';
							$ruta = "../../assets/img/presillas.jpg";
							//$Gancho =FALSE;
							break;
						case 'Oji':
							$Nombre = "Ojillos"; $valor = 'Oji';
							$ruta = "../../assets/img/ojillos.jpg";
							break;
						case 'Vis':
							$Nombre = "Visillos"; $valor = 'Vis';
							$ruta = "../../assets/img/visillo.jpg";
							break;
						case 'Easy':
							$Nombre = "Easywave"; $valor = 'Ond'; $tipoArticuloDetalle = 'Easy';
							$ruta = "../../assets/img/persiana/EASYWAVE3.jpg";
							break;
						case 'Ond':
							$Nombre = "Ondulada"; $valor = 'Ond';
							$ruta = "../../assets/img/ondulada.jpg";
							break;
						case 'Fru':
							$Nombre = "Cinta Fruncidora"; $valor = 'Fru';
							$ruta = "../../assets/img/cinta fruncidora.jpg";
							break;
						case 'FrP':
								$Nombre = "Cinta Fruncidora Pasabarras"; $valor = 'FrP';
								$ruta = "../../assets/img/cinta fruncidora.jpg";
								break;
							case 'PaT':
								$Nombre = "Cinta Ondulada Pasabarras"; $valor = 'PaT';
								$ruta = "../../assets/img/cinta fruncidora.jpg";
								break;
						default:
							$valor = '';
							break;
					}

					echo '<input type="hidden"  id="tipo" value="'. $tipoArticuloDetalle .'">';
					echo '<input type="hidden"  id="tipocalculo" value="'. $valor .'">';
					echo '<input type="hidden"  id="nombre" value="'. $Nombre .'">';
					echo '<input type="hidden"  id="ruta" value="'. $ruta .'">';

					?>
							<!--VALIDACION DIMENSIONES-->
							<input type="hidden"  id="texto" value="<?php echo $medidasValJson; ?>">
							<!--VALIDACION DIMENSIONES-->
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
											<div id="tiras"><h3>Espacio</h3></div>

											<div class="form-group">
												<input type="text" id="autocomplete1" class="form-control" data-source="../../conexion/data/areas.json" placeholder="Espacio">
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
													<input type="text" class="form-control" id="ancho" name="ancho" min="1" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required> 
													<label for="dollars10">Ancho</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
										</div><!--end .form-group -->


										<div class="form-group floating-label">
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-arrows-v"></i></span>
												<div class="input-group-content">
													<input type="text" class="form-control" id="alto" name="alto" min="1" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required>
													<label for="dollars10">Alto</label>
												</div>
												<span class="input-group-addon">mts.</span>
											</div>
										</div><!--end .form-group -->
										<!--NUEVO DIVS PARA MOSTRAR MENSAJES
										<div id="valTela"  hidden="true"></div><br>
										<div id="valTela2"  hidden="true"></div><br>
										<br>-->

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
															if (($ArregloTipoTela[$i]['nombre'] == "DARREN VELVET" && $valor=="Ond") ||  (($valor=="pEs" or $valor=="pPo") and $ArregloTipoTela[$i]['nombre']=="LUXY")){
															
															} else {
																   echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';	
															}
											        	}
											        echo "</select>";
											        //echo $valor;
											        //echo $ArregloTipoTela;
								        		?>
												
												<label>Selecciona el tipo de tela</label>
											</div>
											<div id="notastock"></div>
											<script type="text/javascript">
											    CambiarCombo();
												ColorVariable();
											</script>
											<div id="colores"></div>
										</div>

										<div class="form" id="forros2">
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
											<div id="notastockforro"></div>
											<div id="coloresforro"></div>
											<!--NUEVO -->
											<div id="nombreTelaForro" hidden="false"></div>

										</div>

											<!-- CUADRO PARA Cinta ripplefold  --->
									<div  id="cinta"  hidden="false">
										<div id="tiras"><h3>Cinta Ripplefold</h3></div>
										<label><b>Selecciona una Cinta Ripplefold</b></label>
										<div class="form-group">											
											<select class="form-control"  id="cinta" onchange="CargarValor()">												
										 		<optgroup label="Cinta Ripplefold:">
													<option value="1">Blanco</option>
													<option value="2">Transparente</option>
													<option value="3">Negro</option>
													<option value="4">Transparente XL</option>
												</optgroup>
											</select>											
										</div>
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
																	<input type="radio" name="acoplamiento"  value="Izquierda" id="Izquierda" onchange="CargarValor()" checked><span>Izquierda 1 hoja</span>
																	<img src="../../assets/img/opciones/izquierda.png" style="" width="50px" height="50px"/>
																</label>
															</td>
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="acoplamiento"  value="Derecha" id="Derecha" onchange="CargarValor()"><span>Derecha 1 hoja</span>
																	<img src="../../assets/img/opciones/derecha.png" width="50px" height="50px"/>
																</label>
															</td>
															<td>
																<label class="radio-inline radio-styled">
																	<input type="radio" name="acoplamiento" value="Ambos" id="Ambos" onchange="CargarValor()"><span>Ambos</span>
																	<img src="../../assets/img/opciones/Ambas.png" style="" width="50px" height="50px"/>
																</label>
															</td>
														</div>
													</tr>
												</table>
											</div>
											<div id="cortinaIrregularContainer" style="display: none;">
												<label for="cortinaIrregular">Cortina Ancho Irregular</label>
												<input type="checkbox" id="cortinaIrregular" onchange="toggleHojaFields()">
											</div>
											<div id="hojaFields" style="display: none; margin-top: 10px;">
												<div style="display: inline-block; margin-right: 20px;">
													<label for="hojaIzquierda">Hoja Izquierda (mts)</label>
													<input type="number" id="hojaIzquierda" name="hojaIzquierda" min="0" step="0.01" disabled>
												</div>
												<div style="display: inline-block;">
													<label for="hojaDerecha">Hoja Derecha (mts)</label>
													<input type="number" id="hojaDerecha" name="hojaDerecha" min="0" step="0.01" readonly disabled>
												</div>
											</div>

											<script type="text/javascript">
												CambiarAcoplamiento();
											</script>

											<div class="form-group" id = "div_orientacion_vertical" style="display: none;">
												<div id="tiras"><h3>Orientaci&oacute;n Raya Cortina</h3></div>
												<img src="../../assets/img/CRV.png" width="50px" height="50px"/>
												Vertical
											</div>
											<div class="form-group" id = "div_orientacion_horizontal" style="display: none;">
												<div id="tiras"><h3>Orientaci&oacute;n Raya Cortina</h3></div>
												<img src="../../assets/img/CRH.png" width="50px" height="50px"/>
												Horizontal
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


								        		<script type="text/javascript">
													CambiarVariables();
												</script>

								        		<div id="variables"></div>

								        		
										        <!--VALIDACION DIMENSIONES -->
								        		<div id = "div_tamanio" style="display: none;">
													<p style="color: red;"><b>Cortina supera las medidas permitidas para su confecci&oacuten</b></p>
												</div>
												<!--VALIDACION DIMENSIONES -->
								        		
												<br>
												<div id="cargando" style="display:none; color: green;">Cargando...</div>
												<div id="BtnD" style="display:none;"><button type="submit" class="btn btn-block ink-reaction btn-primary-light" style="font-weight: bolder;"  >Guardar cambios</button> <!-- onclick="MostrarValor()"--></div>
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
					<p>El "<b>Espacio</b>" es un campo requerido para poder enviar la cotización. Favor de capturarlo</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!--VALIDACION DIMENSIONES -->
	<div class="modal fade" id="modalValidacionTamano" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title" id="simpleModalLabel">Información</h4>
					</div>
					<div class="modal-body">
						<p>Cortina supera las medidas permitidas para la confecci&oacute;n.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>								
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!--VALIDACION DIMENSIONES -->

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
