<style type="text/css">
.boton_personalizado{
    text-decoration: underline;
    cursor:pointer;
    color: blue;
}
</style>

<?php 
require_once '../../conexion/wsConsumeDrapes.php';
require_once '../../conexion/cnxCostosProduccion.php';


if (isset($_POST['codigotela']) and isset($_POST['Ancho']) and isset($_POST['Alto']) and isset($_POST['tela']) and isset($_POST['TipoTela']) and isset($_POST['ColorForro']) ) {
    $codigotela = $_POST['codigotela'];
    $Ancho = $_POST['Ancho'];
    $Alto = $_POST['Alto'];
    $tela = $_POST['tela'];
    $TipoTela = $_POST['TipoTela'];
    $ColorForro = $_POST['ColorForro'];


    
	$stockfinal = stock($codigotela,$Ancho,$Alto,$tela,$TipoTela,$ColorForro);

}
function stock($codigoSAP,$Ancho,$Alto,$tela,$TipoTela,$ColorForro){
    $stock = StockTela($codigoSAP);
    //echo($codigoSAP);
    //echo($Ancho);

    if($TipoTela=="SEMITRANSLUCIDA" || $TipoTela=="TRANSLUCIDA" || $TipoTela=="OPACA"){
        if($Alto>2.5 && $Alto>4 && $Ancho>5){
            echo "<b>Mensaje: <br> <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo "<b>Mensaje: <br> Codigo de Tela:  $codigoSAP <br> Tipo de Tela: $TipoTela   <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo 'Codigo de Tela: '. $codigoSAP . '<div style="color:red">Plizado de tela no permitido.<a class="boton_personalizado" data-toggle="modal" data-target="#exampleModal3">Hipervinculo</a></div>'.'Tipo de Tela: '. $TipoTela;
          }else if($Alto>2.5 && $Alto<=4 && $Ancho>5){
            echo "<b>Mensaje: <br> <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo "<b>Mensaje: <br> Codigo de Tela:  $codigoSAP <br> Tipo de Tela: $TipoTela   <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo 'Codigo de Tela: '. $codigoSAP . '<div style="color:red">Plizado de tela no permitido.<a class="boton_personalizado" data-toggle="modal" data-target="#exampleModal3">Hipervinculo</a></div>'.'Tipo de Tela: '. $TipoTela;
          }
          else if($Alto>2.5 && $Alto>4 && $Ancho<=5){
            echo "<b>Mensaje: <br> <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo "<b>Mensaje: <br> Codigo de Tela:  $codigoSAP <br> Tipo de Tela: $TipoTela   <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo 'Codigo de Tela: '. $codigoSAP . '<div style="color:red">Plizado de tela no permitido.<a class="boton_personalizado" data-toggle="modal" data-target="#exampleModal3">Hipervinculo</a></div>'.'Tipo de Tela: '. $TipoTela;
          }elseif($Alto<=2.5 && $Ancho>6){
            echo "<b>Mensaje: <br>  <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo "<b>Mensaje: <br> Codigo de Tela:  $codigoSAP <br> Tipo de Tela: $TipoTela   <div style='color:red'>Plizado de tela no permitido.<a class='boton_personalizado' data-toggle='modal' data-target='#exampleModal3'>Hipervinculo</a></div></b>";
            //echo 'Codigo de Tela: '. $codigoSAP . '<div style="color:red">Plizado de tela no permitido.<a class="boton_personalizado" data-toggle="modal" data-target="#exampleModal3">Hipervinculo</a></div>'.'Tipo de Tela: '. $TipoTela;
          }
          else{
            //echo "<b>Mensaje: <br> Codigo de Tela: $codigoSAP <br> Tipo de Tela: $TipoTela <div></div></b>";
            //echo 'Codigo de Tela: '. $codigoSAP.'<div></div>'. 'Tipo de Tela: '. $TipoTela;
        }
    }
    
}

?>

<!-- Modal -->
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Medidas Permitidas</h5>
            </div>
            <div class="modal-body">
            Imagen pendiente
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
