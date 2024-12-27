<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "poli";

$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dari tabel pasien
$sql = "SELECT * FROM pasien";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #1a6fdc;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover {
            background-color: #155bb5;
        }
        .logout-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-sm {
            margin: 0 3px;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 sidebar vh-100 d-flex flex-column p-3">
                <h4 class="text-center mb-4">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="kelola_pasien.php">Kelola Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_dokter.php">Kelola Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_obat.php">Kelola Obat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_poli.php">Kelola Poli</a>
                    </li>
                </ul>
            </div>
            
            <div class="col-md-9 col-lg-10 d-flex flex-column p-5">
                <h2 class="fw-bold mb-4">Kelola Pasien</h2>
                
                <!-- Button Tambah Pasien -->
                <div class="mb-4">
                    <a href="tambah_pasien.php" class="btn btn-primary">Tambah Pasien</a>
                </div>

                <!-- Table untuk menampilkan data pasien -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Nama Pasien</th>
                                <th>Password</th>
                                <th>Alamat</th>
                                <th>No KTP</th>
                                <th>No HP</th>
                                <th>No Rekam Medis</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td>" . $row['nama'] . "</td>";
                                    echo "<td>" . $row['password'] . "</td>";
                                    echo "<td>" . $row['alamat'] . "</td>";
                                    echo "<td>" . $row['no_ktp'] . "</td>";
                                    echo "<td>" . $row['no_hp'] . "</td>";
                                    echo "<td>" . $row['no_rm'] . "</td>";
                                    echo "<td>
                                            <a href='edit_pasien.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                            <a href='hapus_pasien.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <button class="logout-btn" onclick="window.location.href='index.php';">Logout</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
