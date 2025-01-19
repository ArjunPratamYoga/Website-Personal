<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'topup_diamond_ml';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Mendapatkan id_pembelian dari URL
$id_pembelian = $_GET['id_pembelian'];

// Update status pembelian menjadi 'berhasil'
$stmt = $pdo->prepare("UPDATE ML_pembelian SET status = 'berhasil' WHERE id_pembelian = :id_pembelian");
$stmt->execute(['id_pembelian' => $id_pembelian]);

// Update status transaksi menjadi 'dibayar'
$stmt = $pdo->prepare("UPDATE ML_transaksi SET status_pembayaran = 'dibayar' WHERE id_pembelian = :id_pembelian");
$stmt->execute(['id_pembelian' => $id_pembelian]);

echo "Pembelian telah disetujui dan pembayaran berhasil.";
?>
