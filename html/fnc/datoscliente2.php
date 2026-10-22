<?php 
 include '../../conexion/cnx.php';
if (isset($_POST['client'])){ 	

        $client = $_POST['client']; 
        //echo "si llega la variable ".$client;      
      $arreglon=tabclient($client);      

     $Filas = count($arreglon);     
     echo "<table class='table table-banded no-margin'>";
      	echo "<thead>";
		      echo "<tr>";
			      echo "<th>Nombre</th>";
			      echo "<th>Telefono</th>";
			      echo "<th>Referencias</th>";
			      echo "<th>Correo</th>";
		      echo "</tr>";
		echo "</thead>";
      for($i=0; $i<$Filas; $i++){

			echo "<tr>";
				echo "<td>".$arreglon[$i]['NOMBRE']."</td>";
				echo "<td>".$arreglon[$i]['TELEFONO']."</td>";
				echo "<td>".$arreglon[$i]['REFERENCIAS']."</td>";
				echo "<td>".$arreglon[$i]['EMAIL']."</td>";
			echo "</tr>";
		}
	  echo "</table>";
}
	   
		function tabclient($IdCliente){			
			$cons= "SELECT * FROM cliente WHERE ID_CLIENTE =".$IdCliente."; " ;
			$datos = array();
			$result = mysqli_query($GLOBALS["db"], $cons);

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
