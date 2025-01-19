<?php
include 'koneksi.php';
session_start();

// Periksa apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dan validasi
    $jumlah_diamond = isset($_POST['jumlah_diamond']) ? intval($_POST['jumlah_diamond']) : 0;
    $harga = isset($_POST['harga']) ? floatval($_POST['harga']) : 0;

    if ($jumlah_diamond > 0 && $harga > 0) {
        // Masukkan data ke database menggunakan prepared statement
        $stmt = $conn->prepare("INSERT INTO ML_diamond (jumlah_diamond, harga) VALUES (?, ?)");
        $stmt->bind_param("id", $jumlah_diamond, $harga);

        if ($stmt->execute()) {
            // Redirect ke halaman admin_read setelah berhasil
            header("Location: admin_read.php");
            exit;
        } else {
            $error = "Terjadi kesalahan saat menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Jumlah diamond dan harga harus lebih besar dari 0!";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Diamond</title>
    <style>
        /* CSS untuk halaman tambah diamond */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-top: 20px;
        }

        form {
            background: #fff;
            max-width: 400px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
        }

        input[type="number"] {
            width: calc(100% - 20px);
            padding: 8px 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            color: #333;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            font-size: 14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        p {
            text-align: center;
            color: red;
            font-size: 14px;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <h2>Tambah Diamond</h2>
    <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    <form method="POST" action="">
        <label for="jumlah_diamond">Jumlah Diamond:</label>
        <input type="number" id="jumlah_diamond" name="jumlah_diamond" required>
        
        <label for="harga">Harga:</label>
        <input type="number" id="harga" name="harga" step="0.01" required>
        
        <button type="submit">Tambah</button>
    </form>
    <footer>&copy; 2025 Sistem Top-Up Diamond</footer>
</body>
</html>
