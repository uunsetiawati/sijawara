<?php

namespace App\Http\Controllers;

use JWTAuth, Validator, RestApi, AppHelper;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ExportExcelController extends Controller
{
    public function offlineCourseParticipant(Request $request)
    {
        $rules = [
            'course' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = \App\Models\CourseOther::where('is_online', '0')->where('uuid', $request->course)->first();

        if(!isset($course->id)) {
            return RestApi::error('Khursus tidak ditemukan.', 404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('KOPERASI');

        $spreadsheet->getDefaultStyle()->applyFromArray([
            'font' => [
                'name' => 'Candara'
            ]
        ]);

        $sheet->setCellValue('B2', "DATA PESERTA PELATIHAN OFFLINE");
        $sheet->getStyle('B2')->getFont()->setUnderline(true);
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24,
                'color' => ['rgb' => 'ffffff'],
            ],
        ]);
        $sheet->mergeCells('B2:K2');

        $sheet->setCellValue('B3', "NAMA PELATIHAN : ".strtoupper($course->title));
        $sheet->getStyle('B3')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B3:K3');

        $sheet->setCellValue('B4', "TANGGAL : ".(($course->date_start == $course->date_end) ? AppHelper::tgl_indo($course->date_start) : AppHelper::tgl_indo($course->date_start)." - ".AppHelper::tgl_indo($course->date_end)));

        $sheet->getStyle('B4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B4:K4');

        $sheet->setCellValue('B5', "WAKTU : ".($course->time_start." - ".$course->time_end));

        $sheet->getStyle('B5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B5:K5');

        $spreadsheet->getActiveSheet()->getStyle('B2:B5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3699ff');

        $spreadsheet->getActiveSheet()->freezePane('A8');

        // START INFORMASI PESERTA
        $cellPeserta = 7;
        $sheet->setCellValue('B'.$cellPeserta, 'NO');

        $sheet->setCellValue('C'.$cellPeserta, 'NO. KTP');

        $sheet->setCellValue('D'.$cellPeserta, 'NAMA PESERTA');
        
        $sheet->setCellValue('E'.$cellPeserta, 'JENIS');

        $sheet->setCellValue('F'.$cellPeserta, 'JABATAN');

        $sheet->setCellValue('G'.$cellPeserta, 'EMAIL');
        
        $sheet->setCellValue('H'.$cellPeserta, 'NO. TELP');

        $sheet->setCellValue('I'.$cellPeserta, 'ALAMAT');

        $sheet->setCellValue('J'.$cellPeserta, 'KAB/KOTA');

        $sheet->setCellValue('K'.$cellPeserta, 'PROVINSI');

        $styleHeaderTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('B'.$cellPeserta.':K'.$cellPeserta)->applyFromArray($styleHeaderTable);

        $sheet->getStyle('B7:K7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FCD5B4');

        if(Count($course->CourseSection) == 0) {
            return RestApi::error('Data tidak ditemukan.', 404);
        }

        $cellFirst = $cellPeserta + 1;
        foreach ($course->CourseSection as $key => $value) {
            $cellPeserta += 1;

            $sheet->setCellValue('B'.$cellPeserta, $key + 1);
            
            $sheet->setCellValue('C'.$cellPeserta, $value->user->nik);

            $sheet->setCellValue('D'.$cellPeserta, $value->user->name);
            
            $sheet->setCellValue('E'.$cellPeserta, $value->user->jenis);

            $sheet->setCellValue('F'.$cellPeserta, $value->user->jabatan);

            $sheet->setCellValue('G'.$cellPeserta, $value->user->email);
        
            $sheet->setCellValue('H'.$cellPeserta, $value->user->phone);

            $sheet->setCellValue('I'.$cellPeserta, $value->user->address);

            $sheet->setCellValue('J'.$cellPeserta, $value->user->City->nm_city);

            $sheet->setCellValue('K'.$cellPeserta, $value->user->province->nm_province);
        }

        foreach (range('B', 'K') as $col1) {
            $sheet->getColumnDimension($col1)->setAutoSize(true);
        }

        $styleTable = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('B'.$cellFirst.':K'.$cellPeserta)->applyFromArray($styleTable);
        // END INFORMASI PESERTA



        // SHEET UKM

        // $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'UKM');
        // $spreadsheet->addSheet($myWorkSheet, 0);

        // END SHEET UKM

        $writer = new Xlsx($spreadsheet);
        $filename = "SIJAWARA_PESERTA_PELATIHAN_OFFLINE_[".date('d-m-Y')."].xlsx";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $writer->save("php://output");
    }

    public function onlineCourseParticipant(Request $request)
    {
        $rules = [
            'course' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = \App\Models\CourseOther::where('is_online', '1')->where('uuid', $request->course)->first();

        if(!isset($course->id)) {
            return RestApi::error('Khursus tidak ditemukan.', 404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('KOPERASI');

        $spreadsheet->getDefaultStyle()->applyFromArray([
            'font' => [
                'name' => 'Candara'
            ]
        ]);

        $sheet->setCellValue('B2', "DATA PESERTA PELATIHAN ONLINE");
        $sheet->getStyle('B2')->getFont()->setUnderline(true);
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24,
                'color' => ['rgb' => 'ffffff'],
            ],
        ]);
        $sheet->mergeCells('B2:K2');

        $sheet->setCellValue('B3', "NAMA PELATIHAN : ".strtoupper($course->title));
        $sheet->getStyle('B3')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B3:K3');

        $sheet->setCellValue('B4', "TANGGAL : ".(($course->date_start == $course->date_end) ? AppHelper::tgl_indo($course->date_start) : AppHelper::tgl_indo($course->date_start)." - ".AppHelper::tgl_indo($course->date_end)));

        $sheet->getStyle('B4')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B4:K4');

        $sheet->setCellValue('B5', "WAKTU : ".($course->time_start." - ".$course->time_end));

        $sheet->getStyle('B5')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B5:K5');

        $spreadsheet->getActiveSheet()->getStyle('B2:B5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('76933C');

        $spreadsheet->getActiveSheet()->freezePane('A8');

        // START INFORMASI PESERTA
        $cellPeserta = 7;
        $sheet->setCellValue('B'.$cellPeserta, 'NO');

        $sheet->setCellValue('C'.$cellPeserta, 'NO. KTP');

        $sheet->setCellValue('D'.$cellPeserta, 'NAMA PESERTA');
        
        $sheet->setCellValue('E'.$cellPeserta, 'JENIS');

        $sheet->setCellValue('F'.$cellPeserta, 'JABATAN');

        $sheet->setCellValue('G'.$cellPeserta, 'EMAIL');
        
        $sheet->setCellValue('H'.$cellPeserta, 'NO. TELP');

        $sheet->setCellValue('I'.$cellPeserta, 'ALAMAT');

        $sheet->setCellValue('J'.$cellPeserta, 'KAB/KOTA');

        $sheet->setCellValue('K'.$cellPeserta, 'PROVINSI');

        $styleHeaderTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('B'.$cellPeserta.':K'.$cellPeserta)->applyFromArray($styleHeaderTable);

        $sheet->getStyle('B7:K7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FCD5B4');

        if(Count($course->CourseSection) == 0) {
            return RestApi::error('Data tidak ditemukan.', 404);
        }
        
        $cellFirst = $cellPeserta + 1;
        foreach ($course->CourseSection as $key => $value) {
            $cellPeserta += 1;
            $sheet->setCellValue('B'.$cellPeserta, $key + 1);

            $sheet->setCellValue('C'.$cellPeserta, $value->user->nik);

            $sheet->setCellValue('D'.$cellPeserta, $value->user->name);
            
            $sheet->setCellValue('E'.$cellPeserta, $value->user->jenis);

            $sheet->setCellValue('F'.$cellPeserta, $value->user->jabatan);

            $sheet->setCellValue('G'.$cellPeserta, $value->user->email);
        
            $sheet->setCellValue('H'.$cellPeserta, $value->user->phone);

            $sheet->setCellValue('I'.$cellPeserta, $value->user->address);

            $sheet->setCellValue('J'.$cellPeserta, $value->user->city->nm_city);

            $sheet->setCellValue('K'.$cellPeserta, $value->user->province->nm_province);
        }

        foreach (range('B', 'K') as $col1) {
            $sheet->getColumnDimension($col1)->setAutoSize(true);
        }

        $styleTable = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('B'.$cellFirst.':K'.$cellPeserta)->applyFromArray($styleTable);
        // END INFORMASI PESERTA



        // SHEET UKM

        // $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'UKM');
        // $spreadsheet->addSheet($myWorkSheet, 0);

        // END SHEET UKM

        $writer = new Xlsx($spreadsheet);
        $filename = "SIJAWARA_PESERTA_PELATIHAN_ONLINE_[".date('d-m-Y')."].xlsx";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $writer->save("php://output");
    }

    public function courseParticipant(Request $request)
    {
        $rules = [
            'course' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $course = \App\Models\Course::where('uuid', $request->course)->first();

        if(!isset($course->id)) {
            return RestApi::error('Khursus tidak ditemukan.', 404);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('KOPERASI');

        $spreadsheet->getDefaultStyle()->applyFromArray([
            'font' => [
                'name' => 'Candara'
            ]
        ]);

        $sheet->setCellValue('B2', "DATA PESERTA PELATIHAN");
        $sheet->getStyle('B2')->getFont()->setUnderline(true);
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24,
                'color' => ['rgb' => 'ffffff'],
            ],
        ]);
        $sheet->mergeCells('B2:K2');

        $sheet->setCellValue('B3', "NAMA PELATIHAN : ".strtoupper($course->nm_course));
        $sheet->getStyle('B3')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'ffffff'],
                'size' => 12
            ],
        ]);
        $sheet->mergeCells('B3:K3');

        $spreadsheet->getActiveSheet()->getStyle('B2:B3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('948A54');

        $spreadsheet->getActiveSheet()->freezePane('A8');

        // START INFORMASI PESERTA
        $cellPeserta = 7;
        $sheet->setCellValue('B'.$cellPeserta, 'NO');

        $sheet->setCellValue('C'.$cellPeserta, 'NO. KTP');

        $sheet->setCellValue('D'.$cellPeserta, 'NAMA PESERTA');
        
        $sheet->setCellValue('E'.$cellPeserta, 'JENIS');

        $sheet->setCellValue('F'.$cellPeserta, 'JABATAN');

        $sheet->setCellValue('G'.$cellPeserta, 'EMAIL');
        
        $sheet->setCellValue('H'.$cellPeserta, 'NO. TELP');

        $sheet->setCellValue('I'.$cellPeserta, 'ALAMAT');

        $sheet->setCellValue('J'.$cellPeserta, 'KAB/KOTA');

        $sheet->setCellValue('K'.$cellPeserta, 'PROVINSI');

        $styleHeaderTable = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ];

        $sheet->getStyle('B'.$cellPeserta.':K'.$cellPeserta)->applyFromArray($styleHeaderTable);


        $spreadsheet->getActiveSheet()->getStyle('B7:K7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FCD5B4');

        $courseSection = \App\Models\CourseSection::whereBetween('created_at', [
            date('Y-m-d', strtotime($request->start_date)),
            date('Y-m-d', strtotime($request->end_date)),
        ])
        ->where('course_id', $course->id)
        ->get();

        if(Count($courseSection) == 0) {
            return RestApi::error('Data tidak ditemukan.', 404);
        }

        $cellFirst = $cellPeserta + 1;
        foreach ($courseSection as $key => $value) {
            $cellPeserta += 1;
            $sheet->setCellValue('B'.$cellPeserta, $key + 1);

            $sheet->setCellValue('C'.$cellPeserta, $value->user->nik);

            $sheet->setCellValue('D'.$cellPeserta, $value->user->name);
            
            $sheet->setCellValue('E'.$cellPeserta, $value->user->jenis);

            $sheet->setCellValue('F'.$cellPeserta, $value->user->jabatan);

            $sheet->setCellValue('G'.$cellPeserta, $value->user->email);
        
            $sheet->setCellValue('H'.$cellPeserta, $value->user->phone);

            $sheet->setCellValue('I'.$cellPeserta, $value->user->address);

            $sheet->setCellValue('J'.$cellPeserta, $value->user->city->nm_city);

            $sheet->setCellValue('K'.$cellPeserta, $value->user->province->nm_province);
        }

        foreach (range('B', 'K') as $col1) {
            $sheet->getColumnDimension($col1)->setAutoSize(true);
        }

        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        $sheet->getStyle('B'.$cellFirst.':K'.$cellPeserta)->applyFromArray($styleArray);
        // END INFORMASI PESERTA



        // SHEET UKM

        // $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, 'UKM');
        // $spreadsheet->addSheet($myWorkSheet, 0);

        // END SHEET UKM

        $writer = new Xlsx($spreadsheet);
        $filename = "SIJAWARA_PESERTA_PELATIHAN_[".date('d-m-Y')."].xlsx";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $writer->save("php://output");
    }

    public function ukmExcel(Request $request)
    {
        $rules = [
            'year' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('UKM');

        $sheet->setCellValue('B2', 'DATA UKM ' . $request->year);
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24,
                'color' => ['rgb' => 'FF0000'],
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '00B050')
            )
        ]);
        $sheet->mergeCells('B2:H2');

        $sheet->setCellValue('B4', 'NO');
        $sheet->getStyle('B4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '00B050')
            )
        ]);
        $sheet->mergeCells('B4:B6');

        $sheet->setCellValue('C4', 'INFORMASI PELATIHAN');
        $sheet->getStyle('C4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFC000')
            )
        ]);
        $sheet->mergeCells('C4:E4');

        $sheet->setCellValue('F4', 'INFORMASI PESERTA');
        $sheet->getStyle('F4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '00B0F0')
            )
        ]);
        $sheet->mergeCells('F4:M4');

        $sheet->setCellValue('N4', 'INFORMASI UKM');
        $sheet->getStyle('N4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFFF00')
            )
        ]);
        $sheet->mergeCells('N4:AQ4');

        foreach (range('A', 'Z') as $col1) {
            foreach (range('A', 'Z') as $col2) {
                if (($col1 . $col2) == 'AR') {
                    break;
                }
                $sheet->getColumnDimension($col1 . $col2)->setAutoSize(true);
            }
            $sheet->getColumnDimension($col1)->setAutoSize(true);
        }

        // START HEADER INFORMASI PELATIHAN
        $sheet->setCellValue('C5', 'JUDUL PELATIHAN');
        $sheet->mergeCells('C5:C6');

        $sheet->setCellValue('D5', 'TANGGAL PELATIHAN');
        $sheet->mergeCells('D5:D6');

        $sheet->setCellValue('E5', 'TEMPAT PELATIHAN');
        $sheet->mergeCells('E5:E6');

        $sheet->getStyle('C5:E6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FCE4D6')
            )
        ]);
        // END HEADER INFORMASI PELATIHAN

        // START HEADER INFORMASI PESERTA
        $sheet->setCellValue('F5', 'NO. KTP');
        $sheet->mergeCells('F5:F6');

        $sheet->setCellValue('G5', 'NAMA PESERTA');
        $sheet->mergeCells('G5:G6');
        
        $sheet->setCellValue('H5', 'TTL');
        $sheet->mergeCells('H5:H6');

        $sheet->setCellValue('I5', 'ALAMAT');
        $sheet->mergeCells('I5:I6');

        $sheet->setCellValue('J5', 'JENIS KELAMIN');
        $sheet->mergeCells('J5:J6');

        $sheet->setCellValue('K5', 'JABATAN');
        $sheet->mergeCells('K5:K6');

        $sheet->setCellValue('L5', 'NO. TELP');
        $sheet->mergeCells('L5:L6');

        $sheet->setCellValue('M5', 'EMAIL');
        $sheet->mergeCells('M5:M6');

        $sheet->getStyle('F5:M6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'DDEBF7')
            )
        ]);
        // END HEADER INFORMASI PESERTA

        // START HEADER INFORMASI KOPERASI
        $sheet->getStyle('N5:AQ6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFF2CC')
            )
        ]);

        $sheet->setCellValue('N5', 'PEMILIK');
        $sheet->mergeCells('N5:T5');

        $sheet->setCellValue('N6', 'NO.KTP');
        $sheet->setCellValue('O6', 'NAMA');
        $sheet->setCellValue('P6', 'TTL');
        $sheet->setCellValue('Q6', 'ALAMAT');
        $sheet->setCellValue('R6', 'JENIS KELAMIN');
        $sheet->setCellValue('S6', 'PENDIDIKAN TERAKHIR');
        $sheet->setCellValue('T6', 'NO.TELP');

        $sheet->setCellValue('U5', 'NAMA UKM');
        $sheet->mergeCells('U5:U6');

        $sheet->setCellValue('V5', 'ALAMAT UKM');
        $sheet->mergeCells('V5:V6');

        $sheet->setCellValue('W5', 'KAB/KOTA');
        $sheet->mergeCells('W5:W6');

        $sheet->setCellValue('X5', 'PROVINSI');
        $sheet->mergeCells('X5:X6');

        $sheet->setCellValue('Y5', 'KEGIATAN USAHA YANG DILAKUKAN');
        $sheet->mergeCells('Y5:Y6');

        $sheet->setCellValue('Z5', 'PRODUK YANG DIHASILKAN');
        $sheet->mergeCells('Z5:Z6');

        $sheet->setCellValue('AA5', 'KATEGORI JENIS PRODUK');
        $sheet->mergeCells('AA5:AA6');

        $sheet->setCellValue('AB5', 'TAHUN MULAI USAHA');
        $sheet->mergeCells('AB5:AB6');

        $sheet->setCellValue('AC5', 'KAPASITAS PRODUKSI PERBULAN DINILAI DALAM RUPIAH');
        $sheet->mergeCells('AC5:AC6');

        $sheet->setCellValue('AD5', 'VOLUME USAHA PERBULAN (OMZET) DALAM RUPIAH');
        $sheet->mergeCells('AD5:AD6');

        $sheet->setCellValue('AE5', 'SUMBER BAHAN BAKU');
        $sheet->mergeCells('AE5:AE6');

        $sheet->setCellValue('AF5', 'JUMLAH TENAGA KERJA');
        $sheet->mergeCells('AF5:AG5');
        
        $sheet->setCellValue('AF6', 'PRIA');
        $sheet->setCellValue('AG6', 'WANITA');

        $sheet->setCellValue('AH5', 'BENTUK BADAN USAHA');
        $sheet->mergeCells('AH5:AH6');

        $sheet->setCellValue('AI5', 'LEGALITAS USAHA YANG DIMILIKI');
        $sheet->mergeCells('AI5:AI6');

        $sheet->setCellValue('AJ5', 'STANDARISASI PRODUK');
        $sheet->mergeCells('AJ5:AJ6');

        $sheet->setCellValue('AK5', 'NPWP');
        $sheet->mergeCells('AK5:AK6');

        $sheet->setCellValue('AL5', 'WILAYAH PEMASARAN');
        $sheet->mergeCells('AL5:AL6');

        $sheet->setCellValue('AM5', 'LOKASI PEMASARAN');
        $sheet->mergeCells('AM5:AM6');

        $sheet->setCellValue('AN5', 'FASILITAS KEFGIATAN YANG PERNAH DIIKUTI');
        $sheet->mergeCells('AN5:AN6');

        $sheet->setCellValue('AO5', 'NILAI REALISASI (KREDIT/PINJAMAN)');
        $sheet->mergeCells('AO5:AO6');

        $sheet->setCellValue('AP5', 'TAHUN REALISASI PINJAMAN');
        $sheet->mergeCells('AP5:AP6');

        $sheet->setCellValue('AQ5', 'PERMASALAHAN DALAM PENGEMBANGAN USAHA');
        $sheet->mergeCells('AQ5:AQ6');

        $sheet->getStyle('B4:AQ6')->applyFromArray([
            'font' => [
                'name' => 'Candara',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        $dataUkm = \App\Models\CourseSection::with('User', 'Course', 'CourseOther')
        ->whereHas('CourseOther', function ($q) use ($request){
            $q->whereYear('date_start', '=', $request->year);
        })->get();

        if (Count($dataUkm) == 0) {
            return RestApi::error('Data Ukm tidak ditemukan.', 404);
        }

        $cellTable = 7;
        foreach ($dataUkm as $key => $value) {
            // NO
            $sheet->setCellValue('B' . $cellTable, $key + 1);

            // DATA PELATIHAN
            $sheet->setCellValue('C' . $cellTable, $value->CourseOther->title);
            $sheet->setCellValue('D' . $cellTable, AppHelper::tgl_indo($value->CourseOther->date_start) . ' S/D ' . AppHelper::tgl_indo($value->CourseOther->date_end) );
            $sheet->setCellValue('E' . $cellTable, $value->CourseOther->place);

            // DATA PESERTA
            $sheet->setCellValue('F' . $cellTable, $value->User->nik);
            $sheet->setCellValue('G' . $cellTable, $value->User->name);
            $sheet->setCellValue('H' . $cellTable, $value->User->birth_place . ', ' . ((strlen($value->User->birth_date) == '10') ? AppHelper::tgl_indo($value->User->birth_date) : $value->User->birth_date));
            $sheet->setCellValue('I' . $cellTable, $value->User->address);
            $sheet->setCellValue('J' . $cellTable, $value->User->gender == 1 ? 'L' : 'P');
            $sheet->setCellValue('K' . $cellTable, $value->User->jabatan);
            $sheet->setCellValue('L' . $cellTable, $value->User->phone);
            $sheet->setCellValue('M' . $cellTable, $value->User->email);

            if (isset($value->User->Ukm)) {
                // DATA PEMILIK
                $sheet->setCellValue('N' . $cellTable, $value->User->Ukm->nik);
                $sheet->setCellValue('O' . $cellTable, $value->User->Ukm->nm_pemilik);
                $sheet->setCellValue('P' . $cellTable, $value->User->Ukm->tempat_lahir_pemilik . ', ' . $value->User->Ukm->tanggal_lahir_pemilik);
                $sheet->setCellValue('Q' . $cellTable, $value->User->Ukm->alamat_pemilik);
                $sheet->setCellValue('R' . $cellTable, $value->User->Ukm->jenis_kelamin);
                $sheet->setCellValue('S' . $cellTable, $value->User->Ukm->pendidikan_terakhir_pemilik);
                $sheet->setCellValue('T' . $cellTable, $value->User->Ukm->phone);

                // INFORMASI UKM
                $sheet->setCellValue('U' . $cellTable, $value->User->Ukm->nm_ukm);
                $sheet->setCellValue('V' . $cellTable, $value->User->Ukm->alamat_ukm);
                $sheet->setCellValue('W' . $cellTable, $value->User->Ukm->City->nm_city);
                $sheet->setCellValue('X' . $cellTable, $value->User->Ukm->Province->nm_province);
                $sheet->setCellValue('Y' . $cellTable, $value->User->Ukm->kegiatan_usaha);
                $sheet->setCellValue('Z' . $cellTable, $value->User->Ukm->produk_dihasilkan);
                $sheet->setCellValue('AA' . $cellTable, $value->User->Ukm->KategoriUkm->name);
                $sheet->setCellValue('AB' . $cellTable, $value->User->Ukm->tahun_mulai);

                $sheet->setCellValue('AC' . $cellTable, $value->User->Ukm->kapasitas_poduksi);//rp
                $sheet->getStyle('AC' . $cellTable)->getNumberFormat()->setFormatCode('Rp#,##0_-');

                $sheet->setCellValue('AD' . $cellTable, $value->User->Ukm->volume_usaha);//rp
                $sheet->getStyle('AD' . $cellTable)->getNumberFormat()->setFormatCode('Rp#,##0_-');

                $bahanBaku = '';
                foreach ($value->User->Ukm->BahanBaku as $key => $resss) {
                    $koma = count($value->User->Ukm->BahanBaku) == ($key + 1) ? '' : ', ';
                    $bahanBaku = $bahanBaku . $resss->BahanBaku->name . $koma;
                }
                $sheet->setCellValue('AE' . $cellTable, $bahanBaku);
                
                $sheet->setCellValue('AF'  . $cellTable, $value->User->Ukm->tenaga_pria);
                $sheet->setCellValue('AG'  . $cellTable, $value->User->Ukm->tenaga_wanita);

                $sheet->setCellValue('AH' . $cellTable, $value->User->Ukm->BadanUsaha->name);

                $legalitasUsaha = '';
                foreach ($value->User->Ukm->LegalitasUsaha as $key => $valueLegal) {
                    $koma = count($value->User->Ukm->LegalitasUsaha) == ($key + 1) ? '' : ', ';
                    $legalitasUsaha = $legalitasUsaha . $valueLegal->LegalitasUsaha->name . $koma;
                }
                $sheet->setCellValue('AI' . $cellTable, $legalitasUsaha);

                $standarisaiProduk = '';
                foreach ($value->User->Ukm->StandarisasiProduk as $key => $valueStandar) {
                    $koma = count($value->User->Ukm->StandarisasiProduk) == ($key + 1) ? '' : ', ';
                    $standarisaiProduk = $standarisaiProduk . $valueStandar->StandarisasiProduk->name . $koma;
                }
                $sheet->setCellValue('AJ' . $cellTable, $standarisaiProduk);

                $sheet->setCellValue('AK' . $cellTable, $value->User->Ukm->npwp);

                $wilayahPemasaran = '';
                foreach ($value->User->Ukm->WilayahPemasaran as $key => $valueWilayah) {
                    $koma = count($value->User->Ukm->WilayahPemasaran) == ($key + 1) ? '' : ', ';
                    $wilayahPemasaran = $wilayahPemasaran . $valueWilayah->WilayahPemasaran->name . $koma;
                }
                $sheet->setCellValue('AL' . $cellTable, $wilayahPemasaran);

                $sheet->setCellValue('AM' . $cellTable, $value->User->Ukm->lokasi_pemasaran);

                $faslitasKegiatan = '';
                foreach ($value->User->Ukm->FasKegPernah as $key => $valueFas) {
                    $koma = count($value->User->Ukm->FasKegPernah) == ($key + 1) ? '' : ', ';
                    $faslitasKegiatan = $faslitasKegiatan . $valueFas->FasKegPernah->name . $koma;
                }
                $sheet->setCellValue('AN' . $cellTable, $faslitasKegiatan);

                $sheet->setCellValue('AO' . $cellTable, $value->User->Ukm->nilai_realisasi);

                $sheet->setCellValue('AP' . $cellTable, $value->User->Ukm->tahun_realisasi);

                $masalahUkm = '';
                foreach ($value->User->Ukm->MasalahUkm as $key => $valueMasalah) {
                    $koma = ($key + 1) == count($value->User->Ukm->MasalahUkm) ? '' : ', ';
                    $masalahUkm = $masalahUkm . $valueMasalah->MasalahUkm->name . $koma;
                }
                $sheet->setCellValue('AQ' . $cellTable, $masalahUkm);
            }

            $cellTable++;
        }


        $styleGlobal = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('B4:AQ6')->applyFromArray($styleGlobal);


        $writer = new Xlsx($spreadsheet);
        $filename = "SIJAWARA_UKM_[".date('d-m-Y')."].xlsx";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $writer->save("php://output");
    }

    public function koperasiExcel(Request $request)
    {
        $rules = [
            'year' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('KOPERASI');

        $sheet->setCellValue('B2', 'DATA KOPERASI ' . $request->year);
        $sheet->getStyle('B2')->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 24,
                'color' => ['rgb' => 'FF0000'],
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '00B050')
            )
        ]);
        $sheet->mergeCells('B2:H2');

        $sheet->setCellValue('B4', 'NO');
        $sheet->getStyle('B4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '00B050')
            )
        ]);
        $sheet->mergeCells('B4:B6');

        $sheet->setCellValue('C4', 'INFORMASI PELATIHAN');
        $sheet->getStyle('C4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFC000')
            )
        ]);
        $sheet->mergeCells('C4:E4');

        $sheet->setCellValue('F4', 'INFORMASI PESERTA');
        $sheet->getStyle('F4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '00B0F0')
            )
        ]);
        $sheet->mergeCells('F4:M4');

        $sheet->setCellValue('N4', 'INFORMASI KOPERASI');
        $sheet->getStyle('N4')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFFF00')
            )
        ]);
        $sheet->mergeCells('N4:AW4');

        foreach (range('A', 'Z') as $col1) {
            foreach (range('A', 'Z') as $col2) {
                if (($col1 . $col2) == 'AX') {
                    break;
                }
                $sheet->getColumnDimension($col1 . $col2)->setAutoSize(true);
            }
            $sheet->getColumnDimension($col1)->setAutoSize(true);
        }

        // START HEADER INFORMASI PELATIHAN

        $sheet->setCellValue('C5', 'JUDUL PELATIHAN');
        $sheet->mergeCells('C5:C6');

        $sheet->setCellValue('D5', 'TANGGAL PELATIHAN');
        $sheet->mergeCells('D5:D6');

        $sheet->setCellValue('E5', 'TEMPAT PELATIHAN');
        $sheet->mergeCells('E5:E6');

        $sheet->getStyle('C5:E6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FCE4D6')
            )
        ]);
        // END HEADER INFORMASI PELATIHAN

        // START HEADER INFORMASI PESERTA
        $sheet->setCellValue('F5', 'NO. KTP');
        $sheet->mergeCells('F5:F6');

        $sheet->setCellValue('G5', 'NAMA PESERTA');
        $sheet->mergeCells('G5:G6');
        
        $sheet->setCellValue('H5', 'TTL');
        $sheet->mergeCells('H5:H6');

        $sheet->setCellValue('I5', 'ALAMAT');
        $sheet->mergeCells('I5:I6');

        $sheet->setCellValue('J5', 'JENIS KELAMIN');
        $sheet->mergeCells('J5:J6');

        $sheet->setCellValue('K5', 'JABATAN');
        $sheet->mergeCells('K5:K6');

        $sheet->setCellValue('L5', 'NO. TELP');
        $sheet->mergeCells('L5:L6');

        $sheet->setCellValue('M5', 'EMAIL');
        $sheet->mergeCells('M5:M6');

        $sheet->getStyle('F5:M6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'DDEBF7')
            )
        ]);
        // END HEADER INFORMASI PESERTA

        // START HEADER INFORMASI KOPERASI
        $sheet->getStyle('N5:AW6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFF2CC')
            )
        ]);

        $sheet->setCellValue('N5', 'NIK');
        $sheet->mergeCells('N5:N6');

        $sheet->setCellValue('O5', 'NAMA KOPERASI');
        $sheet->mergeCells('O5:O6');

        $sheet->setCellValue('P5', 'ALAMAT');
        $sheet->mergeCells('P5:P6');

        $sheet->setCellValue('Q5', 'KAB/KOTA');
        $sheet->mergeCells('Q5:Q6');

        $sheet->setCellValue('R5', 'PROVINSI');
        $sheet->mergeCells('R5:R6');

        $sheet->setCellValue('S5', 'NO.TELP');
        $sheet->mergeCells('S5:S6');

        $sheet->setCellValue('T5', 'BADAN HUKUM');
        $sheet->mergeCells('T5:U5');

        $sheet->setCellValue('T6', 'NOMOR');
        $sheet->setCellValue('U6', 'TANGGAL');
        $sheet->getStyle('T6:U6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'BF8F00')
            )
        ]);

        $sheet->setCellValue('V5', 'PAD');
        $sheet->mergeCells('V5:W5');

        $sheet->setCellValue('V6', 'NOMOR');
        $sheet->setCellValue('W6', 'TANGGAL');
        $sheet->getStyle('V6:W6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'F4B084')
            )
        ]);

        $sheet->setCellValue('X5', 'STATUS KOPERASI');
        $sheet->mergeCells('X5:X6');

        $sheet->setCellValue('Y5', 'JUMLAH KANTOR CABANG');
        $sheet->mergeCells('Y5:Y6');

        $sheet->setCellValue('Z5', 'TGL. RAT');
        $sheet->mergeCells('Z5:Z6');

        $sheet->setCellValue('AA5', 'PENGURUS');
        $sheet->mergeCells('AA5:AF5');

        $sheet->setCellValue('AA6', 'KETUA');
        $sheet->setCellValue('AB6', 'NO.TELP');
        $sheet->getStyle('AA6:AB6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFD966')
            )
        ]);

        $sheet->setCellValue('AC6', 'SEKRETARIS');
        $sheet->setCellValue('AD6', 'NO.TELP');
        $sheet->getStyle('AC6:AD6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '9BC2E6')
            )
        ]);

        $sheet->setCellValue('AE6', 'BENDAHARA');
        $sheet->setCellValue('AF6', 'NO.TELP');
        $sheet->getStyle('AE6:AF6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'C6E0B4')
            )
        ]);

        $sheet->setCellValue('AG5', 'ANGGOTA KOPERASI');
        $sheet->mergeCells('AG5:AH5');
        $sheet->setCellValue('AG6', 'PRIA');
        $sheet->setCellValue('AH6', 'WANITA');
        $sheet->getStyle('AG6:AH6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FFCCFF')
            )
        ]);

        $sheet->setCellValue('AI5', 'MANAJER');
        $sheet->mergeCells('AI5:AJ5');
        $sheet->setCellValue('AI6', 'PRIA');
        $sheet->setCellValue('AJ6', 'WANITA');
        $sheet->getStyle('AI6:AJ6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '99FFCC')
            )
        ]);

        $sheet->setCellValue('AK5', 'KARYAWAN');
        $sheet->mergeCells('AK5:AL5');
        $sheet->setCellValue('AK6', 'PRIA');
        $sheet->setCellValue('AL6', 'WALITA');
        $sheet->getStyle('AK6:AL6')->applyFromArray([
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'CCFF99')
            )
        ]);

        $sheet->setCellValue('AM5', 'BENTUK KOPERASI');
        $sheet->mergeCells('AM5:AM6');

        $sheet->setCellValue('AN5', 'JENIS KOPERASI');
        $sheet->mergeCells('AN5:AN6');

        $sheet->setCellValue('AO5', 'KELOMPOK KOPERASI');
        $sheet->mergeCells('AO5:AO6');

        $sheet->setCellValue('AP5', 'SEKTOR USAHA');
        $sheet->mergeCells('AP5:AP6');

        $sheet->setCellValue('AQ5', 'VOLUME USAHA PERBULAN (OMZET) DALAM RUPIAH');
        $sheet->mergeCells('AQ5:AQ6');

        $sheet->setCellValue('AR5', 'ASSET');
        $sheet->mergeCells('AR5:AR6');

        $sheet->setCellValue('AS5', 'UNIT USAHA PENYUMBANG (OMZET) TERBESAR');
        $sheet->mergeCells('AS5:AS6');

        $sheet->setCellValue('AT5', 'MODAL SENDIRI');
        $sheet->mergeCells('AT5:AT6');

        $sheet->setCellValue('AU5', 'MODAL LUAR');
        $sheet->mergeCells('AU5:AU6');

        $sheet->setCellValue('AV5', 'SISA HASIL USAHA');
        $sheet->mergeCells('AV5:AV6');

        $sheet->setCellValue('AW5', 'PERMASALAHAN DALAM PENGEMBANGAN KOPERASI');
        $sheet->mergeCells('AW5:AW6');

        $sheet->getStyle('B4:AW6')->applyFromArray([
            'font' => [
                'name' => 'Candara',
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $spreadsheet->getActiveSheet()->freezePane('A7');

        $dataKoperasi = \App\Models\CourseSection::with('User', 'Course', 'CourseOther')
        ->whereHas('CourseOther', function ($q) use ($request){
            $q->whereYear('date_start', '=', $request->year);
        })->get();

        if (Count($dataKoperasi) == 0) {
            return RestApi::error('Data Koperasi tidak ditemukan.', 404);
        }

        $cellTable = 7;
        foreach ($dataKoperasi as $key => $value) {
            // NO
            $sheet->setCellValue('B' . $cellTable, $key + 1);

            // DATA PELATIHAN
            $sheet->setCellValue('C' . $cellTable, $value->CourseOther->title);
            $sheet->setCellValue('D' . $cellTable, AppHelper::tgl_indo($value->CourseOther->date_start) . ' S/D ' . AppHelper::tgl_indo($value->CourseOther->date_end) );
            $sheet->setCellValue('E' . $cellTable, $value->CourseOther->place);

            // DATA PESERTA
            $sheet->setCellValue('F' . $cellTable, $value->User->nik);
            $sheet->setCellValue('G' . $cellTable, $value->User->name);
            $sheet->setCellValue('H' . $cellTable, $value->User->birth_place . ', ' . AppHelper::tgl_indo($value->User->birth_date));
            $sheet->setCellValue('I' . $cellTable, $value->User->address);
            $sheet->setCellValue('J' . $cellTable, $value->User->gender == 1 ? 'L' : 'P');
            $sheet->setCellValue('K' . $cellTable, $value->User->jabatan);
            $sheet->setCellValue('L' . $cellTable, $value->User->phone);
            $sheet->setCellValue('M' . $cellTable, $value->User->email);

            if (isset($value->User->Koperasi)) {
                // DATA KOPERASI
                $sheet->setCellValue('N' . $cellTable, $value->User->Koperasi->nik);
                $sheet->setCellValue('N' . $cellTable, $value->User->Koperasi->nm_koperasi);
                $sheet->setCellValue('P' . $cellTable, $value->User->Koperasi->alamat_koperasi);
                $sheet->setCellValue('Q' . $cellTable, $value->User->Koperasi->City->nm_city);
                $sheet->setCellValue('R' . $cellTable, $value->User->Koperasi->Province->nm_province);
                $sheet->setCellValue('S' . $cellTable, $value->User->Koperasi->phone);

                // BADAN HUKUM
                $sheet->setCellValue('T' . $cellTable, $value->User->Koperasi->no_badan_hukum);
                $sheet->setCellValue('U' . $cellTable, AppHelper::tgl_indo($value->User->Koperasi->tgl_badan_hukum));

                // PAD
                $sheet->setCellValue('V' . $cellTable, $value->User->Koperasi->no_pad);
                $sheet->setCellValue('W' . $cellTable, AppHelper::tgl_indo($value->User->koperasi->tgl_pad));

                $sheet->setCellValue('X' . $cellTable, $value->User->Koperasi->status == 1 ? 'AKTIF' : 'TIDAK AKTIF');
                $sheet->setCellValue('Y' . $cellTable, $value->User->Koperasi->cabang);
                $sheet->setCellValue('Z' . $cellTable, AppHelper::tgl_indo($value->User->Koperasi->tgl_rat));

                // PENGURUS
                $sheet->setCellValue('AA' . $cellTable, $value->User->Koperasi->nm_ketua);
                $sheet->setCellValue('AB' . $cellTable, $value->User->Koperasi->phone_ketua);
                $sheet->setCellValue('AC' . $cellTable, $value->User->Koperasi->nm_sekretaris);
                $sheet->setCellValue('AD' . $cellTable, $value->User->Koperasi->phone_sekretaris);
                $sheet->setCellValue('AE' . $cellTable, $value->User->Koperasi->nm_bendahara);
                $sheet->setCellValue('AF' . $cellTable, $value->User->Koperasi->phone_bendahara);

                // ANGGOTA KOPERASI
                $sheet->setCellValue('AG' . $cellTable, $value->User->Koperasi->anggota_pria);
                $sheet->setCellValue('AH' . $cellTable, $value->User->Koperasi->anggota_wanita);

                // MANAJER KOPERASI
                $sheet->setCellValue('AI' . $cellTable, $value->User->Koperasi->manager_pria);
                $sheet->setCellValue('AJ' . $cellTable, $value->User->Koperasi->manager_wanita);

                // KARYAWAN KOPERASI
                $sheet->setCellValue('AK' . $cellTable, $value->User->Koperasi->karyawan_pria);
                $sheet->setCellValue('AL' . $cellTable, $value->User->Koperasi->karyawan_wanita);

                $sheet->setCellValue('AM' . $cellTable, $value->User->Koperasi->BentukKoperasi->name);
                $sheet->setCellValue('AN' . $cellTable, $value->User->Koperasi->JenisKoperasi->name);
                $sheet->setCellValue('AO' . $cellTable, $value->User->Koperasi->KelompokKoperasi->name);
                $sheet->setCellValue('AP' . $cellTable, $value->User->Koperasi->SektorUsaha->name);

                $rupiahFormat = 'Rp#,##0_-';
                $sheet->setCellValue('AQ' . $cellTable, $value->User->Koperasi->volume_usaha); //rp
                $sheet->getStyle('AQ' . $cellTable)->getNumberFormat()->setFormatCode($rupiahFormat);
                
                $sheet->setCellValue('AR' . $cellTable, $value->User->Koperasi->asset); //rp
                $sheet->getStyle('AR' . $cellTable)->getNumberFormat()->setFormatCode($rupiahFormat);

                $sheet->setCellValue('AS' . $cellTable, $value->User->Koperasi->UnitUsaha->name);
                $sheet->setCellValue('AT' . $cellTable, $value->User->Koperasi->modal_sendiri); //rp
                $sheet->getStyle('AT' . $cellTable)->getNumberFormat()->setFormatCode($rupiahFormat);

                $sheet->setCellValue('AU' . $cellTable, $value->User->Koperasi->modal_luar);
                $sheet->getStyle('AU' . $cellTable)->getNumberFormat()->setFormatCode($rupiahFormat);
                
                $sheet->setCellValue('AV' . $cellTable, $value->User->Koperasi->sisa_hasil_usaha); //rp
                $sheet->getStyle('AV' . $cellTable)->getNumberFormat()->setFormatCode($rupiahFormat);

                $masalahKop = '';
                foreach ($value->User->Koperasi->MasalahKoperasi as $key => $valueMasalah) {
                    $koma = ($key + 1) == count($value->User->Koperasi->MasalahKoperasi) ? '' : ', ';
                    $masalahKop = $masalahKop . $valueMasalah->MasalahKoperasi->name . $koma;
                }
                $sheet->setCellValue('AW' . $cellTable, $masalahKop);   
            }

            $cellTable++;
        }

        $styleGlobal = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $sheet->getStyle('B4:AY6')->applyFromArray($styleGlobal);


        $writer = new Xlsx($spreadsheet);
        $filename = "SIJAWARA_KOPERASI_[".date('d-m-Y')."].xlsx";

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$filename.'"');
        $writer->save("php://output");
    }
}
