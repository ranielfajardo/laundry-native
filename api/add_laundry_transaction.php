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

$customer_name = $input["customer_name"] ?? "";
$total_price = $input["total_price"] ?? 0;
$status = $input["status"] ?? "pending";

if ($customer_name == "") {
    http_response_code(400);
    echo json_encode([
        "status" => "error",
        "message" => "Customer name is required"
    ]);
    exit;
}

/*
  IMPORTANT:
  Change the table name and column names based on your actual laundry.sql.
  This is only a sample structure.
*/

$query = "INSERT INTO tb_transaksi (customer_name, total_price, status) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $query);

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => mysqli_error($conn)
    ]);
    exit;
}

mysqli_stmt_bind_param($stmt, "sds", $customer_name, $total_price, $status);

if (mysqli_stmt_execute($stmt)) {
    echo json_encode([
        "status" => "success",
        "message" => "Transaction added successfully"
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => mysqli_stmt_error($stmt)
    ]);
}