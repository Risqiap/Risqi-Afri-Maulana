<?php
require 'auth_check.php';
if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin - Sistem Akademik</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f1f1f1; }
        h2 { color: #333; }
        .menu { background: white; padding: 20px; border-radius: 8px; width: 300px; }
        .menu ul { list-style: none; padding: 0; }
        .menu li { margin: 10px 0; }
        .menu a { text-decoration: none; color: #0066cc; font-weight: bold; }
        .logout { margin-top: 20px; display: inline-block; }
    </style>
</head>
<body>

<h2>Selamat Datang, <?= $_SESSION['username'] ?> (Admin)</h2>

<div class="menu">
    <h3>Menu Admin</h3>
    <ul>
        <li><a href="mahasiswa.php">Manajemen Mahasiswa</a></li>
        <li><a href="dosen.php">Manajemen Dosen</a></li>
        <li><a href="matakuliah.php">Manajemen Mata Kuliah</a></li>
        <li><a href="krs.php">Manajemen KRS</a></li>
        <li><a href="nilai.php">Manajemen Nilai</a></li>
        <li><a href="users.php">Manajemen Pengguna</a></li>
    </ul>
</div>

<a href="logout.php" class="logout">Logout</a>

</body>
</html>
