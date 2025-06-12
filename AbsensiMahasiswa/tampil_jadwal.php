<?php
include 'koneksi.php';

$sql = "SELECT ID_Jadwal, Kode_MK, Hari, Jam, Ruang FROM Jadwal";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Perkuliahan</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
        th { background: #007bff; color: white; }
    </style>
</head>
<body>

<h2>Jadwal Perkuliahan</h2>
<table>
    <tr>
        <th>ID Jadwal</th>
        <th>Kode Mata Kuliah</th>
        <th>Hari</th>
        <th>Jam</th>
        <th>Ruang</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <tr>
        <td><?= $row['ID_Jadwal'] ?></td>
        <td><?= $row['Kode_MK'] ?></td>
        <td><?= $row['Hari'] ?></td>
        <td><?= $row['Jam'] ?></td>
        <td><?= $row['Ruang'] ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
