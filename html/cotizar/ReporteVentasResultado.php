<?php 
	//print_r("entro");
	require_once '../../conexion/cnx.php'; 
	$Where = " where c.ID_USUARIO_ALTA is not null ";
	$order = ""; 
	if (isset($_POST['distribuidor']) and $_POST['distribuidor'] <> ""){ 
		$distribuidor = $_POST['distribuidor']; 
		$Where = $Where . " and c.ID_USUARIO_ALTA = " .$distribuidor;
	}else{
		$distribuidor="";
	}
	if (isset($_POST['folio']) and $_POST['folio'] <> ""){ 
		$folio = $_POST['folio'];
		$Where = $Where . " AND CAST(ID_COTIZACION as CHAR(50)) LIKE '%" .$folio . "%'";
	} else {
		$folio = "";
	}
	if (isset($_POST['fecha1']) and $_POST['fecha1'] <> ""){ 
		$fecha1 = $_POST['fecha1'];
		$Where = $Where . " and date(c.FECHA_ALTA) >= '" .$fecha1 . "'";
	}else{
		$fecha1="";
	}
	if (isset($_POST['fecha2']) and $_POST['fecha2'] <> ""){ 
		$fecha2 = $_POST['fecha2'];
		$Where = $Where . " and date(c.FECHA_ALTA) <= '" .$fecha2."'";
	}else{
		$fecha2="";
	}
	if ((isset($_POST['Pro']) and $_POST['Pro'] <> "") and (isset($_POST['Ve']) and $_POST['Ve'] <> "")){
		$Where = $Where . " and (c.ESTADO = 0 or c.ESTADO = 4)  ";
	} elseif (isset($_POST['Gua']) and $_POST['Gua'] <> ""){ 
		$Where = $Where . " and c.ESTATUS = 1 and c.ESTADO=0 ";
	}elseif (isset($_POST['Pro']) and $_POST['Pro'] <> ""){ 
		$Where = $Where . " and c.ESTADO = 0";
	}elseif (isset($_POST['Ve']) and $_POST['Ve'] <> ""){ 
		$Where = $Where . " and c.ESTADO = 4";
	} else {
		$Where = $Where . " and (c.estatus=2 or (c.ESTADO = 1 and c.ESTATUS=4) or (c.ESTADO = 3 AND c.ESTATUS = 4 ) OR (c.ESTADO = 4 AND c.ESTATUS = 4 )) ";
	}
	if (isset($_POST['ord']) and $_POST['ord'] <> ""){ 
		$ord = $_POST['ord'];
		$order =" ORDER BY ".$ord;
	} else {
		$ord = "";
	}
	$perfil =  (isset($_POST['lp']) and $_POST['lp'] <> "") ? $_POST['lp'] : "";
	$idusr = (isset($_POST['lu']) and $_POST['lu'] <> "") ? $_POST['lu'] : "";
	$sql = "SELECT ID_COTIZACION,FolioCotizacion, us.NOMBRE,c.FECHA_ALTA,SUBTOTAL,DESCUENTO,IVA, TOTAL,c.ESTADO,cli.nombre as cliente,
	if(c.ESTADO = 1, 'APROBADO',IF(c.ESTADO=2 /*AND c.ESTATUS<>2*/,'VERIFICAR',IF(c.ESTADO=3,'AUTORIZADO', IF(c.ESTADO = 4,'CREADO EN SAP',if(c.ESTATUS=1,'GUARDADO (SIN ENVIO)','SIN REVISIÓN'))))) AS ESTATUSt,c.ESTATUS, us.EMAIL , FECHAEMBARQUE, ESTADOCOTIZACION  
	from cotizacion c INNER join usuario us on (us.ID_USUARIO = c.ID_USUARIO_ALTA)
	 inner join cliente cli on (cli.id_cliente = c.id_cliente) " . $Where .$order." LIMIT 1000";
	$result = mysqli_query($GLOBALS["db"], $sql);
?>
<?php
	if (mysqli_num_rows($result) > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			$Enviar ="";
			$Negar ="";
			$AutorizarPedido ="";
			if ($row["ESTADO"]==0 and $row["ESTATUS"]==1) {
			}
			elseif ($row["ESTADO"]==0 or ($row["ESTATUS"]==2 AND $row["ESTADO"]==2 )) {
				$Enviar = '<a id="a" style="cursor:pointer;cursor:click" 
				data-toggle="modal" data-target="#simpleModal" onclick="Autorizar('.$row["ID_COTIZACION"].')"><img src="../../assets/img/iconos/cheque.png" style="" width="18px" height="18px"/></a>';
				$Negar = '<a style="cursor:pointer;cursor:click"
				data-toggle="modal" data-target="#simpleModal2"  onclick="Devolver('.$row["ID_COTIZACION"].',\''.$row["EMAIL"].'\',\''.$row["NOMBRE"].'\',\''.$row["cliente"].'\','.$row["FolioCotizacion"].')"><img src="../../assets/img/iconos/cerrar.png" style="" width="14px" height="14px"/></span></a>';
			} elseif ($row["ESTADO"]==1 and $row["ESTATUS"]==4){
				$AutorizarPedido = '<a id="a" style="cursor:pointer;cursor:click" href="index.php?opcion=APedido&id='.$row["ID_COTIZACION"].'"><img src="../../assets/img/iconos/cheque.png" style="" width="10px" height="10px"/></span> Autorizar Pedido.</a>';
			}
			$Boton = '<label class="empty"></label>';
			if($row["ESTATUS"]==4 and $row["ESTADO"]==3){
				$Boton = '<label class="empty"><a href="index.php?opcion=seguimiento&id='.$row["ID_COTIZACION"].'"><img src="../../assets/img/iconos/rastreo.png" style="" width="20px" height="20px"/></a></label>';
			}
			echo '<div class="line '.$backg.'">
					<label class="empty"><a href="index.php?opcion=RCarr&id='.$row["ID_COTIZACION"].'"><img src="../../assets/img/iconos/lupa.png" style="" width="20px" height="20px"/></a></label>
					<label class="empty"><a href="index.php?opcion=REdit&id='.$row["ID_COTIZACION"].'"><img src="../../assets/img/iconos/boton-editar.png" style="" width="20px" height="20px"/></a></label>
					'.$Boton.'
					<label class="folio">'.$row["ID_COTIZACION"].'</label>
					<label class="fecha">'.$row["FECHA_ALTA"].'</label>
					<label class="cliente">'.$row["NOMBRE"].'</label>
					<label class="subtotal">$ '.number_format($row["SUBTOTAL"], 2, '.', ', ').'</label>
					<label class="descuento">$ '.number_format($row["DESCUENTO"], 2, '.', ', ').'</label>
					<label class="iva">$ '.number_format($row["IVA"], 2, '.', ', ').'</label>
					<label class="total">$ '.number_format($row["TOTAL"], 2, '.', ', ').'</label>
					<label class="estatus">'.$row["ESTATUSt"].'</label>
					<label class="accion">'.$Negar.'</label>
					<label class="accion">'.$Enviar.'</label>
					<label class="accion">' . $AutorizarPedido . '</label>
					<!---<label class="fechaembarque">'.$row["FECHAEMBARQUE"].'</label>
					<label class="estado">' . $row["ESTADOCOTIZACION"] . '</label>--->
				</div>';
		}
	}
?>