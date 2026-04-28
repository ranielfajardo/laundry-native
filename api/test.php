<?php

header("Content-Type: application/json");

echo json_encode([
    "status" => "success",
    "message" => "Laundry API is working"
]);