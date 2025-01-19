<?php
include 'koneksi.php';
session_start();

// Periksa apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Ambil data diamond berdasarkan ID
$sql = "SELECT * FROM ML_diamond WHERE id_diamond = '$id'";
$result = $conn->query($sql);
$diamond = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_diamond = $_POST['jumlah_diamond'];
    $harga = $_POST['harga'];

    // Update data di database
    $sql = "UPDATE ML_diamond SET jumlah_diamond = '$jumlah_diamond', harga = '$harga' WHERE id_diamond = '$id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_read.php");
        exit;
    } else {
        $error = "Terjadi kesalahan: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Diamond</title>
    <style>
        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Gaya untuk seluruh halaman */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Container form */
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        /* Judul halaman */
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        /* Label form */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        /* Input field */
        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Tombol submit */
        button {
            width: 100%;
            padding: 10px 15px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Pesan error */
        p {
            color: red;
            text-align: center;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <h2>Edit Diamond</h2>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        <label for="jumlah_diamond">Jumlah Diamond:</label>
        <input type="number" id="jumlah_diamond" name="jumlah_diamond" value="<?php echo $diamond['jumlah_diamond']; ?>" required>

        <label for="harga">Harga:</label>
        <input type="number" id="harga" name="harga" step="0.01" value="<?php echo $diamond['harga']; ?>" required>

        <button type="submit">Update</button>
    </form>
</body>
</html>
