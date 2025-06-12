<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nism = $_POST['nism'];
    $password = $_POST['password'];

    // Cek dosen dulu
    $stmt = $conn->prepare("SELECT * FROM dosen WHERE nism = ?");
    $stmt->bind_param("s", $nism);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['nism'] = $row['nism'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = 'dosen';
            header("Location: hasil_dosen.php");
            exit();
        }
    } else {
        // Cek mahasiswa jika bukan dosen
        $stmt2 = $conn->prepare("SELECT * FROM mahasiswa WHERE nim = ?");
        $stmt2->bind_param("s", $nism);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows === 1) {
            $row2 = $result2->fetch_assoc();
            if (password_verify($password, $row2['password'])) {
                $_SESSION['nim'] = $row2['nim'];
                $_SESSION['nama'] = $row2['nama'];
                $_SESSION['role'] = 'dosen';
                header("Location: hasil.php");
                exit();
            }
        }
    }
    
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Dosen</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('pesawatpolmed.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .container {
            padding: 30px;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        .logo {
            width: 90px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        .btn {
            padding: 12px;
            width: 100%;
            font-size: 16px;
            background-color: #ffc107;
            color: black;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.6);
        }

        .alert {
            color: red;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="logopolmed.png" alt="Logo Polmed" class="logo">
    <h2>Login Dosen</h2>

    <!-- Tampilkan pesan error jika ada -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert"><?= $_SESSION['login_error']; ?></div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nism">NISM</label>
            <input type="text" id="nism" name="nism" placeholder="Masukkan NISM" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
        </div>

        <button type="submit" class="btn">Login</button>
    </form>
</div>

</body>
</html>
