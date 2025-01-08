<?php
require_once 'db_connect.php';

// Kiểm tra xem có phải request POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy username và password từ form POST
    $username = htmlspecialchars(trim($_POST['admin_username']), ENT_QUOTES, 'UTF-8');
    $password = $_POST['admin_password'];

    // Mã hóa mật khẩu
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Lưu mật khẩu đã mã hóa vào cơ sở dữ liệu
    // Luu mat khau da ma hoa vao co so du lieu
    $stmt = $conn->prepare("INSERT INTO admin_marathon (name, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    if ($stmt->execute()) {
        header("Location: admin_login.php");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Admin</title>
    <link rel="stylesheet" href="../css/admin_login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
</head>

<body>
    <header>
        <h1>Create Admin Account</h1>
    </header>
    <main>
        <form action="create_admin.php" method="POST">
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
            <button type="submit" class="btn btn-primary">Create Admin</button>
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