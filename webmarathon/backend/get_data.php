<?php
require_once 'db_connect.php';

// Query cho Hà Nội Marathon
$sql_hanoi = "SELECT * FROM user_marathon WHERE marathonID = 1 ORDER BY time_record";
$result_hanoi = mysqli_query($conn, $sql_hanoi);

// Query cho Mỹ Đình Marathon
$sql_mydinh = "SELECT * FROM user_marathon WHERE marathonID = 2 ORDER BY time_record";
$result_mydinh = mysqli_query($conn, $sql_mydinh);

$data = [
    'hanoi' => [],
    'mydinh' => []
];

// Xử lý dữ liệu Hà Nội Marathon
$rank = 1;
while ($row = mysqli_fetch_assoc($result_hanoi)) {
    $row['rank'] = $row['time_record'] ? $rank++ : 'N/A';
    $data['hanoi'][] = $row;
}

// Xử lý dữ liệu Mỹ Đình Marathon
$rank = 1;
while ($row = mysqli_fetch_assoc($result_mydinh)) {
    $row['rank'] = $row['time_record'] ? $rank++ : 'N/A';
    $data['mydinh'][] = $row;
}

// Trả về dữ liệu dạng JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
