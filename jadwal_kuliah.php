<?php
require 'auth_check.php';
require 'config.php';

if (!isUser()) { exit('Akses ditolak!'); }
$nim = $_SESSION['username'];

// Untuk contoh, ambil jadwal dari KRS yang diambil mahasiswa
// Misal, kita punya tabel jadwal: (kode_mk, hari, jam_mulai, jam_selesai, ruang)

$query = "
    SELECT mk.kode_mk, mk.nama_mk, j.hari, j.jam_mulai, j.jam_selesai, j.ruang
    FROM krs k
    JOIN matakuliah mk ON k.kode_mk = mk.kode_mk
    JOIN jadwal j ON mk.kode_mk = j.kode_mk
    WHERE k.nim='$nim'
    ORDER BY FIELD(j.hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'), j.jam_mulai
";

$jadwal = mysqli_query($conn, $query);
?>

<h2>Jadwal Kuliah Saya</h2>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>Kode MK</th><th>Nama MK</th><th>Hari</th><th>Jam Mulai</th><th>Jam Selesai</th><th>Ruang</th></tr>
    <?php while($row = mysqli_fetch_assoc($jadwal)): ?>
        <tr>
            <td><?= htmlspecialchars($row['kode_mk']) ?></td>
            <td><?= htmlspecialchars($row['nama_mk']) ?></td>
            <td><?= htmlspecialchars($row['hari']) ?></td>
            <td><?= htmlspecialchars($row['jam_mulai']) ?></td>
            <td><?= htmlspecialchars($row['jam_selesai']) ?></td>
            <td><?= htmlspecialchars($row['ruang']) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
<a href="user_dashboard.php">Kembali</a>
