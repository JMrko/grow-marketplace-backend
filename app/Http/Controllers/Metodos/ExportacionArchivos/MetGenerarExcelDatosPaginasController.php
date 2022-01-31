<?php

namespace App\Http\Controllers\Metodos\ExportacionArchivos;

use App\Http\Controllers\Controller;
use App\Models\dtpdatospaginas;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class MetGenerarExcelDatosPaginasController extends Controller
{
    public function MetExportarExcelDtp()
    {
        $cantidadRegistros = dtpdatospaginas::count();
        $datos = dtpdatospaginas::get([
                                        'pagid',
                                        'dtpnombre',
                                        'dtpprecioactual'
                                    ]);

        $documento = new Spreadsheet();
        $hoja = $documento->getActiveSheet();
        $hoja->setTitle("dtpdatospagina");

        $hoja->setCellValue('A1','PAGINA');
        $hoja->setCellValue('B1','NOMBRE PRODUCTO');
        $hoja->setCellValue('C1','PRECIO');
        for ($i=2; $i <= $cantidadRegistros + 1 ; $i++) { 
            $posicion = $i-2;
            $hoja->setCellValue("A$i", $datos[$posicion]->pagid);
            $hoja->setCellValue("B$i", $datos[$posicion]->dtpnombre);
            $hoja->setCellValue("C$i", $datos[$posicion]->dtpprecioactual);
        }

        $fileName="datospaginas.xlsx";
        $writer = new Xlsx($documento);
        // $writer->move('GenerarExcel/DatosPaginas', $fileName);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'. urlencode($fileName).'"');
        $writer->save('php://output');
    }
}
