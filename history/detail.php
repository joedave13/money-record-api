<?php
include '../connection.php';

$user_id = $_POST['user_id'];
$date = date('Y-m-d', strtotime($_POST['date']));
$type = $_POST['type'];

$sql = "SELECT * FROM histories WHERE user_id = '$user_id' AND date = '$date' AND type = '$type'";

$result = $connect->query($sql);

if ($result->num_rows > 0) {
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data = $row;
    }

    header('Content-type: application/json');
    echo json_encode([
        'success' => true,
        'message' => 'Data successfully retrieved.',
        'data' => $data
    ], JSON_PRETTY_PRINT);
} else {
    header('Content-type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Data not found!'
    ], JSON_PRETTY_PRINT);
}
