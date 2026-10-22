<?php
require_once '../fnc/CortinaFnc.php';

if (isset($_POST['elegidoForro']) and $_POST['elegidoForro'] <> ""){ 
	$Tela = $_POST['elegidoForro'];
	
}


if (isset($_POST['ColorForro']) and $_POST['ColorForro'] <> ""){ 
	$ColorForro = $_POST['ColorForro'];
}
else
{
	$ColorForro="";
}


?>

<TABLE  class="table">
	

	<?php

		$ArregloTipoTela1 = TraerColoresTelas($Tela);
		$Filas = count($ArregloTipoTela1);

		$inicio = "<tr>";
		$fin = "";

		//echo "TERMINO CONSULTA " . $Tela ;
		
		for($i=0; $i<$Filas; $i++ ){
 		
 			$fila = ($i+1);
 			$residuo = $fila%3;
			if (($fila%3==0) AND ($i!=0)){
				$fin = "</tr>";
			}
			else{
				$inicio="";
				$fin = "";
			}

			
			echo $inicio;
			$Archivo = "../../assets/img/colores/small/".$Tela."/".$ArregloTipoTela1[$i]['color'].".jpg";
		
			if (!file_exists($Archivo)) {
				$Archivo = "../../assets/img/colores/small/".$Tela."/".$ArregloTipoTela1[$i]['color'].".png";
			}

			/*echo '<td>
			<label class="radio-inline radio-styled">
				  <input type="radio" name="colorforro" value="'.$ArregloTipoTela1[$i]['color']. '" onchange="CargarValor();"><span> '.$ArregloTipoTela1[$i]['color']. '</span><br>
				  <a href="../../assets/img/colores/big/'.$Tela.'/'.$ArregloTipoTela1[$i]['color'].'.jpg" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
				  		<img src="'.$Archivo.'" style="" width="70%" height="50%"/>
				  </a>
				  </label>
			 </td>';*/

			 if ($ArregloTipoTela1[$i]['pedido']=="SI"){
			 	$pedido="*";
			 }else{
			 	$pedido="";
			 }

			 if($ColorForro==$ArregloTipoTela1[$i]['color']){

				echo '<td>
				<label class="radio-inline radio-styled">
				  <input type="radio" name="colorforro" value="'.$ArregloTipoTela1[$i]['color']. '" id="'.$ArregloTipoTela1[$i]['color']. '" onchange="CargarValor();" checked><span> '.$ArregloTipoTela1[$i]['color'].'<b >'.$pedido.'</b>'. '</span><br>
				  <a href="../../assets/img/colores/big/'.$Tela.'/'.$ArregloTipoTela1[$i]['color'].'.jpg" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
				  		<img src="'.$Archivo.'" style="" width="70%" height="50%"/>
				  </a>
				  </label>
			 	</td>';

			}
			else{

				echo '<td>
				<label class="radio-inline radio-styled">
				  <input type="radio" name="colorforro" value="'.$ArregloTipoTela1[$i]['color']. '" id="'.$ArregloTipoTela1[$i]['color']. '" onchange="CargarValor();"><span> '.$ArregloTipoTela1[$i]['color'].'<b >'.$pedido.'</b>'. '</span><br>
				  <a href="../../assets/img/colores/big/'.$Tela.'/'.$ArregloTipoTela1[$i]['color'].'.jpg" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
				  		<img src="'.$Archivo.'" style="" width="70%" height="50%"/>
				  </a>
				 </label>
			 	</td>';


			}

			 echo $fin;
			// ECHO $Tela.'/'.$ArregloTipoTela1[$i]['color'];

			
			if (($fila%3==0)) {
				$inicio = "<tr>";
				$inicio = "";
			}
			else{
				$inicio="";
				$fin = "";
			}

																		               	 
	  	}


	?>
	<script type="text/javascript">CargarValor();</script>
	</TABLE>

