<?php
$servername = "localhost";
$username = "root"; // Username MySQL
$password = ""; // Password MySQL
$dbname = "absensimahasiswa"; // Nama database

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
