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
        $hoja->mergeCells('C2:D3');
        $hoja->mergeCells('E2:G3');

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
