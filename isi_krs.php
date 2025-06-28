<?php
require 'auth_check.php';
require 'config.php';

if (!isUser()) {
    echo "Akses ditolak!";
    exit();
}

$nim = $_SESSION['username'];

// Tambah mata kuliah ke KRS
if (isset($_POST['tambah'])) {
    $kode_mk = $_POST['kode_mk'];
    $semester = $_POST['semester'];

    // Cek apakah sudah mengambil matkul ini
    $cek = mysqli_query($conn, "SELECT * FROM krs WHERE nim='$nim' AND kode_mk='$kode_mk'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO krs (nim, kode_mk, semester) VALUES ('$nim', '$kode_mk', '$semester')");
    }
    header("Location: isi_krs.php");
    exit();
}

// Hapus matkul dari KRS
if (isset($_GET['hapus'])) {
    $kode_mk = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM krs WHERE nim='$nim' AND kode_mk='$kode_mk'");
    header("Location: isi_krs.php");
    exit();
}

// Data matkul yang sudah diambil mahasiswa
$krs = mysqli_query($conn, "
    SELECT krs.kode_mk, mk.nama_mk, krs.semester
    FROM krs JOIN matakuliah mk ON krs.kode_mk = mk.kode_mk
    WHERE krs.nim='$nim'
");

// Semua matkul yang tersedia
$matakuliah = mysqli_query($conn, "SELECT * FROM matakuliah ORDER BY kode_mk");
?>

<h2>Kelola KRS Saya</h2>

<h3>Mata Kuliah yang Diambil</h3>
<table border="1" cellpadding="5" cellspacing="0">
    <tr><th>No</th><th>Kode MK</th><th>Nama MK</th><th>Semester</th><th>Aksi</th></tr>
    <?php
    $no=1;
    while ($row = mysqli_fetch_assoc($krs)) {
        echo "<tr>
            <td>$no</td>
            <td>".htmlspecialchars($row['kode_mk'])."</td>
            <td>".htmlspecialchars($row['nama_mk'])."</td>
            <td>".htmlspecialchars($row['semester'])."</td>
            <td><a href='?hapus=".urlencode($row['kode_mk'])."' onclick=\"return confirm('Hapus mata kuliah ini dari KRS?')\">Hapus</a></td>
        </tr>";
        $no++;
    }
    ?>
</table>

<h3>Tambah Mata Kuliah</h3>
<form method="post">
    <select name="kode_mk" required>
        <option value="">-- Pilih Mata Kuliah --</option>
        <?php while ($mk = mysqli_fetch_assoc($matakuliah)): ?>
            <option value="<?= htmlspecialchars($mk['kode_mk']) ?>">
                <?= htmlspecialchars($mk['kode_mk'] . " - " . $mk['nama_mk']) ?>
            </option>
        <?php endwhile; ?>
    </select>
    <input type="number" name="semester" min="1" max="14" placeholder="Semester" required>
    <button type="submit" name="tambah">Tambah</button>
</form>

<a href="user_dashboard.php">Kembali ke Dashboard</a>
