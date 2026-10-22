<?php 
require_once '../../conexion/cnx.php';

if (isset($_POST['nombreSelect'])){ 
            $nombreSelect = $_POST['nombreSelect'];
             //echo $nombreSelect;
             //echo "<br> color cortinero:". $nombreSelect;    
              
                  $arreglo=traer($nombreSelect);
                    foreach ($arreglo as $valor) {
                        echo "<br> Valor: $". $valor;
                        echo '<br><input id="valor" type="text" value="'.$valor.'" style="visibility:hidden">';                
                    }         
         }

         else {echo "NEL";}


function aa(){ 
$sql = "SELECT NOMBRE, ID_CLIENTE FROM cliente WHERE ID_USUARIO_ALTA= ".$_SESSION['login_user']." ;";
		$tipo = array();
		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	array_push($tipo,array('NOMBRE'=> $row["NOMBRE"],'ID'=> $row["ID_CLIENTE"]));    
		    }
		} else {
		    $a = "No hay resultados";
		}
		return $tipo;
	}

	

	function traer(){
		$sql = "SELECT * FROM usuario WHERE ID_USUARIO= ".$_SESSION['login_user']." ;";
		$nombreR = array();
		$result = mysqli_query($GLOBALS['db'], $sql);

		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		    	array_push($nombreR,array('ID'=> $row["ID_CLIENTE"],'NOMBRE'=> $row["NOMBRE"],'CALLE'=> $row["CALLE"],'NUMERO'=> $row["NUMERO"],
			    		                  'COLONIA'=> $row["COLONIA"],'LOCALIDAD'=> $row["LOCALIDAD"],'ESTADO'=> $row["ESTADO"],'MUNICIPIO'=> $row["MUNICIPIO"],
			    		                  'TELEFONO'=> $row["TELEFONO"],'REFERENCIAS'=> $row["REFERENCIAS"],'ATENCION'=> $row["ATENCION"],'CONTACTO'=> $row["CONTACTO"],
			    		                  'SUCURSAL'=> $row["SUCURSAL"],'EMAIL'=> $row["EMAIL"],'CP'=> $row["CP"]));    
		    }
		} else {
		    
		    $a = "No hay resultados";
		}

		return $nombreR;


	}
?>