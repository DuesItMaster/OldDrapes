<?php
	include_once '../../conexion/ins.php';
	include_once '../../conexion/cnx.php';

    session_start();
    $datos="";
	if (isset($_POST['datos'])){
	 	$datos = $_POST['datos'];
	}
    $folio="";
	if (isset($_POST['folio'])){
	 	$folio = $_POST['folio'];
	}
    $respuesta="";
	if (isset($_POST['respuesta'])){
	 	$respuesta = $_POST['respuesta'];
	}
    $login_user="";
	if (isset($_POST['respuesta'])){
	 	$login_user = $_SESSION['login_user'];
	}
    $nombre_user="";
	if (isset($_POST['respuesta'])){
	 	$nombre_user = $_SESSION['nombre_user'];
	}
    
    $created = date("Y-m-d h:i:s");
    if(insert('Log_enviado_Sincronizador',array('id'=>null,'created'=>$created,'folio'=>$folio,'usuario'=>$login_user,'nombre'=>$nombre_user,'datos'=>$datos,'respuesta'=>$respuesta), array('%s','%s','%s','%s','%s','%s','%s'))!=false)
        echo "Success";
    else
        echo "Error";
?>