<?php

//echo "holaaa";
include_once '../../conexion/ins.php';
include_once '../../conexion/cnx.php';
include_once '../cotizar/EnviarCorreoaVentasGmail.php';

if (isset($_POST['IdUsuario'])){

	$IdUsuario = $_POST['IdUsuario'];
	$IdDescuento = $_POST['IdDescuento'];
	delete('usuario_desc','ID_USUARIO_DESCUENTO', $IdDescuento);
	}

	//delete('usuario_desc',array('ID_USUARIO_DESCUENTO' => $IdDescuento), array('%s'),array('ID_USUARIO_DESCUENTO'=>$IdDescuento), array('%d'));

	if (isset($_POST['IdDistri'])){
		$IdDistri = $_POST['IdDistri'];
	}

	if (isset($_POST['NuevoDescuento'])){
		$NuevoDescuento = $_POST['NuevoDescuento'];

		 insert('usuario_desc',array('ID_USUARIO'=>$IdDistri, 'DESCUENTO' =>$NuevoDescuento), 
					 array('%s', '%s'));
	}
?>