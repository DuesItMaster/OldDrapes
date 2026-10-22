<?php 
require_once '../../conexion/cnx.php';

if (isset($_POST['IDCOTIZACION'])){ 		
        $IDCOTIZACION = $_POST['IDCOTIZACION'];      
        $arreglon=tabusuario($IDCOTIZACION);
        $Filas = count($arreglon);
     
      echo "<div class='table-responsive'>";
      echo "<table class='table table-banded no-margin'>";
	      echo "<thead>";
		      echo "<tr>";
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
			      echo "<th>Hr Atención</th>";
			      echo "<th>CP</th>";
			      echo "<th>Ciudad</th>";
		      echo "</tr>";
	      echo "</thead>";

      for( $i=0; $i<$Filas; $i++ ){
			echo "<tr>";
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
			echo "<td>".$arreglon[$i]['HORA']."</td>";
			echo "<td>".$arreglon[$i]['CP']."</td>";
			echo "<td>".utf8_encode($arreglon[$i]['CIUDAD'])."</td>";
			echo "</tr>";	
	  	}
	   echo "</table><BR><BR>";
	   echo "</div>";
	}
	   
		function tabusuario($idCotizacion){			
			$cons= "SELECT CALLE,NUMERO,COLONIA,LOCALIDAD,ESTADO,TELEFONO,REFERENCIAS,ATENCION,CONTACTO,SUCURSAL,CP,HORA,CIUDAD  
					FROM cotizacion
			        WHERE ID_COTIZACION=".$idCotizacion.";";
			$datos = array();
			$result = mysqli_query($GLOBALS["db"], $cons);

			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
			    	array_push($datos,array('CALLE'=> $row["CALLE"],'NUMERO'=> $row["NUMERO"],
			    		                    'COLONIA'=> $row["COLONIA"],'LOCALIDAD'=> $row["LOCALIDAD"],'ESTADO'=> $row["ESTADO"],'MUNICIPIO'=> $row["LOCALIDAD"],
			    		                    'TELEFONO'=> $row["TELEFONO"],'REFERENCIAS'=> $row["REFERENCIAS"],'ATENCION'=> $row["ATENCION"],'CONTACTO'=> $row["CONTACTO"],
			    		                    'SUCURSAL'=> $row["SUCURSAL"],'CP'=> $row["CP"],'HORA'=> $row["HORA"],'CIUDAD'=> $row["CIUDAD"]));    
			    }
			} else {
			    
			    $a = "No hay resultados";
			}
			
			return $datos;
		}	

?>