<?php
require 'auth_check.php';
require 'config.php';

if (!isUser()) {
    echo "Akses ditolak!";
    exit();
}

$nim = $_SESSION['username'];

// Ambil data profil mahasiswa
$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'");
$user = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Mahasiswa</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #003366;
            color: white;
            padding: 20px;
            text-align: center;
        }
        h2 {
            margin: 0;
        }
        .container {
            padding: 20px;
        }
        p {
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        nav ul {
            list-style: none;
            padding: 0;
            max-width: 400px;
            margin: auto;
        }
        nav ul li {
            margin: 10px 0;
        }
        nav ul li a {
            display: block;
            padding: 12px 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-left: 5px solid #003366;
            border-radius: 5px;
            text-decoration: none;
            color: #003366;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        nav ul li a:hover {
            background-color: #e6f0ff;
        }
    </style>
</head>
<body>
    <header>
        <h2>Dashboard Mahasiswa</h2>
    </header>

    <div class="container">
        <p>Selamat datang, <strong><?= htmlspecialchars($user['nama']) ?></strong> (<?= htmlspecialchars($nim) ?>)</p>

        <nav>
            <ul>
                <li><a href="profil_saya.php">👤 Profil Saya</a></li>
                <li><a href="lihat_matakuliah.php">📖 Lihat Mata Kuliah</a></li>
                <li><a href="isi_krs.php">📝 Ambil KRS</a></li>
                <li><a href="lihat_nilai.php">📊 Lihat Nilai</a></li>
                <li><a href="jadwal_kuliah.php">📅 Jadwal Kuliah</a></li>
                <li><a href="logout.php">🚪 Logout</a></li>
            </ul>
        </nav>
    </div>
</body>
</html>
