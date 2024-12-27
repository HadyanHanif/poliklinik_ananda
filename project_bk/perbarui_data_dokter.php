<?php
session_start();

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

// Periksa apakah dokter sudah login
if (!isset($_SESSION['dokter_id'])) {
    header('Location: login_dokter.php');
    exit();
}

// Ambil ID dokter dari session
$dokter_id = $_SESSION['dokter_id'];

// Query untuk mendapatkan data dokter berdasarkan ID
$sql = "SELECT * FROM dokter WHERE id = $dokter_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ambil data dokter
    $row = $result->fetch_assoc();
    $nama_dokter = $row['nama'];
    $password = $row['password'];
    $no_hp = $row['no_hp'];
} else {
    echo "Data tidak ditemukan!";
    exit();
}

// Proses pembaruan data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_dokter = $_POST['nama_dokter'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];

    // Query untuk mengupdate data dokter (tanpa id_poli)
    $sql = "UPDATE dokter SET nama = '$nama_dokter', password = '$password', no_hp = '$no_hp' WHERE id = $dokter_id";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman dokter
        header("Location: dokter.php");
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
    <title>Perbarui Data Dokter</title>
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
                    <h5 class="card-title mb-4 text-center">Perbarui Data Dokter</h5>
                    <form action="perbarui_data_dokter.php" method="POST">
                        <div class="mb-3">
                            <label for="namaDokter" class="form-label">Nama Dokter</label>
                            <input type="text" class="form-control" id="namaDokter" name="nama_dokter" value="<?php echo $nama_dokter; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="noHp" class="form-label">No Hp</label>
                            <input type="text" class="form-control" id="noHp" name="no_hp" value="<?php echo $no_hp; ?>" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
