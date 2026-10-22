<pre>
<?php
    require_once('lib/nusoap.php');
    $cliente = new nusoap_client('http://192.168.1.20/ws/wsDrapesPruebas.php');
    $datos_persona_entrada = array( "datos_persona_entrada" => array('cod1'    => "31"));
    $resultado = $cliente->call('ConsultaColorCortinero',$datos_persona_entrada);
    echo "<br/>";
    echo "<br/>";
    $filas = count($resultado);
    for( $i=0; $i<$filas; $i++ ){
        $res1=($resultado[$i]['color']);
            /*print_r( $resultado[$i]['color'] );
            print_r( $resultado[$i]['codigo'] );*/
            print_r($res1);
            echo "<br/>"; 
        }
?>
</pre>