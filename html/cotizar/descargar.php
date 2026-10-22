<?php
  require_once '../../conexion/cnx.php';
  $Where = " where c.ID_USUARIO_ALTA is not null"; 
  if (isset($_GET['distribuidor']) and $_GET['distribuidor'] <> ""){ 
    $distribuidor = $_GET['distribuidor'];
    $Where = $Where . " and c.ID_USUARIO_ALTA = " .$distribuidor;
  }
  if (isset($_GET['folio']) and $_GET['folio'] <> ""){ 
		$folio = $_GET['folio'];
		$Where = $Where . " AND CAST(ID_COTIZACION as CHAR(50)) LIKE '%" .$folio . "%'";
	}
  if (isset($_GET['fecha1']) and $_GET['fecha1'] <> ""){ 
    $fecha1 = $_GET['fecha1'];
    $Where = $Where . " and date(c.FECHA_ALTA) >= '" .$fecha1 . "'";
  }
  if (isset($_GET['fecha2']) and $_GET['fecha2'] <> ""){ 
    $fecha2 = $_GET['fecha2'];
    $Where = $Where . " and date(c.FECHA_ALTA) <= '" .$fecha2."'";
  }
  if ((isset($_GET['Pro']) and $_GET['Pro'] <> "") and (isset($_GET['Ve']) and $_GET['Ve'] <> "")){
    $Where = $Where . " and (c.ESTADO = 0 or c.ESTADO = 4) ";
  }elseif (isset($_GET['Pro']) and $_GET['Pro'] <> ""){ 
    $Where = $Where . " and c.ESTADO = 0";
  }elseif (isset($_GET['Ve']) and $_GET['Ve'] <> ""){ 
    $Where = $Where . " and c.ESTADO = 4";
  }
  $sql = "SELECT ID_COTIZACION, us.NOMBRE,c.FECHA_ALTA,SUBTOTAL,DESCUENTO,IVA, TOTAL,c.ESTADO,cli.nombre as cliente,
  if(c.ESTADO = 1, 'AUTORIZADO',IF(c.ESTADO=2,'VERIFICAR',IF(c.ESTADO=3,'CON PEDIDO EN SAP','SIN REVISIÓN'))) AS ESTATUSt,
    c.ESTATUS, us.EMAIL from cotizacion c INNER join usuario us on (us.ID_USUARIO = c.ID_USUARIO_ALTA)
   inner join cliente cli on (cli.id_cliente = c.id_cliente) " . $Where;
   $result = mysqli_query($GLOBALS['db'], $sql);
if (mysqli_num_rows($result) > 0) {
  require_once '../clases/PHPExcel.php';
  $objPHPExcel = new PHPExcel();
  $objPHPExcel->
  getProperties()
      ->setCreator("DUES")
      ->setLastModifiedBy("DUES")
      ->setTitle("Exportar excel desde mysql")
      ->setSubject("Reporte")
      ->setDescription("Documento generado con PHPExcel")
      ->setKeywords("DUES")
      ->setCategory("Reporte");    

        $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A1', 'FOLIO')
          ->setCellValue('B1', 'FECHA')
          ->setCellValue('C1', 'DISTRIBUIDOR')
          ->setCellValue('D1', 'SUBTOTAL')
          ->setCellValue('E1', 'DESCUENTO')
          ->setCellValue('F1', 'IVA')
          ->setCellValue('G1', 'TOTAL')
          ->setCellValue('H1', 'ESTATUS');
  $i = 2;    
  while($registro = mysqli_fetch_object($result)) {
  $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, $registro->ID_COTIZACION)
    ->setCellValue('B'.$i, $registro->FECHA_ALTA)
    ->setCellValue('C'.$i, $registro->NOMBRE)
    ->setCellValue('D'.$i, $registro->SUBTOTAL)
    ->setCellValue('E'.$i, $registro->DESCUENTO)
    ->setCellValue('F'.$i, $registro->IVA)
    ->setCellValue('G'.$i, $registro->TOTAL)
    ->setCellValue('H'.$i, $registro->ESTATUSt);
    $i++;
  }
}
  $objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true);
    for($col = 'A'; $col !== 'J'; $col++) {
      $objPHPExcel->getActiveSheet()
          ->getColumnDimension($col)
          ->setAutoSize(true);
    }
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Reporte.xls"');
  header('Cache-Control: max-age=0');
  header('Cache-Control: max-age=1');
  header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
  header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
  header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
  header ('Pragma: public'); // HTTP/1.0
  $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
  $objWriter->save('php://output');
  exit;
?>