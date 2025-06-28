<?php
require 'auth_check.php';
if (!isUser()) {
    echo "Akses ditolak!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Mahasiswa</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        .menu a { display: block; margin: 5px 0; color: green; text-decoration: none; }
    </style>
</head>
<body>
    <h2>Selamat datang, <?= $_SESSION['username'] ?> (Mahasiswa)</h2>
    <div class="menu">
        <a href="#">👤 Profil Saya</a>
        <a href="#">📖 Lihat Mata Kuliah</a>
        <a href="#">📝 Ambil KRS</a>
        <a href="#">📊 Lihat Nilai</a>
        <a href="#">📅 Jadwal Kuliah</a>
        <a href="logout.php">🚪 Logout</a>
    </div>
</body>
</html>
