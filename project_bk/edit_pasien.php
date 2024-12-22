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

// Cek apakah ID pasien ada dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data pasien berdasarkan ID
    $sql = "SELECT * FROM pasien WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data pasien
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $password = $row['password'];
        $alamat = $row['alamat'];
        $no_ktp = $row['no_ktp'];
        $no_hp = $row['no_hp'];
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak valid!";
    exit();
}

// Proses pembaruan data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data yang diinputkan pada form
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];

    // Query untuk mengupdate data pasien
    $sql = "UPDATE pasien SET nama = '$nama', password = '$password', alamat = '$alamat', no_ktp = '$no_ktp', no_hp = '$no_hp' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman kelola pasien
        header("Location: kelola_pasien.php");
        exit();
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
    <title>Form Edit Pasien</title>
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
                    <h5 class="card-title mb-4 text-center">Form Edit Pasien</h5>
                    <form action="edit_pasien.php?id=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="namaPasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="namaPasien" name="nama" value="<?php echo $nama; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">No KTP</label>
                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php echo $no_ktp; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $no_hp; ?>" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
