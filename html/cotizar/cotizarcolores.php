<?php
require_once '../fnc/CortinaFnc.php';

if (isset($_POST['elegido']) and $_POST['elegido'] <> ""){ 
	$Tela = $_POST['elegido'];
	
}

if (isset($_POST['Color']) and $_POST['Color'] <> ""){ 
	$Color = $_POST['Color'];
}
else
{
	$Color = "";	
}

$TipoTela = (isset($_POST['tipo'])) ? $_POST['tipo'] : "";
$TipoCortina = (isset($_POST['TipoCortina'])) ? $_POST['TipoCortina'] : "";
?>

<TABLE class="table">
	<?php
		$mensaje = ($TipoTela == "BLACK OUT" && $TipoCortina == "Ojillos") ? "Esta confección permite filtraciones de luz por lo que no se recomienda utilizar el tipo de tela BLACK OUT. " : "";
		echo $mensaje;

		$ArregloTipoTela1 = TraerColoresTelas($Tela);
		$Filas = count($ArregloTipoTela1);

		$inicio = "<tr>";
		$fin = "";

		//echo "TERMINO CONSULTA " . $Tela ;
		
		for($i=0; $i<$Filas; $i++ ){
 		
 			$fila = ($i+1);
 			$residuo = $fila%5;
			if (($fila%5==0) AND ($i!=0)){
				$fin = "</tr>";
			}
			else{
				$inicio="";
				$fin = "";
			}

			echo $inicio;
			$Archivo = "../../assets/img/colores/small/".trim($Tela)."/".$ArregloTipoTela1[$i]['color'].".jpg";
			$ArchivoBig = "../../assets/img/colores/big/".trim($Tela)."/".$ArregloTipoTela1[$i]['color'].".jpg";
		
			if (!file_exists($Archivo)) {
				$Archivo = "../../assets/img/colores/small/".trim($Tela)."/".$ArregloTipoTela1[$i]['color'].".png";
				}

			if (!file_exists($ArchivoBig)) {
				$ArchivoBig = "../../assets/img/colores/big/".trim($Tela)."/".$ArregloTipoTela1[$i]['color'].".png";
				}

			/*echo '<td>
			<label class="radio-inline radio-styled">
				  <input type="radio" name="color" value="'.$ArregloTipoTela1[$i]['color']. '" onchange="CargarValor();"><span> '.$ArregloTipoTela1[$i]['color']. '</span><br>
				  <a href="../../assets/img/colores/big/'.$Tela.'/'.$ArregloTipoTela1[$i]['color'].'.jpg" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
				  		<img src="'.$Archivo.'" style="" width="70%" height="50%"/>
				  </a>
				  	</label>
			 </td>';*/
			 //echo $Archivo . "<br>";

			 if ($ArregloTipoTela1[$i]['pedido']=="SI"){
			 	$pedido="*";
			 }else{
			 	$pedido="";
			 }
			 //$pedido="*";
			 if ($ArregloTipoTela1[$i]['color']==$Color){
				echo '<td>
						<label class="radio-inline radio-styled">
						  <input type="radio" name="color" value="'.$ArregloTipoTela1[$i]['color']. '" id="'.$ArregloTipoTela1[$i]['color']. '" onchange="CargarValor();" checked><span> '.$ArregloTipoTela1[$i]['color'].'<b >'.$pedido.'</b>'. '</span><br>
						  <a href="'.$ArchivoBig.'" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
						  		<img src="'.$Archivo.'" style="" width="70%" height="50%"/>
						  </a>
					 	</label>
				 	</td>';
			}else{
				echo '<td>
						<label class="radio-inline radio-styled">
						  <input type="radio" name="color" value="'.$ArregloTipoTela1[$i]['color']. '" id="'.$ArregloTipoTela1[$i]['color']. '" onchange="CargarValor();"><span> '.$ArregloTipoTela1[$i]['color'].'<b >'.$pedido.'</b>'. '</span><br>
						  <a href="'.$ArchivoBig.'" data-toggle="lightbox" data-title="'.$ArregloTipoTela1[$i]['color'].'">
						  		<img src="'.$Archivo.'" style="" width="70%" height="50%"/>
						  </a>
					  	</label>
				 	</td>';
			}

			 echo $fin;
			// ECHO $Tela.'/'.$ArregloTipoTela1[$i]['color'];

			if (($fila%5==0)) {
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