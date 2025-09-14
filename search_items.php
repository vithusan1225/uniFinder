<?php include "db.php"; session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Items - UniFinder</title>
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
    <h2>🔍 Search Reported Items</h2>
    <form method="get">
        <input type="text" name="q" placeholder="Search by item name">
        <button type="submit">Search</button>
    </form>
</div>

<?php
$q = isset($_GET['q']) ? $_GET['q'] : '';
$sql = "SELECT * FROM items WHERE item_name LIKE '%$q%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='item-card'>";
        echo "<h3>".$row['item_name']." (".$row['type'].")</h3>";
        echo "<p>".$row['description']."</p>";
        echo "<a href='claim_item.php?id=".$row['id']."'>✅ Claim</a>";
        echo "</div>";
    }
} else {
    echo "<p style='text-align:center;'>No items found.</p>";
}
?>
</body>
</html>
