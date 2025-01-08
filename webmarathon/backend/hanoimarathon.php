<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathon HaNoi</title>
    <link rel="stylesheet" href="../css/hanoimarathon.css">
</head>

<body>
    <div class="container">
        <div class="card-header">
            <h1>HN Marathon</h1>
            <div class="button-group">
                <a href="../index.php" class="b-home">Home</a>
            </div>
        </div>
        <div class="card-content">
            <div class="bg-image">
                <img src="../images/hanoi.jpg" alt="Image 2" class="box-img">
            </div>
            <div class="h-content">
                <div class="info-content">
                    <h2>HANOI MARATHON 2024</h2>
                    <p>Finish (23:59) 28-12-2024</p>
                    <p>Location: Ha Noi</p>
                </div>
                <div class="m-image">
                    <img src="../images/hanoimap.png" alt="Map Marathon Hanoi" class="map-img">
                </div>
                <div class="r-button">
                    <a href="../register.html?marathonID=1" class="b-register">Register</a>
                </div>
            </div>
        </div>
        <div class="participant-table">
            <?php
            // Kết nối đến cơ sở dữ liệu
            session_start();
            require_once 'db_connect.php';

            // Truy vấn dữ liệu từ bảng user_marathon với marathonID = 1
            $sql = "SELECT * FROM user_marathon WHERE marathonID = 1";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>EntryNo</th><th>Name</th><th>Email</th><th>Age</th><th>Nationality</th><th>Time Record</th></tr>";
                $count = 1;
                // Hiển thị dữ liệu dưới dạng bảng
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $count++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['entry_no']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['age']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nationality']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['time_record']) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No participants found.";
            }

            // Đóng kết nối
            $conn->close();
            ?>
        </div>
</body>

</html>