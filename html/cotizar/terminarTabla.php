<?php
	include_once '../clases/Carrito.class.php';
	require_once '../fnc/terminarIva.php';
	require_once '../fnc/terminarDescuento.php';
	require_once 'DemoUIMessages.php';
	include_once '../fnc/comprobacionInsumos.php';
	session_start();
	$carrito = new Carrito();
	$carro = $carrito->get_content();
	$PorcentajeDescuentoVAR = 0;
	if (!isset($_SESSION['folio'])){
		$iva = TraerIva();
		$DescuentoProducto = TraerDescuento($_SESSION['login_user']);
		$TotalPorcentaje =  GenerarPorcentaje();
	}
	else{
		$iva = TraerIvaPorId($_SESSION['folio']);
		$DescuentoProducto = TraerDescuentoPorID($_SESSION['folio']);
		$TotalPorcentaje =  GenerarPorcentajePorId($_SESSION['folio']);
	}
	echo "<input type='hidden' id='numArticulos' value='" . $carrito->articulos_total() . "'>";
?>
	<link type="text/css" rel="stylesheet" href="../../assets/css/theme-default/libs/toastr/toastr.css?1425466569" />
	
	<div id="order-detail-content" class="table_block table-responsive">
		<?php 
			if(isset($_POST["Folio"])){
		?>
			<h1 id="cart_title" class="page-heading">Cotización: <?php echo $_POST["Folio"]; ?>. Cliente: <?php echo $_POST["Cliente"]; ?></h1>
		<?php
			}else{
		?>
			<h1 id="cart_title" class="page-heading">Cotización <?php echo $_POST["Cotizacion"]; ?></h1>
		<?php
			}
		?>
		<table id="cart_summary" class="table table-bordered stock-management-on">
			<thead>
				<tr>
					<th class="cart_quantity item text-center">&nbsp;</th>
					<th class="cart_product first_item">&nbsp;</th>
					<th class="cart_description item"></th>
					<th class="cart_avail item text-center">Precio Unitario</th>
					<th class="cart_unit item text-right">Descuento</th>
					<th class="cart_total item text-right">Total</th>
				</tr>
			</thead>
			<tbody>
			<?php if($carro) { 
				
				function cmp($a, $b) { 
					return strcasecmp($a["area"], $b["area"]); 
				}
				usort($carro, "cmp");
				foreach($carro as $producto) { ?>
				<tr id="product_6_31_0_20" class="cart_item first_item address_20 odd" >
					<td class="cart_delete text-center" data-title="Delete">
						<div>
							<a rel="nofollow" title="Eliminar" class="cart_quantity_delete" id="6_31_0_20" onclick="Eliminar('<?php echo $producto['unique_id']; ?>',0,'<?php echo $producto['nombre']; ?>')"><span><img class= "color "src="../../assets/img/x.png" alt=""> Borrar</span></a>
						</div>	
						<input type="hidden" value="2" name="quantity_6_31_0_20_hidden">
						<div class="cart_quantity_button clearfix">
					        <a rel="nofollow" class="cart_quantity_up btn btn-default button-plus" id="cart_quantity_up_6_31_0_20" title="Agregar" onclick="Agregar('<?php echo $producto['unique_id']; ?>')">
					        	<span><i>+</i></span>
					        </a>
							<input size="2" type="text" autocomplete="off" class="cart_quantity_input form-control grey" value="<?php echo $producto["cantidad"]; ?>" name="quantity_6_31_0_20" readonly>
							<a rel="nofollow" class="cart_quantity_down btn btn-default button-minus" id="cart_quantity_down_6_31_0_20"  title="Eliminar" onclick="Suprimir('<?php echo $producto['unique_id']; ?>')">
								<span><i>-</i></span>
							</a>
						</div>
					</td>
					<td class="cart_product">
						<?php
							switch ($producto["tipoarticulo"]) {
							    case "cortina":
							        $ruta = "index.php?opcion=ccotizar&opc=".$producto["TipoArticuloDetalle"]."&i=".$producto["id"];
									$ruta_img_small = "../../assets/img/colores/small/".$producto["tela"]."/".$producto["color"].".jpg";
							        break;
							    
							    case "cortinero":
								    $ruta = "index.php?opcion=c" . $producto["TipoArticuloDetalle"] . "&i=" . $producto["id"];
									$ruta_img_small = $producto["ruta"];
							        break;
							   
							    case "pacheto":
							      	$ruta = "index.php?opcion=cpacheto&i=".$producto["id"];
									$ruta_img_small = $producto["ruta"];
							        break;

							    case "romana":
							      	$ruta = "index.php?opcion=cromana&i=".$producto["id"];
									  $ruta_img_small = $producto["ruta"];
							        break;

							    case "galeria":
							      	$ruta = "index.php?opcion=cgaleria&i=".$producto["id"];
									$ruta_img_small = $producto["ruta"];
							        break;

								case "DOMOTICA":
									$ruta = "index.php?opcion=cDOMOTICA&i=". $producto["unique_id"];
									$ruta_img_small = $producto["ruta"];
									// if(str_contains($producto["ruta"], 'INTEO STATION'))
									// 	$producto["ruta"] = str_replace("%body%", "black", $producto["ruta"]);
									break;

								case "SITUO":
									$ruta = "index.php?opcion=ccontroles&i=" . $producto["id"];
									$ruta_img_small = $producto["ruta"];
									break;

								case "CONTROL PARED":
									$ruta = "index.php?opcion=ccontroles&i=" . $producto["id"];
									$ruta_img_small = $producto["ruta"];
									break;
							}
						?>
						<a href='<?php echo $ruta; ?>'>
							<img class="tela" src="<?php echo $producto["ruta"]; ?>" alt="">
							<img class= "color "src="<?php echo $ruta_img_small; ?>" alt="">
						</a>
					</td>
					<td class="cart_description">
						<p class="product-name">
						<!--SUGERENCIAS-->		
						<?php 
							if ($producto["tipoarticulo"]=="cortina") {
								$a="aa";
								echo $producto["nombre"];	
								echo '<a id="toast-action" onClick="a(\''.$producto["unique_id"].'\');" style="cursor:pointer;cursor:click">';
								echo "<br>Ver cortineros recomendados <span class='fa fa-plus-square-o'></span>";
									echo "<input type='hidden' id='".$producto["unique_id"]."' value='".$producto["TipoArticuloDetalle"]."'>";												
									echo " <br>";
								echo "</a>";
							} else if($producto["tipoarticulo"]=="romana" or $producto["tipoarticulo"]=="pacheto"){
							 	echo "<a>".$producto["nombre"]."</a>";	
							} else if($producto["tipoarticulo"]=="DOMOTICA" || $producto["tipoarticulo"]=="SITUO" || $producto["tipoarticulo"]=="CONTROL PARED") {
								echo "<a>". "CONTROL " .$producto["nombre"]." </a><br><span>Espacio: " .$producto["area"].  "</span>";
							}
								else{echo "<a>".$producto["nombre"]." Med. " . $producto["ancho"]. "</a>";}
						?>												
						</p>
						
						<script>
							function a(valor){
								//alert(valor);
								tpl = $("#"+valor+"").val();
							    $.post("DemoUIMessages.php", {tpl:tpl, id_unico:valor}, function(data){
							    $("#resultado").html(data);
							    //$("#resultado").show();
				    			});
						    }
						</script>

						<p class="cart_ref">
						<?php
						

						//echo "Tipo: " . $producto["tipoarticulo"] . " Detalle: " . $producto["TipoArticuloDetalle"]. " <br>";
						if ($producto["tipoarticulo"]=="cortina"){
							//ECHO "TIPO ARTICULO DETALLE ".$producto["TipoArticuloDetalle"] . " ";
							echo 'ESPACIO: '.$producto["area"] .'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; TELA: '.$producto["tela"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; COLOR: '.$producto["color"].'<br>
								MEDIDAS: '.$producto["ancho"].' ANCHO x '.$producto["alto"].' ALTO<br> 
								Acoplamiento: '.$producto["acoplamiento"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Fijación: '.$producto["fijacion"]. '<br>
								Accesorios : '.$producto["stiffener"].' '.$producto["neverlight"].' '.$producto["bajoplomo"].' '.$producto["gancho"].'';

							$cortinaIrregularActiva = isset($producto["cortinairregular"]) && $producto["cortinairregular"] != "0" && $producto["cortinairregular"] != 0 && trim((string)$producto["cortinairregular"]) !== "";
							if ($cortinaIrregularActiva && isset($producto["hojaizquierda"]) && isset($producto["hojaderecha"]) && trim((string)$producto["hojaizquierda"]) !== "" && trim((string)$producto["hojaderecha"]) !== "") {
								echo "<br> Cortina Irregular: Izq.- " . $producto["hojaizquierda"] . " Der.- " . $producto["hojaderecha"];
							} else {
								echo "";
							}
							
							// Imprimir el valor de colorCinta en pantalla
							if (
								!isset($producto["colorCinta"]) ||
								$producto["colorCinta"] == "0" ||
								$producto["colorCinta"] == ""
							) {
								//SI NO ESTA SETEADO EL COLOR DE CINTA, SI ESTA EN 0 O SI LLEGA COMO
								//STRING VACIO, MANDAMOS UN ECHO SIN NADA 
								//echo "<br> Color Cinta Ripplefold: " . N/A" FALLBACK DESCARTADO XD
								echo "<br>";
							} else {
								echo "<br> Color Cinta Ripplefold: " . $producto["colorCinta"];
							}

							if(isset($producto["colorOjillo"]) && trim($producto["colorOjillo"]) != ""){
								echo "<br> Color Ojillo: " . $producto["colorOjillo"];
							}
							
							if ($estatusCotizacion <> 4)   echo '<div id="notastock">'.stock($producto["CodigoTela"],$producto["Metraje"],$producto["cantidad"]).'</div>'; 

							if (!empty(trim($producto["telaForro"])) && !empty(trim($producto["ColorForro"]))){
								echo "<br> Forro: ". $producto["telaForro"] . ", Color Forro: " . $producto["ColorForro"];
								if ($estatusCotizacion <> 4)  echo '<div id="notastockforro">'.stock($producto["CodigoTelaForro"],$producto["MetrajeForro"],$producto["cantidad"]).'</div>';    
							}
							} 
							if ($producto["tipoarticulo"]=="cortinero"){
								// hola soy espacio para cortinero!! :D wiii 	nmms güero nos trajiste a Italia?												
								echo 'ESPACIO: '.$producto["area"] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; COLOR: '.$producto["color"].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ANCHO: '.$producto["ancho"].' m&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; FIJACION: '.$producto["fijacion"].
								     ', Control: '.$producto["control"]. ', Soporte: '.$producto["soporte"].',<br> Remate: '.$producto["remate"].', Hojas: '.$producto["cantidadHojas"].
								     ', Sistema: '.$producto["resultadoSistema"].', Argolla: '.$producto["argolla"]. ' ';
								      
								if(isset($producto["lado_motor"]) && ($producto["TipoArticuloDetalle"] == "glystro" || $producto["TipoArticuloDetalle"] == "movelite" || $producto["TipoArticuloDetalle"] == "irismo" || $producto["TipoArticuloDetalle"] == "forest" || $producto["TipoArticuloDetalle"] == "elatio" || $producto["TipoArticuloDetalle"] == "cs")){
									echo ', Lado Motor: ' .$producto["lado_motor"] .' ';
								}
								
							  	if($producto["baston"]=="true"){
								      	$baston="SI";
										echo '<br>Baston: '.$baston.', Cantidad: '.$producto["cantBaston"].', Color baston: '.$producto["colorBaston"].', Medida del baston: '.$producto["radioMedida"].', Material del baston: '.$producto["radioMaterial"];
								}
								if($producto["controlMot"]=="true"){
									$controlMot="SI";
								  echo '<br>Control Cortinero: '.$controlMot.', '.$producto["nombreControl"];
						  		}
								if((float)$producto["peso"] > 0){
							  		// La carga llega como "60" o "60.000" (desde BD); se muestra como 60KG
									$cargaMaxima = rtrim(rtrim(number_format((float)$producto["peso"], 3, '.', ''), '0'), '.');
									echo ', Carga maxima: '.$cargaMaxima.'KG';
							  	}
								if($producto["cantidadCodos"]!="0" && $producto["cantidadCodos"]!=""){
									echo ', Cantidad Codos: '.$producto["cantidadCodos"];
								}else{
									echo ' , Cantidad Codos: N/A';
								}
								if(isset($producto["curvoRecto"]) && $producto["TipoArticuloDetalle"] == "glystro"){
									if($producto["curvoRecto"] == "CODO90"){
										echo ', Curva a 90°: SI';
									}elseif($producto["curvoRecto"] == "PERSONALIZADA"){
										echo ', Curva Personalizada: SI';
									}
								}
								// Servicio de la curva (SERVICIO-CURV-KS o DT-CODO-GLYDEA90°), cantidad total como en Cotizacion_Det.
								// No se muestra en la cotizacion guardada (con folio)
								if(!isset($_SESSION['folio']) && !empty($producto["codigoCurva"]) && (float)$producto["cantidadCurva"] > 0){
									$cantidadCurvaTotal = (float)$producto["cantidadCurva"] * (float)$producto["cantidad"];
									echo '<br>Servicio de curva: '.$producto["codigoCurva"].', Cantidad: '.rtrim(rtrim(number_format($cantidadCurvaTotal, 2, '.', ''), '0'), '.');
								}
								if($produto["cantidadCodos"] >="1"){
									echo ', Cantidad de codos: '.$producto["cantidadCodos"];
								}
								if(isset($producto["resultadoSoporte"]) && $producto["resultadoSoporte"] <> "" && $producto["TipoArticuloDetalle"] == "elatio"){
									echo ', Soporte: '.$producto["resultadoSoporte"];
								}
							} 

							if ($producto["tipoarticulo"]=="pacheto"){

							 	echo 'Espacio: '.$producto["area"] . ' Tela: '.$producto["tela"].', Color : '.$producto["color"].',<br>
							 		 '.$producto["ancho"].' ancho x '.$producto["alto"].' alto. ';
							
							} 
							
							if ($producto["tipoarticulo"]=="romana"){
								echo 'ESPACIO: '.$producto["area"] . '<br>';
								echo 'TELA: '.$producto["tela"] . '<br>';
								echo 'COLOR: '.$producto["color"] . '<br>';
								echo 'MEDIDAS: '.$producto["ancho"].' ANCHO x '.$producto["alto"].' ALTO<br>';
								
								// Mostrar los datos específicos de romana si existen
								if(!empty($producto["fijacion"])) {
									echo 'FIJACIÓN: '.$producto["fijacion"] . '<br>';
								}
								$__varilla = (isset($producto["Varilla"]) && strtoupper(trim($producto["Varilla"])) === "SI") ? "SI" : "NO";
								echo 'VARILLA: '.$__varilla . '<br>';
								if(!empty($producto["hojas"])) {
									echo 'HOJAS: '.$producto["hojas"] . '<br>';
								}
								if(!empty($producto["lado_cordon"])) {
									echo 'LADO CORDÓN: '.$producto["lado_cordon"] . '<br>';
								}
								
								

								// Mostrar forro solo si ambos tienen valor real (no vacíos ni solo espacios)
								if(!empty(trim($producto["telaForro"])) && !empty(trim($producto["ColorForro"]))) {
									echo 'TELA FORRO: '.$producto["telaForro"] . '<br>';
									echo 'COLOR FORRO: '.$producto["ColorForro"] . '<br>';
								}

							 	//if (isset($producto["ColorForro"])){
								//	echo "<br> Tela Forro: ". $producto["telaForro"] . ", Color Forro: " . $producto["ColorForro"];	
								//}
							}

							if ($producto["tipoarticulo"]=="galeria"){
								if($producto["proyecciones"] <> "N/A"){
									$medidaProy = ", Medida Proyección: ".$producto["medidaProyeccion"];
								}else{
									$medidaProy = "";
								}

								if($producto["fijacion"]=="Muro"){
									if($producto["proyecciones"] <> "N/A"){
										$cop="<br>";
									}else{
										$cop=", ";
									}

									$cop=$cop."Copete: SI, Medida Copete: ".$producto["copete"];
								}else{
									$cop=", Copete: N/A";
								}
							 	echo 'Espacio: '.$producto["area"] .' Tela: '.$producto["tela"].', Color: '.$producto["color"].', Fijación: '.$producto["fijacion"].
							 	     ',<br> Ancho: '.$producto["ancho"].', Alto: '.$producto["alto"].', Proyección: '.$producto["proyecciones"].$medidaProy.$cop;
							}

						/*	if ($producto["tipoarticulo"]=="romana"){
							echo 'Espacio: '.$producto["area"] . ' Tela: '.$producto["tela"].', Color: '.$producto["color"].',<br>
								'.$producto["ancho"].' ancho x '.$producto["alto"].' alto. ';
							
							 	if (!empty(trim($producto["telaForro"])) && !empty(trim($producto["ColorForro"]))){
									echo "<br> Tela Forro: ". $producto["telaForro"] . ", Color Forro: " . $producto["ColorForro"];	
								}
							
							// Agregar información específica de persiana romana
							if (isset($producto["Varilla"]) && $producto["Varilla"] == "SI"){
								echo "<br> Con varilla";
							}
							if (isset($producto["hojas"]) && $producto["hojas"] != ""){
								echo "<br> Pliegues: ".$producto["hojas"];
							}
							if (isset($producto["lado_cordon"]) && $producto["lado_cordon"] != ""){
								echo "<br> Lado del cordón: ".$producto["lado_cordon"];
							}
							if (isset($producto["fijacion"]) && $producto["fijacion"] != ""){
								echo "<br> Fijación: ".$producto["fijacion"];
							}
						}*/
						?>
						</p>		
					</td>
					<td class="cart_unit" data-title="Precio Unit">
						<ul class="price text-right" id="product_price_6_31_20">
				            <li class="price"><?php echo "$ " . number_format($producto["precio"], 2, '.', ', ');?></li>
						</ul>
					</td>
					<td class="cart_unit" data-title="Desc">
						<ul class="price text-right" id="product_price_5_19_20">
			            	<!--<li class="price special-price">$35</li>-->
						   	<li class="price-percent-reduction small">
								<?php 
									if (count($DescuentoProducto) > 0)
									{
										if ($producto["tipoarticulo"] == "cortinero" && ($producto["TipoArticuloDetalle"] == "glystro" || $producto["TipoArticuloDetalle"] == "movelite" || $producto["TipoArticuloDetalle"] == "irismo" || $producto["TipoArticuloDetalle"] == "gabin" || $producto["TipoArticuloDetalle"] == "forest")) 
										{
											echo "&nbsp;-" . GenerarPorcentajeCortineroMotorizado($TotalPorcentaje) . "% &nbsp;";
										} 
										elseif($producto["tipoarticulo"] == "DOMOTICA" || $producto["tipoarticulo"] == "SITUO"|| $producto["tipoarticulo"] == "CONTROL PARED"){
											echo "&nbsp;-" . GenerarPorcentajeCortineroMotorizado($TotalPorcentaje) . "% &nbsp;";
										}
										else 
										{
											foreach ($DescuentoProducto as $Desc) 
											{
												echo "&nbsp;-" . $Desc . "% &nbsp;";
											}
										}
									}
									else
									{
										echo "0%";
									}
								?>
	           			    </li>
							<li class="price special-price">$ 
								<?php 
									$valor = GenerarCantidadFinal($TotalPorcentaje,$producto["precio"],$producto["cantidad"],$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]);
									//echo " Tipo Art " . $producto["tipoarticulo"]. " ".$producto["TipoArticuloDetalle"];
									echo  number_format($valor,2, '.', ', ');
								 ?>
							</li>
						</ul>
					</td>
					<td class="cart_total" data-title="Total">
						<span class="price" idf="total_product_price_6_31_20">
							<?php 
								$TotalArticulo = ($producto["cantidad"] * $producto["precio"])-$valor;
								echo "$ ". number_format($TotalArticulo, 2, '.', ', ') ;
								$SumTotalArticulo = $SumTotalArticulo + $TotalArticulo;
							?>									
						</span>
					</td>
				</tr>
			<?php  
				} 
			}  
			?>
			</tbody>
		</table>		
		<p class="cart_navigation clearfix">
			<?php
				if(isset($_POST["Folio"])){
			?>
				<a href="index.php?opcion=linea" id="seguir" title="Continuar" class="button btn btn-default standard-checkout button-medium" style="float:left; line-height:27px;">Agregar Productos</a>
			<?php
				}else{
			?>
				<a href="index.php?opcion=linea" id="seguir" title="Continuar" class="button btn btn-default standard-checkout button-medium" style="float:left; line-height:27px;">Seguir Cotizando</a>
			<?php
				}
			?>
		</p>					
	</div>
	<div class="totales">
		<div class="cantidades_container">
			<div class="cart_total_price">
				<label rowspan="3" colspan="2" id="cart_voucher" class="cart_voucher"></label>
				<label colspan="3" class="text-right">Subtotal</label>
				<label colspan="2" class="price" id="total_product">$ <?php echo number_format($SumTotalArticulo, 2, '.', ', '); ?></label>
			</div>
			<div style="display: none;">
				<label colspan="3" class="text-right"></label>
				<label colspan="2" class="price-discount price" id="total_wrapping">
					$0
				</label>
			</div>
			<div class="cart_total_delivery">
				<label colspan="3" class="text-right">Iva</label>
				<?php $IvaTotal = ($SumTotalArticulo * ($iva/100)); ?>
				<label colspan="2" class="price" id="total_shipping">$ <?php  echo number_format($IvaTotal, 2, '.', ', '); ?></label>
			</div>
			<div class="separador"></div>
			<div class="cart_total_price">
				<label colspan="3" class="total_price_container text-right">Total</label>
				<label colspan="2" class="price" id="total_price_container">
					<?php $Total = $SumTotalArticulo+$IvaTotal; ?>
					<span id="total_price">$ <?php echo number_format($Total, 2, '.', ', ') ; ?></span>
				</label>
			</div>

		<?php if ( ($estatus == 1 or $estatus ==3) and $IdUsuarioAlta==$_SESSION['login_user']) { ?>
		<p class="cart_navigation clearfix">
			<a  class="button btn btn-default standard-checkout button-medium" onclick="Guardar()" title="Terminar" style="">
				<span>Guardar<i class="icon-save right"></i></span>
			</a>
		</p>
		<?php } ?>

		<?php 
			if(isset($_SESSION['folio'])){ 
				if ( ($_SESSION['estatus'] == 1 or $_SESSION['estatus'] == 3) and $_SESSION['IdUsuarioAlta']==$_SESSION['login_user']) {
		?>
				<div id="HOOK_SHOPPING_CART"></div>
				<p class="cart_navigation clearfix">
					<a id="guardar" class="button btn btn-default standard-checkout button-medium" onclick="Guardar()" title="Terminar" style="">Guardar</a>
				</p>
		<?php  
				}
			}else { 
		?>
			<div id="HOOK_SHOPPING_CART"></div>
			<p class="cart_navigation clearfix">
				<a id="siguiente" class="button btn btn-default standard-checkout button-medium" title="Terminar" style="">Siguiente</a>
			</p>
		<?php  } ?>
		</div>
		<div class="datos_oportunidad">
		<?php
			if($_POST["usuarioDues"] == 1 or $_POST["usuarioDues"] == 0) {
				echo "<br>Num. de Oportunidad: " . $_POST["Oportunidad"]."<br>";
				if ($_POST["Oportunidad"] == "No hay oportunidad asociada a esta cotizacion"){
				}else{
				echo '<span class="heading-counter" style="color: #f44336;float: none;"><a href="https://crm.zoho.com/crm/org722017379/tab/Potentials/'.trim($_POST["Oportunidad"]).'"target="_blank"><b>Ir a Oportunidad CRM</b></a></span><br>';
				}
				echo "<br>Ejecutivo Cotizador: ". $_POST["Ejecutivo_Cotizador"];
				echo '<div> Descargar excel: <b><a href="DescargarCotizacion.php?Nombre='.$_POST["Nombre"].'&op=1"><br>Version Cliente</a></b><br><b><a href="DescargarCotizacion.php?Nombre='.$_POST["Nombre"].'&op=2">Version Distribuidor</a></b></div>';
			}
		?>
		</div>
	</div>
<div id="resultado" style="display:none;"></div>			
<script type="text/javascript">
	$(function()
	{
		$("#siguiente").click(function()
		{
			if ($("#numArticulos").val() > 0)
			{
				window.location.href = "index.php?opcion=datos";
			}
			else
			{
				alert("Para continuar agregue articulos al carrito.");
			}
		});
	});					
</script>
<script src="../../assets/js/libs/toastr/toastr.js"></script>
