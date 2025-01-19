<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'topup_diamond_ml';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Mendapatkan id_pembelian dari URL
$id_pembelian = $_GET['id_pembelian'];

// Update status pembelian menjadi 'gagal'
$stmt = $pdo->prepare("UPDATE ML_pembelian SET status = 'gagal' WHERE id_pembelian = :id_pembelian");
$stmt->execute(['id_pembelian' => $id_pembelian]);

// Update status transaksi menjadi 'gagal'
$stmt = $pdo->prepare("UPDATE ML_transaksi SET status_pembayaran = 'gagal' WHERE id_pembelian = :id_pembelian");
$stmt->execute(['id_pembelian' => $id_pembelian]);

echo "Pembelian telah dibatalkan.";
?>
