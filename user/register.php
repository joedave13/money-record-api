<?php
include '../connection.php';

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$dt = new DateTime();
$dt->setTimezone(new DateTimeZone('Asia/Jakarta'));

$created_at = $dt->format('Y-m-d H:i:s');
$updated_at = $dt->format('Y-m-d H:i:s');

// Check email is exists or not
$sql_check = "SELECT * FROM users WHERE email = '$email'";
$result_check = $connect->query($sql_check);

if ($result_check->num_rows > 0) {
    header('Content-type: application/json');
    echo json_encode([
        'success' => false,
        'message' => 'Email is already exist!'
    ], JSON_PRETTY_PRINT);
} else {
    $register_sql = "INSERT INTO users SET name = '$name', email = '$email', password = '$password', created_at = '$created_at', updated_at = '$updated_at'";
    $register = $connect->query($register_sql);

    if ($register) {
        header('Content-type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Register success.'
        ], JSON_PRETTY_PRINT);
    } else {
        header('Content-type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Something went wrong.'
        ], JSON_PRETTY_PRINT);
    }
}
