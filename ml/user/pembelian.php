<?php
session_start(); // Memulai sesi untuk menyimpan informasi login pengguna

error_reporting(E_ALL); 
ini_set('display_errors', 1);

// Koneksi ke database
$host = 'localhost';
$dbname = 'topup_diamond_ml';
$username = 'root';
$password = '';
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Pastikan id_user didapat dari sesi login
$id_user = $_SESSION['id_user']; // ID User yang login

// Menangani pembelian diamond
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_diamond = $_POST['id_diamond'];

    // Cek apakah user sudah pernah membeli diamond ini sebelumnya
    $stmt = $pdo->prepare("SELECT * FROM ML_pembelian WHERE id_user = :id_user AND id_diamond = :id_diamond AND status = 'pending'");
    $stmt->execute(['id_user' => $id_user, 'id_diamond' => $id_diamond]);
    $existing_purchase = $stmt->fetch();

    if ($existing_purchase) {
        // Jika ada pembelian yang masih pending
        echo "<script>alert('Anda sudah melakukan pembelian diamond ini dan masih dalam status pending.');</script>";
    } else {
        // Ambil harga dari paket diamond
        $stmt = $pdo->prepare("SELECT harga FROM ML_diamond WHERE id_diamond = :id_diamond");
        $stmt->execute(['id_diamond' => $id_diamond]);
        $diamond = $stmt->fetch();

        if ($diamond) {
            $harga = $diamond['harga'];

            // Simpan data pembelian dengan status 'pending'
            $stmt = $pdo->prepare("INSERT INTO ML_pembelian (id_user, id_diamond, status) 
                                   VALUES (:id_user, :id_diamond, 'pending')");
            $stmt->execute(['id_user' => $id_user, 'id_diamond' => $id_diamond]);

            $id_pembelian = $pdo->lastInsertId(); 

            // Simpan transaksi pembayaran dengan status 'menunggu'
            $stmt = $pdo->prepare("INSERT INTO ML_transaksi (id_pembelian, jumlah_pembayaran, status_pembayaran) 
                                   VALUES (:id_pembelian, :jumlah_pembayaran, 'menunggu')");
            $stmt->execute(['id_pembelian' => $id_pembelian, 'jumlah_pembayaran' => $harga]);

            // Redirect setelah berhasil
            echo "<script>
                    alert('Pembelian berhasil, silakan lakukan pembayaran sebesar Rp" . number_format($harga, 2, ',', '.') . "');
                    document.location.href = 'history.php'; // Arahkan pengguna ke histori
                  </script>";
            exit();
        } else {
            echo "<script>alert('Paket diamond tidak ditemukan.');</script>";
        }
    }
}
?>

<!-- Sisa kode HTML untuk pembelian tetap sama -->
