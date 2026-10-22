<?php
	include_once '../clases/Carrito.class.php';
	require_once '../fnc/terminarIva.php';
	require_once '../fnc/terminarDescuento.php';
	require_once 'DemoUIMessages.php';
	include_once '../fnc/comprobacionInsumos.php';
	
	session_start();
	$carrito = new Carrito();
	$carro = $carrito->get_content();
	

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
	
	//$EjemploTotalBorrardespues = SacarTotalesCortineroMotorizado();

?>

	<div id="order-detail-content" class="table_block table-responsive">
		<table id="cart_summary" class="table table-bordered stock-management-on">
			<thead>
				<tr>
					<th class="cart_delete last_item">&nbsp;</th>
					<th class="cart_quantity item text-center">Cantidad</th>
					<th class="cart_product first_item">Producto</th>
					<th class="cart_description item">Descripción</th>
					<th class="cart_avail item text-center">Precio Unitario</th>
					<th class="cart_unit item text-right">Descuento</th>
					<th class="cart_total item text-right">Total</th>
				</tr>
			</thead>
			
			<tbody>
			<?php if($carro) { 
				
				function cmp($a, $b) { return strcasecmp($a["area"], $b["area"]); }
				usort($carro, "cmp");
					
				foreach($carro as $producto) { ?>
				<!---<tr id="product_6_31_0_20" class="cart_item first_item address_20 odd" >
					<td class="cart_delete text-center" data-title="Delete" colspan="7">
						<pre><?php //var_dump($producto); ?></pre>
					</td>
				</tr> Pendiente para cuando haya proyecto de actualizar carrito
				<?php 
					//$item = $carrito->get_item($producto["unique_id"]);
				?>
				<tr id="product_6_31_0_20" class="cart_item first_item address_20 odd" >
					<td class="cart_delete text-center" data-title="Delete" colspan="7">
						Find
						<pre><?php //var_dump($item); ?></pre>
					</td>
				</tr>-->
				<tr id="product_6_31_0_20" class="cart_item first_item address_20 odd" >
					<td class="cart_delete text-center" data-title="Delete">
						<div>
							<a rel="nofollow" title="Eliminar" class="cart_quantity_delete" id="6_31_0_20" onclick="Eliminar('<?php echo $producto["unique_id"]; ?>',0,'<?php echo $producto["nombre"]; ?>')"><i class="icon-trash"></i></a>
						</div>
					</td>
					<td class="cart_quantity text-center">			
						<input type="hidden" value="2" name="quantity_6_31_0_20_hidden">
						<input size="2" type="text" autocomplete="off" class="cart_quantity_input form-control grey" value="<?php echo $producto["cantidad"]; ?>" name="quantity_6_31_0_20" readonly>
						<div class="cart_quantity_button clearfix">
							<a rel="nofollow" class="cart_quantity_down btn btn-default button-minus" id="cart_quantity_down_6_31_0_20"  title="Eliminar" onclick="Suprimir('<?php echo $producto["id"]; ?>')">
								<span><i class="icon-minus"></i></span>
							</a>
					        <a rel="nofollow" class="cart_quantity_up btn btn-default button-plus" id="cart_quantity_up_6_31_0_20" title="Agregar" onclick="Agregar('<?php echo $producto["id"]; ?>')">
					        	<span><i class="icon-plus"></i></span>
					        </a>
						</div>
					</td>
					<td class="cart_product">
						<?php
							switch ($producto["tipoarticulo"]) {
							    case "cortina":
							        $ruta = "index.php?opcion=ccotizar&opc=".$producto["TipoArticuloDetalle"]."&i=".$producto["id"];
							        break;
							    
							    case "cortinero":
								    $ruta = "index.php?opcion=c" . $producto["TipoArticuloDetalle"] . "&i=" . $producto["id"];
							        break;
							   
							    case "pacheto":
							      	$ruta = "index.php?opcion=cpacheto&i=".$producto["id"];
							        break;

							    case "romana":
							      	$ruta = "index.php?opcion=cromana&i=".$producto["id"];
							        break;

							    case "galeria":
							      	$ruta = "index.php?opcion=cgaleria&i=".$producto["id"];
							        break;

								case "DOMOTICA":
									$ruta = "index.php?opcion=c" . $producto["tipoarticulo"]. "&i=" . $producto["id"];
									break;

								case "SITUO":
									$ruta = "index.php?opcion=ccontroles&i=" . $producto["id"];
									break;

								case "CONTROL PARED":
									$ruta = "index.php?opcion=ccontroles&i=" . $producto["id"];
									break;
							}
						?>
						<a href='<?php echo $ruta; ?>'>
							<img src="<?php echo $producto["ruta"]; ?>" alt="" width="98" height="98">
						</a>
					</td>
					<td class="cart_description">
						<p class="product-name">
						<!--SUGERENCIAS-->		
						<?php 
							if ($producto["tipoarticulo"]=="cortina") {
								$a="aa";
								echo '<a id="toast-action" onClick="a(\''.$producto["unique_id"].'\');" style="cursor:pointer;cursor:click">';
								echo $producto["nombre"] . " Tela " .  $producto["tela"] . " Med: " .number_format($producto["ancho"],2, '.', ', ')
								                                             /*$producto["ancho"]*/ . " x " .number_format($producto["alto"],2, '.', ', ') /*$producto["alto"]*/ . " mts";	
								echo "<br>Ver cortineros recomendados <span class='fa fa-plus-square-o'></span>";
									echo "<input type='hidden' id='".$producto["unique_id"]."' value='".$producto["TipoArticuloDetalle"]."'>";												
									echo " <br>";
								echo "</a>";
							} else if($producto["tipoarticulo"]=="romana" or $producto["tipoarticulo"]=="pacheto"){
							 	echo "<a>".$producto["nombre"]." Med. " . $producto["ancho"] . " x " . $producto["alto"] . " ";	
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
								echo 'Espacio: <b>'.$producto["area"] .'</b>, Tela: '.$producto["tela"].', Color: '.$producto["color"].',<br>
									 '.$producto["ancho"].' ancho x '.$producto["alto"].' alto, Acoplamiento: '.$producto["acoplamiento"].', Fijación: '.$producto["fijacion"].
									 ', Accesorios : '.$producto["stiffener"].' '.$producto["neverlight"].' '.$producto["bajoplomo"].' '.$producto["gancho"].'';

								if ($estatusCotizacion <> 4)   echo '<div id="notastock">'.stock($producto["CodigoTela"],$producto["Metraje"],$producto["cantidad"]).'</div>'; 

								if (isset($producto["ColorForro"])){
									echo "<br> Forro: ". $producto["telaForro"] . ", Color Forro: " . $producto["ColorForro"];
									if ($estatusCotizacion <> 4)  echo '<div id="notastockforro">'.stock($producto["CodigoTelaForro"],$producto["MetrajeForro"],$producto["cantidad"]).'</div>';	
								}
							} 
							if ($producto["tipoarticulo"]=="cortinero"){
								// hola soy espacio para cortinero!! :D wiii 													
								echo 'Espacio: <b>'.$producto["area"] . '</b>, Color: '.$producto["color"].', Ancho: '.$producto["ancho"].' m, Fijacion: '.$producto["fijacion"].
								     ', Control: '.$producto["control"]. ', Soporte: '.$producto["soporte"].',<br> Remate: '.$producto["remate"].', Hojas: '.$producto["cantidadHojas"].
								     ', Sistema: '.$producto["resultadoSistema"].', Argolla: '.$producto["argolla"]. ' ';
								      
							  	if($producto["baston"]=="true"){
								      	$baston="SI";
										echo '<br>Baston: '.$baston.', Cantidad: '.$producto["cantBaston"].', Color baston: '.$producto["colorBaston"].', Medida del baston: '.$producto["radioMedida"].', Material del baston: '.$producto["radioMaterial"];
								}
								if($producto["controlMot"]=="true"){
									$controlMot="SI";
								  echo '<br>Control Cortinero: '.$controlMot.', '.$producto["nombreControl"];
						  		}
								if($producto["peso"]!="0"){
							  		echo ', Carga maxima: '.$producto["peso"];
							  	}
							} 

							if ($producto["tipoarticulo"]=="pacheto"){

							 	echo 'Espacio: '.$producto["area"] . ' Tela: '.$producto["tela"].', Color : '.$producto["color"].',<br>
							 		 '.$producto["ancho"].' ancho x '.$producto["alto"].' alto. ';
							
							} if ($producto["tipoarticulo"]=="romana"){

							 	echo 'Espacio: '.$producto["area"] . ' Tela: '.$producto["tela"].', Color: '.$producto["color"].',<br>
							 		 '.$producto["ancho"].' ancho x '.$producto["alto"].' alto. ';

							 	if (isset($producto["ColorForro"])){
									echo "<br> Tela Forro: ". $producto["telaForro"] . ", Color Forro: " . $producto["ColorForro"];	
								}
							}

							if ($producto["tipoarticulo"]=="galeria"){
								/*if($producto["copete"]=="true"){
									$cop="SI";
								}else if($producto["copete"]=="false")  {$cop="NO";}*/
							 	echo 'Espacio: '.$producto["area"] .' Tela: '.$producto["tela"].', Color: '.$producto["color"].
							 	     ', Ancho: '.$producto["ancho"].', Copete: '.$producto["copete"].',<br> proyecciones: '.$producto["proyecciones"].
							 		 ', Fijación: '.$producto["fijacion"];
							}
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
						<span class="price" id="total_product_price_6_31_20">
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
			<tfoot>
				<tr class="cart_total_price">
					<td rowspan="3" colspan="2" id="cart_voucher" class="cart_voucher">
					</td>
					<td colspan="3" class="text-right">Subtotal</td>
					<td colspan="2" class="price" id="total_product">$ <?php echo number_format($SumTotalArticulo, 2, '.', ', '); ?></td>
				</tr>
				
				<tr style="display: none;">
					<td colspan="3" class="text-right">
																
					</td>
					<td colspan="2" class="price-discount price" id="total_wrapping">
						$0
					</td>
				</tr>
				<tr class="cart_total_delivery">
					<td colspan="3" class="text-right">Iva</td>
					<?php $IvaTotal = ($SumTotalArticulo * ($iva/100)); ?>
					<td colspan="2" class="price" id="total_shipping">$ <?php  echo number_format($IvaTotal, 2, '.', ', '); ?></td>
				</tr>
				
				<tr class="cart_total_price">
					<td colspan="3" class="total_price_container text-right">
						<span>Total</span>
					</td>
					<td colspan="2" class="price" id="total_price_container">
						<?php $Total = $SumTotalArticulo+$IvaTotal; ?>
						<span id="total_price">$ <?php echo number_format($Total, 2, '.', ', ') ; ?></span>
					</td>
				</tr>
			</tfoot>
		</table>						
	</div> <!-- end order-detail-content -->	
<div id="resultado" style="display:none;"></div>				
<!--<script src="../../assets/js/core/demo/DemoUIMessages.php"></script>    antes de pasarlo a php esta en require -->


