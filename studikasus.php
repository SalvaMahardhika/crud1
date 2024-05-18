<?php
// Memanggil file koneksi.php untuk membuat koneksi
include 'koneksi.php';

// Fungsi untuk mencari data berdasarkan nama pada tabel t_dosen
function searchDosen($keyword)
{
    global $link;
    $query = "SELECT * FROM t_dosen WHERE namaDosen LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
    return $result;
}

// Fungsi untuk mencari data berdasarkan nama pada tabel t_mahasiswa
function searchMahasiswa($keyword)
{
    global $link;
    $query = "SELECT * FROM t_mahasiswa WHERE namaMahasiswa LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
    return $result;
}

// Fungsi untuk mencari data berdasarkan nama pada tabel t_matakuliah
function searchMatakuliah($keyword)
{
    global $link;
    $query = "SELECT * FROM t_matakuliah WHERE namaMatakuliah LIKE '%$keyword%'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
    return $result;
}

// Mengecek apakah form pencarian telah di-submit
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $resultDosen = searchDosen($keyword);
    $resultMahasiswa = searchMahasiswa($keyword);
    $resultMatakuliah = searchMatakuliah($keyword);
} else {
    // Jika form pencarian tidak di-submit, tampilkan semua data
    $resultDosen = mysqli_query($link, "SELECT * FROM t_dosen");
    $resultMahasiswa = mysqli_query($link, "SELECT * FROM t_mahasiswa");
    $resultMatakuliah = mysqli_query($link, "SELECT * FROM t_matakuliah");
}

// Fungsi untuk menambahkan data mahasiswa
if (isset($_POST['submitMahasiswa'])) {
    $nim = $_POST['nim'];
    $namaMahasiswa = $_POST['namaMahasiswa'];
    $alamat = $_POST['alamat'];
    
    $query = "INSERT INTO t_mahasiswa (nim, namaMahasiswa, alamat) VALUES ('$nim', '$namaMahasiswa', '$alamat')";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}

// Fungsi untuk menambahkan data dosen
if (isset($_POST['submitDosen'])) {
    $idDosen = $_POST['idDosen'];
    $namaDosen = $_POST['namaDosen'];
    $noHP = $_POST['noHP'];
    
    $query = "INSERT INTO t_dosen (idDosen, namaDosen, noHP) VALUES ('$idDosen', '$namaDosen', '$noHP')";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}

// Fungsi untuk menambahkan data matakuliah
if (isset($_POST['submitMatakuliah'])) {
    $idMatakuliah = $_POST['idMatakuliah'];
    $namaMatakuliah = $_POST['namaMatakuliah'];
    
    $query = "INSERT INTO t_matakuliah (idMatakuliah, namaMatakuliah) VALUES ('$idMatakuliah', '$namaMatakuliah')";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}

// Fungsi untuk menghapus data mahasiswa
if (isset($_POST['submitHapusMahasiswa'])) {
    $nim = $_POST['nim'];
    
    $query = "DELETE FROM t_mahasiswa WHERE nim='$nim'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}

// Fungsi untuk menghapus data dosen
if (isset($_POST['submitHapusDosen'])) {
    $idDosen = $_POST['idDosen'];
    
    $query = "DELETE FROM t_dosen WHERE idDosen='$idDosen'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}

// Fungsi untuk menghapus data matakuliah
if (isset($_POST['submitHapusMatakuliah'])) {
    $idMatakuliah = $_POST['idMatakuliah'];
    
    $query = "DELETE FROM t_matakuliah WHERE idMatakuliah='$idMatakuliah'";
    $result = mysqli_query($link, $query);
    if (!$result) {
        die("Query Error: " . mysqli_errno($link) . " - " . mysqli_error($link));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CRUD Mahasiswa, Dosen, Matakuliah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
        }
        .search-bar {
            margin-top: 20px;
            margin-bottom: 20px;
            text-align: center;
            .search-bar input[type="text"] {
            padding: 8px;
            width: 300px;
        }
        .search-bar input[type="submit"] {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .search-bar input[type="submit"]:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="search-bar">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Cari Nama...">
                <input type="submit" value="Cari">
            </form>
        </div>

        <h2>Data Dosen</h2>
        <table>
            <tr>
                <th>ID Dosen</th>
                <th>Nama Dosen</th>
                <th>No HP</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultDosen)) { ?>
                <tr>
                    <td><?php echo $row['idDosen']; ?></td>
                    <td><?php echo $row['namaDosen']; ?></td>
                    <td><?php echo $row['noHP']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="idDosen" value="<?php echo $row['idDosen']; ?>">
                            <input type="submit" name="submitHapusDosen" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Data Mahasiswa</h2>
        <table>
            <tr>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Alamat</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultMahasiswa)) { ?>
                <tr>
                    <td><?php echo $row['nim']; ?></td>
                    <td><?php echo $row['namaMahasiswa']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="nim" value="<?php echo $row['nim']; ?>">
                            <input type="submit" name="submitHapusMahasiswa" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Data Matakuliah</h2>
        <table>
            <tr>
                <th>ID Matakuliah</th>
                <th>Nama Matakuliah</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultMatakuliah)) { ?>
                <tr>
                    <td><?php echo $row['idMatakuliah']; ?></td>
                    <td><?php echo $row['namaMatakuliah']; ?></td>
                    <td>
                        <form method="POST" action="">
                            <input type="hidden" name="idMatakuliah" value="<?php echo $row['idMatakuliah']; ?>">
                            <input type="submit" name="submitHapusMatakuliah" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
