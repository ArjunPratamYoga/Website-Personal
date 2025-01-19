<?php
include 'koneksi.php';
session_start();

// Pastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location:/ml/share/login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Proses logout jika tombol ditekan
if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location:/ml/share/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_diamond = $_POST['id_diamond'];

    // Cek apakah pengguna sudah membeli diamond ini sebelumnya dengan status 'pending'
    $stmt = $conn->prepare("SELECT * FROM ML_pembelian WHERE id_user = ? AND id_diamond = ? AND status = 'pending'");
    $stmt->bind_param('ii', $id_user, $id_diamond);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Anda sudah memiliki pembelian dengan status pending untuk diamond ini.');</script>";
    } else {
        // Ambil harga dari paket diamond yang dipilih
        $stmt = $conn->prepare("SELECT harga FROM ML_diamond WHERE id_diamond = ?");
        $stmt->bind_param('i', $id_diamond);
        $stmt->execute();
        $diamond = $stmt->get_result()->fetch_assoc();

        if ($diamond) {
            $harga = $diamond['harga'];

            // Simpan data pembelian dengan status 'pending'
            $stmt = $conn->prepare("INSERT INTO ML_pembelian (id_user, id_diamond, status) VALUES (?, ?, 'pending')");
            $stmt->bind_param('ii', $id_user, $id_diamond);
            $stmt->execute();

            $id_pembelian = $stmt->insert_id; // ID Pembelian terakhir yang dimasukkan

            // Simpan transaksi pembayaran dengan status 'menunggu'
            $stmt = $conn->prepare("INSERT INTO ML_transaksi (id_pembelian, jumlah_pembayaran, status_pembayaran) VALUES (?, ?, 'menunggu')");
            $stmt->bind_param('ii', $id_pembelian, $harga);
            $stmt->execute();

            // Redirect ke halaman history setelah pembelian berhasil
            echo "<script>
                    alert('Pembelian berhasil! Silakan lakukan pembayaran sebesar Rp" . number_format($harga, 2, ',', '.') . "');
                    document.location.href = 'history.php';
                  </script>";
        } else {
            echo "<script>alert('Paket diamond tidak ditemukan.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembelian Diamond</title>
    <style>
        /* General body styling */
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
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        /* Styling for the diamond cards container */
        .diamond-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1200px;
            margin-top: 30px;
        }

        /* Individual card styling */
        .diamond-card {
            display: flex;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            width: 100%;
            max-width: 280px;
            text-align: center;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card-content {
            padding: 20px;
        }

        .card-content h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2575fc;
        }

        .card-content p {
            font-size: 1rem;
            color: #333;
            margin-bottom: 20px;
            font-weight: 500;
        }

        .card .btn-beli {
            background-color: #2575fc;
            border: none;
            color: white;
            font-weight: bold;
            padding: 12px 20px;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .card .btn-beli:hover {
            background-color: #6a11cb;
        }

        /* History button styling */
        .btn-history {
            padding: 12px 20px;
            background-color: #6a11cb;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
            display: block;
            margin-top: 20px;
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
        }

        .btn-history:hover {
            background-color: #2575fc;
        }

        .history-container {
            text-align: center;
            margin-top: 30px;
        }

        /* Logout button styling */
        .btn-logout {
            padding: 12px 20px;
            background-color: red;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.3s ease;
            display: block;
            margin: 20px auto;
            width: 100%;
            max-width: 200px;
        }

        .btn-logout:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>

<h2>Pilih Paket Diamond</h2>

<div class="diamond-cards">
    <?php
    // Ambil semua paket diamond dari database
    $stmt = $conn->query("SELECT * FROM ML_diamond");
    while ($row = $stmt->fetch_assoc()) {
        ?>
        <form method="POST" action="" class="diamond-card">
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>"> <!-- ID User dari sesi -->
            <input type="hidden" name="id_diamond" value="<?php echo $row['id_diamond']; ?>">
            <div class="card">
                <div class="card-content">
                    <h3><?php echo $row['jumlah_diamond']; ?> Diamond</h3>
                    <p>Rp <?php echo number_format($row['harga'], 2, ',', '.'); ?></p>
                    <button type="submit" class="btn-beli">Beli</button>
                </div>
            </div>
        </form>
        <?php
    }
    ?>
</div>

<!-- History Button -->
<div class="history-container">
    <a href="history.php">
        <button class="btn-history">Lihat History</button>
    </a>
    <!-- Logout Button -->
    <a href="?logout=true">
        <button class="btn-logout">Logout</button>
    </a>
</div>

</body>
</html>