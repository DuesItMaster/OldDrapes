<?php

		include_once '../clases/Carrito.class.php';
		require_once '../fnc/terminarIva.php';
		require_once '../fnc/terminarDescuento.php';
		include_once '../../conexion/ins.php';
		include_once '../../conexion/cnx.php';

		if (isset($_POST['idcomo'])){
			$idcomo=$_POST['idcomo'];
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

			}
			else{

				//echo "<br>no es nuevo cliente<br>";

				$idCliente=$_POST['idCliente'];

			}
		}

		if (isset($_POST['AgregarDireccion'])){
			
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

			}
			elseif($_POST['DireccionCliente']=="SI"){

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

				}
				else{
					
					//DIRECCION DEL CLIENTE YA GUARDADO
					$idCliente=$_POST['idCliente'];
					$sql = "select CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,MUNICIPIO,
							TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,EMAIL,CP  
							from cliente where id_cliente =".$idCliente." and ID_USUARIO_ALTA=".$_SESSION['login_user'].";";

					//echo "Consulta cliente ya guardado: " . $sql;
					
					$result = mysqli_query($GLOBALS['db'], $sql);

					if (mysqli_num_rows($result) > 0) {
					    // output data of each row
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

			}else{

				//DIRECCION DEL DISTRIBUIDOR
				$sql = "select CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,CIUDAD,
						TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,/*EMAIL,*/CP,HORA  
						from usuario_direccion where ID_USUARIO =".$_SESSION['login_user']." AND ID =".$idcomo.";";

				//echo "Consulta" . $sql;
					
				$result = mysqli_query($GLOBALS['db'], $sql);

				if (mysqli_num_rows($result) > 0) {
					//echo "<BR> Si hay registros";
				    // output data of each row
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


		$DireccionFinal = $n_calle . " " .  $n_numero . " " . $n_colonia ." ". $n_localidad . ", " . $n_estado;

		$carrito = new Carrito();
		$carro = $carrito->get_content();


		if($carro) {

			$iva = TraerIva();

			//Descuento Precio Total

			//$Descuentot = GenerarDescuento($carrito->precio_total());
			//$Subtotal =  $carrito->precio_total() - $Descuentot;/*$carrito->precio_total() -*/

			//$IvaTotal =  ($Descuentot * ($iva/100));
			//$Total = $Descuentot + $IvaTotal;|
			//$PorcentajeDescuento = GenerarPorcentaje();


			$PorcentajeDescuento =  GenerarPorcentaje();
			$DescuentoPorcentaje = GenerarCantidadFinal($PorcentajeDescuento,$carrito->precio_total(),1);
			$Subtotal = $carrito->precio_total() - $DescuentoPorcentaje;
			$IvaTotal = ($Subtotal * ($iva/100));
			$Total =  $Subtotal + $IvaTotal;


			$IdCotizacion = insert('Cotizacion_Gen',array('NombreCte'=>$_SESSION['nombre_user'],
														  'CodigoCte'=>$_SESSION['sap'],
														  'Total' => $Subtotal,
														  'DirEntrega'=> $DireccionFinal,
														  'Atenciona'=> $n_atencion,
														  'Telefonos'=> $n_telefono,
														  'ImpDescto'=>'0',
										  				  'Subtotal'=>$Subtotal, 
										  				  'iva' => $IvaTotal,
										  				  'Descuento' => '0',
										  				  'ImpTotal' => $Total), 
													array( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
			// 'ImpDescto'=>$DescuentoPorcentaje,
			// 'Descuento' => $PorcentajeDescuento,
			//  'Total' => $carrito->precio_total(),

				
			foreach($carro as $producto){

				if ($producto["tipoarticulo"]=="cortina"){

					//Cortina General Descuento
					//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * 1;
					$Nombre = strtoupper ("Cortina " . utf8_decode($producto["nombre"]) . " en tela: " . $producto["tela"] . " color: " . $producto["color"] . " med: " . $producto["ancho"] . " x " . $producto["alto"]);
					$importe = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $Nombre ,
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

				
											
					//Tela
					//$Descuento = GenerarDescuento($producto["PrecioTela"]); $importe = $producto["PrecioTela"] - $Descuento;
					$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', ''); //$producto["Metraje"] * $producto["cantidad"]; //number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
					$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
					$PrecioTotalTelaFinal = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
													   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioTotalTelaFinal), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

									
					//Mano Obra
					//$Descuento = GenerarDescuento($producto["PrecioMo"]); $importe = $producto["PrecioTela"] - $Descuento;
					$PrecioTotalMo = ($producto["MetrajeMo"]* $producto["cantidad"]) *$producto["PrecioMo"];
					$TotalMo = $producto["MetrajeMo"] *  $producto["cantidad"];
					$PrecioFinalMo = ($PrecioTotalMo - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMo,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMo, 'Codigo'=> $producto["CodigoMo"], 'Descripcion' => 'Mano de Obra',
					    						  'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMo), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

				

					if (isset($producto["ColorForro"])){
					//Tela Forro
						$TotalMetraje = number_format($producto["MetrajeForro"] * $producto["cantidad"], 2, '.', '');//$producto["MetrajeForro"] * $producto["cantidad"];
						$PrecioTotalTela = $TotalMetraje * $producto["PrecioTelaForro"];
						$PrecioFinalMetraje = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1)) * 1;
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' =>$TotalMetraje , 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => $producto["telaForro"],
					    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMetraje), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
						

					//Mano Obra Forro
						$PrecioTotalMoForro = ($producto["MetrajeMoForro"]* $producto["cantidad"]) * $producto["PrecioMoForro"];
						$TotalMo = $producto["MetrajeMoForro"] *  $producto["cantidad"];
						$PrecioFinalMoForro = ($PrecioTotalMoForro - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalMoForro,1)) * 1;
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $TotalMo, 'Codigo'=> $producto["CodigoMoForro"], 'Descripcion' => 'Mano de Obra Forro',
					    						  	  'PrecioUnit'=> $producto["PrecioMoForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMoForro), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
						
					}

					//echo "CODIGO STIFFENER" . $producto["CodigoStiffener"] . "  PRECIO" . $producto["PrecioStiffener"]; 
					if (isset($producto["CodigoStiffener"])){

						$importeTotal = $producto["PrecioStiffener"] * $producto["cantidad"];
						$PrecioFinalStiffener = ($importeTotal - GenerarCantidadFinal($PorcentajeDescuento,$importeTotal,1)) * 1;
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoStiffener"], 'Descripcion' => "STIFFENER",
					    						  	  'PrecioUnit'=> $producto["PrecioStiffener"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalStiffener), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
					
					}

					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
												array('%s','%s'));
				
				}


				//CORTINEROS
				elseif ($producto["tipoarticulo"]=="cortinero"){
					//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
					if ($producto["baston"]=="true"){
						$PrecioBaston = (($producto["precio"]* $producto["cantidad"]) -  $producto["precioBaston"])/$producto["cantidad"];
						$importe = ($PrecioBaston - GenerarCantidadFinal($PorcentajeDescuento,$PrecioBaston,1))* $producto["cantidad"];
						
					}
					else{
						$PrecioBaston = $producto["precio"];
						$importe = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1))* $producto["cantidad"];
					}
					
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'N', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => $producto["nombre"],
					   						  	  'PrecioUnit'=> $PrecioBaston, 'Descuento' => $PorcentajeDescuento,'importe'=> $importe), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
					

					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
											array('%s','%s'));					


					if ($producto["baston"]=="true"){
						$precioBaston=$producto["precioBaston"]/$producto["cantBaston"];
						//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
						$importe = ($precioBaston - GenerarCantidadFinal($PorcentajeDescuento,$precioBaston,1))* $producto["cantBaston"];
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'N', 'Cantidad' => $producto["cantBaston"], 'Codigo'=> $producto["codigoBaston"], 'Descripcion' => "Baston",
						   						  	  'PrecioUnit'=> $precioBaston, 'Descuento' => $PorcentajeDescuento,'importe'=> $importe), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
						

						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
												array('%s','%s'));
					}
				}

				

				elseif ($producto["tipoarticulo"]=="pacheto"){

					//Cortina General
					//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * 1;
					$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => utf8_decode($producto["nombre"]),
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
					
											
					//Tela
					$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');
					$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
					$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
													   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalTela), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s')) ;

									
					//Mecanismo
					$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
					$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoMecanismo"], 'Descripcion' => 'Mecanismo Romana sin varilla',
					    						  'PrecioUnit'=> $producto["PrecioMecanismo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

					//, 'Cantidad' => $producto["cantidad"], '%s'
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
											array('%s','%s'));
					
				} elseif ($producto["tipoarticulo"]=="romana"){

					//Cortina General
					//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * 1;
					$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) *  $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 'Descripcion' => utf8_decode($producto["nombre"]),
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
					
											
					//Tela
					$TotalMetraje = number_format($producto["Metraje"] * $producto["cantidad"], 2, '.', '');//$producto["Metraje"] * $producto["cantidad"];
					$PrecioTotalTela = $TotalMetraje * $producto["PrecioTela"];
					$PrecioFinalTela = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 'Descripcion' => $producto["tela"],
													   'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalTela), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s')) ;

										
					//Mecanismo
					$TotalPrecioMecanismo = $producto["cantidad"] * $producto["PrecioMecanismo"];
					$PrecioFinalMecanismo = ($TotalPrecioMecanismo - GenerarCantidadFinal($PorcentajeDescuento,$TotalPrecioMecanismo,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoMecanismo"], 'Descripcion' => 'Mecanismo Romana',
					    						  'PrecioUnit'=> $producto["PrecioMecanismo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

					
					if (isset($producto["ColorForro"])){
						//Tela Forro
						$TotalMetraje = number_format($producto["MetrajeForro"] * $producto["cantidad"], 2, '.', '');//$producto["MetrajeForro"] * $producto["cantidad"];
						$PrecioTotalTela = $TotalMetraje * $producto["PrecioTelaForro"];
						$PrecioFinalMecanismo = ($PrecioTotalTela - GenerarCantidadFinal($PorcentajeDescuento,$PrecioTotalTela,1)) * 1;
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => $producto["telaForro"],
					    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMecanismo), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
					
					}

					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
											array('%s','%s'));

					

				}elseif ($producto["tipoarticulo"]=="galeria"){


					//Cortina General
					//$Descuento = GenerarDescuento($producto["precio"]); $importe = $producto["precio"] - $Descuento;
					$PrecioUnitC = ($producto["precio"] - GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * 1;
					$importe = ($producto["precio"] -  GenerarCantidadFinal($PorcentajeDescuento,$producto["precio"],1)) * $producto["cantidad"];
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'K', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["codigo"], 
													'Descripcion' => utf8_decode($producto["nombre"]),
												  'PrecioUnit'=> $PrecioUnitC, 'Descuento' => '0','importe'=> $importe), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

																
					//Tela
					$TotalMetraje = number_format($producto["MetrajeGaleria"] * $producto["cantidad"], 2, '.', ''); //$producto["cantidad"] * $producto["MetrajeGaleria"];
					$PrecioGaleria = $producto["PrecioTela"] * $TotalMetraje;
					$PrecioFinalGaleria = ($PrecioGaleria - GenerarCantidadFinal($PorcentajeDescuento,$PrecioGaleria,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'I', 'Cantidad' => $TotalMetraje, 'Codigo'=> $producto["CodigoTela"], 
												  'Descripcion' => $producto["tela"],
												  'PrecioUnit'=> $producto["PrecioTela"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalGaleria), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));

					
										
					//Mano Obra
					$PrecioMO = ($producto["PrecioMo"] * $producto["ancho"])*$producto["cantidad"];
					$CantidadTotal = $producto["ancho"] * $producto["cantidad"];
					$PrecioFinalMO = ($PrecioMO - GenerarCantidadFinal($PorcentajeDescuento,$PrecioMO,1)) * 1;
					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $CantidadTotal, 'Codigo'=> $producto["CodigoMo"], 
												  'Descripcion' => 'Mano de Obra',
					    						  'PrecioUnit'=> $producto["PrecioMo"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalMO), 
											array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));


				
					//Tela Forro

					if (isset($producto["ColorForro"])){

						$PrecioFinalForro = ( $producto["PrecioTelaForro"] - GenerarCantidadFinal($PorcentajeDescuento, $producto["PrecioTelaForro"],1)) * $producto["cantidad"];
						
						insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'IO', 'Cantidad' => $producto["cantidad"], 'Codigo'=> $producto["CodigoTelaForro"], 'Descripcion' => "MICROFIBRA",
					    						  	  'PrecioUnit'=> $producto["PrecioTelaForro"], 'Descuento' =>  $PorcentajeDescuento,'importe'=> $PrecioFinalForro), 
												array('%s','%s', '%s','%s', '%s','%s', '%s','%s'));
						
						
					}

					insert('Cotizacion_Det',array('FolioCotizacion'=>$IdCotizacion,'TipoLinea'=>'S'), 
												array('%s','%s'));

				}

			}// Termina foreach($carro as $producto){


			/*$PorcentajeDescuento =  GenerarPorcentaje();
			$DescuentoPorcentaje = GenerarCantidadFinal($PorcentajeDescuento,$carrito->precio_total(),1);
			$Subtotal = $carrito->precio_total() - $DescuentoPorcentaje;
			$IvaTotal = ($Subtotal * ($iva/100));
			$Total =  $Subtotal + $IvaTotal;*/

			//INSERTA EN COTIZACION LOS DATOS DEL ENVIO FINAL
			$IdCotizacionM = insert('cotizacion',array('ID_CLIENTE'=>$idCliente,'ID_USUARIO_ALTA'=>$_SESSION['login_user'],'SUBTOTAL' => $Subtotal,'IVA'=>$IvaTotal,
														'IMPORTEUNITARIO'=> $carrito->precio_total(),
														'DESCUENTO'=>$DescuentoPorcentaje,'TOTAL'=>$Total, 'ESTATUS' => "1",'FolioCotizacion'=>$IdCotizacion,'CALLE'=>$n_calle,
														'NUMERO'=>$n_numero,'LOCALIDAD'=>$n_localidad,'TELEFONO'=>$n_telefono,'REFERENCIAS'=>$n_referencias,'ATENCION'=>$n_atencion,
														'CONTACTO'=>$n_contacto,'SUCURSAL'=>$n_sucursal,'COLONIA'=>$n_colonia, 'CP'=>$n_cp,'ESTADOD'=>$n_estado,'HORA'=>$n_hora,
														'CIUDAD'=>$n_ciudad, 'MUNICIPIO'=>$n_ciudad), 
												 array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));

		

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
										  		  'METRAJEGALERIA'	=> $producto["MetrajeGaleria"]
										  		  ), 
											array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s',
												  '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'));
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
