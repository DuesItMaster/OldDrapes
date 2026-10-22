<?php

	include_once '../clases/Carrito.class.php';
	require_once '../fnc/terminarIva.php';
	require_once '../fnc/terminarDescuento.php';
	include_once '../../conexion/ins.php';
	include_once '../../conexion/cnx.php';

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

	if (isset($_POST['NuevoCliente']))
	{
		if ($_POST['NuevoCliente']=="SI")
		{
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
		}
		else
		{
			$idCliente=$_POST['idCliente'];
		}
	}

	if (isset($_POST['AgregarDireccion']))
	{
		if ($_POST['AgregarDireccion']=="SI")
		{
			// DIRECCION NUEVA//echo "Agregar direccion de inputs nueva direccion";
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
		} 
		elseif($_POST['DireccionCliente']=="SI")
		{
			if ($_POST['NuevoCliente']=="SI")
			{
				//DIRECCION DEL CLIENTE GUARDADO EN INPUTS//echo "Agregar direccion de inputs nuevo cliente";
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
			}
			else
			{
				//DIRECCION DEL CLIENTE YA GUARDADO
				$idCliente=$_POST['idCliente'];
				$sql = "select CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,MUNICIPIO,
						TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,EMAIL,CP  
						from cliente where id_cliente =".$idCliente." and ID_USUARIO_ALTA=".$_SESSION['login_user'].";";

				$result = mysqli_query($GLOBALS['db'], $sql);
				if (mysqli_num_rows($result) > 0)
				{
				    while($row = mysqli_fetch_assoc($result))
				    {
				    	$n_calle = $row["CALLE"];
						$n_numero = $row["NUMERO"];
						$n_colonia = $row["COLONIA"];
						$n_localidad = $row["LOCALIDAD"];
						$n_estado = $row["ESTADO"];
						$n_municipio = $_POST['MUNICIPIO'];
						$n_telefono = $row["TELEFONO"]; 
						$n_referencias = $row["REFERENCIAS"]; 
						$n_atencion = $row["ATENCION"];
						$n_contacto = $row["CONTACTO"];
						$n_sucursal =$row["SUCURSAL"];
						$n_cp =$row["CP"]; 
				    }
				}
			}
		}
		else
		{
			//DIRECCION DEL DISTRIBUIDOR
			$sql = "select CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,MUNICIPIO,CIUDAD,
					TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,/*EMAIL,*/CP,HORA  
					from usuario_direccion where ID_USUARIO =".$_SESSION['login_user'].";";

			$result = mysqli_query($GLOBALS['db'], $sql);
			if (mysqli_num_rows($result) > 0) 
			{
			    while($row = mysqli_fetch_assoc($result)) 
			    {
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

	$DireccionFinal = $n_calle . " " .  $n_numero . " " . $n_colonia ." ". $n_localidad . ", " . $n_estado;

	$carrito = new Carrito();
	$carro = $carrito->get_content();

	// FOLIO DE COTIZACION
	$Folio = $carrito->TraerFolio();

	if($carro)
	{
		$sql="select FolioCotizacion from cotizacion where id_cotizacion =".$Folio." and id_usuario_alta=".$_SESSION['login_user'].";";
		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) 
		{
		    while($row = mysqli_fetch_assoc($result)) 
		    {
		    	$IdCotizacion = $row["FolioCotizacion"];
			}
		}

		$iva = TraerIva();

		$PorcentajeDescuento =  GenerarPorcentaje();
		$SubtotalDescCortinero = SacarTotalesCortineroMotorizado();

		$IvaTotal = ($Subtotal * ($iva/100));
		$Total =  $Subtotal + $IvaTotal;

		$IvaTotalCortinero = ($SubtotalDescCortinero * ($iva/100));
		$TotalCortinero =  $SubtotalDescCortinero + $IvaTotalCortinero;
			

		$ModificacionCotizacionSap = FALSE;

		if (!isset($_POST['DireccionCarrito']))
		{
			echo "<br>no traigo variable isset";
			if (update('Cotizacion_Gen',array('NombreCte'=>$_SESSION['nombre_user'],
											  'CodigoCte'=>$_SESSION['sap'],
											  'Total' => $TotalCortinero,
											  'DirEntrega'=> $DireccionFinal,
											  'Atenciona'=> $n_atencion,
											  'Telefonos'=> $n_telefono,
											  'ImpDescto'=> '0',
							  				  'Subtotal'=>$SubtotalDescCortinero, 
							  				  'iva' => $IvaTotalCortinero,
							  				  'Descuento' =>  '0',
							  				  'ImpTotal' => $TotalCortinero), 
										array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'),
										array('FolioCotizacion'=>$IdCotizacion), array('%d')) ) 
			{
				$ModificacionCotizacionSap = true;
				delete('Cotizacion_Det','FolioCotizacion',$IdCotizacion);
			}
		} 
		else 
		{
			//***** Validar que lo que se quiere actualizar no sea igual a lo que ya esta guardado en bdd
			$query = "SELECT NombreCte, CodigoCte, Total, ImpDescto, Subtotal, Iva, Descuento, ImpTotal
				 	  FROM Cotizacion_Gen
				 	  WHERE FolioCotizacion = " . $IdCotizacion . ";";

			$result = mysqli_query($GLOBALS["db"], $query);
			
			if (mysqli_num_rows($result) > 0)
			{
			    while ($row = mysqli_fetch_assoc($result))
			    {
			    	if (
						$_SESSION['nombre_user'] == $row["NombreCte"] &&
						$_SESSION['sap'] == $row["CodigoCte"] &&
						number_format($TotalCortinero, 2, '.', '') == $row["Total"] &&
						'0' == $row["ImpDescto"] &&
						number_format($SubtotalDescCortinero, 2, '.', '') == $row["Subtotal"] &&
						number_format( $IvaTotalCortinero, 2, '.', '') == $row['Iva'] &&
						'0' == $row["Descuento"] &&
						number_format($Total, 2, '.', '') == $row["ImpTotal"]
					)
					{
						$ModificacionCotizacionSap = TRUE;
						delete('Cotizacion_Det', 'FolioCotizacion', $IdCotizacion);
					}
			    }
			}
		    //***** Validar que lo que se quiere actualizar no sea igual a lo que ya esta guardado en bdd

			if (
				update('Cotizacion_Gen',
					array(
						'NombreCte' => $_SESSION['nombre_user'],
						'CodigoCte' => $_SESSION['sap'],
						'Total' => number_format($TotalCortinero, 2, '.', ''),
						'ImpDescto' => '0',
					  	'Subtotal' => number_format($SubtotalDescCortinero, 2, '.', ''),
					  	'Iva' => number_format( $IvaTotalCortinero, 2, '.', ''),
						'Descuento' => '0',
						'ImpTotal' => number_format($Total, 2, '.', '')
					),
					array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'),
					array('FolioCotizacion' => $IdCotizacion),
					array('%d')
				)
			) 
			{
				$ModificacionCotizacionSap = TRUE;
				delete('Cotizacion_Det','FolioCotizacion',$IdCotizacion);
			}
		}

		if ($ModificacionCotizacionSap == TRUE) 
		{
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

			foreach($carro as $producto)
			{
				/* ************************************************************************* CORTINA ************************************************************************* */
				if ($producto["tipoarticulo"]=="cortina")
				{
					$numKit = $numKit + 1;
					//Cortina General Descuento
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					$Nombre = strtoupper ("" . utf8_decode($producto["nombre"]) . " tela: " . $producto["tela"] . " color: " . $producto["color"] . " med: " . $producto["ancho"] . " x " . $producto["alto"]);
					$importe = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $Nombre ,
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				
					//Tela
					$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', ''); //$producto["Metraje"] * $producto["cantidad"]; //number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
					$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
					$PrecioTotalTelaFinal = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
													   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioTotalTelaFinal, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
			
					//Mano Obra
					$PrecioTotalMo = ($producto["MetrajeMo"]* $producto["cantidad"]) *$producto["PrecioMo"];
					$TotalMo = $producto["MetrajeMo"] *  $producto["cantidad"];
					$PrecioFinalMo = ($PrecioTotalMo - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMo, 'Codigo'=> $producto["CodigoMo"], 'Descripcion' => 'Mano de Obra',
					    						  'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMo, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

					if ($producto["ancho"]>3) 
					{
						$PrecioTotalMo = ($producto["MetrajeMo"]* ($producto["cantidad"]/2)) * $producto["PrecioMo"];	
						$TotalMo = $producto["MetrajeMo"] *  ($producto["cantidad"]/2);
						$PrecioFinalMo = ($PrecioTotalMo - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
						
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMo, 'Codigo'=> $producto["CodigoMo"], 'Descripcion' => 'Mano de Obra',
						    						  'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMo, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));	
					}

				
					if (!empty($producto["ColorForro"]))
					{
					//Tela Forro
						$TotalMetraje = number_format($producto["MetrajeForro"] * $producto["cantidad"], 2, '.', '');//$producto["MetrajeForro"] * $producto["cantidad"];
						$PrecioTotalTela = $TotalMetraje * $producto["PrecioTelaForro"];
						$PrecioFinalMetraje = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' =>$TotalMetraje , 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => $producto["telaForro"],
					    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMetraje, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
						

					//Mano Obra Forro
						if (!empty($producto["CodigoMoForro"])) {
							$PrecioTotalMoForro = ($producto["MetrajeMoForro"]* $producto["cantidad"]) * $producto["PrecioMoForro"];
							$TotalMo = $producto["MetrajeMoForro"] *  $producto["cantidad"];
							$PrecioFinalMoForro = ($PrecioTotalMoForro - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMoForro,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
							insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMo, 'Codigo'=> $producto["CodigoMoForro"], 'Descripcion' => 'Mano de Obra Forro',
					    						  	  'PrecioUnit'=> $producto["PrecioMoForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMoForro, 'numKit' => $numKit), 
													array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));	
						}
					}

					if (($producto["MetrajeBajoPlomo"])>0)
					{
						$TotalMetraje = number_format($producto["MetrajeBajoPlomo"] * $producto["cantidad"], 2, '.', ''); 
						$PrecioTotalTela = $TotalMetraje * $producto["PrecioPlomo"];
						$PrecioTotalTelaFinal = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoBajoPlomo"], 'Descripcion' => 'Bajo Plomo Rapport',
														   'PrecioUnit'=> $producto["PrecioPlomo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioTotalTelaFinal, 'numKit' => $numKit), 
													array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
					}

					if (!empty($producto["CodigoStiffener"]))
					{
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
				elseif ($producto["tipoarticulo"]=="cortinero")
				{
					if ($producto["TipoArticuloDetalle"]=="CONTROL PARED" || $producto["TipoArticuloDetalle"]=="SITUO" || $producto["TipoArticuloDetalle"]=="DOMOTICA" || $producto["TipoArticuloDetalle"]=="glystro" || $producto["TipoArticuloDetalle"] == "movelite" || $producto["TipoArticuloDetalle"] == "irismo" || $producto["TipoArticuloDetalle"] == "gabin" || $producto["TipoArticuloDetalle"] == "forest") 
					{
						$PorcentajeDescuentoCortinero = GenerarPorcentajeCortineroMotorizado($PorcentajeDescuento);
					}
					else 
					{
						$PorcentajeDescuentoCortinero = $PorcentajeDescuento;
					}
					
					if ($producto["baston"]=="true")
					{
						$PrecioBaston = (($producto["precio"]* $producto["cantidad"]) -  $producto["precioBaston"])/$producto["cantidad"];
						$importe = ($PrecioBaston - GenerarCantidadFinal($PorcentajeDescuento,$PrecioBaston,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
					}elseif($producto["controlMot"]=="true"){
						$PrecioBaston = (($producto["precio"]* $producto["cantidad"]) -  ($producto["precioControl"] * $producto["cantidad"]))/$producto["cantidad"];
						$importe = ($PrecioBaston - GenerarCantidadFinal($PorcentajeDescuento,$PrecioBaston,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
					}
					else
					{
						$PrecioBaston = $producto["precio"];
						$importe = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
					}
					
					$numKit = $numKit +1;

					if ($producto["controlMot"]=="true"){
						$precioControl=$producto["precioControl"];		
						$importeKit = $importe + (($precioControl - GenerarCantidadFinal($PorcentajeDescuento,$precioControl,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) *  $producto["cantidad"]);
					}else{
						$importeKit = $importe;
					}

					// Curva de Glydea (SERVICIO-CURV-KS o DT-CODO-GLYDEA90°): va como renglon aparte del kit,
					// se le resta al cortinero para que el total del kit no cambie
					$tieneCurva = !empty($producto["codigoCurva"]) && $producto["cantidadCurva"] > 0 && $producto["precioCurva"] > 0;
					if ($tieneCurva){
						$precioCurva = $producto["precioCurva"];
						$cantidadCurva = $producto["cantidadCurva"] * $producto["cantidad"];
						$importeCurva = ($precioCurva - GenerarCantidadFinal($PorcentajeDescuento,$precioCurva,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $cantidadCurva;

						$importe = $importe - $importeCurva;
						$PrecioBaston = $PrecioBaston - ($precioCurva * $producto["cantidadCurva"]);
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
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigoControl"], 'Descripcion' => $producto["nombreControl"],
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

					if ($producto["baston"]=="true")
					{
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
				elseif ($producto["tipoarticulo"]=="pacheto")
				{
					$numKit = $numKit +1;
					//Cortina General
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => utf8_decode($producto["nombre"]),
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
					
											
					//Tela
					$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
					$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
					$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					if (!empty($producto["CodigoTela"]) && $TotalMetraje > 0 && $producto["PrecioTela"] > 0){
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
														   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalTela, 'numKit' => $numKit), 
													array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s')) ;
					}

									
					//Mecanismo
					$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
					$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoMecanismo"], 'Descripcion' => 'Mecanismo Romana sin varilla',
					    						  'PrecioUnit'=> $producto["PrecioMecanismo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

					//, 'Cantidad' => $producto["cantidad"], '%s'
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
											array('%s','%s','%s'));
					

				/* ************************************************************************* ROMANA ************************************************************************* */
				} 
				elseif ($producto["tipoarticulo"]=="romana")
				{
					$numKit = $numKit +1;
					//Cortina General
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) *  $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => utf8_decode($producto["nombre"]),
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
					
											
					//Tela
					$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');//$producto["Metraje"] * $producto["cantidad"];
					$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
					$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
													   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalTela, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s')) ;

										
					//Mecanismo
					$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
					$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
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
				}
				elseif ($producto["tipoarticulo"]=="galeria")
				{
					$numKit = $numKit +1;
					//Cortina General
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 
													'Descripcion' => utf8_decode($producto["nombre"]),
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe, 'numKit' => $numKit, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

																
					//Tela
					$TotalMetraje = number_format($producto["MetrajeGaleria"] * $producto["cantidad"], 2, '.', ''); //$producto["cantidad"] * $producto["MetrajeGaleria"];
					$PrecioGaleria = $producto["PrecioTela"] * $TotalMetraje;
					$PrecioFinalGaleria = ($PrecioGaleria - GenerarCantidadFinal($PorcentajeDescuento,$PrecioGaleria,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 
												  'Descripcion' => $producto["tela"],
												  'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalGaleria, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
				
					//Mano Obra
					$PrecioMO = ($producto["PrecioMo"] * $producto["ancho"])*$producto["cantidad"];
					$CantidadTotal = $producto["ancho"] * $producto["cantidad"];
					$PrecioFinalMO = ($PrecioMO - GenerarCantidadFinal($PorcentajeDescuento,$PrecioMO,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $CantidadTotal, 'Codigo'=> $producto["CodigoMo"], 
												  'Descripcion' => 'Mano de Obra',
					    						  'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMO, 'numKit' => $numKit), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));

					//Tela Forro
					if (isset($producto["ColorForro"]))
					{
						$PrecioFinalForro = ( $producto["PrecioTelaForro"] - GenerarCantidadFinal($PorcentajeDescuento, $producto["PrecioTelaForro"],1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"])) * $producto["cantidad"];
						
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => "MICROFIBRA",
					    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalForro, 'numKit' => $numKit), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
					}

					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
												array('%s','%s','%s'));
				}elseif ($producto["tipoarticulo"]=="DOMOTICA" || $producto["tipoarticulo"]=="SITUO" || $producto["tipoarticulo"]=="CONTROL PARED"){
					$numKit = $numKit +1;

					if ($producto["TipoArticuloDetalle"]=="CONTROL PARED" || $producto["TipoArticuloDetalle"]=="SITUO" || $producto["TipoArticuloDetalle"]=="DOMOTICA" || $producto["TipoArticuloDetalle"]=="glystro" || $TipoArticuloDetalle == "movelite" || $TipoArticuloDetalle["TipoArticuloDetalle"] == "irismo" || $producto["TipoArticuloDetalle"] == "gabin" || $producto["TipoArticuloDetalle"] == "forest") {
						$PorcentajeDescuentoCortinero = GenerarPorcentajeCortineroMotorizado($PorcentajeDescuento);
					} else {
						$PorcentajeDescuentoCortinero = $PorcentajeDescuento;
					}

					$precioControl=$producto["precio"];
					$importe = ($precioControl - GenerarCantidadFinal($PorcentajeDescuento,$precioControl,1,$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]))* $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'N', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $producto["nombre"],
						'PrecioUnit'=> $precioControl, 'Descuento' => $PorcentajeDescuento,'importe'=> $importe, 'numKit' => $numKit), 
						array('%s','%s', '%s','%s', '%s','%s', '%s','%s','%s'));
						
		
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S', 'numKit' => $numKit), 
												array('%s','%s','%s'));
				}

			}// Termina foreach($carro as $producto){
		}

		$ModificacionCotizacion = FALSE;
		$error_num="";
		$DescuentoAplicado = $carrito->precio_total() - $SubtotalDescCortinero;
		
		if (!isset($_POST['DireccionCarrito']))
		{
			if (update('cotizacion',array('ID_CLIENTE'=>$idCliente,'SUBTOTAL' => $SubtotalDescCortinero,'IVA'=>number_format($IvaTotalCortinero, 2, '.', ''),
											'IMPORTEUNITARIO'=> $carrito->precio_total(),
											'DESCUENTO'=>$DescuentoAplicado,'TOTAL'=>number_format($TotalCortinero, 2, '.', ''), 'ESTATUS' => "1",'FolioCotizacion'=>$IdCotizacion,'CALLE'=>$n_calle,
											'NUMERO'=>$n_numero,'LOCALIDAD'=>$n_localidad,'TELEFONO'=>$n_telefono,'REFERENCIAS'=>$n_referencias,'ATENCION'=>$n_atencion,
											'CONTACTO'=>$n_contacto,'SUCURSAL'=>$n_sucursal,'COLONIA'=>$n_colonia, 'CP'=>$n_cp,'ESTADOD'=>$n_estado,'HORA'=>$n_hora,
											'CIUDAD'=>$n_ciudad), 
			array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'),
			array('ID_COTIZACION'=>$Folio,'ID_USUARIO_ALTA'=>$_SESSION['login_user']), array('%d','%d')))
			{
				$ModificacionCotizacion = TRUE;
				$error_num.="No";
				delete('cotizacion_detalle','ID_COTIZACION',$Folio);
			}else{
				$error_num.="1";
			}
		}
		else
		{
			//***** Validar que lo que se quiere actualizar no sea igual a lo que ya esta guardado en bdd
			$query = "SELECT ID_CLIENTE, SUBTOTAL, IVA, IMPORTEUNITARIO, DESCUENTO, TOTAL, ESTATUS
				 	  FROM cotizacion
				 	  WHERE ID_COTIZACION = " . $Folio . " AND ID_USUARIO_ALTA = " . $_SESSION['login_user'] . ";";

			$result = mysqli_query($GLOBALS["db"], $query);
			
			if (mysqli_num_rows($result) > 0)
			{
			    while ($row = mysqli_fetch_assoc($result))
			    {
					if (
						$idCliente == $row["ID_CLIENTE"] &&
						//$SubtotalDescCortinero == $row["SUBTOTAL"] &&
						number_format($SubtotalDescCortinero, 2, '.', '') == number_format($row["SUBTOTAL"], 2, '.', '') &&
						number_format($IvaTotalCortinero, 2, '.', '') == number_format($row["IVA"], 2, '.', '') &&
						number_format($carrito->precio_total(), 2, '.', '') == number_format($row["IMPORTEUNITARIO"], 2, '.', '') &&
						number_format($DescuentoAplicado, 2, '.', '') == number_format($row["DESCUENTO"], 2, '.', '') &&
						number_format($TotalCortinero, 2, '.', '') == number_format($row["TOTAL"], 2, '.', '') &&
						"1" == $row["ESTATUS"]
					)
					{
						$ModificacionCotizacion = TRUE;
						$error_num.="N1";
						delete('cotizacion_detalle','ID_COTIZACION',$Folio);
					}else{
						$error_num.="2";
					}
			    }
			}
		    //***** Validar que lo que se quiere actualizar no sea igual a lo que ya esta guardado en bdd

			if (
				update('cotizacion',
					array(
						'ID_CLIENTE' => $idCliente,
						'SUBTOTAL' => $SubtotalDescCortinero,
						'IVA' => number_format($IvaTotalCortinero, 2, '.', ''),
						'IMPORTEUNITARIO' => $carrito->precio_total(),
						'DESCUENTO' => $DescuentoAplicado,
						'TOTAL' => number_format($TotalCortinero, 2, '.', ''),
						'ESTATUS' => "1"
					),
					array('%s', '%s', '%s', '%s', '%s', '%s', '%s'),
					array(
						'ID_COTIZACION' => $Folio,
						'ID_USUARIO_ALTA' => $_SESSION['login_user']
					),
					array('%d','%d')
				)
			)
			{
				$ModificacionCotizacion = TRUE;
				$error_num.="N2";
				delete('cotizacion_detalle','ID_COTIZACION',$Folio);
			}else{
				$error_num.="3";
			}
		}
		
		if ($ModificacionCotizacion==TRUE) 
		{
			foreach($carro as $producto)
			{
				insert('cotizacion_detalle',array('ID_COTIZACION'	=> $Folio,
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
												  'HOJAIZQUIERDA'   => $producto["hojaizquierda"],
												  'HOJADERECHA'     => $producto["hojaderecha"],
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
												  'COLORCINTA'      => $producto["colorCinta"],
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
												  'PRECIOCURVA'   => isset($producto["precioCurva"]) && $producto["precioCurva"] <> "" ? $producto["precioCurva"] : null
										  		  ),
											array('%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
			}// Termina foreach($carro as $producto)
		}else{
			$error_num.="5";
		}
	}

	if ($ModificacionCotizacion and $ModificacionCotizacion)
	{
		echo "Cotizacion modificada correctamente";
		$_SESSION['folio']=null;
		$_SESSION['IdCliente']=null;
		$_SESSION['NombreCliente']=null; 
		$carrito->destroy();
		?>

		<script type="text/javascript">
			alert('Modificado correctamente');
			window.location.href = 'index.php?opcion=linea';
		</script>

		<?php
	}
	else
	{
		echo "Hubo un problema al guardar los datos favor de reportarlo. (x".$error_num.")";
	}
?>
