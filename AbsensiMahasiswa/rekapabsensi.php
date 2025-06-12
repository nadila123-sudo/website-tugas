<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['nim']) || !isset($_SESSION['nama'])) {
    header("Location: index.php");
    exit();
}

// Ambil daftar tanggal yang tersedia dalam absensi tanpa waktu
$tanggal_result = mysqli_query($conn, "SELECT DISTINCT DATE(Tanggal) AS Tanggal FROM Absensi ORDER BY Tanggal DESC");

// Ambil tanggal yang dipilih oleh user (default: hari ini)
$tanggal_terpilih = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

// Ambil data absensi berdasarkan tanggal yang dipilih
$query = "SELECT Absensi.NIM, Mahasiswa.Nama, Mata_Kuliah.Nama_MK, Absensi.Status
          FROM Absensi 
          JOIN Mahasiswa ON Absensi.NIM = Mahasiswa.NIM
          JOIN Jadwal ON Absensi.ID_Jadwal = Jadwal.ID_Jadwal
          JOIN Mata_Kuliah ON Jadwal.Kode_MK = Mata_Kuliah.Kode_MK
          WHERE DATE(Absensi.Tanggal) = '$tanggal_terpilih'
          ORDER BY Mata_Kuliah.Nama_MK, Mahasiswa.Nama";

$result = mysqli_query($conn, $query);

// Ambil jumlah mahasiswa hadir per mata kuliah
$count_query = "SELECT Mata_Kuliah.Nama_MK, COUNT(*) AS Total_Hadir
                FROM Absensi
                JOIN Jadwal ON Absensi.ID_Jadwal = Jadwal.ID_Jadwal
                JOIN Mata_Kuliah ON Jadwal.Kode_MK = Mata_Kuliah.Kode_MK
                WHERE DATE(Absensi.Tanggal) = '$tanggal_terpilih' AND Absensi.Status = 'Hadir'
                GROUP BY Mata_Kuliah.Nama_MK";

$count_result = mysqli_query($conn, $count_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        h2 {
            margin-bottom: 10px;
            font-weight: 600;
        }

        select, button {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        button {
            background: #007bff;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: center;
        }

        th {
            background: #007bff;
            color: white;
        }

        .total-box {
            margin-top: 15px;
            padding: 10px;
            background: #ffcccb;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Rekap Absensi</h2>
    
    <!-- Filter Tanggal -->
    <form method="GET">
        <select name="tanggal">
            <?php while ($tanggal = mysqli_fetch_assoc($tanggal_result)): ?>
                <option value="<?= $tanggal['Tanggal'] ?>" <?= ($tanggal['Tanggal'] == $tanggal_terpilih) ? 'selected' : '' ?>>
                    <?= $tanggal['Tanggal'] ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Lihat</button>
    </form>

    <!-- Tabel Data Absensi -->
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Mata Kuliah</th>
            <th>Status</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['NIM'] ?></td>
                <td><?= $row['Nama'] ?></td>
                <td><?= $row['Nama_MK'] ?></td>
                <td><?= $row['Status'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Jumlah Mahasiswa Hadir -->
    <h3>📊 Statistik Kehadiran</h3>
    <?php while ($count = mysqli_fetch_assoc($count_result)): ?>
        <div class="total-box">
            Mata Kuliah: <strong><?= $count['Nama_MK'] ?></strong> | Hadir: <strong><?= $count['Total_Hadir'] ?></strong> mahasiswa
        </div>
    <?php endwhile; ?>
</div>

</body>
</html>
