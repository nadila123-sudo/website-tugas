<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Mahasiswa</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid black; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

<h2>Data Absensi Mahasiswa</h2>

<table>
    <tr>
        <th>No</th>
        <th>Nama Mahasiswa</th>
        <th>Mata Kuliah</th>
        <th>Hari</th>
        <th>Tanggal</th>
        <th>Waktu Masuk</th>
        <th>Waktu Keluar</th>
        <th>Status</th>
    </tr>

    <?php
    $sql = "SELECT Kehadiran.ID_Absensi, Mahasiswa.Nama, Mata_Kuliah.Nama_MK, Jadwal.Hari, 
                   Kehadiran.Tanggal, Kehadiran.Waktu_Masuk, Kehadiran.Waktu_Keluar, Kehadiran.Status 
            FROM Kehadiran
            JOIN Mahasiswa ON Kehadiran.NIM = Mahasiswa.NIM
            JOIN Jadwal ON Kehadiran.ID_Jadwal = Jadwal.ID_Jadwal
            JOIN Mata_Kuliah ON Jadwal.Kode_MK = Mata_Kuliah.Kode_MK";

    $result = mysqli_query($conn, $sql);
    $no = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$no++."</td>
                <td>".$row['Nama']."</td>
                <td>".$row['Nama_MK']."</td>
                <td>".$row['Hari']."</td>
                <td>".$row['Tanggal']."</td>
                <td>".$row['Waktu_Masuk']."</td>
                <td>".$row['Waktu_Keluar']."</td>
                <td>".$row['Status']."</td>
              </tr>";
    }
    ?>
</table>

</body>
</html>
