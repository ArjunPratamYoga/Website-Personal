<?php
include 'koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Update status pembelian berdasarkan status pembayaran
$updateBerhasil = $conn->prepare("UPDATE ML_pembelian p
                                 JOIN ML_transaksi t ON p.id_pembelian = t.id_pembelian
                                 SET p.status = 'berhasil'
                                 WHERE t.status_pembayaran = 'dibayar' AND p.id_user = ?");
$updateBerhasil->bind_param('i', $id_user);
$updateBerhasil->execute();

// Update status pembelian menjadi "gagal" jika pembayaran gagal
$updateGagal = $conn->prepare("UPDATE ML_pembelian p
                              JOIN ML_transaksi t ON p.id_pembelian = t.id_pembelian
                              SET p.status = 'gagal'
                              WHERE t.status_pembayaran = 'gagal' AND p.id_user = ?");
$updateGagal->bind_param('i', $id_user);
$updateGagal->execute();

// Ambil histori pembelian berdasarkan id_user
$stmt = $conn->prepare("SELECT p.id_pembelian, d.jumlah_diamond, t.jumlah_pembayaran, p.status AS status_pembelian, t.status_pembayaran 
                       FROM ML_pembelian p 
                       JOIN ML_diamond d ON p.id_diamond = d.id_diamond 
                       JOIN ML_transaksi t ON p.id_pembelian = t.id_pembelian 
                       WHERE p.id_user = ?");
$stmt->bind_param('i', $id_user);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histori Pembelian Diamond</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 1rem;
        }

        th {
            background-color: #2575fc;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-back {
            padding: 12px 20px;
            margin-top: 30px;
            background-color: #6a11cb;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #2575fc;
        }

    </style>
</head>
<body>

<h2>Histori Pembelian Diamond</h2>

<table>
    <tr>
        <th>ID Pembelian</th>
        <th>Diamond</th>
        <th>Jumlah Pembayaran</th>
        <th>Status Pembelian</th>
        <th>Status Pembayaran</th>
    </tr>

    <?php
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_pembelian']}</td>
                <td>{$row['jumlah_diamond']} Diamond</td>
                <td>Rp " . number_format($row['jumlah_pembayaran'], 2, ',', '.') . "</td>
                <td>{$row['status_pembelian']}</td>
                <td>{$row['status_pembayaran']}</td>
              </tr>";
    }
    ?>
</table>

<a href="user.php">
    <button class="btn-back">Kembali</button>
</a>

</body>
</html>
