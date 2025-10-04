<?php
require_once __DIR__ . '/../config/database.php';

$pdo = getPDOInstance();

if (isset($_GET['month'])) {
    $selectedMonth = $_GET['month'];
    $selectedStatus = isset($_GET['status']) ? $_GET['status'] : '';

    // Query untuk mendapatkan data pengajuan
    $query = "
    SELECT p.*, d.nm_divisi, s.nm_sparepart 
    FROM pengajuan p
    JOIN divisi d ON p.id_divisi = d.id_divisi
    JOIN sparepart s ON p.nm_barang = s.id_sparepart
    WHERE DATE_FORMAT(p.tgl_pengajuan, '%Y-%m') = :selectedMonth
    ";

    if (!empty($selectedStatus)) {
        $query .= " AND p.status = :selectedStatus";
    }

    $query .= " ORDER BY p.tgl_pengajuan DESC";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':selectedMonth', $selectedMonth);
    if (!empty($selectedStatus)) {
        $stmt->bindParam(':selectedStatus', $selectedStatus);
    }
    $stmt->execute();
    $riwayat = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Nama bulan untuk judul
    $bulanTahun = date('F Y', strtotime($selectedMonth . '-01'));
    $namaFile = !empty($selectedStatus) ? 
        'Rekap_Pengajuan_' . $selectedMonth . '_' . $selectedStatus . '.xlsx' : 
        'Rekap_Pengajuan_' . $selectedMonth . '.xlsx';

    // Header untuk Excel
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $namaFile . '"');
    header('Cache-Control: max-age=0');

    // Gunakan PHPExcel atau PhpSpreadsheet
    require __DIR__ . '/../vendor/autoload.php';

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Set judul
    $judulStatus = !empty($selectedStatus) ? ' (Status: ' . $selectedStatus . ')' : '';
    $sheet->setCellValue('A1', 'Rekap Pengajuan Sparepart' . $judulStatus);
    $sheet->setCellValue('A2', 'Bulan: ' . $bulanTahun);
    $sheet->mergeCells('A1:H1');
    $sheet->mergeCells('A2:H2');
    $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);

    // Header Tabel
    $headers = [
        'No',
        'Departemen',
        'Nama Barang',
        'Jumlah',
        'Tanggal Pengajuan',
        'Status',
        'Nama Pengaju',
        'Keterangan'
    ];

    // Tulis header
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '4', $header);
        $col++;
    }

    // Style header
    $sheet->getStyle('A4:H4')->applyFromArray([
        'font' => ['bold' => true],
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => 'FFD9D9D9']
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            ]
        ]
    ]);

    // Tulis data
    $row = 5;
    foreach ($riwayat as $index => $item) {
        $sheet->setCellValue('A' . $row, $index + 1);
        $sheet->setCellValue('B' . $row, $item['nm_divisi']);
        $sheet->setCellValue('C' . $row, $item['nm_sparepart']);
        $sheet->setCellValue('D' . $row, $item['jumlah']);
        $sheet->setCellValue('E' . $row, date("d-m-Y H:i:s", strtotime($item['tgl_pengajuan'])));
        $sheet->setCellValue('F' . $row, $item['status']);
        $sheet->setCellValue('G' . $row, $item['nm_pengaju']);
        $sheet->setCellValue('H' . $row, $item['keterangan']);
        $row++;
    }

    // Style data
    $sheet->getStyle('A5:H' . ($row - 1))->applyFromArray([
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
            ]
        ]
    ]);

    // Auto width kolom
    foreach (range('A', 'H') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Simpan Excel
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');
    exit;
} else {
    echo "Bulan tidak valid";
    exit();
}