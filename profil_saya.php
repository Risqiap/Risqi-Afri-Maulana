<?php
require 'auth_check.php';
require 'config.php';

if (!isUser()) { 
    exit('Akses ditolak!'); 
}
$nim = $_SESSION['username'];

$result = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'");
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f9;
            padding: 30px;
            color: #333;
        }

        h2 {
            color: #003366;
            margin-bottom: 20px;
        }

        table {
            border-collapse: collapse;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border-radius: 8px;
            overflow: hidden;
            width: 400px;
        }

        td {
            padding: 12px 20px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }

        td:first-child {
            font-weight: bold;
            width: 150px;
            background-color: #f0f4f8;
            color: #003366;
        }

        td:last-child {
            color: #555;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
            color: #003366;
            text-decoration: none;
            border: 1px solid #003366;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #003366;
            color: white;
        }
    </style>
</head>
<body>

<h2>Profil Saya</h2>
<table>
    <tr><td>NIM</td><td>: <?= htmlspecialchars($user['nim']) ?></td></tr>
    <tr><td>Nama</td><td>: <?= htmlspecialchars($user['nama']) ?></td></tr>
    <tr><td>Program Studi</td><td>: <?= htmlspecialchars($user['prodi']) ?></td></tr>
</table>

<a href="user_dashboard.php">← Kembali ke Dashboard</a>

</body>
</html>
