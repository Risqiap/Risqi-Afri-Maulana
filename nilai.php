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
    $nilai = strtoupper($_POST['nilai']);

    $cek = mysqli_query($conn, "SELECT * FROM nilai WHERE nim='$nim' AND kode_mk='$kode_mk'");
    if (mysqli_num_rows($cek) > 0) {
        mysqli_query($conn, "UPDATE nilai SET nilai='$nilai' WHERE nim='$nim' AND kode_mk='$kode_mk'");
    } else {
        mysqli_query($conn, "INSERT INTO nilai (nim, kode_mk, nilai) VALUES ('$nim', '$kode_mk', '$nilai')");
    }
    header("Location: nilai.php");
    exit();
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM nilai WHERE id='$id'");
    header("Location: nilai.php");
    exit();
}

$mahasiswa = mysqli_query($conn, "SELECT nim, nama FROM mahasiswa ORDER BY nama");
$matakuliah = mysqli_query($conn, "SELECT kode_mk, nama_mk FROM matakuliah ORDER BY nama_mk");

$nilai_list = mysqli_query($conn, "
    SELECT n.id, n.nim, m.nama, n.kode_mk, mk.nama_mk, n.nilai
    FROM nilai n
    JOIN mahasiswa m ON n.nim = m.nim
    JOIN matakuliah mk ON n.kode_mk = mk.kode_mk
    ORDER BY n.nim
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Nilai</title>
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

<h2>Manajemen Nilai Mahasiswa</h2>

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

    <input type="text" name="nilai" maxlength="2" placeholder="Nilai (A, B, C, D, E)" required>

    <button type="submit" name="simpan">Simpan Nilai</button>
</form>

<table>
    <tr>
        <th>No</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Kode MK</th>
        <th>Mata Kuliah</th>
        <th>Nilai</th>
        <th>Aksi</th>
    </tr>
    <?php
    $no=1;
    while ($row = mysqli_fetch_assoc($nilai_list)) {
        echo "<tr>
            <td>{$no}</td>
            <td>{$row['nim']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['kode_mk']}</td>
            <td>{$row['nama_mk']}</td>
            <td>{$row['nilai']}</td>
            <td><a href='?hapus={$row['id']}' onclick=\"return confirm('Hapus nilai?')\">Hapus</a></td>
        </tr>";
        $no++;
    }
    ?>
</table>

<a href="admin_dashboard.php" class="back-link">← Kembali ke Dashboard</a>

</body>
</html>
