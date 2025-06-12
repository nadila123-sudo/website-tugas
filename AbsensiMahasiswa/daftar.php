<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pengguna</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: url('pesawatpolmed.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(15px);
            padding: 30px 40px;
            border-radius: 15px;
            width: 350px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            text-align: center;
        }
        h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 20px;
            font-weight: 600;
        }
        label {
            color: #333;
            font-size: 16px;
            margin-bottom: 5px;
            display: inline-block;
            text-align: left;
            width: 100%;
        }
        input, select {
            width: 100%;
            padding: 12px 20px;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 16px;
            transition: all 0.3s ease-in-out;
        }
        input:focus, select:focus {
            border-color: dodgerblue;
            box-shadow: 0 0 8px rgba(30, 144, 255, 0.7);
            outline: none;
        }
        button {
            background-color: #00bcd4;
            color: white;
            padding: 12px 20px;
            border: none;
            width: 100%;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s ease-in-out;
        }
        button:hover {
            background-color: #0097a7;
        }
        a {
            color: #ff6347;
            text-decoration: none;
            margin-top: 20px;
            display: block;
            font-size: 14px;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        @media (max-width: 400px) {
            .container {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <form class="container" action="daftar_proses.php" method="post">
        <h2>Pendaftaran Pengguna</h2>
        <label for="role">Pilih sebagai:</label>
        <select name="role" id="role" required>
            <option value="mahasiswa">Mahasiswa</option>
            <option value="dosen">Dosen</option>
        </select>

        <label for="name">Nama:</label>
        <input type="text" name="name" id="name" placeholder="Nama Lengkap" required>

        <div id="nim-field">
            <label for="nim">NIM:</label>
            <input type="text" name="nim" id="nim" placeholder="Nomor Induk Mahasiswa" required>
        </div>

        <div id="nism-field" style="display: none;">
            <label for="nism">NISM:</label>
            <input type="text" name="nism" id="nism" placeholder="Nomor Induk Dosen">
        </div>

        <label for="password">Kata Sandi:</label>
        <input type="password" name="password" id="password" placeholder="Minimal 8 karakter" minlength="8" required>

        <button type="submit">Daftar</button>
        <a href="index.php">Kembali ke halaman utama</a>
    </form>

    <script>
        const roleSelect = document.getElementById('role');
        const nimField = document.getElementById('nim-field');
        const nismField = document.getElementById('nism-field');

        roleSelect.addEventListener('change', function () {
            if (this.value === 'mahasiswa') {
                nimField.style.display = 'block';
                nismField.style.display = 'none';
                document.getElementById('nim').required = true;
                document.getElementById('nism').required = false;
            } else {
                nimField.style.display = 'none';
                nismField.style.display = 'block';
                document.getElementById('nim').required = false;
                document.getElementById('nism').required = true;
            }
        });
    </script>
</body>
</html>
