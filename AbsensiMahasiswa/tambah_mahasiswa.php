<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];

    $sql = "INSERT INTO Mahasiswa (NIM, Nama) VALUES ('$nim', '$nama')";

    if (mysqli_query($conn, $sql)) {
        echo "<p class='success'>Mahasiswa berhasil ditambahkan!</p>";
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; background-color: #f4f4f4; }
        .container { width: 40%; background: white; padding: 20px; margin: 50px auto; border-radius: 8px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        h2 { margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        label { font-weight: bold; display: block; }
        input { width: 100%; padding: 8px; margin-top: 5px; border: 1px solid #ccc; border-radius: 5px; }
        .btn { background: #007bff; color: white; padding: 10px; border: none; width: 100%; cursor: pointer; font-size: 16px; border-radius: 5px; }
        .btn:hover { background: #0056b3; }
        .success { color: green; font-weight: bold; margin-top: 10px; }
        .error { color: red; font-weight: bold; margin-top: 10px; }
    </style>
</head>
<body>

<div class="container">
    <h2>Tambah Mahasiswa</h2>
    
    <form method="POST">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" name="nim" id="nim" required>
        </div>

        <div class="form-group">
            <label for="nama">Nama Mahasiswa:</label>
            <input type="text" name="nama" id="nama" required>
        </div>

        <input type="submit" class="btn" value="Simpan">
    </form>
</div>

</body>
</html>



include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];

    // Cek apakah mahasiswa sudah ada
    $cek = mysqli_query($conn, "SELECT * FROM Mahasiswa WHERE NIM = '$nim'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<p class='error'>Mahasiswa dengan NIM tersebut sudah terdaftar!</p>";
    } else {
        $sql = "INSERT INTO Mahasiswa (NIM, Nama) VALUES ('$nim', '$nama')";
        if (mysqli_query($conn, $sql)) {
            echo "<p class='success'>Mahasiswa berhasil ditambahkan!</p>";
        } else {
            echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>
