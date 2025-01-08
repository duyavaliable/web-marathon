<?php 
include 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        //Ghi nhat ky kiem tra user_id
        error_log("Deleting user with ID: " . $user_id);

        //xoa nguoi dung khoi bang 
        $stmt = $conn->prepare("DELETE FROM user_marathon WHERE user_id = ?");
        
        //kiem tra loi
        if ($stmt === false) {
            $error_message = "Prepare failed: " . $conn->error;
            error_log($error_message);
            header("Location: management.php?error=" .urlencode($error_message));
            exit();
        }

        $stmt->bind_param("i", $user_id);
        //KIEM TRA loi
        if ($stmt ->execute() === false){
            $error_message = "Execute failed: " . $stmt->error;
            error_log($error_message);
            header("Location: management.php?error=" .urlencode($error_message));
            exit();
        }
    // $stmt->execute();
        $stmt->close();

        //cap nhat lai standing thu hang
        $result = $conn->query("SELECT user_id FROM user_marathon ORDER BY time_record ASC");
        if ($result) {
            $stading = [];
            $index = 1;
            while ($row = $result->fetch_assoc()) {
                $stading[$row['user_id']] = $index;
                $index++;
            }

            foreach ($stading as $user_id => $standing) {
                $stmt = $conn->prepare("UPDATE user_marathon SET standing = ? WHERE user_id = ?");
                $stmt->bind_param("ii", $standing, $user_id);
                $stmt->execute();
                $stmt->close();
            }
        }
        //chuyen huong ve trang quan ly
        header("Location: management.php");
        exit();
    } else {
        $error_message = "User ID not set in POST request";
        error_log($error_message);
        header("Location: management.php?error=" .urlencode($error_message));
        exit();
    }
}else {
    //neu ko phai phuong thuc post thi tra ve loi
    http_response_code(405);
    $error_message = "Error 405: Request method not supported";
    error_log($error_message);
    die($error_message);
}

?>