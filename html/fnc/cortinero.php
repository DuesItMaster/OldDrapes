<?php
//if (isset($_GET['debug'])) { echo '<pre>'; print_r(get_defined_vars()); echo '</pre>'; }
	include '../../conexion/wsConsumeDrapes.php';

    if (isset($_POST['color'])){ 
        $colorentrada = $_POST['color'];
        //echo "<br> tipo:". $color;
    }

     if (isset($_POST['tipo'])){ 
        $tipoCortinero = $_POST['tipo'];
        //echo "<br> tipo:". $tipoCortinero;
     } 

     if (isset($_POST['remate'])){ 
        $remate = $_POST['remate'];
        //echo "<br> remate:". $remate;
     }

     if (isset($_POST['soporte'])){ 
        $soporte = $_POST['soporte'];
        //echo "<br> soporte:". $soporte;
     }

     if (isset($_POST['argolla'])){ 
        $argolla = $_POST['argolla'];//no trae
        //echo "<br> argolla:". $argolla; 
     }

     if($tipoCortinero == '125' && $argolla == 'N/A'){
        $argolla = 'NO';
     }

      if (isset($_POST['fijacion'])){ 
        $fijacion = $_POST['fijacion'];
        //echo "<br> fijacion:". $fijacion; 
     }

     if (isset($_POST['ancho'])){ 
        $ancho = $_POST['ancho'];
        //echo "<br> anchocortinero:". $ancho; 
     }

     if (isset($_POST['colorBaston'])){ 
        $colorBaston = $_POST['colorBaston'];
        //echo "<br> colorbaston:". $colorBaston;               
     }

     if (isset($_POST['radioMedida'])){ 
        $medidaBaston = $_POST['radioMedida'];
        //echo "<br> medida baston:". $medidaBaston;             
     }

     if (isset($_POST['radioMaterial'])){ 
        $materialBaston = $_POST['radioMaterial'];
        //echo "<br> material baston:". $materialBaston;             
     }

     if (isset($_POST['baston'])){ 
        $baston = $_POST['baston'];
        //echo "<br> baston:". $baston;             
     }

     if (isset($_POST['valorBaston'])){ 
        $valorBaston = $_POST['valorBaston'];
        //echo "<br> valor baston:". $valorBaston;             
     }

     if (isset($_POST['resultadoSistema'])){ 
        $resultadoSistema = $_POST['resultadoSistema'];
        //echo "<br> resultadoSistema:". $resultadoSistema;
     }

     if (isset($_POST['decorativo'])){ 
        $decorativo = $_POST['decorativo'];
        //echo "<br> decorativo:". $decorativo;             
     }

     if (isset($_POST['peso'])){ 
        $peso = $_POST['peso'];
        //echo "<br> peso:". $peso;      
     }

     if (isset($_POST['resHojas'])){ 
        $resHojas = $_POST['resHojas'];
        //echo "<br> resHojas:". $resHojas;             
     }

    if (isset($_POST['curvoRecto'])){ 
        $curvoRecto = $_POST['curvoRecto'];
     } else {
        $curvoRecto = "RECTO"; // Valor por defecto
     }

    if (isset($_POST['doblar']))
    { 
        $doblar = $_POST['doblar'];

        if ($soporte=="DOBLE")
        {
            $soporte="SENCILLO";
            $aux = "DOBLE";
        }
        else
        {
            $soporte=="SENCILLO";
        }
    }

    if (isset($_POST['controlMotorizado'])){ 
        $controlMotorizado = $_POST['controlMotorizado'];
        //echo "<br> resHojas:". $resHojas;             
     }
     
     if (isset($_POST['controlMotNombre'])){ 
        $controlMotNombre = $_POST['controlMotNombre'];
        //echo "<br> resHojas:". $resHojas;
     }
     
     $cantidadCodos = isset($_POST['cantidadCodos']) ? (int)$_POST['cantidadCodos'] : 0;
     $codoCurveado  = (isset($_POST['codoCurveado']) && $_POST['codoCurveado'] !== '') ? $_POST['codoCurveado'] : 'NO';
     
     //Add codoCurveado variable capture from POST data
     if (isset($_POST['codoCurveado']) and $_POST['codoCurveado'] <> ""){$codoCurveado = $_POST['codoCurveado'];}

     if ($valorBaston == "SI" && $controlMotorizado == "SI")
     {
         $arreglo = CostoCortineroCompleto($tipoCortinero, $remate, $fijacion, $soporte, $resultadoSistema, $decorativo, $argolla, $ancho,
             $colorentrada, $peso, $materialBaston, $medidaBaston, $colorBaston, $controlMotorizado, $controlMotNombre, $codoCurveado);
     }
     elseif ($valorBaston == "SI") {
         $arreglo = CostoCortineroCompleto($tipoCortinero, $remate, $fijacion, $soporte, $resultadoSistema, $decorativo, $argolla, $ancho,
             $colorentrada, $peso, $materialBaston, $medidaBaston, $colorBaston, '', '', $codoCurveado);
     }
     elseif ($controlMotorizado == "SI") {
         $arreglo = CostoCortineroCompleto($tipoCortinero, $remate, $fijacion, $soporte, $resultadoSistema, $decorativo, $argolla, $ancho,
             $colorentrada, $peso, '', '', '', $controlMotorizado, $controlMotNombre, $codoCurveado);
     }
     else
     {
         $arreglo = CostoCortineroCompleto($tipoCortinero, $remate, $fijacion, $soporte, $resultadoSistema, $decorativo, $argolla, $ancho,
             $colorentrada, $peso, '', '', '', '', '', $codoCurveado);
     }

    $foundCortinero = false;
    $foundBaston = false;
    $foundControl = false;
    $SCKS = 0.0;
    $codoUnitario = 0.0;
    $costoCodos = 0.0;
    $codo90Unitario = 0.0;
    $costoCodo90 = 0.0;
    $costoSCKSTotal = 0.0;

    foreach ($arreglo as $row)
    {
        if ($foundCortinero && $row["TipoArticulo"] == "Cortinero")
        {
            $foundCortinero = false;

            echo '<input type="hidden" id="valorCortinero" type="text" value="">';
            echo '<input type="hidden" id="CodigoCortinero" type="text" value="multiCortinero">';

            break;
        }
        elseif ($foundBaston && $row["TipoArticulo"] == "Baston")
        {
            $foundBaston = false;

            echo '<input type="hidden" id="valorBaston" type="text" value="">';
            echo '<input type="hidden" id="codigoBaston" type="text" value="multiBaston">';

            break;
        }
        elseif ($foundControl && ($row["TipoArticulo"] == "SITUO" || $row["TipoArticulo"] == "CONTROL PARED"))
        {
            $foundControl = false;

            echo '<input type="hidden" id="valorControl" type="text" value="">';
            echo '<input type="hidden" id="codigoControl" type="text" value="multiControl">';

            break;
        }
        else
        {
            // Primero procesar SERVICIO-CURV-KS si existe, para tener el valor disponible
            if (!empty($row["codigo"]) && $row["codigo"] == "SERVICIO-CURV-KS")
            {
                $SCKS = $row["CostoUni"];
            }

            // DT-CODO-GLYDEA90° (Glydea con curva de 90°); se compara por prefijo porque el ° puede llegar con otra codificacion
            if (!empty($row["codigo"]) && strpos($row["codigo"], "DT-CODO-GLYDEA90") === 0)
            {
                $codo90Unitario = (float)$row["CostoUni"];
            }

            if ($row["TipoArticulo"] == "Cortinero")
            {
                $foundCortinero = true;

                if ($doblar == "SI" && $aux == "DOBLE")
                {
                    $costoCortinero = $row["CostoUni"] * 2;
                }
                else
                {
                    $costoCortinero = $row["CostoUni"];
                }

                // CURVO (Curvo KS) y PERSONALIZADA (Glydea) cobran el servicio de curveado por metro
                 if ($curvoRecto == "CURVO" || $curvoRecto == "PERSONALIZADA")
                {
                    // Usar el valor SCKS si ya se obtuvo del WS
                    $scksUnitario = 0;
                    if (isset($SCKS) && $SCKS > 0) {
                        $scksUnitario = (float)$SCKS;
                    }
                    
                    // Si no se obtuvo del WS, buscar con Comodin
                    if ($scksUnitario <= 0) {
                        $comodin = Comodin("SERVICIO-CURV-KS");
                        if (is_array($comodin)) {
                            foreach ($comodin as $item) {
                                if (isset($item["codigo"]) && trim($item["codigo"]) === "SERVICIO-CURV-KS" && isset($item["CostoUni"])) {
                                    $scksUnitario = (float)$item["CostoUni"];
                                    break;
                                }
                            }
                        }
                    }
                    
                    // Fallback final: si aún no hay costo, usar valor por defecto
                    if ($scksUnitario <= 0) {
                        $scksUnitario = 194.44; // Valor de respaldo
                    }
                    
                    if ($ancho !== null && $ancho > 0) {
                        // Redondea siempre hacia arriba
                        $cantidadSCKS = ceil((float)$ancho); // 1.1 → 2, 2.1 → 3
                        
                        // Costo total de SCKS
                        $SCKS = $cantidadSCKS * $scksUnitario;
                        // Se guarda aparte porque $SCKS se vuelve a asignar con el unitario si el WS regresa el servicio despues del cortinero
                        $costoSCKSTotal = $SCKS;

                        // Sumar al costo del cortinero
                        $costoCortinero = $costoCortinero + $SCKS;
                        
                        //echo "<br>DEBUG: SCKS unitario: $scksUnitario, cantidad: $cantidadSCKS, total: $SCKS";
                    }
                }

                $codigoCortinero = htmlspecialchars($row["codigo"]);
            }
            elseif ($row["TipoArticulo"] == "Baston") 
            {
                $foundBaston = true;

                if ($soporte == "DOBLE" or $doblar == "SI" and $aux == "DOBLE")
                {
                    if ($resHojas == "Ambos")
                    {
                        $costoBaston = $row['CostoUni'] * 4;
                    }
                    else
                    {
                        $costoBaston = $row['CostoUni'] * 2;
                    }
                }
                else
                {
                    if ($resHojas == "Ambos")
                    {
                        $costoBaston = $row['CostoUni'] * 2;
                    }
                    else
                    {
                        $costoBaston = $row['CostoUni'];
                    }
                }

				$codigoBaston = htmlspecialchars($row["codigo"]);
            }
            elseif ($row["TipoArticulo"] == "SITUO" || $row["TipoArticulo"] == "CONTROL PARED") 
            {
                $foundControl = true;
                $costoControl = $row["CostoUni"];
                $codigoControl = htmlspecialchars($row["codigo"]);
                $nombreControl = $row["nombre"];
            }
            elseif (!empty($row["codigo"]) && $row["codigo"] == "SERVICIO-CURV-KS")
            {
                $SCKS = $row["CostoUni"];
            }
            if (!empty($row["codigo"]) && $row["codigo"] == "SOM-9027549") {
                $codoUnitario = (float)$row["CostoUni"];
            }
        }
    }

    // Glydea con curva de 90°: codo prefabricado por pieza (uno por riel). Se suma despues del ciclo
    // porque el WS puede regresar el codo antes o despues del cortinero
    if ($foundCortinero && $curvoRecto == "CODO90")
    {
        // Fallback: si el WS aún no regresa el codo, usar valor por defecto
        if ($codo90Unitario <= 0) {
            $codo90Unitario = 6714.71; // Valor de respaldo
        }

        $cantidadCodo90 = ($doblar == "SI" && $aux == "DOBLE") ? 2 : 1;
        $costoCodo90 = $cantidadCodo90 * $codo90Unitario;

        $costoCortinero = $costoCortinero + $costoCodo90;
    }

	if ($foundCortinero)
    {
        echo '<input type="hidden" id="valorCortinero" type="text" value="' . $costoCortinero . '">';
        echo '<input type="hidden" id="CodigoCortinero" type="text" value="' . $codigoCortinero . '">';
    }

    if ($foundBaston)
    {
        echo '<input type="hidden" id="valorBaston" type="text" value="' . $costoBaston . '" >';
        echo '<input type="hidden" id="codigoBaston" type="text" value="' . $codigoBaston . '" >';
    }

    if ($foundControl)
    {
        echo '<input type="hidden" id="valorControl" type="text" value="' . $costoControl . '" >';
        echo '<input type="hidden" id="codigoControl" type="text" value="' . $codigoControl . '" >';
        echo '<input type="hidden" id="nombreControl" type="text" value="' . $nombreControl . '" >';
    }
    //prueba para verificar el valor de cantidadCodos
    //$costoCodoUnitario= 100;
    //$costoCodoTotal = $costoCodoUnitario * $cantidadCodos;
    //echo '<input type="hidden" id="costoCodoTotal" type="text" value="' . $costoCodoTotal . '" >';
   // $codoCurveado = isset($_POST['codoCurveado']) ? $_POST['codoCurveado'] : "NO";
    //$costoCodos = ($codoCurveado === "SI") ? ($cantidadCodos * 100) : 0;
    if ($codoCurveado === "SI" && $cantidadCodos > 0) {
        $costoCodos = $cantidadCodos * $codoUnitario;
        echo '<input type="hidden" id="costoCodos" type="text" value="' . $costoCodos . '" >';
        echo '<input type="hidden" id="cantidadCodos" type="text" value="' . $cantidadCodos . '" >';
    }
    
    
	$TotalValor = $costoCortinero + $costoBaston + $costoControl + $costoCodos;
     
    echo "<div class='form-group'>
        <input type='hidden' id='resultadoVacio' type='text' value='" . $costoCortinero . "'>
        <input type='hidden' id='resultadoSuma' type='text' value='" . $TotalValor . "'>
        <input type='hidden' id='PrecioFinal2' class='form-control' name='PrecioFinal2' value='$ " . number_format($TotalValor, 2, '.', ', ') . "' style='text-align: right;' readonly>";
        
    // Agregar debug temporal para verificar los valores calculados
    //if ($curvoRecto == "CURVO") {
      //  echo "<!-- DEBUG: curvoRecto=" . $curvoRecto . ", SCKS=" . (isset($SCKS) ? $SCKS : 'no definido') . ", scksUnitario=" . (isset($scksUnitario) ? $scksUnitario : 'no definido') . ", costoCortinero=" . $costoCortinero . " -->";
    //}
    
    // Agregar campo hidden para el costo SCKS si es curvo
    if (($curvoRecto == "CURVO" || $curvoRecto == "PERSONALIZADA") && $costoSCKSTotal > 0) {
        echo "<input type='hidden' id='costoSCKS' value='" . $costoSCKSTotal . "'>";
        echo "<input type='hidden' id='costoSCKSUnitario' value='" . $scksUnitario . "'>";
    }

    if ($curvoRecto == "CODO90" && $costoCodo90 > 0) {
        echo "<input type='hidden' id='costoCodo90' value='" . $costoCodo90 . "'>";
        echo "<input type='hidden' id='costoCodo90Unitario' value='" . $codo90Unitario . "'>";
    }

    // Articulo de la curva por cortinero, para guardarlo como renglon aparte del kit en la cotizacion
    if (($curvoRecto == "CURVO" || $curvoRecto == "PERSONALIZADA") && $costoSCKSTotal > 0) {
        echo "<input type='hidden' id='codigoCurva' value='SERVICIO-CURV-KS'>";
        echo "<input type='hidden' id='cantidadCurva' value='" . $cantidadSCKS . "'>";
        echo "<input type='hidden' id='precioCurva' value='" . $scksUnitario . "'>";
    }
    elseif ($curvoRecto == "CODO90" && $costoCodo90 > 0) {
        echo "<input type='hidden' id='codigoCurva' value='DT-CODO-GLYDEA90°'>";
        echo "<input type='hidden' id='cantidadCurva' value='" . $cantidadCodo90 . "'>";
        echo "<input type='hidden' id='precioCurva' value='" . $codo90Unitario . "'>";
    }
    
    echo "</div>";
    echo "
    <label class='label_total'>Precio Total</label>
    <label class='label_cantidad'>$".number_format($TotalValor, 2, '.', '')."MXP</label>";