<?php
session_start();
if (!isset($_SESSION['nim']) || !isset($_SESSION['nama'])) {
    header("Location: login_mahasiswa.php");
    exit();
}
$nim = $_SESSION['nim'];
$nama = $_SESSION['nama'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Absensi Mahasiswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: #4b0082;
            color: white;
            animation: fadeIn 1s ease-in-out;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .container {
            width: 50%;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            backdrop-filter: blur(10px);
            box-shadow: 0 0 15px rgba(255, 255, 255, 0.2);
            text-align: left;
        }
        .logo {
            display: block;
            margin: 0 auto 20px;
            width: 80px;
            height: auto;
        }
        h2 {
            font-size: 24px;
            text-align: center;
            margin-top: 10px;
        }
        p {
            text-align: center;
            margin-top: -10px;
            margin-bottom: 20px;
            font-size: 16px;
        }
        table {
            width: 100%;
            margin-top: 15px;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            overflow: hidden;
        }
        table, th, td {
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        th, td {
            padding: 12px;
            text-align: left;
            color: white;
        }
        th {
            background: rgba(0, 0, 0, 0.3);
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: none;
            background: rgba(255, 255, 255, 0.3);
            color: white;
            font-size: 16px;
        }
        select {
            background: rgba(100, 100, 255, 0.7);
        }
        .hidden {
            display: none;
        }
        .btn {
            padding: 12px;
            font-size: 16px;
            border: none;
            width: 100%;
            cursor: pointer;
            font-weight: bold;
            border-radius: 6px;
            transition: 0.3s;
        }
        .btn:hover {
            transform: scale(1.05);
        }
        .btn-submit {
            background: #28a745;
            color: white;
        }
        .btn-cancel {
            background: #dc3545;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="logopolmed.png" alt="Logo Polmed" class="logo">
    <h2>📌 Form Absensi Mahasiswa 📌</h2>
    <p>Halo, <strong><?= htmlspecialchars($nama) ?></strong> (NIM: <?= htmlspecialchars($nim) ?>)</p>

    <form method="POST" action="proses_input.php" enctype="multipart/form-data">
        <table>
            <tr>
                <th>Mata Kuliah</th>
                <td>
                    <select name="kode_mk" required>
                        <option value="">Pilih Mata Kuliah</option>
                        <optgroup label="Senin">
                            <option value="MK001">MK001 - Manajemen Database Client/Server</option>
                            <option value="MK002">MK002 - Praktik Manajemen Database Client/Server</option>
                        </optgroup>
                        <optgroup label="Selasa">
                            <option value="MK003">MK003 - Analisis dan Perancangan Sistem Informasi</option>
                            <option value="MK004">MK004 - Teknik Riset Operasi</option>
                        </optgroup>
                        <optgroup label="Rabu">
                            <option value="MK005">MK005 - Pemrograman Aplikasi Mobile</option>
                        </optgroup>
                        <optgroup label="Kamis">
                            <option value="MK006">MK006 - Pemrograman Web Lanjut</option>
                        </optgroup>
                        <optgroup label="Jumat">
                            <option value="MK007">MK007 - Etika Profesi Teknologi Informasi</option>
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Tanggal</th>
                <td><input type="date" name="tanggal" required></td>
            </tr>
            <tr>
                <th>Jenis Absensi</th>
                <td>
                    <select name="jenis_absensi" id="jenis_absensi" required onchange="toggleUlasan()">
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                    </select>
                </td>
            </tr>
            <tr id="ulasanRow" class="hidden">
                <th>Keterangan Ulasan</th>
                <td><textarea name="ulasan" id="ulasan" rows="3" placeholder="Jelaskan alasan izin/sakit..."></textarea></td>
            </tr>
            <tr id="buktiRow" class="hidden">
                <th>Upload Bukti Surat</th>
                <td><input type="file" name="bukti_surat" id="bukti_surat"></td>
            </tr>
        </table>
        <br>
        <button type="submit" class="btn btn-submit">Simpan</button>
        <button type="reset" class="btn btn-cancel">Batal</button>
    </form>
</div>

<script>
    function toggleUlasan() {
        let jenisAbsensi = document.getElementById("jenis_absensi").value;
        let ulasanRow = document.getElementById("ulasanRow");
        let buktiRow = document.getElementById("buktiRow");

        if (jenisAbsensi === "Izin" || jenisAbsensi === "Sakit") {
            ulasanRow.classList.remove("hidden");
            buktiRow.classList.remove("hidden");
        } else {
            ulasanRow.classList.add("hidden");
            buktiRow.classList.add("hidden");
        }
    }
</script>

</body>
</html>
