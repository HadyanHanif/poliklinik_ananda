<?php
session_start();

// Redirect ke login jika belum login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil nama pasien dari session
$username = $_SESSION['username'];

// Koneksi ke database
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "poli";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil no rekam medis dan id pasien berdasarkan nama
$query = "SELECT id, no_rm FROM pasien WHERE nama = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $no_rm = $row['no_rm'];
    $id_pasien = $row['id'];
} else {
    echo "Pasien tidak ditemukan!";
    exit();
}

// Ambil nomor antrian terbaru dari tabel daftar_poli
$query_antrian = "SELECT no_antrian FROM daftar_poli WHERE id_pasien = $id_pasien ORDER BY id DESC LIMIT 1";
$result_antrian = $conn->query($query_antrian);

if ($result_antrian->num_rows > 0) {
    $row_antrian = $result_antrian->fetch_assoc();
    $no_antrian = $row_antrian['no_antrian'];
} else {
    $no_antrian = "Belum ada antrian";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eeeded;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #a71d2a;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #721c24;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 30px;
        }
        .container {
            margin-top: 50px;
            text-align: center;
        }
        .rekam-medis {
            margin-top: 10px;
            font-size: 1.2rem;
            font-weight: 500;
        }
        .btn-group {
            position: absolute;
            top: 200px;
            left: 4cm;
            display: flex;
            gap: 10px;
        }
        .btn-primary, .btn-secondary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover, .btn-secondary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        .antrian-card {
            margin-top: 30px;
            width: 300px;
        }
    </style>
</head>
<body>
    <!-- Tombol Logout di pojok kanan atas -->
    <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>

    <div class="container d-flex flex-column align-items-center min-vh-100">
        <h2 class="fw-bold mb-3">Selamat Datang, <?php echo htmlspecialchars($username); ?></h2>
        <p class="rekam-medis">No Rekam Medis Anda: <strong><?php echo $no_rm; ?></strong></p>
        
        <!-- Button Group (Daftar Poli dan Riwayat Pasien) -->
        <div class="btn-group">
            <a href="form_pendaftaran.php" class="btn btn-primary">Daftar Poli</a>
            <a href="riwayat.php" class="btn btn-secondary">Riwayat Pasien</a>
        </div>
        
        <!-- Card Nomor Antrian -->
        <div class="card antrian-card text-center">
            <div class="card-body">
                <h5 class="card-title">Nomor Antrian Anda</h5>
                <p class="card-text display-4"><?php echo $no_antrian; ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
