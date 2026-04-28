<?php

header("Content-Type: application/json");

$host = "mysql";
$user = "root";
$pass = "root";
$db = "laundry";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . mysqli_connect_error()
    ]);
    exit;
}