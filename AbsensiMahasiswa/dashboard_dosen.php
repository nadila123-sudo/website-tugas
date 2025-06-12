<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'dosen') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Dosen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            padding: 30px;
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .btn {
            padding: 12px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(0, 255, 0, 0.5);
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Selamat datang, Dosen</h1>
    <p>Anda telah berhasil login ke sistem kehadiran mahasiswa.</p>

    <!-- Menu dashboard -->
    <div>
        <a href="rekap_absensi.php">
            <button class="btn">Lihat Rekap Kehadiran</button>
        </a>
        <a href="logout.php">
            <button class="btn">Logout</button>
        </a>
    </div>
</div>

</body>
</html>
