<?php
require 'auth_check.php';
require 'config.php';

if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}

// Handle tambah/edit
if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $jurusan = $_POST['jurusan'];
    $angkatan = $_POST['angkatan'];

    $cek = mysqli_query($conn, "SELECT * FROM mahasiswa WHERE nim='$nim'");
    if (mysqli_num_rows($cek) > 0) {
        $query = "UPDATE mahasiswa SET nama='$nama', jurusan='$jurusan', angkatan='$angkatan' WHERE nim='$nim'";
    } else {
        $query = "INSERT INTO mahasiswa (nim, nama, jurusan, angkatan) VALUES ('$nim', '$nama', '$jurusan', '$angkatan')";
    }

    mysqli_query($conn, $query);
    header("Location: mahasiswa.php");
    exit();
}

// Handle hapus
if (isset($_GET['hapus'])) {
    $nim = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE nim='$nim'");
    header("Location: mahasiswa.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Mahasiswa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f8;
            padding: 30px;
        }

        h2 {
            color: #003366;
        }

        form {
            margin-bottom: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        form input, form button {
            margin: 8px 5px 8px 0;
            padding: 10px;
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

<h2>Manajemen Mahasiswa</h2>

<form method="post">
    <input type="text" name="nim" placeholder="NIM" required>
    <input type="text" name="nama" placeholder="Nama" required>
    <input type="text" name="jurusan" placeholder="Jurusan" required>
    <input type="number" name="angkatan" placeholder="Angkatan" required>
    <button type="submit" name="simpan">Simpan</button>
</form>

<table>
    <tr>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Angkatan</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = mysqli_query($conn, "SELECT * FROM mahasiswa ORDER BY nim");
    while ($mhs = mysqli_fetch_assoc($data)) {
        echo "<tr>
            <td>{$mhs['nim']}</td>
            <td>{$mhs['nama']}</td>
            <td>{$mhs['jurusan']}</td>
            <td>{$mhs['angkatan']}</td>
            <td><a href='?hapus={$mhs['nim']}' onclick=\"return confirm('Hapus data?')\">Hapus</a></td>
        </tr>";
    }
    ?>
</table>

<a class="back-link" href="admin_dashboard.php">← Kembali ke Dashboard</a>

</body>
</html>
