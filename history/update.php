<?php
include '../connection.php';

$id = $_POST['id'];
$user_id = $_POST['user_id'];
$type = $_POST['type'];
$date = date('Y-m-d', strtotime($_POST['date']));
$total = $_POST['total'];
$details = $_POST['details'];

$dt = new DateTime();
$dt->setTimezone(new DateTimeZone('Asia/Jakarta'));

$updated_at = $dt->format('Y-m-d H:i:s');

$sql_check = "SELECT * FROM histories WHERE user_id = '$user_id' AND date = '$date' AND type = '$type'";
$result_check = $connect->query($sql_check);

if ($result_check->num_rows > 1) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'This date contain multiple data!'
    ], JSON_PRETTY_PRINT);
} else {
    $sql = "UPDATE histories SET user_id = '$user_id', type = '$type', date = '$date', total = '$total', details = '$details', updated_at = '$updated_at' WHERE id = '$id'";
    $result = $connect->query($sql);

    if ($result) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Data updated successfully.'
        ], JSON_PRETTY_PRINT);
    } else {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Something went wrong.'
        ], JSON_PRETTY_PRINT);
    }
}
