<?php
	include_once '../../conexion/ins.php';
	include_once '../../conexion/cnx.php';
	require_once '../cotizar/EnviarCorreoGmail.php';

	$id = $_POST['id'];
	$IdCotizador = $_POST['IdCotizador'];
	$IdUsuarioCotizador = $_POST['IdUsuarioCotizador'];
	$emailDistribuidor = $_POST['emailDistribuidor'];
	$nombreDistribuidor = $_POST['nombreDistribuidor'];
	$EjecutivoCotizador = $_POST['username'];

	if (isset($_POST['idUsuario'])){
	 	$idUsuario = $_POST['idUsuario'];
	}

	$nowFormat = date('Y-m-d H:i:s');

	$actualizacion = update('cotizacion',array('ESTADO' => '3' , 'ID_USUARIO_COTIZADOR' => $idUsuario,'FECHA_COTIZADOR'=>$nowFormat, 'IdCotizador'=>$IdCotizador, 'IdUsuarioCotizador'=>$IdUsuarioCotizador), array('%s', '%s', '%s', '%s', '%s'),array('ID_COTIZACION'=>$id), array('%d'));
	
	$sql="select FolioCotizacion from Cotizacion_Gen where FolioCotizacion =(select FolioCotizacion from cotizacion where id_cotizacion=".$id.");";

	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    	$FolioCotizacion =$row["FolioCotizacion"];
	    	    	
	    }
	}

	update('cotizacion',array('EJECUTIVO_COTIZADOR' => $EjecutivoCotizador), array('%s'),array('ID_COTIZACION'=>$id), array('%d'));
	
	update('Cotizacion_Gen',array('Estatus' => 'AUTORIZADO'), array('%s'),array('FolioCotizacion'=>$FolioCotizacion), array('%d')); 

	//EnviarCorreo($emailDistribuidor,$nombreDistribuidor,$id,$nombreDistribuidor); 

	if($actualizacion){
		echo "Enviado a cotizador correctamente";
	}else{
		echo "Error al guardar estado en Dues Drapes";
	}


?>