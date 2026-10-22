<?php
require_once '../../conexion/wsConsumeDrapes.php';
require_once '../../conexion/cnxCostosProduccion.php';


if (isset($_POST['metraje']) and isset($_POST['cantidad']) and isset($_POST['codigotela'])) {
	$metraje = $_POST['metraje'];
	$cantidad = $_POST['cantidad'];
	$codigotela = $_POST['codigotela'];


	$stockfinal = stock($codigotela,$metraje,$cantidad);

	//echo "<b>Mensaje: " . $stockfinal ."</b>";

}


function stock($codigoSAP, $metraje, $cantidad,$CotizacionGuardada=0){

	$stock = StockTela($codigoSAP);
	$telaNecesaria =  $metraje * $cantidad;

	//Comentar
	//echo "Stock de " . $codigoSAP . ": " . $stock[0]['total']." total tela: " . $telaNecesaria . "<br>";
	
	$cambios = cambiosTelas($codigoSAP);
	$stockFinal = $stock[0]['total'] +$cambios[0]['telaAumenta'] - $cambios[0]['telaDisminuye'];
	
	//Comentar
	//echo "<br> Stock con cambios: " . $stockFinal. ". Tela Aumenta: " . $cambios[0]['telaAumenta'] . ". Tela Disminuye: " . $cambios[0]['telaDisminuye'] . " <br> Codigo Tela:" . $codigoSAP ."<br>";

	
	if($stockFinal < $telaNecesaria){ //Revisar parte de porcentaje ****

		$mensaje = fechallegada($codigoSAP,$stockFinal,$telaNecesaria);
	}
	else {

		if ($stockFinal <= 20){
			$mensaje='<div style="color: #bdbd29;">Insumo con stock bajo. Favor de comunicarse con su ejecutiv@ para confirmar stock</div>';
		}else {
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

				return "<div style=\"color: #ff9800;\">Insumo en tránsito: Llegada prevista " . $compra['fecha'] . "</div>";
				// " (total = ".$compra['total'].")" . "(Tela Disminuye = " . $cambios[0]['telaDisminuye'] . ")"  ;
			}
			
		}

	}
	
	return "<div style=\"color: red;\">Insumos insuficientes.</div>";
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





