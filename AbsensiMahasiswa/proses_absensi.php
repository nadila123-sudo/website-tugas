if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_SESSION['nim'];
    $kode_mk = $_POST['kode_mk'];
    $tanggal = $_POST['tanggal'];
    $jenis_absensi = $_POST['jenis_absensi'];
    $ulasan = isset($_POST['ulasan']) ? mysqli_real_escape_string($conn, $_POST['ulasan']) : NULL;

    $query = "INSERT INTO Kehadiran (NIM, ID_Jadwal, Tanggal, Status, Ulasan) 
              VALUES ('$nim', (SELECT ID_Jadwal FROM Jadwal WHERE Kode_MK='$kode_mk' LIMIT 1), '$tanggal', '$jenis_absensi', '$ulasan')";
    
    if (mysqli_query($conn, $query)) {
        header("Location: hasil.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
