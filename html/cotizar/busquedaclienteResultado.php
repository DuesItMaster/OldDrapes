<?php 
	require_once '../../conexion/cnx.php'; 
	if (isset($_POST['us']) and $_POST['us'] <> ""){ 
		$us = $_POST['us'];
		$Where="ID_USUARIO_ALTA =".$us;
		if (isset($_POST['distribuidor']) and $_POST['distribuidor'] <> ""){ 
			$client = $_POST['distribuidor'];
			//echo $client;
			$Where="ID_USUARIO_ALTA ='".$us."' AND NOMBRE LIKE'%".$client."%';";
		}
	}
	$sql = "SELECT ID_CLIENTE,NOMBRE,TELEFONO,EMAIL,ESTADO,MUNICIPIO,LOCALIDAD,COLONIA,CP,REFERENCIAS,ATENCION,SUCURSAL,CONTACTO FROM cliente WHERE ".$Where ;
	$result = mysqli_query($GLOBALS['db'], $sql);
?>
<div class="row">
	<div class="col-lg-12">
		<div class="thead">
			<label class="button" for=""></label>
			<label class="name" for="">Nombre</label>
			<label class="phone" for="">Telefono</label>
			<label class="adress" for="">Direccion</label>
			<label class="email" for="">Correo</label>
		</div>
		<div class="table_scroll">
			<div class="tbody">
				<?php
					if(mysqli_num_rows($result)>0){
						$str=false;
						while($row = mysqli_fetch_assoc($result)) {
							$backg="";
							if($str){
								$backg="str";
								$str=false;
							}else{
								$str=true;
							}
							echo '<div class="line '.$backg.'">
									<label class="button" style="text-align:center;"><a href="index.php?opcion=CliEdi&id='.$row["ID_CLIENTE"].'"><img src="../../assets/img/iconos/boton-editar.png" style="" width="20px" height="20px"/></a></label>
									<label class="name">'.$row["NOMBRE"].'</label>
									<label class="phone">'.$row["TELEFONO"].'</label>
									<label class="adress">'.$row["LOCALIDAD"].' '.$row["MUNICIPIO"].', '.$row["ESTADO"].' '.$row["CP"].'.</label>
									<label class="email">'.$row["EMAIL"].'</label>																	
								</div>';
						}
					}
				?>
			</div>
		</div>
	</div>
</div>
<script src="../../assets/js/core/demo/Demo.js"></script>
<script src="../../assets/js/core/demo/DemoTableDynamic.js"></script>