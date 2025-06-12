<?php
include 'koneksi.php';
session_start();

if ($_SESSION['role'] !== 'dosen') {
    header("Location: index.php");
    exit;
}

$validasi_berhasil = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Reset semua jadi belum disetujui
    mysqli_query($conn, "UPDATE absensi SET persetujuandosen = 'Belum Disetujui'");

    // Update yang diceklis jadi disetujui
    if (!empty($_POST['status'])) {
        $ids = array_map('intval', $_POST['status']);
        $id_list = implode(',', $ids);
        mysqli_query($conn, "UPDATE absensi SET persetujuandosen = 'Disetujui' WHERE id_absensi IN ($id_list)");
    }
    $validasi_berhasil = true;
}

// Ambil semua data
$query = "SELECT * FROM absensi ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

$data_per_tanggal = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tanggal = date('Y-m-d', strtotime($row['tanggal']));
    $data_per_tanggal[$tanggal][] = $row;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<title>Rekap Absensi - Dosen</title>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px; background-color: #f9f9f9;
    }
    .container {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h2 {
        text-align: center;
        color: #333;
    }
    .tanggal {
        background-color: #007BFF;
        color: white;
        padding: 10px;
        margin-top: 15px;
        cursor: pointer;
        border-radius: 4px;
    }
    .tanggal:hover {
        background-color: #0056b3;
    }
    .detail {
        display: none;
        margin-top: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        overflow-x: auto;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }
    th, td {
        padding: 8px 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
    button {
        margin-top: 15px;
        padding: 10px 20px;
        background-color: #28a745;
        border: none;
        border-radius: 4px;
        color: white;
        font-size: 16px;
        cursor: pointer;
    }
    button:hover {
        background-color: #218838;
    }
    a {
        color: #007BFF;
        text-decoration: none;
    }
    a:hover {
        text-decoration: underline;
    }
</style>
<script>
    function toggleDetail(id) {
        var el = document.getElementById(id);
        el.style.display = (el.style.display === 'none' || el.style.display === '') ? 'block' : 'none';
    }
    window.onload = function() {
        <?php if ($validasi_berhasil): ?>
            alert("✅ Persetujuan berhasil disimpan!");
        <?php endif; ?>
    }
</script>
</head>
<body>
<div class="container">
    <h2>Rekapitulasi Absensi - Dosen</h2>
    <form method="POST" action="hasil_dosen.php">
        <?php foreach($data_per_tanggal as $tanggal => $absensi): ?>
            <div class="tanggal" onclick="toggleDetail('detail_<?php echo $tanggal; ?>')">
                <strong><?php echo $tanggal; ?></strong>
            </div>
            <div class="detail" id="detail_<?php echo $tanggal; ?>">
                <table>
                    <tr>
                        <th>Persetujuan</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Mata Kuliah</th>
                        <th>Ulasan</th>
                        <th>Bukti Surat</th>
                    </tr>
                    <?php foreach($absensi as $row): ?>
                    <tr>
                        <td>
                            <input type="checkbox" name="status[]" value="<?= $row['id_absensi']; ?>" <?= ($row['persetujuandosen'] == 'Disetujui') ? 'checked' : ''; ?>>
                        </td>
                        <td><?= htmlspecialchars($row['nim']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['kode_mk']); ?></td>
                        <td><?= $row['ulasan'] ?: '-'; ?></td>
                        <td>
                            <?php if (!empty($row['bukti_surat'])): ?>
                                <a href="<?= htmlspecialchars($row['bukti_surat']); ?>" target="_blank">Lihat Surat</a>
                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endforeach; ?>
        <button type="submit">Simpan Persetujuan</button>
    </form>
</div>
</body>
</html>
