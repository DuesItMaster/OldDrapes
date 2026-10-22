<?php 
include_once '../../conexion/ins.php';
//include_once '../../conexion/cnx.php';


//var en comun
if (isset($_POST['idalta'])){ 
	$idalta = $_POST['idalta'];
	//echo $idalta;
}

//----------DATOS CLIENTE------------
if (isset($_POST['cliente'])){ 
	$cliente = $_POST['cliente'];
	//echo $cliente;
}
if (isset($_POST['calle'])){ 
	$calle = $_POST['calle'];
	//echo $calle;
}
if (isset($_POST['numero'])){ 
	$numero = $_POST['numero'];
	//echo $numero;
}
if (isset($_POST['colonia'])){ 
	$colonia = $_POST['colonia'];
	//echo $colonia;
}
if (isset($_POST['localidad'])){ 
	$localidad = $_POST['localidad'];
	//echo $localidad;
}
if (isset($_POST['ciudad'])){ 
	$ciudad = $_POST['ciudad'];
	//echo $ciudad;
}
if (isset($_POST['estado'])){ 
	$estado = $_POST['estado'];
	//echo $estado;
}
if (isset($_POST['telefono'])){ 
	$telefono = $_POST['telefono'];
	//echo $telefono;
}
if (isset($_POST['hora'])){ 
	$hora = $_POST['hora'];
	//echo $hora;
}
if (isset($_POST['sucursal'])){ 
	$sucursal = $_POST['sucursal'];
	//echo $sucursal;
}

if (isset($_POST['atencion'])){ 
	$atencion = $_POST['atencion'];
	//echo $sucursal;
}

if (isset($_POST['cp'])){ 
	$cp = $_POST['cp'];
	//echo $sucursal;
}
if (isset($_POST['contacto'])){ 
	$contacto = $_POST['contacto'];
	//echo $sucursal;
}

if (isset($_POST['referencias'])){ 
	$referencias = $_POST['referencias'];
	//echo $sucursal;
}

/*if (isset($_POST['email'])){ 
	$email = $_POST['email'];
	//echo $sucursal;
}*/
//DATOS CLIENTE




 insert('usuario_direccion',array('NOMBRE_DOMICILIO'=>$cliente, 'CALLE' =>utf8_decode($calle), 'NUMERO'=> $numero, 
							'COLONIA' =>utf8_decode($colonia),'LOCALIDAD'=>utf8_decode($localidad), 'ESTADO'=>utf8_decode($estado),
							'CIUDAD'=>utf8_decode($ciudad),'TELEFONO'=>$telefono,'HORA'=>$hora,'SUCURSAL'=>utf8_decode($sucursal),
							'ATENCION'=>utf8_decode($atencion),'CP'=>$cp,'CONTACTO'=>utf8_decode($contacto),'REFERENCIAS'=>utf8_decode($referencias),
							'ID_USUARIO'=>$idalta), 
					 array('%s', '%s','%s', '%s','%s', '%s','%s',
						   '%s', '%s','%s', '%s','%s', '%s','%s','%s')); //arriba 15 falta municipio


?>

