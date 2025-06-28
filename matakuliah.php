<?php
require 'auth_check.php';
require 'config.php';

if (!isAdmin()) {
    echo "Akses ditolak!";
    exit();
}

$kode_mk = "";
$nama_mk = "";
$sks = "";

if (isset($_POST['simpan'])) {
    $kode = $_POST['kode_mk'];
    $nama = $_POST['nama_mk'];
    $sks  = $_POST['sks'];

    $cek = mysqli_query($conn, "SELECT * FROM matakuliah WHERE kode_mk='$kode'");

    if (mysqli_num_rows($cek) > 0) {
        $query = "UPDATE matakuliah SET nama_mk='$nama', sks='$sks' WHERE kode_mk='$kode'";
    } else {
        $query = "INSERT INTO matakuliah (kode_mk, nama_mk, sks) VALUES ('$kode', '$nama', '$sks')";
    }

    mysqli_query($conn, $query);
    header("Location: matakuliah.php");
    exit();
}

if (isset($_GET['edit'])) {
    $kode = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM matakuliah WHERE kode_mk='$kode'");
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $kode_mk = $row['kode_mk'];
        $nama_mk = $row['nama_mk'];
        $sks = $row['sks'];
    }
}

if (isset($_GET['hapus'])) {
    $kode = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM matakuliah WHERE kode_mk='$kode'");
    header("Location: matakuliah.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Mata Kuliah</title>
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

        input, button, a {
            font-size: 14px;
            padding: 10px;
            margin: 5px 5px 5px 0;
            border-radius: 5px;
        }

        input {
            border: 1px solid #ccc;
            width: 200px;
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

        a {
            text-decoration: none;
            color: #cc0000;
        }

        a:hover {
            text-decoration: underline;
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

        .back-link {
            display: inline-block;
            margin-top: 20px;
            font-weight: bold;
            color: #003366;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .cancel-btn {
            background-color: #999;
            color: white;
            text-decoration: none;
            padding: 10px;
            border-radius: 5px;
        }

        .cancel-btn:hover {
            background-color: #777;
        }
    </style>
</head>
<body>

<h2>Manajemen Mata Kuliah</h2>

<form method="post">
    <input type="text" name="kode_mk" placeholder="Kode MK" required 
        value="<?= htmlspecialchars($kode_mk) ?>" <?= $kode_mk ? 'readonly' : '' ?>>
    <input type="text" name="nama_mk" placeholder="Nama Mata Kuliah" required 
        value="<?= htmlspecialchars($nama_mk) ?>">
    <input type="number" name="sks" placeholder="SKS" required 
        value="<?= htmlspecialchars($sks) ?>">
    <button type="submit" name="simpan">Simpan</button>
    <?php if ($kode_mk): ?>
        <a href="matakuliah.php" class="cancel-btn">Batal</a>
    <?php endif; ?>
</form>

<table>
    <tr>
        <th>Kode</th>
        <th>Nama MK</th>
        <th>SKS</th>
        <th>Aksi</th>
    </tr>
    <?php
    $data = mysqli_query($conn, "SELECT * FROM matakuliah ORDER BY kode_mk");
    while ($row = mysqli_fetch_assoc($data)) {
        echo "<tr>
            <td>".htmlspecialchars($row['kode_mk'])."</td>
            <td>".htmlspecialchars($row['nama_mk'])."</td>
            <td>".htmlspecialchars($row['sks'])."</td>
            <td>
                <a href='?edit=".urlencode($row['kode_mk'])."'>Edit</a> | 
                <a href='?hapus=".urlencode($row['kode_mk'])."' onclick=\"return confirm('Hapus mata kuliah ini?')\">Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

<a href="admin_dashboard.php" class="back-link">← Kembali ke Dashboard</a>

</body>
</html>
