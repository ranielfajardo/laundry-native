<?php

require_once "db.php";

$input = json_decode(file_get_contents("php://input"), true);

if (!$input) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid JSON input"
    ]);
    exit;
}

$id_outlet = $input["id_outlet"] ?? 1;
$kode_invoice = $input["kode_invoice"] ?? ("INV-" . date("YmdHis"));
$id_member = $input["id_member"] ?? 1;
$tgl = $input["tgl"] ?? date("Y-m-d");
$batas_waktu = $input["batas_waktu"] ?? date("Y-m-d", strtotime("+3 days"));
$tgl_bayar = $input["tgl_bayar"] ?? null;
$biaya_tambahan = $input["biaya_tambahan"] ?? 0;
$diskon = $input["diskon"] ?? 0;
$pajak = $input["pajak"] ?? 0;
$status = $input["status"] ?? "baru";
$dibayar = $input["dibayar"] ?? "belum dibayar";
$id_user = $input["id_user"] ?? 1;

$allowed_status = ["baru", "proses", "selesai", "diambil"];
$allowed_dibayar = ["dibayar", "belum dibayar"];

if (!in_array($status, $allowed_status)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid status. Allowed: baru, proses, selesai, diambil"
    ]);
    exit;
}

if (!in_array($dibayar, $allowed_dibayar)) {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Invalid dibayar. Allowed: dibayar, belum dibayar"
    ]);
    exit;
}

$query = "INSERT INTO tb_transaksi 
    (id_outlet, kode_invoice, id_member, tgl, batas_waktu, tgl_bayar, biaya_tambahan, diskon, pajak, status, dibayar, id_user)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "isisssiiissi",
    $id_outlet,
    $kode_invoice,
    $id_member,
    $tgl,
    $batas_waktu,
    $tgl_bayar,
    $biaya_tambahan,
    $diskon,
    $pajak,
    $status,
    $dibayar,
    $id_user
);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Laundry transaction added successfully",
        "inserted_id" => mysqli_insert_id($conn)
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => mysqli_stmt_error($stmt)
    ]);
}