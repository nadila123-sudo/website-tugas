<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$password = ''; // Ganti jika ada
$database = 'absensimahasiswa';

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Proses update status
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['status'] as $id_absensi => $status) {
        $validasi = isset($_POST['validasi'][$id_absensi]) ? 1 : 0;

        $query = "UPDATE absensi SET status = ?, validasi = ?, tanggal_validasi = NOW(), dosen_validasi = 'Dosen' WHERE id_absensi = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, 'sii', $status, $validasi, $id_absensi);
        mysqli_stmt_execute($stmt);
    }

    // Redirect kembali ke halaman dosen.php
    echo "<script>alert('Status kehadiran berhasil diperbarui.'); window.location.href='dosen.php';</script>";
}

// Tutup koneksi
mysqli_close($koneksi);
?>
