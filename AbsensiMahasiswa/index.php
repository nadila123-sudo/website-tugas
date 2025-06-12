<?php
session_start();

// Cek apakah ada data yang dimasukkan
$login_error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : false;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sistem Kehadiran Mahasiswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: url('pesawatpolmed.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            text-align: center;
            color: #fff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            animation: float 3s ease-in-out infinite alternate;
        }

        @keyframes float {
            from { transform: translateY(0px); }
            to   { transform: translateY(10px); }
        }

        .logo {
            width: 90px;
            margin-bottom: 15px;
        }

        .judul {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
            opacity: 0;
            animation: fadeInText 2s ease-in forwards;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        @keyframes fadeInText {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            padding: 12px;
            margin-top: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-mahasiswa {
            background-color: #28a745;
        }

        .btn-dosen {
            background-color: #ffc107;
            color: black;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.6);
        }

        .alert {
            color: red;
            font-size: 14px;
            margin-top: 20px;
        }

        .daftar {
            margin-top: 20px;
            font-size: 14px;
            color: #ff5733;
            text-decoration: underline;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="logopolmed.png" alt="Logo Polmed" class="logo">
    <div class="judul">Sistem Kehadiran Mahasiswa</div>

    <!-- Form untuk login sebagai mahasiswa -->
    <form action="login_mahasiswa.php" method="post">
        <button type="submit" class="btn btn-mahasiswa">Login sebagai Mahasiswa</button>
    </form>

    <!-- Form untuk login sebagai dosen -->
    <form action="login.php" method="post">
        <button type="submit" class="btn btn-dosen">Login sebagai Dosen</button>
    </form>

    <!-- Menampilkan bagian daftar -->
    <div class="daftar">
        Jika belum memiliki akun, <a href="daftar.php">Daftar di sini</a>
    </div>

</div>

</body>
</html>
