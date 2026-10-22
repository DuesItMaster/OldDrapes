function disabledRadios(radioHojasCheckedValue) {
	if (radioHojasCheckedValue == '2HOJAS') {
		$('#Derecha').attr('disabled', true);
		$('#Izquierda').attr('disabled', true);
		$('#Ambos').attr('disabled', false);
		$("#Ambos").attr('checked', true);
	} 
	else if(radioHojasCheckedValue == '1DERECHA'){
		$('#Izquierda').attr('disabled', true);
		$('#Ambos').attr('disabled', true);
		$('#Derecha').attr('disabled', false);
		$("#Derecha").attr('checked', true);
	}
	else if(radioHojasCheckedValue == '1IZQUIERDA'){
		$('#Ambos').attr('disabled', true);
		$('#Derecha').attr('disabled', true);
		$('#Izquierda').attr('disabled', false);
		$("#Izquierda").attr('checked', true);
	}

}
								var costoFinal=0;
								precioRecalculado1 = 0;
								precioRecalculado2 = 0;

							    var costoCortinero=0;
							    var anchoinicial=0;
							    var Nombre;
							    var color = "BLANCO";
							    var resultadoSistema;
							    var decorativo;
							    var peso;
							    var	argollaBool;							    
							    var resultadoRemate;
							    var resultadoSoporte;
							    var radioMedida;
								var radioMaterial="Fibra de Vidrio";
								//var radioMaterial="ACRILICO";
							    var baston;
							    var valorBaston;
							    var colorBaston="BLANCO";
							    var Color="N/A";
							    var rutaImg="../../assets/img/cortineros/CCS.jpg";
							    var tipolinea="N";
							    var TipoArticuloDetalle="ccs";
							    var area;
							    var cantBaston=0;
							    var resHojas;

							    bloqueado = false;

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
								    Nombre = 91 ;
								    //TipoArticuloDetalle	= "<?php echo $opcion;?>";										   
								    //color="BLANCO";
								    //color=document.getElementById("SelectColor").value;
								    argollaBool="N/A";
								    resultadoRemate="N/A";
								    resultadoSistema="ESTANDAR";
								    decorativo="NO";
								    peso=0;								   

								 	       //obtener fijacion
									   var radioFijacion=document.getElementsByName("instalacion");
										for(var i=0;i<radioFijacion.length;i++){
									            if(radioFijacion[i].checked)
									               resultadoFijacion=radioFijacion[i].value;									               
									    }

                                        if(resultadoFijacion=="TECHO"){       
                                            $("#soporteSenchillo #fijacion").prop('disabled', true);
                                            $("#sopordoble #fijacion").prop('disabled', true);
                                            $("#soporteTecho #fijacion").prop("checked", true);	
                                            $("#soporteTecho #fijacion").prop('disabled', false);    								    	
                                        }
                                        else if(resultadoFijacion=="MURO"){
                                            $("#soporteTecho #fijacion").prop('disabled', true);       
                                            $("#soporteSenchillo #fijacion").prop('disabled', false);
                                            $("#sopordoble #fijacion").prop('disabled', false);
                                            $("#soporteSenchillo #fijacion").prop("checked", true);									    	
                                        }

									
									        //OBTENER SOPORTE
									    var radioSoporte=document.getElementsByName("soporte");
										for(var i=0;i<radioSoporte.length;i++){
									            if(radioSoporte[i].checked)
									               resultadoSoporte=radioSoporte[i].value;
									    }
									   
									        //OBTENER MEDIDA
									    /*radioMedida=document.getElementsByName("medida");
										for(var i=0;i<radioMedida.length;i++){
									            if(radioMedida[i].checked)
									                radioMedida=radioMedida[i].value;
									    }*/

									    radioMedida= $("input[name='medida']:checked").val();
									     
									    //baston=document.getElementById("chkbaston").checked;


									    if(baston==false){										  
									      valorBaston = "NO";
									    }
									    else {
									    	valorBaston = "SI";
									    }

										if (color == "NEGRO")
									    {
									    	colorBaston = "NEGRO";
									    }
									    else
									    {
									    	colorBaston = "BLANCO";
									    }

									    resHojas=$("input[name='control']:checked").val();

									    $("#cargando").css("display", "inline");
			                           $("#BtnD").css("display", "none");

									        /*AQUI SE OBTIENE EL VALOR DE CORTINERO*/
											$.post("../fnc/cortinero.php", 
											{
												doblar:"SI", ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,
												resultadoSistema:resultadoSistema, soporte:resultadoSoporte,argolla:argollaBool,
												fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,radioMaterial:radioMaterial,
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
															doblar:"SI", ancho:anchomod, color:color, tipo:Nombre,remate:resultadoRemate,
															resultadoSistema:resultadoSistema, soporte:resultadoSoporte,argolla:argollaBool,
															fijacion:resultadoFijacion,colorBaston:colorBaston, radioMedida:radioMedida,
															radioMaterial:radioMaterial, baston:baston,valorBaston:valorBaston,decorativo:decorativo,
															peso:peso,resHojas:resHojas
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
																	$("#ccs").submit();
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

										$(document).ready(function()
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

											$("#ccs").submit(function() 
											{
											    Cantidad = $("#cantidadcortinero").val();
											    precioFinal = costoFinal;//este es el precio final
											    codigoBaston = ''; //$("#codigoBaston").val();
											    precioBaston = ''; //$("#valorBaston").val();
											    cantidadHojas=$("input[name='hoja']:checked").val();
											    control= $("input[name='control']:checked").val();
											    fijacion= $("input[name='instalacion']:checked").val();
											    nombreCorti="CORTINERO CCS";
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

											    cantBaston=cantBaston * Cantidad;
											    precioBaston=precioBaston * Cantidad;

											    $.post("LlenarCarrito.php",{id:id, Cantidad:Cantidad, precioFinal:precioFinal, nombre:nombreCorti, codigo:codigo,
											                                tipoarticulo:tipoarticulo, ruta:rutaImg, ancho:anchoinicial, color:color, fijacion:fijacion,
											                                cantidadHojas:cantidadHojas, control:control, decorativo:decorativo, peso:peso,
											                                remate:resultadoRemate,resultadoSistema:resultadoSistema,
																			soporte:resultadoSoporte,argolla:argollaBool,codigoBaston:codigoBaston,
																			baston:baston, colorBaston:Color, radioMedida:radioMedida,radioMaterial:"Fibra de Vidrio",tipolinea:tipolinea,
																			TipoArticuloDetalle:TipoArticuloDetalle,area:area,cantBaston:cantBaston,precioBaston:precioBaston
																		   }, function(){ });	   			  
											});
										});