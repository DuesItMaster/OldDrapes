<?php
    require_once '../fnc/CortinaFnc.php';
    $valor = $_GET['opc'];
    $Gancho = TRUE;
    $TipoTela ="";
    $FactorPlizaje=2.5;

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
?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">  
    <script src="../../assets/js/libs/jquery/jquery-1.11.2.min.js"></script>
    <script src="../../assets/js/libs/jquery-ui/jquery-ui.min.js"></script>
    <script src="../../assets/js/imgmodal/ekko-lightbox.js"></script>
    <!-- Bootstrap Icons Font CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <link type="text/css" rel="stylesheet" href="../../assets/css/imgmodal/ekko-lightbox.css" />
    <link type="text/css" rel="stylesheet" href="../../assets/css/cotizar.css?v=1" />

    <script language="javascript">


document.addEventListener("DOMContentLoaded", function () {
    const ambosRadio = document.getElementById("Ambos");
    const cortinaIrregular = document.getElementById("cortinaIrregular");

    // Listener para "Ambos 2 Hojas" radio button
    ambosRadio.addEventListener("change", function () {
        toggleCortinaIrregular(true);
        clearFields(); // Limpia campos al seleccionar "Ambos 2 Hojas"
    });

    // Listener para otros radio buttons
    const otherRadios = document.querySelectorAll("input[type='radio']:not(#Ambos)");
    otherRadios.forEach(radio => {
        radio.addEventListener("change", function () {
            toggleCortinaIrregular(false);
            clearFields(); // Limpia campos y oculta al seleccionar otro radio
        });
    });

    // Listener para el checkbox de "Cortina Irregular"
    cortinaIrregular.addEventListener("change", function () {
        toggleHojaFields(); // Muestra u oculta campos de Hoja Izquierda y Derecha
    });

    // Listener para el campo Hoja Izquierda
    document.getElementById("hojaIzquierda").addEventListener("input", autoFillHojaDerecha);
});

function toggleCortinaIrregular(show) {
    const cortinaIrregularContainer = document.getElementById("cortinaIrregularContainer");
    cortinaIrregularContainer.style.display = show ? "block" : "none";
    toggleHojaFields(); // Asegura que los campos de hoja se oculten si no se selecciona "Ambos 2 Hojas"
}

function toggleHojaFields() {
    const hojaFields = document.getElementById("hojaFields");
    const cortinaIrregular = document.getElementById("cortinaIrregular");

    // Muestra/oculta campos de Hoja Izquierda y Derecha
    hojaFields.style.display = cortinaIrregular.checked ? "block" : "none";
}

function clearFields() {
    // Limpia los campos de Hoja Izquierda, Hoja Derecha y desmarca Cortina Irregular
    document.getElementById("hojaIzquierda").value = "";
    document.getElementById("hojaDerecha").value = "";
    document.getElementById("cortinaIrregular").checked = false;
    hideErrorMessage(); // Oculta el mensaje de error si está visible

    // Asegura que los campos de Hoja Izquierda y Derecha estén ocultos
    document.getElementById("hojaFields").style.display = "none";
}

function autoFillHojaDerecha() {
    const anchoInicial = parseFloat(document.getElementById("ancho").value) || 0;
    const hojaIzquierda = parseFloat(document.getElementById("hojaIzquierda").value) || 0;
    const hojaDerechaField = document.getElementById("hojaDerecha");

    // Calcula el valor de Hoja Derecha y redondea a dos decimales
    const hojaDerechaValue = Math.round((anchoInicial - hojaIzquierda) * 100) / 100;

    // Validación de que la suma no exceda el ancho inicial
    if (hojaIzquierda > anchoInicial) {
        showErrorMessage(`El valor en Hoja Izquierda no puede ser mayor que el Ancho Inicial de ${anchoInicial}.`);
        hojaDerechaField.value = ""; // Deja Hoja Derecha vacía
    } else {
        hideErrorMessage(); // Oculta cualquier mensaje de error si no hay problema
        hojaDerechaField.value = hojaDerechaValue; // Autocompleta Hoja Derecha redondeado a 2 decimales
    }
}

function showErrorMessage(message) {
    let errorMessage = document.getElementById("errorMessage");

    // Si no existe el elemento del mensaje de error, lo creamos
    if (!errorMessage) {
        errorMessage = document.createElement("div");
        errorMessage.id = "errorMessage";
        errorMessage.style.color = "red";
        errorMessage.style.marginTop = "5px";
        document.getElementById("hojaFields").appendChild(errorMessage);
    }
    errorMessage.textContent = message;
    errorMessage.style.display = "block";
}

function hideErrorMessage() {
    const errorMessage = document.getElementById("errorMessage");
    if (errorMessage) {
        errorMessage.style.display = "none";
    }
}

//HASTA AQUI ES EL SCRIPT QUE HACE LA FUNCIONALIDAD DE LA HOJA IZQUIERDA Y DERECHA Y EL DE CORTINA IRREGULAR
//SOLO COPIA ES COPIAR ESTA ESTRUCTURA DE SCRIPT EN EL RESTO DE LAS CORTINAS Y EL DISEÑO DE LOS CAMPOS
//QUE COMENTE ANTERIORMENTE Y LISTO, YA HARIA EN TEORIA LA MISMA FUNCION QUE CORTINA ONDULADA.

        $(document).ready(function(){
            $("#Telas").change(function () {
                $("#colores").hide();
                $("#variables").hide();
                $("#PrecioFinal").val('0.00');
                $("#PrecioFinal2").val('0.00');
                ColorVariable();
                //NUEVO VALIDACION DE BORRAR DATOS CUANDO CAMBIA DE TELA//
                $("#PrecioFinalForro").val('0.00');
                $("#PrecioFinalForro2").val('0.00');
                ColorVariableForro();  
            });
            $("#TelasForro").change(function () {
                $("#coloresforro").hide();
                $("#variables").hide(); //PrecioFinalForro
                $("#PrecioFinalForro").val('0.00');
                $("#PrecioFinalForro2").val('0.00');
                ColorVariableForro();           
            });
        });
        function prueba() {
            tela= $("#Telas option:selected").html();
            
            // MODIFICADO: Añade el color del ojillo al nombre
            var colorOjillo = $("input[name='colorOjillo']:checked").val() || "";
            var nombre = "Cortina " + $("#nombre").val();
            if (colorOjillo) {
                nombre += "  " + colorOjillo;
            }
            
            Color= $("input[name='color']:checked").val();
            Cantidad = $("#cantidad").val();

            precioFinal = $("#PrecioFinal").val();

            Codigo = $("#CodigoComodin").val();

            CodigoTela = $("#CodigoTela").val();
            PrecioTela = $("#PrecioTela").val();
            Metraje = $("#Metraje").val();
            Ancho = $("#ancho").val();
            Alto = $("#alto").val();
            CodigoMo = $("#CodigoMo").val();
            PrecioMo = $("#PrecioMo").val();
            MetrajeMo = $("#MetrajeMo").val();

            telaForro = $("#TelasForro option:selected").html();
            ColorForro = $("input[name='colorforro']:checked").val();
            PrecioFinalForro = $("#PrecioFinalForro").val();
            CodigoTelaForro = $("#CodigoTelaForro").val();
            PrecioTelaForro = $("#PrecioTelaForro").val();
            CodigoMoForro = $("#CodigoMoForro").val();
            PrecioMoForro = $("#PrecioMoForro").val();
            MetrajeForro = $("#MetrajeForro").val();
            MetrajeMoForro = $("#MetrajeMoForro").val();
            
            MetrajeRealForro = $("#MetrajeRealForro").val();
            MetrajeMORealForro = $("#MetrajeMORealForro").val();
            PrecioRealForro = $("#PrecioRealForro").val();
            PrecioMoRealForro = $("#PrecioMoRealForro").val();

            CodigoBajoPlomo = $("#CodigoBajoPlomo").val();
            PrecioPlomo = $("#PrecioPlomo").val();
            MetrajeBajoPlomo = $("#MetrajeBajoPlomo").val();

            MetrajeReal = $("#MetrajeReal").val();
            MetrajeMOReal = $("#MetrajeMOReal").val();
            PrecioReal = $("#PrecioReal").val();
            PrecioMoReal = $("#PrecioMoReal").val();

            MetrajeBajoPlomoReal = $("#MetrajeBajoPlomoReal").val();

            ruta = $("#ruta").val();              
            Fijacion= $("input[name='fijacion']:checked").val();
            Acoplamiento= $("input[name='acoplamiento']:checked").val();
            Tipo= $("#tipo").val();

            Sti = MostrarValor();
            if (Sti == "TRUE"){ 
                Stiffener = "STIFFENER"; 
                CodigoStiffener = $("#CodigoStiffener").val();
                PrecioStiffener = $("#PrecioStiffener").val();
            }
            else{  
                Stiffener = "";
                CodigoStiffener="";
                PrecioStiffener="0"; 
            }

            Bp = BajoPlomoFnc();
            if (Bp == "TRUE"){ BajoPlomo = "BAJO PLOMO";}
            else{ BajoPlomo = "";}

            Gr = GanchoReforzado();
            if (Gr == "TRUE"){ Gancho = "GANCHO METALICO"; }
            else{ Gancho = ""; }

            Nl = NeverlightFunc();
            if (Nl == "TRUE"){ Never = "NEVER LIGHT"; }
            else{ Never = ""; }

            if(Tipo == "Ond" || Tipo == "Easy"){
                colorCinta = $("#cinta option:selected").val();
                if (colorCinta == "1") {
                    colorCinta = "Blanco";
                } else if (colorCinta == "2") {
                    colorCinta = "Transparente";
                } else if (colorCinta == "3") {
                    colorCinta = "Negra";
                } else if(colorCinta == "4"){
                    colorCinta = "Transparente XL";
                }
            }else{
                colorCinta = "";
            }

            area = $("#autocomplete1").val(); 
            id=Tipo+'*'+Codigo+'*'+Ancho+'*'+Alto+'*'+Fijacion+'*'+Acoplamiento+'*'+CodigoTela+'*'+Color+'*'+area+'*'+BajoPlomo+'*'+Gancho+'*'+Never;
            //ORIENTACION RAYAS
            OrientacionRayaCortina = $("#orientacionCortina").val();
            //ORIENTACION RAYAS

            cortinairregular = $("#cortinaIrregular").is(":checked") ? "1" : "0";
            hojaizquierda = cortinairregular === "1" ? $("#hojaIzquierda").val() : "";
            hojaderecha = cortinairregular === "1" ? $("#hojaDerecha").val() : "";

            
            if (typeof area == "undefined" || area == null  ||  area == ""  ){
                 $("#modalcorreo").modal(); 
                return false;
            }
            else{
                if (typeof Color == "undefined" || Color == null || 
                    typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
                    typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
                    typeof Alto == "undefined" || Alto == null || Alto == ""){
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
                        if (typeof ColorForro == "undefined" || ColorForro == null || ColorForro == "") {
                            // Calcular número de hojas
                            var numHojas = (Acoplamiento == "Ambos") ? 2 : 1;
                            // MODIFICADO: Añadido colorOjillo y numHojas
                            var data = {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
                                                        codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
                                                        stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
                                                        tipoarticulo:'cortina', ruta : ruta, CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,                  
                                                        CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo,
                                                        CodigoArgolla: CodigoArgolla, CantidadArgolla: CantidadArgolla, PrecioArgolla: PrecioArgolla,
                                                         MetrajeReal: MetrajeReal, MetrajeMOReal: MetrajeMOReal, PrecioReal: PrecioReal, PrecioMoReal: PrecioMoReal, MetrajeBajoPlomoReal: MetrajeBajoPlomoReal, colorCinta : colorCinta, OrientacionRayaCortina : OrientacionRayaCortina,
                                                        cortinairregular: cortinairregular, hojaizquierda: hojaizquierda, hojaderecha:hojaderecha, colorOjillo: colorOjillo, numHojas: numHojas };
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
                            if (PrecioFinalForro==0){
                                // FIX: Permitir guardar forro aunque el precio sea 0 si se seleccionó color
                                id = id + '*' + telaForro + '*' + ColorForro;
                                // Calcular número de hojas
                                var numHojas = (Acoplamiento == "Ambos") ? 2 : 1;
                                
                                var data = {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
                                                                 codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
                                                                 stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
                                                                 tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,
                                                                 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro,
                                                                 CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro,
                                                                 MetrajeForro:MetrajeForro, MetrajeMoForro:MetrajeMoForro,
                                                                 CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo,
                                                                 CodigoArgolla: CodigoArgolla, CantidadArgolla: CantidadArgolla, PrecioArgolla: PrecioArgolla, MetrajeReal: MetrajeReal, MetrajeMOReal: MetrajeMOReal, PrecioReal: PrecioReal, PrecioMoReal: PrecioMoReal, MetrajeRealForro : MetrajeRealForro, MetrajeMORealForro : MetrajeMORealForro, PrecioRealForro : PrecioRealForro, PrecioMoRealForro : PrecioMoRealForro, MetrajeBajoPlomoReal: MetrajeBajoPlomoReal, colorCinta : colorCinta,OrientacionRayaCortina : OrientacionRayaCortina,
                                                                cortinairregular: cortinairregular, hojaizquierda: hojaizquierda, hojaderecha:hojaderecha, colorOjillo: colorOjillo, numHojas: numHojas};
                                if (Sti != "TRUE"){
                                    delete data.stiffener;
                                    delete data.CodigoStiffener;
                                    delete data.PrecioStiffener;
                                }
                                $.post("LlenarCarrito.php", data, function(data2){ 
                                                                    window.location.href = "index.php?opcion=terminar";
                                                                 });
                            }else{
                                id = id + '*' + telaForro + '*' + ColorForro;
                                precioFinal = parseFloat(precioFinal) + parseFloat(PrecioFinalForro); //+  (parseFloat(MetrajeMo) * parseFloat(PrecioMoForro)) ;
                                // Calcular número de hojas
                                var numHojas = (Acoplamiento == "Ambos") ? 2 : 1;
                                // MODIFICADO: Añadido colorOjillo y numHojas
                                var data = {area: area, Cantidad : Cantidad, precioFinal : precioFinal, nombre: nombre, id:id, ancho:Ancho, alto:Alto, CodigoTela : CodigoTela,TipoArticuloDetalle:Tipo,
                                                                 codigo:Codigo, fijacion:Fijacion, acoplamiento : Acoplamiento, tela : tela, color : Color, PrecioTela : PrecioTela, Metraje:Metraje,
                                                                 stiffener:Stiffener, bajoplomo:BajoPlomo, gancho:Gancho, neverlight:Never, CodigoStiffener:CodigoStiffener,PrecioStiffener:PrecioStiffener,
                                                                 tipoarticulo:'cortina', ruta : ruta,  CodigoMo : CodigoMo, PrecioMo : PrecioMo, MetrajeMo:MetrajeMo,
                                                                 telaForro:telaForro, ColorForro:ColorForro, PrecioFinalForro:PrecioFinalForro, PrecioFinalForro : PrecioFinalForro,
                                                                 CodigoTelaForro:CodigoTelaForro,CodigoMoForro:CodigoMoForro, PrecioMoForro : PrecioMoForro, PrecioTelaForro:PrecioTelaForro,
                                                                 MetrajeForro:MetrajeForro, MetrajeMoForro:MetrajeMoForro,
                                                                 CodigoBajoPlomo : CodigoBajoPlomo, PrecioPlomo : PrecioPlomo, MetrajeBajoPlomo : MetrajeBajoPlomo,
                                                                 CodigoArgolla: CodigoArgolla, CantidadArgolla: CantidadArgolla, PrecioArgolla: PrecioArgolla, MetrajeReal: MetrajeReal, MetrajeMOReal: MetrajeMOReal, PrecioReal: PrecioReal, PrecioMoReal: PrecioMoReal, MetrajeRealForro : MetrajeRealForro, MetrajeMORealForro : MetrajeMORealForro, PrecioRealForro : PrecioRealForro, PrecioMoRealForro : PrecioMoRealForro, MetrajeBajoPlomoReal: MetrajeBajoPlomoReal, colorCinta : colorCinta,OrientacionRayaCortina : OrientacionRayaCortina,
                                                                cortinairregular: cortinairregular, hojaizquierda: hojaizquierda, hojaderecha:hojaderecha, colorOjillo: colorOjillo, numHojas: numHojas};
                                if (Sti != "TRUE"){
                                    delete data.stiffener;
                                    delete data.CodigoStiffener;
                                    delete data.PrecioStiffener;
                                }
                                $.post("LlenarCarrito.php", data, function(data2){ });

                                window.location.href = "index.php?opcion=terminar";
                            }
                        }
                    }
                }
            }
        }

        function ColorVariable(){
            $("#Telas option:selected").each(function () {
                elegido=$("#Telas option:selected").html();
                tipo = $(this).val();
                //console.log(tipo);
                var TipoCortina  = $("#nombre").val();
                $('#colores').html('<div><img src="../../assets/img/ajax-loader.gif"/></div>');
                $.post("cotizarvariables.php", { tipo: tipo,elegido:elegido }, function(data){
                    $("#variables").html(data);
                    $("#variables").show();
                });
                $.post("cotizarcolores.php", { elegido: elegido, tipo: tipo, TipoCortina:TipoCortina }, function(data1){
                    $("#colores").fadeIn(1000).html(data1);
                    $("#colores").show();
                });
            });
        }
        function CambiarVariables(){
            //NO ELIMINAR ESTA FUNCION
        }
        function ColorVariableForro(){
            $("#TelasForro option:selected").each(function () {
                elegidoForro = $("#TelasForro option:selected").html();
                tipo = $(this).val();

                $.post("cotizarcoloresforro.php", { elegidoForro: elegidoForro }, function(data1){
                    $("#coloresforro").html(data1);
                    $("#coloresforro").show();
                });
            });
        }
        //NUEVO PARA SABER EL TIPO DE FORRO SELECCIONADO
        function TipoForro(){
            TelaForro=$("#TelasForro option:selected").html();
            TipoTelaForro=$("#TelasForro option:selected").val();
            ColorForro = $("input[name='colorforro']:checked").val();
        
        }
        function CargarValor(submit = false)
        {
            var Argolla = "NO";
            var FactorPlizaje = 2.5;
            var TipoCortina  = $("#nombre").val();
            
            Clave =  "<?php echo $valor; ?>";
            Tela=$("#Telas option:selected").html();
            TipoTela=$("#Telas option:selected").val();
            Color= $("input[name='color']:checked").val();
            Ancho = $("#ancho").val();
            Alto = $("#alto").val();
            Cantidad = $("#cantidad").val();
            TelaForro=$("#TelasForro option:selected").html();
            TipoTelaForro=$("#TelasForro option:selected").val();
            ColorForro = $("input[name='colorforro']:checked").val();
            //NUEVO VARIABLE PARA SABER EL CODIGO DE LA TELA DEL FORRO
            CodigoTelaForro = $("#CodigoTelaForro").val();
            CodigoTela = $("#CodigoTela").val();
            
            //NUEVO PARA CINTA RIPPLEFOLD
            if(Clave == "Ond"){
                $("#cinta").css("display", "inline");
                Cinta = $("#cinta option:selected").val();
            }else{
                Cinta = "";
                $("#cinta").css("display", "none");
            }

            CantidadArgolla = $("#CantidadArgolla").val();
            CodigoArgolla = $("#CodigoArgolla").val();
            PrecioArgolla = $("#PrecioArgolla").val();

            if (["TRANSLUCIDA","FRESCURA"].includes(TipoTela)) {
                $("#forros2").hide();
                } else {
                $("#forros2").show();
                }

            if (!$("#forros2").is(":visible")) {
            ColorForro = "";
            CodigoTelaForro = "";
            PrecioFinalForro = 0;
            $("#PrecioFinalForro").val('0.00');
            $("#PrecioFinalForro2").val('0.00');
            }
            //NUEVO VALIDACION PARA QUE NO SALGA EL FORRO EN LAS TELAS BLACK OUT 
            /*if(TipoTela!="TRANSLUCIDA"){
                $("#forros2").css("display", "inline");
            } else{
                $("#forros2").css("display", "none");
            }*/

            if(TipoTela=="BLACK OUT"){
                $("#div_feston").css("display", "inline");
            } else{
                $("#div_feston").css("display", "none");
            }
            if (TipoCortina=="Ojillos" && Ancho >= 2.3){
                document.getElementById("Ambos").disabled=false;
                document.getElementById("Ambos").checked=true;
                document.getElementById("Derecha").disabled=true;
                document.getElementById("Izquierda").disabled=true;
            }
            else if (!submit)
            {
                // document.getElementById("Ambos").disabled=false;
                // document.getElementById("Ambos").checked=true;
                // document.getElementById("Derecha").disabled=false;
                // document.getElementById("Izquierda").disabled=false;
            }

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
            Bp = BajoPlomoFnc();
            if (Bp == "TRUE"){ 
                BajoPlomo = "SI"; 
            }
            else{ 
                BajoPlomo = "NO"; 
            }

            // MODIFICADO: Se ajusta para manejar radio buttons de color de ojillo
            var colorOjillo = ObtenerColorOjillo();
            var CAFE = "NO";
            if (colorOjillo === "Cafe") {
                CAFE = "SI";
            }
            // Si el color "Natural" tiene un costo o manejo diferente, se debe añadir aquí.
            // Por ahora, asumimos que solo "Cafe" afecta el precio.

            //anchomax = $("#anchomax").val();
            //altomax = $("#altomax").val();
            //VALIDACION DIMENSIONES//
            Acoplamiento= $("input[name='acoplamiento']:checked").val();
            var numHojas = 1;
            if(Acoplamiento == "Ambos"){
            numHojas = 2;
            }
            var medidas = <?php echo $medidasValJson; ?>;
            var anchoHoja = parseFloat(Ancho) / numHojas;
            var aplicanMedidas = false;
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

            $("#cargando").css("display", "inline-block");
            $("#BtnD").css("display", "none");
            if (typeof Color == "undefined" || Color == null ||  Color == ""  ||
                typeof Cantidad == "undefined" || Cantidad == null  ||  Cantidad == ""  ||
                typeof Ancho == "undefined" || Ancho == null || Ancho == "" ||
                typeof Alto == "undefined" || Alto == null || Alto == ""){
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
            else
            {
                //VALIDACION DIMENSIONES//
                x.style.display = "none";
                //VALIDACION DIMENSIONES//
                $.post("cotizarprecio.php",
                {
                    Color : Color, Tela : Tela, TipoTela : TipoTela, Clave : Clave, Ancho : Ancho,
                    Alto : Alto, Stiffener : Stiffener, ForroX : "NO", BajoPlomo:BajoPlomo, CAFE:CAFE, Argolla: Argolla, Cinta:Cinta, numHojas:numHojas
                }, function(data2)
                {
                    $("#precio_total").html(data2);
                    $("#precio").show();
                    $("#cargando").css("display", "none");
                    $("#BtnD").css("display", "inline-block");

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
                    }else{
                        $("#DIVBAJOPLOMO").css("display", "none");
                    }
                    // *************** NUEVO NOTASTOCK
                    $.post("../fnc/comprobacionInsumos2.php",
                    {
                        metraje : $("#Metraje").val(),
                        codigotela : $("#CodigoTela").val(),
                        cantidad : $("#cantidad").val(),
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
                    $.post("validacionTela.php", {
                        tela:$("#Telas option:selected").html(),
                        TipoTela:$("#Telas option:selected").val(),
                        Ancho : $("#ancho").val(),
                        Alto : $("#alto").val(),
                        codigotela : $("#CodigoTela").val(),                
                    }, function(dataInsumo){
                        $("#valTela").html(dataInsumo);
                        $("#valTela").show();
                        $('#valTela2').hide();
                        // TEXTO PARA MOSTRAR EL TIPO DE TELA DE FORRO
                        document.getElementById('nombreTelaForro').hidden = true;
                    });
                    if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
                        PrecioForro =0;
                        if (submit) {
                            prueba();
                        }
                    } else {
                        $.post("cotizarprecioforro.php", {
                            ColorForro : ColorForro, TelaForro : TelaForro, TipoTelaForro : TipoTelaForro, Clave : Clave,
                            Ancho : Ancho, Alto : Alto, Stiffener : "NO", ForroX : "SI", BajoPlomo:BajoPlomo,CAFE:CAFE, Argolla: Argolla, Cinta:Cinta 
                        }, function(data2){
                            $("#precio_forro").html(data2);
                            $("#precioforro").show();
                            if (ColorForro == "undefined" || ColorForro == null ||  ColorForro == "" ){
                                PrecioForro =0;
                            }
                            $("#cargando").css("display", "none");
                            $("#BtnD").css("display", "inline-block");
                            $.post("../fnc/comprobacionInsumosForro.php", {
                                metraje : $("#Metraje").val(),
                                codigotela : $("#CodigoTela").val(),
                                cantidad : $("#cantidad").val(),
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
                            }, function(dataInsumoforro){
                                $("#notastockforro").html(dataInsumoforro);
                                $("#notastockforro").show();
                            });
                            //****************** NUEVO  VALIDACION TELA
                            $.post("validacionTela2.php", {
                                tela:$("#Telas option:selected").html(),
                                TipoTela:$("#Telas option:selected").val(),
                                Ancho : $("#ancho").val(),
                                Alto : $("#alto").val(),
                                codigotela : $("#CodigoTela").val(),
                                ColorForro : $("input[name='colorforro']:checked").val(),              
                            }, function(dataInsumo){
                                $("#valTela2").html(dataInsumo);
                                $("#valTela2").show();
                                $('#valTela').hide();
                                // TEXTO PARA MOSTRAR EL TIPO DE TELA DE FORRO
                                TelaForro=$("#TelasForro option:selected").html();
                                ColorForro = $("input[name='colorforro']:checked").val();
                                document.getElementById('nombreTelaForro').innerHTML='Tela Seleccionada: '+TelaForro+ '-'+ColorForro + '<p class="boton_personalizado2" onclick="test()">Desseleccionar Forro</p>';
                                document.getElementById('nombreTelaForro').hidden = false;
                            });
                            if (submit){
                                prueba();
                            }
                        });
                    }  
                });
            }      
        }
//--------------------------------------------NUEVO VALIDACION PARA DESACTIVAR EL COLOR DEL FORRO --------------------------------------//
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
        function BajoPlomoFnc() {
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
                if($(this).val() == "GANCHO METALICO"){
                    Devolver = 'TRUE';
                }
            });
            return Devolver;
        }
        function NeverlightFunc() {
            var Devolver = 'FALSE';
            $("input[type=checkbox]:checked").each(function(){
                if($(this).val() == "NEVER LIGHT"){
                    Devolver = 'TRUE';
                }
            });
            return Devolver;
        }
        
        // MODIFICADO: La función ahora obtiene el valor del radio button seleccionado
        function ObtenerColorOjillo() {
            return $("input[name='colorOjillo']:checked").val() || "";
        }

        function cintaRippleford(){
            var Delvolver = "FALSE";
            
            $("#cinta option:selected").each(function () {
                elegido=$("#cinta option:selected").html();
                Devolver = 'TRUE';
            });
            return Devolver;
        }
    </script>
    <form  id="cortina" name="cortina">
        <?php
            switch ($valor) {
                case 'pFr':
                    $Nombre = "Plitz Frances"; $valor = 'pFr';
                    $ruta = "../../assets/img/plitz frances.jpg";
                    break;
                case 'pEs':
                    $Nombre = "Plitz Español"; $valor = 'pEs';
                    $ruta = "../../assets/img/plitz espanol.jpg";
                    break;
                case 'pPo':
                    $Nombre = "Plitz Portugues"; $valor = 'pPo';
                    $ruta = "../../assets/img/plitz portuges.jpg";
                    break;
                case 'Pre':
                    $Nombre = "Presillas"; $valor = 'Pre';
                    $ruta = "../../assets/img/presillas.jpg";
                    break;
                case 'Oji':
                    $Nombre = "Ojillos"; $valor = 'Oji';
                    $ruta = "../../assets/img/ojillos.jpg";
                    break;
                case 'Vis':
                    $Nombre = "Visillos"; $valor = 'Vis';
                    $ruta = "../../assets/img/visillos.jpg";
                    break;
                case 'Ond':
                    $Nombre = "Ondulada"; $valor = 'Ond';
                    $ruta = "../../assets/img/ondulada.jpg";
                    break;
                /*case 'Fru':
                    $Nombre = "Cinta Fruncidora"; $valor = 'Fru';
                    $ruta = "../../assets/img/tipocortina/cinta fruncidora.jpg";
                    break;*/
                case 'FrP':
                    $Nombre = "Fruncidora Pasabarras"; $valor = 'FrP';
                    $ruta = "../../assets/img/tipocortina/cinta fruncidora.jpg";
                    break;
                case 'PaT':
                    $Nombre = "Ondulada Pasabarra"; $valor = 'PaT';
                    $ruta = "../../assets/img/tipocortina/ondulada pasabarra.jpg";
                    break;
                default:
                    $valor = '';
                    break;
            }
            ?>
            <input type="hidden"  id="tipo" value="<?php echo $valor; ?>">
            <input type="hidden"  id="nombre" value="<?php echo $Nombre; ?>">
            <input type="hidden"  id="ruta" value="<?php  echo $ruta; ?>">
            <input type="hidden"  id="texto" value="<?php echo $medidasValJson; ?>">
            <div class="container-left">
                <div class="card card-outlined style-default-light">
                    <div class="card-head">
                        <h3><?php echo  $Nombre; ?></h3>
                    </div>
                    <div class="card-body no-padding height-7">
                        <div class="img-backdrop" style="background-image: url('<?php echo $ruta; ?>')"></div>
                    </div>   
                </div>  

            </div>
            <style>
    #infoButtonTrigger {
        background: none;
        border: none;
        padding: 5px;
        cursor: pointer;
        color: inherit;
        transition: opacity 0.2s;
        position: relative;
        display: inline-block;
        opacity: 1 !important; /* Asegura que el botón tenga opacidad total */
        z-index: 100;
    }
    
    #infoButtonTrigger:hover {
        opacity: 0.8;
    }

    /* Tooltip con imagen */
    .info-tooltip {
        display: none;
        position: fixed; /* CAMBIO: fixed en lugar de absolute */
        background-color: #ffffff;
        padding: 15px;
        border-radius: 4px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        z-index: 9999; /* Z-index muy alto */
        white-space: nowrap;
        min-width: 200px;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .info-tooltip.show {
        display: block;
        opacity: 1;
        visibility: visible;
    }

    .info-tooltip-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        opacity: 1;
    }

    .info-tooltip-image {
        max-width: 146px;
        max-height: 212px;
        width: auto;
        height: auto;
        /*border-radius: 4px;*/
        margin-bottom: 12px;
        display: block;
        opacity: 1;
        background: white; /* Fondo blanco para asegurar visibilidad */
    }

    .info-tooltip-text {
        color: #555;
        line-height: 1.5;
        font-size: 13px;
        text-align: center;
        white-space: normal;
        opacity: 1;
    }

    .info-tooltip-text p {
        margin: 0;
    }
</style>

<div class="container-right">
                <div class="container-right-top">
                    <div class="container-right-top-tab">
                        <div class="col-sm-5">
                            <label for="cantidad">Cantidad de cortinas <span class="comentario_label">*Unidad</span></label>
                            <div class="cantidades">
                                <button type="button" id="btn_cantidad_1" onclick="seleccionarNumero('1')" class="btn_cantidad">1</button>
                                <button type="button" id="btn_cantidad_2" onclick="seleccionarNumero('2')" class="btn_cantidad">2</button>
                                <button type="button" id="btn_cantidad_3" onclick="seleccionarNumero('3')" class="btn_cantidad">3</button>
                                <button type="button" id="btn_cantidad_4" onclick="seleccionarNumero('4')" class="btn_cantidad">4</button>
                                <button type="button" id="btn_cantidad_5" onclick="seleccionarNumero('5')" class="btn_cantidad">5+</button>
                                <input type="tel" class="form-control" id="cantidad" min="1" onkeypress="ValidaSoloNumeros()"  onchange="CargarValor()" onkeyup="CargarValor()" required ></div>
                            <label for="autocomplete1">Espacio</label>
                            <input type="text" id="autocomplete1" data-source="../../conexion/data/areas.json" class="" required>
                        </div>
                        <div class="col-sm-3">
                            <label for="cantidad">Ancho (mts)</label>
                            <input type="number" id="ancho" name="ancho" min="1" step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required >
                            <label for="dollars10">Alto (mts)</label>
                            <input type="number" id="alto" name="alto" min="1" step="0.1" onkeypress="return NumCheck(event, this)" onchange="CargarValor()" onkeyup="CargarValor()" required >
                        </div>
                        <div class="col-sm-4">
                            <div id="notastock" class="status">Stock:</div>
                            <div id="notasTela" style="font-weight:bold;"></div>
                        </div>
                    </div>
                    <div class="tab-options">
                        <button class="tablinks active" onclick="openTab(event,'1')" type="button">DATOS GENERALES</button>
                        </div>
                    <div id="tab_1" class="tabcontent tab-bg row" style="display:block;">
                        <div class="col-sm-12"> 
                            <label>SELECCIONA EL TIPO DE TELA</label>
                            <?php
                                //  Descomentar en productivo
                                //$ArregloTipoTela = array();
                                $ArregloTipoTela = TraerTipoTela($valor);
                                $Filas = count($ArregloTipoTela);
                                echo '<select class="form-control" data-placeholder="Select an item" name="Telas" id="Telas">';
                                for( $i=0; $i<$Filas; $i++ ){
                                    if (($ArregloTipoTela[$i]['nombre'] == "DARREN VELVET" && ($valor=="Ond" || $valor=="PaT")) || (($valor=="pEs" or $valor=="pPo") and $ArregloTipoTela[$i]['nombre']=="LUXY")){
                                        
                                    } else {
                                            echo '<option value="'.$ArregloTipoTela[$i]['tipotela'].'"">'. $ArregloTipoTela[$i]['nombre'] .'</option>';  
                                    }
                                }
                                
                                echo "</select>";
                            ?>
                            <div>(<b>*</b>) Sujeto a disponibilidad</div>
                        </div>
                        <div class="col-sm-12"> 
                            <div id="colores"></div>
                            <script type="text/javascript">
                                ColorVariable();
                            </script>
                        </div>
                        <div id = "div_feston" style="display: none;">
                            <p style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;Si Desea evitar filtraciones de luz en costuras de bastilla inferior se recomienda el acabado festón.</p>
                        </div>

                        <div id="div_easywave" style="display: none;">
                            <p style="color: black;">&nbsp;&nbsp;&nbsp;&nbsp;Las
                                telas de red llevarán cintas de red XL 
                                (7cm) de altura.
                                <br> 
                                &nbsp;&nbsp;&nbsp;&nbsp;Más información → 
                                <button id="infoButtonTrigger" style="background: none; border: none; padding: 0; cursor: pointer; color: inherit; position: relative;">
                                    <i class="bi bi-info-circle-fill"></i>
                                    <div id="infoTooltip" class="info-tooltip">
                                        <div class="info-tooltip-content">
                                            <img src="../../assets/img/acce/ImagenLateralEasyWave2.jpg" alt="Cintas de red XL" class="info-tooltip-image">
                                            <div class="info-tooltip-text">
                                                <p>Cintas de red XL (7cm) de altura</p>
                                            </div>
                                        </div>
                                    </div>
                                </button>
                            </p>
                        </div>

                        <div class="col-sm-12"> 
                            <?php
                                $ArregloAccesorio = TraerAccesorio($valor);
                                foreach($ArregloAccesorio as $ValorAccesorio){
                                    if ($ValorAccesorio['nombre'] == 'STIFFENER'){
                                        $Funcion = "onclick='CargarValor()'";
                                        $c = "";
                                        $Oculto = '';
                                    }
                                    else{
                                        $Funcion ="";
                                        $Funcion ="";
                                        // Quite esta opcion de solicitud de Ilu: or $Nombre == "Cinta Fruncidora"
                                        if (($Nombre == "Plitz Portugues") and $ValorAccesorio['nombre'] == "GANCHO METALICO"){
                                            $c = "checked";
                                            //$Oculto = 'style="display:none;"';
                                        } else 
                                            $Oculto = 'style="display:none;"';
                                    }
                                    echo '<div class=""  '.$Oculto.'   data-toggle="tooltip" data-placement="left" title="'.utf8_encode($ValorAccesorio['descripcion']).'">
                                            <label>
                                                <input type="checkbox" value="'.$ValorAccesorio['nombre'].'" '. $Funcion .' '. $c . '>
                                                <span>
                                                    '.$ValorAccesorio['nombre'].'
                                                </span>
                                            </label>
                                        </div>';
                                }
                            ?>
                            <div id="variables"></div><br>
                            <h3>Acoplamiento</h3>
                            <table class="table table-condensed acoplamiento">
                                <tr>
                                    <div class="input-group">
                                        <td>
                                            <label class="radio-inline radio-styled">
                                                <input type="radio" name="acoplamiento"  value="Izquierda" id="Izquierda" onchange="CargarValor()" checked><span>Izquierda 1 hoja </span>
                                                <img src="../../assets/img/opciones/izquierda.png" style=""/>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="radio-inline radio-styled">
                                                <input type="radio" name="acoplamiento"  value="Derecha" id="Derecha" onchange="CargarValor()"><span>Derecha 1 hoja </span>
                                                <img src="../../assets/img/opciones/derecha.png"/>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="radio-inline radio-styled">
                                                <input type="radio" name="acoplamiento" value="Ambos" id="Ambos" onchange="CargarValor()"><span>Ambos 2 hojas</span>
                                                <img src="../../assets/img/opciones/Ambas.png" style=""/>
                                            </label>
                                        </td>
                                    </div>
                                </tr>
                            </table>
                            <div id="cortinaIrregularContainer" style="display: none;">
    <label for="cortinaIrregular">Cortina Ancho Irregular</label>
    
    <input type="checkbox" id="cortinaIrregular" onchange="toggleHojaFields()">
</div>

<div id="hojaFields" style="display: none; margin-top: 10px;">
    <div style="display: inline-block; margin-right: 20px;">
        <label for="hojaIzquierda">Hoja Izquierda (mts)</label>
        <input type="number" id="hojaIzquierda" name="hojaIzquierda" min="0" step="0.1" onchange="validateHojaSize('hojaIzquierda')" >
    </div>

    <div style="display: inline-block;">
        <label for="hojaDerecha">Hoja Derecha (mts)</label>
        <input type="number" id="hojaDerecha" name="hojaDerecha" min="0" step="0.1" onchange="validateHojaSize('hojaDerecha')" >
    </div>
</div>

<div id="errorMessage" style="color: red; display: none;"></div>
                            <h3 style="margin-top: 10px;">Fijación</h3>
                            <table class="table table-condensed fijacion">
                                <tr>
                                    <div class="input-group">
                                        <td>
                                            <label class="radio-inline radio-styled">
                                                <input type="radio" name="fijacion" value="Muro" checked><span>Muro</span>
                                                <img src="../../assets/img/opciones/muro.png" style=""/>
                                            </label>
                                        </td>
                                        
                                        <td>
                                            <label class="radio-inline radio-styled">
                                                <input type="radio" name="fijacion"  value="Techo" checked><span>Techo</span>
                                                <img src="../../assets/img/opciones/techo.png" style=""/>
                                            </label>
                                        </td>
                                    </div>
                                </tr>
                            </table>   
                            <div class="form">
                                <?php           
                                    // MODIFICADO: Cambiado a radio buttons para Café y Natural
                                    if ($valor == 'Oji'){
                                        echo ' <br> ';
                                        echo '<h3>Color de Ojillo</h3>';
                                        echo '<div class="radio radio-styled tile-text" style="display:inline-block; margin-right: 20px;">
                                                <label>
                                                    <input type="radio" name="colorOjillo" value="Cafe" onclick="CargarValor()">
                                                    <span>OJILLO CAFÉ</span>
                                                </label>
                                              </div>';
                                        echo '<div class="radio radio-styled tile-text" style="display:inline-block;">
                                                <label>
                                                    <input type="radio" name="colorOjillo" value="Natural" onclick="CargarValor()">
                                                    <span>OJILLO NATURAL</span>
                                                </label>
                                              </div>';
                                        echo '<div class="radio radio-styled tile-text" style="display:inline-block; margin-left: 20px;">
                                                <label>
                                                    <input type="radio" name="colorOjillo" value="Negro" onclick="CargarValor()">
                                                    <span>OJILLO NEGRO</span>
                                                    </label>
                                              </div>';
                                    }
                                ?>
                            </div>
                            <div id="forros2" class="form">
                                <div class="col-sm-6" style="padding:0px">  
                                    <h3 style="margin-top: 20px;margin-bottom:5px;">Forro</h3>
                                    <div>
                                        <?php
                                            //  Descomentar en productivo
                                            //$ArregloTipoTela = array();
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
                                        ColorVariableForro();
                                    </script>
                                    <div id="notastockforro"></div> 
                                    <div id="coloresforro"></div>
                                    <div id="nombreTelaForro" hidden="false"></div>
                                    <div>(<b>*</b>) Sujeto a disponibilidad</div>
                                </div>
                            </div>

                            <div class="col-sm-6">  
                                <div id="cinta" hidden="false" class="form">
                                    <h3 style="margin-top: 20px;margin-bottom:5px;">Cinta Ripplefold</h3>
                                    <div>
                                        <select class="form-control"  id="cinta" onchange="CargarValor()">                                               
                                            <optgroup label="Cinta Ripplefold:">
                                                <option value="1" id="cinta_blanco">Blanco</option>
                                                <option value="2" id="cinta_transparente">Transparente</option>
                                                <option value="3" id="cinta_negro">Negro</option>
                                                <option value="4" id="cinta_transparente_xl">Transparente XL</option>
                                            </optgroup>
                                        </select>                                         
                                        <label><b>Selecciona una Cinta Ripplefold</b></label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">  
                                <div class="form-group" id = "div_orientacion_vertical" style="display: none;">
                                    <div id="tiras"><h3>Orientación Raya Cortina</h3></div>
                                    <img src="../../assets/img/CRV.png" width="50px" height="50px"/>
                                    Vertical
                                </div>
                                <div class="form-group" id = "div_orientacion_horizontal" style="display: none;">
                                    <div id="tiras"><h3>Orientación Raya Cortina</h3></div>
                                    <img src="../../assets/img/CRH.png" width="50px" height="50px"/>
                                    Horizontal
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id = "div_tamanio" style="display: none;">
                        <p style="color: red;"><b>Cortina supera las medidas permitidas para su confección</b></p>
                    </div>
                </div>
                <div></div> 
                <div></div>
                <br>
            <div class="panel_inferior">
                <div id="precios">
                    <div id="precio_total" class="precio_total">
                        <label class="label_total">Precio Total</label>
                        <label class="label_cantidad">$0.00</label>
                        <input id='PrecioFinal' class='form-control' name='PrecioFinal' value='0.00' style='text-align: right;' type="hidden" readonly>
                    </div>
                    <img src="../../assets/img/iconos/derecha.png" alt="Derecha">
                    <div id="precio_forro" class="precio_total">
                        <label class="label_total">Precio Forro</label>
                        <label class="label_cantidad">$0.00</label>
                        <input id='PrecioFinalForro' name='PrecioFinalForro' class='form-control' value='0.00' style='text-align: right;' type="hidden" readonly>
                    </div>
                </div>
                <div id="cargando" style="display:none; color: green;">Cargando...</div>
                <div id="BtnD" style="display:none;"><button type="button" id="BotonEnviar" onclick="CargarValor(true)">Generar<img src="../../assets/img/iconos/derecha.png" alt="Derecha"></button></div>
            </div>
            </div></form>
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
            </div></div></div><div class="modal fade" id="modalValidacionTamano" tabindex="-1" role="dialog" aria-labelledby="simpleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="simpleModalLabel">Información</h4>
                    </div>
                    <div class="modal-body">
                        <p>Cortina supera las medidas permitidas para la confección.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" value="no" data-dismiss="modal">Cerrar</button>                      
                    </div>
                </div></div></div><script type="text/javascript">
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
            $('#open-image').click(function (e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });
            $('#open-youtube').click(function (e) {
                e.preventDefault();
                $(this).ekkoLightbox();
            });
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
    <script>
        /*Si la tela seleccionada entra dentro de este arreglo se mostrará la opción de cinta ripplefold transparente XL y se ocultarán las otras opciones de cinta ripplefold*/
        cortineroseasy = ['NALU', 'KAIRA', 'SAMARA', 'TALA'];
            $(document).ready(function() {
                $('#Telas').change(function() {
                    var telaSeleccionada = $('#Telas option:selected').html();
                    if (cortineroseasy.includes(telaSeleccionada)) {
                        $('#cinta_blanco').hide();
                        $('#cinta_negro').hide();
                        $('#cinta_transparente').hide();
                        $('#cinta_transparente_xl').prop('selected', true);

                        $('#div_easywave').show();
                    }else{
                        $('#div_easywave').hide();
                        $('#cinta_blanco').show();
                        $('#cinta_negro').show();
                        $('#cinta_transparente').show();
                        $('#cinta_transparente_xl').hide();
                        $('#cinta_blanco').prop('selected', true);
                    }
                });
            });

              $(document).ready(function(){
        var tooltip = $('#infoTooltip');
        var button = $('#infoButtonTrigger');

        button.mouseenter(function(e) {
            // Posicionar el tooltip cerca del botón
            var btnOffset = button.offset();
            var btnWidth = button.width();
            
            tooltip.css({
                'top': (btnOffset.top - 100) + 'px',
                'left': (btnOffset.left + btnWidth + 15) + 'px'
            });
            
            tooltip.addClass('show');
        });

        button.mouseleave(function() {
            tooltip.removeClass('show');
        });

        // Mantener el tooltip visible si el mouse está sobre él
        tooltip.mouseenter(function() {
            tooltip.addClass('show');
        });

        tooltip.mouseleave(function() {
            tooltip.removeClass('show');
        });
    });

    </script>
    <script src="../../assets/js/cotizar.js"></script>
    <script src="../../assets/js/core/source/App.js"></script>
    <script src="../../assets/js/libs/select2/select2.min.js"></script>
    <script src="../../assets/js/libs/typeahead/typeahead.bundle.min.js"></script>
    <script src="../../assets/js/core/demo/Demo.js"></script>
    <script src="../../assets/js/core/demo/DemoFormComponents.js"></script> 
    
