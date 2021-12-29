<?php

namespace App\Http\Controllers\Metodos\ExportacionArchivos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use ZipArchive;

class MetGenerarExcelController extends Controller
{
    public function MetExcelNorte()
    {
        $documento = new Spreadsheet();
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("CONSORCIO ZIA TRUJILLO");

        //DEFINICION DEL TAMAÑO DE LAS COLUMNAS Y FILAS
        $hoja->getColumnDimension('B')->setVisible(false);
        $hoja->getColumnDimension('A')->setWidth(6.45);
        $hoja->getColumnDimension('C')->setWidth(6);
        $hoja->getColumnDimension('D')->setWidth(25.39);
        $hoja->getColumnDimension('E')->setWidth(11);
        $hoja->getColumnDimension('F')->setWidth(43.69);
        $hoja->getColumnDimension('G')->setWidth(22);
        $hoja->getColumnDimension('H')->setWidth(20);
        $hoja->getColumnDimension('I')->setWidth(6.45);
        $hoja->getRowDimension('2')->setRowHeight(37.5);
        $hoja->getRowDimension('3')->setRowHeight(36.5);
        $hoja->getRowDimension('4')->setRowHeight(40.5);
        for ($i=5; $i <= 14 ; $i++) { 
            $hoja->getRowDimension("$i")->setRowHeight(31.5);
        }
        $hoja->getRowDimension('15')->setRowHeight(13.5);
        $hoja->getRowDimension('16')->setRowHeight(23.25);
        for ($i=17; $i <=56 ; $i++) { 
            $hoja->getRowDimension("$i")->setRowHeight(17.25);
        }
        $hoja->getRowDimension('60')->setRowHeight(11.25);
        $hoja->getRowDimension('61')->setRowHeight(11.25);
        $hoja->getRowDimension('62')->setRowHeight(11.25);
        $hoja->getRowDimension('63')->setRowHeight(11.25);
        $hoja->getRowDimension('64')->setRowHeight(9);
        $hoja->getRowDimension('65')->setRowHeight(18);
        $hoja->getRowDimension('66')->setRowHeight(23.25);
        $hoja->getRowDimension('67')->setRowHeight(23.25);
        $hoja->getRowDimension('68')->setRowHeight(23.25);
        //UNION DE COLUMNAS
        $hoja->mergeCells('C2:D3');
        $hoja->mergeCells('E2:G3');
        $hoja->mergeCells('H2:H3');
        $hoja->mergeCells('C4:H4');
        for ($i=5; $i <= 14 ; $i++) { 
            $hoja->mergeCells("C$i:D$i");
            $hoja->mergeCells("E$i:H$i");
        }
        $hoja->mergeCells('D56:F56');
        $hoja->mergeCells('C58:E59');
        $hoja->mergeCells('F58:F59');
        $hoja->mergeCells('G58:H59');
        $hoja->mergeCells('C60:E63');
        $hoja->mergeCells('F60:F63');
        $hoja->mergeCells('G60:H63');

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Logo');
        $drawing->setPath('./images/logo.png');
        $drawing->setCoordinates('C2:D3');
        $drawing->setHeight(2.39, 'cm');
        $hoja->getStyle('C2:D3')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E2', "SOLICITUD DE EMISIÓN DE NOTA DE CRÉDITO FINANCIERA")
                ->getStyle('E2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E2')->getFont()->setSize(18)->setBold(true)->setName('Arial');
        $hoja->getStyle('E2:G3')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->getStyle('H2:H3')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C4','Por medio de la presente le solicitamos la generación de una Nota de Crédito Financiera al cliente de la referencia según datos adjuntos:')
                ->getStyle('C4')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C4')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('C4:H4')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C5','Solicitado por:')
            ->getStyle('C5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C5')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C5:D5')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E5','Anthony Omar Quiroz Morales')
            ->getStyle('E5')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E5')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E5:H5')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C6','Canal:')
            ->getStyle('C6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C6')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C6:D6')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E6','20 - INSTITUCIONAL')
            ->getStyle('E6')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E6')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E6:H6')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C7','Fecha:')
            ->getStyle('C7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C7')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C7:D7')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E7', date('d-m-Y'))
            ->getStyle('E7')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E7')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E7:H7')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C8','Oficina de ventas:')
            ->getStyle('C8')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C8')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C8:D8')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E8', '1304')
            ->getStyle('E8')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E8')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E8:H8')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C9','Destinatario')
            ->getStyle('C9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C9')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C9:D9')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E9', '148921 - CONSORCIO Z.I.A TRUJILLO')
            ->getStyle('E9')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E9')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E9:H9')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C10','Cliente:')
            ->getStyle('C10')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C10')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C10:D10')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E10', '148921 - CONSORCIO Z.I.A')
            ->getStyle('E10')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E10')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E10:H10')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C11','Valor venta:')
            ->getStyle('C11')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C11')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C11:D11')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E11', '=G63')
            ->getStyle('E11')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E11')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E11:H11')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C12','Motivo de descuento:')
            ->getStyle('C12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C12')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C12:D12')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E12', 'DESCUENTOS EN PRECIO')
            ->getStyle('E12')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E12')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('E12:H12')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C13','Detalle')
            ->getStyle('C13')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C13')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C13:D13')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E13', 'PRECIOS ESPECIALES (SUBSIDIO)')
            ->getStyle('E13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E13')->getFont()->setSize(14)->setName('Arial');
        $hoja->getStyle('E13:H13')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('C14','Correspondiente al mes')
            ->getStyle('C14')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C14')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('C14:D14')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E14', 'AGOSTO')
            ->getStyle('E14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
            ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E14')->getFont()->setSize(14)->setBold(true)->setName('Arial');
        $hoja->getStyle('E14:H14')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        //CONTORNO TABLA PRODUDCTOS
        $hoja->getStyle('C15:H15')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $hoja->getStyle('C15')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $hoja->getStyle('H15')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        for ($i=16; $i <=56 ; $i++) { 
            $hoja->getStyle("C$i")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
            $hoja->getStyle("C$i")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
            $hoja->getStyle("H$i")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
            $hoja->getStyle("H$i")->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
        }
        $hoja->getStyle('C57:H57')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $hoja->getStyle('C57')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $hoja->getStyle('H57')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);


        //TABLA DE PRODUCTOS
        //CABECERA
        $hoja->setCellValue('D16', 'Factura de referencia')
                ->getStyle('D16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('D16')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('D16')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('E16', 'Material')
                ->getStyle('E16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('E16')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('E16')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('F16', 'Descripción')
                ->getStyle('F16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('F16')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('F16')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('G16', 'Importe')
                ->getStyle('G16')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('G16')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('G16')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        //CONTENIDO
        for ($i=17; $i <=56 ; $i++) { 
            $hoja->setCellValue("D$i", '01-FF01-00808722')
                ->getStyle("D$i")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
            $hoja->getStyle("D$i")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

            $hoja->setCellValue("E$i", '360664')
                    ->getStyle("E$i")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_BOTTOM);
            $hoja->getStyle("E$i")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

            $hoja->setCellValue("F$i", 'SA Elite Plus Blanca UH 100 mts x1x2')
                    ->getStyle("F$i")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
            $hoja->getStyle("F$i")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

            $hoja->setCellValue("G$i", '80')
                    ->getStyle("G$i")->getAlignment()->setVertical(Alignment::VERTICAL_BOTTOM);
            $hoja->getStyle("G$i")->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
            if ($i==55) {
                $hoja->setCellValue("D$i", '');
                $hoja->setCellValue("E$i", '');
                $hoja->setCellValue("F$i", '');
                $hoja->setCellValue("G$i", '');
            }
            if ($i==56) {
                $hoja->setCellValue("D$i", 'TOTAL')
                    ->getStyle("D$i")->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                    ->setVertical(Alignment::VERTICAL_BOTTOM);

                $hoja->setCellValue("G$i", '=SUMA(G17:G54)');
            }
        }

        //FOOTER
        $hoja->setCellValue('C58', 'JEFE DE VENTAS')
                ->getStyle('C58')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('C58')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('C58:E59')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('F58', 'GERENTE DIV.INSTITUCIONAL')
                ->getStyle('F58')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('F58')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('F58:F59')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->setCellValue('G58', 'GERENTE GENERAL')
                ->getStyle('G58')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)->setWrapText(true);
        $hoja->getStyle('G58')->getFont()->setSize(10)->setBold(true)->setName('Arial');
        $hoja->getStyle('G58:H59')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);

        $hoja->getStyle('C60:E63')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $hoja->getStyle('F60:F63')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);
        $hoja->getStyle('G60:H63')->getBorders()->getOutline()->setBorderStyle(Border::BORDER_THIN);


        $hoja->setCellValue('C65', 'Enviar la solicitud + sustento :')
                ->getStyle('C65')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER);
        $hoja->getStyle('C65')->getFont()->setSize(14)->setBold(true)->setName('Arial');

        $hoja->setCellValue('C66', 'Original: Contabilidad (Adm. vtas)')
                ->getStyle('C66')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER);
        $hoja->getStyle('C66')->getFont()->setSize(14)->setName('Arial');

        $hoja->setCellValue('C67', 'Copia: Contabilidad (Estudio Contable)')
                ->getStyle('C67')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER);
        $hoja->getStyle('C67')->getFont()->setSize(14)->setName('Arial');

        $hoja->setCellValue('C68', 'Copia: Distribución')
                ->getStyle('C68')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT)
                ->setVertical(Alignment::VERTICAL_CENTER);
        $hoja->getStyle('C68')->getFont()->setSize(14)->setName('Arial');   

        $hoja->getStyle('C64:H64')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $hoja->getStyle('C65:H65')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('#B4C6E7');
        $hoja->getStyle('C66:H68')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF');
        $hoja->getStyle('C68:H68')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
        $hoja->getStyle('C64:C68')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);
        $hoja->getStyle('H64:H68')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);

        //Creacion de otra hoja
        $worksheet2 = $documento->createSheet();
        $worksheet2->setTitle('Another sheet');

        $hoja = $documento->getSheet('1');
        $hoja->setCellValue('A1', 'GERENTE GENERAL');
        $hoja->setCellValue('A2', 'GERENTE GENERAL2');

        //definir la hoja activa
        $hoja = $documento->setActiveSheetIndex(0);

                        
        $fileNameExcel="NORTE_2.xlsx";
        $writer = new Xlsx($documento);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileNameExcel).'"');
        $writer->save('php://output');
    }

    public function MetGenerarExcel()
    {
        $cantidad = 2;
        for ($i=1; $i <=$cantidad ; $i++) { 
            $documento = new Spreadsheet();
            $documento->getProperties()
                        ->setCreator("Aquí va el creador, como cadena")
                        ->setLastModifiedBy('Parzibyte') // última vez modificado por
                        ->setTitle('Mi primer documento creado con PhpSpreadSheet')
                        ->setSubject('El asunto')
                        ->setDescription('Este documento fue generado para Grow')
                        ->setKeywords('etiquetas o palabras clave separadas por espacios')
                        ->setCategory('La categoría');

            
            $documento->getDefaultStyle()->getFont()->setName('Arial');
            $documento->getDefaultStyle()->getFont()->setSize(8);

            $hoja = $documento->getActiveSheet();
        
            $hoja->setTitle("El título de la hoja");
            $hoja->setCellValueByColumnAndRow(1, 1, "Un valor en 1, 1");
            $hoja->getColumnDimension('A')->setWidth(30);
            // $hoja->getDefaultColumnDimension()->setWidth(12);//ancho excel general
            // $hoja->getDefaultRowDimension()->setRowHeight(15);//alto excel general
            // $hoja->getColumnDimension('A')->setAutoSize(true);//ancho automatico
            // $hoja->getColumnDimension('C')->setVisible(false);//ocultar columna
            // $hoja->getRowDimension('10')->setRowHeight(100);//alto de una fila
            // $hoja->getRowDimension('10')->setVisible(false);//ocultar una fila
            // $hoja->getSheetView()->setZoomScale(75); //zoom 
            // $hoja->mergeCells('A18:E22');//unir celdas
            // $hoja->unmergeCells('A18:E22');//separar celdas
            $hoja->setCellValue("B2", "Este va en B2");
            $hoja->getStyle('B2')->getFont()->getColor()->setARGB(Color::COLOR_RED);//color rojo letra
            $hoja->setCellValue("C2", "Este va en C2");
            $hoja->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);//alineamiento derecha
            // $hoja->getStyle('C2')->getAlignment()->setVertical(Alignment::VERTICAL_TOP);//alieamiento top
            // $hoja->getStyle('C2')->getAlignment()->setWrapText(true);//justificar
            $hoja->setCellValue("C3", "Este va en C3");
            $hoja->getStyle('C3')->getBorders()->getTop()->setBorderStyle(Border::BORDER_THICK); //borde superior
            $hoja->setCellValue("D2", "Este va en D2");
            $hoja->getStyle('D2')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);//borde inferior
            // $hoja->getStyle('D2')->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THICK);//borde izquierdo
            // $hoja->getStyle('D2')->getBorders()->getRight()->setBorderStyle(Border::BORDER_THICK);//borde derecho
            $hoja->setCellValue("A3", "Este va en A3");
            $hoja->getStyle('A3')->getFill()->setFillType(Fill::FILL_SOLID);//relleno blanco
            $hoja->setCellValue("A4", "Este va en A4");
            $hoja->getStyle('A4')->getFill()->getStartColor()->setARGB('FFFF0000');
            $hoja->getStyle('A3:A4')->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setARGB('FFFF0000');

            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_RIGHT,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_GRADIENT_LINEAR,
                    'rotation' => 90,
                    'startColor' => [
                        'argb' => 'FFA0A0A0',
                    ],
                    'endColor' => [
                        'argb' => 'FFFFFFFF',
                    ],
                ],
            ];
            $hoja->setCellValue("E1", "Este va en E1");
            $hoja->getStyle('E1')->applyFromArray($styleArray);

            $hoja->setCellValue("E4", "1578.2");
            $hoja->getStyle('E4')->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);//LA COMA EN NUMEROS

            $worksheet1 = $documento->createSheet();
            $worksheet1->setTitle('Another sheet')
                        ->getTabColor()->setRGB('FF0000');

            $fileNameExcel="test".$i.".xlsx";
            $writer = new Xlsx($documento);
            // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            // header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
            // $writer->save('php://output');
            $writer->save($fileNameExcel);

            if ($i == 1) {
                $fileName="comprimido.rar";
                // Creamos un instancia de la clase ZipArchive
                $zip = new ZipArchive();
                // Creamos y abrimos un archivo zip temporal
                $zip->open("miarchivo.zip",ZipArchive::CREATE);
                // Añadimos un directorio
                $dir = 'miDirectorio';
                $zip->addEmptyDir($dir);
                // Añadimos un archivo en la raid del zip.
            }
            $zip->addFile($fileNameExcel);
            // Una vez añadido los archivos deseados cerramos el zip.
            if ($i == $cantidad) {
                $zip->close();
                // Creamos las cabezeras que forzaran la descarga del archivo como archivo zip.
                header("Content-type: application/octet-stream");
                header('Content-disposition: attachment; filename="'. urlencode($fileName).'"');
                // leemos el archivo creado
                readfile('miarchivo.zip');
                // Por último eliminamos el archivo temporal creado
                unlink('miarchivo.zip');//Destruye el archivo temporal
            }
            
        }
    }
}
