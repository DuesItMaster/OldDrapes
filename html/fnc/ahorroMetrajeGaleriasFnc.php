<?php 
		//set_time_limit(10);
		include_once '../clases/Carrito.class.php';

			function cmp($a, $b) { return strcasecmp($a["area"], $b["area"]); }

		//En el carrito las galerías sin forro guardan "N/A" o "" en campos de precio/metraje; en PHP 8 operar con ellos lanza TypeError
		function valorNumericoGaleria($valor){
			return is_numeric($valor) ? (float)$valor : 0;
		}

		//Precio de una galería del carrito con el metraje de tela indicado (todas sus piezas)
		function PrecioGaleriaCarrito($producto, $metrajeTela){
			$precioMo = valorNumericoGaleria($producto["PrecioMo"]) * valorNumericoGaleria($producto["MetrajeMo"]);
			$precioCopete = ($producto["CodigoCopete"] <> "N/A") ? $precioMo * 0.5 : 0;
			$precioMoForro = ($producto["CodigoTelaForro"] <> "N/A") ? $precioMo * 0.5 : 0;

			return (valorNumericoGaleria($producto["PrecioTela"]) * valorNumericoGaleria($metrajeTela)) + $precioMo
				 + (valorNumericoGaleria($producto["PrecioTelaForro"]) * valorNumericoGaleria($producto["MetrajeForro"]))
				 + (valorNumericoGaleria($producto["PrecioEscuadras"]) * valorNumericoGaleria($producto["TotalEscuadras"]))
				 + $precioCopete + $precioMoForro;
		}

		function VerificarAhorroTela(){
			$carrito = new Carrito();
			$carro = $carrito->get_content();
			$retorno = "";

			if($carro){
				usort($carro, "cmp");

				
				$x = 0;

				foreach($carro as $producto){ 
					$cancelarOrigen = 0;
					$cancelarRelacionado = 0;

					$relacionadoEncontrado = false;	
					$aplicaProducto = 0;

					if($producto["tipoarticulo"] == "galeria" && $producto["MetrajeReal"] <> $producto["MetrajeGaleria"]){
						$aplicaProducto = 1;

						if($producto["AplicaAprov"] == "NO" ||  $producto["cantidad"] <> 1){
							//Si ya no aplica el producto origen para el ahorro de tela; Cancelar ahorro del origen y relacionado.
							$cancelarOrigen = 1;
							$cancelarRelacionado = 1;

							//$retorno = $retorno." Vuelta".$x." No toma al origen para el aprovechamiento"." Galeria: ".$producto["MetrajeGaleria"]." Real: ".$producto["MetrajeReal"]." Aplica:".$producto["AplicaAprov"].$producto["cantidad"];
						}
					}

					$relacionadoEncontrado = false;
					if($aplicaProducto == 1){
						foreach($carro as $producto2){ 
							if($producto2["id"] == $producto["ConsecAprov"]){
								$relacionadoEncontrado = true;
								$productoRelacionado = $producto2;

								if(($producto2["AplicaAprov"] == "NO" ||  $producto2["cantidad"] <> 1 || $producto2["CodigoTela"] <> $producto["CodigoTela"])){
									//Si ya no aplica el producto origen para el ahorro de tela; Cancelar ahorro del origen y relacionado.
									$cancelarOrigen = 1;
									$cancelarRelacionado = 1;

									///$retorno = $retorno." Vuelta ".$x." No toma al DESTINO para el aprovechamiento"." Galeria: ".$producto2["MetrajeGaleria"]." Real: ".$producto2["MetrajeReal"]." Aplica:".$producto2["AplicaAprov"].$producto2["cantidad"];
								}
							}
						}

						if($relacionadoEncontrado == false){
							$cancelarOrigen = 1;
							//$retorno = $retorno." Vuelta".$x.": No encuentra relacionado";
						}


						if($cancelarOrigen == 1){
							//Cambiar precio (Sin ahorro), relacionado y Metraje Galería al real 

							$metrajeOrigen = $producto["MetrajeReal"];

							$precioOrigen = PrecioGaleriaCarrito($producto, $metrajeOrigen);

							$precioOrigen	= $precioOrigen / $producto["cantidad"];


							$relacionadoOrigen = "N/A";
							$retorno = $retorno."Metraje Origen".$metrajeOrigen." Precio Origen".$precioOrigen;
						}

						//si el relacionado ya no está en el carrito no hay nada que recalcular (y su cantidad vacía daría división entre cero)
						if($cancelarRelacionado == 1 && $relacionadoEncontrado){
							$metrajeRelacionado = $productoRelacionado["MetrajeReal"];

							$precioRelacionado = PrecioGaleriaCarrito($productoRelacionado, $metrajeRelacionado);

							$precioRelacionado = $precioRelacionado / $productoRelacionado["cantidad"];


							$relacionadoRelacionado = "N/A";
							$retorno = $retorno."Metraje Relacionado".$metrajeRelacionado." Precio Relacionado".$precioRelacionado."Metraje Relacionado: ".$metrajeRelacionado."Precio Tela Relacionado: ".$productoRelacionado["PrecioTela"];

						}

						if($cancelarOrigen == 0 && $cancelarRelacionado == 0){
							if($producto["MetrajeReal"] > $productoRelacionado["MetrajeReal"]){
								$metrajeGaleria = $producto["MetrajeReal"];
							}else{
								$metrajeGaleria = $productoRelacionado["MetrajeReal"];
							}

							$metrajeOrigen = $metrajeGaleria / 2;
							$metrajeRelacionado = $metrajeGaleria / 2;
							//Calcular origen
							$precioOrigen = PrecioGaleriaCarrito($producto, $metrajeOrigen);
							//Calcular Relacionado
							$precioRelacionado = PrecioGaleriaCarrito($productoRelacionado, $metrajeRelacionado);

							$retorno = $retorno." Metraje Relacionado:".$metrajeRelacionado." Metraje MO: ".$productoRelacionado["MetrajeMo"]."  Metraje Forro: ".$productoRelacionado["MetrajeForro"]." Total Escuadras ".$productoRelacionado["TotalEscuadras"]." Copete: ".$productoRelacionado["CodigoCopete"]." Precio Tela: ".$productoRelacionado["PrecioTela"]." Precio Mo:".$productoRelacionado["PrecioMo"]." Precio Tela Forro".$productoRelacionado["PrecioTelaForro"]." Precio Escuadras: ".$productoRelacionado["PrecioEscuadras"]." Precio Relacionado: ".$precioRelacionado;

							$retorno = $retorno." Real Origen: ".$producto["MetrajeReal"]."Real Relacionado:".$productoRelacionado["MetrajeReal"];

							$relacionadoOrigen = $productoRelacionado["id"];
							$relacionadoRelacionado = $producto["id"];
							//$retorno = $retorno." Metraje Galeria: ".$producto["MetrajeReal"];
						}

						$x = $x + 1;

						$retorno = $retorno." Vuelta: ".$x." Cancelar Origen: ".$cancelarOrigen." Cancelar Relacionad: ".$cancelarRelacionado;

						$articulo = array(
										"id"				=>		$producto["id"],
										"cantidad"			=>		$producto["cantidad"],
										"precio"			=>		$precioOrigen,
										"nombre"			=>		$producto["nombre"],
										"tipoarticulo"		=>		$producto["tipoarticulo"],
										"ruta"				=>		$producto["ruta"],
										"ancho"				=>		$producto["ancho"],
										"codigo"			=>		$producto["codigo"],
										"alto"				=>		$producto["alto"],
										"tipocortina"		=>		$producto["tipocortina"],
										"fijacion"			=>		$producto["fijacion"],
										"acoplamiento"		=>		$producto["acoplamiento"],
										"tela"				=>		$producto["tela"],
										"color"				=>		$producto["color"],
										"gancho"			=>		$producto["gancho"],
										"bajoplomo"			=>		$producto["bajoplomo"],
										"stiffener"			=>		$producto["stiffener"],
										"neverlight"		=>		$producto["neverlight"],
										"telaForro"			=>      $producto["telaForro"],
										"PrecioTela"		=>		$producto["PrecioTela"],
										"CodigoTela"		=>		$producto["CodigoTela"],
										"Metraje"			=>		$producto["Metraje"],
										"ColorForro"		=>		$producto["ColorForro"],
										"PrecioFinalForro"	=>		$producto["PrecioFinalForro"],
										"CodigoTelaForro"	=>		$producto["CodigoTelaForro"],
										"CodigoMoForro"		=>		$producto["CodigoMoForro"],
										"PrecioTelaForro"	=>		$producto["PrecioTelaForro"],
										"PrecioMoForro"		=>		$producto["PrecioMoForro"],
										"CodigoMo"			=>		$producto["CodigoMo"],
										"PrecioMo"			=>		$producto["PrecioMo"],									
										"MetrajeMo"			=>		$producto["MetrajeMo"],
										"MetrajeForro"		=>		$producto["MetrajeForro"],
										"MetrajeMoForro"	=>		$producto["MetrajeMoForro"],
										"CodigoStiffener"	=>		$producto["CodigoStiffener"],
										"PrecioStiffener"	=>		$producto["PrecioStiffener"],
										"TipoArticuloDetalle"=>		$producto["TipoArticuloDetalle"],
										"area"              =>		$producto["area"],

										"CodigoBajoPlomo"	=>		$producto["CodigoBajoPlomo"],
										"PrecioPlomo"		=>		$producto["PrecioPlomo"],
										"MetrajeBajoPlomo"	=> 		$producto["MetrajeBajoPlomo"],
										
										"cantidadHojas" 	=>      $producto["cantidadHojas"],
										"control"       	=>      $producto["control"],
										"decorativo"    	=>      $producto["decorativo"],
										"peso"          	=>      $producto["peso"],
										"remate"        	=>      $producto["remate"],
										"resultadoSistema"  	=>      $producto["resultadoSistema"],
										"soporte"       	=>      $producto["soporte"],
										"argolla"       	=>      $producto["argolla"],
										"baston"        	=>      $producto["baston"],
										"colorBaston"   	=>      $producto["colorBaston"],
										"radioMedida"   	=>      $producto["radioMedida"],
										"radioMaterial" 	=>      $producto["radioMaterial"],
										"cantBaston"        =>      $producto["cantBaston"],
										"codigoBaston"      =>      $producto["codigoBaston"],
										"precioBaston"      =>      $producto["precioBaston"],
										"cantidadBastonFija"    =>		0,
										
										"proyecciones"  	=>      $producto["proyecciones"],
										"copete"        	=>      $producto["copete"],
										"MetrajeGaleria"	=>		$metrajeOrigen,
										"medidaProyeccion"=>		$producto["medidaProyeccion"],
										"MLManoObra" => $producto["MLManoObra"],
										"TotalEscuadras" => $producto["TotalEscuadras"],
										"CodigoMoForro" => $producto["CodigoMoForro"],
										"CodigoCopete" => $producto["CodigoCopete"],
										"CodigoEscuadras" => $producto["CodigoEscuadras"],
										"PrecioEscuadras" => $producto["PrecioEscuadras"],
										"AnchoTela" => $producto["AnchoTela"],
										"AprovTela" => $producto["AprovTela"],
										"AplicaAprov" => $producto["AplicaAprov"],
										"ConsecAprov" => $relacionadoOrigen,
										"Varilla" => $producto["Varilla"],
										"MetrajeReal" => $producto["MetrajeReal"],

										"CodigoMecanismo"	=> 		$producto["CodigoMecanismo"],
										"PrecioMecanismo"	=> 		$producto["PrecioMecanismo"],
										
										"controlMot"		=>		$producto["controlMot"],
										"precioControl"		=>		$producto["precioControl"],
										"codigoControl"		=>		$producto["codigoControl"],
										"nombreControl"		=>		$producto["nombreControl"],
										"tipoControlMot"	=>		$producto["tipoControlMot"],
										"idDrapesNombre"	=>		$producto["idDrapesNombre"]									
										);

						$carrito->addNoSuma($articulo);


						if($relacionadoEncontrado){

							$articulo2 = array(
										"id"				=>		$productoRelacionado["id"],
										"cantidad"			=>		$productoRelacionado["cantidad"],
										"precio"			=>		$precioRelacionado,
										"nombre"			=>		$productoRelacionado["nombre"],
										"tipoarticulo"		=>		$productoRelacionado["tipoarticulo"],
										"ruta"				=>		$productoRelacionado["ruta"],
										"ancho"				=>		$productoRelacionado["ancho"],
										"codigo"			=>		$productoRelacionado["codigo"],
										"alto"				=>		$productoRelacionado["alto"],
										"tipocortina"		=>		$productoRelacionado["tipocortina"],
										"fijacion"			=>		$productoRelacionado["fijacion"],
										"acoplamiento"		=>		$productoRelacionado["acoplamiento"],
										"tela"				=>		$productoRelacionado["tela"],
										"color"				=>		$productoRelacionado["color"],
										"gancho"			=>		$productoRelacionado["gancho"],
										"bajoplomo"			=>		$productoRelacionado["bajoplomo"],
										"stiffener"			=>		$productoRelacionado["stiffener"],
										"neverlight"		=>		$productoRelacionado["neverlight"],
										"telaForro"			=>      $productoRelacionado["telaForro"],
										"PrecioTela"		=>		$productoRelacionado["PrecioTela"],
										"CodigoTela"		=>		$productoRelacionado["CodigoTela"],
										"Metraje"			=>		$productoRelacionado["Metraje"],
										"ColorForro"		=>		$productoRelacionado["ColorForro"],
										"PrecioFinalForro"	=>		$productoRelacionado["PrecioFinalForro"],
										"CodigoTelaForro"	=>		$productoRelacionado["CodigoTelaForro"],
										"CodigoMoForro"		=>		$productoRelacionado["CodigoMoForro"],
										"PrecioTelaForro"	=>		$productoRelacionado["PrecioTelaForro"],
										"PrecioMoForro"		=>		$productoRelacionado["PrecioMoForro"],
										"CodigoMo"			=>		$productoRelacionado["CodigoMo"],
										"PrecioMo"			=>		$productoRelacionado["PrecioMo"],									
										"MetrajeMo"			=>		$productoRelacionado["MetrajeMo"],
										"MetrajeForro"		=>		$productoRelacionado["MetrajeForro"],
										"MetrajeMoForro"	=>		$productoRelacionado["MetrajeMoForro"],
										"CodigoStiffener"	=>		$productoRelacionado["CodigoStiffener"],
										"PrecioStiffener"	=>		$productoRelacionado["PrecioStiffener"],
										"TipoArticuloDetalle"=>		$productoRelacionado["TipoArticuloDetalle"],
										"area"              =>		$productoRelacionado["area"],

										"CodigoBajoPlomo"	=>		$productoRelacionado["CodigoBajoPlomo"],
										"PrecioPlomo"		=>		$productoRelacionado["PrecioPlomo"],
										"MetrajeBajoPlomo"	=> 		$productoRelacionado["MetrajeBajoPlomo"],
										
										"cantidadHojas" 	=>      $productoRelacionado["cantidadHojas"],
										"control"       	=>      $productoRelacionado["control"],
										"decorativo"    	=>      $productoRelacionado["decorativo"],
										"peso"          	=>      $productoRelacionado["peso"],
										"remate"        	=>      $productoRelacionado["remate"],
									"resultadoSistema"  	=>      $productoRelacionado["resultadoSistema"],
										"soporte"       	=>      $productoRelacionado["soporte"],
										"argolla"       	=>      $productoRelacionado["argolla"],
										"baston"        	=>      $productoRelacionado["baston"],
										"colorBaston"   	=>      $productoRelacionado["colorBaston"],
										"radioMedida"   	=>      $productoRelacionado["radioMedida"],
										"radioMaterial" 	=>      $productoRelacionado["radioMaterial"],
										"cantBaston"        =>      $productoRelacionado["cantBaston"],
										"codigoBaston"      =>      $productoRelacionado["codigoBaston"],
										"precioBaston"      =>      $productoRelacionado["precioBaston"],
										"cantidadBastonFija"    =>		0,
										
										"proyecciones"  	=>      $productoRelacionado["proyecciones"],
										"copete"        	=>      $productoRelacionado["copete"],
										"MetrajeGaleria"	=>		$metrajeRelacionado,
										"medidaProyeccion"=>		$productoRelacionado["medidaProyeccion"],
										"MLManoObra" => $productoRelacionado["MLManoObra"],
										"TotalEscuadras" => $productoRelacionado["TotalEscuadras"],
										"CodigoMoForro" => $productoRelacionado["CodigoMoForro"],
										"CodigoCopete" => $productoRelacionado["CodigoCopete"],
										"CodigoEscuadras" => $productoRelacionado["CodigoEscuadras"],
										"PrecioEscuadras" => $productoRelacionado["PrecioEscuadras"],
										"AnchoTela" => $productoRelacionado["AnchoTela"],
										"AprovTela" => $productoRelacionado["AprovTela"],
										"AplicaAprov" => $productoRelacionado["AplicaAprov"],
										"ConsecAprov" => $relacionadoRelacionado,
										"Varilla" => $productoRelacionado["Varilla"],
										"MetrajeReal" => $productoRelacionado["MetrajeReal"],

										"CodigoMecanismo"	=> 		$productoRelacionado["CodigoMecanismo"],
										"PrecioMecanismo"	=> 		$productoRelacionado["PrecioMecanismo"],
										
										"controlMot"		=>		$productoRelacionado["controlMot"],
										"precioControl"		=>		$productoRelacionado["precioControl"],
										"codigoControl"		=>		$productoRelacionado["codigoControl"],
										"nombreControl"		=>		$productoRelacionado["nombreControl"],
										"tipoControlMot"	=>		$productoRelacionado["tipoControlMot"],
										"idDrapesNombre"	=>		$productoRelacionado["idDrapesNombre"]									
										);

									$carrito->addNoSuma($articulo2);

						}

					}//Final if aplica
				
				}//Fin For


				return $retorno;
			}
		}
	

		//$carrito = new Carrito();


		//$carro = $carrito->get_content();
			
		//if($carro){ 
				
			//foreach($carro as $producto){ 

				//$relacionadoEncontrado = false;	

				//if($producto["tipoarticulo"] == "galeria" && $producto["MetrajeReal"] <> $producto["MetrajeGaleria"]){
					/*if($producto["AplicaAprov"] == "NO" ||  $producto["Cantidad"] <> 1){
						//Si ya no aplica el producto origen para el ahorro de tela; Cancelar ahorro del origen y relacionado.
						$cancelarOrigen = true;
						$cancelarRelacionado = true;
					}

					$relacionadoEncontrado = false;*/

					/*foreach($carro as $producto2){ 
						if($producto2["id"] == $producto["ConsecAprov"]){
							$relacionadoEncontrado = true;
							$productoRelacionado = $producto2;

							if(($producto2["AplicaAprov"] == "NO" ||  $producto2["Cantidad"] <> 1 || $producto2["CodigoTela"] <> $producto["CodigoTela"])){
								//Si ya no aplica el producto origen para el ahorro de tela; Cancelar ahorro del origen y relacionado.
								$cancelarOrigen = true;
								$cancelarRelacionado = true;
							}
						}
						
					}*/

					/*if($relacionadoEncontrado == false ){
						$cancelarOrigen = true;
					}

					if($cancelarOrigen == true){
						$ahorroPrecio = ($producto["MetrajeReal"] - $producto["MetrajeGaleria"]) * $producto["PrecioTela"];
						$precioOrigen = $producto["precio"] + $ahorroPrecio;
						$metrajeOrigen = $producto["MetrajeReal"];
					}

					if($cancelarRelacionado == true){
						$ahorroPrecio = ($productoRelacionado["MetrajeReal"] - $productoRelacionado["MetrajeGaleria"]) * $productoRelacionado["PrecioTela"];
						$precioRelacionado = $productoRelacionado["precio"] + $ahorroPrecio;
						$metrajeRelacionado = $productoRelacionado["MetrajeReal"];
					}

					if($cancelarOrigen == false && $cancelarRelacionado == false){
						if($producto["MetrajeGaleria"] > $productoRelacionado["MetrajeGaleria"]){
							$metrajeGaleria = $productoRelacionado["MetrajeGaleria"];
						}else{
							$metrajeGaleria = $productoRelacionado["MetrajeGaleria"];
						}

						$metrajeOrigen = $metrajeGaleria / 2;
						$metrajeRelacionado = $metrajeGaleria / 2;

						$precioOrigen = 50;
						$precioRelacionado = 100;
					}*/
 /*
					$articulo = array(
									"id"				=>		$producto["id"],
									"cantidad"			=>		$producto["cantidad"],
									"precio"			=>		$precioTotalOrigen,
									"nombre"			=>		$producto["nombre"],
									"tipoarticulo"		=>		$producto["tipoarticulo"],
									"ruta"				=>		$producto["ruta"],
									"ancho"				=>		$producto["ancho"],
									"codigo"			=>		$producto["codigo"],
									"alto"				=>		$producto["alto"],
									"tipocortina"		=>		$producto["tipocortina"],
									"fijacion"			=>		$producto["fijacion"],
									"acoplamiento"		=>		$producto["acoplamiento"],
									"tela"				=>		$producto["tela"],
									"color"				=>		$producto["color"],
									"gancho"			=>		$producto["gancho"],
									"bajoplomo"			=>		$producto["bajoplomo"],
									"stiffener"			=>		$producto["stiffener"],
									"neverlight"		=>		$producto["neverlight"],
									"telaForro"			=>      $producto["telaForro"],
									"PrecioTela"		=>		$producto["PrecioTela"],
									"CodigoTela"		=>		$producto["CodigoTela"],
									"Metraje"			=>		$producto["Metraje"],
									"ColorForro"		=>		$producto["ColorForro"],
									"PrecioFinalForro"	=>		$producto["PrecioFinalForro"],
									"CodigoTelaForro"	=>		$producto["CodigoTelaForro"],
									"CodigoMoForro"		=>		$producto["CodigoMoForro"],
									"PrecioTelaForro"	=>		$producto["PrecioTelaForro"],
									"PrecioMoForro"		=>		$producto["PrecioMoForro"],
									"CodigoMo"			=>		$producto["CodigoMo"],
									"PrecioMo"			=>		$producto["PrecioMo"],									
									"MetrajeMo"			=>		$producto["MetrajeMo"],
									"MetrajeForro"		=>		$producto["MetrajeForro"],
									"MetrajeMoForro"	=>		$producto["MetrajeMoForro"],
									"CodigoStiffener"	=>		$producto["CodigoStiffener"],
									"PrecioStiffener"	=>		$producto["PrecioStiffener"],
									"TipoArticuloDetalle"=>		$producto["TipoArticuloDetalle"],
									"area"              =>		$producto["area"],

									"CodigoBajoPlomo"	=>		$producto["CodigoBajoPlomo"],
									"PrecioPlomo"		=>		$producto["PrecioPlomo"],
									"MetrajeBajoPlomo"	=> 		$producto["MetrajeBajoPlomo"],
									
									"cantidadHojas" 	=>      $producto["cantidadHojas"],
									"control"       	=>      $producto["control"],
									"decorativo"    	=>      $producto["decorativo"],
									"peso"          	=>      $producto["peso"],
									"remate"        	=>      $producto["remate"],
									"resultadoSistema"  	=>      $producto["resultadoSistema"],
									"soporte"       	=>      $producto["soporte"],
									"argolla"       	=>      $producto["argolla"],
									"baston"        	=>      $producto["baston"],
									"colorBaston"   	=>      $producto["colorBaston"],
									"radioMedida"   	=>      $producto["radioMedida"],
									"radioMaterial" 	=>      $producto["radioMaterial"],
									"cantBaston"        =>      $producto["cantBaston"],
									"codigoBaston"      =>      $producto["codigoBaston"],
									"precioBaston"      =>      $producto["precioBaston"],
									"cantidadBastonFija"    =>		0,
									
									"proyecciones"  	=>      $producto["proyecciones"],
									"copete"        	=>      $producto["copete"],
									"MetrajeGaleria"	=>		$metrajeOrigen,

									"CodigoMecanismo"	=> 		$producto["CodigoMecanismo"],
									"PrecioMecanismo"	=> 		$producto["PrecioMecanismo"],
									
									"controlMot"		=>		$producto["controlMot"],
									"precioControl"		=>		$producto["precioControl"],
									"codigoControl"		=>		$producto["codigoControl"],
									"nombreControl"		=>		$producto["nombreControl"],
									"tipoControlMot"	=>		$producto["tipoControlMot"],
									"idDrapesNombre"	=>		$producto["idDrapesNombre"]									
									);

					$carrito->add($articulo);

					if($relacionadoEncontrado){
						$articulo2 = array(
									"id"				=>		$productoRelacionado["id"],
									"cantidad"			=>		$productoRelacionado["cantidad"],
									"precio"			=>		$precioRelacionado,
									"nombre"			=>		$productoRelacionado["nombre"],
									"tipoarticulo"		=>		$productoRelacionado["tipoarticulo"],
									"ruta"				=>		$productoRelacionado["ruta"],
									"ancho"				=>		$productoRelacionado["ancho"],
									"codigo"			=>		$productoRelacionado["codigo"],
									"alto"				=>		$productoRelacionado["alto"],
									"tipocortina"		=>		$productoRelacionado["tipocortina"],
									"fijacion"			=>		$productoRelacionado["fijacion"],
									"acoplamiento"		=>		$productoRelacionado["acoplamiento"],
									"tela"				=>		$productoRelacionado["tela"],
									"color"				=>		$productoRelacionado["color"],
									"gancho"			=>		$productoRelacionado["gancho"],
									"bajoplomo"			=>		$productoRelacionado["bajoplomo"],
									"stiffener"			=>		$productoRelacionado["stiffener"],
									"neverlight"		=>		$productoRelacionado["neverlight"],
									"telaForro"			=>      $productoRelacionado["telaForro"],
									"PrecioTela"		=>		$productoRelacionado["PrecioTela"],
									"CodigoTela"		=>		$productoRelacionado["CodigoTela"],
									"Metraje"			=>		$productoRelacionado["Metraje"],
									"ColorForro"		=>		$productoRelacionado["ColorForro"],
									"PrecioFinalForro"	=>		$productoRelacionado["PrecioFinalForro"],
									"CodigoTelaForro"	=>		$productoRelacionado["CodigoTelaForro"],
									"CodigoMoForro"		=>		$productoRelacionado["CodigoMoForro"],
									"PrecioTelaForro"	=>		$productoRelacionado["PrecioTelaForro"],
									"PrecioMoForro"		=>		$productoRelacionado["PrecioMoForro"],
									"CodigoMo"			=>		$productoRelacionado["CodigoMo"],
									"PrecioMo"			=>		$productoRelacionado["PrecioMo"],									
									"MetrajeMo"			=>		$productoRelacionado["MetrajeMo"],
									"MetrajeForro"		=>		$productoRelacionado["MetrajeForro"],
									"MetrajeMoForro"	=>		$productoRelacionado["MetrajeMoForro"],
									"CodigoStiffener"	=>		$productoRelacionado["CodigoStiffener"],
									"PrecioStiffener"	=>		$productoRelacionado["PrecioStiffener"],
									"TipoArticuloDetalle"=>		$productoRelacionado["TipoArticuloDetalle"],
									"area"              =>		$productoRelacionado["area"],

									"CodigoBajoPlomo"	=>		$productoRelacionado["CodigoBajoPlomo"],
									"PrecioPlomo"		=>		$productoRelacionado["PrecioPlomo"],
									"MetrajeBajoPlomo"	=> 		$productoRelacionado["MetrajeBajoPlomo"],
									
									"cantidadHojas" 	=>      $productoRelacionado["cantidadHojas"],
									"control"       	=>      $productoRelacionado["control"],
									"decorativo"    	=>      $productoRelacionado["decorativo"],
									"peso"          	=>      $productoRelacionado["peso"],
									"remate"        	=>      $productoRelacionado["remate"],
								"resultadoSistema"  	=>      $productoRelacionado["resultadoSistema"],
									"soporte"       	=>      $productoRelacionado["soporte"],
									"argolla"       	=>      $productoRelacionado["argolla"],
									"baston"        	=>      $productoRelacionado["baston"],
									"colorBaston"   	=>      $productoRelacionado["colorBaston"],
									"radioMedida"   	=>      $productoRelacionado["radioMedida"],
									"radioMaterial" 	=>      $productoRelacionado["radioMaterial"],
									"cantBaston"        =>      $productoRelacionado["cantBaston"],
									"codigoBaston"      =>      $productoRelacionado["codigoBaston"],
									"precioBaston"      =>      $productoRelacionado["precioBaston"],
									"cantidadBastonFija"    =>		0,
									
									"proyecciones"  	=>      $productoRelacionado["proyecciones"],
									"copete"        	=>      $productoRelacionado["copete"],
									"MetrajeGaleria"	=>		$metrajeRelacionado,

									"CodigoMecanismo"	=> 		$productoRelacionado["CodigoMecanismo"],
									"PrecioMecanismo"	=> 		$productoRelacionado["PrecioMecanismo"],
									
									"controlMot"		=>		$productoRelacionado["controlMot"],
									"precioControl"		=>		$productoRelacionado["precioControl"],
									"codigoControl"		=>		$productoRelacionado["codigoControl"],
									"nombreControl"		=>		$productoRelacionado["nombreControl"],
									"tipoControlMot"	=>		$productoRelacionado["tipoControlMot"],
									"idDrapesNombre"	=>		$productoRelacionado["idDrapesNombre"]									
									);

								$carrito->add($articulo2);*/
					//}
				//}
			//}
		//}

	
?>