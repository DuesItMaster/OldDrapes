<?php 
//require_once '../../conexion/cnx.php';
require_once '../../conexion/ins.php';


//var en comun
if (isset($_POST['idalta'])){ 
	$idalta = $_POST['idalta'];
	//echo $idalta;
}

//----------------DATOS DIRECCIÓN-----------------

if (isset($_POST['n_nombre'])){ 
	$n_nombre = $_POST['n_nombre'];
	//echo $n_nombre;
}
if (isset($_POST['n_calle'])){ 
	$n_calle = $_POST['n_calle'];
	//echo $n_calle;
}
if (isset($_POST['n_numero'])){ 
	$n_numero = $_POST['n_numero'];
	//echo $n_numero;
}
if (isset($_POST['n_colonia'])){ 
	$n_colonia = $_POST['n_colonia'];
	//echo $n_colonia;
}
if (isset($_POST['n_localidad'])){ 
	$n_localidad = $_POST['n_localidad'];
	//echo $n_localidad;
}
if (isset($_POST['n_estado'])){ 
	$n_estado = $_POST['n_estado'];
	//echo $n_estado;
}
if (isset($_POST['n_municipio'])){ 
	$n_municipio = $_POST['n_municipio'];
	//echo $n_municipio;
}
if (isset($_POST['n_telefono'])){ 
	$n_telefono = $_POST['n_telefono'];
	//echo $n_telefono;
}
if (isset($_POST['n_referencias'])){ 
	$n_referencias = $_POST['n_referencias'];
	//echo $n_referencias;
}
if (isset($_POST['n_atencion'])){ 
	$n_atencion = $_POST['n_atencion'];
	//echo $n_atencion;
}

if (isset($_POST['n_hora'])){ 
	$n_hora = $_POST['n_hora'];
	//echo $n_hora;
}

if (isset($_POST['n_ciudad'])){ 
	$n_ciudad = $_POST['n_ciudad'];
	//echo $n_ciudad;
}
if (isset($_POST['n_contacto'])){ 
	$n_contacto = $_POST['n_contacto'];
	//echo $n_contacto;
}

if (isset($_POST['n_sucursal'])){ 
	$n_sucursal = $_POST['n_sucursal'];
	//echo $n_sucursal;
}

if (isset($_POST['n_cp'])){ 
	$n_cp = $_POST['n_cp'];
	//echo $n_cp;
}
//----------------DATOS DIRECCIÓN-----------------




 insert('usuario_direccion',array('NOMBRE_DOMICILIO'=>$n_nombre, 'CALLE' => $n_calle, 'NUMERO'=> $n_numero, 
							'LOCALIDAD' =>$n_localidad,'ESTADO'=>$n_estado, 'MUNICIPIO'=>$n_municipio,
							'TELEFONO'=>$n_telefono,'REFERENCIAS'=>$n_referencias,'ATENCION'=>$n_atencion,'CONTACTO'=>$n_contacto,
							'SUCURSAL'=>$n_sucursal,'ID_USUARIO'=>$idalta,'COLONIA'=>$n_colonia,'CP'=>$n_cp,
							'CIUDAD'=>$n_ciudad,'HORA'=>$n_hora), 
					 array('%s', '%s','%s', '%s','%s', '%s','%s','%s',
						   '%s', '%s','%s', '%s','%s', '%s','%s','%s'))

?>

