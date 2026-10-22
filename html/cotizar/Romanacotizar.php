<?php
    require_once '../fnc/PersianaFnc.php';
?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
    <script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
    <link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
    <link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css" />

    <style>
    #infoButtonTrigger {
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        color: inherit;
        transition: opacity 0.2s;
        position: relative;
        display: inline-block;
    }
    
    #infoButtonTrigger:hover {
        opacity: 0.7;
    }

    /* Tooltip con imagen */
    .info-tooltip {
        display: none;
        position: absolute;
        background-color: #ffffff;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        z-index: 10000;
        top: 50%;
        left: calc(100% + 15px);
        transform: translateY(-50%);
        white-space: nowrap;
        min-width: 200px;
        opacity: 1 !important;
        background-clip: padding-box;
    }

    .info-tooltip.show {
        display: block;
    }

    .info-tooltip-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .info-tooltip-image {
        max-width: 146px;
        max-height: 212px;
        width: auto;
        height: auto;
        border-radius: 4px;
        margin-bottom: 12px;
        display: block;
        opacity: 1 !important;
    }

    .info-tooltip-text {
        color: #555;
        line-height: 1.5;
        font-size: 13px;
        text-align: center;
        white-space: normal;
    }

    .info-tooltip-text p {
        margin: 0;
    }
    </style>


    <script>
/* =========================
   Cotizador Romana (JS fijo)
   ========================= */
let FinalTela = 0;
let FinalForro = 0;

// Función centralizada para obtener el valor de Varilla
// Lee siempre el estado actual del checkbox - NO depende de variables globales
function getVarilla() {
  return $("#opc_varilla").is(":checked") ? "SI" : "NO";
}

$(function () {
  //— El checkbox de Varilla se mantendrá en su estado natural
  //   (unchecked por defecto para nuevos productos)
  //   No forzamos ningún estado, dejamos que el usuario pueda marcarlo/desmarcarlo
  //   y que getVarilla() lea el estado actual cuando se haga submit
  
  //— Recalcular ante cualquier cambio relevante (incluye colores inyectados por AJAX)
  $("#Telas, #TelasForro, #hojas, #lado_cordon, #fijacion, #ancho, #alto, #cantidad, #opc_varilla").on("change keyup", CargarValor);
  $(document).on("change", 'input[name="color"], input[name="colorforro"]', CargarValor);

  //— Al cambiar la tela, resetea color/importe y vuelve a cargar paleta
  $("#Telas").on("change", function () {
    var telaSeleccionada = $("#Telas option:selected").html();
    var cortineroseasy = ['NALU', 'KAIRA', 'SAMARA', 'TALA'];
    
    $("#colores").hide().empty();
    FinalTela = 0;
    $("#label_cantidadFinal2").text("$0.00");
    
    // Lógica para cinta transparente XL
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
        $("#cinta_blanco").prop('selected', true);
      }
    }
    
    ColorVariable();
  });

  //— Al cambiar la tela del forro, resetea color/importe y recarga paleta
  $("#TelasForro").on("change", function () {
    $("#coloresforro").hide().empty();
    FinalForro = 0;
    $("#PrecioFinalForroReal").val("0.00");
    $("#precios #precio_forro .label_cantidad").text("$0.00");
    ColorVariableForro();
  });

  //— Envío del formulario
  $("#cortina").on("submit", function (e) {
    e.preventDefault();

    const telaNombre = $("#Telas option:selected").text().trim();
    const telaValor  = $("#Telas").val(); // código/categoría
    const nombre = "Cortina Romana ";
    const Color = $('input[name="color"]:checked').val();
    const Cantidad = toInt($("#cantidad").val());
    const precioFinalTelaUnitario = FinalTela;

    const Codigo         = $("#CodigoComodin").val();
    const CodigoTela     = $("#CodigoTela").val();
    const PrecioTelaHid  = $("#PrecioTela").val();
    const CodigoMecan    = $("#CodigoMecanismo").val();
    const PrecioMecan    = $("#PrecioMecanismo").val();
    const Metraje        = $("#metrajeUnitarioFinal").val();
    const Ancho          = $("#ancho").val();
    const Alto           = $("#alto").val();

    const MetrajeForro   = $("#MetrajeForro").val();
    const telaForroNombre= $("#TelasForro option:selected").text().trim();
    const telaForroValor = $("#TelasForro").val();
    const ColorForro     = $('input[name="colorforro"]:checked').val();
    const precioFinalForroUnitario = FinalForro;
    const CodigoTelaForro = $("#CodigoTelaForro").val();
    const PrecioTelaForroHid = $("#PrecioTelaForro").val();

    const area = $("#autocomplete1").val();
    const Varilla = getVarilla();
    

    const Hojas = $("#hojas").val();
    const LadoCordon = $("#lado_cordon").val();
    const Fijacion = $("#fijacion").val();

    const ruta = Varilla === "SI"
      ? "../../assets/img/tipopersiana/romana.jpg"
      : "../../assets/img/tipopersiana/pacheto.jpg";

    const id = `romana*${Codigo}*${Ancho}*${Alto}*${CodigoTela}*${Color}`;

    //— Validaciones mínimas
    if (!area) { $("#modalcorreo").modal(); return; }
    if (!Color) { alert("Selecciona un color para la tela principal."); return; }
    if (!isPositive(Ancho) || !isPositive(Alto) || !isPositive(Cantidad)) {
      alert("Revisa ancho/alto/cantidad: deben ser números positivos.");
      return;
    }
    //— Máximos (2 x 2 m)
    if (parseFloat(Ancho) > 2 || parseFloat(Alto) > 2) {
      $("#cargando2_medidas").show();
      $("#BtnD").hide();
      $("#cargando").hide();
      $("#msj").modal("show");
      return;
    }

    const datosEnvio = {
      area,
      Cantidad,
      nombre,
      id,
      ancho: Ancho,
      alto: Alto,
      TipoArticuloDetalle: "romana",
      codigo: Codigo,
      tela: telaNombre,     // visible para humanos
      tipo_tela: telaValor, // valor/código por si lo usas en backend
      color: Color,
      CodigoTela,
      PrecioTela: PrecioTelaHid,
      CodigoMecanismo: CodigoMecan,
      PrecioMecanismo: PrecioMecan,
      Metraje,
      tipoarticulo: "romana",
      ruta,
      Varilla,
      hojas: Hojas,
      lado_cordon: LadoCordon,
      fijacion: Fijacion
    };
    if (!CodigoMecan || !PrecioMecan || PrecioMecan === "0" || PrecioMecan === "0.00") {
      delete datosEnvio.CodigoMecanismo;
      delete datosEnvio.PrecioMecanismo;
    }

    //— Precio unitario y total coherentes
    if (telaForroValor && ColorForro) {
      datosEnvio.precioFinal = round2(precioFinalTelaUnitario + precioFinalForroUnitario);
      datosEnvio.telaForro = telaForroNombre;
      datosEnvio.tipo_tela_forro = telaForroValor;
      datosEnvio.ColorForro = ColorForro;
      datosEnvio.PrecioFinalForro = round2(precioFinalForroUnitario);
      datosEnvio.CodigoTelaForro = CodigoTelaForro;
      datosEnvio.PrecioTelaForro = PrecioTelaForroHid;
      datosEnvio.MetrajeForro = MetrajeForro;
    } else {
      datosEnvio.precioFinal = round2(precioFinalTelaUnitario);
    }

    $.post("LlenarCarrito.php", datosEnvio)
      .done(function () {
        window.location.href = "index.php?opcion=terminar";
      })
      .fail(function () {
        alert("Hubo un error al agregar el producto al carrito. Inténtalo de nuevo.");
      });
  });

  //— Cargas iniciales
  ColorVariable();
  ColorVariableForro();
  CargarValor();
});

/* =========================
   Núcleo de cálculo
   ========================= */
function CargarValor() {
  const TelaNombre = $("#Telas option:selected").text().trim();
  const Color = $('input[name="color"]:checked').val();
  const Ancho = $("#ancho").val();
  const Alto  = $("#alto").val();
  const Cantidad = toInt($("#cantidad").val());
  const Varilla = getVarilla();

  // Cambia imagen de referencia
  const url = Varilla === "SI"
    ? "../../assets/img/tipopersiana/romana.jpg"
    : "../../assets/img/tipopersiana/pacheto.jpg";
  const div = document.getElementById("imagen");
  if (div) div.style.backgroundImage = "url(" + url + ")";

  $("#varilla_status_text").text(Varilla === "SI" ? "Con Varilla" : "Sin Varilla (Estilo Pacheto)");

  // Si faltan datos mínimos, limpia y no calcula
  if (!Color || !isPositive(Ancho) || !isPositive(Alto) || !isPositive(Cantidad)) {
    FinalTela = 0; FinalForro = 0;
    actualizarPrecioTotalYValidaciones();
    return;
  }

  // Máximos 2x2
  if (parseFloat(Ancho) > 2 || parseFloat(Alto) > 2) {
    $("#cargando2_medidas").show();
    $("#BtnD").hide();
    $("#cargando").hide();
    $("#msj").modal("show");
    return;
  } else {
    $("#cargando2_medidas").hide();
  }

  $("#cargando").css("display", "inline");
  $("#BtnD").hide();
  $("#noCalcula").hide();

  //— Precio principal (unitario)
  $.post("PachetoCotizarPrecio.php", {
    Alto: Alto,
    Acoplamiento: $("input[name='acoplamiento']:checked").val() || "Una",

    Ancho: Ancho,
    Tela: TelaNombre, // si tu backend prefiere código, cámbialo a $("#Telas").val()
    Varilla: Varilla,
    Color: Color,
    ForroX: "NO",
    Cantidad: 1
  })
  .done(function (html) {
    $("#precio").html(html);
    FinalTela = toFloat($("#PrecioFinal").val()); // viene del fragmento insertado
    $("#PrecioFinalReal").val(round2(FinalTela));

    // Sincroniza comodines/metraje
    $("#CodigoComodin").val($("#CodigoComodin").val() || "");
    $("#CodigoTela").val($("#CodigoTela").val() || "");
    $("#PrecioTela").val($("#PrecioTela").val() || round2(FinalTela));
    $("#CodigoMecanismo").val($("#CodigoMecanismo").val() || "");
    $("#PrecioMecanismo").val($("#PrecioMecanismo").val() || "0.00");
    $("#metrajeUnitarioFinal").val($("#metrajeUnitarioFinal").val() || "0");

    //— Precio forro (si aplica)
    const forroVal = $("#TelasForro").val();
    const forroNom = $("#TelasForro option:selected").text().trim();
    const ColorForro = $('input[name="colorforro"]:checked').val();

    if (forroVal && ColorForro) {
      $.post("PachetoCotizarPrecio.php", {
        Alto: Alto,
        Ancho: Ancho,
        Tela: forroNom,
        Varilla: "NO",
        Color: ColorForro,
        ForroX: "SI",
        Cantidad: 1
      })
      .done(function (htmlForro) {
        const $tmp = $("<div/>").html(htmlForro);
        FinalForro = toFloat($tmp.find("#PrecioFinal").val());
        // 👇 DESCUENTO DEL 40% APLICADO AL FORRO
FinalForro = FinalForro * 0.415;


        $("#PrecioFinalForroReal").val(round2(FinalForro));
        $("#precios #precio_forro .label_cantidad").text("$" + round2(FinalForro));
        $("#CodigoTelaForro").val($tmp.find("#CodigoTela").val() || "");
        $("#PrecioTelaForro").val($tmp.find("#PrecioTela").val() || round2(FinalForro));
        $("#MetrajeForro").val($tmp.find("#ComodinMetraje").val() || "0");
        actualizarPrecioTotalYValidaciones();
      })
      .fail(function () {
        FinalForro = 0;
        actualizarPrecioTotalYValidaciones();
      });
    } else {
      FinalForro = 0;
      $("#PrecioFinalForroReal").val("0.00");
      $("#precios #precio_forro .label_cantidad").text("$0.00");
      $("#PrecioTelaForro").val("0.00");
      actualizarPrecioTotalYValidaciones();
    }
  })
  .fail(function () {
    FinalTela = 0;
    actualizarPrecioTotalYValidaciones();
    $("#cargando").hide();
    alert("Error al calcular el precio de la tela principal.");
  });
}

/* =========================
   UI y helpers
   ========================= */
function actualizarPrecioTotalYValidaciones() {
  const Cantidad = toInt($("#cantidad").val());
  const total = round2((FinalTela + FinalForro) * Cantidad);

  // Actualiza el total en pantalla
  $("#label_cantidadFinal2").text("$" + total);

  // Mostrar/ocultar el botón “Generar” según el valor
  if (total > 0) {
    $("#BtnD").show();
    $("#noCalcula").hide();
  } else {
    $("#BtnD").hide();
  }

  // Oculta loaders
  $("#cargando").hide();
  $("#cargando2").hide();
}


function ColorVariable() {
  const elegido = $("#Telas option:selected").text().trim();
  if (!elegido) return;
  $.post("cotizarcolores.php", { elegido }, function (html) {
    $("#colores").html(html).show();
  });
}

function ColorVariableForro() {
  const elegidoForroTxt = $("#TelasForro option:selected").text().trim();
  const elegidoForroVal = $("#TelasForro").val();
  if (!elegidoForroTxt || !elegidoForroVal) {
    $("#coloresforro").hide().empty();
    FinalForro = 0;
    $("#PrecioFinalForroReal").val("0.00");
    $("#precios #precio_forro .label_cantidad").text("$0.00");
    $("#PrecioTelaForro").val("0.00");
    return;
  }
  $.post("cotizarcoloresforro.php", { elegidoForro: elegidoForroTxt }, function (html) {
    $("#coloresforro").html(html).show();
  });
}

//— Cantidades rápidas
function seleccionarNumero(num) {
  const $inp = $("#cantidad");
  if (num === "5+") {
    $inp.val("").focus();
  } else {
    $inp.val(num);
  }
  CargarValor();
  $(".btn_cantidad").removeClass("active");
  $("#btn_cantidad_" + (num === "5+" ? "5" : num)).addClass("active");
}

//— Solo números (legacy)
function ValidaSoloNumeros() {
  if (event.keyCode < 48 || event.keyCode > 57) event.returnValue = false;
}

//— Validación de números con 2 decimales
function NumCheck(e, field) {
  const key = e.keyCode ? e.keyCode : e.which;
  if (key === 8) return true; // backspace
  if (key >= 48 && key <= 57) {
    if (field.value === "") return true;
    const regexp = /^\d+(\.\d{0,2})?$/;
    if (field.value.includes(".") && key === 46) return false;
    if (field.value.indexOf(".") !== -1 && field.value.substring(field.value.indexOf(".")).length > 2 && key !== 8) return false;
    return regexp.test(field.value + String.fromCharCode(key));
  }
  if (key === 46) {
    if (field.value === "" || field.value.includes(".")) return false;
    return true;
  }
  return false;
}

//— Helpers numéricos seguros
function toFloat(v) {
  const n = parseFloat(String(v).replace(",", "."));
  return isFinite(n) ? n : 0;
}
function toInt(v) {
  const n = parseInt(v, 10);
  return isFinite(n) && n > 0 ? n : 0;
}
function isPositive(v) { return toFloat(v) > 0; }
function round2(n) { return (Math.round((toFloat(n)) * 100) / 100).toFixed(2); }

//— Tabs
function openTab(evt, tabName) {
  const tabcontent = document.getElementsByClassName("tabcontent");
  for (let i = 0; i < tabcontent.length; i++) tabcontent[i].style.display = "none";
  const tablinks = document.getElementsByClassName("tablinks");
  for (let i = 0; i < tablinks.length; i++) tablinks[i].className = tablinks[i].className.replace(" active", "");
  document.getElementById("tab_" + tabName).style.display = "block";
  evt.currentTarget.className += " active";
}

//— Inicializar la lógica de cinta transparente XL al cargar la página
$(document).ready(function(){
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
});
</script>

    <form id="cortina" class="pacheto" name="pacheto"> 
        <div class="container-left">
            <div class="card card-outlined style-default-light">
                <div class="card-head">
                    <h3>Romana</h3>
                </div>
                <div class="card-body no-padding height-7">
                    <div id="imagen" class="img-backdrop" style="background-image: url('../../assets/img/tipopersiana/romana.jpg')"></div>
                </div>
            </div>
        </div>
        <div class="container-right">
            <div class="container-right-top">
                <div class="container-right-top-tab">
                    <div class="col-sm-5">
                        <label for="cantidad">Cantidad <span class="comentario_label">*Unidad</span></label>
                        <div class="cantidades">
                            <button type="button" id="btn_cantidad_1" onclick="seleccionarNumero('1')" class="btn_cantidad active">1</button>
                            <button type="button" id="btn_cantidad_2" onclick="seleccionarNumero('2')" class="btn_cantidad">2</button>
                            <button type="button" id="btn_cantidad_3" onclick="seleccionarNumero('3')" class="btn_cantidad">3</button>
                            <button type="button" id="btn_cantidad_4" onclick="seleccionarNumero('4')" class="btn_cantidad">4</button>
                            <button type="button" id="btn_cantidad_5" onclick="seleccionarNumero('5+')" class="btn_cantidad">5+</button>
                            <input type="tel" class="form-control" id="cantidad" value="1" min="1" onkeypress="ValidaSoloNumeros()" onchange="CargarValor()" onkeyup="CargarValor()" required >
                        </div>
                        <label for="autocomplete1">Espacio</label>
                        <input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
                    </div>
                    <div class="col-sm-3">
                        <label for="ancho">Ancho (mts)</label>
                        <input type="number" id="ancho" name="ancho" min="0.1" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required >
                        <label for="alto">Alto (mts)</label>
                        <input type="number" id="alto" name="alto" min="0.1" step="0.01" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required >
                    </div>
                    <div class="col-sm-4">
                        <div id="notastock" class="status" style="display:none;"></div>
                        <div id="notasTela" style="font-weight:bold;"></div>
                    </div>
                </div>
                <div class="tab-options">
                    <button class="tablinks active" onclick="openTab(event,'1')" type="button">DATOS GENERALES</button>
                </div>
                <div id="tab_1" class="tabcontent tab-bg row" style="display:block;">
                    <div class="col-sm-6"> 
                        <label>SELECCIONA EL TIPO DE TELA</label>
                        <?php
                            $ArregloTipoTela = TraerTipoTela("PACHETO"); 
                            $Filas = count($ArregloTipoTela);
                            echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
                            echo '<option value="" selected disabled>Seleccione una tela...</option>'; 
                                for( $i=0; $i<$Filas; $i++ ){
                                    echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';
                                }
                            echo "</select>";
                        ?>
                        <!--<div class="text-muted">(<b>*</b>) Sujeto a disponibilidad</div>-->
                        
                        <!--<label style="margin-top: 10px;">SELECCIONA TELA PARA FORRO (OPCIONAL)</label>-->
                        <?php
                          /*
                            $ArregloTipoTelaForro = TraerTipoTela("FORROPACHETO"); 
                            $FilasForro = count($ArregloTipoTelaForro);
                            echo '<select class="form-control" data-placeholder="Select an item" name="TelasForro" id="TelasForro">';
                            echo '<option value="">Sin Forro</option>'; 
                                for( $i=0; $i<$FilasForro; $i++ ){
                                    echo '<option value="'.$ArregloTipoTelaForro[$i]['tipotela'].'"">'. $ArregloTipoTelaForro[$i]['nombre'] .'</option>';
                                }
                            echo "</select>";
                            */
                        ?>
                         <div style="margin-top:15px;">
                            <label for="hojas">Hoja</label>
                            <select id="hojas" name="hojas" class="form-control" onchange="CargarValor()">
                                <option value="1" selected>1 Hoja</option>
                                <option value="2"></option>
                                </select>
                        </div>
                        <div style="margin-top:10px;">
                            <label for="lado_cordon">Lado del Cordón/Mecanismo</label>
                            <select id="lado_cordon" name="lado_cordon" class="form-control" onchange="CargarValor()">
                                <option value="DERECHO" selected>Derecho</option>
                                <option value="IZQUIERDO">Izquierdo</option>
                            </select>
                        </div>
                         <div style="margin-top:10px;">
                            <label for="fijacion">Tipo de Fijación</label>
                            <select id="fijacion" name="fijacion" class="form-control" onchange="CargarValor()">
                                <option value="TECHO" selected>Techo</option>
                                <option value="PARED">Pared</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6"> 
                        <div id="colores" style="display:none;"></div>
                        <div id="coloresforro" style="margin-top: 10px; display:none;"></div>
                    </div> 
                    <div class="col-sm-12" style="margin-top:15px;"> 
                        <div class="form">
                           <!-- <div class="checkbox checkbox-styled tile-text">
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
                                        </div>
                                    </button>
                                </label>
                                <div style="font-size: 0.9em; margin-left: 20px; display: inline-block; vertical-align: middle;">
                                    (<span id="varilla_status_text">Sin Varilla (Estilo Pacheto)</span>)
                                </div>
                            </div>
                        </div>-->
                        <div class= "chekbox-styled title text">
                            <label>
                                <input type="checkbox" id="opc_varilla" name="opc_varilla" value="SI" onchange='CargarValor()'>
                                <span>Incluir varilla</span>
                                <button type="button" id="infoButtonTrigger" style="margin-left: 10px; padding: 0; border: none; background: none; cursor: pointer; position: relative; vertical-align: middle;">
                                    <i class="bi bi-info-circle-fill" style="font-size: 1.2em; color: #0066cc;"></i>
                        </div>

                        
                        <div id="cargando2" style="display:none; color: red; margin-top:10px;"><b></b></div>
                        <div id="noCalcula" style="display:none; color: red; margin-top:10px;"><b>Debido a dimensiones NO se puede calcular. Contacte a su ejecutivo.</b></div>
                        <div id="cargando2_medidas" style="display:none; color: red; margin-top:10px;">Excede las medidas máximas (2 x 2), cambiar valores.</div> 

                        <div class="modal fade" id="msj" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="simpleModalLabelMsj">Información</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p id="msj_text">Excede las medidas máximas (2 x 2).</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" value="NEL" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="panel_inferior">
                <div id="precio" style="display: none;"></div>

                <div id="precios">
                    <div id="precio_total" class="precio_total">
                        <label class="label_total">Precio Total</label>
                        <label id="label_cantidadFinal2" class="label_cantidad">$0.00</label>
                        <input id='PrecioFinalReal' class='form-control' name='PrecioFinalTelaPrincipalUnitario' value='0.00' style='text-align: right;' type="hidden" readonly>
                        
                        <input type="hidden" id="CodigoComodin" name="CodigoComodin" value="">
                        <input type="hidden" id="CodigoTela" name="CodigoTela" value="">
                        <input type="hidden" id="PrecioTela" name="PrecioTela" value="0.00"> 
                        <input type="hidden" id="CodigoMecanismo" name="CodigoMecanismo" value="">
                        <input type="hidden" id="PrecioMecanismo" name="PrecioMecanismo" value="0.00">
                        <input type="hidden" id="metrajeUnitarioFinal" name="metrajeUnitarioFinal" value="0">
                        
                        <input type="hidden" id="CodigoTelaForro" name="CodigoTelaForro" value="">
                        <input type="hidden" id="PrecioTelaForro" name="PrecioTelaForro" value="0.00">
                        <input type="hidden" id="MetrajeForro" name="MetrajeForro" value="0">

                    </div>
                    <img src="../../assets/img/iconos/derecha.png" alt="Derecha">
                    <div id="precio_forro" class="precio_total">
                        <label class="label_total">Precio Forro</label>
                        <label class="label_cantidad">$0.00</label>
                        <input id='PrecioFinalForroReal' name='PrecioFinalForroUnitario' class='form-control' value='0.00' style='text-align: right;' type="hidden" readonly>
                    </div>
                </div>
                <div id="cargando" style="display:none; color:green;">Cargando...</div>
                <div id="BtnD" style="display:none;"><button type="submit" id="BotonEnviar">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
            </div>
        </div>
    </form>
    
    <div class="modal fade" id="modalcorreo" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true"> 
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="simpleModalLabelCorreo">Información</h4>
                </div>
                <div class="modal-body">
                    <p>El "<b>Espacio</b>" es un campo requerido para poder enviar la cotización. Favor de capturarlo</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button> 
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function ($) {
            $(document).delegate('*[data-toggle="lightbox"]:not([data-gallery="navigateTo"])', 'click', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                    onShown: function() { if (window.console) {} },
                    onNavigate: function(direction, itemIndex) { if (window.console) {} }
                });
            });
            $('#open-image, #open-youtube').click(function (e) {
                e.preventDefault(); $(this).ekkoLightbox();
            });
            $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
                event.preventDefault();
                return $(this).ekkoLightbox({
                    onShown: function() {
                        var a = this.modal_content.find('.modal-footer a');
                        if(a.length > 0) { a.click(function(e) { e.preventDefault(); this.navigateTo(2); }.bind(this)); }
                    }
                });
            });
        });
    </script>

    <script src="../../assets/js/cotizar.js"></script> 
    <script src="../../assets/js/core/source/App.js"></script>
    <script src="../../assets/js/libs/select2/select2.min.js"></script>
    <script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
    <script src="../../assets/js/core/demo/Demo.js"></script>
    <script src="../../assets/js/core/demo/DemoFormComponents.js"></script>
