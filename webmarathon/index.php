<!DOCTYPE html>
<html lang=en>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marathon HaNoi</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container">
        <div class="card-header">
            <h1>HN Marathon</h1>
            <div class="button-group">
                <a href="index.html" class="b-home">Home</a>
                <a href="result.html" class="b-result">Result</a>
            </div>
        </div>
        <div class="card-content">
            <div class="m-image">
                <img src="images/hanoi.jpg" alt="Image 2" class="box-img">
            </div>

            <div class="m-content">
                <div class="event-m" data-url="backend/hanoimarathon.php">
                    <img src="images/marathon.jpg" alt="Hanoi Marathon 2024" class="hn-img">
                    <h1>HaNoi Marathon</h1>
                    <a href="register.html" class="b-register">Register Now</a>
                </div>
                <div class="event-m" data-url="backend/mydinhmarathon.php">
                    <img src="images/mydinhm.jpg" alt="MyDinh Marathon 2024" class="md-img">
                    <h1>MyDinh Marathon</h1>
                    <a href="register.html" class="b-register">Register Now</a>
                </div>
            </div>
        </div>
        <div class="race-list">
            <?php
                // Kết nối cơ sở dữ liệu
                require_once 'backend/db_connect.php';

                // Truy vấn dữ liệu từ bảng name_marathon, bỏ qua marathonID là 1 và 2
                $result = $conn->query("SELECT racename, date FROM name_marathon WHERE marathonID NOT IN (1, 2) ORDER BY date ASC");

                if ($result->num_rows > 0) {
                    echo '<h2>Upcoming Races</h2>';
                    echo '<ul id="race-list">';
                    while ($row = $result->fetch_assoc()) {
                        $startDate = new DateTime($row['date']);
                        $endDate = new DateTime($row['date']);
                        $endDate->setTime(23, 59); // Giả sử thời gian kết thúc là 23:59 cùng ngày

                        echo '<li>';
                        echo '<h3>' . htmlspecialchars($row['racename']) . '</h3>';
                        echo '<p>Finish (' . $endDate->format('H:i') . ') ' . $endDate->format('d-m-Y') . '</p>';
                        echo '<a href="register.html" class="b-register">Register Now</a>';
                        echo '</li>';
                    }
                    echo '</ul>';
                }

                $conn->close();
            ?>
        </div>
        </div>
    </div>
    <script src="js/index.js"></script>
</body>

</html>