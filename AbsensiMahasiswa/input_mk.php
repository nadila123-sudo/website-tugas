<?php
$matkul_query = "SELECT Kode_MK, Nama_MK FROM Mata_Kuliah";
$matkul_result = mysqli_query($conn, $matkul_query);
while ($row = mysqli_fetch_assoc($matkul_result)): ?>
    <option value="<?= $row['Kode_MK'] ?>"><?= $row['Nama_MK'] ?></option>
<?php endwhile; ?>
