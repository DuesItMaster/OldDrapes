<?php
    include_once '../../conexion/wsConsumeDrapes.php';
    
    if(isset($_POST['codigo'])){
        $codigo = $_POST['codigo'];
    }
    if(isset($_POST['accion'])){
        $accion = $_POST['accion'];
    }

    if($accion == "controles"){
        $resultado  = DatosControles($codigo);
        
        foreach ($resultado as $fila) {

            if (is_null($fila["numCanales"])) {
                echo "<option value='". $fila["precio"] ."' codigo='". $fila["codigo"] ."' imgNombre = '". $fila["imgNombre"] ."' nombre='". $fila["nombre"] ."'>".trim($fila["nombre"]) . "</option>";     
            }
            else {
                if($fila["numCanales"] > 1){
                    echo "<option value='". $fila["precio"] ."' codigo='". $fila["codigo"] ."' imgNombre = '". $fila["imgNombre"] ."'  nombre='". $fila["nombre"] ."' >".trim($fila["numCanales"] . " Canales")."</option>";     
                }else{
                    echo "<option value='". $fila["precio"] ."' codigo='". $fila["codigo"] ."' imgNombre = '". $fila["imgNombre"] ."'  nombre='". $fila["nombre"] ."' >".trim($fila["numCanales"] . " Canal")."</option>";     
                }
                
            }
        }
    }
    elseif($accion == "precio"){

    }

?>
