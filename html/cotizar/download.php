<?php 

$archivo = $_GET["archivo"];
$pedido = $_GET["pedido"];
$tipo = $_GET["tipo"];
$id = $_GET["id"];

$url = 'http://192.168.1.60:81/Seguimientos/'.$pedido.'/'.$tipo.'/'.$id.'/'.$archivo;


$file_headers = @get_headers($url);
if(strpos($file_headers[0], "OK")){
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"".$archivo."\""); 
	readfile($url);
	exit;
}





/*   
Ejemplo
$url_prueba_facturas = 'http://192.168.1.60/Seguimientos/36453/Factura/29780/B29780.xml';
$url_prueba_ListaEmbarques = 'http://192.168.1.60/Seguimientos/34630/Embarque/10630/Lista_de_Embarques.pdf';
$url_prueba_Guia = 'http://192.168.1.60/Seguimientos/34630/Embarque/10630/Guia.pdf';
$url_prueba_DetalleRecepcion = 'http://192.168.1.60/Seguimientos/34630/Embarque/10630/Detalle_Recepcion.pdf';
*/
?>