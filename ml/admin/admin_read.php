<?php
include 'koneksi.php';
session_start();

// Periksa apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location:/ml/share/login.php");
    exit;
}

// Ambil data diamond
$sql = "SELECT * FROM ML_diamond";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Diamond</title>
    <style>
        /* Reset untuk elemen dasar */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            background-color: #f4f4f9;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: rgb(0, 105, 252);
            color: white;
            position: fixed;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h3 {
            /* text-align: center; */
            margin: 10px 0;
            margin-bottom: 20px;
            padding: 10px;
        }
        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        /* Main content */
        .content {
            margin-left: 290px;
            padding: 20px;
            flex: 1;
        }

        /* Judul */
        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        /* Tombol Tambah */
        .btn-add {
            display: inline-block;
            padding: 10px 15px;
            background-color: rgb(0, 105, 252);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .btn-add:hover {
            background-color: #0039b8;
        }

        /* Tabel */
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: white;
        }

        thead {
            background-color: rgb(0, 105, 252);
            color: white;
        }

        th, td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Admin </h3>
        <a href="admin_read.php">Daftar Diamond</a>
        <a href="admin_kelola.php">Kelola Transaksi</a>
        <a href="cetak_transaksi.php">Cetak Transaksi</a>
        <a href="/ml/share/logout.php">Logout</a>

    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Daftar Diamond</h2>
        <a href="add_diamond.php" class="btn-add">Tambah Diamond</a><br><br>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Diamond</th>
                    <th>Jumlah Diamond</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id_diamond']; ?></td>
                        <td><?php echo $row['jumlah_diamond']; ?></td>
                        <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id_diamond']; ?>">Edit</a> |
                            <a href="hapus.php?id=<?php echo $row['id_diamond']; ?>" onclick="return confirm('Yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
