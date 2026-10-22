<?php
	
	include_once '../clases/Carrito.class.php';

	$carrito = new Carrito();

	$_SESSION['folio']=null;
	$_SESSION['IdCliente']=null;
	$_SESSION['NombreCliente']=null;
	$carrito->destroy();

?>

	<script type="text/javascript">
		window.location.href = 'index.php?opcion=linea';
	</script>