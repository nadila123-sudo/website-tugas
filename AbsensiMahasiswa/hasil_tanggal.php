<?php
include 'koneksi.php';

// Ambil tanggal dari URL
$tanggal = $_GET['tanggal'] ?? '';

if (!$tanggal) {
    echo "Tanggal tidak valid.";
    exit;
}

// Ambil data absensi berdasarkan tanggal
$result = mysqli_query($conn, "SELECT * FROM absensi WHERE tanggal = '$tanggal'");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Absensi - <?php echo $tanggal; ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4b0082, #1e90ff);
            color: white;
            text-align: center;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            border: 1px solid white;
        }
        th {
            background: rgba(255, 255, 255, 0.3);
        }
        .status-hadir {
            background: green;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
        .status-izin {
            background: orange;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
        .status-sakit {
            background: blue;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h2>📄 Hasil Absensi - <?php echo $tanggal; ?> 📄</h2>
    <table>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Ulasan</th>
            <th>Bukti Surat</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo $row['nim']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td>
                    <span class="status-<?php echo strtolower($row['status']); ?>">
                        <?php echo $row['status']; ?>
                    </span>
                </td>
                <td>
                    <?php 
                    if ($row['status'] == 'Izin' || $row['status'] == 'Sakit') {
                        echo $row['ulasan'] ?: '-'; // Jika kosong, tampilkan "-"
                    } else {
                        echo "-"; // Hadir tidak perlu ulasan
                    }
                    ?>
                </td>
                <td>
                    <?php 
                    if (($row['status'] == 'Izin' || $row['status'] == 'Sakit') && !empty($row['bukti_surat'])) {
                        echo "<a href='uploads/{$row['bukti_surat']}' target='_blank' style='color: yellow;'>Lihat Surat</a>";
                    } else {
                        echo "-"; // Hadir atau jika bukti surat kosong, tampilkan "-"
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="hasil.php" style="color: yellow; font-weight: bold;">⬅ Kembali ke Rekap Absensi</a>
</body>
</html>
