<?php 
require_once '../../conexion/cnx.php';

if (isset($_POST['id_session'])){ 		
        $id_session = $_POST['id_session'];      
        $arreglon=tabusuario($id_session);
        $Filas = count($arreglon);
     
      echo "<table class='table table-banded no-margin'>";
      echo "<tr>";
      echo "<th></th>";
      echo "<th>Nombre</th>";
      echo "<th>Calle</th>";
      echo "<th>Numero</th>";
      echo "<th>Colonia</th>";
      echo "<th>Localidad</th>";
      echo "<th>Estado</th>";
      echo "<th>Telefono</th>";
      echo "<th>Referencias</th>";
      echo "<th>Atención</th>";
      echo "<th>Contacto</th>";
      echo "<th>Sucursal</th>";
      echo "<th>Hr Atención</th>";
      echo "<th>CP</th>";
      echo "<th>Ciudad</th>";

      for( $i=0; $i<$Filas; $i++ ){//\"
			echo "<tr>";
			//echo "<td><input type='checkbox'></td>"; 
			echo"<td style='text-align:center;'><input type='radio' name='midire' onchange='enviar(\"".$arreglon[$i]['ID']."\",\"".$arreglon[$i]['NOMBRE']."\",\"".
				$arreglon[$i]['CALLE']."\",\"".$arreglon[$i]['NUMERO']."\",\"".$arreglon[$i]['COLONIA']."\",\"".utf8_encode($arreglon[$i]['LOCALIDAD'])."\",\"".
				$arreglon[$i]['ESTADO']."\",\"".$arreglon[$i]['TELEFONO']."\",\"".$arreglon[$i]['REFERENCIAS']."\",\"".$arreglon[$i]['ATENCION']."\",\"".$arreglon[$i]['CONTACTO']."\",\"".
				$arreglon[$i]['SUCURSAL']."\",\"".$arreglon[$i]['HORA']."\",\"".$arreglon[$i]['CP']."\",\"".utf8_encode($arreglon[$i]['CIUDAD'])."\");'></td>";


			//echo"<td style='text-align:center;'><input type='radio' name='midire' onchange='enviar(\"".$arreglon[$i]['CALLE']."\",\"".$arreglon[$i]['NOMBRE']."\",\"".$arreglon[$i]['NUMERO']."\");'></td>";

			echo "<td>".$arreglon[$i]['NOMBRE']."</td>";
			echo "<td>".$arreglon[$i]['CALLE']."</td>";
			echo "<td>".$arreglon[$i]['NUMERO']."</td>";
			echo "<td>".$arreglon[$i]['COLONIA']."</td>";
			echo "<td>".utf8_encode($arreglon[$i]['LOCALIDAD'])."</td>";
			echo "<td>".$arreglon[$i]['ESTADO']."</td>";
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
	}

		function tabusuario($IdCliente){			
			$cons= "SELECT * FROM usuario_direccion ud INNER JOIN usuario u ON (u.ID_USUARIO=ud.ID_USUARIO)
			        WHERE u.ID_USUARIO=".$IdCliente.";";
			$datos = array();
			$result = mysqli_query($GLOBALS['db'], $cons);

			if (mysqli_num_rows($result) > 0) {
			    // output data of each row
			    while($row = mysqli_fetch_assoc($result)) {
			    	array_push($datos,array('ID'=> $row["ID"],'NOMBRE'=> $row["NOMBRE_DOMICILIO"],'CALLE'=> $row["CALLE"],'NUMERO'=> $row["NUMERO"],
		    		                   'COLONIA'=> $row["COLONIA"],'LOCALIDAD'=> $row["LOCALIDAD"],'ESTADO'=> $row["ESTADO"],//'MUNICIPIO'=> $row["MUNICIPIO"],
		    		                   'TELEFONO'=> $row["TELEFONO"],'REFERENCIAS'=> $row["REFERENCIAS"],'ATENCION'=> $row["ATENCION"],'CONTACTO'=> $row["CONTACTO"],
		    		                   'SUCURSAL'=> $row["SUCURSAL"],'CP'=> $row["CP"],'HORA'=> $row["HORA"],'CIUDAD'=> $row["CIUDAD"]));    
			    }
			} else {
			    
			    $a = "No hay resultados";
			}
			
			return $datos;
		}	
?>