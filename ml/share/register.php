<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Enkripsi password
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $role = 'pengguna'; // Default role

    // Cegah SQL Injection
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $nama_lengkap = $conn->real_escape_string($nama_lengkap);

    // Masukkan data ke database
    $sql = "INSERT INTO ML_user (username, password, email, role, nama_lengkap) 
            VALUES ('$username', '$password', '$email', '$role', '$nama_lengkap')";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php"); // Redirect ke halaman login
        exit;
    } else {
        $error = "Terjadi kesalahan: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(120deg, #3498db, #8e44ad);
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        input {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus {
            border-color: #3498db;
            outline: none;
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
        }

        button {
            padding: 10px;
            background: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: #2c81ba;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 15px;
        }

        @media (max-width: 480px) {
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="nama_lengkap">Nama Lengkap:</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" required>

            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
