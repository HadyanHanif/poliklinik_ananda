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

// Ambil no rekam medis pasien berdasarkan nama
$query = "SELECT no_rm FROM pasien WHERE nama = '$username'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $no_rm = $row['no_rm'];
} else {
    echo "Pasien tidak ditemukan!";
    exit();
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
    </style>
</head>
<body>
    <!-- Tombol Logout di pojok kanan atas -->
    <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>

    <div class="container d-flex flex-column align-items-center min-vh-100">
        <h2 class="fw-bold mb-3">Selamat Datang, <?php echo htmlspecialchars($username); ?></h2>
        <p class="rekam-medis">No Rekam Medis Anda: <strong><?php echo $no_rm; ?></strong></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
