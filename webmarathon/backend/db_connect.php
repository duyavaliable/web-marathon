<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "marathon";

//mk tai khoan 123
// Create a PDO instance
//bien kiem tra xem ket noi hay chua
try {
    $conn = new mysqli($server, $username, $password, $database);
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
    $conn->set_charset("utf8");
} catch (Exception $e) {
    error_log($e->getMessage());
    exit('Database connection error');
}
?>