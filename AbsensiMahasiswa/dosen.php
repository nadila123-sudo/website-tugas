<?php
// Koneksi ke database
$host = 'localhost'; // Ganti dengan host database Anda
$user = 'root'; // Ganti dengan username MySQL Anda
$password = ''; // Ganti dengan password MySQL Anda
$database = 'absensimahasiswa'; // Ganti dengan nama database Anda

// Koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database);

// Periksa apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data absensi
$query = "SELECT * FROM absensi"; // Sesuaikan dengan filter yang diinginkan, seperti berdasarkan kode mata kuliah
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Absensi Mahasiswa</title>
    <style>
        /* Reset default margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Pengaturan body */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            padding: 20px;
        }

        /* Container utama */
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Judul halaman */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #2d3e50;
        }

        /* Tabel untuk menampilkan data absensi */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        /* Header tabel */
        th {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: left;
        }

        /* Baris data tabel */
        td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        /* Style untuk select status */
        select {
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 100%;
        }

        /* Button submit */
        input[type="submit"] {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            width: 100%;
            margin-top: 20px;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        /* Style untuk input checkbox */
        input[type="checkbox"] {
            width: 20px;
            height: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Rekap Absensi Mahasiswa</h2>
        <form method="POST" action="update_status.php">
            <table>
                <thead>
                    <tr>
                        <th>Validasi</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Mata Kuliah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr>
                            <td><input type="checkbox" name="validasi[<?php echo $row['id_absensi']; ?>]" <?php echo ($row['validasi'] == 1) ? 'checked' : ''; ?>></td>
                            <td><?php echo $row['nim']; ?></td>
                            <td><?php echo $row['nama']; ?></td>
                            <td><?php echo $row['kode_mk']; ?></td>
                            <td>
                                <select name="status[<?php echo $row['id_absensi']; ?>]">
                                    <option value="Hadir" <?php echo ($row['status'] == 'Hadir') ? 'selected' : ''; ?>>Hadir</option>
                                    <option value="Tidak Hadir" <?php echo ($row['status'] == 'Tidak Hadir') ? 'selected' : ''; ?>>Tidak Hadir</option>
                                    <option value="Sakit" <?php echo ($row['status'] == 'Sakit') ? 'selected' : ''; ?>>Sakit</option>
                                    <option value="Izin" <?php echo ($row['status'] == 'Izin') ? 'selected' : ''; ?>>Izin</option>
                                </select>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <input type="submit" value="Update Status">
        </form>
    </div>

    <?php
    // Update status jika form dikirim
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST['status'] as $id_absensi => $status) {
            // Update status kehadiran mahasiswa
            $query = "UPDATE absensi SET status = ?, validasi = 1, tanggal_validasi = NOW(), dosen_validasi = 'Dosen' WHERE id_absensi = ?";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, 'si', $status, $id_absensi);
            mysqli_stmt_execute($stmt);
        }
        echo "<script>alert('Status kehadiran berhasil diperbarui.'); window.location.href='dosen.php';</script>";
    }
    ?>
</body>
</html>

<?php
// Menutup koneksi database
mysqli_close($koneksi);
?>
