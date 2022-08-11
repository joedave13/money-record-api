<?php
include '../connection.php';

$user_id = $_POST['user_id'];
$today = new DateTime();
$today->setTimezone(new DateTimeZone('Asia/Jakarta'));
$this_month = $today->format('m');

$day7 = $today->format('Y-m-d');
$day6 = date_sub($today, new DateInterval('P1D'))->format('Y-m-d');
$day5 = date_sub($today, new DateInterval('P1D'))->format('Y-m-d');
$day4 = date_sub($today, new DateInterval('P1D'))->format('Y-m-d');
$day3 = date_sub($today, new DateInterval('P1D'))->format('Y-m-d');
$day2 = date_sub($today, new DateInterval('P1D'))->format('Y-m-d');
$day1 = date_sub($today, new DateInterval('P1D'))->format('Y-m-d');

$week = [$day1, $day2, $day3, $day4, $day5, $day6, $day7];

$weekly = [0, 0, 0, 0, 0, 0, 0];
$month_income = 0;
$month_outcome = 0;

$sql_month = "SELECT * FROM histories WHERE user_id = '$user_id' AND MONTH(date) = MONTH(NOW()) ORDER BY date DESC";
$result_month = $connect->query($sql_month);

if ($result_month->num_rows > 0) {
    while ($row_month = $result_month->fetch_assoc()) {
        $type = $row_month['type'];
        if ($type == 'Pemasukan') {
            $month_income += intval($row_month['total']);
        } else {
            $month_outcome += intval($row_month['total']);
        }
    }
}

$sql_week = "SELECT * FROM histories WHERE user_id = '$user_id' AND date >= '$day1' ORDER BY date DESC";
$result_week = $connect->query($sql_week);

if ($result_week->num_rows > 0) {
    while ($row_week = $result_week->fetch_assoc()) {
        $type = $row_week['type'];
        $date = $row_week['date'];
        if ($type == 'Pengeluaran') {
            for ($i = 0; $i < count($week); $i++) {
                if ($date == $week[$i]) {
                    $weekly[$i] += intval($row_week['total']);
                }
            }
        }
    }
}

header('Content-Type: application/json');
echo json_encode([
    'today' => $weekly[6],
    'yesterday' => $weekly[5],
    'week' => $weekly,
    'month' => [
        'income' => $month_income,
        'outcome' => $month_outcome
    ]
], JSON_PRETTY_PRINT);
