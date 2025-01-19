<?php
// Mulai session untuk memberikan notifikasi jika diperlukan
session_start();

// Koneksi ke database
$host = 'localhost';
$dbname = 'topup_diamond_ml';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location:/ml/share/login.php");
    exit;
}

// Menangani perubahan status pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = $_POST['id_transaksi'];
    $status_pembayaran = $_POST['status_pembayaran'];

    // Update status pembayaran pada database
    $stmt = $pdo->prepare("UPDATE ML_transaksi 
                           SET status_pembayaran = :status_pembayaran 
                           WHERE id_transaksi = :id_transaksi");
    $stmt->execute([
        'status_pembayaran' => $status_pembayaran,
        'id_transaksi' => $id_transaksi
    ]);

    // Set session untuk notifikasi perubahan berhasil
    $_SESSION['status_berhasil'] = "Status pembayaran berhasil diperbarui.";

    // Redirect untuk mencegah pengiriman form ulang setelah refresh halaman
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Ambil semua transaksi dari database
$stmt = $pdo->query("SELECT t.id_transaksi, t.jumlah_pembayaran, t.status_pembayaran, 
                             t.tanggal_transaksi, p.id_user, d.jumlah_diamond 
                      FROM ML_transaksi t
                      INNER JOIN ML_pembelian p ON t.id_pembelian = p.id_pembelian
                      INNER JOIN ML_diamond d ON p.id_diamond = d.id_diamond
                      ORDER BY t.tanggal_transaksi DESC");
$transaksi = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi</title>
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
            text-align: center;
        }

        /* Judul */
        h2 {
            color: #333;
            margin-bottom: 20px;
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

        /* Tombol dan Dropdown */
        form select {
            padding: 5px;
            margin-right: 10px;
        }

        form button {
            padding: 5px 10px;
            background-color: rgb(0, 55, 255);
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        form button:hover {
            background-color: #0039b8;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h3>Kelola Transaksi</h3>
        <a href="admin_read.php">Daftar Diamond</a>
        <a href="admin_kelola.php">Kelola Transaksi</a>
        <a href="cetak_transaksi.php">Cetak Transaksi</a>
        <a href="/ml/share/logout.php">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Kelola Transaksi Pembayaran</h2>

        <!-- Notifikasi jika ada perubahan status -->
        <?php if (isset($_SESSION['status_berhasil'])): ?>
            <div style="color: green; font-size: 18px;">
                <?php echo $_SESSION['status_berhasil']; ?>
                <?php unset($_SESSION['status_berhasil']); ?>
            </div>
        <?php endif; ?>

        <table border="1" cellpadding="10" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Jumlah Diamond</th>
                    <th>Jumlah Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transaksi as $row): ?>
                    <tr>
                        <td><?= $row['id_transaksi']; ?></td>
                        <td><?= $row['jumlah_diamond']; ?></td>
                        <td>Rp <?= number_format($row['jumlah_pembayaran'], 2, ',', '.'); ?></td>
                        <td><?= ucfirst($row['status_pembayaran']); ?></td>
                        <td><?= $row['tanggal_transaksi']; ?></td>
                        <td>
                            <form method="POST" action="">
                                <input type="hidden" name="id_transaksi" value="<?= $row['id_transaksi']; ?>">
                                <select name="status_pembayaran">
                                    <option value="menunggu" <?= $row['status_pembayaran'] == 'menunggu' ? 'selected' : ''; ?>>Menunggu</option>
                                    <option value="dibayar" <?= $row['status_pembayaran'] == 'dibayar' ? 'selected' : ''; ?>>Dibayar</option>
                                    <option value="gagal" <?= $row['status_pembayaran'] == 'gagal' ? 'selected' : ''; ?>>Gagal</option>
                                </select>
                                <button type="submit">Ubah</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
