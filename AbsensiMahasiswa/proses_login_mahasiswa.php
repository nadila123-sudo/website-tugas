<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nim = $_POST['nim'];
    $password = $_POST['password'];

    // Amankan input dari SQL Injection
    $nim = $conn->real_escape_string($nim);
    $password = $conn->real_escape_string($password);

    // Cari data mahasiswa berdasarkan NIM
    $sql = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Cek password mahasiswa, jika menggunakan password yang di-hash
        if (password_verify($password, $row['password'])) {
            // Menyimpan data mahasiswa ke session
            $_SESSION['nim'] = $row['nim'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = 'mahasiswa'; 

            // Ambil data absensi berdasarkan NIM
            $sql_absensi = "SELECT * FROM absensi WHERE nim = '$nim'";
            $result_absensi = $conn->query($sql_absensi);

            if ($result_absensi->num_rows > 0) {
                // Menyimpan data absensi ke session
                $_SESSION['absensi'] = $result_absensi->fetch_all(MYSQLI_ASSOC);
            } else {
                $_SESSION['absensi'] = []; // Jika tidak ada data absensi
            }

            // Redirect ke halaman input_absensi.php
            header("Location: input_absensi.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Password salah!";
            header("Location: login_mahasiswa.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "NIM tidak ditemukan!";
        header("Location: login_mahasiswa.php");
        exit();
    }
}
$conn->close();
?>
