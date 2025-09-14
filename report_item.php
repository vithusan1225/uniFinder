<?php 
include "db.php"; 
session_start(); 

if(!isset($_SESSION['user'])){
    header("Location: login.php"); 
    exit; 
} 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report Item - UniFinder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
    <a href="dashboard.php">🏠 Home</a>
    <a href="report_item.php">➕ Report Item</a>
    <a href="search_items.php">🔍 Search Items</a>
    <a href="my_claims.php">📦 My Claims</a>
    <a href="my_reports.php">📝 My Reports</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<div class="container">
    <h2>📌 Report Lost or Found Item</h2>
    <form method="post">
        <input type="text" name="item_name" placeholder="Enter item name" required><br>
        <textarea name="description" placeholder="Enter item description" required></textarea><br>
        <select name="type" required>
            <option value="Lost">❌ Lost</option>
            <option value="Found">✅ Found</option>
        </select><br>
        <input type="text" name="telephone" placeholder="Enter your telephone" required><br>
        <input type="email" name="email" placeholder="Enter your email" required><br>
        <input type="date" name="date_found" required><br>
        <input type="text" name="location" placeholder="Enter location" required><br>
        <button type="submit" name="report">Submit Report</button>
    </form>
</div>

<?php
if (isset($_POST['report'])) {
    $user_id = $_SESSION['user'];
    $item_name = $_POST['item_name'];
    $description = $_POST['description'];
    $type = $_POST['type'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $date_found = $_POST['date_found'];
    $location = $_POST['location'];

    // Use prepared statement for security
    $stmt = $conn->prepare("INSERT INTO items (user_id, item_name, description, type, telephone, email, date_found, location) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $user_id, $item_name, $description, $type, $telephone, $email, $date_found, $location);

    if ($stmt->execute()) {
        echo "<p style='color:green;text-align:center;'>✅ Item reported successfully!</p>";
    } else {
        echo "<p style='color:red;text-align:center;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>
</body>
</html>
