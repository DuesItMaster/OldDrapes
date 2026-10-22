<?php 
 include '../../conexion/cnx.php';
if (isset($_POST['client'])){ 		
        $client = $_POST['client']; 
        //echo "si llega la variable ".$client;      
      $arreglon=tabclient($client);      

     $Filas = count($arreglon);
      echo "<table class='table table-banded no-margin'>";
      echo "<tr>";
      echo "<th>Nombre</th>";
      echo "<th>Calle</th>";
      echo "<th>Numero</th>";
      echo "<th>Colonia</th>";
      echo "<th>Localidad</th>";
      echo "<th>Estado</th>";
      echo "<th>Municipio</th>";
      echo "<th>Telefono</th>";
      echo "<th>Referencias</th>";
      echo "<th>Atención</th>";
      echo "<th>Contacto</th>";
      echo "<th>Sucursal</th>";
      echo "<th>Correo</th>";
      echo "<th>CP</th>";

      echo "</tr>";
      for($i=0; $i<$Filas; $i++){

			echo "<tr>";
			echo "<td>".$arreglon[$i]['NOMBRE']."</td>";
			echo "<td>".$arreglon[$i]['CALLE']."</td>";
			echo "<td>".$arreglon[$i]['NUMERO']."</td>";
			echo "<td>".$arreglon[$i]['COLONIA']."</td>";
			echo "<td>".utf8_encode($arreglon[$i]['LOCALIDAD'])."</td>";
			echo "<td>".$arreglon[$i]['ESTADO']."</td>";
			echo "<td>".utf8_encode($arreglon[$i]['MUNICIPIO'])."</td>";
			echo "<td>".$arreglon[$i]['TELEFONO']."</td>";
			echo "<td>".$arreglon[$i]['REFERENCIAS']."</td>";
			echo "<td>".$arreglon[$i]['ATENCION']."</td>";
			echo "<td>".$arreglon[$i]['CONTACTO']."</td>";
			echo "<td>".$arreglon[$i]['SUCURSAL']."</td>";
			echo "<td>".$arreglon[$i]['EMAIL']."</td>";
			echo "<td>".$arreglon[$i]['CP']."</td>";
			echo "</tr>";
		}
	  echo "</table>";
}
	   
		function tabclient($IdCliente){			
			$cons= "SELECT * FROM cliente WHERE ID_CLIENTE =".$IdCliente."; " ;
			$datos = array();
			$result = mysqli_query($GLOBALS['db'], $cons);

			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
			    	array_push($datos,array('NOMBRE'=> $row["NOMBRE"],'CALLE'=> $row["CALLE"],'NUMERO'=> $row["NUMERO"],
		    		                   'COLONIA'=> $row["COLONIA"],'LOCALIDAD'=> $row["LOCALIDAD"],'ESTADO'=> $row["ESTADO"],'MUNICIPIO'=> $row["MUNICIPIO"],
		    		                   'TELEFONO'=> $row["TELEFONO"],'REFERENCIAS'=> $row["REFERENCIAS"],'ATENCION'=> $row["ATENCION"],'CONTACTO'=> $row["CONTACTO"],
		    		                   'SUCURSAL'=> $row["SUCURSAL"],'EMAIL'=> $row["EMAIL"],'CP'=> $row["CP"]));    
			    }
			} else {
			    
			    $a = "No hay resultados";
			}
			
			return $datos;
		}	

?>
