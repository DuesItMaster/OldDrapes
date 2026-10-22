  <?php
include '../../conexion/wsConsumeDrapes.php';

         if (isset($_POST['colorBaston'])){ 
            $colorBaston = $_POST['colorBaston'];            
         }

         if (isset($_POST['materialBaston'])){ 
            $materialBaston = $_POST['materialBaston'];            
         } 

         if (isset($_POST['medidaBaston'])){ 
            $medidaBaston = $_POST['medidaBaston'];
         }


         if (isset($_POST['costoCortinero'])){ 
            $costoCortinero = $_POST['costoCortinero'];
         }

         if (isset($_POST['colorBaston'])){
            $arreglo=CostoBaston($colorBaston,$materialBaston,$medidaBaston);    
              foreach ($arreglo as $valor) {
                echo $valor;
                echo '<input id="valorBaston" type="text" value="'.$valor.'" style="visibility:hidden">';
                echo "Suma: " . $costoCortinero . "AQUIIII";
              }
         }

         else {
            echo "Error consulta del baston.php";
         }
         //echo "llegadas ".$colorBaston.$materialBaston.$medidaBaston;

  ?>