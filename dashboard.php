<?php session_start(); if(!isset($_SESSION['user'])){ header("Location: login.php"); exit; } ?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - UniFinder</title>
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
    <h2>Welcome to UniFinder</h2>
    <p>Your one-stop portal for reporting and finding lost items within the university.</p>
</div>
</body>
</html>
