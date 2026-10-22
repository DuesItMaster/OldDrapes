<?php 
require_once '../../conexion/cnx.php';

//$db = new DB;

if(isset($_SESSION['login_user'])) {
	redirect("../cotizar/index.php");
}

if(isSet($_POST['username']) && isSet($_POST['password']))
{
//if(isset($_POST['btn-login'])) {

	/*$uname = $_POST['username'];
	$upass = $_POST['password'];	
	if ($user->login($uname,$upass)){
	header("Location: ../cotizar/index.php");
	}*/
	

	session_start();

	$uname = $_POST['username'];
	$upass = $_POST['password'];

	
	$username = mysqli_real_escape_string($db,htmlentities(strtolower($uname),ENT_QUOTES,'UTF-8'));
	$password = mysqli_real_escape_string($db,htmlentities(md5(strtolower($upass)),ENT_QUOTES,'UTF-8'));

	$result = mysqli_query($db,"SELECT ID_USUARIO,NOMBRE,CLAVESAP,ID_TIPOUSUARIO,USUARIO FROM usuario WHERE USUARIO='$username' and PASS='$password' and estatus=1");
	$count = mysqli_num_rows($result);

	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

	if($count == 1) {
		$_SESSION['login_user'] = $row['ID_USUARIO'];
		$_SESSION['nombre_user'] = $row['NOMBRE'];
		$_SESSION['user'] = $row['USUARIO'];
		$_SESSION['sap'] = $row['CLAVESAP'];
		$_SESSION['perfil'] = $row['ID_TIPOUSUARIO'];
		//echo $row['ID_USUARIO'];
		header("Location: ../cotizar/index.php");
	}

}


?>