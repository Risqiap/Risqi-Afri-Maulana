<?php
require 'auth_check.php';
require 'config.php';

if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $kode_mk = $_POST['kode_mk'];
    $semester = $_POST['semester'];

    $cek = mysqli_query($conn, "SELECT * FROM krs WHERE nim='$nim' AND kode_mk='$kode_mk'");
    if (mysqli_num_rows($cek) == 0) {
        mysqli_query($conn, "INSERT INTO krs (nim, kode_mk, semester) VALUES ('$nim', '$kode_mk', '$semester')");
    }
    header("Location: krs.php");
    exit();
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM krs WHERE id='$id'");
    header("Location: krs.php");
    exit();
}

$mahasiswa = mysqli_query($conn, "SELECT nim, nama FROM mahasiswa ORDER BY nama");
$matakuliah = mysqli_query($conn, "SELECT kode_mk, nama_mk FROM matakuliah ORDER BY nama_mk");

$krs = mysqli_query($conn, "
    SELECT krs.id, krs.nim, mhs.nama AS nama_mhs, krs.kode_mk, mk.nama_mk, krs.semester 
    FROM krs 
    JOIN mahasiswa mhs ON krs.nim = mhs.nim 
    JOIN matakuliah mk ON krs.kode_mk = mk.kode_mk
    ORDER BY krs.nim
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen KRS</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
            padding: 30px;
        }

        h2 {
            color: #003366;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
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

<h2>Manajemen Kartu Rencana Studi (KRS)</h2>

<form method="post">
    <select name="nim" required>
        <option value="">Pilih Mahasiswa</option>
        <?php while($m = mysqli_fetch_assoc($mahasiswa)) {
            echo "<option value='{$m['nim']}'>{$m['nama']} ({$m['nim']})</option>";
        } ?>
    </select>

    <select name="kode_mk" required>
        <option value="">Pilih Mata Kuliah</option>
        <?php mysqli_data_seek($matakuliah, 0);
        while($mk = mysqli_fetch_assoc($matakuliah)) {
            echo "<option value='{$mk['kode_mk']}'>{$mk['nama_mk']} ({$mk['kode_mk']})</option>";
        } ?>
    </select>

    <input type="number" name="semester" placeholder="Semester" min="1" max="14" required>

    <button type="submit" name="simpan">Tambah KRS</button>
</form>

<table>
    <tr>
        <th>No</th>
        <th>NIM</th>
        <th>Nama Mahasiswa</th>
        <th>Kode MK</th>
        <th>Mata Kuliah</th>
        <th>Semester</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no=1;
    while($row = mysqli_fetch_assoc($krs)) {
        echo "<tr>
            <td>{$no}</td>
            <td>{$row['nim']}</td>
            <td>{$row['nama_mhs']}</td>
            <td>{$row['kode_mk']}</td>
            <td>{$row['nama_mk']}</td>
            <td>{$row['semester']}</td>
            <td><a href='?hapus={$row['id']}' onclick=\"return confirm('Hapus data KRS?')\">Hapus</a></td>
        </tr>";
        $no++;
    }
    ?>
</table>

<a href="admin_dashboard.php" class="back-link">← Kembali ke Dashboard</a>

</body>
</html>
