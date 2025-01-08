<?php
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (isset($_POST['deleteID'])) {
        $studentID = $_POST['deleteID'];
        deleteStudent($studentID);
    }
   
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    if (isset($_GET['deleteID'])) {
        $studentID = $_GET['deleteID'];
        deleteStudent($studentID);
    }
   
    header('Location: index.php');
    exit();
}
?>
