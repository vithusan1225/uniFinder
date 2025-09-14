<?php
session_start();
include "db.php";

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm  = $_POST['confirm'];

    if ($password !== $confirm) {
        $error = "❌ Passwords do not match!";
    } else {
        // Hash password
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res->num_rows > 0) {
            $error = "⚠️ Username already taken. Try another.";
        } else {
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $username, $hashed);
            if ($stmt->execute()) {
                $success = "✅ Registration successful! <a href='login.php'>Login here</a>";
            } else {
                $error = "❌ Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register - UniFinder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>📝 User Registration</h2>
    <form method="post">
        <input type="text" name="username" placeholder="Choose a username" required><br>
        <input type="password" name="password" placeholder="Enter password" required><br>
        <input type="password" name="confirm" placeholder="Confirm password" required><br>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already registered? <a href="login.php">Login here</a></p>

    <?php
    if (isset($error)) {
        echo "<p style='color:red;text-align:center;'>$error</p>";
    }
    if (isset($success)) {
        echo "<p style='color:green;text-align:center;'>$success</p>";
    }
    ?>
</div>
</body>
</html>
