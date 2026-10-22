<?php

	include '../../conexion/wsConsumeDrapes.php';

	if (isset($_POST['IdNombre']))
	{
		$IdNombre = $_POST['IdNombre'];
	}

	$rescolor = colores($IdNombre);

	foreach ($rescolor as $valor)
	{
		echo "<option value='" . $valor . "'>" . trim($valor) . "</option>";
	}