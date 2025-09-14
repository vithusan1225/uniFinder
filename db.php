<?php
$host = "localhost";// your MySQL host
$user = "root";   // your MySQL username
$pass = "";       // your MySQL password
$dbname = "unifinder";// your database name

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
