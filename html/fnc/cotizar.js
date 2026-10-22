
		$(document).ready(function(){
			$("#Telas").change(function () {
				$("#colores").hide();
				$("#variables").hide();
				ColorVariable();				
			})

			$("#TelasForro").change(function () {
				alert("aqui");
				$("#coloresforro").hide();
				$("#variables").hide();
				ColorVariableForro();				
			})


			$("#cortina").submit(function() {

				tela= $("#Telas option:selected").html();
			    nombre = "Cortina " + $("#nombre").val();
			    Color= $("input[name='color']:checked").val();

			    Cantidad = $("#cantidad").val();
			    precioFinal = $("#PrecioFinal").val();

			    Codigo = $("#CodigoComodin").val();

			    CodigoTela = $("#CodigoTela").val();
			    PrecioTela = $("#PrecioTela").val();
			    
			    Ancho = $("#ancho").val();
				Alto = $("#alto").val();
				CodigoMo = $("#CodigoMo").val();
				PrecioMo = $("#PrecioMo").val();
				
			    telaForro = $("#TelasForro option:selected").html();
			    ColorForro = $("input[name='colorforro']:checked").val();
			    PrecioFinalForro = $("#PrecioFinalForro").val();
			    CodigoTelaForro = $("#CodigoTelaForro").val();
			    PrecioTelaForro = $("#PrecioTelaForro").val();
			    CodigoMoForro = $("#CodigoMoForro").val();
			    PrecioMoForro = $("#PrecioMoForro").val();

			    ruta = $("#ruta").val();			    
			    
			    Fijacion= $("input[name='fijacion']:checked").val();
			    Acoplamiento= $("input[name='acoplamiento']:checked").val();
			    Tipo= $("#tipo").val();

			    Sti = MostrarValor();
				if (Sti == "TRUE"){ Stiffener = "STIFFENER"; }
				else{ Stiffener = ""; }

				Bp = BajoPlomo();
				if (Bp == "TRUE"){ BajoPlomo = "BAJO PLOMO"; }
				else{ BajoPlomo = ""; }

				Gr = GanchoReforzado();
				if (Gr == "TRUE"){ Gancho = "GANCHO REFORZADO"; }
				else{ Gancho = ""; }

				Nl = Neverlight();
				if (Nl == "TRUE"){ Never = "NEVER LIGHT"; }
				else{ Never = ""; }


			    id=Tipo+'*'+Codigo+'*'+Ancho+'*'+Alto+'*'+Fijacion+'*'+Acoplamiento;

			    //alert(PrecioTela);

			    if (typeof Color == "undefined" || Color == null) {
			    	return false;
			    } else {

			    	if (typeof ColorForro == "undefined" || ColorForro == null) {

			    		$.post("../cotizar/LlenarCarrito.php", {Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,
			    								 	codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela,
			    								 	stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, 
			    								 	tipoarticulo:'cortina', ruta : ruta, CodigoMo : CodigoMo, PrecioMo : PrecioMo }, function(data2){ });
			    	}
			    	else{
			    		
			    		id = id + '*' + telaForro + '*' + ColorForro;

			    		$.post("../cotizar/LlenarCarrito.php", {Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,
				    								 codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela,
				    								 stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, 
				    								 tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo,
				    								 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro, PrecioFinalForro : PrecioFinalForro,
				    								 CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro }
				    								 , function(data2){ });
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


					$.post("../cotizar/cotizarvariables.php", { tipo: tipo }, function(data){
					    $("#variables").html(data);
					    $("#variables").show();
			    	});

				   $.post("../cotizar/cotizarcolores.php", { elegido: elegido }, function(data1){
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

				   	$.post("../cotizar/cotizarcoloresforro.php", { elegidoForro: elegidoForro }, function(data1){
					    $("#coloresforro").html(data1);
					    $("#coloresforro").show();
			    	});
  
			});
		}


		function CargarValor(){
			//alert("aquiiiiii");
			Clave =  "<?php echo $valor; ?>";
			Tela=$("#Telas option:selected").html();
			TipoTela=$("#Telas option:selected").val();
			Color= $("input[name='color']:checked").val();
			Ancho = $("#ancho").val();
			Alto = $("#alto").val();


			TelaForro=$("#TelasForro option:selected").html();
			TipoTelaForro=$("#TelasForro option:selected").val();
			ColorForro = $("input[name='colorforro']:checked").val();

			Sti = MostrarValor();
			if (Sti == "TRUE"){
				Stiffener = "SI";
			}
			else{
				Stiffener = "NO";
			}

			$.post("../cotizar/cotizarprecio.php", { Color : Color, Tela : Tela, TipoTela : TipoTela, Clave : Clave, Ancho : Ancho,
										  Alto : Alto, Stiffener : Stiffener }, function(data2){
			   $("#precio").html(data2);
			   $("#precio").show();
			});	

			$.post("../cotizar/cotizarprecioforro.php", {ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
											   Ancho : Ancho, Alto : Alto, Stiffener : "NO" }, function(data2){
			   $("#precioforro").html(data2);
			   $("#precioforro").show();
			});				
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

		function BajoPlomo() {
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