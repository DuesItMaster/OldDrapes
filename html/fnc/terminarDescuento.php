<?php

require_once '../../conexion/cnx.php';


function TraerDescuento($id_usuario){
	$Desc = Array();
	$sql = "SELECT descuento from usuario_desc where id_usuario=".$id_usuario." order by descuento desc;";
		
	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	    	array_push($Desc, $row["descuento"]);    
	    }
	} 

	return $Desc;

}



function GenerarDescuento($Importe){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuento($_SESSION['login_user']);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = $Importe;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		return $porcentaje;

	} else {

		return 0;
	}
}



function GenerarPorcentaje(){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuento($_SESSION['login_user']);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = 100;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		$porcentajeFinal = 100 - $porcentaje;
		return $porcentajeFinal;

	} else {

		return 0;
	}
}

function GenerarPorcentajeCortineroMotorizado($TotalPorcentaje) 
{
    // Nueva regla: si el descuento es muy bajo (5% o menos), se convierte en cero.
    if ($TotalPorcentaje <= 5)
    {
        return 0;
    }
    
    // Para cualquier otro descuento, se aplica completo, SIN RESTARLE NADA.
    return $TotalPorcentaje;
}

// **************************************************************************************************

function GenerarCantidadFinal($TotalPorcentaje,$Precio,$Unidades,$tipoarticulo,$TipoArticuloDetalle){

    if ($TotalPorcentaje==0) {
        return "0.00";
    }
    else{

        // Lista de todos los productos especiales (Somfy)
        $esProductoEspecial = ($tipoarticulo =="cortinero" && ($TipoArticuloDetalle=="glydea" || $TipoArticuloDetalle=="glystro" || $TipoArticuloDetalle == "movelite" || $TipoArticuloDetalle == "irismo"|| $TipoArticuloDetalle == "gabin" || $TipoArticuloDetalle == "forest")) || 
                              ($tipoarticulo == "DOMOTICA" || $tipoarticulo == "SITUO" || $tipoarticulo == "CONTROL PARED");

        if ($esProductoEspecial) {
            // REGLA PARA PRODUCTOS ESPECIALES (SOMFY)
            
            if ($TotalPorcentaje <= 5 ) 
            {
                $TotalPorcentajeFinal = 0;
            } 
            elseif ($TotalPorcentaje >= 30 ) 
            {
                // YA NO SE LIMITA A 35%. SE APLICA EL DESCUENTO COMPLETO.
                $TotalPorcentajeFinal  = $TotalPorcentaje;     
            } 
            else 
            {
                // Para descuentos intermedios, se sigue restando 5
                $TotalPorcentajeFinal = $TotalPorcentaje - 5;
            }

        } else {
            // REGLA PARA PRODUCTOS NORMALES
            // Para cualquier otro producto que no esté en la lista, se aplica el descuento completo.
            $TotalPorcentajeFinal = $TotalPorcentaje;
        }
        
        // CÁLCULO FINAL
        if ($TotalPorcentajeFinal <= 0) :
            return "0.00";
        else : 
            $valor = ($Unidades * $Precio) * ($TotalPorcentajeFinal / 100) ;
            return $valor;
        endif;
    }   
}
// *************************************************************************************************

function TraerDescuentoPorID($idCot){
	$Desc = Array();
	$sql = "SELECT descuento from cotizacion_descuento where id_cotizacion=".$idCot." order by descuento desc;";
		
	$result = mysqli_query($GLOBALS["db"], $sql);

	if (mysqli_num_rows($result) > 0) {
	    // output data of each row
	    while($row = mysqli_fetch_assoc($result)) {
	    	array_push($Desc, $row["descuento"]);    
	    }
	} 

	return $Desc;

}



function GenerarDescuentoPorID($Importe,$idCot){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuentoPorID($idCot);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = $Importe;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		return $porcentaje;

	} else {

		return 0;
	}
}



function GenerarPorcentajePorId($idCot){

	//echo "ENTRO A DESCUENTO" ;
	$Descuento = TraerDescuentoPorID($idCot);
	//$porcentaje = $carrito->precio_total();
	$porcentaje = 100;
	
	if (count($Descuento)>0){
		foreach ($Descuento as $Desc) {
			$porcentaje = $porcentaje - ($porcentaje * ($Desc/100));
		}

		$porcentajeFinal = 100 - $porcentaje;
		return $porcentajeFinal;

	} else {

		return 0;
	}
}




function SacarTotalesCortineroMotorizado(){

	$carrito = new Carrito();
	$carro = $carrito->get_content();
	
	$valor=0;
	$TotalArticulo=0;
	$SumTotalArticulo = 0;

	if (!isset($_SESSION['folio'])){
		//echo "SOY COTIZACION NUEVA " .  $_SESSION['folio'];
		//$iva = TraerIva();
		$DescuentoProducto = TraerDescuento($_SESSION['login_user']);
		$TotalPorcentaje =  GenerarPorcentaje();
		//$DescuentoPorcentaje = GenerarCantidadFinal($TotalPorcentaje,$carrito->precio_total(),1);
	}
	else{
		//ECHO "SOY COTIZACION DE REPORTE " . $_SESSION['folio'];
		//$iva = TraerIvaPorId($_SESSION['folio']);
		$DescuentoProducto = TraerDescuentoPorID($_SESSION['folio']);
		$TotalPorcentaje =  GenerarPorcentajePorId($_SESSION['folio']);
	}

	if($carro) {
		
		foreach($carro as $producto){
			
			$valor = GenerarCantidadFinal($TotalPorcentaje,$producto["precio"],$producto["cantidad"],$producto["tipoarticulo"],$producto["TipoArticuloDetalle"]);
			$TotalArticulo = ($producto["cantidad"] * $producto["precio"])-$valor;
			$SumTotalArticulo = $SumTotalArticulo + $TotalArticulo;
		}
	}


	return $SumTotalArticulo;
}


/*function SumarDescuento($Importe){

			//echo "ENTRO A DESCUENTO" ;
			$Descuento = TraerDescuento($_SESSION['login_user']);
			//$porcentaje = $carrito->precio_total();
			$porcentaje = $Importe;
			$valor = 0;
			
			if (count($Descuento)>0){
				foreach ($Descuento as $Desc) {
					$valor = $valor - ($porcentaje * ($Desc/100));
					$porcentaje  = $porcentaje -$valor;
				}

				return $valor;

			} else {

				return 0;
			}

		}*/

?>