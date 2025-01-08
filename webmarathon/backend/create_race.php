<?php


// Bao gồm file db_connect.php để kết nối cơ sở dữ liệu
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $racename = $_POST['racename'];
    $date = $_POST['date'];

    // Chuẩn bị và thực thi câu lệnh SQL để chèn dữ liệu vào bảng name_marathon
    $stmt = $conn->prepare("INSERT INTO name_marathon (racename, date) VALUES (?, ?)");
    $stmt->bind_param("ss", $racename, $date);

    if ($stmt->execute()) {
        // Chuyển hướng về trang index.php sau khi thêm thành công
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Race</title>
</head>
<body>
    <h1>Create Race</h1>
    <form method="POST" action="">
        <label for="racename">Race Name:</label>
        <input type="text" id="racename" name="racename" required><br><br>
        <label for="date">Event Date:</label>
        <input type="date" id="date" name="date" required><br><br>
        <input type="submit" value="Add race">
    </form>
</body>
</html>