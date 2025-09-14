<?php
include "db.php";
session_start();

// Check if admin is logged in
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit;
}

// Handle Add Item
if(isset($_POST['report'])){
    $item_name = $_POST['item_name'];
    $type = $_POST['type'];
    $description = $_POST['description'];
    $telephone = $_POST['telephone'];
    $email = $_POST['email'];
    $date_found = $_POST['date_found'];
    $location = $_POST['location'];

    $stmt = $conn->prepare("INSERT INTO items (item_name, type, description, telephone, email, date_found, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $item_name, $type, $description, $telephone, $email, $date_found, $location);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_panel.php"); // Refresh page to show new item
    exit;
}

// Handle Delete Item
if(isset($_GET['delete_item'])){
    $item_id = $_GET['delete_item'];
    $stmt = $conn->prepare("DELETE FROM items WHERE id=?");
    $stmt->bind_param("i", $item_id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_panel.php");
    exit;
}

// Handle Delete User
if(isset($_GET['delete_user'])){
    $user_id = $_GET['delete_user'];
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    $stmt2 = $conn->prepare("DELETE FROM items WHERE user_id=?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();
    $stmt2->close();

    header("Location: admin_panel.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - UniFinder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="navbar">
    <a href="admin_panel.php">⚙️ Admin Panel</a>
    <a href="logout.php">🚪 Logout</a>
</div>

<div class="container">
    <div class="admin-section1">
        <h2>⚙️ Admin Panel</h2>

        <!-- Add Item Form -->
        <h3>Add New Item</h3>
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

    <div class="admin-section2">
        <!-- List Items -->
        <h3>All Items</h3>
        <?php
        $result = $conn->query("SELECT * FROM items ORDER BY id DESC");
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<div class='item-card'>";
                echo "<h4>".$row['item_name']." (".$row['type'].")</h4>";
                echo "<p>".$row['description']."</p>";
                echo "<a href='admin_panel.php?delete_item=".$row['id']."' onclick=\"return confirm('Delete this item?')\">🗑️ Delete</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No items found.</p>";
        }
        ?>

        <!-- List Users -->
        <h3>All Users</h3>
        <?php
        $result = $conn->query("SELECT * FROM users ORDER BY id DESC");
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<div class='user-card'>";
                echo "<p>".$row['username']."</p>";
                echo "<a href='admin_panel.php?delete_user=".$row['id']."' onclick=\"return confirm('Delete this user?')\">🗑️ Delete User</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No users found.</p>";
        }
        ?>
    </div>
</div>
</body>
</html>
