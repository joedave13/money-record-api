<?php
include '../connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM histories WHERE id = '$id'";
$result = $connect->query($sql);

if ($result) {
    header('Content-Type: application/json');
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Data deleted successfully.'
    ], JSON_PRETTY_PRINT);
} else {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Something went wrong'
    ], JSON_PRETTY_PRINT);
}
