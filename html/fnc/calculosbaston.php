  <?php

         if (isset($_POST['baston'])){ 
            $baston = $_POST['baston'];  
            //echo "llego baston";          
         }

         if (isset($_POST['costoBaston'])){ 
            $costoBaston = $_POST['costoBaston'];            
            //echo "llego costo baston";
         } 

         if (isset($_POST['costoCortinero'])){ 
            $costoCortinero = $_POST['costoCortinero'];
            //echo "llego cortinero";
         }

         if (isset($_POST['costoCortinero'])){
            $resultadoSuma=suma($costoCortinero,$costoBaston);             

               //echo "Costo cortinero" . $costoCortinero;
               //echo "<br>Costo Baston " . $costoBaston;
                echo '<input id="resultadoSuma" type="text" value="'.$resultadoSuma.'" >';
              
         }

         else {
            echo "Error consulta de calculos";
         }
        

         function suma($costoCortinero,$costoBaston){
            $resultado=$costoCortinero+$costoBaston;
            return $resultado;
         }

  ?>