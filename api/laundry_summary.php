<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$host = "mysql";
$user = "root";
$pass = "root";
$db   = "laundry";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit;
}

function countStatus($conn, $status) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM tb_transaksi WHERE status = ?");
    $stmt->bind_param("s", $status);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return (int)$row["total"];
}

$response = [
    "success" => true,
    "new" => countStatus($conn, "baru"),
    "in_process" => countStatus($conn, "proses"),
    "completed" => countStatus($conn, "selesai"),
    "picked_up" => countStatus($conn, "diambil")
];

echo json_encode($response);
$conn->close();
?>