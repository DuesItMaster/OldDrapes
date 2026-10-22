<?php
require_once '../../conexion/cnx.php';
require_once '../../conexion/wsConsumeDrapes.php';
require_once 'FormulasCortina.php';

	function TraerTipoTela($Confeccion)
	{
		$tipo = array();
		$sql = "SELECT tipo from confeccion c inner join confeccion_det cd on (c.id_confeccion = cd.id_confeccion) 
				inner join tipotela t on (cd.id_tipotela = t.ID_TIPOTELA) where c.CLAVE='".$Confeccion."' and cd.estatus=1;";
		
		$result = mysqli_query($GLOBALS["db"], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	array_push($tipo, $row["tipo"]);    
		    }
		} else {		    
		    $a = "No hay resultados";
		}

		$Cantidad = count($tipo);

		for($i=$Cantidad; $i<4; $i++ ){
			$tipo[$Cantidad]="";
		}

		$Telas = TraerTelas($tipo[0],$tipo[1],$tipo[2],$tipo[3]);
		$result->free();
		return $Telas;
	}

	//VALIDACION MEDIDAS//
	function TraerMedidasMaximas($Confeccion)
	{
		$medidas = array();

		$sql = "SELECT * FROM Validacion_Medidas_Cortinas WHERE claveCortina = '$Confeccion' ORDER BY anchoMax";

		$result = mysqli_query($GLOBALS["db"], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	array_push($medidas, array('anchomax'=>$row["anchoMax"],  'altomax'=>$row['altoMax']));    
		    }
		}
		$result->free();
		return $medidas;
	}
	//VALIDACION MEDIDAS//


	function TraerForro($Tela1)
	{
		$ArregloTela1 = Forro($Tela1);
		return $ArregloTela1;
	}

	function TraerAccesorio($Estilo)
	{
		$Accesorio = array();

		$sql ="SELECT a.NOMBRE, a.DESCRIPCION  FROM confeccion c 
							   inner join confeccion_accesorio ca on (ca.id_confeccion=c.id_confeccion) 
							   inner join accesorio a on (a.id_accesorio = ca.id_accesorio)
							   where c.clave='$Estilo' and tipotela=0 and estatus=1";

		$result = mysqli_query($GLOBALS["db"], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {

		    	array_push($Accesorio, array('nombre'=>$row["NOMBRE"],  'descripcion'=>$row['DESCRIPCION']));    

		    }
		}

		$result->free();

		return $Accesorio;
	}



	function TraerAccesorioporTela($TipoTela){
		$AccesorioTela = array();

		$sql ="SELECT NOMBRE, a.DESCRIPCION FROM tipotela_det td 
											inner join tipotela t on (t.id_tipotela = td.id_tipotela) 
											inner join accesorio a on (a.id_accesorio = td.id_accesorio) where estatus=1 and tipo='$TipoTela'";

		$result = mysqli_query($GLOBALS["db"], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	array_push($AccesorioTela, array('nombre'=>$row["NOMBRE"], 'descripcion'=>$row['DESCRIPCION']));    
		    }
		}

		$result->free();
		return $AccesorioTela;
	}
	


	function TraerTelas($Tela1,$Tela2,$Tela3,$Tela4){
		//$ArregloTela = array();
		$ArregloTela = Tela($Tela1,$Tela2,$Tela3,$Tela4);

		return $ArregloTela;
	}



	function TraerColoresTelas($Tela1){

		$ArregloTela1 = ColoresTela($Tela1);

		return $ArregloTela1;

	}

	//------------- NUEVO ---------------------//
	function TraerColoresTelas2($codigotela, $TipoTela){
		
		$ArregloTela1 = ColoresTela2($codigotela,$TipoTela);

		return $ArregloTela1;

	}

	Function TraerPrecioTela($Clave,$Tipo,$Alto,$Ancho,$Color,$Tela,$Stiffener,$ForroX,$BajoPlomo,$Cafe,$Argolla,$Cinta){

		$GLOBALS["Alto"] = $Alto; 
		$GLOBALS["Ancho"] = $Ancho;
		$NeverLight  = FALSE;
		$TamañoNeverLight=0;
		$preciomo = 0;
		$codigomo = "";

		$PrecioBajoPlomoWS=PrecioBajoPlomoWSF();
		$Filas = count($PrecioBajoPlomoWS);
		for( $i=0; $i<$Filas; $i++ ){
			$PBPWS=$PrecioBajoPlomoWS[$i]['CostoUni'];
			$CodigoBajoPlomo=$PrecioBajoPlomoWS[$i]['codigo'];
    	}

		$ArregloFinal =  array();

		//CHECAR POR MYSQL VARIABLES DEL ESTILO Y TIPO DE CORTINA
		$sql =" SELECT tipo,nombre,clave, desp, bastilla, medidaplomo, bajoplomo, estatus, maxalto, traslape, manoobra,
				(SELECT PLOMORAPPORT from varios) plomorapport,(SELECT PLOMORAPPORTONDULADO from varios) plomorapportOndulado, ifnull((select plitz from confeccion_det_ex where id_confeccion_det = cd.id_confeccion_det and tela='".$Tela."'),plitz) as plitz
				from confeccion_det cd 
				inner join confeccion c on (c.id_confeccion = cd.id_confeccion)
				inner join tipotela t on (t.id_tipotela = cd.id_tipotela) where clave= '$Clave' and tipo ='$Tipo'; ";

     
		$result = mysqli_query($GLOBALS["db"], $sql);


		//var_dump(	$sql);	

		if (mysqli_num_rows($result) > 0) {

		    $row = mysqli_fetch_assoc($result);
			
			$GLOBALS["nombre"] = $row["nombre"];
			$GLOBALS["FactorPlitz"] = $row["plitz"];
			$GLOBALS["FactorDesp"] = $row["desp"];
			$GLOBALS["Bastilla"] = $row["bastilla"];
			$GLOBALS["TamañoBajoPlomo"] = $row["medidaplomo"];
			$GLOBALS["Traslape"] = $row["traslape"];	
			$TipoManoObra = $row["manoobra"];
			$GLOBALS["PrecioBajoPlomo"] = $PBPWS /*$row["PRECIOBAJOPLOMO"]*/;
			// Forzamos la opción de Bajo Plomo a estar disponible, ya que la columna no existe en la BD.
$GLOBALS["TelaBajoPlomo"] = TRUE;
			if ($Clave=="Ond"){
				$GLOBALS["plomorapportMedida"] = $row["plomorapportOndulado"];	
			} else{
				$GLOBALS["plomorapportMedida"] = $row["plomorapport"];	
			}
					
		}

		//$sql = "select plitz confeccion_det_ex from ";
	    
		//CHECAR POR WEB SERVICE EL PRECIO DE LA TELA Y SU ANCHO
		$ArregloPrecioTela = CostoTela($Tela,$Color);

		$Filas = count($ArregloPrecioTela);
		for( $i=0; $i<$Filas; $i++ ){

			$CodigoTela = $ArregloPrecioTela[$i]['codigo'];
			$GLOBALS["AnchoTela"] = $ArregloPrecioTela[$i]['ancho']; 
			$GLOBALS["PrecioTela"] = $ArregloPrecioTela[$i]['precio'];

			$GLOBALS["rapport"] = $ArregloPrecioTela[$i]['rapport']; 
			$GLOBALS["rapportPlomo"] = $ArregloPrecioTela[$i]['rapportPlomo'];
			$GLOBALS["rapportHor"] = $ArregloPrecioTela[$i]['rapportHor']; 
			$GLOBALS["rapportVert"] = $ArregloPrecioTela[$i]['rapportVert'];
			$GLOBALS["rapportTra"] = $ArregloPrecioTela[$i]['rapportTra'];
		}

		
		//CHECAR POR WEB SERVICE EL CODIGO DE COMODIN
		// OVERRIDE: Si es Ondulada Pasabarra (PaT), usar el nombre correcto de SAP
		$nombreParaSAP = $GLOBALS["nombre"];
		if ($Clave == 'PaT') {
			$nombreParaSAP = "CORTINA ONDULADA PASABARRA";
		}

		$ArregloCodigoComodin = Comodin($nombreParaSAP);

		$Filas = count($ArregloCodigoComodin);
		for( $i=0; $i<$Filas; $i++ ){
			$GLOBALS["CodigoComodin"] = $ArregloCodigoComodin[$i]['codigo'];
		}

		// FALLBACK: Si SAP devuelve vacío y es Ondulada Pasabarra, hardcodear el código conocido.
		if ((!isset($GLOBALS["CodigoComodin"]) || $GLOBALS["CodigoComodin"] == "") && $Clave == 'PaT'){
			$GLOBALS["CodigoComodin"] = "CORTONDPASAB"; // Código SAP para Cortina Ondulada Pasabarra
		}

		if (!isset($GLOBALS["CodigoComodin"]) || $GLOBALS["CodigoComodin"] == ""){
			$ArregloCodigoComodin = Comodin($Clave);
			$Filas = count($ArregloCodigoComodin);
			for( $i=0; $i<$Filas; $i++ ){
				$GLOBALS["CodigoComodin"] = $ArregloCodigoComodin[$i]['codigo'];
			}
		}

		// TRAER MANOS DE OBRA
		// $TipoManoObra
		if ($ForroX=="SI"){
			?> <!--<script type="text/javascript">
				var TipoManoObra = "<?php echo $TipoManoObra; ?>" ;
				var Tipo = "<?php echo $Tipo; ?>" ;
				var Cafe = "<?php echo $Cafe; ?>" ;	
				alert('Mano Obra  ' + TipoManoObra + ' ' + Tipo + ' Cafe ' + Cafe );
			</script>-->
			<?php
		}

		$ArregloMO = TipoManoObra($TipoManoObra,$Tipo,$Cafe,$Cinta);

		$Filas = count($ArregloMO);
		for( $i=0; $i<$Filas; $i++ ){
			$preciomo = $ArregloMO[$i]['precio'];
			$codigomo = $ArregloMO[$i]['codigo'];
			if ($ArregloMO[$i]['ancho'] == '0') {
				//$codigoMU = $ArregloMO[$i]['codigo'];
				$GLOBALS["CodigoManoObraMu"] =$ArregloMO[$i]['codigo'];
				$GLOBALS["ManoObraMu"] = $ArregloMO[$i]['precio'];
				//$ArregloMO[$i]['color'];
			}

			if ($ArregloMO[$i]['ancho'] == '1.4') {
				$GLOBALS["CodigoManoObraLz14"] =$ArregloMO[$i]['codigo'];
				$GLOBALS["ManoObraLz14"] = $ArregloMO[$i]['precio'];
				//$ArregloMO[$i]['color'];
			}

			if ($ArregloMO[$i]['ancho'] == '2.8') {
				?>
				<!--<script type="text/javascript">
					var variablejs = "<?php echo $ArregloMO[$i]['codigo']; ?>" ;
					var variableFila = "<?php echo $Filas; ?>" ;
					
					alert('Mano Obra 2.8 ' + variablejs + ' ' + variableFila);
				</script>-->
				<?php			
				$GLOBALS["CodigoManoObraLz28"] =$ArregloMO[$i]['codigo'];
				$GLOBALS["ManoObraLz28"] = $ArregloMO[$i]['precio'];
			}

			if ($ArregloMO[$i]['ancho'] == '3') {
				$GLOBALS["CodigoManoObraLz3"] =$ArregloMO[$i]['codigo'];
				$GLOBALS["ManoObraLz3"] = $ArregloMO[$i]['precio'];
			}

			if ($ArregloMO[$i]['ancho'] == '3.2') {
				$GLOBALS["CodigoManoObraLz32"] =$ArregloMO[$i]['codigo'];
				$GLOBALS["ManoObraLz32"] = $ArregloMO[$i]['precio'];
			}
		}

		if ($TipoManoObra == 'CINTA FRUNCIDORA' ||  $TipoManoObra == 'ONDULADO' || $TipoManoObra == 'CINTA FRUNCIDORA PASABARRAS' || $TipoManoObra == 'CINTA PASABARRAS TRANSPARENTE'){

		}else{
					
			$GLOBALS["CodigoManoObraLz3"] =$GLOBALS["CodigoManoObraLz28"];
			$GLOBALS["ManoObraLz3"] = $GLOBALS["ManoObraLz28"];
			$GLOBALS["CodigoManoObraLz32"] =$GLOBALS["CodigoManoObraLz28"];
			$GLOBALS["ManoObraLz32"] = $GLOBALS["ManoObraLz28"];
		}
		/*}
		else{
			$GLOBALS[CodigoManoObraMu] ="";
			$GLOBALS[ManoObraMu] = 0;
			$GLOBALS[CodigoManoObraLz14] ="";
			$GLOBALS[ManoObraLz14] = 0;
			$GLOBALS[CodigoManoObraLz28] ="";
			$GLOBALS[ManoObraLz28] = 0;
		}*/

		if ($Stiffener=="SI" || $Stiffener=="STIFFENER"){
			$ValorSti = ConsultaStiffener("SI");
			$Filas = count($ValorSti);
			for( $i=0; $i<$Filas; $i++ ){
				$CodigoStiffener = $ValorSti[$i]['codigo']; 
				$GLOBALS["PrecioStiffener"] = $ValorSti[$i]['precio'];
			}
		}
		else{
			$CodigoStiffener ="";
			$GLOBALS["PrecioStiffener"] = 0.00;
		}

		if ($Argolla == "SI"){
			$Color = "ESTANDAR";
			if($Cafe == "SI"){
				$Color = "CAFE";
			}
			$ArregloArgolla = TipoArgolla(106,'ARGOLLA','SI','SI',$Color);
			$CodigoArgolla = $ArregloArgolla[0]['codigo'];
			$GLOBALS["PrecioArgolla"] = $ArregloArgolla[0]['precio'];

			$FactorPlizaje = 2.5;
			$CantidadArgolla = ceil(($Ancho * $FactorPlizaje) / .18);
			if ($CantidadArgolla%2 <> 0){
				$CantidadArgolla = $CantidadArgolla + 1;
			}
			
			$precioArgollad = $GLOBALS["PrecioArgolla"] * $CantidadArgolla;
		}
		else{
			$CodigoArgolla = "";
			$CantidadArgolla = 0;
			$GLOBALS["PrecioArgolla"] = 0.00;
			$precioArgollad = 0;
		}
		  
		$valorFormula = Cotizar($GLOBALS["Alto"], 
								$GLOBALS["Ancho"],
								$GLOBALS["FactorPlitz"],
								$GLOBALS["FactorDesp"], 
								$GLOBALS["Bastilla"] ,
								$GLOBALS["TamañoBajoPlomo"] ,
								$GLOBALS["Traslape"]  ,
								$GLOBALS["PrecioBajoPlomo"] ,
								$GLOBALS["TelaBajoPlomo"],
								$GLOBALS["AnchoTela"],
								$GLOBALS["PrecioTela"],
								$GLOBALS["ManoObraMu"],
								$GLOBALS["ManoObraLz14"],
								$GLOBALS["ManoObraLz28"],
								$GLOBALS["ManoObraLz3"],
								$GLOBALS["ManoObraLz32"],
								$NeverLight,
								$TamañoNeverLight,
								$Stiffener,
								$GLOBALS["PrecioStiffener"],
								$GLOBALS["CodigoManoObraMu"],
								$GLOBALS["CodigoManoObraLz14"],
								$GLOBALS["CodigoManoObraLz28"],
								$GLOBALS["CodigoManoObraLz3"],
								$GLOBALS["CodigoManoObraLz32"],
								$BajoPlomo,
								$GLOBALS["rapport"], 
								$GLOBALS["rapportPlomo"],
								$GLOBALS["rapportHor"], 
								$GLOBALS["rapportVert"],
								$GLOBALS["plomorapportMedida"],
								$GLOBALS["rapportTra"],
								$Argolla,
								$precioArgollad,
								$CantidadArgolla
								
								);


		
		//$ArregloFinal = array('Precio'=>$valorFormula,'CodigoTela'=>$CodigoTela,'CodigoMo'=>$codigoMo);
		// ESTA ES LA VERSIÓN CORRECTA Y SIMPLIFICADA
if ($GLOBALS["TelaBajoPlomo"] == TRUE) {
    $BajoPlomoOp = "SI";
} else {  

	 
    $BajoPlomoOp = "NO";
}

		/*if ($Alto > 3) {
		$PrecioFinal = $valorFormula[0]["precioformula"] + ($valorFormula[0]['PrecioMo'] * ($valorFormula[0]['MetrajeMo']/2));
		//$PrecioFinal = $valorFormula[0]["PrecioReal"] + ($valorFormula[0]['PrecioMoReal'] * ($valorFormula[0]['MetrajeMOReal']/2));
	} else {
		$PrecioFinal = $valorFormula[0]["precioformula"];
		//$PrecioFinal = $valorFormula[0]["PrecioReal"];
	}*/

// 🔧 Cálculo corregido del precio final
if ($ForroX == "SI") {
    // Si hay forro, solo pagar tela + 30% de la MO (restamos el 70% de MO)
    $soloTela = $valorFormula[0]['PrecioTela'] * $valorFormula[0]['Metraje'];
    $soloMO   = ($valorFormula[0]['PrecioMo'] * $valorFormula[0]['MetrajeMo']) * 0.3;
    $PrecioFinal = $soloTela + $soloMO;
} else if ($Alto > 3 && $ForroX == "NO") {
    // Sin forro pero con incremento por altura
    $PrecioFinal = $valorFormula[0]["precioformula"] + ($valorFormula[0]['PrecioMo'] * ($valorFormula[0]['MetrajeMo']/2));
} else {
    // Normal
    $PrecioFinal = $valorFormula[0]["precioformula"];
}


	/*$valorFormula[0]['PrecioMoReal'] = $valorFormula[0]['PrecioMoReal'] * $valorFormula[0]['MetrajeMOReal'];
	$valorFormula[0]['PrecioReal'] = $valorFormula[0]['PrecioReal'] - $valorFormula[0]['PrecioMoReal'];*/


	array_push($ArregloFinal, array('Precio'=> $valorFormula[0]["precioformula"],'CodigoTela'=> $CodigoTela,
									'CodigoMo'=> $valorFormula[0]['CodigoManoObra'],'PrecioMo'=>$valorFormula[0]['PrecioMo'],
									"PrecioTela"=>$GLOBALS["PrecioTela"],"CodigoComodin"=>$GLOBALS["CodigoComodin"],"Metraje"=>$valorFormula[0]['Metraje'],
									"LienzoTotal"=>$valorFormula[0]['LienzoTotal'],"Altura"=>$valorFormula[0]['Altura'],
									"CodigoStiffener"=>$CodigoStiffener,"PrecioStiffener"=>$GLOBALS["PrecioStiffener"],"TipoFormula"=>$valorFormula[0]['TipoFormula'],
									"MetrajeMo"=>$valorFormula[0]['MetrajeMo'],"TipoManoObra"=>$TipoManoObra , "Tipo"=>$Tipo,
									'rapportAltura'=>$valorFormula[0]['rapportAltura'],'rapportVert'=>$valorFormula[0]['rapportVert'],
									"PrecioPlomo"=>$GLOBALS["PrecioBajoPlomo"],'rapportHor'=>$valorFormula[0]['rapportHor'],
									'TelaBajoPlomo'=>$BajoPlomoOp,'CodigoBajoPlomo'=>$CodigoBajoPlomo,'MetrajeBajoPlomo'=>$valorFormula[0]['MetrajeBajoPlomo'], 'MetrajeReal'=>$valorFormula[0]['MetrajeReal'],
									'MetrajeMOReal'=>$valorFormula[0]['MetrajeMOReal'],'PrecioReal'=>$valorFormula[0]['PrecioReal'],'PrecioMoReal'=>$valorFormula[0]['PrecioMoReal'], "CodigoArgolla"=>$CodigoArgolla,
									"PrecioArgolla"=>$GLOBALS["PrecioArgolla"],"CantidadArgolla"=>$CantidadArgolla, "MetrajeBajoPlomoReal"=>$valorFormula[0]['MetrajeBajoPlomoReal'],
									'rapportPlomo'=>$GLOBALS["rapportPlomo"],"PrecioFinal" => $PrecioFinal)); 
	/* 
	'MetrajeReal'=>$valorFormula[0]['MetrajeReal'],'MetrajeMOReal'=>$valorFormula[0]['MetrajeMOReal'],'PrecioReal'=>$valorFormula[0]['PrecioReal'],'PrecioMoReal'=>$valorFormula[0]['PrecioMoReal'], "CodigoArgolla"=>$CodigoArgolla,"PrecioArgolla"=>$GLOBALS["PrecioArgolla"],"CantidadArgolla"=>$CantidadArgolla, "MetrajeBajoPlomoReal"=>$valorFormula[0]['MetrajeBajoPlomoReal'], 
	*/

	//array_push($ArregloFinal,array('Precio'=>$valorFormula,'CodigoTela'=>$CodigoTela,'CodigoMo'=>$codigoMo));
	//$ArregloFinal=array();
	//array_push($ArregloFinal,$valorFormula,$CodigoTela,$codigoMo);
			
	return $ArregloFinal;
	}
