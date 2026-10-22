<?php 
include_once '../../conexion/ins.php';
include '../../conexion/cnx.php';

session_start();

$usuario="";
if (isset($_POST['ref'])){
	$usuario = $_POST['ref'];
}else{
	echo "Error1";
	exit;
}

$respuesta="";
if (isset($_POST['respuesta'])){ 
	$respuesta = $_POST['respuesta'];
}else{
	echo "Error2";
	exit;
}

$sql = "SELECT * FROM interesado_evento WHERE id_usuario = ".$usuario.";";
$result = mysqli_query($GLOBALS["db"], $sql);
if(mysqli_num_rows($result) > 0) {
	echo "Error3";
	exit;
}

$created = date("Y-m-d h:i:s");
$res = insert('interesado_evento',array('id_usuario'=>$usuario,'respuesta'=>$respuesta,'created'=>$created), array('%s', '%s', '%s'));
if($res!=0 && $res==false)
	echo "Error4";
else
	echo "Success";

?>