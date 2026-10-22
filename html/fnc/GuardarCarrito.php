<?php

include_once '../clases/Carrito.class.php';  
require_once '../fnc/terminarIva.php';
require_once '../fnc/terminarDescuento.php';
include_once '../../conexion/ins.php';
include_once '../../conexion/cnx.php';  

if (isset($_POST['idcomo'])){
	$idcomo=$_POST['idcomo'];
}

$nowFormat = date('Y-m-d H:i:s');

//Ultimo numero de kit
function TraerNumKit(){
	$numKit = Array();
	$sql = "SELECT MAX(numKit) AS numKit FROM Cotizacion_Det";
		
	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	    	array_push($numKit, $row["numKit"]);    
	    }
	} 
	return $numKit;
}

$numKitArray = TraerNumKit();
$numKit;
foreach ($numKitArray as $i => $value) {	
	if($numKitArray[$i] <> ""){
		$numKit = $numKitArray[$i];
	}
	else 
	{
		$numKit = 0;
	}
}

if (isset($_POST['NuevoCliente'])){
	
	if ($_POST['NuevoCliente']=="SI"){

		$cliente=$_POST['cliente'];
		$calle= $_POST['calle'];
		$numero = $_POST['numero']; 
		$colonia = $_POST['colonia'];
		$localidad = $_POST['localidad'];
		$estado = $_POST['estado'];
		$atencion = $_POST['atencion'];
		$hora = $_POST['hora']; 
		$ciudad = $_POST['ciudad'];
		$telefono = $_POST['telefono'];
		$cp = $_POST['cp'];
		$contacto = $_POST['contacto']; 
		$sucursal =$_POST['sucursal']; 
		$referencias = $_POST['referencias']; 
		$email = $_POST['email'];


		$idCliente = insert('cliente',array('NOMBRE'=>$cliente,
											'CALLE'=>$calle,
											'NUMERO' => $numero,
											'COLONIA'=>$colonia,
							  				'LOCALIDAD'=>$localidad, 
							  				'ESTADO' => $estado,
							  				'MUNICIPIO' => $ciudad,
							  				'TELEFONO'=> $telefono,
											'REFERENCIAS' => $referencias,
											'ATENCION'=>$atencion,
							  				'CONTACTO'=>$contacto, 
							  				'SUCURSAL' => $sucursal,
							  				'ID_USUARIO_ALTA' => $_SESSION['login_user'],
							  				'EMAIL'=>$email,
							  				'CP'=>$cp
								  			), 
										array( '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

	} else{

		$idCliente=$_POST['idCliente'];
	}
}

if (isset($_POST['AgregarDireccion'])) {
	
	if ($_POST['AgregarDireccion']=="SI"){
		// DIRECCION NUEVA
		//echo "Agregar direccion de inputs nueva direccion";
		if(isset($_POST['n_nombre']) and ($_POST['n_nombre']<>"")){$n_nombre = $_POST['n_nombre'];}else{$n_nombre="";}
		if(isset($_POST['n_calle']) and ($_POST['n_calle']<>"")){$n_calle = $_POST['n_calle'];}else{$n_calle="";}
		if(isset($_POST['n_numero']) and ($_POST['n_numero']<>"")){$n_numero = $_POST['n_numero'];}else{$n_numero="";}
		if(isset($_POST['n_colonia']) and ($_POST['n_colonia']<>"")){$n_colonia = $_POST['n_colonia'];}else{$n_colonia="";}
		if(isset($_POST['n_localidad']) and ($_POST['n_localidad']<>"")){$n_localidad = $_POST['n_localidad'];}else{$n_localidad="";}
		if(isset($_POST['n_estado']) and ($_POST['n_estado']<>"")){$n_estado = $_POST['n_estado'];}else{$n_estado="";}
		if(isset($_POST['n_municipio']) and ($_POST['n_municipio']<>"")){$n_municipio = $_POST['n_municipio'];}else{$n_municipio="";}
		if(isset($_POST['n_telefono']) and ($_POST['n_telefono']<>"")){$n_telefono = $_POST['n_telefono'];}else{$n_telefono="";}
		if(isset($_POST['n_referencias']) and ($_POST['n_referencias']<>"")){$n_referencias = $_POST['n_referencias'];}else{$n_referencias="";}
		if(isset($_POST['n_atencion']) and ($_POST['n_atencion']<>"")){$n_atencion = $_POST['n_atencion'];}else{$n_atencion="";}
		if(isset($_POST['n_hora']) and ($_POST['n_hora']<>"")){$n_hora = $_POST['n_hora'];}else{$n_hora="";}
		if(isset($_POST['n_ciudad']) and ($_POST['n_ciudad']<>"")){$n_ciudad = $_POST['n_ciudad'];}else{$n_ciudad="";}
		if(isset($_POST['n_contacto']) and ($_POST['n_contacto']<>"")){$n_contacto = $_POST['n_contacto'];}else{$n_contacto="";}
		if(isset($_POST['n_sucursal']) and ($_POST['n_sucursal']<>"")){$n_sucursal = $_POST['n_sucursal'];}else{$n_sucursal="";}
		if(isset($_POST['n_cp']) and ($_POST['n_cp']<>"")){$n_cp = $_POST['n_cp'];}else{$n_cp="";}


		$IDDireccion = insert('usuario_direccion',array('ID_USUARIO'=>$_SESSION['login_user'],
														'NOMBRE_DOMICILIO'=>$n_nombre,
														'CALLE'=>$n_calle,
														'NUMERO' => $n_numero,
														'COLONIA'=>$n_colonia,
										  				'LOCALIDAD'=>$n_localidad, 
										  				'ESTADO' => $n_estado,
										  				'MUNICIPIO' => $n_municipio,
										  				'TELEFONO'=> $n_telefono,
														'REFERENCIAS' => $n_referencias,
														'ATENCION'=>$n_atencion,
										  				'CONTACTO'=>$n_contacto, 
										  				'SUCURSAL' => $n_sucursal,
										  				'HORA' => $n_hora,
										  				'CIUDAD'=>$n_ciudad,
										  				'CP'=>$n_cp
											  			), 
													array( '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

	} elseif($_POST['DireccionCliente']=="SI") {
		
		if ($_POST['NuevoCliente']=="SI"){
			//DIRECCION DEL CLIENTE GUARDADO EN INPUTS
			//echo "Agregar direccion de inputs nuevo cliente";
			$n_calle = $calle;
			$n_numero = $numero;
			$n_colonia = $colonia;
			$n_localidad = $localidad;
			$n_estado = $estado;
			//$n_municipio = $_POST['n_municipio'];
			$n_telefono = $telefono; 
			$n_referencias = $referencias; 
			$n_atencion = $atencion;
			$n_hora = $hora;
			$n_ciudad = $ciudad;
			$n_contacto = $contacto;
			$n_sucursal =$sucursal;
			$n_cp =$cp; 
		
		} else{
			//DIRECCION DEL CLIENTE YA GUARDADO
			$idCliente=$_POST['idCliente'];
			$sql = "select CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,MUNICIPIO,
					TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,EMAIL,CP  
					from cliente where id_cliente =".$idCliente." and ID_USUARIO_ALTA=".$_SESSION['login_user'].";";

			//echo "Consulta cliente ya guardado: " . $sql;
			$result = mysqli_query($GLOBALS['db'], $sql);

			if (mysqli_num_rows($result) > 0) {
			    while($row = mysqli_fetch_assoc($result)) {
			    	$n_calle = $row["CALLE"];
					$n_numero = $row["NUMERO"];
					$n_colonia = $row["COLONIA"];
					$n_localidad = $row["LOCALIDAD"];
					$n_estado = $row["ESTADO"];
					$n_municipio = $_POST['MUNICIPIO'];
					$n_telefono = $row["TELEFONO"]; 
					$n_referencias = $row["REFERENCIAS"]; 
					$n_atencion = $row["ATENCION"];
					//$n_hora = $row[""];
					//$n_ciudad = $row[""];
					$n_contacto = $row["CONTACTO"];
					$n_sucursal =$row["SUCURSAL"];
					$n_cp =$row["CP"]; 
			    }
			} 

		}

	} else{

		//DIRECCION DEL DISTRIBUIDOR
		$sql = "select CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,CIUDAD,
				TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,/*EMAIL,*/CP,HORA  
				from usuario_direccion where ID_USUARIO =".$_SESSION['login_user']." AND ID =".$idcomo.";";
	
		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {
		    while($row = mysqli_fetch_assoc($result)) {
		    	$n_calle = $row["CALLE"];
				$n_numero = $row["NUMERO"];
				$n_colonia = $row["COLONIA"];
				$n_localidad = $row["LOCALIDAD"];
				$n_estado = $row["ESTADO"];
				$n_municipio = $_POST['MUNICIPIO'];
				$n_telefono = $row["TELEFONO"]; 
				$n_referencias = $row["REFERENCIAS"]; 
				$n_atencion = $row["ATENCION"];
				$n_hora = $row["HORA"];
				$n_ciudad = $row["CIUDAD"];
				$n_contacto = $row["CONTACTO"];
				$n_sucursal =$row["SUCURSAL"];
				$n_cp =$row["CP"]; 
		    }
		} 
	}
}

/* Direccion Final */
$DireccionFinal = $n_calle . " " .  $n_numero . " " . $n_colonia ." ". $n_localidad . ", " . $n_estado;

/* Instanciar Carrito */
$carrito = new Carrito();
$carro = $carrito->get_content();

if($carro) {

	$iva = TraerIva();

	$PorcentajeDescuento =  GenerarPorcentaje();
	$SubtotalDescCortinero = SacarTotalesCortineroMotorizado();

	$IvaTotal = ($Subtotal * ($iva/100));
	$Total =  $Subtotal + $IvaTotal;

	$IvaTotalCortinero = ($SubtotalDescCortinero * ($iva/100));
	$TotalCortinero =  $SubtotalDescCortinero + $IvaTotalCortinero;


	$IdCotizacion = insert('Cotizacion_Gen',array('NombreCte'=>$_SESSION['nombre_user'],
												  'CodigoCte'=>$_SESSION['sap'],
												  'Total' => $SubtotalDescCortinero,
												  'DirEntrega'=> $DireccionFinal,
												  'Atenciona'=> $n_atencion,
												  'Telefonos'=> $n_telefono,
												  'ImpDescto'=>'0',
								  				  'Subtotal'=>$SubtotalDescCortinero, 
								  				  'iva' => $IvaTotalCortinero,
								  				  'Descuento' => '0',
								  				  'ImpTotal' => $TotalCortinero,
								  				  'FecCotizacion'=>$nowFormat), 
											array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

	//INSERTA EN COTIZACION LOS DATOS DEL ENVIO FINAL
	$DescuentoAplicado = $carrito->precio_total() - $SubtotalDescCortinero;
	$DescuentoAplicadoReal = $carrito->precio_total_real() - $SubtotalDescCortinero;

	$IdCotizacionM = insert('cotizacion',array('ID_CLIENTE'=>$idCliente,'ID_USUARIO_ALTA'=>$_SESSION['login_user'],'SUBTOTAL' => $SubtotalDescCortinero,'IVA'=>$IvaTotalCortinero,
												'IMPORTEUNITARIO'=> $carrito->precio_total(),
												'DESCUENTO'=>$DescuentoAplicado,'TOTAL'=>$TotalCortinero, 'ESTATUS' => "1",'FolioCotizacion'=>$IdCotizacion,'CALLE'=>$n_calle,
												'NUMERO'=>$n_numero,'LOCALIDAD'=>$n_localidad,'TELEFONO'=>$n_telefono,'REFERENCIAS'=>$n_referencias,'ATENCION'=>$n_atencion,
												'CONTACTO'=>$n_contacto,'SUCURSAL'=>$n_sucursal,'COLONIA'=>$n_colonia, 'CP'=>$n_cp,'ESTADOD'=>$n_estado,'HORA'=>$n_hora,
												'CIUDAD'=>$n_ciudad, 'MUNICIPIO'=>$n_ciudad,'FECHA_ALTA'=>$nowFormat, 'SUBTOTAL_REAL'=>$carrito->precio_total_real(), 'DESCUENTO_REAL'=>$DescuentoAplicadoReal), 
										array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));											
	
	foreach($carro as $producto){

		/* ************************************************************************* CORTINA ************************************************************************* */
		if ($producto["tipoarticulo"]=="cortina"){
			$numKit = $numKit + 1;
			//Cortina General Descuento
			$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			$Nombre = strtoupper ("" . utf8_decode($producto["nombre"]) . " tela: " . $producto["tela"] . " color: " . $producto["color"] . " med: " . $producto["ancho"] . " x " . $producto["alto"]);
			$importe = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $Nombre ,
										  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

		
									
			//Tela
			$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
			$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];

			$ImporteRealTela = $PrecioTotalTela;
			$MetrajeReal = $TotalMetraje;
			$PorcentajeDescuentoVAR = $PorcentajeDescuento;

			/*if(isset($producto["PrecioReal"]) && $producto["PrecioReal"] <> ""){
				//$ImporteRealTela =  $producto["PrecioReal"];
				$ImporteRealTela = $producto["PrecioReal"] * $producto["cantidad"];
				//$MetrajeReal = $producto["MetrajeReal"];

				$MetrajeReal = number_format($producto["MetrajeReal"] * $producto["cantidad"], 2, '.', '');

				$CalculoDescMetraje = $PrecioTotalTela - $ImporteRealTela;
				if($CalculoDescMetraje > 0){
					$DescuentoAplicadoAProducto = GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]);

					$DescuentosTotales = $DescuentoAplicadoAProducto - $CalculoDescMetraje;
					$PorcentajeDescuentoVAR = ($DescuentosTotales * 100) / $ImporteRealTela;	
				}
			}*/

			$PrecioTotalTelaFinal = ($ImporteRealTela - GenerarCantidadFinal($PorcentajeDescuentoVAR,$ImporteRealTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $MetrajeReal, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuentoVAR,'importe'=> $PrecioTotalTelaFinal, 'numKit' => $numKit), 
			array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));




			//Mano Obra
			$PrecioTotalMo = ($producto["MetrajeMo"]* $producto["cantidad"]) *$producto["PrecioMo"];
			$TotalMo = $producto["MetrajeMo"] *  $producto["cantidad"];

			$ImporteRealMO = $PrecioTotalMo;
			$MetrajeRealMO = $TotalMo;
			$PorcentajeDescuentoVAR = $PorcentajeDescuento;

			/*if(isset($producto["PrecioMoReal"]) && $producto["PrecioMoReal"] <> ""){
				//$ImporteRealMO = $producto["PrecioMoReal"];
				//$MetrajeRealMO = $producto["MetrajeMOReal"];

				$ImporteRealMO = $producto["PrecioMoReal"] * $producto["cantidad"];
				$MetrajeRealMO = $producto["MetrajeMOReal"] * $producto["cantidad"];

				$CalculoDescMO = $PrecioTotalMo - $ImporteRealMO;
				if($CalculoDescMO > 0){
					$DescuentoAplicadoAProducto = GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]);

					$DescuentosTotales = $DescuentoAplicadoAProducto - $CalculoDescMO;
					$PorcentajeDescuentoVAR = ($DescuentosTotales * 100) / $ImporteRealMO;	
				}
			}*/

			$PrecioFinalMo = ($ImporteRealMO - GenerarCantidadFinal($PorcentajeDescuentoVAR,$ImporteRealMO,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $MetrajeRealMO, 'Codigo'=> $producto["CodigoMo"], 'Descripcion' => 'Mano de Obra', 'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuentoVAR,'importe'=> $PrecioFinalMo, 'numKit' => $numKit), 
			array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

			if ($producto["alto"]>3) 
			{
				$PrecioTotalMo = ($producto["MetrajeMo"]* ($producto["cantidad"]/2)) * $producto["PrecioMo"];	
				$TotalMo = $producto["MetrajeMo"] *  ($producto["cantidad"]/2);

				$ImporteRealMO = $PrecioTotalMo;
				$MetrajeRealMO = $TotalMo;
				$PorcentajeDescuentoVAR = $PorcentajeDescuento;

				$PrecioFinalMo = ($ImporteRealMO - GenerarCantidadFinal($PorcentajeDescuentoVAR,$ImporteRealMO,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
						
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $MetrajeRealMO, 'Codigo'=> $producto["CodigoMo"], 'Descripcion' => 'Mano de Obra', 'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuentoVAR,'importe'=> $PrecioFinalMo, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));	
			}

			// NUEVO: Cargo extra por Ancho >= 5m en 1 hoja
			// Recuperamos numHojas del objeto si existe, o lo deducimos
			$numHojas = (isset($producto["cantidadHojas"])) ? $producto["cantidadHojas"] : 1; 
			// Si acoplamiento es 'Ambos', son 2 hojas. Si no está definido, asumimos 1.
			if(isset($producto["acoplamiento"]) && $producto["acoplamiento"] == "Ambos"){
				$numHojas = 2;
			}

			if ($producto["ancho"] >= 5 && $numHojas == 1) 
			{
				$PrecioTotalMo = ($producto["MetrajeMo"]* ($producto["cantidad"]/2)) * $producto["PrecioMo"];	
				$TotalMo = $producto["MetrajeMo"] *  ($producto["cantidad"]/2);

				$ImporteRealMO = $PrecioTotalMo;
				$MetrajeRealMO = $TotalMo;
				$PorcentajeDescuentoVAR = $PorcentajeDescuento;

				$PrecioFinalMo = ($ImporteRealMO - GenerarCantidadFinal($PorcentajeDescuentoVAR,$ImporteRealMO,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
						
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $MetrajeRealMO, 'Codigo'=> $producto["CodigoMo"], 'Descripcion' => 'Mano de Obra', 'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuentoVAR,'importe'=> $PrecioFinalMo, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));	
			}



			if (!empty($producto["ColorForro"])){
				//Tela Forro
				$TotalMetraje = number_format($producto["MetrajeForro"] * $producto["cantidad"], 2, '.', '');
				$PrecioTotalTela = $TotalMetraje * $producto["PrecioTelaForro"];

				$ImporteRealForro = $PrecioTotalTela;
				$MetrajeRealForro = $TotalMetraje;
				$PorcentajeDescuentoVAR = $PorcentajeDescuento;

				/*if(isset($producto["PrecioRealForro"]) && $producto["PrecioRealForro"] <> ""){
					//$ImporteRealForro =  $producto["PrecioRealForro"];
					//$MetrajeRealForro = $producto["MetrajeRealForro"];

					$ImporteRealForro =  $producto["PrecioRealForro"] * $producto["cantidad"];
					$MetrajeRealForro = $producto["MetrajeRealForro"] * $producto["cantidad"];

					$CalculoDescForro = $PrecioTotalTela - $ImporteRealForro;
					if($CalculoDescForro > 0){
						$DescuentoAplicadoAProducto = GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]);

						$DescuentosTotales = $DescuentoAplicadoAProducto - $CalculoDescForro;
						$PorcentajeDescuentoVAR = ($DescuentosTotales * 100) / $ImporteRealForro;	
					}
				}*/

				$PrecioFinalMetraje = ($ImporteRealForro - GenerarCantidadFinal($PorcentajeDescuentoVAR,$ImporteRealForro,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' =>$MetrajeRealForro , 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => $producto["telaForro"],
					    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuentoVAR,'importe'=> $PrecioFinalMetraje, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

				//Mano Obra Forro

				$PrecioTotalMoForro = ($producto["MetrajeMoForro"]* $producto["cantidad"]) * $producto["PrecioMoForro"];
				$TotalMo = $producto["MetrajeMoForro"] *  $producto["cantidad"];

				$PorcentajeDescuentoVAR = $PorcentajeDescuento;

				$ImporteRealForroMO = $PrecioTotalMoForro;
				$MetrajeRealForroMO = $TotalMo;

				/*if(isset($producto["PrecioMoRealForro"]) && $producto["PrecioMoRealForro"] <> ""){
					//$ImporteRealForroMO =  $producto["PrecioMoRealForro"];
					//$MetrajeRealForroMO = $producto["MetrajeMORealForro"];

					$ImporteRealForroMO =  $producto["PrecioMoRealForro"] *  $producto["cantidad"];
					$MetrajeRealForroMO = $producto["MetrajeMORealForro"] *  $producto["cantidad"];

					$CalculoDescForroMO = $PrecioTotalMoForro - $ImporteRealForroMO;
					if($CalculoDescForroMO > 0){
						$DescuentoAplicadoAProducto = GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMoForro,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]);

						$DescuentosTotales = $DescuentoAplicadoAProducto - $CalculoDescForroMO;
						$PorcentajeDescuentoVAR = ($DescuentosTotales * 100) / $ImporteRealForroMO;	
					}
				}*/

				$PrecioFinalMoForro = ($ImporteRealForroMO - GenerarCantidadFinal($PorcentajeDescuentoVAR,$ImporteRealForroMO,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $MetrajeRealForroMO, 'Codigo'=> $producto["CodigoMoForro"], 'Descripcion' => 'Mano de Obra Forro',
					    						  	  'PrecioUnit'=> $producto["PrecioMoForro"], 'Descuento' =>  $PorcentajeDescuentoVAR,'importe'=> $PrecioFinalMoForro, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

			}

			if(isset($producto["CodigoArgolla"]) && $producto["CodigoArgolla"] <> ""){
				$importeTotal = $producto["PrecioArgolla"] * $producto["CantidadArgolla"];
				$PrecioFinalArgolla = ($importeTotal - GenerarCantidadFinal($PorcentajeDescuento,$importeTotal,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;

				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["CantidadArgolla"], 'Codigo'=> $producto["CodigoArgolla"], 'Descripcion' => 'Argolla',
					    						  	  'PrecioUnit'=> $producto["PrecioArgolla"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalArgolla, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			if ($producto["MetrajeBajoPlomo"]>0){

				$TotalMetraje = number_format($producto["MetrajeBajoPlomo"] * $producto["cantidad"], 2, '.', ''); 
				$PrecioTotalTela = $TotalMetraje * $producto["PrecioPlomo"];
				$PrecioTotalTelaFinal = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoBajoPlomo"], 'Descripcion' => 'Bajo Plomo Rapport',
												   'PrecioUnit'=> $producto["PrecioPlomo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioTotalTelaFinal, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			if (!empty($producto["stiffener"])){
				$importeTotal = $producto["PrecioStiffener"] * $producto["cantidad"];
				$PrecioFinalStiffener = ($importeTotal - GenerarCantidadFinal($PorcentajeDescuento,$importeTotal,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoStiffener"], 'Descripcion' => "STIFFENER",
			    						  	  'PrecioUnit'=> $producto["PrecioStiffener"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalStiffener, 'numKit' => $numKit), 
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
										array('%s','%s','%s'));
		
		}

		/* ************************************************************************* CORTINEROS ************************************************************************* */
		elseif ($producto["tipoarticulo"]=="cortinero"){

			if ($producto["TipoArticuloDetalle"]=="CONTROL PARED" || $producto["TipoArticuloDetalle"]=="SITUO" || $producto["TipoArticuloDetalle"]=="DOMOTICA" || $producto["TipoArticuloDetalle"]=="glystro" || $producto["TipoArticuloDetalle"] == "movelite" || $producto["TipoArticuloDetalle"] == "irismo" || $producto["TipoArticuloDetalle"] == "gabin" || $producto["TipoArticuloDetalle"] == "forest") {
				$PorcentajeDescuentoCortinero = GenerarPorcentajeCortineroMotorizado($PorcentajeDescuento);
			} else {
				$PorcentajeDescuentoCortinero = $PorcentajeDescuento;
			}

			if ($producto["baston"]=="true"){
				// Cálculo original para bastón
				$PrecioBaston = (($producto["precio"]* $producto["cantidad"]) -  $producto["precioBaston"])/$producto["cantidad"];
				$importe = ($PrecioBaston - GenerarCantidadFinal($PorcentajeDescuento,$PrecioBaston,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
				$importeKit = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];

			}elseif($producto["controlMot"]=="true"){
				// NUEVA LÓGICA DE RESIDUO PARA CONTROL MOTORIZADO
				// 1. Calcular el Total Original EXACTO (lo que vio el cliente)
				$ImporteTotalOriginal = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
				
				// 2. Calcular el Importe del Control con su descuento
				$precioControl = $producto["precioControl"];
				$ImporteControl = ($precioControl - GenerarCantidadFinal($PorcentajeDescuento,$precioControl,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];

				// 3. El Importe del Cortinero Base es el RESIDUO (Total - Control)
				// Esto fuerza a que la suma sea exacta
				$importe = $ImporteTotalOriginal - $ImporteControl; 
				$PrecioBaston = $importe / $producto["cantidad"]; // Precio unitario implícito del cortinero

				// El precio del kit es el total original
				$importeKit = $ImporteTotalOriginal;
			}
			else{
				$PrecioBaston = $producto["precio"];
				$importe = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
				$importeKit = $importe;
			}
			
			$numKit = $numKit +1;
			// El bloque original que recalculaba $importeKit sumando partes se elimina o comenta porque ya calculamos $importeKit arriba con exactitud
			/*
			if ($producto["controlMot"]=="true"){
				$precioControl=$producto["precioControl"];		
				$importeKit = $importe + (($precioControl - GenerarCantidadFinal($PorcentajeDescuento,$precioControl,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) *  $producto["cantidad"]);
			}else{
				$importeKit = $importe;
			}
			*/

			// Curva de Glydea (SERVICIO-CURV-KS o DT-CODO-GLYDEA90°): va como renglon aparte del kit,
			// se le resta al cortinero para que el total del kit no cambie
			$tieneCurva = !empty($producto["codigoCurva"]) && $producto["cantidadCurva"] > 0 && $producto["precioCurva"] > 0;
			if ($tieneCurva){
				$precioCurva = $producto["precioCurva"];
				$cantidadCurva = $producto["cantidadCurva"] * $producto["cantidad"];
				$importeCurva = ($precioCurva - GenerarCantidadFinal($PorcentajeDescuento,$precioCurva,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $cantidadCurva;

				$importe = $importe - $importeCurva;
				if ($producto["controlMot"]=="true"){
					$PrecioBaston = $importe / $producto["cantidad"];
				}else{
					$PrecioBaston = $PrecioBaston - ($precioCurva * $producto["cantidadCurva"]);
				}
			}

			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => '1', 'Codigo'=> 'AR-COMODIN', 'Descripcion' => $producto["nombre"],
			   						  	  'PrecioUnit'=> $importeKit, 'Descuento' => '0','importe'=> $importeKit, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $producto["nombre"],
										'PrecioUnit'=> $PrecioBaston, 'Descuento' => $PorcentajeDescuentoCortinero,'importe'=> $importe, 'numKit' => $numKit), 
						 array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
									
			if ($producto["controlMot"]=="true"){
				$precioControl=$producto["precioControl"];
				$importe = ($precioControl - GenerarCantidadFinal($PorcentajeDescuento,$precioControl,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))*  $producto["cantidad"];
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' =>  $producto["cantidad"], 'Codigo'=> $producto["codigoControl"], 'Descripcion' => $producto["nombreControl"],
				   						  	  'PrecioUnit'=> $precioControl, 'Descuento' => $PorcentajeDescuentoCortinero,'importe'=> $importe, 'numKit' => $numKit),
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			if ($tieneCurva){
				// utf8_decode porque la conexion es latin1 (el codigo del codo lleva °)
				$descripcionCurva = ($producto["codigoCurva"] == "SERVICIO-CURV-KS") ? "SERVICIO DE CURVEADO" : utf8_decode("CODO PREFABRICADO PARA CURVA GLYDEA 90°");
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $cantidadCurva, 'Codigo'=> utf8_decode($producto["codigoCurva"]), 'Descripcion' => $descripcionCurva,
				   						  	  'PrecioUnit'=> $precioCurva, 'Descuento' => $PorcentajeDescuentoCortinero,'importe'=> $importeCurva, 'numKit' => $numKit),
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit),
									array('%s','%s','%s'));						


			if ($producto["baston"]=="true"){
				$numKit = $numKit +1;
				$precioBaston=$producto["precioBaston"]/$producto["cantBaston"];
				$importe = ($precioBaston - GenerarCantidadFinal($PorcentajeDescuento,$precioBaston,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantBaston"];
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'N', 'Cantidad' => $producto["cantBaston"], 'Codigo'=> $producto["codigoBaston"], 'Descripcion' => "Baston",
				   						  	  'PrecioUnit'=> $precioBaston, 'Descuento' => $PorcentajeDescuentoCortinero,'importe'=> $importe, 'numKit' => $numKit), 
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				

				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
										array('%s','%s','%s'));
			}
		}

		
		/* ************************************************************************* PACHETO ************************************************************************* */
		elseif ($producto["tipoarticulo"]=="pacheto"){
			$numKit = $numKit +1;
			//Cortina General
			//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;

			$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
			$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
			$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;

			$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
			$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;

			$importePacheto = $PrecioFinalTela + $PrecioFinalMecanismo;
			$unitarioPacheto = $importePacheto / $producto["cantidad"];
			
			//$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			//$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => utf8_decode($producto["nombre"]),
										  'PrecioUnit'=> $unitarioPacheto, 'Descuento' => '0','importe'=> $importePacheto, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			
									
			//Tela
			
			if (!empty($producto["CodigoTela"]) && $TotalMetraje > 0 && $producto["PrecioTela"] > 0){
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
												   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalTela, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s')) ;
			}

							
			//Mecanismo
			if (!empty($producto["CodigoMecanismo"]) && $producto["PrecioMecanismo"] > 0){
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoMecanismo"], 'Descripcion' => 'Mecanismo Romana sin varilla',
				    						  'PrecioUnit'=> $producto["PrecioMecanismo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo, 'numKit' => $numKit), 
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			//, 'Cantidad' => $producto["cantidad"], '%s'
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
									array('%s','%s','%s'));
			
		/* ************************************************************************* ROMANA ************************************************************************* */
		} elseif ($producto["tipoarticulo"]=="romana"){
			//Cortina General
			//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
			$numKit = $numKit +1;

			$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
			$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
			$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;

			$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
			$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;

			$importePacheto = $PrecioFinalTela + $PrecioFinalMecanismo;
			$unitarioPacheto = $importePacheto / $producto["cantidad"];


			//$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			//$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) *  $producto["cantidad"];
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => utf8_decode($producto["nombre"]),
										  'PrecioUnit'=> $unitarioPacheto, 'Descuento' => '0','importe'=> $importePacheto, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			
									
			//Tela
			//$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');//$producto["Metraje"] * $producto["cantidad"];
			//$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
			//$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			if (!empty($producto["CodigoTela"]) && $TotalMetraje > 0 && $producto["PrecioTela"] > 0){
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
												   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalTela, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s')) ;
			}

								
			//Mecanismo
			//$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
			//$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			if (!empty($producto["CodigoMecanismo"]) && $producto["PrecioMecanismo"] > 0){
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoMecanismo"], 'Descripcion' => 'Mecanismo Romana',
				    						  'PrecioUnit'=> $producto["PrecioMecanismo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo, 'numKit' => $numKit), 
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			}

			
			$colorForro = isset($producto["ColorForro"]) ? trim($producto["ColorForro"]) : "";
			$colorForroLower = strtolower($colorForro);
			if ($colorForro !== "" && $colorForro !== "0" && $colorForroLower !== "undefined" && $colorForroLower !== "null"){
				//Tela Forro
				$TotalMetraje = number_format($producto["MetrajeForro"] * $producto["cantidad"], 2, '.', '');//$producto["MetrajeForro"] * $producto["cantidad"];
				$PrecioTotalTela = $TotalMetraje * $producto["PrecioTelaForro"];
				$PrecioFinalMecanismo = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
				if (!empty($producto["CodigoTelaForro"]) && $TotalMetraje > 0 && $producto["PrecioTelaForro"] > 0){
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => $producto["telaForro"],
				    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				}
			
			}

			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
									array('%s','%s','%s'));

			
		/* ************************************************************************* GALERIA ************************************************************************* */
		}elseif ($producto["tipoarticulo"]=="galeria"){
			//CÁLCULO DE TODOS LOS TOTALES
			$aux = 1 - (doubleval($PorcentajeDescuento)/100);

			$TotalTela = ($producto["MetrajeGaleria"] * $producto["PrecioTela"]) * $aux;
			$TotalMo = ($producto["MetrajeMo"] * $producto["PrecioMo"]) * $aux;
			$TotalEscuadras = ($producto["TotalEscuadras"] * $producto["PrecioEscuadras"]) * $aux;

			if ($producto["PrecioTelaForro"] <> "N/A"){
				$TotalForro = ($producto["MetrajeForro"] * $producto["PrecioTelaForro"]) * $aux;
				//$TotalForro = 150;

				$PrecioMOForro = ($producto["MetrajeMo"] * $producto["PrecioMo"]) * 0.5; //PENDIENTE TOMARLO DE BASE DE DATOS
				$TotalMOForro = $PrecioMOForro * $aux;
			}else{
				$TotalForro = 0;
				$TotalMOForro = 0;
			}

			if ($producto["fijacion"] == "Muro"){
				$PrecioCopete = ($producto["MetrajeMo"] * $producto["PrecioMo"]) * 0.5; //PENDIENTE TOMARLO DE BASE DE DATOS
				$TotalCopete = $PrecioCopete * $aux;
			}else{
				$TotalCopete = 0;
			}

			//$TotalGaleria = $TotalTela + $TotalMo + $TotalEscuadras + $TotalForro + $TotalMOForro + $TotalCopete;

			$TotalGaleria = $TotalTela + $TotalMo + $TotalEscuadras + $TotalForro + $TotalMOForro + $TotalCopete;

			$PrecioUnitarioGaleria = $TotalGaleria / $producto["cantidad"];

			$numKit = $numKit +1;
			//Cortina General
			//$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			//$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * $producto["cantidad"];
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 
											'Descripcion' => utf8_decode($producto["nombre"]),
										  'PrecioUnit'=> $PrecioUnitarioGaleria, 'Descuento' => '0','importe'=> $TotalGaleria, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

														
			//Tela
			//$TotalMetraje = number_format($producto["MetrajeGaleria"] * $producto["cantidad"], 2, '.', ''); //$producto["cantidad"] * $producto["MetrajeGaleria"];

			//$PrecioGaleria = $producto["PrecioTela"] * $TotalMetraje;
			//$PrecioFinalGaleria = ($PrecioGaleria - GenerarCantidadFinal($PorcentajeDescuento,$PrecioGaleria,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $producto["MetrajeGaleria"], 'Codigo'=> $producto["CodigoTela"], 
										  'Descripcion' => $producto["tela"],
										  'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $TotalTela, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

			
								
			//Mano Obra
			//$PrecioMO = ($producto["PrecioMo"] * $producto["ancho"])*$producto["cantidad"];
			//$CantidadTotal = $producto["ancho"] * $producto["cantidad"];
			//$PrecioFinalMO = ($PrecioMO - GenerarCantidadFinal($PorcentajeDescuento,$PrecioMO,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["MetrajeMo"], 'Codigo'=> $producto["CodigoMo"], 
										  'Descripcion' => 'Mano de Obra',
			    						  'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $TotalMo, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));


			
			//Tela Forro
			if ($TotalForro <> 0){

				$PrecioFinalForro = ( $producto["PrecioTelaForro"] - GenerarCantidadFinal($PorcentajeDescuento, $producto["PrecioTelaForro"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
				
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["MetrajeForro"], 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => "MICROFIBRA",
			    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $TotalForro, 'numKit' => $numKit), 
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => 1, 'Codigo'=> $producto["CodigoMoForro"], 
										  'Descripcion' => 'Mano de Obra Tela Forro',
			    						  'PrecioUnit'=> $PrecioMOForro, 'Descuento' =>  $PorcentajeDescuento,'importe'=> $TotalMOForro, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				 
			}

			//COPETE
			if($TotalCopete <> 0){
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => 1, 'Codigo'=> $producto["CodigoCopete"], 
										  'Descripcion' => 'Copete',
			    						  'PrecioUnit'=> $PrecioCopete, 'Descuento' =>  $PorcentajeDescuento,'importe'=> $TotalCopete, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

			}
			
			//ESCUADRAS
			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["TotalEscuadras"], 'Codigo'=> $producto["CodigoEscuadras"], 
										  'Descripcion' => 'Escuadras',
			    						  'PrecioUnit'=> $producto["PrecioEscuadras"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $TotalEscuadras, 'numKit' => $numKit), 
									array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

			insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
										array('%s','%s','%s'));

			//ESCUADRAS


			//$producto["MetrajeMo"] = $producto["MLManoObra"];


		}elseif ($producto["tipoarticulo"]=="DOMOTICA" || $producto["tipoarticulo"]=="SITUO" || $producto["tipoarticulo"]=="CONTROL PARED"){
			$numKit = $numKit +1;
			
			if ($producto["TipoArticuloDetalle"]=="CONTROL PARED" || $producto["TipoArticuloDetalle"]=="SITUO" || $producto["TipoArticuloDetalle"]=="DOMOTICA") {
				$PorcentajeDescuentoCortinero = GenerarPorcentajeCortineroMotorizado($PorcentajeDescuento);
			} else {
				$PorcentajeDescuentoCortinero = $PorcentajeDescuento;
			}
				$precioControl=$producto["precio"];
				$importe = ($precioControl - GenerarCantidadFinal($PorcentajeDescuento,$precioControl,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'N', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $producto["nombre"],
				   						  	  'PrecioUnit'=> $precioControl, 'Descuento' => $PorcentajeDescuentoCortinero,'importe'=> $importe, 'numKit' => $numKit), 
										array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				

				insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
										array('%s','%s','%s'));
		}

	}// Termina foreach($carro as $producto){



	//INSERTA EN COTIZACION LOS DATOS DEL ENVIO FINAL
	/*$DescuentoAplicado = $carrito->precio_total() - $SubtotalDescCortinero;
	$IdCotizacionM = insert('cotizacion',array('ID_CLIENTE'=>$idCliente,'ID_USUARIO_ALTA'=>$_SESSION['login_user'],'SUBTOTAL' => $SubtotalDescCortinero,'IVA'=>$IvaTotalCortinero,
												'IMPORTEUNITARIO'=> $carrito->precio_total(),
												'DESCUENTO'=>$DescuentoAplicado,'TOTAL'=>$TotalCortinero, 'ESTATUS' => "1",'FolioCotizacion'=>$IdCotizacion,'CALLE'=>$n_calle,
												'NUMERO'=>$n_numero,'LOCALIDAD'=>$n_localidad,'TELEFONO'=>$n_telefono,'REFERENCIAS'=>$n_referencias,'ATENCION'=>$n_atencion,
												'CONTACTO'=>$n_contacto,'SUCURSAL'=>$n_sucursal,'COLONIA'=>$n_colonia, 'CP'=>$n_cp,'ESTADOD'=>$n_estado,'HORA'=>$n_hora,
												'CIUDAD'=>$n_ciudad, 'MUNICIPIO'=>$n_ciudad,'FECHA_ALTA'=>$nowFormat), 
										 array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
		*/
	

		foreach($carro as $producto){

			//ECHO "<BR> TIPO ARTICULO " . $producto["TipoArticuloDetalle"];

			insert('cotizacion_detalle',array('ID_COTIZACION'	=> $IdCotizacionM,
											  'CODIGO'			=> $producto["codigo"],
											  'CANTIDAD' 		=> $producto["cantidad"],
											  'NOMBRE'			=> utf8_decode($producto["nombre"]),
									  		  'PRECIO'			=> $producto["precio"], 
									  		  'TIPOARTICULO' 	=> $producto["tipoarticulo"],
									  		  'TIPOARTICULODETALLE'=> $producto["TipoArticuloDetalle"],
									  		  'RUTA'			=> $producto["ruta"],
											  'ANCHO' 			=> $producto["ancho"],
											  'ALTO'			=> $producto["alto"],
									  		  'TIPOCORTINA'		=> $producto["tipocortina"], 
									  		  'FIJACION' 		=> $producto["fijacion"],
									  		  'ACOPLAMIENTO'	=> $producto["acoplamiento"],
											  'TELA' 			=> $producto["tela"],
											  'COLOR'			=> $producto["color"],
									  		  'GANCHO'			=> $producto["gancho"], 
									  		  'BAJOPLOMO' 		=> $producto["bajoplomo"],
									  		  'STIFFENER'		=> $producto["stiffener"],
											  'NEVERLIGHT' 		=> $producto["neverlight"],
											  'TELAFORRO'		=> $producto["telaForro"],
									  		  'PRECIOTELA'		=> $producto["PrecioTela"], 
									  		  'CODIGOTELA' 		=> $producto["CodigoTela"],
									  		  'METRAJE'			=> $producto["Metraje"],
											  'COLORFORRO' 		=> $producto["ColorForro"],
											  'PRECIOFINALFORRO'=> $producto["PrecioFinalForro"],
									  		  'CODIGOTELAFORRO'	=> $producto["CodigoTelaForro"], 
									  		  'CODIGOMOFORRO' 	=> $producto["CodigoMoForro"],
									  		  'PRECIOTELAFORRO'	=> $producto["PrecioTelaForro"],
											  'PRECIOMOFORRO' 	=> $producto["PrecioMoForro"],
											  'CODIGOMO'		=> $producto["CodigoMo"],
									  		  'PRECIOMO'		=> $producto["PrecioMo"], 
									  		  'METRAJEFORRO' 	=> $producto["MetrajeForro"],
									  		  'METRAJEMOFORRO'	=> $producto["MetrajeMoForro"],
									  		  'CODIGOSTIFFENER'	=> $producto["CodigoStiffener"],
											  'PRECIOSTIFFENER' => $producto["PrecioStiffener"],

											  'CODIGOBAJOPLOMO'	=> $producto["CodigoBajoPlomo"],
									  		  'PRECIOPLOMO'	=> $producto["PrecioPlomo"],
											  'METRAJEBAJOPLOMO' => $producto["MetrajeBajoPlomo"],


											  'CANTIDADHOJAS'	=> $producto["cantidadHojas"],
									  		  'CONTROL'			=> $producto["control"], 
									  		  'DECORATIVO' 		=> $producto["decorativo"],
									  		  'PESO' 			=> $producto["peso"],
									  		  'REMATE'			=> $producto["remate"],
											  'RESULTADOSISTEMA'=> $producto["resultadoSistema"],
											  'SOPORTE'			=> $producto["soporte"],
									  		  'ARGOLLA'			=> $producto["argolla"], 
									  		  'BASTON' 			=> $producto["baston"],
									  		  'COLORBASTON'		=> $producto["colorBaston"],
									  		  'RADIOMEDIDA' 	=> $producto["radioMedida"],
											  'RADIOMATERIAL' 	=> $producto["radioMaterial"],
											  'CANTIDADBASTON' 	=> $producto["cantBaston"],
											  'CODIGOBASTON' 	=> $producto["codigoBaston"],
											  'PRECIOBASTON' 	=> $producto["precioBaston"],
											  'PROYECCIONES'	=> $producto["proyecciones"],
									  		  'COPETE'			=> $producto["copete"], 
									  		  'CODIGOMECANISMO' => $producto["CodigoMecanismo"],
									  		  'PRECIOMECANISMO'	=> $producto["PrecioMecanismo"],
									  		  'ID'				=> $producto["id"],
									  		  'AREA'			=> $producto["area"],
									  		  'METRAJEMO'		=> $producto["MetrajeMo"],
									  		  'METRAJEGALERIA'	=> $producto["MetrajeGaleria"],
									  		  'CONTROLMOT'		=> $producto["controlMot"],
									  		  'CODIGOCONTROL'	=> $producto["codigoControl"],
									  		  'NOMBRECONTROL'	=> $producto["nombreControl"],
									  		  'PRECIOCONTROL' 	=> $producto["precioControl"],
											  'TIPOCONTROL' 	=> $producto["tipoControlMot"],
											  'IDDRAPESNOMBRE'  => $producto["idDrapesNombre"],
											  'CODIGOARGOLLA'	=> $producto["CodigoArgolla"],
											  'CANTIDADARGOLLA'	=> $producto["CantidadArgolla"],
											  'PRECIOARGOLLA'	=> $producto["PrecioArgolla"],
											  'METRAJEREAL'     => $producto["MetrajeReal"],
											  'METRAJEMOREAL'   => $producto["MetrajeMOReal"],
											  'PRECIOREAL'      => $producto["PrecioReal"],
											  'PRECIOMOREAL'    => $producto["PrecioMoReal"],
											  'METRAJEREALFORRO' => $producto["MetrajeRealForro"],
											  'METRAJEMOREALFORRO' => $producto["MetrajeMORealForro"],
											  'PRECIOREALFORRO' => $producto["PrecioRealForro"],
											  'PRECIOMOREALFORRO' => $producto["PrecioMoRealForro"],
											  'METRAJEBAJOPLOMOREAL' => $producto["MetrajeBajoPlomoReal"],
											  'COLORCINTA' => $producto["colorCinta"],
											  'MEDIDAPROYECCION' => $producto["medidaProyeccion"],
											  'CODIGOESCUADRAS' => $producto["CodigoEscuadras"],
											  'CANTIDADESCUADRAS' => $producto["TotalEscuadras"],
											  'PRECIOESCUADRAS' => $producto["PrecioEscuadras"],
											  'CODIGOCOPETE' => $producto["CodigoCopete"],
											  'VARILLA' => $producto["Varilla"],
											  'ANCHOTELA' => $producto["AnchoTela"],
											  'APROVTELA' => $producto["AprovTela"],
											  'APLICAAPROV' => $producto["AplicaAprov"],
											  'CONSECAPROV' => $producto["ConsecAprov"],
											  'ORIENTACIONRAYACORTINA' => $producto["OrientacionRayaCortina"],
											'LADO_MOTOR' => $producto["lado_motor"],
											  // Curva (Glydea / Curvo KS); NULL si no lleva
											  'CURVORECTO'    => isset($producto["curvoRecto"]) && $producto["curvoRecto"] <> "" ? $producto["curvoRecto"] : null,
											  'CODIGOCURVA'   => isset($producto["codigoCurva"]) && $producto["codigoCurva"] <> "" ? utf8_decode($producto["codigoCurva"]) : null,
											  'CANTIDADCURVA' => isset($producto["cantidadCurva"]) && $producto["cantidadCurva"] <> "" ? $producto["cantidadCurva"] : null,
											  'PRECIOCURVA'   => isset($producto["precioCurva"]) && $producto["precioCurva"] <> "" ? $producto["precioCurva"] : null,
									  		  ),
										array('%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
											  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s','%s', '%s', '%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s'));
	}// Termina foreach($carro as $producto) 


}

// Guardar Descuento utilizado
$DescuentoProducto = TraerDescuento($_SESSION['login_user']);
if (count($DescuentoProducto)>0){
	foreach ($DescuentoProducto as $Desc) {
		//echo "&nbsp;-".$Desc."% &nbsp;";
		insert('cotizacion_descuento',array('ID_COTIZACION'	=> $IdCotizacionM,'DESCUENTO'=> $Desc ),array('%s','%s'));
	}

}else{
	insert('cotizacion_descuento',array('ID_COTIZACION'	=> $IdCotizacionM,'DESCUENTO'=> '0'),array('%s','%s'));
}


// Guardar Iva utilizado
insert('cotizacion_iva',array('ID_COTIZACION' => $IdCotizacionM,'IVA'=>$iva),array('%s','%s'));





if ($IdCotizacionM>0 and  $IdCotizacion>0) {

	echo "Cotizacion guardada correctamente";
	$_SESSION['folio']=null;
	$_SESSION['IdCliente']=null;
	$_SESSION['NombreCliente']=null;

	$carrito->destroy();

	?>
	<script type="text/javascript">
		alert('Cotizacion guardada');
		window.location.href = 'index.php?opcion=linea';
	</script>

	<?php

}else{

	$_SESSION['folio']=null;
	$_SESSION['IdCliente']=null;
	$_SESSION['NombreCliente']=null;
	$carrito->destroy();

	echo "hubo un problema al guardar los datos favor de reportarlo.";
}


?>
