<?php
//require_once '../../conexion/cnx.php';
include_once '../clases/Carrito.class.php';
require_once '../fnc/terminarIva.php';
require_once '../fnc/terminarDescuento.php';

$Nombre = $_GET['Nombre'];
$Tipo = $_GET['op'];

$carrito = new Carrito();
$carro = $carrito->get_content();
$DescuentoProductoReal = 0;

require_once '../clases/PHPExcel.php';
$objPHPExcel = new PHPExcel();

//Informacion del excel
$objPHPExcel->
    getProperties()
    ->setCreator("DUES")
    ->setLastModifiedBy("DUES")
    ->setTitle("Exportar excel desde mysql")
    ->setSubject("Reporte")
    ->setDescription("Documento generado con PHPExcel")
    ->setKeywords("DUES")
    ->setCategory("Reporte");

if ($Tipo == 1) {
    $Descuento = "";
    $iva = TraerIva();
    $SubtotalTotal = $carrito->precio_total();
    $IvaTotal = ($SubtotalTotal * ($iva / 100));
    $TotalFinal = $SubtotalTotal + $IvaTotal;
} else {
    $Descuento = "Descuento";
    $iva = TraerIvaPorId($_SESSION['folio']);
    $DescuentoProducto = TraerDescuentoPorID($_SESSION['folio']);
    $TotalPorcentaje = GenerarPorcentajePorId($_SESSION['folio']);
    $DescuentoPorcentaje = GenerarCantidadFinal($TotalPorcentaje, $carrito->precio_total(), 1);
}

if ($Tipo == 2) { 
    $objPHPExcel->getActiveSheet()->mergeCells('C1:E4'); 
    $gdImage = imagecreatefromjpeg('../../assets/img/logo/LOGOS_SECCIONS_GENERALES.jpg');
    $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setImageResource($gdImage);
    $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
    $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
    $objDrawing->setHeight(55);
    $objDrawing->setOffsetX(1); // set x position 
    $objDrawing->setOffsetY(10);  
    $objDrawing->setCoordinates('C1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
}

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A1', "Cotizacion")
    ->setCellValue('A2', "DUES TEXTIL S.A. de C.V.")
    ->setCellValue('A3', "Av. La Marina 651, Col. Francisco Villa")
    ->setCellValue('A4', "Mazatlan, Sin., México, C.P. 82127 / Tel. (669) 105 51 40")
    ->setCellValue('A5', "RFC: DTE 031126 KD1")
    ->setCellValue('A6', 'Cliente: ' . $Nombre)
    ->setCellValue('A7', 'Domicilio: ')
    ->setCellValue('A8', 'Telefono: ')
    ->setCellValue('A10', 'Cantidad')
    ->setCellValue('B10', 'Producto')
    ->setCellValue('C10', 'Precio Unitario')
    ->setCellValue('D10', $Descuento)
    ->setCellValue('E10', 'Total');

$i = 11;

$Total = 0;
//while($registro = mysqli_fetch_object($result)) {
if ($carro) {
    function cmp($a, $b)
    {return strcasecmp($a["area"], $b["area"]);}
    usort($carro, "cmp");
    foreach ($carro as $producto) {

        if ($Tipo == 1) {
            $desc = "";
            $Total = ($producto["precio"] * $producto["cantidad"]);
        } else {
            $desc = GenerarCantidadFinal($TotalPorcentaje, $producto["precio"], $producto["cantidad"], $producto["tipoarticulo"], $producto["TipoArticuloDetalle"]);
            $DescuentoProductoReal = $DescuentoProductoReal + $desc;
            $Total = (($producto["cantidad"] * $producto["precio"]) - $desc);
            // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
            $desc = number_format($desc, 2, '.', ',');
        }

        if ($producto["tipoarticulo"] == "cortinero") {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $producto["cantidad"])
                ->setCellValue('B' . $i, $producto["nombre"] . " " . $producto["ancho"] . " A " . $producto["fijacion"] . ". Área: " . $producto["area"])
                // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
                ->setCellValue('C' . $i, "$ " . number_format($producto["precio"], 2, '.', ','))
                ->setCellValue('D' . $i, $desc)
                // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
                ->setCellValue('E' . $i, "$ " . number_format($Total, 2, '.', ','));
            $i++;

            if ($producto["baston"] == "true") {
                $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('B' . $i, "Baston " . $producto["colorBaston"] . " " . $producto["radioMedida"] . " " . $producto["radioMaterial"])
                    ->setCellValue('E' . $i, "");
                $i++;
            }

        } else {

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $producto["cantidad"])
                ->setCellValue('B' . $i, $producto["nombre"] . ". Área: " . $producto["area"])
                // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
                ->setCellValue('C' . $i, "$ " . number_format($producto["precio"], 2, '.', ','))
                ->setCellValue('D' . $i, $desc)
                // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
                ->setCellValue('E' . $i, "$ " . number_format($Total, 2, '.', ','));
            $i++;

            if (isset($producto["ColorForro"])) {
                $Forro = ", Forrada en: " . $producto["telaForro"] . " " . $producto["ColorForro"];
            } else {
                $Forro = "";
            }

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $i, "EN TELA: " . $producto["tela"] . " COLOR: " . $producto["color"] . $Forro)
                ->setCellValue('E' . $i, "");

            $i++;

            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('B' . $i, "MEDIDAS: " . $producto["ancho"] . " x " . $producto["alto"])
                ->setCellValue('E' . $i, "");

            $i++;
        }

        $i++;
    }
}

 // **NUEVO: Mostrar detalles adicionales para Cortina Romana** COMENTADO POR SI NOS LO PIDEN 09/12/25
            /*if ($producto["tipoarticulo"] == "romana") {
                // Mostrar Hojas
                if (isset($producto["hojas"]) && !empty($producto["hojas"])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $i, "HOJAS: " . $producto["hojas"])
                        ->setCellValue('E' . $i, "");
                    $i++;
                }
                
                // Mostrar Lado del Cordón
                if (isset($producto["lado_cordon"]) && !empty($producto["lado_cordon"])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $i, "LADO DEL CORDÓN: " . $producto["lado_cordon"])
                        ->setCellValue('E' . $i, "");
                    $i++;
                }
                
                // Mostrar Fijación
                if (isset($producto["fijacion"]) && !empty($producto["fijacion"])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $i, "FIJACIÓN: " . $producto["fijacion"])
                        ->setCellValue('E' . $i, "");
                    $i++;
                }
                
                // Mostrar Varilla
                if (isset($producto["Varilla"]) && !empty($producto["Varilla"])) {
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('B' . $i, "VARILLA: " . $producto["Varilla"])
                        ->setCellValue('E' . $i, "");
                    $i++;
                }
            }*/
        
if ($Tipo != 1) {
    $SubtotalTotal = $carrito->precio_total() - $DescuentoProductoReal;
    $IvaTotal = ($SubtotalTotal * ($iva / 100));
    $TotalFinal = $SubtotalTotal + $IvaTotal;
}
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('D' . $i, "SUBTOTAL: ")
    // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
    ->setCellValue('E' . $i, "$ " . number_format($SubtotalTotal, 2, '.', ','));
$j = $i + 1;

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('D' . $j, "IVA: ")
    // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
    ->setCellValue('E' . $j, "$ " . number_format($IvaTotal, 2, '.', ','));
$k = $i + 2;

$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('D' . $k, "TOTAL: ")
    // MODIFICACIÓN AQUÍ: se quitó el espacio después de la coma
    ->setCellValue('E' . $k, "$ " . number_format($TotalFinal, 2, '.', ','));

$objPHPExcel->getActiveSheet()->getStyle("A10:E10")->applyFromArray(array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
));

$objPHPExcel->getActiveSheet()->getStyle("B11:B" . $i)->applyFromArray(array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
));

$objPHPExcel->getActiveSheet()->getStyle("C11:E" . $k)->applyFromArray(array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
    ),
));
$objPHPExcel->getActiveSheet()->getStyle("A11:A" . $i)->applyFromArray(array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    ),
));

$objPHPExcel->getActiveSheet()->getStyle("A6:E8")->applyFromArray(array('fill' => array( //relleno de color
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
),
    'borders' => array( //bordes
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
    ),
));

$objPHPExcel->getActiveSheet()->getStyle("A10:E10")->applyFromArray(array('fill' => array( //relleno de color
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
),
    'borders' => array( //bordes
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
    ),
));

$objPHPExcel->getActiveSheet()->getStyle("A" . $i . ":E" . $k)->applyFromArray(array('fill' => array( //relleno de color
    'type' => PHPExcel_Style_Fill::FILL_SOLID,
),
    'borders' => array( //bordes
        'top' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'right' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
        'left' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM),
    ),
));

$objPHPExcel->getActiveSheet()->getStyle('A1:E5')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setWrapText(TRUE);
for ($col = 'B'; $col !== 'F'; $col++) {
    $objPHPExcel->getActiveSheet()
        ->getColumnDimension($col)
        ->setAutoSize(true);
}
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;