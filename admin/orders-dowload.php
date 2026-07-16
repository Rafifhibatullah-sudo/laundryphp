<?php 
session_start();
// membatasi halaman login
if (!isset($_SESSION['login'])) {
    echo "
    <script>
    alert('login sebelum masuk ya');
    document.location.href = 'login.php';
    
    </script>";
    exit;
}

require_once 'config/function.php';
require_once 'config/database.php';
require_once 'vendor/autoload.php'; 

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

 $data = $_POST;

    $start_date = strip_tags($data['start_date'] . ' 00:00:00');
    $end_date = strip_tags($data['end_date']. ' 23:59:58');

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheet.sheet');
    header('Content-Disposition: attachment;filename="Laporan_Data_Order.xlsx"');
    header('Cache-Control: max-age=0');

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // set header kolom (disesuaikan denngan data orderlaundry )
    $sheet->setCellValue('A1', 'No');
    $sheet->setCellValue('B1', 'Produk');
    $sheet->setCellValue('C1', 'Metode Pembayaran');
    $sheet->setCellValue('D1', 'Status bayar');
    $sheet->setCellValue('E1', 'qty');
    $sheet->setCellValue('F1', 'Total');
    $sheet->setCellValue('G1', 'Tanggal');

    //ambil dari database
    $orders = select("SELECT * FROM orders JOIN products ON orders.product_id = products.id_products WHERE orders.created_at BETWEEN '$start_date' AND '$end_date'");

    // looping data untuk dimasukan ke excel
    $rowNum = 2; //data mulai dari baris ke dua
    $no = 1;
    foreach ($orders as $order) {
        $sheet ->setCellValue('A' . $rowNum, $no++);
        $sheet ->setCellValue('B' . $rowNum, $order['title']);
        $sheet ->setCellValue('C' . $rowNum, $order['payment_method']);
        $sheet ->setCellValue('D' . $rowNum, $order['is_pay']);
        $sheet ->setCellValue('E' . $rowNum, $order['qty']);
        $sheet ->setCellValue('F' . $rowNum, $order['total']);
        $sheet ->setCellValue('G' . $rowNum, $order['created_at']);
        $rowNum++;
    }


    // 2. LANGSUNG STREAM KE BROWSER (Tanpa simpan file di server dulu)
    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit;



   

