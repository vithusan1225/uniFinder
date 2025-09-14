<?php
session_start();
session_destroy();
header("Location: login.php"); // user or admin_login.php for admin
exit;
?>
