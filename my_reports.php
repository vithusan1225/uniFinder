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
    <title>My Reports - UniFinder</title>
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
    <h2>📝 My Reported Items</h2>

<?php
$user_id = $_SESSION['user'];
$sql = "SELECT * FROM items WHERE user_id='$user_id' ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='item-card'>";
        echo "<h3>".$row['item_name']." (".$row['type'].")</h3>";
        echo "<p>".$row['description']."</p>";
        echo "<p><b>Reported:</b> ✅</p>";
        echo "</div>";
    }
} else {
    echo "<p>You have not reported any items yet.</p>";
}
?>
</div>
</body>
</html>
