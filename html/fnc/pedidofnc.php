<?php
include_once '../../conexion/ins.php';
include_once '../../conexion/cnx.php';


	
	$id = $_POST['id'];
	$estatus = $_POST['estatus'];
	$fecha = $_POST['fecha'];
	

	
	if (update('cotizacion',
			array('FECHAEMBARQUE' => $fecha , 'ESTADOCOTIZACION' => $estatus), array('%s', '%s'),
			array('ID_COTIZACION'=>$id), array('%d')
			)){

		echo "SI";

	} else {
		echo "NO";
	}

	




?>		