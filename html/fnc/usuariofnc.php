<?php 
require_once '../../conexion/ins.php';

//----------DATOS USUARIO------------
if (isset($_POST['nombre'])){ 
	$nombre = $_POST['nombre'];
	//echo $nombre;
}
if (isset($_POST['email'])){ 
	$email = $_POST['email'];
	//echo $calle;
}
if (isset($_POST['claveSap'])){ 
	$claveSap = $_POST['claveSap'];
	//echo $numero;
}
if (isset($_POST['usuario'])){ 
	$usuario = $_POST['usuario'];
	//echo $colonia;
}
if (isset($_POST['pass'])){ 
	$pass = $_POST['pass'];
	//echo $localidad;
}
if (isset($_POST['tipo'])){ 
	$tipo = $_POST['tipo'];
	//echo $ciudad;
}

if (isset($_POST['tipo'])){ 
	$tipo = $_POST['tipo'];
	//echo $ciudad;
}


if (isset($_POST['lu'])){ 
	$user = $_POST['lu'];
}
$estatus=1;
//DATOS CLIENTE




 /*insert('usuario',array('NOMBRE'=>$nombre, 'EMAIL' =>utf8_decode($email), 'CLAVESAP'=> $claveSap, 
							'usuario' =>utf8_decode($usuario),'PASS'=>utf8_decode(md5($pass)), 'ID_TIPOUSUARIO'=>utf8_decode($tipo), 'ESTATUS'=>$estatus), 
					 array('%s', '%s','%s', '%s','%s', '%s','%s',))*/


//DATOS CLIENTE
$sql = 'select id_usuario from usuario where usuario = "'.$usuario.'"';
$result = mysqli_query($GLOBALS["db"], $sql);
if (mysqli_num_rows($result) > 0) {
	$respuesta = -1;
}else{
	$respuesta = insert('usuario',array('NOMBRE'=>$nombre, 'EMAIL' =>utf8_decode($email), 'CLAVESAP'=> $claveSap, 
							'usuario' =>utf8_decode($usuario),'PASS'=>utf8_decode(md5($pass)), 
							'ID_TIPOUSUARIO'=>utf8_decode($tipo), 'ESTATUS'=>$estatus,'ID_USUARIOALTA'=>$user), 
					 array('%s', '%s','%s', '%s','%s', '%s','%s','%s'));
}


echo $respuesta;

?>

