<?php
// Include the FPDF file
require '../config/functions.php';
include "../fpdf/fpdf.php";

// Create a new object named pdf from the FPDF class
// and set the paper: L = landscape, A3 = paper size
$pdf = new FPDF('L', 'mm', 'A3');

// Create a new page
$pdf->AddPage();

// Set the font: Times, bold, size 25
$pdf->SetFont('Times', 'B', 25);

// Title
$pdf->Cell(410, 25, 'LAUNDRY TRANSACTION REPORT', 0, 1, 'C');


// Add vertical space
$pdf->Cell(20, 7, '', 0, 1);

$pdf->SetFont('Times', 'B', 10);
$pdf->Cell(10, 7, 'NO', 1, 0, 'C');
$pdf->Cell(25, 7, 'OUTLET', 1, 0, 'C');
$pdf->Cell(32, 7, 'INVOICE CODE', 1, 0, 'C');
$pdf->Cell(25, 7, 'MEMBER', 1, 0, 'C');
$pdf->Cell(45, 7, 'TRANSACTION DATE', 1, 0, 'C');
$pdf->Cell(32, 7, 'DEADLINE', 1, 0, 'C');
$pdf->Cell(38, 7, 'PAYMENT DATE', 1, 0, 'C');
$pdf->Cell(40, 7, 'ADDITIONAL FEE', 1, 0, 'C');
$pdf->Cell(25, 7, 'DISCOUNT', 1, 0, 'C');
$pdf->Cell(25, 7, 'TAX', 1, 0, 'C');
$pdf->Cell(25, 7, 'STATUS', 1, 0, 'C');
$pdf->Cell(45, 7, 'PAYMENT STATUS', 1, 0, 'C');
$pdf->Cell(25, 7, 'STAFF', 1, 1, 'C');

$pdf->SetFont('Times', '', 10);

$no = 1;
$transaksi = query("SELECT tb_transaksi.*, tb_outlet.id AS outlet_id, tb_outlet.nama AS outlet_nama, tb_member.id AS member_id, tb_member.nama AS member_nama, tb_user.id AS user_id, tb_user.nama AS user_nama FROM tb_transaksi, tb_outlet, tb_member, tb_user WHERE tb_transaksi.id_outlet = tb_outlet.id AND tb_transaksi.id_member = tb_member.id AND tb_transaksi.id_user = tb_user.id");

foreach ($transaksi as $t) {
    $status = $t['status'];
    if ($status == 'baru') {
        $status = 'New';
    } elseif ($status == 'proses') {
        $status = 'In Process';
    } elseif ($status == 'selesai') {
        $status = 'Completed';
    } elseif ($status == 'diambil') {
        $status = 'Picked Up';
    }

    $paymentStatus = $t['dibayar'];
    if ($paymentStatus == 'dibayar') {
        $paymentStatus = 'Paid';
    } elseif ($paymentStatus == 'belum dibayar') {
        $paymentStatus = 'Unpaid';
    }

    $pdf->Cell(10, 7, $no++, 1, 0, 'C');
    $pdf->Cell(25, 7, $t['outlet_nama'], 1, 0, 'C');
    $pdf->Cell(32, 7, $t['kode_invoice'], 1, 0, 'C');
    $pdf->Cell(25, 7, $t['member_nama'], 1, 0, 'C');
    $pdf->Cell(45, 7, date('d F Y', strtotime($t['tgl'])), 1, 0, 'C');
    $pdf->Cell(32, 7, date('d F Y', strtotime($t['batas_waktu'])), 1, 0, 'C');
    $pdf->Cell(38, 7, date('d F Y', strtotime($t['tgl_bayar'])), 1, 0, 'C');
    $pdf->Cell(40, 7, "Rp. " . number_format($t['biaya_tambahan'], 2, ",", "."), 1, 0, 'C');
    $pdf->Cell(25, 7, $t['diskon'] . '%', 1, 0, 'C');
    $pdf->Cell(25, 7, "Rp. " . number_format($t['pajak'], 2, ",", "."), 1, 0, 'C');
    $pdf->Cell(25, 7, $status, 1, 0, 'C');
    $pdf->Cell(45, 7, $paymentStatus, 1, 0, 'C');
    $pdf->Cell(25, 7, $t['user_nama'], 1, 1, 'C');
}

$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Times', '', 15);
$pdf->Cell(390, 7, 'Medan, ' . date('d F Y') . '', 0, 1, 'R');
$pdf->Cell(403, 7, 'Approved By              ', 0, 1, 'R');
$pdf->Cell(10, 20, '', 0, 1);
$pdf->Cell(404, 7, '____________________        ', 0, 1, 'R');

$pdf->Output('laundry transaction report.pdf', 'I');
?>