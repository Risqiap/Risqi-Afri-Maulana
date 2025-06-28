<?php
require 'auth_check.php';
require 'config.php';

if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}

// Simpan data dosen
if (isset($_POST['simpan'])) {
    $nidn = $_POST['nidn'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];

    $cek = mysqli_query($conn, "SELECT * FROM dosen WHERE nidn='$nidn'");
    if (mysqli_num_rows($cek) > 0) {
        $query = "UPDATE dosen SET nama='$nama', prodi='$prodi' WHERE nidn='$nidn'";
    } else {
        $query = "INSERT INTO dosen (nidn, nama, prodi) VALUES ('$nidn', '$nama', '$prodi')";
    }
    mysqli_query($conn, $query);
    header("Location: dosen.php");
    exit();
}

// Hapus data dosen
if (isset($_GET['hapus'])) {
    $nidn = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM dosen WHERE nidn='$nidn'");
    header("Location: dosen.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Dosen</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f6f8;
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

        form input, form button {
            padding: 10px;
            margin: 8px 5px 8px 0;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        form button {
            background-color: #003366;
            color: white;
            border: none;
            cursor: pointer;
        }

        form button:hover {
            background-color: #002244;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: #fff;
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

        td a {
            color: #cc0000;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #003366;
            font-weight: bold;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<h2>Manajemen Dosen</h2>

<form method="post">
    <input type="text" name="nidn" placeholder="NIDN" required>
    <input type="text" name="nama" placeholder="Nama Dosen" required>
    <input type="text" name="prodi" placeholder="Program Studi" required>
    <button type="submit" name="simpan">Simpan</button>
</form>

<table>
    <tr>
        <th>NIDN</th>
        <th>Nama</th>
        <th>Prodi</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = mysqli_query($conn, "SELECT * FROM dosen ORDER BY nidn");
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>
            <td>{$row['nidn']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['prodi']}</td>
            <td><a href='?hapus={$row['nidn']}' onclick=\"return confirm('Hapus data ini?')\">Hapus</a></td>
        </tr>";
    }
    ?>
</table>

<a class="back-link" href="admin_dashboard.php">← Kembali ke Dashboard</a>

</body>
</html>
