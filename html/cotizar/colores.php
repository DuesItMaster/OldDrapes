<?php 
require_once '../fnc/CortinaFnc.php';
require_once '../../conexion/wsConsumeDrapes.php';
include_once '../clases/Carrito.class.php';


if (isset($_POST['elegido']) and isset($_POST['tipo']) and isset($_POST['TipoCortina']) and isset($_POST['Color']) and isset($_POST['codigotela'])
        and isset($_POST['Clave']) and isset($_POST['Ancho']) and isset($_POST['Alto']) and isset($_POST['Stiffener'])
		and isset($_POST['ForroX']) and isset($_POST['BajoPlomo']) and isset($_POST['CAFE'])
        and isset($_POST['metraje']) and isset($_POST['cantidad']))  {
    
    $Tela = $_POST['elegido'];
    $TipoTela = $_POST['tipo'];
    $TipoCortina = $_POST['TipoCortina'];
    $Color = $_POST['Color'];
    $codigotela = $_POST['codigotela'];
    $Clave = $_POST['Clave'];		
	$Ancho = $_POST['Ancho'];
	$Alto = $_POST['Alto'];
	$Stiffener = $_POST['Stiffener'];
	$ForroX = $_POST['ForroX'];
	$BajoPlomo = $_POST['BajoPlomo'];
	$CAFE = $_POST['CAFE'];
    $metraje = $_POST['metraje'];
    $cantidad = $_POST['cantidad'];
    $codigoArticuloCarrito = (isset($_POST['idCarrito'])) ? $_POST['idCarrito'] : "";
}

?>
<TABLE class="table">
    <?php	
    //------------------------------------ FUNCIONES PARA VALIDACION PARA STOCK DE TELA-------------------------------------------------------------------------
        function ObtenerStockCarrito($codigotela, $articuloCarrito) {
	        $carrito = new Carrito();
	        $carro = $carrito->get_content();
	        $stock=0;
            if($carro) {
		        foreach($carro as $producto){
			        if($producto["CodigoTela"]==$codigotela){
			            if ($producto["id"] != $articuloCarrito){
				            $totalMetraje = $producto["Metraje"] * $producto["cantidad"];
				            $stock = $stock + $totalMetraje;
			            }
			        }
		        }
	        }
	        return $stock;
        }

    //--------FUNCION CAMBIOSTELA -----------
        function cambiosTelas($codigoSAP){
            $telaAumenta = 0;
            $telaDisminuye = 0;
            $cambiosInsumos=[];
            $condicion = " ";
            $pedidosSinEntrega = cambiosTelaEntregadosSAP($codigoSAP);
            if ($pedidosSinEntrega!= " "){ 
                $condicion = " and  ordenVenta in (".$pedidosSinEntrega.")";
            }
            $sql = "SELECT codArticulo, codArticuloCambio, cantidad, ordenVenta 
                    FROM CambioTela WHERE (codArticulo='".$codigoSAP."' OR codArticuloCambio='".$codigoSAP."')  " . $condicion ; 
            $result = mysqli_query($GLOBALS["dbC"], $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    if ($row["codArticulo"] != $row["codArticuloCambio"]){                        
                        if ($row["codArticuloCambio"] == $codigoSAP){
                            $telaDisminuye = $telaDisminuye + $row["cantidad"];
                        }else{
                            $telaAumenta = $telaAumenta + $row["cantidad"];
                        }
                    }
                }
            }
            array_push($cambiosInsumos, array('telaAumenta'=> $telaAumenta,'telaDisminuye'=> $telaDisminuye)); 
            return $cambiosInsumos;
        }
    //--------FUNCION CAMBIOSTELAENTREGADOSSAP ------
        function cambiosTelaEntregadosSAP($codigoSAP){
            $sql = "SELECT codArticulo, codArticuloCambio, cantidad, ordenVenta 
                        FROM CambioTela WHERE codArticulo='".$codigoSAP."' OR codArticuloCambio='".$codigoSAP."'" ;
            $pedidosSAP = array();
            $busqueda = "";
            $PedidosSinEntrega = " ";
            $or = " ";
            $next = " ";
            $result = mysqli_query($GLOBALS["dbC"], $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if ($row["codArticulo"] != $row["codArticuloCambio"]){
                            if ($row["codArticulo"] == $codigoSAP){
                                $busqueda = $busqueda . $or . " (T0.docnum = " . $row["ordenVenta"] . " and " . " T1.itemcode = '" . $row["codArticuloCambio"] ."')";
                            }elseif ($row["codArticuloCambio"] == $codigoSAP ){
                                $busqueda =  $busqueda . $or  . " (T0.docnum = " . $row["ordenVenta"] . " and " . " T1.itemcode = '"  . $row["codArticuloCambio"] ."')";
                            }
                        }
                        $or = " or ";
                    }
                }
                if ($busqueda!= ""){
                    $pedidos = PedidosEntregados($busqueda);
                    if(!empty($pedidos)){
                        foreach ($pedidos as $key => $entregados) {
                            if ($entregados['EstadoEntrega']=="No Entregado"){ 
                                $PedidosSinEntrega = $PedidosSinEntrega . $next . $entregados['Pedido'];
                            }
                            $next = ", ";                   
                        }
                    }
                }
                return $PedidosSinEntrega;
            }

    //--------FUNCION PEDIDOSNOCREADOSSAP ------
            function PedidosNoCreadosSAP($codigotela){
                $next = " ";
                $busqueda = "";
                $nextsap = " ";
                $busquedasap = "";
                $metraje = 0;
                $sql="SELECT cotizacion.ID_COTIZACION, cotizacion_detalle.CODIGOTELA, sum(cotizacion_detalle.cantidad * cotizacion_detalle.METRAJE) as METRAJE
                        FROM cotizacion 
                        INNER JOIN cotizacion_detalle ON cotizacion_detalle.ID_COTIZACION = cotizacion.ID_COTIZACION
                        WHERE cotizacion.ESTATUS=4 and cotizacion.ESTADO=3
                        and YEAR(cotizacion.FECHA_ALTA)>2017
                        AND cotizacion_detalle.CODIGOTELA='".$codigotela."' 
                        group by cotizacion.ID_COTIZACION;";
            
                $result = mysqli_query($GLOBALS["db"], $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {	  
                        $busqueda = $busqueda .$next. "'".$row["ID_COTIZACION"]."'";  	
                        $next = ", ";
                        $resultado = ConsultaFoliosEnPedido($row["ID_COTIZACION"]);
                        if(empty($resultado)) {
                            $busquedasap = $busquedasap .$nextsap. "'".$row["ID_COTIZACION"]."'";  	
                            $nextsap = ", ";
                            $metraje = $metraje + $row["METRAJE"];            
                        }
                    }
                }
                return  $metraje;
            }

            function ObtenerPorcentaje(){
                $Porcentaje = 0;
                $sql="SELECT PORCENTAJEINSUMOS FROM varios LIMIT 1;";
                $result = mysqli_query($GLOBALS["db"], $sql);
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {	  
                        $Porcentaje = $row["PORCENTAJEINSUMOS"];
                    }
                }
                return $Porcentaje;
            }
//---------------------------------------------------------------------------------------------------------------------------------------//


        $mensaje = ($TipoTela == "BLACK OUT" && $TipoCortina == "Ojillos") ? "Esta confección permite filtraciones de luz por lo que no se recomienda utilizar el tipo de tela BLACK OUT. " : "";
        echo $mensaje;

        $ArregloTipoTela1 = TraerColoresTelas2($codigotela,$TipoTela);
       
            

        $Filas = count($ArregloTipoTela1);
        $limiteSustitutos = 4;
        $limiteRevisionCandidatas = 8;

        $inicio = "<tr>";
        $fin = "";
        $contador=0;
        $fila = 0;
        $stockCache = [];
        $cambiosCache = [];
        $stockCarritoCache = [];
        $pedidosNoCreadosCache = [];

        for($i=0; $i<$Filas; $i++ ){
            if($contador >= $limiteSustitutos){
                break;
            }
            if($i >= $limiteRevisionCandidatas){
                break;
            }
            $codigoTelaSustituta = $ArregloTipoTela1[$i]['codigoTela'];
           
//------------------------------------VALIDACION PARA STOCK DE TELA----------------------------------------------------------------------------------------
                   
                if (!isset($stockCache[$codigoTelaSustituta])) {
                    $stockCache[$codigoTelaSustituta] = StockTela($codigoTelaSustituta);
                }
                $stock = $stockCache[$codigoTelaSustituta];

                if (!isset($cambiosCache[$codigoTelaSustituta])) {
                    $cambiosCache[$codigoTelaSustituta] = cambiosTelas($codigoTelaSustituta);
                }
                $cambios = $cambiosCache[$codigoTelaSustituta];
                $stockFinal = $stock[0]['total'] +$cambios[0]['telaAumenta'] - $cambios[0]['telaDisminuye'];
                // ************ Comentar
            	//echo "<br> Stock con intercambio: " . $stockFinal;
	            //echo "<br> Tela Aumenta: " . $cambios[0]['telaAumenta'];
	            //echo "<br>Tela Disminuye: " . $cambios[0]['telaDisminuye']."<br>" ;
	            // ************ Comentar

                if($stockFinal <= 0){
                    continue;
                }

                   // NUEVO PARA SACAR EL PRECIO 
                   $valor = TraerPrecioTela($Clave,$ArregloTipoTela1[$i]['tipoTela'],$Alto,$Ancho,$ArregloTipoTela1[$i]['color'],$ArregloTipoTela1[$i]['nombre'],$Stiffener,$ForroX,$BajoPlomo,$CAFE);
                
                   if ($Alto > 3) {
                       $PrecioFinal = $valor[0]["Precio"] + ($valor[0]['PrecioMo'] * ($valor[0]['MetrajeMo']/2));
                   } else {
                       $PrecioFinal = $valor[0]["Precio"] ;
                   }
                $telaNecesaria =  $valor[0]['Metraje'] * $cantidad;
                $CotizacionGuardada=0;
                // ************ Comentar
	            //echo "Stock en SAP: ";
	           // echo "<br> . $stock[0]['total']"; 
                //echo "<br>Stock de sap: " . $stock[0]['total']. "<br>";
	            //echo "<br>Tela necesaria articulo: " . $telaNecesaria . "<br>";
                //echo "<br>CODIGO Tela: " . $codigoTelaSustituta . "<br>";
	            // ************ Comentar
               
                if (!isset($stockCarritoCache[$codigoTelaSustituta])) {
                    $stockCarritoCache[$codigoTelaSustituta] = ObtenerStockCarrito($codigoTelaSustituta,$codigoArticuloCarrito);
                }
                $telaNecesariaCarrito = $stockCarritoCache[$codigoTelaSustituta];
                // ************ Comentar
	            //echo "<br>Tela necesaria en carrito: " . $telaNecesariaCarrito . "<br>";
	            // ************ Comentar

                $telaNecesariaTotal = ($CotizacionGuardada==0) ? $telaNecesaria + $telaNecesariaCarrito : $telaNecesariaCarrito;
                // ************ Comentar
	            //echo "<br>Tela necesaria total: " . $telaNecesariaTotal . "<br>";
	            // ************ Comentar

                if($stockFinal >= $telaNecesariaTotal){
                    if (!isset($pedidosNoCreadosCache[$codigoTelaSustituta])) {
                        $pedidosNoCreadosCache[$codigoTelaSustituta] = PedidosNoCreadosSAP($codigoTelaSustituta);
                    }
                    $pedidosnocreados = $pedidosNoCreadosCache[$codigoTelaSustituta];
                    $stockFinal = $stockFinal - $pedidosnocreados;

                    if($stockFinal >= $telaNecesariaTotal){
                        //echo "<br> Nombre :" .$ArregloTipoTela1[$i]['nombre'];
                        //echo "<br> color :" .$ArregloTipoTela1[$i]['color'];
                        $fila = ($fila+1);
                        $residuo = $fila%3;
                        if (($fila%3==0) AND ($i!=0)){
                            $fin = "</tr>";
                        }else{
                            $inicio="";
                            $fin = "";
                        }
                        $contador = $contador +1;
                        echo $inicio;
                        $Archivo = "../../assets/img/colores/small/".$ArregloTipoTela1[$i]['nombre']."/".$ArregloTipoTela1[$i]['color'].".jpg";
                        $ArchivoBig = "../../assets/img/colores/big/".$ArregloTipoTela1[$i]['nombre']."/".$ArregloTipoTela1[$i]['color'].".jpg";
                        if (!file_exists($Archivo)) {
                            $Archivo = "../../assets/img/colores/small/".$ArregloTipoTela1[$i]['nombre']."/".$ArregloTipoTela1[$i]['color'].".png";
                      
                            }
        
                        if (!file_exists($ArchivoBig)) {
                            $ArchivoBig = "../../assets/img/colores/big/".$ArregloTipoTela1[$i]['nombre']."/".$ArregloTipoTela1[$i]['color'].".png";
                            }
                   
                        echo '<td>
                                <label class="radio-inline radio-styled">
                                    <input type="radio" name="color" value="'.$ArregloTipoTela1[$i]['nombre'].'" id="'.$ArregloTipoTela1[$i]['color'].'">
                                     <span>'.$ArregloTipoTela1[$i]['nombre'].'  - '.$ArregloTipoTela1[$i]['color'].'<br>$ '.number_format($PrecioFinal, 2, '.', ', ').' </span>
                                    <input type="hidden" name="tipoTela" value ="'.$ArregloTipoTela1[$i]['tipoTela'].'"></input>
                                    <a href="'.$ArchivoBig.'" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
                                        <img src="'.$Archivo.'" style="" width="70%" height="50%"/>
                                    </a>
                                </label>
                            </td>';
                        echo $fin;
                        if (($fila%3==0)) {
                            $inicio = "<tr>";
                            $inicio = "";
                        }else{
                            $inicio="";
                            $fin = "";
                        }
                    }
                }
//---------------------------------------------------------------------------------------------------------------------------------------//
        }//LLAVE DEL FOR
        //echo $contador;
        if($contador == 0){
            echo $inicio;
            echo "<br> SUSTITUTOS SIN TELA NECESARIA PARA LA FABRICACIÓN DE ESTE PEDIDO <br>";
            echo $fin;
        }
    ?>
<!--NUEVO SCRIP PARA SELECCIONAR EL COLOR NUEVO --->
<script>
    $('input[type=radio][name=color]').change(function(){
        //Verificamos que el modal esté abierto
        if($('#ModalSustituto').is(':visible')){
            let tela = $(this).val();
            let color = this.id;
        
            //Aquí seleccionamos el 'select'
            $('#ModalSustituto').modal('hide')
            $("#Telas option:contains(" + tela + ")").attr('selected', 'selected');
            $('#Telas').change();
    
            //debido a que carga los datos una vez el select cambia de valor, generamos un timeout para 
            //que cargue la información y despues seleccionamos el input radio
            /*setTimeout(function(){
                let checkBtn = document.getElementById(color);
                checkBtn.checked = true;    
                checkBtn.onchange();  
            }, 100);*/ //tiempo de 0.1 segundos*/ 
        }
    });
</script>

</TABLE>
	