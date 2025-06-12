<?php
include 'koneksi.php';
session_start();

$user_role = $_SESSION['role'] ?? 'mahasiswa'; // default mahasiswa

$validasi_berhasil = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user_role == 'dosen') {
    // Reset semua jadi belum disetujui
    mysqli_query($conn, "UPDATE absensi SET persetujuandosen = 'Belum Disetujui'");

    // Update yang diceklis jadi disetujui
    if (!empty($_POST['status'])) {
        $ids = $_POST['status'];
        $ids_sanitized = array_map('intval', $ids);
        $id_list = implode(',', $ids_sanitized);
        mysqli_query($conn, "UPDATE absensi SET persetujuandosen = 'Disetujui' WHERE id_absensi IN ($id_list)");
    }
    $validasi_berhasil = true;
}

// Ambil data absensi (semua user bisa lihat seluruh data)
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
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Hasil Absensi</title>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0; padding: 0; background: #f4f4f4;
}
.container {
    max-width: 900px;
    margin: 30px auto;
    background: white;
    padding: 20px;
    border-radius: 8px;
}
h2 {
    text-align: center;
    margin-bottom: 20px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}
th, td {
    border: 1px solid #ccc;
    padding: 10px;
    text-align: left;
}
th {
    background-color: #4b0082;
    color: white;
}
button {
    margin-top: 10px;
    padding: 10px 20px;
    background-color: #28a745;
    border: none;
    color: white;
    border-radius: 5px;
    cursor: pointer;
}
button:hover {
    background-color: #218838;
}
.tanggal {
    cursor: pointer;
    background-color: #6a0dad;
    color: white;
    padding: 10px;
    margin-top: 15px;
    border-radius: 5px;
}
.detail {
    display: none;
    margin-top: 10px;
}
</style>
<script>
function toggleDetail(id) {
    var el = document.getElementById(id);
    if(el.style.display === 'none' || el.style.display === '') {
        el.style.display = 'block';
    } else {
        el.style.display = 'none';
    }
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
    <h2>Rekapitulasi Absensi</h2>

    <?php if ($user_role == 'dosen'): ?>
    <form method="POST" action="hasil.php">
    <?php endif; ?>

    <?php foreach($data_per_tanggal as $tanggal => $absensi): ?>
        <div class="tanggal" onclick="toggleDetail('detail_<?php echo $tanggal; ?>')">
            <strong><?php echo $tanggal; ?></strong>
        </div>
        <div class="detail" id="detail_<?php echo $tanggal; ?>">
            <table>
                <tr>
                    <th><?php echo $user_role == 'dosen' ? 'Persetujuan' : 'Status'; ?></th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Mata Kuliah</th>
                    <th>Ulasan</th>
                    <th>Bukti Surat</th>
                </tr>
                <?php foreach($absensi as $row): ?>
                <tr>
                    <td>
                    <?php if ($user_role == 'dosen'): ?>
                        <input type="checkbox" name="status[]" value="<?php echo $row['id_absensi']; ?>" 
                            <?php echo ($row['persetujuandosen'] == 'Disetujui') ? 'checked' : ''; ?>>
                    <?php else: ?>
                        <?php 
                        if ($row['persetujuandosen'] == 'Disetujui') {
                            echo '✅ Sudah disetujui oleh dosen';
                        } else {
                            echo '⏳ (menunggu persetujuan oleh dosen)';
                        }
                        ?>
                    <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['nim']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['kode_mk']); ?></td>
                    <td><?php echo !empty($row['ulasan']) ? htmlspecialchars($row['ulasan']) : '-'; ?></td>
                    <td>
                        <?php if (!empty($row['bukti_surat'])): ?>
                            <a href="<?php echo htmlspecialchars($row['bukti_surat']); ?>" target="_blank">Lihat Surat</a>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    <?php endforeach; ?>

    <?php if ($user_role == 'dosen'): ?>
        <button type="submit">Simpan Persetujuan</button>
    </form>
    <?php endif; ?>

</div>

</body>
</html>
