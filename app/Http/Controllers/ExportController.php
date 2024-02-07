<?php

namespace App\Http\Controllers;

use App\Models\Pendukung;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        if (Auth::user()->level != "admin") {
            return redirect()->to('/');
        }
        
        $pendukung = Pendukung::select('dpts.*', 'calegs.name as nama_caleg', 'users.name as nama_user')
        ->leftJoin('calegs', 'pendukungs.caleg_id', '=', 'calegs.id')
        ->leftJoin('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')
        ->leftJoin('users', 'pendukungs.user_id', '=', 'users.id')
        ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $bulantahun = date('d-m-Y');

        $sheet->setCellValue('A1', 'Data Plasma Per '.$bulantahun);
        $stylea1 = [
            'font' => [
                'bold' => true,
                'size' => 20
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ]
        ];
        
        $sheet->getStyle('A1')->applyFromArray($stylea1);
        $sheet->mergeCells('A1:H1');


                // style judul
                $stylejudul = [
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true,
                    ]
                ];
        
                $sheet->getStyle('A3:H3')->applyFromArray($stylejudul);

        // Add headers
        $sheet->setCellValue('A3', 'No.');
        $sheet->setCellValue('B3', 'Nama');
        $sheet->setCellValue('C3', 'Umur');
        $sheet->setCellValue('D3', 'Jenis Kelamin');
        $sheet->setCellValue('E3', 'Kelurahan');
        $sheet->setCellValue('F3', 'Kecamatan');
        $sheet->setCellValue('G3', 'TPS');
        $sheet->setCellValue('H3', 'Koordinator');
        // Add more headers as needed...

        //lebar kolom
        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(7);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(8);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15);

        // Add data
        $row = 4;
        $no = 1;
        foreach ($pendukung as $pend) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $pend->nama);
            $sheet->setCellValue('C' . $row, $pend->umur);
            $sheet->setCellValue('D' . $row, $pend->jenis_kelamin);
            $sheet->setCellValue('E' . $row, $pend->kelurahan);
            $sheet->setCellValue('F' . $row, $pend->kecamatan);
            $sheet->setCellValue('G' . $row, $pend->tps);
            $sheet->setCellValue('H' . $row, $pend->nama_user);
            // Add more data as needed...
            $row++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $row = $row - 1;
        $sheet->getStyle('A3:H'.$row)->applyFromArray($styleArray);

        // Save the spreadsheet to a file
        $filename = 'pendukung-'.date('Y-m-d').'.xlsx';
        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        // Download the file
        return response()->download($filename)->deleteFileAfterSend(true);

    }
}
