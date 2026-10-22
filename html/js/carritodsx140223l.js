var costoFinal=0;	
precioRecalculado1 = 0;
precioRecalculado2 = 0;

var costoCortinero=0;
var anchoinicial=0;
var Nombre;
var color;
var resultadoSistema;
var decorativo;
var peso;
var	argollaBool;							    
var resultadoRemate;
var resultadoSoporte;
var radioMaterial="Fibra de Vidrio";
//var radioMaterial="ACRILICO";
var baston;
var valorBaston;
var rutaImg="../../assets/img/cortineros/DSXL.jpg";
var tipolinea="N";
var TipoArticuloDetalle="dsxl";
var area;
var cantBaston=0;
var cantidadBastonFija = 0;
var resHojas;

bloqueado = false;

$(document).ready(function()
{
	CambiarRadio();
	CambiarNumber();
	CambiarCheckbox();

	$("#BotonEnviar").click(function()
	{
		if ($("#autocomplete1").val().length == 0)
		{
			triggerModal("Favor de especificar el espacio.");

			return;
		}

		obtenerValores(true);
	});

	$("#msj").on('hidden.bs.modal', function()
	{
		$("#autocomplete1").focus();
    });

	$("#dsxl").submit(function() 
	{
	    Cantidad = $("#cantidadcortinero").val();
	    precioFinal = costoFinal;//este es el precio final
	    codigoBaston = $("#codigoBaston").val();
	    precioBaston = $("#valorBaston").val();
	    cantidadHojas=$("input[name='hoja']:checked").val();
	    control= $("input[name='control']:checked").val();
	    fijacion= $("input[name='instalacion']:checked").val();
	    nombreCorti="CORTINERO DSXL";
	    tipoarticulo="cortinero";
	    codigo = $("#CodigoCortinero").val();
	    area=$("#autocomplete1").val();
	    idllega=$("#opID").val();
	    
	    if(idllega=="nuevo"){
	    	id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+"*"+anchoinicial+"*"+area+"*"+codigoBaston;
	    }	
	    else {
	    	id=$("#opID").val();
	    }				
	   		

	    if(baston==true){
		    if(cantidadHojas == "2HOJAS"){
		    	cantBaston=2;
		    	if(resultadoSoporte=="DOBLE"){
		    		cantBaston=4;
		    	}
		    }
		    else{
		    	cantBaston=1;
		    	if(resultadoSoporte=="DOBLE"){
		    		cantBaston=2;
		    	}
		    }
	    }

		cantidadBastonFija = cantBaston;
	    cantBaston=cantBaston * Cantidad;
	    precioBaston=precioBaston * Cantidad;

	    $.post("LlenarCarrito.php",{id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo,
	                                tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:anchoinicial, color:color, fijacion:fijacion,
	                                cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
	                                remate:resultadoRemate,resultadoSistema:resultadoSistema,
									soporte:resultadoSoporte,argolla:argollaBool,codigoBaston:codigoBaston,
									baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,tipolinea:tipolinea,
									TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston,
									cantidadBastonFija:cantidadBastonFija
								   }, function(){ });	   			  
	});
});

$("input[name='instalacion']").change( function()
{
	if ($("input[name='instalacion']:checked").val() == "MURO")
	{
		$("#imagenSencillo").attr("src", "../../assets/img/acce/DSXLSoporteMuro.jpg")
	}
	else if ($("input[name='instalacion']:checked").val() == "TECHO")
	{
		$("#imagenSencillo").attr("src", "../../assets/img/acce/DSXLSoporteTecho.jpg")
	}
});

function CambiarNumber(){
	 ancho = $("#opAncho").val();
     cantidad = $("#opCantidad").val();
     AREA = $("#opArea").val();

     $("#anchocortinero").val(ancho);
     $("#cantidadcortinero").val(cantidad);
     $("#autocomplete1").val(AREA);

    if (Cortina == "SI")
    {
     	$("#autocomplete1").prop("disabled", true);
     	$("#cantidadcortinero").prop("disabled", true);
    }
}

function CambiarRadio()
{
	if ($("#opFijacion").val().toUpperCase() == "TECHO")
	{
		$("#Techo").prop("checked", true);
		$("#imagenSencillo").attr("src", "../../assets/img/acce/DSXLSoporteTecho.jpg")
	}

	if ($("#opBastonmedida").val() == "1.22")
	{
		$("#bastonUnoP2").prop("checked", true);
	}
	else if ($("#opBastonmedida").val() == "1.5")
	{
		$("#bastonUnoP3").prop("checked", true);
	}

	Hojas = $("#opHojas").val();
	$("#"+Hojas+"").prop("checked", true);

	Control = $("#opControl").val();
	$("#"+Control+"").prop("checked", true);

	Sistema = $("#opSistema").val();
	$("#"+Sistema+"").prop("checked", true);

	Acoplamiento = $("#opAcoplamiento").val();
	Cortina = $("#opCortina").val();

	//solo entra si---datos vienen de cortina
	if (Cortina=="SI")
	{
		if ($("#opFijacion").val().toUpperCase() == "TECHO")
		{
			$("#Muro").prop("disabled", true);
		}
		else
		{
			$("#Techo").prop("disabled", true);
		}

		if (Sistema=="Ond")
		{
	 		$("#ONDULADO").prop("checked", true);
	 		$("#ESTANDAR").attr('disabled', true);
	 	}
	 	else
	 	{
	 		$("#ESTANDAR").prop("checked", true);
	 		$("#ONDULADO").attr('disabled', true);
	   	}
	}

	if (Acoplamiento != undefined || "" || 0)
	{
		if (Acoplamiento=="Izquierda")
		{
	    	$("#1IZQUIERDA").prop("checked", true);//cant hojas
	    	$("#1DERECHA").attr('disabled', true);//cant hojas
	    	$("#2HOJAS").attr('disabled', true);//cant hojas
	 	
	 		$("#Derecha").prop("checked", true);//control
	 		$("#Izquierda").attr('disabled', true);
	 		$("#Ambos").attr('disabled', true);
	  	}
		else if (Acoplamiento=="Derecha")
		{
	 		$("#1DERECHA").prop("checked", true);//cant hojas
	 		$("#1IZQUIERDA").attr('disabled', true);//cant hojas
	 		$("#2HOJAS").attr('disabled', true);//cant hojas

	 		$("#Izquierda").prop("checked", true);//control
	 		$("#Derecha").attr('disabled', true);
	 		$("#Ambos").attr('disabled', true);
	  	}
	  	else if (Acoplamiento=="Ambos")
	  	{
	  		$("#Ambos").prop("checked", true);//control
	  		$("#2HOJAS").prop("checked", true);//cant hojas

	  		$("#Derecha").attr('disabled', true);
	  		$("#Izquierda").attr('disabled', true);
	  		$("#1IZQUIERDA").attr('disabled', true);//cant hojas
	  		$("#1DERECHA").attr('disabled', true);//cant hojas
	  	}	 
	}
}

function CambiarCheckbox()
{
	Bastonchk = $("#opBastonchk").val();

	if(Bastonchk=="true"){
	Bastonchk = Bastonchk.replace(/\s+/g, '');
	$("#chkbaston").prop("checked", true);
	}
	else if(Bastonchk=="false"){
	Bastonchk = Bastonchk.replace(/\s+/g, '');	
	$("#chkbaston").prop("checked", false);
	}			 
}

function disabledRadios(radioHojasCheckedValue) {
	if (radioHojasCheckedValue == '2HOJAS') {
		$('#Derecha').attr('disabled', true);
		$('#Izquierda').attr('disabled', true);
		$('#Ambos').attr('disabled', false);
		$("#Ambos").attr('checked', true);
	} 
	else if(radioHojasCheckedValue == '1DERECHA'){
		$('#Derecha').attr('disabled', true);
		$('#Ambos').attr('disabled', true);
		$('#Izquierda').attr('disabled', false);
		$("#Izquierda").attr('checked', true);
	}
	else if(radioHojasCheckedValue == '1IZQUIERDA'){
		$('#Ambos').attr('disabled', true);
		$('#Izquierda').attr('disabled', true);
		$('#Derecha').attr('disabled', false);
		$("#Derecha").attr('checked', true);
	}

}

function obtenerValores(hacerRecalculo = false)
{	
	permitirCotizar();

	if ($("#anchocortinero").val().length == 0)
	{
		bloquearCotizar("Favor de capturar el ancho deseado para el cortinero.", false);

		return;
	}

	radioHojasCheckedValue = $("input[name='hoja']:checked").val();
	disabledRadios(radioHojasCheckedValue);											
    anchoinicial=document.getElementById('anchocortinero').value;
    anchomod=Math.ceil( anchoinicial * 10 )/10;
    color = "BLANCO";
    Nombre = 81;
    argollaBool="N/A";
    decorativo="NO";	
    peso=0;							   


   //obtener fijacion
   var radioFijacion=document.getElementsByName("instalacion");
	for(var i=0;i<radioFijacion.length;i++){
            if(radioFijacion[i].checked)
               resultadoFijacion=radioFijacion[i].value;									               
    }

	resultadoRemate = "N/A";

         //OBTENER SISTEMA
    var radioSistema=document.getElementsByName("sistema");
	for(var i=0;i<radioSistema.length;i++){
            if(radioSistema[i].checked)
                resultadoSistema=radioSistema[i].value;
    }
        //OBTENER SOPORTE
        var radioSoporte=document.getElementsByName("soporte");
	for(var i=0;i<radioSoporte.length;i++){
            if(radioSoporte[i].checked)
               resultadoSoporte=radioSoporte[i].value;
    }
   

    Color="BLANCO";
    baston=document.getElementById("chkbaston").checked;
    radioMedida= $("input[name='medida']:checked").val();


    if(baston==false){										  
      valorBaston = "NO";
    }
    else {
    	valorBaston = "SI";
    }
    resHojas=$("input[name='control']:checked").val();

    $("#cargando").css("display", "inline");
   $("#BtnD").css("display", "none");

	        /*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
	$.post("../fnc/cortinero.php", 
	{ 
		ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
		argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida, radioMaterial:radioMaterial,
		baston:baston,valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
	}, function(data)
	{
		$("#resultado").html(data);

		validacionesResultado();

    	if (!bloqueado)
    	{
    		if (hacerRecalculo)
			{
				precioRecalculado1 = $("#resultadoSuma").val();

				$.post("../fnc/cortinero.php", 
				{ 
					ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema,
					soporte:resultadoSoporte, argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,
					radioMaterial:radioMaterial, baston:baston,valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
				}, function(data)
				{
			    	$("#resultado").html(data);

			    	validacionesResultado();

			    	if (!bloqueado)
			    	{
			    		precioRecalculado2 = $("#resultadoSuma").val();

			    		if (precioRecalculado1 != precioRecalculado2 || costoFinal != precioRecalculado1)
						{
							bloquearCotizar("Se detectaron problemas de conexión que podrían afectar el cálculo del costo de su cotización, favor de recargar la página.", true);
						}
						else
						{
							$("#dsxl").submit();
						}
			    	}
		    	});
			}
			else
			{
				costoFinal = $("#resultadoSuma").val();

				permitirCotizar();
			}
    	}
    });									    												 
}

function validacionesResultado()
{
	if ($("#CodigoCortinero").val() == "multiCortinero")
	{
		bloquearCotizar("La configuración actual del artículo esta relacionada con dos códigos de artículo, favor de notificar a su agente de ventas.", true);
	}
	else if ($("#codigoBaston").val() == "multiBaston")
	{
		bloquearCotizar("La configuración actual del artículo esta relacionada con dos códigos de bastón, favor de notificar a su agente de ventas.", true);
	}
	else if ($("#resultadoVacio").val() == 0)
	{
		bloquearCotizar("Este articulo no se encuentra dado de alta, favor de notificar a su agente de ventas.");
	}
}

function bloquearCotizar(mensaje, mostrarModal = false)
{
	$(".msjModal").html(mensaje);
	$("#cargando").css("display", "none");
	$("#BtnD").css("display", "none");

	if (mostrarModal)
	{
		$("#msj").modal();
	}

	$("#cargando2").css("display", "inline");

	bloqueado = true;
}

function triggerModal(mensaje)
{
	$(".msjModal").html(mensaje);

	$("#msj").modal();
}

function permitirCotizar()
{
	bloqueado = false;

	$("#cargando2").css("display", "none");
	$("#cargando").css("display", "none");
    $("#BtnD").css("display", "inline");
}