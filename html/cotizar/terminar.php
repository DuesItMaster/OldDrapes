<?php 
	require_once '../fnc/terminarIva.php';
	$iva = TraerIva();
?>
<link rel="stylesheet" href="../../assets/css/animacion/terminar/global.css?v=2" type="text/css" media="all">
<link rel="stylesheet" href="../../assets/css/carrito.css?v=3" type="text/css" media="all">
<style type="text/css">.fancybox-margin{margin-right:17px;}</style>

<div id="order" class="order hide-left-column hide-right-column lang_en">
	<div id="page">
		<div id="slider_row" class="row">
			<div id="top_column" class=""></div>
		</div>
		<div id="columns" class="">	
			<div class="row">
				<div id="center_column" class="">
					<?php
						//print_r($carrito->get_content());
						$carro = $carrito->get_content();	

						if (isset($_SESSION['folio'])){
							$variableCotizar = " Folio: " . $_SESSION['folio'] . ". Cliente: " . $_SESSION['NombreCliente'];
							echo "<input type='hidden' id='idCliente' name='idCliente' value='".$_SESSION['IdCliente']."'>";
							echo "<input type='hidden' id='id' name='id' value='".$_SESSION['folio']."'>";
						}else{
							$variableCotizar = "";
						}
					?>
					<div id="precio"></div>
					<div id="VALOR"></div>
					<div id="prueba"></div>

				</div>
			</div>
		</div>
	</div>
</div>
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
	
	function CargarValor(){
		//alert("AQUI");
		$.post("terminarTabla.php", { Cotizacion : "<?php echo $variableCotizar; ?>" }, function(data2){
			$("#precio").html(data2);
			$("#precio").show();
		});	
	}
	function GuardarCarrito(){
		//alert('sii');
		$.post("../fnc/GuardarCarrito.php", { Prueba : "Prueba" }, function(data2){
			$("#prueba").html(data2);
			$("#prueba").show();
		});	
	}

	function Eliminar(id, precio, nombre){
		//alert("ELIMINAR: " + nombre);
		$.post("../fnc/TerminarFnc.php", { id : id, precio:precio, nombre: nombre, operacion : "ELIMINAR" }, function(data2){
			$("#VALOR").html(data2);
			$("#VALOR").show();
			CargarValor();
		});
	}

	function Agregar(unique_id){
		//alert("AGREGAR " + id);
		operacion = "AGREGAR";
		//alert(operacion);
		$.post("../fnc/TerminarFnc.php", { id : unique_id,  operacion : operacion}, function(data2){
			$("#VALOR").html(data2);
			$("#VALOR").show();
			CargarValor();
		});
	}

	function Suprimir(unique_id){
		//alert("SUPIMIR" + id);
		operacion = "SUPRIMIR";
		//alert(operacion);
		$.post("../fnc/TerminarFnc.php", { id : unique_id,  operacion : operacion}, function(data2){
			$("#VALOR").html(data2);
			$("#VALOR").show();
			CargarValor();
		});
	}

	function fncValoresCliente(){
		//alert("si");				   
		IdCliente1 = $("#idCliente").val();
		IDCOTIZACION = $("#id").val(); 

		$.post("../fnc/datoscliente2.php", { client: IdCliente1 }, function(data1){
			$("#ValoresCliente").html(data1);
			$("#ValoresCliente").show();
		});


		$.post("../fnc/datosenvio.php", { IDCOTIZACION: IDCOTIZACION }, function(data1){
			$("#Valoresenvio").html(data1);
			$("#Valoresenvio").show();
		});	
	}

	function Guardar(){
		IdCliente1 = $("#idCliente").val();
		//alert(IdCliente1);
		$.post("../fnc/ModificarCarrito.php", { AgregarDireccion:"NO", DireccionCliente:"NO", NuevoCliente:"NO",
												DireccionCarrito:"SI",
												idCliente:IdCliente1
												}, function(data2){
			$("#prueba").html(data2);
			$("#prueba").show();
		});
	}
		
	function CargarAhorro(){
		//alert("AQUI");
		$.post("ahorroMetrajeGalerias.php", { }, function(data2){
		});	
	}
	CargarValor();
	fncValoresCliente();
</script>