<?php
session_start();
require_once 'koneksi.php';

// Aktifkan error reporting untuk memudahkan debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Request Method: POST<br>";  // Debugging log
    $role = $_POST['role'];
    $name = htmlspecialchars(trim($_POST['name']));
    $password = htmlspecialchars(trim($_POST['password']));
    $nim = isset($_POST['nim']) ? htmlspecialchars(trim($_POST['nim'])) : null;
    $nism = isset($_POST['nism']) ? htmlspecialchars(trim($_POST['nism'])) : null;

    // Validasi input
    if (empty($name) || empty($password) || 
        ($role == 'mahasiswa' && empty($nim)) || 
        ($role == 'dosen' && empty($nism))) {
        echo "<script>alert('Semua kolom wajib diisi!'); window.location.href = 'daftar.php';</script>";
        exit();
    }

    if (strlen($password) < 8) {
        echo "<script>alert('Password minimal 8 karakter!'); window.location.href = 'daftar.php';</script>";
        exit();
    }

    echo "Input Validasi berhasil, lanjut ke hash password<br>";  // Debugging log
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validasi mahasiswa
    if ($role === 'mahasiswa') {
        echo "Cek NIM mahasiswa<br>";  // Debugging log
        $cek = $conn->prepare("SELECT nim FROM mahasiswa WHERE nim = ?");
        $cek->bind_param("s", $nim);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            echo "<script>alert('NIM sudah terdaftar!'); window.location.href = 'daftar.php';</script>";
            exit();
        }
        $cek->close();

        $stmt = $conn->prepare("INSERT INTO mahasiswa (nama, nim, password) VALUES (?, ?, ?)");
        if ($stmt) {
            echo "Pendaftaran mahasiswa berhasil<br>";  // Debugging log
            $stmt->bind_param("sss", $name, $nim, $hashed_password);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('Pendaftaran mahasiswa berhasil!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Gagal prepare insert mahasiswa: " . $conn->error . "'); window.location.href = 'daftar.php';</script>";
        }
    }
    // Validasi dosen
    elseif ($role === 'dosen') {
        echo "Cek NISM dosen<br>";  // Debugging log
        $cek = $conn->prepare("SELECT nism FROM dosen WHERE nism = ?");
        $cek->bind_param("s", $nism);
        $cek->execute();
        $cek->store_result();
        if ($cek->num_rows > 0) {
            echo "<script>alert('NISM sudah terdaftar!'); window.location.href = 'daftar.php';</script>";
            exit();
        }
        $cek->close();

        $stmt = $conn->prepare("INSERT INTO dosen (nama, nism, password) VALUES (?, ?, ?)");
        if ($stmt) {
            echo "Pendaftaran dosen berhasil<br>";  // Debugging log
            $stmt->bind_param("sss", $name, $nism, $hashed_password);
            $stmt->execute();
            $stmt->close();
            echo "<script>alert('Pendaftaran dosen berhasil!'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Gagal prepare insert dosen: " . $conn->error . "'); window.location.href = 'daftar.php';</script>";
        }
    }

    $conn->close();
} else {
    echo "<script>alert('Akses tidak sah!'); window.location.href = 'daftar.php';</script>";
}
?>
