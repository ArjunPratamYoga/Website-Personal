<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Selamat datang, Admin!</h2>
    <p>Halo, <?php echo $_SESSION['username']; ?>!</p>
    <p><a href="admin_read.php">masuk</a></p>
    <a href="logout.php">Logout</a>
</body>
</html>
