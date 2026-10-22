<?php
    require_once '../../conexion/cnx.php'; 
    include '../../conexion/wsConsumeDrapes.php';
    require_once '../../conexion/cnxEmbarques.php';


    //session_start();
    if (isset($_GET['id']) and $_GET['id']<>""){
      $id = $_GET['id'];

      echo "<input type='hidden' id='id' name='id' value='".$id."'>";
    }


    /****************************************************** EN FIRME  *************************************************************************/
    //Esta consulta traerá consigo la fecha en que el el ejecutivo aprueba la cotizacion en Dues Drapes junto con el representante de ventas 

    $EMBARQUES = array();
    $PRODUCTOS = array();
    $Facturas = array();
    $SAP = array();


    $sql = "SELECT FolioCotizacion, FECHA_APRUEBA FROM cotizacion WHERE ID_COTIZACION = ".$id." ;";
    //$sql = "SELECT ESTADO, ESTATUS FROM cotizacion WHERE FolioCotizacion = ".$id." ;";

    $resultFirme = mysqli_query($GLOBALS["db"], $sql);

    if (mysqli_num_rows($resultFirme) > 0) {

      $SAP = DatosEnFirme($id);

      while($row = mysqli_fetch_assoc($resultFirme)) {
        $firme = array(
          "folioCotizacion"   =>      $row["FolioCotizacion"],
          "fechaAprueba"      =>      $row["FECHA_APRUEBA"],
          "representante"     =>      "",
          "pedido"            =>      "",
          "fechaPedido"       =>      "",
          "fechaOP"           =>      "",
          "fechaEnFirme"      =>      "",
        );
      }

      //Obtener número de pedido de SAP y su fecha de creación, tambien incluir fechaOP para hacer la validación del estado en proceso
      for ($i = 0; $i < count($SAP); $i++) {
        $firme["fechaPedido"] = $SAP[$i]['fecha'];
        $firme["pedido"] = $SAP[$i]['docnum'];
        $firme["fechaOP"] = $SAP[$i]['fechaOP'];  
        $firme["representante"] = $SAP[$i]['agente'];
        $firme["fechaEnFirme"] = $SAP[$i]['fechaEmbarque'];

      }

      $Facturas = DatosFolioFacturas($firme["pedido"]);
      /*********************************************************************************************************************************************/


      /****************************************************** EN PROCESO  **************************************************************************/

      if(!empty($firme) && !empty($firme["fechaOP"]) && !is_null($firme["fechaOP"])){
        $PROCESO = DatosProductos($firme["pedido"]);

        //$Traslados = DatosTraslados($firme["pedido"]);

        /*$fechaOC = DatosFechaOrdenCompra("ORDEN DE COMPRA DEL PRODUCTO");
        $telas = DatosOrdenCompraDetalles("ORDEN DE COMPRA DEL PRODUCTO");*/


        //$ENTREGAS = ExistenciaEntregas($firme["pedido"]);


        /****************************************************** EMBARQUES  **************************************************************************/
        
        //$EMBARQUES = DatosEmbarque($firme["pedido"]);

        /*$sql = "SELECT a.embarque, a.numGuia, b.paqueteria, c.condicionEnvio, d.condicionPago FROM Embarques a 
        INNER JOIN Paqueterias b ON  b.idPaqueteria = a.idPaqueteria 
        INNER JOIN Condiciones_Envio c ON c.idCondicionesEnvio = a.idCondicionesEnvio 
        INNER JOIN Condiciones_Pago_Envio d ON d.idCondicionePago = a.idCondicionesPagoEnvio
        WHERE a.ordenVentaSapDrapes = ".$firme["pedido"]." ;"; */
        $sql = "SELECT c.embarque, c.numGuia, d.paqueteria, e.condicionEnvio, f.condicionPago, c.estadoEmbarque, c.avisoRecoleccion, c.avisoRezago, c.avisoDevolucion FROM Detalle_Packing_Lists a 
        INNER JOIN Packing_Lists b ON a.idPackingList = b.idPackingList
        INNER JOIN Embarques c ON b.idEmbarque = c.idEmbarque
        INNER JOIN Paqueterias d ON c.idPaqueteria = d.idPaqueteria 
        INNER JOIN Condiciones_Envio e ON c.idCondicionesEnvio = e.idCondicionesEnvio 
        INNER JOIN Condiciones_Pago_Envio f ON c.idCondicionesPagoEnvio = f.idCondicionePago 
        WHERE a.ordenVentaSap = ".$firme["pedido"]." GROUP BY c.idEmbarque ;";

        $resultEmbarque = mysqli_query($GLOBALS["dbE"], $sql);

        if (mysqli_num_rows($resultEmbarque) > 0) {

          while($row = mysqli_fetch_assoc($resultEmbarque)) {

            $estado = "";
            $aviso = null;
            $color = null;
            if($row["estadoEmbarque"] === "1"){
              $estado = "(En Tránsito)";

              if($row["avisoRecoleccion"] === "1"){
                $aviso = "Aviso de Recolección";
                $color = "#FFD100";
              }

              if($row["avisoDevolucion"] === "1"){
                $aviso = "Aviso de Devolución de Mercancía";
                $color = "#FFD100";
              } 

              if($row["avisoRezago"] === "1"){
                $aviso = "Aviso de Mercancía a Rezago";
                $color = "#D22222";
              }   

            }
            else if($row["estadoEmbarque"] === "2"){
              $estado = "(Recibido)";
            }


            $embarqueData = array(
              "embarque"            =>      $row["embarque"],
              "guia"                =>      $row["numGuia"],
              "paqueteria"          =>      $row["paqueteria"],
              "condicionesEnvio"    =>      $row["condicionEnvio"],
              "condicionesPago"     =>      $row["condicionPago"],
              "estadoEmbarque"      =>      $estado,
              "aviso"               =>      $aviso,
              "color"               =>      $color,
            );

            array_push($EMBARQUES, $embarqueData);

          }


          $sql = "SELECT a.numLineaSap, SUM(a.cantidad) AS empacado, a.recibido FROM Detalle_Packing_Lists a 
          INNER JOIN Packing_Lists b ON a.idPackingList = b.idPackingList 
          INNER JOIN Embarques c ON b.idEmbarque = c.idEmbarque
          WHERE a.ordenVentaSap = ".$firme["pedido"]." 
          GROUP BY a.numLineaSap, a.recibido ;";

          $resultProductos = mysqli_query($GLOBALS["dbE"], $sql);

          if (mysqli_num_rows($resultProductos) > 0) {

            while($row = mysqli_fetch_assoc($resultProductos)) {
              $productoData = array(
                "linea"            =>      $row["numLineaSap"],
                "cantidad"         =>      $row["empacado"],
                "recibido"         =>      $row["recibido"],
              );

              array_push($PRODUCTOS, $productoData);
            }

          }

        }


         /*********************************************************************************************************************************************/

      }

      /*********************************************************************************************************************************************/

        
    }

?>
<div class="">
    <section class="section-body contain-lg">
        <div class="row">
					<div class="col-sm-11">
						<div class="card">
                    <br><br>
                    <div class="">
                        <div style="font-size: 22px; text-align: center;">
                          <?php if(empty($firme) || is_null($firme["fechaAprueba"]) || count($SAP) == 0) {  ?> 
                            <strong>Seguimiento de Pedido Folio: <?php echo $id; ?></strong>
                          <?php } else {  ?> 
                            <strong>Seguimiento de Pedido Folio: <?php echo $id."-".$firme["pedido"]; ?></strong>
                          <?php }  ?>   
                        </div>
                        <div class="card-body"> 
                            <div class="row">
                            
                                <?php if(empty($firme) || is_null($firme["fechaAprueba"]) || count($SAP) == 0) {  ?> 
                                    <h2>Aún no tiene información disponible del seguimiento de este pedido</h2>
                                <?php } else { ?>

                                    <div class="accordion" id="accordion1">
                                      <div class="accordion-group">
                                        <div class="accordion-heading">
                                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion1" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="font-size: 22px;">
                                            <strong>En Firme</strong>
                                          </a>
                                        </div>
                                        <div id="collapseOne" class="accordion-body collapse in">
                                          <div class="accordion-inner">
                                            <div class="col-lg-5" style="font-size: 15px;">Pedido:<br><strong><?php echo $id."-".$firme["pedido"]; ?> </strong></div>
                                            <div class="col-lg-7" style="font-size: 15px;">Fecha Pedido:<br><strong><?php echo $firme["fechaPedido"]; ?> </strong></div>
                                            <div class="col-lg-5" style="font-size: 15px;">Representante de ventas:<br><strong><?php echo $firme["representante"]; ?> </strong></div>
                                            <div class="col-lg-7" style="font-size: 15px;">Fecha Programada de Embarque:<br><strong><?php echo $firme["fechaEnFirme"]; ?> </strong></div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <?php if(!empty($firme) && !empty($firme["fechaOP"]) && !is_null($firme["fechaOP"])) { ?>
                                    <div class="accordion" id="accordion2">
                                      <div class="accordion-group">
                                        <div class="accordion-heading">
                                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo" style="font-size: 22px;">
                                            <strong>En Proceso</strong>
                                          </a>
                                        </div>
                                        <div id="collapseTwo" class="accordion-body collapse in">
                                          <div class="accordion-inner">
                                            <div class="col-lg-12" style="font-size: 15px;">Fecha OP: <strong><?php echo $firme["fechaOP"]; ?> </strong></div>

                                            <table class="table table-striped">
                                              <thead>
                                                <tr>
                                                  <th scope="col" style="text-align: center; color: black;">Producto</th>
                                                  <th scope="col" style="text-align: center; color: black;">Cantidad</th>
                                                  <!--<th scope="col" style="text-align: center; color: black;">Estado</th>-->
                                                  <th scope="col" style="text-align: center; color: black;">En Tránsito</th>
                                                  <th scope="col" style="text-align: center; color: black;">Recibido</th>
                                                </tr>
                                              </thead>
                                              <tbody style="text-align: center">

                                                <?php if (count($PROCESO) > 0) {
                                                    $estado = "En Proceso";
                                                    for ($i = 0; $i < count($PROCESO); $i++){
                                                      if($PROCESO[$i]['tipoLinea'] == "1" || $PROCESO[$i]['tipoLinea'] == "2"){
                                                        $embarca = 0;
                                                        $recibido = 0;
                                                        for ($j = 0; $j < count($PRODUCTOS); $j++){
                                                            if($PROCESO[$i]['linea'] == $PRODUCTOS[$j]['linea'] && $PRODUCTOS[$j]['recibido'] == '0'){
                                                                $embarca =+ $PRODUCTOS[$j]['cantidad'];
                                                                //CHECAR VALIDACION PARA ESTADO RECIBIDO
                                                            }
                                                            else if($PROCESO[$i]['linea'] == $PRODUCTOS[$j]['linea'] && $PRODUCTOS[$j]['recibido'] == '1'){
                                                                $recibido =+ $PRODUCTOS[$j]['cantidad'];
                                                                //CHECAR VALIDACION PARA ESTADO RECIBIDO
                                                            }
                                                        }
                                                        if($embarca == 0 && $recibido == 0){
                                                          $estado = "En Proceso";
                                                        }
                                                        if($embarca == $PROCESO[$i]['cantidad']){
                                                          $estado = "En Tránsito";
                                                        }
                                                        if($embarca < $PROCESO[$i]['cantidad'] && $embarca > 0){
                                                          $estado = "Parcialmente en Transito";
                                                        }
                                                        if($recibido < $PROCESO[$i]['cantidad'] && $recibido > 0){
                                                          $estado = "Parcialmente Entregado";
                                                        }
                                                        if($recibido == $PROCESO[$i]['cantidad']){
                                                          $estado = "Entregado";
                                                        }


                                                ?>

                                                <tr>
                                                  <th scope="row"><?php echo $PROCESO[$i]['descripcion']; ?></th>
                                                  <td><?php echo $PROCESO[$i]['cantidad']; ?></td>
                                                  <!--<td><?php echo $estado; ?></td>-->
                                                  <td><?php echo $embarca; ?></td>
                                                  <td><?php echo $recibido; ?></td>
                                                </tr>

                                                <?php } } } ?> 
                                              </tbody>
                                            </table>

                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php } ?>

                                    <?php if(count($EMBARQUES) > 0) { ?>
                                   
                                    <div class="accordion" id="accordion3">
                                      <div class="accordion-group">
                                        <div class="accordion-heading">
                                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree" style="font-size: 22px;">
                                            <strong>Embarque(s)</strong>
                                          </a>
                                        </div>
                                        <div id="collapseThree" class="accordion-body collapse in">
                                        <div class="accordion-inner">

                                        <?php 
                                            for ($i = 0; $i < count($EMBARQUES); $i++){
                                              $lista_embarques = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Embarques/'.$EMBARQUES[$i]['embarque'].'/Lista_de_Embarques.pdf');

                                              $guia_cobra = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Embarques/'.$EMBARQUES[$i]['embarque'].'/Guia.pdf');

                                              $detalle_recepcion = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Embarques/'.$EMBARQUES[$i]['embarque'].'/Detalle_Recepcion.pdf');

                                              $embarqueId = 'collapseFive_'.$i;
                                              $acordionId = 'accordion5_'.$i;
                                        ?>

                                        <div class="col-lg-12" style="font-size: 15px;">
                                            <div class="accordion" id=<?php echo $acordionId; ?>>
                                              <div class="accordion-group">
                                                <div class="accordion-heading">
                                                  <a class="accordion-toggle" data-toggle="collapse" data-parent=<?php echo "#".$acordionId; ?> href=<?php echo "#".$embarqueId; ?> aria-expanded="true" aria-controls=<?php echo $embarqueId; ?> style="font-size: 19px;">
                                                    Embarque <?php echo $EMBARQUES[$i]['embarque']." ".$EMBARQUES[$i]['estadoEmbarque']; ?>
                                                  </a>
                                                </div>
                                                <div id=<?php echo $embarqueId; ?> class="accordion-body collapse in">
                                                  <div class="accordion-inner">
                                                     
                                                    <div class="col-lg-8" style="font-size: 15px;">N° Embarque: <strong><?php echo $EMBARQUES[$i]['embarque']; ?> </strong></div>
                                                    <?php if(strpos($lista_embarques[0], "OK")) { ?>
                                                    <div class="col-lg-4" style="font-size: 15px;">Lista de Embarques: 
                                                        <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Embarques&id='.$EMBARQUES[$i]['embarque'].'&archivo=Lista_de_Embarques.pdf'; ?>"  style="text-decoration-line: underline; color: blue;">Descargar</a>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-lg-8" style="font-size: 15px;">Paquetería: <strong><?php echo $EMBARQUES[$i]['paqueteria']; ?> </strong> </div>
                                                    <?php if(strpos($guia_cobra[0], "OK")) { ?>
                                                    <div class="col-lg-4" style="font-size: 15px;">Guía (Por Cobrar): 
                                                        <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Embarques&id='.$EMBARQUES[$i]['embarque'].'&archivo=Guia.pdf'; ?>" style="text-decoration-line: underline; color: blue;">Descargar</a>
                                                    </div>
                                                    <?php } else if(strpos($detalle_recepcion[0], "OK")) { ?>
                                                      <div class="col-lg-4" style="font-size: 15px;">Detalle de Recepción: 
                                                        <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Embarques&id='.$EMBARQUES[$i]['embarque'].'&archivo=Detalle_Recepcion.pdf'; ?>" style="text-decoration-line: underline; color: blue;">Descargar</a>
                                                      </div>
                                                    <?php } ?>
                                                    <div class="col-lg-8" style="font-size: 15px;">Condiciones de Envío: <strong><?php echo $EMBARQUES[$i]['condicionesEnvio']; ?> </strong></div>
                                                    <?php if(strpos($detalle_recepcion[0], "OK") && strpos($guia_cobra[0], "OK")) { ?>
                                                    <div class="col-lg-4" style="font-size: 15px;">Detalle de Recepción: 
                                                        <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Embarques&id='.$EMBARQUES[$i]['embarque'].'&archivo=Detalle_Recepcion.pdf'; ?>" style="text-decoration-line: underline; color: blue;">Descargar</a>
                                                    </div>
                                                    <?php } ?>
                                                    <div class="col-lg-12" style="font-size: 15px;">Condiciones de Pago: <strong><?php echo $EMBARQUES[$i]['condicionesPago']; ?> </strong></div>
                                                    <div class="col-lg-8" style="font-size: 15px;">Guía: <strong><?php echo $EMBARQUES[$i]['guia']; ?> </strong>
                                                    </div>
                                                    <?php if(!is_null($EMBARQUES[$i]['aviso'])) { ?>
                                                      <div class="col-lg-4" style="font-size: 15px;"><strong style="font-size: 15px;color:white;background-color: <?php echo $EMBARQUES[$i]['color']; ?>;"><?php echo " ".$EMBARQUES[$i]['aviso']." "; ?> </strong>
                                                    </div>
                                                    <?php } ?>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>

                                    <?php } ?>


                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <?php } ?>
                                    
                                    <?php 

                                      if($_SESSION['user'] <> "david.rosado@vivapersianas.com" && $_SESSION['user'] <> "violeta.gomez@vivapersianas.com" && $_SESSION['user'] <> "claudia.villarreal@vivapersianas.com" && $_SESSION['user'] <> "claudia.paez@vivapersianas.com" && $_SESSION['user'] <> "damaris.saldana@vivapersianas.com" && $_SESSION['user'] <> "fernanda.cantu@vivapersianas.com" && $_SESSION['user'] <> "ernesto.resendez@vivapersianas.com" && $_SESSION['user'] <> "elisa.lona@vivapersianas.com" && $_SESSION['user'] <> "elba.velazquez@vivapersianas.com" && $_SESSION['user'] <> "claudia.gutierrez@vivapersianas.com" && $_SESSION['user'] <> "miguel.navarro@vivapersianas.com" && $_SESSION['user'] <> "operaciones@vivapersianas.com" && $_SESSION['user'] <> "viridiana.godoy@vivapersianas.com" && $_SESSION['user'] <> "guadalajara@vivapersianas.com" && $_SESSION['user'] <> "ericka.lopez@vivapersianas.com" && $_SESSION['user'] <> "alejandro.arellano@vivapersianas.com" && $_SESSION['user'] <> "gabriel.perales@vivapersianas.com" && $_SESSION['user'] <> "monica.pedraza@vivapersianas.com" && $_SESSION['user'] <> "damaris.saladana@vivapersianas.com" && $_SESSION['user'] <> "susana.dominguez@vivapersianas.com" && $_SESSION['user'] <> "daniel.flores@vivapersianas.com" && $_SESSION['user'] <> "ymena@vivapersianas.com" && $_SESSION['user'] <> "carlos.velazquez@vivapersianas.com" && $_SESSION['user'] <> "ricardo.sepulveda@vivapersianas.com" && $_SESSION['user'] <> "gabriel.gzz@vivapersianas.com" && $_SESSION['user'] <> "yadira.luna@vivapersianas.com" && $_SESSION['user'] <> "gabriel.gonzalez@vivapersianas.com" && $_SESSION['user'] <> "santiago.luna@vivapersianas.com" && $_SESSION['user'] <> "satisfaccion@vivapersianas.com" && $_SESSION['user'] <> "marcelo.perales@vivapersianas.com" && $_SESSION['user'] <> "pedro.cardiel@vivapersianas.com") {



                                      for ($i = 0; $i < count($Facturas); $i++) {

                                        $facturaId = 'collapseSix_'.$i;
                                        $accordionId = 'accordion6_'.$i;


                                        ?>
                                    <div class="accordion" id="accordion4">
                                      <div class="accordion-group">
                                        <div class="accordion-heading">
                                          <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour" style="font-size: 22px;">
                                            <strong>Factura(s)</strong>
                                          </a>
                                        </div>
                                        <div id="collapseFour" class="accordion-body collapse in">
                                          <div class="accordion-inner">

                                            <div class="col-lg-12" style="font-size: 15px;">
                                                <div class="accordion" id=<?php echo $accordionId; ?>>
                                                  <div class="accordion-group">
                                                    <div class="accordion-heading">
                                                      <a class="accordion-toggle" data-toggle="collapse" data-parent=<?php echo "#".$accordionId; ?> href=<?php echo "#".$facturaId; ?> aria-expanded="true" aria-controls=<?php echo $facturaId; ?> style="font-size: 19px;">
                                                        Factura <?php echo $Facturas[$i]['serie'].$Facturas[$i]['folio']; ?>
                                                      </a>
                                                    </div>
                                                    <div id=<?php echo $facturaId; ?> class="accordion-body collapse in">
                                                      <div class="accordion-inner">
                                                         
                                                      <?php  if(!empty($Facturas[$i]["folio"]) && !is_null($Facturas[$i]["folio"])) { 

                                                        $xml_info = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Factura/'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'/Factura'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'.xml');

                                                        $pdf_info = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Factura/'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'/Factura'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'.pdf');

                                                        ?>
                                                        <div class="col-lg-12" style="font-size: 15px;">Factura: 
                                                          <?php if(strpos($xml_info[0], "OK")) { ?>
                                                            <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Factura&id='.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'&archivo=Factura'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'.xml'; ?>" style="text-decoration-line: underline; color: blue;">XML</a>
                                                          <?php } else { ?> 
                                                            <span>XML</span>
                                                          <?php } ?>
                                                          <?php  if(strpos($pdf_info[0], "OK")) { ?>
                                                            <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Factura&id='.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'&archivo=Factura'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'.pdf'; ?>" style="text-decoration-line: underline; color: blue;">PDF</a>
                                                          <?php } else { ?>
                                                            <span>PDF</span>
                                                          <?php } ?>
                                                        </div>
                                                      <?php } else {?>
                                                        <div class="col-lg-12" style="font-size: 15px;">Por el momento, el XML y PDF de la factura no estan disponibles </div> 
                                                      <?php }?>

                                                        <?php $Complementos = DatosFolioComplementos($Facturas[$i]["folio"]);
                                                          for ($j = 0; $j < count($Complementos); $j++){
                                                            if(!empty($Complementos[$j]["folio"]) && !is_null($Complementos[$j]["folio"])) { 

                                                              $xml_info = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Factura/'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'/Complemento'.$Complementos[$j]['serie'].$Complementos[$j]['folio'].'.xml');

                                                              $pdf_info = @get_headers('http://192.168.1.60:81/Seguimientos/'.$firme["pedido"].'/Factura/'.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'/Complemento'.$Complementos[$j]['serie'].$Complementos[$j]['folio'].'.pdf');

                                                              if(!strpos($xml_info[0], "OK") && !strpos($pdf_info[0], "OK")){}
                                                              else{

                                                        ?>
                                                        <div class="col-lg-12" style="font-size: 15px;">Complemento <?php echo $Complementos[$j]['serie'].$Complementos[$j]['folio']; ?>: 
                                                            <?php if(strpos($xml_info[0], "OK")) { ?>
                                                            <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Factura&id='.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'&archivo=Complemento'.$Complementos[$j]['serie'].$Complementos[$j]['folio'].'.xml'; ?>" style="text-decoration-line: underline; color: blue;">XML</a>
                                                            <?php } else { ?>
                                                            <span>XML</span>
                                                            <?php } ?>
                                                            <?php  if(strpos($pdf_info[0], "OK")) { ?>
                                                            <a href="<?php echo 'download.php?pedido='.$firme["pedido"].'&tipo=Factura&id='.$Facturas[$i]['serie'].$Facturas[$i]['folio'].'&archivo=Complemento'.$Complementos[$j]['serie'].$Complementos[$j]['folio'].'.pdf'; ?>" style="text-decoration-line: underline; color: blue;">PDF</a>
                                                            <?php } else { ?>
                                                            <span>PDF</span>
                                                          <?php } ?>
                                                        </div>
                                                        <?php  }} }?>

                                                        
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                            

                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <?php }?>
                                                                   
                                <?php }} ?>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
  </div>