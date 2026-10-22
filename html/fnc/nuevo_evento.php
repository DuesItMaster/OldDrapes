<?php 
include_once '../../conexion/ins.php';

$nombre="";
if (isset($_POST['nombre']) && $_POST['nombre']!=''){ 
	$nombre = $_POST['nombre'];
}else{
	exit;
}
$descripcion="";
if (isset($_POST['descripcion']) && $_POST['descripcion']!=''){ 
	$descripcion = $_POST['descripcion'];
}else{
	exit;
}
$fecha="";
if (isset($_POST['fecha']) && $_POST['fecha']!=''){ 
	$fecha = $_POST['fecha'];
}else{
	exit;
}
$hora="";
if (isset($_POST['hora']) && $_POST['hora']!=''){ 
	$hora = $_POST['hora'];
}else{
	exit;
}
$fecha_convocatoria="";
if (isset($_POST['fecha_convocatoria']) && $_POST['fecha_convocatoria']!=''){ 
	$fecha_convocatoria = $_POST['fecha_convocatoria'];
}else{
	exit;
}

$created = date("Y-m-d H:i:s");
$data_evento = array('nombre'=>$nombre,'descripcion'=>$descripcion,'fecha'=>$fecha,'hora'=>$hora,'imagen'=>NULL,'created'=>$created,'convocatoria'=>$fecha_convocatoria);
$res = insert('evento', $data_evento, array('%s','%s','%s','%s','%s','%s','%s'));

if ($res === false || $res === 0) {
	// Compatibilidad con esquemas que usan fecha_convocatoria en lugar de convocatoria.
	$data_evento = array('nombre'=>$nombre,'descripcion'=>$descripcion,'fecha'=>$fecha,'hora'=>$hora,'imagen'=>NULL,'created'=>$created,'fecha_convocatoria'=>$fecha_convocatoria);
	$res = insert('evento', $data_evento, array('%s','%s','%s','%s','%s','%s','%s'));
}

if($res !== false && $res !== 0)
	echo "Success";
else
	echo "Error";
?>