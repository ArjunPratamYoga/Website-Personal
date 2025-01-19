<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'topup_diamond_ml';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Query untuk menampilkan transaksi yang terkait dengan pembelian diamond
$stmt = $pdo->query("SELECT t.id_transaksi, p.id_pembelian, u.username, t.jumlah_pembayaran, t.status_pembayaran, t.tanggal_transaksi 
                     FROM ML_transaksi t 
                     JOIN ML_pembelian p ON t.id_pembelian = p.id_pembelian 
                     JOIN ML_user u ON p.id_user = u.id_user");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi Pembelian Diamond</title>
    <style>
        /* CSS untuk halaman transaksi pembelian */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
            font-size: 14px;
        }

        table th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
            text-transform: uppercase;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #eaf2ff;
        }

        table td {
            color: #555;
        }

        table td:first-child, table th:first-child {
            width: 10%;
        }

        table td:last-child, table th:last-child {
            width: 15%;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        button:hover {
            background-color: #45a049;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            padding: 10px 0;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>

<h2>Daftar Transaksi Pembelian Diamond</h2>
<button onclick="window.print()">Cetak Halaman</button>  <!-- Tombol Print -->

<table>
    <tr>
        <th>ID Transaksi</th>
        <th>ID Pembelian</th>
        <th>Jumlah Pembayaran</th>
        <th>Status Pembayaran</th>
        <th>Tanggal Transaksi</th>
    </tr>

    <?php
    while ($row = $stmt->fetch()) {
        // Menampilkan setiap transaksi
        echo "<tr>
                <td>{$row['id_transaksi']}</td>
                <td>{$row['id_pembelian']}</td>
                <td>Rp " . number_format($row['jumlah_pembayaran'], 2, ',', '.') . "</td>
                <td>{$row['status_pembayaran']}</td>
                <td>{$row['tanggal_transaksi']}</td>
              </tr>";
    }
    ?>

</table>

<footer>
    <p>Powered by TopUp Diamond ML</p>
</footer>

</body>
</html>
