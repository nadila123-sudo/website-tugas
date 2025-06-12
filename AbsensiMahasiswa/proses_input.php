<?php
session_start();
include 'koneksi.php';

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari session, bukan POST
if (!isset($_SESSION['nim']) || !isset($_SESSION['nama'])) {
    echo "Session tidak ditemukan. Silakan login kembali.";
    exit();
}

$nim = $conn->real_escape_string($_SESSION['nim']);
$nama = $conn->real_escape_string($_SESSION['nama']);
$kode_mk = $conn->real_escape_string($_POST['kode_mk']);
$tanggal = $conn->real_escape_string($_POST['tanggal']);
$jenis_absensi = $conn->real_escape_string($_POST['jenis_absensi']);
$ulasan = ($jenis_absensi == "Hadir") ? "" : $conn->real_escape_string($_POST['ulasan']);

// Proses file upload
$bukti_surat = "";
if (!empty($_FILES["bukti_surat"]["name"])) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $filename = basename($_FILES["bukti_surat"]["name"]);
    $bukti_surat = $target_dir . time() . "_" . $filename;

    $allowed_types = [
        'image/jpeg', 
        'image/png', 
        'application/pdf', 
        'application/msword', 
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];

    if (in_array($_FILES["bukti_surat"]["type"], $allowed_types)) {
        if (!move_uploaded_file($_FILES["bukti_surat"]["tmp_name"], $bukti_surat)) {
            echo "Gagal meng-upload file.";
            exit();
        }
    } else {
        echo "Jenis file tidak diizinkan.";
        exit();
    }
}

// Simpan ke database
$query = "INSERT INTO absensi (nim, nama, kode_mk, tanggal, jenis_absensi, ulasan, bukti_surat) 
          VALUES ('$nim', '$nama', '$kode_mk', '$tanggal', '$jenis_absensi', '$ulasan', '$bukti_surat')";

if ($conn->query($query)) {
    header("Location: hasil.php");
    exit();
} else {
    echo "Terjadi kesalahan saat menyimpan data: " . $conn->error;
    exit();
}
?>
