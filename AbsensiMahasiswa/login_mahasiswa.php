<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background: url('pesawatpolmed.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1;
        }

        .container {
            position: relative;
            z-index: 2;
            width: 90%;
            max-width: 400px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.15);o0
            backdrop-filter: blur(10px);
            border-radius: 15px;
            text-align: center;
            color: #fff;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
        }

        .logo {
            width: 90px;
            margin-bottom: 15px;
        }

        .judul {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 25px;
            opacity: 0;
            animation: fadeInText 2s ease-in forwards;
            text-shadow: 0 0 10px rgba(255, 255, 255, 0.8);
        }

        @keyframes fadeInText {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 12px 0;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        .btn {
            padding: 12px;
            margin-top: 12px;
            width: 100%;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            color: white;
            transition: all 0.3s ease;
            background-color: #28a745;
        }

        .btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 12px rgba(255, 255, 255, 0.6);
        }

        .alert {
            color: red;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="judul">Login Mahasiswa</h2>
    
    <form action="proses_login_mahasiswa.php" method="post">
        <label for="nim">NIM:</label>
        <input type="text" name="nim" id="nim" required placeholder="Masukkan NIM Anda">

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required placeholder="Masukkan Password">

        <button type="submit" class="btn">Login</button>
    </form>

    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert">
            <?php
                echo $_SESSION['login_error'];
                unset($_SESSION['login_error']);
            ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

