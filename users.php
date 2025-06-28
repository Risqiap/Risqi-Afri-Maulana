<?php
require 'auth_check.php';
require 'config.php';

if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}

// Tambah user
if (isset($_POST['simpan'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $cek = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    }
    header("Location: user.php");
    exit();
}

// Hapus user
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id'");
    header("Location: user.php");
    exit();
}

// Ambil daftar user
$users = mysqli_query($conn, "SELECT * FROM users ORDER BY username");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Pengguna</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f7f9;
            padding: 30px;
        }

        h2 {
            color: #003366;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        select, input, button {
            font-size: 14px;
            padding: 10px;
            margin: 5px 5px 5px 0;
            border-radius: 5px;
        }

        select, input {
            border: 1px solid #ccc;
            width: 220px;
        }

        button {
            background-color: #003366;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #002244;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background: white;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #003366;
            color: white;
        }

        a {
            text-decoration: none;
            color: #cc0000;
        }

        a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
            color: #003366;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Manajemen Pengguna</h2>

<form method="post">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <select name="role" required>
        <option value="">Pilih Role</option>
        <option value="admin">Admin</option>
        <option value="dosen">Dosen</option>
        <option value="mahasiswa">Mahasiswa</option>
    </select>
    <button type="submit" name="simpan">Tambah User</button>
</form>

<table>
    <tr>
        <th>No</th><th>Username</th><th>Role</th><th>Aksi</th>
    </tr>
    <?php
    $no = 1;
    while ($u = mysqli_fetch_assoc($users)) {
        echo "<tr>
            <td>{$no}</td>
            <td>{$u['username']}</td>
            <td>{$u['role']}</td>
            <td><a href='?hapus={$u['id']}' onclick=\"return confirm('Hapus user ini?')\">Hapus</a></td>
        </tr>";
        $no++;
    }
    ?>
</table>

<a href="admin_dashboard.php" class="back-link">← Kembali ke Dashboard</a>

</body>
</html>
