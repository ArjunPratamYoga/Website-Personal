<?php
session_start();

// Periksa apakah user sudah login dan memiliki role pengguna
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pengguna') {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        p {
            text-align: center;
            color: #555;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            text-align: center;
        }

        a:hover {
            background-color: #0056b3;
        }

        .container {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Selamat datang, Pengguna!</h2>
        <p>Halo, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>!</p>
        <a href="../logout.php">Logout</a>
        <a href="user.php">Beli Diamond</a>
    </div>
</body>
</html>
