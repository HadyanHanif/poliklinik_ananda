<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$dbname = 'poli';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Periksa apakah dokter sudah login
if (!isset($_SESSION['dokter_id'])) {
    header('Location: login_dokter.php');
    exit();
}

// Ambil data dokter dan poli
$dokter_id = $_SESSION['dokter_id'];
$stmt = $pdo->prepare("
    SELECT dokter.nama AS nama_dokter, poli.nama_poli 
    FROM dokter 
    JOIN poli ON dokter.id_poli = poli.id 
    WHERE dokter.id = :dokter_id
");
$stmt->bindParam(':dokter_id', $dokter_id);
$stmt->execute();
$dokter = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dokter) {
    echo "Data tidak ditemukan.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eeeded;
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            width: 100%;
            padding: 20px 0;
            text-align: center;
        }
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
        }
    </style>
</head>
<body>
    <!-- Header bagian atas -->
    <div class="header">
        <h1 class="m-0">Selamat Datang <?php echo htmlspecialchars($dokter['nama_dokter']); ?></h1>
        <h3 class="m-0">Anda Praktek Pada <?php echo htmlspecialchars($dokter['nama_poli']); ?></h3>

        <!-- Tombol Logout di pojok kanan atas -->
        <a href="logout.php" class="btn btn-danger logout-btn">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
