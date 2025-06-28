<?php
require 'auth_check.php';
require 'config.php';

if (!isUser()) { exit('Akses ditolak!'); }

$matakuliah = mysqli_query($conn, "SELECT * FROM matakuliah ORDER BY nama_mk");
?>

<h2>Daftar Mata Kuliah</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Kode MK</th><th>Nama Mata Kuliah</th><th>SKS</th></tr>
    <?php while ($row = mysqli_fetch_assoc($matakuliah)) : ?>
        <tr>
            <td><?= htmlspecialchars($row['kode_mk']) ?></td>
            <td><?= htmlspecialchars($row['nama_mk']) ?></td>
            <td><?= htmlspecialchars($row['sks']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="user_dashboard.php">Kembali</a>
