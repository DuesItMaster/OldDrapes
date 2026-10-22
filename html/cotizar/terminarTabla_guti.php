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
<style><link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</style>
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

				// ============= PRECALCULAR STOCKS =============
$cacheStock = [];
foreach ($carro as $p) {
    $key = $p["CodigoTela"] . '_' . $p["Metraje"];
    if (!isset($cacheStock[$key])) {
        $cacheStock[$key] = stock($p["CodigoTela"], $p["Metraje"], $p["cantidad"]);
    }
}
// =============================================


				foreach($carro as $producto) { ?>
				<tr id="product_6_31_0_20" class="cart_item first_item address_20 odd" >
					<td class="cart_delete text-center" data-title="Delete">
						<div>
							<a rel="nofollow" title="Eliminar" class="cart_quantity_delete" id="6_31_0_20" onclick="Eliminar('<?php echo $producto['unique_id']; ?>',0,'<?php echo $producto['nombre']; ?>')"><span><img class= "color "src="../../assets/img/x.png" alt=""> Borrar</span></a>
						</div>	
						<input type="hidden" value="2" name="quantity_6_31_0_20_hidden">
						<div class="cart_quantity_button clearfix">
					        <a rel="nofollow" class="cart_quantity_up btn btn-default button-plus" id="cart_quantity_up_6_31_0_20" title="Agregar" onclick="Agregar('<?php echo $producto['id']; ?>')">
					        	<span><i>+</i></span>
					        </a>
							<input size="2" type="text" autocomplete="off" class="cart_quantity_input form-control grey" value="<?php echo $producto["cantidad"]; ?>" name="quantity_6_31_0_20" readonly>
							<a rel="nofollow" class="cart_quantity_down btn btn-default button-minus" id="cart_quantity_down_6_31_0_20"  title="Eliminar" onclick="Suprimir('<?php echo $producto['id']; ?>')">
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
									$ruta = "index.php?opcion=c" . $producto["tipoarticulo"]. "&i=" . $producto["id"];
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
				<td class="cart_description" style="text-align: left !important;">
    <?php
        switch ($producto["tipoarticulo"]) {

            // Lógica para ROMANA y PACHETO
            case "romana":
            case "pacheto":
                $detalleVarilla = (isset($producto["Varilla"]) && $producto["Varilla"] == "SI") ? " (con varilla)" : " (sin varilla)";
                echo '<p class="product-name"><b>' . htmlspecialchars($producto["nombre"]) . $detalleVarilla . '</b></p>';
                echo '<p class="cart_ref">';
                    echo '<b>Espacio:</b> ' . htmlspecialchars($producto["area"]) . '<br>';
                    echo '<b>Tela:</b> ' . htmlspecialchars($producto["tela"]) . ' (' . htmlspecialchars($producto["color"]) . ')<br>';
                    echo '<b>Medidas:</b> ' . htmlspecialchars($producto["ancho"]) . ' x ' . htmlspecialchars($producto["alto"]) . '<br>';
                    echo '<b>Fijación:</b> ' . htmlspecialchars($producto["fijacion"]) . '<br>';
                    echo '<b>Lado del cordón:</b> ' . htmlspecialchars($producto["lado_cordon"]);
                    if ($producto["tipoarticulo"] == "romana" && !empty($producto["ColorForro"])) {
                        echo '<br><b>Forro:</b> ' . htmlspecialchars($producto["telaForro"]) . ' (' . htmlspecialchars($producto["ColorForro"]) . ')';
                    }
                echo '</p>';
                break;

            // Lógica para CORTINA (aquí se evita mostrar datos de cortinero)
            case "cortina":
                echo '<p class="product-name"><b>' . htmlspecialchars($producto["nombre"]) . '</b></p>';
                echo '<p class="cart_ref">';
                    echo '<b>Espacio:</b> ' . htmlspecialchars($producto["area"]) . '<br>';
                    echo '<b>Tela:</b> ' . htmlspecialchars($producto["tela"]) . ' &nbsp; <b>Color:</b> ' . htmlspecialchars($producto["color"]) . '<br>';
					echo '<b>Medidas:</b> ' . htmlspecialchars($producto["ancho"]) . ' ANCHO x ' . htmlspecialchars($producto["alto"]) . ' ALTO<br>';
                    echo '<b>Acoplamiento:</b> ' . htmlspecialchars($producto["acoplamiento"]) . ' &nbsp; <b>Fijación:</b> ' . htmlspecialchars($producto["fijacion"]);
                    if (!empty($producto["ColorForro"])) {
                        echo '<br><b>Forro:</b> ' . htmlspecialchars($producto["telaForro"]) . ', Color: ' . htmlspecialchars($producto["ColorForro"]);
                    }
				if ($estatusCotizacion <> 4) {
    $key = $producto["CodigoTela"] . '_' . $producto["Metraje"];
    echo '<div id="notastock">'.$cacheStock[$key].'</div>';
}

                echo '</p>';
                break;

            // Lógica para CORTINERO
            case "cortinero":
                echo '<p class="product-name"><b>' . htmlspecialchars($producto["nombre"]) . '</b></p>';
                echo '<p class="cart_ref" style="line-height: 1.5;">';
                    echo '<b>Espacio:</b> ' . htmlspecialchars($producto["area"]) . '<br>';
                    echo '<b>Medidas:</b> ' . htmlspecialchars($producto["ancho"]) . ' m &nbsp; <b>Color:</b> ' . htmlspecialchars($producto["color"]) . '<br>';
                    echo '<b>Fijación:</b> ' . htmlspecialchars($producto["fijacion"]) . ' &nbsp; <b>Hojas:</b> ' . htmlspecialchars($producto["cantidadHojas"]) . '<br>';
                    echo '<b>Control:</b> ' . htmlspecialchars($producto["control"]) . ' &nbsp; <b>Soporte:</b> ' . htmlspecialchars($producto["soporte"]) . '<br>';
                    echo '<b>Remate:</b> ' . htmlspecialchars($producto["remate"]) . ' &nbsp; <b>Argolla:</b> ' . htmlspecialchars($producto["argolla"]) . '<br>';
                    echo '<b>Sistema:</b> ' . htmlspecialchars($producto["resultadoSistema"]);
					echo '<br><b>Lado del motor:</b> ' . htmlspecialchars($producto["lado_motor"]);

                    if (isset($producto["baston"]) && $producto["baston"] == "true") {
                        $detalleBaston = '<br><b>Bastón:</b> Sí (' . htmlspecialchars($producto["cantBaston"]) . ' de ' . htmlspecialchars($producto["radioMedida"]) . ')';
                        if (!empty($producto["radioMaterial"])) $detalleBaston .= ', Material: ' . htmlspecialchars($producto["radioMaterial"]);
                        if (!empty($producto["colorBaston"])) $detalleBaston .= ', Color: ' . htmlspecialchars($producto["colorBaston"]);
                        echo $detalleBaston;
                    }
                echo '</p>';
                break;

            // Lógica para cualquier otro producto
            default:
                echo '<p class="product-name"><b>' . htmlspecialchars($producto["nombre"]) . '</b></p>';
                echo '<p class="cart_ref"><b>Espacio:</b> ' . htmlspecialchars($producto["area"]) . '</p>';
                break;
        }
    ?>
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
<style>.cart_description p {
  margin: 2px 0;
  font-size: 14px;
  line-height: 1.4;
  color: #333;
}

.cart_description b {
  color: #141414ff; /* Azul profesional */
}

.cart_ref {
  font-size: 13px;
  color: #555;
}

.table td.cart_description {
  vertical-align: top;
  padding: 8px 12px;
}
</style>

<script src="../../assets/js/libs/toastr/toastr.js"></script>