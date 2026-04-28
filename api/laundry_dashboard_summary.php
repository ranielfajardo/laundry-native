<?php

require_once "db.php";

function countStatus($conn, $status) {
    $query = "SELECT COUNT(*) AS total FROM tb_transaksi WHERE status = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $status);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    return (int)$row["total"];
}

$new = countStatus($conn, "baru");
$in_process = countStatus($conn, "proses");
$completed = countStatus($conn, "selesai");
$picked_up = countStatus($conn, "diambil");

echo json_encode([
    "status" => "success",
    "data" => [
        "new" => $new,
        "in_process" => $in_process,
        "completed" => $completed,
        "picked_up" => $picked_up
    ]
]);