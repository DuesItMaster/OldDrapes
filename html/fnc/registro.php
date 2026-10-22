<?php 
include_once '../../conexion/ins.php';
include '../../conexion/cnx.php';

$evento="";
if (isset($_POST['evento'])){ 
	$evento = $_POST['evento'];
}else{
	echo "Error";
	exit;
}
$user="";
if (isset($_POST['user'])){ 
	$user = $_POST['user'];
}else{
	echo "Error";
	exit;
}
$nombre="";
if (isset($_POST['nombre'])){ 
	$nombre = $_POST['nombre'];
}else{
	echo "Error";
	exit;
}
$empresa="";
if (isset($_POST['empresa'])){ 
	$empresa = $_POST['empresa'];
}
$ciudad="";
if (isset($_POST['ciudad'])){ 
	$ciudad = $_POST['ciudad'];
}else{
	echo "Error";
	exit;
}

$sql = "SELECT * FROM ciudad WHERE nombre = '".$ciudad."';";
$result = mysqli_query($GLOBALS["db"], $sql);
if(mysqli_num_rows($result) == 0) {
	$sql = "INSERT INTO ciudad values(NULL,'".$ciudad."');";
	mysqli_query($GLOBALS["db"], $sql);
}
$sql = "SELECT * FROM ciudad WHERE nombre = '".$ciudad."';";
$result = mysqli_query($GLOBALS["db"], $sql);
$ciudad = mysqli_fetch_assoc($result);
$ciudad = $ciudad["id"];

$sql = "SELECT * FROM evento_usuario WHERE id_evento = ".$evento." AND id_usuario = ".$user.";";
$result = mysqli_query($GLOBALS["db"], $sql);
if(mysqli_num_rows($result) > 0) {
	echo "Error";
	exit;
}

$created = date("Y-m-d h:i:s");
$res = insert('evento_usuario',array('id_evento'=>$evento,'id_usuario'=>$user,'created'=>$created,'nombre_usuario'=>$nombre,'empresa'=>$empresa,'ciudad'=>$ciudad), array('%s', '%s', '%s','%s', '%s', '%s'));
if($res!=0 && $res==false)
	echo "Error";
else
	echo "Success";

?>