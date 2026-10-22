<?php
require_once '../../conexion/wsConsumeDrapes.php';
require_once '../../conexion/cnxCostosProduccion.php';
require_once '../../conexion/cnx.php';
include_once '../clases/Carrito.class.php'; 

session_start();
$comprobar_insumos="0";

if (isset($_POST['metraje']) and isset($_POST['cantidad']) and isset($_POST['codigotela']) and isset($_POST['Tela']) 
		and isset($_POST['TipoTela']) and isset($_POST['TipoCortina']) and isset($_POST['Color'])
		and isset($_POST['Clave']) and isset($_POST['Ancho']) and isset($_POST['Alto']) and isset($_POST['Stiffener'])
		and isset($_POST['ForroX']) and isset($_POST['BajoPlomo']) and isset($_POST['CAFE'])) {

	$metraje = $_POST['metraje'];
	$Color = $_POST['Color'];
	$cantidad = $_POST['cantidad'];
	$codigotela = $_POST['codigotela'];
	$Tela = $_POST['Tela'];
	$TipoTela = $_POST['TipoTela'];
	$TipoCortina = $_POST['TipoCortina'];
	$Clave = $_POST['Clave'];
	$Ancho = $_POST['Ancho'];
	$Alto = $_POST['Alto'];
	$Stiffener = $_POST['Stiffener'];
	$ForroX = $_POST['ForroX'];
	$BajoPlomo = $_POST['BajoPlomo'];
	$CAFE = $_POST['CAFE'];
	//echo $codigotela;
	$codigoArticuloCarrito = (isset($_POST['idCarrito'])) ? $_POST['idCarrito'] : "";

	//echo "codigo carrito: " . $codigoArticuloCarrito;

	$stockfinal = stock($codigotela,$metraje,$cantidad, 0,$codigoArticuloCarrito);
	echo "<b>Stock: " . $stockfinal ."</b>";
}

function stock($codigoSAP, $metraje, $cantidad,$CotizacionGuardada=1,$articuloCarrito = ""){
	$stock = StockTela($codigoSAP);
	$telaNecesaria =  $metraje * $cantidad;

	/************ Comentar ************ Comentar*/
	echo "Stock en SAP: ";
	echo "<br>".$codigoSAP . ": " . $stock[0]['total']; 
	echo "<br>Stock de sap: " . $stock[0]['total']. "<br>";
	echo "<br>Tela necesaria articulo: " . $telaNecesaria . "<br>";
	echo "<br>CODIGO Tela: " . $codigoSAP. "<br>";
	echo "<br>Metraje: " . $metraje. "<br>";
	echo "<br>cantidad: " . $cantidad. "<br>";
	

	$telaNecesariaCarrito = ObtenerStockCarrito($codigoSAP,$articuloCarrito);

	/************ Comentar 	************ */
	echo "<br>Tela necesaria en carrito: " . $telaNecesariaCarrito . "<br>";
	/*Comentar*/

	$telaNecesariaTotal = ($CotizacionGuardada==0) ? $telaNecesaria + $telaNecesariaCarrito : $telaNecesariaCarrito;

	/************ Comentar	************ */
	//echo "<br>Tela necesaria total: " . $telaNecesariaTotal . "<br>";
	/*Comentar*/
	
	$cambios = cambiosTelas($codigoSAP);
	$stockFinal = $stock[0]['total'] +$cambios[0]['telaAumenta'] - $cambios[0]['telaDisminuye'];
	
	/************ Comentar	*************/
	//echo "<br> Stock con intercambio: " . $stockFinal;
	//echo "<br> Tela Aumenta: " . $cambios[0]['telaAumenta']; 
	//echo "<br>Tela Disminuye: " . $cambios[0]['telaDisminuye']."<br>" ;/**/

	$pedidosnocreados = PedidosNoCreadosSAP($codigoSAP);
	$oculto="";
	if($_SESSION['dues']=='1')
	$oculto="<p type='hidden'>Stock en SAP: ".$stock[0]['total']."m<br>Pendientes en Drapes: ".$pedidosnocreados."m</p>";
	$stockFinal = $stockFinal - $pedidosnocreados;
	/*Comentar*/
	echo "<br> Stock final restando pedidos autorizados No en SAP: " . $stockFinal."<br>";
	/**/

	if($stockFinal < $telaNecesariaTotal){ //Revisar parte de porcentaje ****

		$mensaje = fechallegada($codigoSAP,$stockFinal,$telaNecesariaTotal);
	}
	else {

		$porcentajepermitido = ObtenerPorcentaje();
		$calculoPorcentaje = ROUND(($telaNecesariaTotal * 100) / $stockFinal,0);

		/*Comentar */
		//echo "<br>Porcentaje Permitido: " . $porcentajepermitido . " Porcentaje actual: " . $calculoPorcentaje . "<br>";
		/*Comentar*/

		if ($calculoPorcentaje >= $porcentajepermitido ){
			$mensaje = '<div style="color: #bdbd29;">Esta cotizacion requiere del '.$calculoPorcentaje.'% del metraje disponible</div>';
		}
		else{
			$mensaje='<div style="color: green;">Insumos en stock</div>';	
		}		
	}
	return $mensaje;
}

function fechallegada($codigoSAP, $stock ,$telaNecesaria){

	$compras = Compras($codigoSAP);
	$telaFaltante = $telaNecesaria - $stock;
	
	if(!empty($compras)){

		//$cambios = cambiosTelas($codigoSAP);
		$telaCompra = 0; //$cambios[0]['telaAumenta'] - $cambios[0]['telaDisminuye']; // 0;

		foreach ($compras as $key => $compra) {

			$telaCompra = $telaCompra + $compra['total'];
			if ($telaFaltante <= $telaCompra){

				return "<div style=\"color: #ff9800;\">Insumo en tránsito: Llegada prevista " . $compra['fecha'] . "<br><a data-toggle='modal' data-target='#ModalSustituto' style=\"color: #3a3939; cursor:pointer; font-size:13px;\" >Ver Sustitutos Recomendados <span class='fa fa-plus-square-o'></span></a></div>";
				// " (total = ".$compra['total'].")" . "(Tela Disminuye = " . $cambios[0]['telaDisminuye'] . ")"  ;
			}	
		}
	}
	return "<div style=\"color: red;\">Insumos insuficientes.<br> <a data-toggle='modal' data-target='#ModalSustituto' style=\"color: #3a3939; cursor:pointer; font-size:13px;\" >Ver Sustitutos Recomendados <span class='fa fa-plus-square-o'></span></a></div>";
}

function cambiosTelas($codigoSAP){
	$telaAumenta = 0;
	$telaDisminuye = 0;
	$cambiosInsumos=[];
	$condicion = " ";

	$pedidosSinEntrega = cambiosTelaEntregadosSAP($codigoSAP);
	//echo "Consulta SAP: " . $pedidosSinEntrega ;
	if ($pedidosSinEntrega!= " "){ 
		$condicion = " and  ordenVenta in (".$pedidosSinEntrega.")";
	}

	$sql = "SELECT codArticulo, codArticuloCambio, cantidad, ordenVenta 
			FROM CambioTela WHERE (codArticulo='".$codigoSAP."' OR codArticuloCambio='".$codigoSAP."')  " . $condicion ; 

	//echo " CONSULTA: " . $sql;

	$result = mysqli_query($GLOBALS["dbC"], $sql);
	
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			//$telaDisminuye = $telaDisminuye + $row["cantidad"];
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
						//array_push($pedidosSAP, array('Pedido'=>$entregados['Pedido'],
													//'CodigoSAP'=>$entregados['CodigoSAP']));
					}
					$next = ", ";	
				}
				//echo "<pre>";
				//print_r($pedidosSAP);
				//echo "</pre>";
			}
		}
	return $PedidosSinEntrega;
}

function PedidosNoCreadosSAP($codigotela){

    $metraje = 0.0;
    $noEnSAP = []; // 🔹 guardará los folios que no tienen pedido SAP

    $sql = "
        SELECT 
            c.ID_COTIZACION, 
            d.CODIGOTELA, 
            SUM(d.cantidad * d.METRAJE) AS METRAJE
        FROM cotizacion AS c
        INNER JOIN cotizacion_detalle AS d 
            ON d.ID_COTIZACION = c.ID_COTIZACION
        WHERE
            c.ESTATUS = 4 
            AND c.ESTADO = 3
            AND c.FECHA_ALTA >= DATE_SUB(CURDATE(), INTERVAL 1 YEAR)
            AND d.CODIGOTELA = '".$codigotela."'
        GROUP BY
            c.ID_COTIZACION, d.CODIGOTELA
    ";

    $result = mysqli_query($GLOBALS["db"], $sql);

    if ($result && mysqli_num_rows($result) > 0) {

        while ($row = mysqli_fetch_assoc($result)) {

            $folio = $row["ID_COTIZACION"];

            // Consulta si existe en SAP
            $existeEnSAP = ConsultaFoliosEnPedido($folio);

            // Solo sumamos metraje si NO hay pedido en SAP
            if (!$existeEnSAP) {
                $metraje += (float)$row["METRAJE"];
                $noEnSAP[] = $folio; // 🔹 Guardamos el folio
            }
        }
    }

    // 🔹 Mostrar los pedidos que no están en SAP
    if (!empty($noEnSAP)) {
        echo "<br><b>Pedidos no encontrados en SAP:</b> " . implode(', ', $noEnSAP) . "<br>";
    } else {
        echo "<br><b>Todos los pedidos están en SAP.</b><br>";
    }

    return $metraje;
}


function ObtenerStockCarrito($codigotela, $articuloCarrito) {
	$carrito = new Carrito();
	$carro = $carrito->get_content();
	$stock=0;

	if($carro) {
		foreach($carro as $producto){
			//echo "carrito: " . $producto["CodigoTela"] . " " . $producto["id"];
			if($producto["CodigoTela"]==$codigotela){
				//echo "carrito: " . $producto["id"] . " articulo carrito: " .  $articuloCarrito;
				if ($producto["id"] != $articuloCarrito){
					$totalMetraje = $producto["Metraje"] * $producto["cantidad"];
					$stock = $stock + $totalMetraje;
				}
			}
		}
	}
	//echo "<br> Metraje en Carrito: " . $stock;
	return $stock;
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
?>
<!-- NUEVO -->
<script language="javascript">
	console.log("\nComprobación Insumos 2");
	elegido =  "<?php echo $Tela;?>";
	console.log("Tela= "+elegido);
	tipo = <?= json_encode($TipoTela) ?>;
	console.log("TipoTela= "+tipo);
	TipoCortina = <?= json_encode($TipoCortina) ?>;
	console.log("TipoCortina= "+TipoCortina);
	Color = <?= json_encode($Color) ?>;
	console.log("Color= "+Color);
	codigotela =<?= json_encode($codigotela) ?>;
	console.log("codigotela= "+codigotela);
	Clave = <?= json_encode($Clave) ?>;	
	console.log("Clave= "+Clave);
	Ancho = <?= json_encode($Ancho) ?>;
	console.log("Ancho= "+Ancho);
	Alto = <?= json_encode($Alto) ?>;
	console.log("Alto= "+Alto);
	Stiffener = <?= json_encode($Stiffener) ?>;
	console.log("Stiffener= "+Stiffener);
	ForroX = <?= json_encode($ForroX) ?>;
	console.log("ForroX= "+ForroX);
	BajoPlomo = <?= json_encode($BajoPlomo) ?>;
	console.log("BajoPlomo= "+BajoPlomo);
	CAFE = <?= json_encode($CAFE) ?>;
	console.log("OjilloCafe= "+CAFE);
	metraje = <?= json_encode($metraje) ?>;
	console.log("metraje= "+metraje);
	stockFinal = "<?php echo $comprobar_insumos; ?>";
	console.log("stockFinal= "+stockFinal);
	cantidad = <?= json_encode($cantidad) ?>;
	console.log("cantidad= "+cantidad);
	codigoArticuloCarrito = <?= json_encode($codigoArticuloCarrito) ?>;
	console.log("codigoArticuloCarrito= "+codigoArticuloCarrito);
	function colores(){
		$('#ModalSustituto').on('show.bs.modal', function (e) {
			$("#colores2").html("");
			$("#loader").show();
			$.post("../cotizar/colores.php", 
			{
				elegido: elegido,
				tipo : tipo,
				TipoCortina: TipoCortina,
				Color: Color,
				codigotela: codigotela,
				Clave: Clave,
				Ancho: Ancho,
				Alto: Alto,
				Stiffener: Stiffener,
				ForroX: ForroX,
				BajoPlomo: BajoPlomo,
				CAFE: CAFE,
				metraje:metraje,
				cantidad: cantidad,
				codigoArticuloCarrito: codigoArticuloCarrito
			}, function(dataInsumo)
			{
				$("#colores2").html(dataInsumo);
				$("#colores2").show();
				$("#loader").hide();
			});
		})
	}		
</script>

<!-- Modal  aqui esta el modal -->
<div class="modal fade" id="ModalSustituto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" >
  	<div class="modal-dialog" role="document" >
    <div class="modal-content" >
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="exampleModalLabel"> TELAS SUSTITUTOS</h4>	
				<H4> Buscando sustitutos por favor espere...</H4>
            </div>
            <div class="modal-body">
			<script language="javascript">
				colores();
			</script>
			
            <div id="colores2"></div>
			<div id="loader" >
				<img src="../../assets/img/ajax-loader.gif"  style="margin-top:10px;  margin-left:250px;">
			</div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>