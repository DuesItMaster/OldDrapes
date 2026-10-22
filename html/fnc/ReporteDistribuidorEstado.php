<?php
include_once '../../conexion/ins.php';
include_once '../../conexion/cnx.php';
//include_once '../cotizar/EnviarCorreoaVentasGmail.php';
include_once '../cotizar/EnviarCorreoAutorizacion.php';
require_once '../../conexion/wsConsumeDrapes.php';

if (isset($_POST['id'])){
	$id = $_POST['id'];
	//$Justificacion = $_POST['Justificacion'];
}


if (isset($_POST['nombre'])){
	$Cliente = $_POST['nombre'];
}

if (isset($_POST['FolioCotizacion'])){
	$FolioCotizacion = $_POST['FolioCotizacion'];
}

if (isset($_POST['Tipo'])){
	$Tipo = $_POST['Tipo'];
}
else {
	$Tipo = 0;
}

//nombre

/*if (isset($_POST['idUsuario'])){
	$idUsuario = $_POST['idUsuario'];
}*/

$idUsuario = $_SESSION['login_user'];


if ($Tipo == 1) {

	//, 'justificacion'=>$Justificacion , '%s'
	$nowFormat = date('Y-m-d H:i:s');
	update('cotizacion',array('ESTATUS' => '2' , 'ID_USUARIO_MODIFICA' => $idUsuario,'FECHA_REVISION'=>$nowFormat), array('%s', '%s', '%s'),array('ID_COTIZACION'=>$id), array('%d'));

	$sql="select FolioCotizacion from Cotizacion_Gen where FolioCotizacion =(select FolioCotizacion from cotizacion where id_cotizacion=".$id.");";
	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    		$FolioCotizacion =$row["FolioCotizacion"];	    	    	
	    }
	}

	update('Cotizacion_Gen',array('Estatus' => 'REVISION'), array('%s'),array('FolioCotizacion'=>$FolioCotizacion), array('%d'));	// REVISION


	/*$sql="SELECT nombre,tipo,t.id_tipousuario,email FROM usuario u inner join tipousuario t on (u.id_tipousuario=t.id_tipousuario) where t.id_tipousuario=1 and u.id_perfil=5;";
	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    		//$FolioCotizacion =$row["FolioCotizacion"];
	    		//$correo,$nombre,$id,$NombreCliente	    	    	
	    	EnviarCorreo($row["email"],$row["nombre"],$FolioCotizacion,$Cliente);
	    }
	}*/
	$sqlCliente="SELECT CASE WHEN CLAVESAP = '' THEN '00127' WHEN CLAVESAP = ' ' THEN '00127' ELSE ifnull(CLAVESAP,'00127') END as CLAVESAP FROM cotizacion  INNER JOIN usuario ON usuario.ID_USUARIO= cotizacion.ID_USUARIO_ALTA WHERE id_cotizacion=".$id.";";

	$resultCliente = mysqli_query($GLOBALS["db"], $sqlCliente);
	if (mysqli_num_rows($resultCliente) > 0) {

		$rowCliente = $resultCliente->fetch_row();
		$claveSAP = $rowCliente[0];
		$arrayCliente = Email($claveSAP);
		$Email = $arrayCliente[0]['Email'];
		$Nombre = utf8_decode($arrayCliente[0]['Nombre']);
		EnviarCorreoRevision($Email,$Nombre,$id,$Cliente);
	}

}

else if($Tipo == 2) {

	//, 'justificacion'=>$Justificacion , '%s'
	$nowFormat = date('Y-m-d H:i:s');
	update('cotizacion',array('ESTATUS' => '4' , 'ID_USUARIO_MODIFICA' => $idUsuario,'FECHA_ENVIA_PEDIDO'=>$nowFormat), array('%s', '%s', '%s'),array('ID_COTIZACION'=>$id), array('%d'));

	$sql="select FolioCotizacion from Cotizacion_Gen where FolioCotizacion =(select FolioCotizacion from cotizacion where id_cotizacion=".$id.");";
	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    		$FolioCotizacion =$row["FolioCotizacion"];	    	    	
	    }
	}

	update('Cotizacion_Gen',array('Estatus' => 'CONFIRMADO'), array('%s'),array('FolioCotizacion'=>$FolioCotizacion), array('%d'));	


	/*$sql="SELECT nombre,tipo,t.id_tipousuario,email FROM usuario u inner join tipousuario t on (u.id_tipousuario=t.id_tipousuario) where t.id_tipousuario=1 and u.id_perfil=5;"; 
	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    		//$FolioCotizacion =$row["FolioCotizacion"];
	    		//$correo,$nombre,$id,$NombreCliente	    	    	
	    	EnviarCorreo($row["email"],$row["nombre"],$FolioCotizacion,$Cliente);
	    }
	}*/

	$sqlCliente="SELECT CASE WHEN CLAVESAP = '' THEN '00127' WHEN CLAVESAP = ' ' THEN '00127' ELSE ifnull(CLAVESAP,'00127') END as CLAVESAP FROM cotizacion  INNER JOIN usuario ON usuario.ID_USUARIO= cotizacion.ID_USUARIO_ALTA WHERE id_cotizacion=".$id.";";

	$resultCliente = mysqli_query($GLOBALS["db"], $sqlCliente);
	if (mysqli_num_rows($resultCliente) > 0) {

		$rowCliente = $resultCliente->fetch_row();
		$claveSAP = $rowCliente[0];
		$arrayCliente = Email($claveSAP);
		$Email = $arrayCliente[0]['Email'];
		$Nombre = utf8_decode($arrayCliente[0]['Nombre']);
		EnviarCorreoAutorizacion($Email,$Nombre,$id,$Cliente);
		//EnviarCorreo('iron4soft@gmail.com',$Email,$FolioCotizacion,$Cliente);
	}


}

?>