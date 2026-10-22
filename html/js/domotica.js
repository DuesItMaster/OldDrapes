'use strict'

// Variables globales para control de estado
let controlesCargados = false;
let reintentos = 0;
const maxReintentos = 3;

$(document).ready(function() {
    //console.log("🚀 Inicializando página de domótica...");
    
    // Cargar controles inmediatamente al cargar la página
    inicializarControles();
    
    // Configurar el botón para verificar estado antes de enviar
    $("#BotonEnviar").click(function() {
        if (!verificarEstadoControles()) {
            return;
        }
        procesarEnvio();
    });
});

// Función para inicializar y cargar todos los controles
function inicializarControles() {
    //console.log("🔄 Inicializando controles...");
    
    // Obtener el valor inicial del SelectControl
    const codigoTipoControl = $("#SelectControl").val();
    //console.log("📝 Código tipo control inicial:", codigoTipoControl);
    
    if (!codigoTipoControl) {
        console.error("❌ No se pudo obtener el código tipo control inicial");
        triggerModal("Error de configuración. Recargue la página.");
        return;
    }
    
    // Cargar los controles específicos
    cargarControles(codigoTipoControl);
}

// Función mejorada para cargar controles
function cargarControles(codigo) {
    //console.log("📥 Cargando controles para código:", codigo);
    controlesCargados = false;
    $("#BotonEnviar").prop('disabled', true).html('Cargando controles...');
    
    $.ajax({
        url: "../fnc/domotica.php",
        type: "POST",
        data: { 
            codigo: codigo, 
            accion: "controles" 
        },
        timeout: 10000,
        success: function(data) {
            $("#SelectCanales").html(data);
            controlesCargados = true;
            
            console.log("✅ Controles cargados exitosamente");
            console.log("📊 Opciones cargadas:", $("#SelectCanales option").length);
            
            // Habilitar el botón y establecer precio inicial
            $("#BotonEnviar").prop('disabled', false).html('Generar');
            
            // Establecer precio del primer control
            setTimeout(() => {
                const primerPrecio = $("#SelectCanales").val();
                if (primerPrecio) {
                    precioControl(primerPrecio);
                    console.log("💰 Precio inicial establecido:", primerPrecio);
                }
            }, 100);
            
        },
        error: function(xhr, status, error) {
            console.error("❌ Error cargando controles:", error);
            triggerModal("Error al cargar los controles. Recargue la página.");
            $("#BotonEnviar").prop('disabled', false).html('Generar');
        }
    });
}

// Función para verificar que todo esté listo antes de enviar
function verificarEstadoControles() {
    //console.log("🔍 Verificando estado de controles...");
    
    if (!controlesCargados) {
        console.error("❌ Controles no cargados");
        triggerModal("Los controles aún se están cargando. Espere un momento.");
        return false;
    }
    
    const selectCanales = $("#SelectCanales");
    const opciones = selectCanales.find('option');
    const opcionSeleccionada = selectCanales.find('option:selected');
    const codigoControl = opcionSeleccionada.attr('codigo');
    
    console.log("📊 Estado actual:");
    console.log("  - Opciones disponibles:", opciones.length);
    console.log("  - Opción seleccionada:", opcionSeleccionada.length > 0 ? "Sí" : "No");
    console.log("  - Código control:", codigoControl);
    console.log("  - Valor seleccionado:", opcionSeleccionada.val());
    
    if (opciones.length === 0) {
        console.error("❌ No hay opciones disponibles");
        triggerModal("No hay controles disponibles. Recargue la página.");
        return false;
    }
    
    if (!codigoControl) {
        console.error("❌ Código de control no disponible");
        console.log("🔍 Atributos de la opción:", opcionSeleccionada[0]?.attributes);
        triggerModal("Seleccione un control válido de la lista.");
        return false;
    }
    
    console.log("✅ Estado verificado - Todo listo");
    return true;
}

// Función principal de procesamiento
function procesarEnvio() {
    //console.log("🎯 Iniciando procesamiento de envío...");
    
    // Validaciones básicas
    if ($("#autocomplete1").val().length == 0) {
        triggerModal("Favor de especificar el espacio.");
        return;
    }

        $("#incrementar").click(function() {
        let cantidad = parseInt($("#cantidadControles").val());
        $("#cantidadControles").val(cantidad + 1);
    });
    
    $("#decrementar").click(function() {
        let cantidad = parseInt($("#cantidadControles").val());
        if (cantidad > 1) {
            $("#cantidadControles").val(cantidad - 1);
        }
    });

    if ($("#cantidadControles").val() == 0) {
        triggerModal("Favor de poner una cantidad mayor a 0.");
        return;
    }

    // Obtener datos del formulario
    let idDrapesNombre = $('#SelectControl').val();
    let tipoArticulo = $('#SelectControl option:selected').text();
    let area = $("#autocomplete1").val();
    let nombreControl = $('#SelectCanales option:selected').attr('nombre');
    let codigoControl = $('#SelectCanales option:selected').attr('codigo');
    let nombreTipoControl = $('#SelectCanales option:selected').attr('imgnombre');
    let precio = $("#Precio").val();
    let cantidad = $("#cantidadControles").val();
    let imgRuta = "../../assets/img/cortineros/" + nombreTipoControl + ".jpg";

    // DEBUG: Verificar todos los datos
    console.log("📦 Datos recolectados:");
    console.log("  - idDrapesNombre:", idDrapesNombre);
    console.log("  - codigoControl:", codigoControl);
    console.log("  - area:", area);
    console.log("  - precio:", precio);
    console.log("  - cantidad:", cantidad);

    // Generar ID: si opID es "nuevo" (alta) se arma uno único; si no, se respeta el id al editar
    let opID = $("#opID").val();
    let id = (opID && opID !== "nuevo")
        ? opID
        : idDrapesNombre + "*" + codigoControl + "*" + area;

    console.log("🆔 ID generado:", id);

    // Validación final
    if (!id || !codigoControl) {
        console.error("❌ Datos incompletos para generar ID");
        triggerModal("Error: Datos incompletos. Verifique la selección.");
        return;
    }

    // 🚀 ENVÍO AL CARRITO - ESTO ES LO QUE FALTABA
    /*console.log("📤 Enviando datos al carrito...");
    
    $.post("LlenarCarrito.php", {
        id: id,
        Cantidad: cantidad,
        precioFinal: precio,
        nombre: nombreControl,
        codigo: codigoControl,
        tipoarticulo: tipoArticulo,
        ruta: imgRuta,
        area: area,
        TipoArticuloDetalle: tipoArticulo,
        idDrapesNombre: idDrapesNombre
    }, function(response) {
        console.log("✅ Envío exitoso al carrito");
        console.log("📥 Respuesta del servidor:", response);
        
        // 🎯 REDIRECCIÓN A LA PÁGINA DE TERMINAR
        $("#situo").submit();
        setTimeout(() => {
            window.location.href = "index.php?opcion=terminar";
        }, 300);
    }).fail(function(xhr, status, error) {
        console.error("❌ Error en el envío al carrito:");
        console.error("  - Status:", status);
        console.error("  - Error:", error);
        console.error("  - Response:", xhr.responseText);
        
        triggerModal("Error al agregar al carrito: " + error);
    });*/


    //console.log("📤 Enviando datos al carrito...");

let formData = new FormData();
formData.append('id', id);
formData.append('Cantidad', cantidad);
formData.append('precioFinal', precio);
formData.append('nombre', nombreControl);
formData.append('codigo', codigoControl);
formData.append('tipoarticulo', tipoArticulo);
formData.append('ruta', imgRuta);
formData.append('area', area);
formData.append('TipoArticuloDetalle', tipoArticulo);
formData.append('idDrapesNombre', idDrapesNombre);
formData.append('Operacion', 'AGREGAR');
formData.append('Operacion','SUPRIMIR');
formData.append('Operacion','ELIMINAR');

//console.log("📦 FormData preparado, enviando...");

$.ajax({
    url: "LlenarCarrito.php",
    type: "POST",
    data: formData,
    processData: false,  // ¡IMPORTANTE!
    contentType: false,  // ¡IMPORTANTE!
    success: function(response) {
        //console.log("✅ Envío exitoso al carrito");
        //console.log("📥 Respuesta del servidor:", response);
        
        // Redirección
        $("#situo").submit();
        setTimeout(() => {
            window.location.href = "index.php?opcion=terminar";
        }, 300);
    },
    error: function(xhr, status, error) {
        console.error("❌ Error en el envío al carrito:");
        console.error("  - Status:", status);
        console.error("  - Error:", error);
        console.error("  - Response:", xhr.responseText);
        
        triggerModal("Error al agregar al carrito: " + error);
    }
});
}

function cambiarControl(){
    callBackControles();
}

function callBackControles(){
    let codigoTipoControl = $("#SelectControl").val();

    cargarControles(codigoTipoControl);

    setTimeout(()=>{
        let precio = $("#SelectCanales").val();
        precioControl(precio);
    }, 400);
}

function cargarControles(codigo) {
    //console.log("📥 Cargando controles para código:", codigo);
    //console.log("🔗 URL destino:", "../fnc/domotica.php");
    
    controlesCargados = false;
    $("#BotonEnviar").prop('disabled', true).html('Cargando controles...');
    
    // Mostrar spinner de carga
    $("#cargando").show().html('Cargando controles disponibles...');
    
    $.ajax({
        url: "../fnc/domotica.php",
        type: "POST",
        data: { 
            codigo: codigo, 
            accion: "controles" 
        },
        timeout: 15000, // Aumentar timeout
        beforeSend: function() {
            //console.log("🔄 Iniciando solicitud AJAX...");
        },
        success: function(data, status, xhr) {
            //console.log("✅ Solicitud exitosa - Status:", status);
            //console.log("📦 Datos recibidos (primeros 100 chars):", data.substring(0, 100));
            
            $("#SelectCanales").html(data);
            controlesCargados = true;
            
            //console.log("✅ Controles cargados exitosamente");
            //console.log("📊 Opciones cargadas:", $("#SelectCanales option").length);
            
            // Habilitar el botón
            $("#BotonEnviar").prop('disabled', false).html('Generar');
            $("#cargando").hide();
            
            // Establecer precio del primer control
            setTimeout(() => {
                const primerPrecio = $("#SelectCanales").val();
                if (primerPrecio) {
                    precioControl(primerPrecio);
                    //console.log("💰 Precio inicial establecido:", primerPrecio);
                } else {
                    //console.warn("⚠️ No se pudo establecer precio inicial");
                }
            }, 100);
            
        },
        error: function(xhr, status, error) {
            console.error("❌ Error en AJAX:");
            console.error("  - Status:", status);
            console.error("  - Error:", error);
            console.error("  - Response:", xhr.responseText);
            console.error("  - Status code:", xhr.status);
            
            let mensajeError = "Error al cargar controles: ";
            if (status === "timeout") {
                mensajeError += "Timeout (15 segundos)";
            } else if (xhr.status === 404) {
                mensajeError += "Archivo no encontrado";
            } else if (xhr.status === 500) {
                mensajeError += "Error interno del servidor";
            } else {
                mensajeError += error;
            }
            
            triggerModal(mensajeError);
            $("#BotonEnviar").prop('disabled', false).html('Generar - Error');
            $("#cargando").hide();
        },
        complete: function(xhr, status) {
            //console.log("🏁 Solicitud completada - Status:", status);
        }
    });
}

function precioControl(precio){
    let precio_format = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'MXN' })
                             .format(precio)
                             .replace("MX", "");

    $("#Precio").val(precio);
    $("#label_cantidad").html(precio_format);
    $("#PrecioFinal").val(precio);
}

function triggerModal(mensaje){
    $(".msjModal").html(mensaje);
    $("#msj").modal();
}