<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'crud1';

$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

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
    $query = "SELECT * FROM t_mahasiswa WHERE namaMhs LIKE '%$keyword%'";
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
    $query = "SELECT * FROM t_matakuliah WHERE namaMK LIKE '%$keyword%'";
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

// Handle create dan delete
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['create'])) {
        $table = $_POST['table'];
        if ($table == 'dosen') {
            $namaDosen = $_POST['namaDosen'];
            $noHP = $_POST['noHP'];
            $query = "INSERT INTO t_dosen (namaDosen, noHP) VALUES ('$namaDosen', '$noHP')";
        } elseif ($table == 'mahasiswa') {
            $npm = $_POST['npm'];
            $namaMhs = $_POST['namaMhs'];
            $prodi = $_POST['prodi'];
            $alamat = $_POST['alamat'];
            $noHP = $_POST['noHP'];
            $query = "INSERT INTO t_mahasiswa (npm, namaMhs, prodi, alamat, noHP) VALUES ('$npm', '$namaMhs', '$prodi', '$alamat', '$noHP')";
        } elseif ($table == 'matakuliah') {
            $kodeMK = $_POST['kodeMK'];
            $namaMK = $_POST['namaMK'];
            $sks = $_POST['sks'];
            $jam = $_POST['jam'];
            $query = "INSERT INTO t_matakuliah (kodeMK, namaMK, sks, jam) VALUES ('$kodeMK', '$namaMK', '$sks', '$jam')";
        }
        mysqli_query($link, $query);
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $table = $_POST['table'];
        if ($table == 'dosen') {
            $query = "DELETE FROM t_dosen WHERE idDosen='$id'";
        } elseif ($table == 'mahasiswa') {
            $query = "DELETE FROM t_mahasiswa WHERE npm='$id'";
        } elseif ($table == 'matakuliah') {
            $query = "DELETE FROM t_matakuliah WHERE kodeMK='$id'";
        }
        mysqli_query($link, $query);
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
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
        }
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
        .action-buttons input[type="submit"] {
            background-color: red;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
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
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['idDosen']; ?>">
                            <input type="hidden" name="table" value="dosen">
                            <input type="submit" name="delete" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Data Mahasiswa</h2>
        <table>
            <tr>
                <th>NPM</th>
                <th>Nama Mahasiswa</th>
                <th>Prodi</th>
                <th>Alamat</th>
                <th>No HP</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultMahasiswa)) { ?>
                <tr>
                    <td><?php echo $row['npm']; ?></td>
                    <td><?php echo $row['namaMhs']; ?></td>
                    <td><?php echo $row['prodi']; ?></td>
                    <td><?php echo $row['alamat']; ?></td>
                    <td><?php echo $row['noHP']; ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $row['npm']; ?>">
                            <input type="hidden" name="table" value="mahasiswa">
                            <input type="submit" name="delete" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Data Matakuliah</h2>
        <table>
            <tr>
                <th>Kode MK</th>
                <th>Nama MK</th>
                <th>SKS</th>
                <th>Jam</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($resultMatakuliah)) { ?>
                <tr>
                    <td><?php echo $row['kodeMK']; ?></td>
                    <td><?php echo $row['namaMK']; ?></td>
                    <td><?php echo $row['sks']; ?></td>
                    <td><?php echo $row['jam']; ?></td>
                    <td class="action-buttons">
                        <form method="POST" action="">
                            <
                            <input type="hidden" name="id" value="<?php echo $row['kodeMK']; ?>">
                            <input type="hidden" name="table" value="matakuliah">
                            <input type="submit" name="delete" value="Hapus">
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <h2>Tambah Data Baru</h2>
        <form method="POST" action="">
            <h3>Tambah Dosen</h3>
            <input type="hidden" name="table" value="dosen">
            <label>Nama Dosen:</label><br>
            <input type="text" name="namaDosen" required><br>
            <label>No HP:</label><br>
            <input type="text" name="noHP" required><br>
            <input type="submit" name="create" value="Tambah"><br><br>
        </form>

        <form method="POST" action="">
            <h3>Tambah Mahasiswa</h3>
            <input type="hidden" name="table" value="mahasiswa">
            <label>NPM:</label><br>
            <input type="text" name="npm" required><br>
            <label>Nama Mahasiswa:</label><br>
            <input type="text" name="namaMhs" required><br>
            <label>Prodi:</label><br>
            <input type="text" name="prodi" required><br>
            <label>Alamat:</label><br>
            <input type="text" name="alamat" required><br>
            <label>No HP:</label><br>
            <input type="text" name="noHP" required><br>
            <input type="submit" name="create" value="Tambah"><br><br>
        </form>

        <form method="POST" action="">
            <h3>Tambah Matakuliah</h3>
            <input type="hidden" name="table" value="matakuliah">
            <label>Kode MK:</label><br>
            <input type="text" name="kodeMK" required><br>
            <label>Nama MK:</label><br>
            <input type="text" name="namaMK" required><br>
            <label>SKS:</label><br>
            <input type="text" name="sks" required><br>
            <label>Jam:</label><br>
            <input type="text" name="jam" required><br>
            <input type="submit" name="create" value="Tambah"><br><br>
        </form>
    </div>
</body>
</html>
