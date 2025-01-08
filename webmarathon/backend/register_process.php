<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //kiem tra
    if (isset($_POST['marathonID'])){
        $marathonID = intval($_POST['marathonID']);
    } else {
        //ham xu ly khi ko co marathonID
        header("Location: ../register.html?error=missing_marathonID");
        exit();
    }

    //lay du lieu khac tu POST
    $username = htmlspecialchars(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars(trim($_POST['email']), ENT_QUOTES, 'UTF-8');
    $age = $_POST['age'];
    $gender = htmlspecialchars(trim($_POST['sex']), ENT_QUOTES, 'UTF-8');
    $nationality = htmlspecialchars(trim($_POST['nationality']), ENT_QUOTES, 'UTF-8');

    //chuan bi cau lenh sql bao gom marathonID
    $stmt = $conn->prepare("INSERT INTO user_marathon (marathonID,name, email, age, gender, nationality) VALUES (?,?, ?, ?, ?, ?)");

    $stmt->bind_param("ississ",$marathonID, $username, $email, $age, $gender, $nationality);

    if ($stmt->execute()) {
        header("Location: ../success.html");
        exit();
    } else {
        header("Location: backend/register_process.php?error=1");
        exit();
    }
}