
function QuitarForro() {
    // Obtener el texto de la opci�n seleccionada en el select de Telas
    // Usamos try-catch o verificamos existencia para evitar errores si el elemento no existe
    var telasSelect = $("#Telas");
    if (telasSelect.length === 0) return;

    var tipoTela = telasSelect.find("option:selected").text().trim().toUpperCase();
    
    console.log("Ejecutando QuitarForro para: " + tipoTela);

    // Verificar si contiene "frescura" o "translucida"
    if (tipoTela.indexOf("FRESCURA") !== -1 || tipoTela.indexOf("TRANSLUCIDA") !== -1) {
        // Ocultar completamente el contenedor del forro
        $("#forros2").css("display", "none");
        
        // Deshabilitar el select de forro
        $("#TelasForro").prop("disabled", true);
        
        // Limpiar la selecci�n actual
        $("#TelasForro").val("");
        
        // Ocultar colores de forro y limpiar
        $("#coloresforro").hide().empty();
        
        // Resetear variables de precio globales si existen (Romanacotizar.php)
        if (typeof FinalForro !== 'undefined') {
            FinalForro = 0;
        }
        
        // Resetear inputs de precio de forro (Varios archivos)
        $("#PrecioFinalForroReal").val("0.00");
        $("#PrecioFinalForro").val("0.00");
        $("#PrecioFinalForro2").val("0.00");
        $("#PrecioTelaForro").val("0.00");
        $("#precios #precio_forro .label_cantidad").text("$0.00");
        
        // Limpiar selecci�n de color de forro
        $('input[name="colorforro"]').prop('checked', false);
        
        // Recalcular totales si la funci�n existe (Romanacotizar.php)
        if (typeof actualizarPrecioTotalYValidaciones === 'function') {
            actualizarPrecioTotalYValidaciones();
        }
        
    } else {
        // Habilitar el select de forro
        $("#TelasForro").prop("disabled", false);
        
        // Mostrar el contenedor de forro si no es BLACK OUT
        // La validación de BLACK OUT se maneja en CargarValor()
        if (tipoTela.indexOf("BLACK OUT") === -1) {
            $("#forros2").css("display", "inline");
        }
    }
}
