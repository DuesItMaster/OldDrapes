<?php
include_once '../../conexion/ins.php';
include_once '../../conexion/cnx.php';
include_once '../cotizar/EnviarCorreoGmail.php';



// DEVOLVER **************************************************************************************************************************************
if (isset($_POST['id'])) {
		
	if (isset($_POST['Justificacion'])) {
	 	$Justificacion = $_POST['Justificacion'];
	} else {
		$Justificacion=" ";
	}
	 
	if (isset($_POST['idUsuario'])) {
	 	$idUsuario = $_POST['idUsuario'];
	}	

	if (isset($_POST['FolioCotizacion'])) {
	 	$FolioCotizacion = $_POST['FolioCotizacion'];
	}

	$id = $_POST['id'];
	$correo = $_POST['correo'];
	$nombre = $_POST['nombre'];
	$cliente = $_POST['cliente'];

	$nowFormat = date('Y-m-d H:i:s');

	update('cotizacion',
						array('ESTATUS' => '3' ,'ESTADO'=>'2', 'ID_USUARIO_DEVUELVE' => $idUsuario, 'justificacion'=>$Justificacion,'FECHA_DEVUELVE'=>$nowFormat), array('%s', '%s', '%s', '%s', '%s'),
						array('ID_COTIZACION'=>$id), array('%d')
		   );
	
	EnviarCorreo($correo,$nombre,$id,$cliente,$Justificacion);

	$sql = "select FolioCotizacion from Cotizacion_Gen where FolioCotizacion = (select FolioCotizacion from cotizacion where id_cotizacion=".$id.") ;";

	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    		$FolioCotizacion =$row["FolioCotizacion"];	    	    	
	    }
	}
	  
	update('Cotizacion_Gen',
							array('Estatus' => ''), array('%s'),
							array('FolioCotizacion'=>$FolioCotizacion), array('%d')
		  );
	 
}
// DEVOLVER **************************************************************************************************************************************


// APROBADO **************************************************************************************************************************************
if (isset($_POST['id2'])){
	
	$id2 = $_POST['id2'];
	
	if (isset($_POST['idUsuario'])){
	 	$idUsuario = $_POST['idUsuario'];
	}	

	?> 
	<!--<script type="text/javascript">
		var id2 = "<?php echo $id2; ?>" ;
		var idUsuario = "<?php echo $idUsuario; ?>" ;
	
		alert('id2  ' + id2 + ' idUsuario' + idUsuario );
	</script>-->
	<?php 

	$nowFormat = date('Y-m-d H:i:s');
	
	update('cotizacion',
						array('ESTADO' => '1' , 'ID_USUARIO_APRUEBA' => $idUsuario,'FECHA_APRUEBA' => $nowFormat), array('%s', '%s', '%s'),
						array('ID_COTIZACION'=>$id2), array('%d')
			);

	$sql="select FolioCotizacion from Cotizacion_Gen where FolioCotizacion = (select FolioCotizacion from cotizacion where id_cotizacion=".$id2.");";

	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    	$FolioCotizacion =$row["FolioCotizacion"];
	    	    	
	    }
	}


	update('Cotizacion_Gen',array('Estatus' => 'APROBADO'), array('%s'),array('FolioCotizacion'=>$FolioCotizacion), array('%d'));  	
	//EnviarCorreo($correo,$nombre);
}

// APROBADO **************************************************************************************************************************************


// AUTORIZADO ************************************************************************************************************************************

if (isset($_POST['id3'])){
	
	$id3 = $_POST['id3'];
	
	if (isset($_POST['idUsuario'])){
	 	$idUsuario = $_POST['idUsuario'];
	}

	$nowFormat = date('Y-m-d H:i:s');

	update('cotizacion',array('ESTADO' => '3' , 'ID_USUARIO_COTIZADOR' => $idUsuario,'FECHA_COTIZADOR'=>$nowFormat), array('%s', '%s', '%s'),array('ID_COTIZACION'=>$id3), array('%d'));
	$sql="select FolioCotizacion from Cotizacion_Gen where FolioCotizacion =(select FolioCotizacion from cotizacion where id_cotizacion=".$id3.");";

	$result = mysqli_query($GLOBALS["db"], $sql);
	if (mysqli_num_rows($result) > 0) {
	    while($row = mysqli_fetch_assoc($result)) {	    	
	    	$FolioCotizacion =$row["FolioCotizacion"];
	    	    	
	    }
	}

	update('Cotizacion_Gen',array('Estatus' => 'AUTORIZADO'), array('%s'),array('FolioCotizacion'=>$FolioCotizacion), array('%d'));  	

}

// AUTORIZADO ************************************************************************************************************************************

?>		