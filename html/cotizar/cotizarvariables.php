<?php
require_once '../fnc/CortinaFnc.php';

if (isset($_POST['tipo']) and $_POST['tipo'] <> ""){ 
	$Tela = $_POST['tipo'];	
}
else {

}

if (isset($_POST['elegido']) and $_POST['elegido'] <> ""){ 
	$NombreTela = $_POST['elegido'];
}
else {

}

/*if (isset($_POST['elegido']) and $_POST['elegido'] <> ""){ 
	$Tela = $_POST['elegido'];
	
}
else {

}*/


	$ArregloAccesorio = TraerAccesorioporTela($Tela);

											        
	foreach($ArregloAccesorio as $ValorAccesorio){

		if ($ValorAccesorio['nombre'] =="BAJO PLOMO"){
			if ($NombreTela=="TASIA" || $NombreTela=="JADE" || $NombreTela=="KONY"){
				$ValorCheck = "checked";
			}
			else{
				$ValorCheck ="";
			}
			$Oculto = 'style="display:none;"';
		} else {
			$ValorCheck ="";
			$Oculto = ""; //'.$Oculto .'
		}
	
		echo '<div class="checkbox checkbox-styled tile-text" '.$Oculto .' id="DIV'.str_replace(" ", "", $ValorAccesorio['nombre']).'" data-toggle="tooltip" data-placement="left" title="'.utf8_encode($ValorAccesorio['descripcion']).'">
				<label>
					<input type="checkbox" value="'.$ValorAccesorio['nombre'].'" id="'.str_replace(" ", "", $ValorAccesorio['nombre']).'" onclick="CargarValor()" '.$ValorCheck.'>
					<span>
					'.$ValorAccesorio['nombre'].'
					</span>
				</label>
			  </div>';
	}

	


?>

<script type="text/javascript">
	CambiarVariables();
</script>


