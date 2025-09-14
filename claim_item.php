<?php include "db.php"; session_start(); if(!isset($_SESSION['user'])){ header("Location: login.php"); exit; } ?>
<!DOCTYPE html>
<html>
<head>
    <title>Claim Item - UniFinder</title>
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
    <h2>✅ Claim Item</h2>
<?php
if (isset($_GET['id'])) {
    $item_id = $_GET['id'];
    $user_id = $_SESSION['user'];

    // Prevent duplicate claims
    $check = $conn->query("SELECT * FROM claims WHERE item_id='$item_id' AND user_id='$user_id'");
    if ($check->num_rows > 0) {
        echo "<p style='color:orange;'>⚠️ You have already claimed this item.</p>";
    } else {
        $sql = "INSERT INTO claims (item_id, user_id) VALUES ('$item_id', '$user_id')";
        if ($conn->query($sql)) {
            echo "<p style='color:green;'>🎉 Claim request submitted successfully!</p>";
        } else {
            echo "<p style='color:red;'>❌ Error: " . $conn->error . "</p>";
        }
    }
} else {
    echo "<p style='color:red;'>❌ No item selected to claim.</p>";
}
?>
    <br>
    <a href="search_items.php">🔙 Back to Search</a>
</div>
</body>
</html>
