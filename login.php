<?php
include "db.php";
session_start();

$error = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Hardcoded admin credentials
    $admin_username = "uoc";
    $admin_password = "uoc";

    // Check if admin login
    if($username === $admin_username && $password === $admin_password){
        $_SESSION['admin'] = $username;
        header("Location: admin_panel.php");
        exit;
    } else {
        // User login
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if(password_verify($password, $row['password'])){
                $_SESSION['user'] = $row['id'];
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "❌ Invalid password!";
            }
        } else {
            $error = "❌ User not found!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - UniFinder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>🔑 UniFinder Login</h2>
    <?php if($error != ""){ echo "<p style='color:red;text-align:center;'>$error</p>"; } ?>
    <form method="post">
        <input type="text" name="username" placeholder="Enter Username" required><br><br>
        <input type="password" name="password" placeholder="Enter Password" required><br><br>
        <button type="submit" name="login">Login</button>
    </form>
    <p>Don’t have an account? <a href="register.php">Register here</a></p>
</div>
</body>
</html>
