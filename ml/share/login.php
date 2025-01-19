<?php
include 'koneksi.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cegah SQL Injection
    $username = $conn->real_escape_string($username);

    // Ambil data user dari database
    $sql = "SELECT * FROM ML_user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan informasi user di sesi
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect berdasarkan role
            if ($user['role'] === 'admin') {
                header("Location: /ml/admin/admin_read.php"); // Halaman dashboard admin
            } else if ($user['role'] === 'pengguna') {
                header("Location:/ml/user/user.php"); // Halaman dashboard pengguna
            }
            exit;
        } else {
            $error = "Password salah.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #333;
        }

        .login-container {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h2 {
            margin-bottom: 1.5rem;
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.5rem;
            font-weight: bold;
        }

        input {
            padding: 0.75rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        button {
            padding: 0.75rem;
            border: none;
            border-radius: 5px;
            background: #2575fc;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #6a11cb;
        }

        p {
            text-align: center;
            color: red;
            font-weight: bold;
        }

        .register-link {
            text-align: center;
            margin-top: 1rem;
        }

        .register-link a {
            color: #2575fc;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
        </form>

        <!-- Link to the register page -->
        <div class="register-link">
            <p>Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
        </div>
    </div>
</body>
</html>
