<?php
include '../connection.php';

$user_id = $_POST['user_id'];
$type = $_POST['type'];

$sql = "SELECT id, date, total, type FROM histories WHERE user_id = '$user_id' AND type = '$type' ORDER BY date DESC";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = [
            'id' => intval($row['id']),
            'date' => $row['date'],
            'total' => $row['total'],
            'type' => $row['type'],
            'created_at' => $row['created_at'],
            'updated_at' => $row['updated_at']
        ];
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
