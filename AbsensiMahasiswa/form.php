<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $_SESSION['nim'] = $_POST['nim'];
    $_SESSION['nama'] = $_POST['nama'];
}

if (!isset($_SESSION['nim'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kehadiran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            text-align: center;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            width: 50%;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
        label { display: block; text-align: left; margin-left: 10px; }
        input, select, textarea {
            width: 90%;
            padding: 10px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            outline: none;
        }
        .btn {
            background: #ffc107;
            color: black;
            padding: 10px;
            border: none;
            width: 100%;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
        }
        .btn:hover { background: #e0a800; }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Kehadiran Mahasiswa</h2>
    <form action="proses_absensi.php" method="POST" enctype="multipart/form-data">
        <label>Mata Kuliah:</label>
        <select name="kode_mk" required>
            <option value="">Pilih Mata Kuliah</option>
            <?php
            $query = "SELECT Kode_MK, Nama_MK FROM Mata_Kuliah";
            $result = mysqli_query($conn, $query);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='".$row['Kode_MK']."'>".$row['Nama_MK']."</option>";
            }
            ?>
        </select>

        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>

        <label>Jenis Absensi:</label>
        <select name="jenis_absensi" id="jenis_absensi" onchange="toggleUpload()">
            <option value="Hadir">Hadir</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
            <option value="Alpha">Alpha</option>
        </select>

        <!-- Input untuk upload bukti sakit -->
        <div id="upload_bukti" style="display: none;">
            <label>Unggah Bukti Sakit (PDF/Gambar):</label>
            <input type="file" name="bukti_surat" accept=".jpg,.jpeg,.png,.pdf">
        </div>

        <!-- Input untuk ulasan -->
        <label>Ulasan:</label>
        <textarea name="ulasan" rows="3" placeholder="Tambahkan ulasan atau keterangan..."></textarea>

        <input type="submit" class="btn" value="Simpan">
    </form>
</div>

<script>
    function toggleUpload() {
        var jenisAbsensi = document.getElementById("jenis_absensi").value;
        var uploadBukti = document.getElementById("upload_bukti");

        if (jenisAbsensi === "Sakit") {
            uploadBukti.style.display = "block";
        } else {
            uploadBukti.style.display = "none";
        }
    }
</script>

</body>
</html>
