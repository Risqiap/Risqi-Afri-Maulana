<?php
require 'auth_check.php';
require 'config.php';

if (!isUser()) { exit('Akses ditolak!'); }
$nim = $_SESSION['username'];

$nilai = mysqli_query($conn, "
    SELECT n.nilai, mk.kode_mk, mk.nama_mk, mk.sks
    FROM nilai n
    JOIN matakuliah mk ON n.kode_mk = mk.kode_mk
    WHERE n.nim='$nim'
");
?>

<h2>Nilai Saya</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Kode MK</th><th>Nama Mata Kuliah</th><th>SKS</th><th>Nilai</th></tr>
    <?php while ($row = mysqli_fetch_assoc($nilai)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['kode_mk']) ?></td>
            <td><?= htmlspecialchars($row['nama_mk']) ?></td>
            <td><?= htmlspecialchars($row['sks']) ?></td>
            <td><?= htmlspecialchars($row['nilai']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="user_dashboard.php">Kembali</a>
