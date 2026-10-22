<?php 
require_once '../../conexion/ins.php';

//----------DATOS USUARIO------------
if (isset($_POST['nombre'])){ 
	$nombre = $_POST['nombre'];
	echo $nombre;
}
if (isset($_POST['email'])){ 
	$email = $_POST['email'];
	//echo $calle;
}
if (isset($_POST['usuario'])){ 
	$usuario = $_POST['usuario'];
	//echo $colonia;
}
if (isset($_POST['pass'])){ 
	$pass = $_POST['pass'];
	//echo $localidad;
}

if (isset($_POST['Session'])){ 
	$Session = $_POST['Session'];
	//echo $localidad;
}
if (isset($_POST['control'])){ 
	$control = $_POST['control'];
	//echo $control;
}

//DATOS CLIENTE

if($control=="si"){ 
update('usuario',array('NOMBRE'=>$nombre, 'EMAIL' =>utf8_decode($email), 
							'USUARIO' =>utf8_decode($usuario),'PASS'=>utf8_decode(md5($pass))), 
					 array('%s', '%s','%s', '%s'),array('ID_USUARIO'=>$Session),array('%s'));
 }
 else if ($control=="no"){
update('usuario',array('NOMBRE'=>$nombre, 'EMAIL' =>utf8_decode($email), 
							'USUARIO' =>utf8_decode($usuario)), 
					 array('%s', '%s','%s'),array('ID_USUARIO'=>$Session),array('%s'));

 }


?>

