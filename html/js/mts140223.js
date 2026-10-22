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
var rutaImg="../../assets/img/cortineros/MTS.jpg";
var tipolinea="N";
var TipoArticuloDetalle;
var area;
var Color="BLANCO";
var cantBaston=0;
var cantidadBastonFija = 0;
var resHojas;

bloqueado = false;

$(function()
{
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

	$("#mts").submit(function() 
	{
	    Cantidad = $("#cantidadcortinero").val();
	    precioFinal = costoFinal;//este es el precio final
	    precioBaston = $("#valorBaston").val();
	    codigoBaston = $("#codigoBaston").val();
	    cantidadHojas=$("input[name='hoja']:checked").val();
	    control= $("input[name='control']:checked").val();
	    fijacion= $("input[name='instalacion']:checked").val();
	    nombreCorti="CORTINERO MTS";
	    tipoarticulo="cortinero";
	    codigo = $("#CodigoCortinero").val();
	    area=$("#autocomplete1").val();		
	    
	    id="*"+codigo+"*"+control+"*"+fijacion+"*"+cantidadHojas+'*'+anchoinicial+"*"+area+"*"+codigoBaston;

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
    Nombre = 82;
    TipoArticuloDetalle	= "mts";
    color = "BLANCO";
    argollaBool="N/A";

    decorativo="NO";
    peso=0;

	//obtener fijacion
	var radioFijacion=document.getElementsByName("instalacion");
	
	for (var i = 0; i < radioFijacion.length; i++)
	{
        if (radioFijacion[i].checked)
        {
           resultadoFijacion = radioFijacion[i].value;
    	}
    }

	//obtener remate
	resultadoRemate = "N/A";

	//OBTENER SISTEMA
    var radioSistema = document.getElementsByName("sistema");
	for (var i = 0; i < radioSistema.length; i++)
	{
        if(radioSistema[i].checked)
            resultadoSistema=radioSistema[i].value;
    }
    
    //OBTENER SOPORTE
    resultadoSoporte="N/A";

    baston=document.getElementById("chkbaston").checked;

    if(baston==false)
    {
    	valorBaston = "NO";
    }
    else
    {
    	valorBaston = "SI";
    }

    resHojas=$("input[name='control']:checked").val();
    radioMedida= $("input[name='medida']:checked").val();

   	$("#cargando").css("display", "inline");
   	$("#BtnD").css("display", "none");
   
    /*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
	$.post("../fnc/cortinero.php", 
	{ 
		ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,resultadoSistema:resultadoSistema, soporte:resultadoSoporte,
		argolla:argollaBool,fijacion:resultadoFijacion,colorBaston:Color, radioMedida:radioMedida,radioMaterial:radioMaterial,baston:baston,
		valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
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
					radioMaterial:radioMaterial,baston:baston, valorBaston:valorBaston,decorativo:decorativo, peso:peso,resHojas:resHojas
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
							$("#mts").submit();
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