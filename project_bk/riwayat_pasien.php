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

// Ambil riwayat pasien yang statusnya selesai
$stmt = $pdo->prepare("
    SELECT pasien.nama AS nama_pasien, periksa.tgl_periksa, daftar_poli.status
    FROM periksa
    JOIN daftar_poli ON periksa.id_daftar_poli = daftar_poli.id
    JOIN pasien ON daftar_poli.id_pasien = pasien.id
    WHERE daftar_poli.status = 'selesai'
    ORDER BY periksa.tgl_periksa DESC
");
$stmt->execute();
$riwayat_pasien = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pasien</title>
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
        <?php if ($riwayat_pasien): ?>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Tanggal Periksa</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($riwayat_pasien as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                            <td><?php echo htmlspecialchars($row['tgl_periksa']); ?></td>
                            <td><?php echo htmlspecialchars($row['status']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Belum ada riwayat pemeriksaan yang selesai.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
