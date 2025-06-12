<?php
include 'koneksi.php';

// Ambil semua data kehadiran yang telah diinput
$sql = "SELECT k.ID_Kehadiran, j.Hari, mk.Nama_MK, k.Tanggal, k.Status, k.Bukti_Surat, k.Ulasan 
        FROM Kehadiran k 
        JOIN Jadwal j ON k.ID_Jadwal = j.ID_Jadwal 
        JOIN Mata_Kuliah mk ON j.Kode_MK = mk.Kode_MK 
        ORDER BY k.Tanggal DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kehadiran</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #ff9a9e, #fad0c4); text-align: center; padding: 20px; color: white; }
        .container { width: 90%; background: rgba(255, 255, 255, 0.2); padding: 20px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); margin: auto; }
        table { width: 100%; border-collapse: collapse; background: rgba(255, 255, 255, 0.3); color: black; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid white; text-align: center; }
        th { background: rgba(255, 255, 255, 0.4); }
        tr:nth-child(even) { background: rgba(255, 255, 255, 0.2); }
        .btn { background: #007bff; color: white; padding: 10px; border: none; cursor: pointer; font-size: 16px; border-radius: 5px; text-decoration: none; display: inline-block; }
        .btn:hover { background: #0056b3; }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Data Kehadiran</h2>
    <table>
        <tr>
            <th>Mata Kuliah</th>
            <th>Hari</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Bukti Sakit</th>
            <th>Ulasan</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['Nama_MK'] ?></td>
            <td><?= $row['Hari'] ?></td>
            <td><?= $row['Tanggal'] ?></td>
            <td><?= $row['Status'] ?></td>
            <td>
                <?php if (!empty($row['Bukti_Surat'])): ?>
                    <a href="<?= $row['Bukti_Surat'] ?>" target="_blank">Lihat</a>
                <?php else: ?>
                    Tidak Ada
                <?php endif; ?>
            </td>
            <td><?= $row['Ulasan'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="index.php" class="btn">🔙 Kembali ke Beranda</a>
</div>

</body>
</html>
