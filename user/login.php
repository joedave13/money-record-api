<?php
include '../connection.php';

$email = $_POST['email'];
$password = $_POST['password'];

$email_check = "SELECT * FROM users WHERE email = '$email'";

$email_result = $connect->query($email_check);

if ($email_result->num_rows > 0) {
    $user = [];
    while ($row = $email_result->fetch_assoc()) {
        $user = $row;
    }

    if (password_verify($_POST['password'], $user['password'])) {
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'created_at' => $user['created_at'],
            'updated_at' => $user['updated_at'],
        ];

        header('Content-type: application/json');
        echo json_encode([
            'success' => true,
            'message' => 'Login success.',
            'data' => $data
        ], JSON_PRETTY_PRINT);
    } else {
        header('Content-type: application/json');
        http_response_code(422);
        echo json_encode([
            'success' => false,
            'message' => 'Wrong password!'
        ], JSON_PRETTY_PRINT);
    }
} else {
    header('Content-type: application/json');
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Email is not registered!'
    ], JSON_PRETTY_PRINT);
}
