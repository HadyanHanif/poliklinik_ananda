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

// Ambil data nama poli dari tabel poli
$sql_poli = "SELECT id, nama_poli FROM poli";
$result_poli = $conn->query($sql_poli);

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_dokter = $_POST['nama_dokter'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $id_poli = $_POST['id_poli'];

    // Query untuk menyimpan data dokter
    $sql = "INSERT INTO dokter (nama, password, no_hp, id_poli) VALUES ('$nama_dokter', '$password', '$no_hp', '$id_poli')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dokter berhasil ditambahkan'); window.location.href='kelola_dokter.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eeeded;
        }
        .center-card {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            border: 1px solid #070707;
        }
        .btn-primary {
            background-color: #1a6fdc;
            border: 1px solid #070707;
        }
        .btn-primary:hover {
            background-color: #155ab3;
        }
    </style>
</head>
<body>
    <div class="container center-card">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 text-center">Form Tambah Dokter</h5>
                    <form action="tambah_dokter.php" method="POST">
                        <div class="mb-3">
                            <label for="namaDokter" class="form-label">Nama Dokter</label>
                            <input type="text" class="form-control" id="namaDokter" name="nama_dokter" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="noHp" class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" id="noHp" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="idPoli" class="form-label">ID Poli</label>
                            <select class="form-select" id="idPoli" name="id_poli" required>
                                <option value="">Pilih Poli</option>
                                <?php
                                // Menampilkan opsi ID Poli dari database
                                if ($result_poli->num_rows > 0) {
                                    while ($row = $result_poli->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['nama_poli'] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada data Poli</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
