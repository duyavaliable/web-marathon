<?php
// Hiển thị tất cả lỗi
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//thiet lap phien lam viec va ket noi den co so du lieu
session_start();
require_once 'db_connect.php';

// Debug session
error_log("Session contents: " . print_r($_SESSION, true));

//kiem tra xem co phai request post khong (yeu cau dang nhap admin dung chua neu chua quay lai)
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Xu ly yeu cau cap nhat EntryNo
if (isset($_POST['update'])) {
    if (isset($_POST['entry_nos']) || isset($_POST['time_records'])) {
        $entry_nos = $_POST['entry_nos']; // Nhận danh sách EntryNo từ form
        $time_records = $_POST['time_records'] ?? [];
        foreach ($entry_nos as $user_id => $new_entry_no) {
            // Kiểm tra nếu mã chạy mới không rỗng và khác giá trị cũ
            if (!empty($new_entry_no)) {
                // Kiểm tra xem mã mới có bị trùng không
                $stmt = $conn->prepare("SELECT * FROM user_marathon WHERE entry_no = ?");
                $stmt->bind_param("s", $new_entry_no);
                $stmt->execute();
                $check_result = $stmt->get_result();

                if ($check_result->num_rows == 0) {
                    // Cập nhật mã chạy mới
                    $update_stmt = $conn->prepare("UPDATE user_marathon SET entry_no = ? WHERE user_id = ?");
                    $update_stmt->bind_param("si", $new_entry_no, $user_id);
                    $update_stmt->execute();
                    $update_stmt->close();
                }
                $stmt->close();
            }
        }

        // Handle Time Record updates
        foreach ($time_records as $user_id => $new_time_record) {
            if (isset($new_time_record)) {
                $update_stmt = $conn->prepare("UPDATE user_marathon SET time_record = ? WHERE user_id = ?");
                $update_stmt->bind_param("si", $new_time_record, $user_id);
                $update_stmt->execute();
                $update_stmt->close();
            }
        }
        header("Location: management.php");
        exit();
    }
}

//lay du lieu tu bang co so du lieu user_marathon
$sql = "SELECT * FROM user_marathon";
$result = mysqli_query($conn, $sql);
// Query for Ha Noi Marathon (marathonID = 1)
$sql_hanoi = "SELECT * FROM user_marathon WHERE marathonID = 1";
$result_hanoi = mysqli_query($conn, $sql_hanoi);

// Query for My Dinh Marathon (marathonID = 2)
$sql_mydinh = "SELECT * FROM user_marathon WHERE marathonID = 2";
$result_mydinh = mysqli_query($conn, $sql_mydinh);

if (!$result) {
    die("Lỗi thực thi truy vấn: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Management</title>
    <link rel="stylesheet" href="../css/management.css">
</head>

<body>
    <header>
        <h1>List of Participants</h1>
        <a href="admin_login.php" class="logout-btn">Log Out</a>
    </header>
    <main>
        <!-- Hà Nội Marathon Table -->
        <h2>Ha Noi Marathon</h2>
        <?php $counter_hanoi = 1; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="updateFormHanoi">
            <table class="marathon-table" id="edit-table-hanoi">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EntryNo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Nationality</th>
                        <th>Time Record</th>
                        <th>Standings</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Create an array to store time and user IDs
                    $time_records_hanoi = [];
                    while ($row = mysqli_fetch_assoc($result_hanoi)) {
                        $time_records_hanoi[] = ['user_id' => $row['user_id'], 'time_record' => $row['time_record']];
                    }

                    // Sort the array by time
                    usort($time_records_hanoi, function ($a, $b) {
                        $timeA = $a['time_record'] ?? '';
                        $timeB = $b['time_record'] ?? '';
                        if (empty($timeA) && empty($timeB)) {
                            return 0;
                        } elseif (empty($timeA)) {
                            return 1; // Place user at the end
                        } elseif (empty($timeB)) {
                            return -1; // Place user at the beginning
                        }

                        $datetimeA = DateTime::createFromFormat('H:i:s', $timeA);
                        $datetimeB = DateTime::createFromFormat('H:i:s', $timeB);

                        if (!$datetimeA && !$datetimeB) {
                            return 0;
                        } elseif (!$datetimeA) {
                            return 1;
                        } elseif (!$datetimeB) {
                            return -1;
                        }

                        return $timeA <=> $timeB;
                    });

                    // Array to store standings
                    $standings_hanoi = [];
                    foreach ($time_records_hanoi as $index => $time_record) {
                        $standings_hanoi[$time_record['user_id']] = $index + 1;
                    }

                    // Reset result pointer and initialize counter
                    mysqli_data_seek($result_hanoi, 0);
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result_hanoi)) {
                        if (!$row) {
                            continue;
                        }
                    ?>
                        <tr>
                            <td><?php echo $counter_hanoi++; ?></td>
                            <td class="entry-no">
                                <input type="text" name="entry_nos[<?php echo $row['user_id']; ?>]"
                                    value="<?php echo htmlspecialchars($row['entry_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    placeholder="N/A">
                            </td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                            <td class="time-record">
                                <input type="text" name="time_records[<?php echo $row['user_id']; ?>]"
                                    value="<?php echo htmlspecialchars($row['time_record'] ?? ''); ?>"
                                    placeholder="N/A">
                            </td>
                            <td><?php echo isset($standings_hanoi[$row['user_id']]) ? $standings_hanoi[$row['user_id']] : 'N/A'; ?></td>
                            <td>
                                <form method="POST" action="delete_user.php">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                    <button type="submit" class="btn-u" name="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" class="btn-u" name="update">Update</button>
        </form>

        <!-- Mỹ Đình Marathon Table -->
        <h2>My Dinh Marathon</h2>
        <?php $counter_mydinh = 1; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="updateFormMyDinh">
            <table class="marathon-table" id="edit-table-mydinh">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>EntryNo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Nationality</th>
                        <th>Time Record</th>
                        <th>Standings</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Create an array to store time and user IDs for Mỹ Đình Marathon
                    $time_records_mydinh = [];
                    while ($row = mysqli_fetch_assoc($result_mydinh)) {
                        $time_records_mydinh[] = ['user_id' => $row['user_id'], 'time_record' => $row['time_record']];
                    }

                    // Sort the array by time
                    usort($time_records_mydinh, function ($a, $b) {
                        $timeA = $a['time_record'] ?? '';
                        $timeB = $b['time_record'] ?? '';
                        if (empty($timeA) && empty($timeB)) {
                            return 0;
                        } elseif (empty($timeA)) {
                            return 1; // Place user at the end
                        } elseif (empty($timeB)) {
                            return -1; // Place user at the beginning
                        }

                        $datetimeA = DateTime::createFromFormat('H:i:s', $timeA);
                        $datetimeB = DateTime::createFromFormat('H:i:s', $timeB);

                        if (!$datetimeA && !$datetimeB) {
                            return 0;
                        } elseif (!$datetimeA) {
                            return 1;
                        } elseif (!$datetimeB) {
                            return -1;
                        }

                        return $timeA <=> $timeB;
                    });

                    // Array to store standings
                    $standings_mydinh = [];
                    foreach ($time_records_mydinh as $index => $time_record) {
                        $standings_mydinh[$time_record['user_id']] = $index + 1;
                    }

                    // Reset result pointer and initialize counter
                    mysqli_data_seek($result_mydinh, 0);
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result_mydinh)) {
                        if (!$row) {
                            continue;
                        }
                    ?>
                        <tr>
                            <td><?php echo $counter_mydinh++; ?></td>
                            <td class="entry-no">
                                <input type="text" name="entry_nos[<?php echo $row['user_id']; ?>]"
                                    value="<?php echo htmlspecialchars($row['entry_no'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    placeholder="N/A">
                            </td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['age']); ?></td>
                            <td><?php echo htmlspecialchars($row['nationality']); ?></td>
                            <td class="time-record">
                                <input type="text" name="time_records[<?php echo $row['user_id']; ?>]"
                                    value="<?php echo htmlspecialchars($row['time_record'] ?? ''); ?>"
                                    placeholder="N/A">
                            </td>
                            <td><?php echo isset($standings_mydinh[$row['user_id']]) ? $standings_mydinh[$row['user_id']] : 'N/A'; ?></td>
                            <td>
                                <form method="POST" action="delete_user.php">
                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                    <button type="submit" class="btn-u" name="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <button type="submit" class="btn-u" name="update">Update</button>
        </form>
        <form method="GET" action="create_race.php">
            <button type="submit" class="btn-u create-map-btn" name="create-map">Create Map</button>
        </form>
    </main>
    <script src="../js/management.js"></script>
</body>

</html>