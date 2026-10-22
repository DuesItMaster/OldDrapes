<?php
 require_once('lib/nusoap.php');
     
//$cliente = new nusoap_client('http://192.168.1.20/ws/wsDrapesPruebasSAP_PRUEBAS.php');
//$cliente = new nusoap_client('http://192.168.1.20/ws/wsDrapesNuevo.php');
//$cliente = new nusoap_client('http://192.168.1.20/ws/wsDrapesPruebas.php');
 //$cliente = new nusoap_client('http://192.168.1.20/ws/wsDrapesPruebasSAP_PRUEBAS.php');
 $cliente = new nusoap_client('http://192.168.1.20/ws/wsDrapesPruebasSAP_2.php');
     
//**************************************************************************************************************//
    function Tela($Tipo1,$Tipo2,$Tipo3,$Tipo4){ 
 
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $Tipo1,
                                                                        'cod2'    => $Tipo2,
                                                                        'cod3'    => $Tipo3 ,
                                                                        'cod4'    => $Tipo4)
                                                                        );
     
        $resultado = $GLOBALS['cliente']->call('ConsultaTela',$datos_persona_entrada);
         
        return $resultado;

    }

//**************************************************************************************************************//


function Forro($Tipo1){ 
 
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $Tipo1)
                                                                        );
     
        $resultado = $GLOBALS['cliente']->call('ConsultaForro',$datos_persona_entrada);
         
        return $resultado;

    }

//**************************************************************************************************************//

 function Comodin($Tipo1){ 
 
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $Tipo1)
                                                                        );
     
        $resultado = $GLOBALS['cliente']->call('ConsultaComodin',$datos_persona_entrada);
         
        return $resultado;

    }

//**************************************************************************************************************//


function ColoresTela($Tipo1){ 
        
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $Tipo1)
                                                                        );
     
        $resultadoColor = $GLOBALS['cliente']->call('ConsultaColoresTela',$datos_persona_entrada);
         
        return $resultadoColor;

    }


 //******************************************* NUEVO *******************************************************************//

function ColoresTela2($codigotela, $TipoTela){ 
        
    $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                    'cod1'    => $codigotela,
                                                                    'cod2'    =>$TipoTela)
                                                                    );
 
    $resultadoColor2 = $GLOBALS['cliente']->call('ConsultaColoresTela2',$datos_persona_entrada);
     
    return $resultadoColor2;

}

//**************************************************************************************************************//


function CostoTela($TipoTela, $Color){
        //ConsultaCostoTela

        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $TipoTela,
                                                                        'cod2'    => $Color)
                                                                        );
     
        $resultadoCosto = $GLOBALS['cliente']->call('ConsultaCostoTela',$datos_persona_entrada);

        return $resultadoCosto;

    }

//**************************************************************************************************************//

function TipoManoObra($TipoManoObra,$TipoTela,$Cafe,$Cinta){

        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $TipoManoObra,
                                                                        'cod2'    => $TipoTela,
                                                                        'cod3'    => $Cafe,
                                                                        'cod4'    => $Cinta)
                                                                        );
     
        $resultadoMo = $GLOBALS['cliente']->call('ConsultaManoObra',$datos_persona_entrada);

        return $resultadoMo;

    }


//**************************************************************************************************************//

    function TipoArgolla($U_DD_NOMBRES,$U_DD_PRODUCTOS,$U_DD_ARTICULO,$U_DD_ACTIVO,$U_DD_COLOR){
    
    $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                    'cod1'    => $U_DD_NOMBRES,
                                                                    'cod2'    => $U_DD_PRODUCTOS,
                                                                    'cod3'    => $U_DD_ARTICULO,
                                                                    'cod4'    => $U_DD_ARTICULO,
                                                                    'cod5'    => $U_DD_COLOR)
                                                                    );
    
    $resultadoMo = $GLOBALS['cliente']->call('ConsultaArgolla',$datos_persona_entrada);

    return $resultadoMo;
    }

//**************************************************************************************************************//



  function ConsultaStiffener($TipoManoObra){
        
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $TipoManoObra)
                                                                        );
     
        $resultadoMo = $GLOBALS['cliente']->call('ConsultaStiffener',$datos_persona_entrada);

        return $resultadoMo;

    }


//**************************************************************************************************************//


  function ConsultaMicroFibra($MicroFibra){
        
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $MicroFibra)
                                                                        );
     
        $resultadoMo = $GLOBALS['cliente']->call('ConsultaMicroFibra',$datos_persona_entrada);

        return $resultadoMo;

    }

    function ConsultaEscuadras($MicroFibra){
        
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $MicroFibra)
                                                                        );
     
        $resultadoMo = $GLOBALS['cliente']->call('ConsultaEscuadras',$datos_persona_entrada);

        return $resultadoMo;

    }


//**************************************************************************************************************//



  function ConsultaMecanismoPersiana($Alto,$Ancho,$Varilla){
	$Alto = redondearDecimas($Alto);
        $Ancho = redondearDecimas($Ancho);
		
        
        $datos_persona_entrada = array( "datos_persona_entrada" => array(    
                                                                        'cod1'    => $Alto,
                                                                        'cod2'    => $Ancho,
                                                                        'cod3'    => $Varilla)
                                                                        );
     
        $resultadoMo = $GLOBALS['cliente']->call('ConsultaMecanismoPersiana',$datos_persona_entrada);

        return $resultadoMo;

    }

   function redondearDecimas($numero) {

        if($numero < 1){
            $numero = '1.00';
        }

        $decimales = explode('.', $numero);
        if (count($decimales) === 2) {
            $decimal = $decimales[1];
            if ($decimal >= 91) {
                return (float)($decimales[0] + 1);
            } elseif (strlen($decimal) > 1) {
                $decimal = ceil($decimal / 10) * 10; // Redondear al siguiente m�ltiplo de 10
                $numeroRedondeado = (float)($decimales[0] . '.' . $decimal);
                return number_format($numeroRedondeado, 2); // Conservar dos decimales en la representaci�n
            }
        }
        return $numero;
    }

//**************************************************************************************************************//


    function Costo($ancho,$colorentrada,$tipoCortinero,$remate,$soporte,$argolla,$fijacion,$resultadoSistema,$decorativo,$peso)
    {
    $datos_persona_entrada = array( "datos_persona_entrada" => array('CodNombres'=>$tipoCortinero,
                                                                     'CodRemate'=>$remate,
                                                                     'CodFijacion'=>$fijacion,
                                                                     'CodSoporte'=>$soporte,
                                                                     'CodSistema'=>$resultadoSistema,
                                                                     'CodDecorativo'=>$decorativo,
                                                                     'CodArgolla'=>$argolla,
                                                                     'CodAncho'=>$ancho,
                                                                     'CodColor'=>$colorentrada,
                                                                     'CodPeso'=>$peso));
    $resultado = $GLOBALS['cliente']->call('ConsultaCostoCortinero',$datos_persona_entrada);//print_r($datos_persona_entrada);

    return $resultado;
}

//**************************************************************************************************************//

function colores($Idllegada)
{
    $datos_persona_entrada = array("datos_persona_entrada" => array('cod1' => $Idllegada));
    $resultado = $GLOBALS['cliente']->call('ConsultaColorCortinero', $datos_persona_entrada);

    $res1 = array();
    $filas = count($resultado);
    for ($i = 0; $i < $filas; $i++)
    {
        array_push($res1, $resultado[$i]['color']);
    }

    return $res1;
}

//**************************************************************************************************************//

    function CostoBaston($colorBaston,$materialBaston,$medidaBaston)
    {
    $datos_persona_entrada = array( "datos_persona_entrada" => array('CodMaterial'=>$materialBaston,                                                                     
                                                                     'CodAlto'=>$medidaBaston,
                                                                     'CodColorBaston'=>$colorBaston));                                                                    
    $resultado = $GLOBALS['cliente']->call('ConsultaCostoBaston',$datos_persona_entrada);
    //print_r($datos_persona_entrada);//print_r($resultado);

    return $resultado;
}

/****************************************************************************************************************/

function CostoCortineroCompleto($CodNombres, $CodRemate, $CodFijacion, $CodSoporte, $CodSistema, 
    $CodDecorativo, $CodArgolla, $CodAncho, $CodColor, $CodPeso, $CodMaterial, $CodAlto, $CodColorBaston, 
    $CodControlMot, $CodControlMotNombre)
{ 
    $datos_entrada = [
        'CodNombres' => $CodNombres,
        'CodRemate' => $CodRemate,
        'CodFijacion' => $CodFijacion,
        'CodSoporte' => $CodSoporte,
        'CodSistema' => $CodSistema,
        'CodDecorativo' => $CodDecorativo,
        'CodArgolla' => $CodArgolla,
        'CodAncho' => $CodAncho,
        'CodColor' => $CodColor,
        'CodPeso' => $CodPeso,
        'CodMaterial' => $CodMaterial,
        'CodAlto' => $CodAlto,
        'CodColorBaston' => $CodColorBaston,
        'CodControlMot' => $CodControlMot,
        'CodControlMotNombre' => $CodControlMotNombre
    ];

    $resultado = $GLOBALS['cliente']->call('ConsultaCostoCortineroCompleto', $datos_entrada);//print_r($resultado);

    return $resultado;
}

//**************************************************************************************************************

    function PrecioBajoPlomoWSF(){
    $datos_persona_entrada = array( "datos_persona_entrada" => array('CodNombre'=>'51'));
    $resultado = $GLOBALS['cliente']->call('ConsultaPrecioBajoPlomo',$datos_persona_entrada);
    return $resultado;
    }
//**************************************************************************************************************

//**************************************************************************************************************

    function Email($Codigo){
        $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'=>$Codigo));                                                                    
        $resultado = $GLOBALS['cliente']->call('ConsultaCorreo',$datos_persona_entrada);
        return $resultado;
    }

    function StockTela($CodigoTela){
        $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'=>$CodigoTela));                                                                    
        $resultado = $GLOBALS['cliente']->call('ConsultaStock',$datos_persona_entrada);
        return $resultado;
    }

    function Compras($CodigoTela){
        $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'=>$CodigoTela));                                                                    
        $resultado = $GLOBALS['cliente']->call('ConsultaCompras',$datos_persona_entrada);
        return $resultado;
    }

    function PedidosEntregados($Condicion){
        $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'=>$Condicion));                                                                    
        $resultado = $GLOBALS['cliente']->call('ConsultaPedidosEntregados',$datos_persona_entrada);
        return $resultado;
    }

    function ConsultaFoliosEnPedido($Condicion){
        $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'=>$Condicion));                                                                    
        $resultado = $GLOBALS['cliente']->call('ConsultaFoliosEnPedido',$datos_persona_entrada);
        return $resultado;
    }

//**************************************************************************************************************


function DatosEnFirme ($Folio)
{
    $datos_entrada = [
        'cod1' => $Folio
    ];

    $resultado = $GLOBALS['cliente']->call('ConsultaPedido', $datos_entrada); 
    
    return $resultado;
}


function DatosProductos ($DocNum)
{
    $datos_entrada = [
        'cod1' => $DocNum
    ];

    $resultado = $GLOBALS['cliente']->call('ConsultaProductos', $datos_entrada); 
    
    return $resultado;
}


function DatosFolioFacturas ($DocNum)
{
    $datos_entrada = [
        'cod1' => $DocNum
    ];

    $resultado = $GLOBALS['cliente']->call('ConsultaFolioFacturas', $datos_entrada); 
    
    return $resultado;
}


function DatosFolioComplementos ($Factura)
{
    $datos_entrada = [
        'cod1' => $Factura
    ];

    $resultado = $GLOBALS['cliente']->call('ConsultaFolioComplementos', $datos_entrada); 
    
    return $resultado;
}

function TipoControl($idControl,$idControl2)
{

    $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1' => $idControl, 'cod2' => $idControl2 ));

    $resultado = $GLOBALS['cliente']->call('ConsultaTipoControlesMotorizados',$datos_persona_entrada);

    return $resultado;
}

function DatosControles($idControl)
{

    $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'    => $idControl));

    $resultado = $GLOBALS['cliente']->call('ConsultaControlesMotorizados',$datos_persona_entrada);

    return $resultado;
}

function CanalesControl($codigoCont)
{

    $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'    => $codigoCont));

    $resultado = $GLOBALS['cliente']->call('ConsultaCanalesControl',$datos_persona_entrada);

    return $resultado;
}

function entra(){
    return "true";
}

?>