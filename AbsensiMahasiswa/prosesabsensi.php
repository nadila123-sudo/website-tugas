<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_SESSION['nim'];
    $nama = $_SESSION['nama'];
    $kode_mk = $_POST['kode_mk'];
    $tanggal = $_POST['tanggal'];
    $jenis_absensi = $_POST['jenis_absensi'];
    $ulasan = $_POST['ulasan'];

    $bukti_surat = NULL;

    // Jika memilih "Sakit" dan ada file yang diunggah
    if ($jenis_absensi == "Sakit" && isset($_FILES['bukti_surat'])) {
        $file_name = $_FILES['bukti_surat']['name'];
        $file_tmp = $_FILES['bukti_surat']['tmp_name'];
        $file_path = "uploads/" . $file_name;

        if (move_uploaded_file($file_tmp, $file_path)) {
            $bukti_surat = $file_path;
        }
    }

    // Simpan ke database
    $query = "INSERT INTO Kehadiran (NIM, Kode_MK, Tanggal, Status, Bukti_Surat, Ulasan) 
              VALUES ('$nim', '$kode_mk', '$tanggal', '$jenis_absensi', '$bukti_surat', '$ulasan')";

    if (mysqli_query($conn, $query)) {
        header("Location: hasil.php");
        exit();
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
?>
