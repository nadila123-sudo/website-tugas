<?php
session_start();
include 'koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['nim']) || !isset($_SESSION['nama'])) {
    header("Location: index.php");
    exit();
}

// Ambil daftar mata kuliah dari database
$jadwal_result = mysqli_query($conn, "SELECT ID_Jadwal, Hari, Nama_MK 
                                      FROM Jadwal 
                                      JOIN Mata_Kuliah ON Jadwal.Kode_MK = Mata_Kuliah.Kode_MK");

// Simpan data kehadiran
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_SESSION['nim'];
    $id_jadwal = $_POST['id_jadwal'];
    $status = $_POST['status'];
    $ulasan = $_POST['ulasan'] ?? "";
    $tanggal = date('Y-m-d'); // Simpan tanggal otomatis

    // Upload bukti surat jika ada
    $bukti_surat = "";
    if (isset($_FILES["bukti_surat"]) && $_FILES["bukti_surat"]["error"] == 0) {
        $target_dir = "uploads/";
        $bukti_surat = $target_dir . basename($_FILES["bukti_surat"]["name"]);
        move_uploaded_file($_FILES["bukti_surat"]["tmp_name"], $bukti_surat);
    }

    // Masukkan ke database
    $query = "INSERT INTO Absensi (NIM, ID_Jadwal, Status, Bukti_Surat, Ulasan, Tanggal) 
              VALUES ('$nim', '$id_jadwal', '$status', '$bukti_surat', '$ulasan', '$tanggal')";

    if (mysqli_query($conn, $query)) {
        header("Location: hasil_mahasiswa.php"); // Redirect otomatis setelah input
        exit();
    } else {
        $error = "Terjadi kesalahan: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Kehadiran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            width: 400px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }

        h2 {
            margin-bottom: 15px;
            font-weight: 600;
        }

        select, input, textarea, button {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        select, input, textarea {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }

        button {
            background: #ff6f61;
            color: white;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #e55b50;
            transform: scale(1.05);
        }

        .error {
            color: #ff4d4d;
            font-weight: bold;
        }

        .success {
            color: #2ecc71;
            font-weight: bold;
        }

        .user-info {
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>📌 Tambah Kehadiran</h2>
    <p class="user-info">👤 Nama: <strong><?= $_SESSION['nama'] ?></strong> | 🎓 NIM: <strong><?= $_SESSION['nim'] ?></strong></p>

    <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <select name="id_jadwal" required>
            <option value="" disabled selected>📖 Pilih Mata Kuliah</option>
            <?php while ($jadwal = mysqli_fetch_assoc($jadwal_result)): ?>
                <option value="<?= $jadwal['ID_Jadwal'] ?>">📚 <?= $jadwal['Nama_MK'] ?> - 🗓 <?= $jadwal['Hari'] ?></option>
            <?php endwhile; ?>
        </select>

        <select name="status" required>
            <option value="Hadir">✅ Hadir</option>
            <option value="Sakit">🤒 Sakit</option>
            <option value="Izin">✉️ Izin</option>
        </select>

        <input type="file" name="bukti_surat">
        <textarea name="ulasan" rows="3" placeholder="📝 Tulis ulasan..."></textarea>

        <button type="submit">📌 Simpan Kehadiran</button>
    </form>
</div>

</body>
</html>
