<?php
require 'auth_check.php';
if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - Sistem Akademik</title>
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

        h2, h3 {
            margin: 0;
        }

        .container {
            max-width: 600px;
            background-color: white;
            margin: 30px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
        }

        .menu ul {
            list-style: none;
            padding: 0;
        }

        .menu li {
            margin: 12px 0;
        }

        .menu a {
            display: block;
            padding: 12px 16px;
            background-color: #f1f1f1;
            border-left: 6px solid #003366;
            text-decoration: none;
            color: #003366;
            border-radius: 4px;
            font-weight: bold;
            transition: background-color 0.2s;
        }

        .menu a:hover {
            background-color: #e6f0ff;
        }

        .logout {
            display: inline-block;
            margin-top: 20px;
            color: white;
            background-color: #cc0000;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #990000;
        }
    </style>
</head>
<body>

<header>
    <h2>Dashboard Admin</h2>
</header>

<div class="container">
    <p>Selamat datang, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong> (Admin)</p>

    <div class="menu">
        <h3>Menu Sistem Akademik</h3>
        <ul>
            <li><a href="mahasiswa.php">📋 Manajemen Mahasiswa</a></li>
            <li><a href="dosen.php">👨‍🏫 Manajemen Dosen</a></li>
            <li><a href="matakuliah.php">📚 Manajemen Mata Kuliah</a></li>
            <li><a href="krs.php">📝 Manajemen KRS</a></li>
            <li><a href="nilai.php">📊 Manajemen Nilai</a></li>
            <li><a href="users.php">👥 Manajemen Pengguna</a></li>
        </ul>
    </div>

    <a href="logout.php" class="logout">🚪 Logout</a>
</div>

</body>
</html>
