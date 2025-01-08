<?php
session_start(); //khoi tao phien lam vec cua session 
require_once 'db_connect.php'; //ket noi database

//kiem tra xem co phai request post khong
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //loc va santiize username input
    $username = htmlspecialchars(trim($_POST['admin_username']), ENT_QUOTES, 'UTF-8');
    //lay passsword tu form post
    $password = $_POST['admin_password'];


    //chuan bi cau quey sql vs prepare statement de lay thong tin user, tren co so du lieu
    //ten bang co so du lieu va ten cot (lay mat khau da ma hoa)
    $stmt = $conn->prepare("SELECT id, password FROM admin_marathon WHERE name = ?");
    $stmt->bind_param("s", $username); // bind username to the query
    $stmt->execute(); //thuc thu cau query
    $result = $stmt->get_result();

    //kiem tra xem co user nao tra ve khong
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc(); //lay du lieu user duoi dang array

        // so sanh password truc tiep
        if (password_verify($password, $user['password'])) {
            //set session va chuyen huong den trang dashboard
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            header("Location: management.php");
            exit();
        } else {
            // chuuyen huong ve trang login neu dang nhap khong thanh cong
            header("Location: admin_login.php?error=wrong_password");
            exit();
        }
    } else {
        // chuuyen huong ve trang login neu dang nhap khong thanh cong
        header("Location: admin_login.php?error=wrong_username");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="../css/admin_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <h1>Admin Login</h1>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error-message">';
            switch ($_GET['error']) {
                case 'wrong_password':
                    echo 'Wrong Passsord!';
                    break;
                case 'wrong_username':
                    echo 'Uesername does not exit!';
                    break;
                default:
                    echo 'Login Failed!';
            }
            echo '</div>';
        }
        ?>
    </header>
    <main>
        <form action="admin_login.php" method="POST">
            <div class="user-admin">
                <label for="admin_username" class="input">Username:</label>
                <input type="text" id="admin_username" name="admin_username" class="form-control" required>
            </div>
            <div class="p-container">
                <label for="admin_password" class="form-label">Password:</label>
                <input type="password" id="admin_password" name="admin_password" class="form-control" required>
                <span class="toggle-password" onclick="togglePassword()">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <a href="create_admin.php" class="add-btn">Create account</a>
        </form>
    </main>
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("admin_password");
            var passwordFieldType = passwordField.getAttribute("type");
            var toggleIcon = document.querySelector(".toggle-password i");
            if (passwordFieldType === "password") {
                passwordField.setAttribute("type", "text");
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordField.setAttribute("type", "password");
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        }
    </script>
</body>

</html>