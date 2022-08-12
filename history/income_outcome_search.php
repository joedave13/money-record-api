<?php
include '../connection.php';

$user_id = $_POST['user_id'];
$type = $_POST['type'];
$date = date('Y-m-d', strtotime($_POST['date']));

$sql = "SELECT id, date, total, type FROM histories WHERE user_id = '$user_id' AND type = '$type' AND date = '$date' ORDER BY date DESC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Data retrieved successfully.',
        'data' => $data
    ], JSON_PRETTY_PRINT);
} else {
    header('Content-Type: application/json');
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Data not found.',
    ], JSON_PRETTY_PRINT);
}
