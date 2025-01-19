<?php
include 'koneksi.php';
session_start();

// Periksa apakah user adalah admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Hapus data diamond
$sql = "DELETE FROM ML_diamond WHERE id_diamond = '$id'";
if ($conn->query($sql) === TRUE) {
    header("Location:admin_read.php");
    exit;
} else {
    echo "Terjadi kesalahan: " . $conn->error;
}
?>
