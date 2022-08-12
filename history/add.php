<?php
include '../connection.php';

$user_id = $_POST['user_id'];
$type = $_POST['type'];
$date = date('Y-m-d', strtotime($_POST['date']));
$total = $_POST['total'];
$details = $_POST['details'];

$dt = new DateTime();
$dt->setTimezone(new DateTimeZone('Asia/Jakarta'));

$created_at = $dt->format('Y-m-d H:i:s');
$updated_at = $dt->format('Y-m-d H:i:s');

$sql_check = "SELECT * FROM histories WHERE user_id = '$user_id' AND date = '$date' AND type = '$type'";

$result_check = $connect->query($sql_check);

if ($result_check->num_rows > 0) {
    header('Content-type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Data is already exist for this date!'
    ], JSON_PRETTY_PRINT);
} else {
    $sql = "INSERT INTO histories SET user_id = '$user_id', type = '$type', date = '$date', total = '$total', details = '$details', created_at = '$created_at', updated_at = '$updated_at'";
    $result = $connect->query($sql);

    if ($result) {
        header('Content-type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Data created successfully.'
        ], JSON_PRETTY_PRINT);
    } else {
        header('Content-type: application/json');
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Something went wrong.'
        ], JSON_PRETTY_PRINT);
    }
}
