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
$stmt = $pdo->prepare("SELECT dokter.nama AS nama_dokter, poli.nama_poli FROM dokter JOIN poli ON dokter.id_poli = poli.id WHERE dokter.id = :dokter_id");
$stmt->bindParam(':dokter_id', $dokter_id);
$stmt->execute();
$dokter = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dokter) {
    echo "Data tidak ditemukan.";
    exit();
}

// Ambil data pasien dari daftar_poli
$stmt_pasien = $pdo->prepare("SELECT daftar_poli.id_pasien, pasien.nama AS nama_pasien, daftar_poli.keluhan, daftar_poli.status FROM daftar_poli JOIN pasien ON daftar_poli.id_pasien = pasien.id");
$stmt_pasien->execute();
$pasien_data = $stmt_pasien->fetchAll(PDO::FETCH_ASSOC);

// Proses pembaruan status pasien jika ada form yang disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_pasien'], $_POST['status'])) {
    $id_pasien = $_POST['id_pasien'];
    $status = $_POST['status'];

    // Update status pasien
    $update_stmt = $pdo->prepare("UPDATE daftar_poli SET status = :status WHERE id_pasien = :id_pasien");
    $update_stmt->bindParam(':status', $status);
    $update_stmt->bindParam(':id_pasien', $id_pasien);
    $update_stmt->execute();

    // Redirect untuk menampilkan pembaruan
    header("Location: periksa_pasien.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Periksa Pasien</title>
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
        .btn-container {
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .profil-btn {
            background-color: #1a6fdc;
            color: white;
            margin-right: 10px;
        }
        .profil-btn:hover {
            background-color: #1a6fdc;
            color: white;
        }
        .jadwal-btn {
            margin-top: 80px;
            margin-left: 85px; 
        }
        .table-container {
            margin: 50px auto;
            width: 90%;
        }
        .table-bordered {
            border: 1px solid black;
        }
        .table-bordered th, 
        .table-bordered td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="m-0">Selamat Datang <?php echo htmlspecialchars($dokter['nama_dokter']); ?></h1>
        <h3 class="m-0">Anda Praktek Pada <?php echo htmlspecialchars($dokter['nama_poli']); ?></h3>

        <div class="text-start jadwal-btn">
            <a href="dokter.php" class="btn btn-primary">Input Jadwal Periksa</a>
            <a href="periksa_pasien.php" class="btn btn-primary">Periksa Pasien</a>
            <a href="riwayat_pasien.php" class="btn btn-primary">Riwayat Pasien</a>
        </div>

        <div class="btn-container">
            <a href="perbarui_data_dokter.php" class="btn profil-btn">Profil</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>

    <div class="table-container">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Pasien</th>
                    <th>Keluhan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pasien_data) > 0): ?>
                    <?php foreach ($pasien_data as $index => $pasien): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($pasien['nama_pasien']); ?></td>
                            <td><?php echo htmlspecialchars($pasien['keluhan']); ?></td>
                            <td><?php echo htmlspecialchars($pasien['status']); ?></td>
                            <td>
                                <a href="periksa.php?id=<?php echo $pasien['id_pasien']; ?>" class="btn btn-warning btn-sm">Periksa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada pasien terdaftar</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
