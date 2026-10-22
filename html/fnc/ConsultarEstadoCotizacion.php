<?php
include_once '../../conexion/cnx.php';

$id = $_POST['id'];

$IdCotizador=0;
$IdUsuarioCotizador=0;

$sql="select IdCotizador, IdUsuarioCotizador from cotizacion where ID_COTIZACION =".$id.";";

$result = mysqli_query($GLOBALS["db"], $sql);

if (mysqli_num_rows($result) > 0) {
    
    while($row = mysqli_fetch_assoc($result)) {	    	
    	
    	$IdCotizador =$row["IdCotizador"];
    	
    	$IdUsuarioCotizador=$row["IdCotizador"];
    	    	
    }
}

echo "<input type='hidden' id='IdCotizador' name='IdCotizador' value='".$IdCotizador."'>";
echo "<input type='hidden' id='IdUsuarioCotizador' name='IdUsuarioCotizador' value='".$IdUsuarioCotizador."'>";

?>