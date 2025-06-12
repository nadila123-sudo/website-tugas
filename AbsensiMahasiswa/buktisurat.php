if ($row['Status'] == "Sakit" && !empty($row['Bukti_Surat']) && file_exists($row['Bukti_Surat'])) {
    echo "<a href='{$row['Bukti_Surat']}' target='_blank'>📄 Lihat Surat</a>";
} else {
    echo "Tidak Ada";
}
