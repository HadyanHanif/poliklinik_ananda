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

// Ambil jadwal periksa berdasarkan dokter yang login
$stmt_jadwal = $pdo->prepare("SELECT jp.id, d.nama AS nama_dokter, jp.hari, jp.jam_mulai, jp.jam_selesai, jp.status FROM jadwal_periksa jp JOIN dokter d ON jp.id_dokter = d.id WHERE d.id = :dokter_id");
$stmt_jadwal->bindParam(':dokter_id', $dokter_id);
$stmt_jadwal->execute();
$jadwal_list = $stmt_jadwal->fetchAll(PDO::FETCH_ASSOC);
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
            <a href="jadwal.php" class="btn btn-primary">Input Jadwal Periksa</a>
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
                    <th>Nama Dokter</th>
                    <th>Hari</th>
                    <th>Jam Mulai</th>
                    <th>Jam Selesai</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($jadwal_list) > 0): ?>
                    <?php foreach ($jadwal_list as $index => $jadwal): ?>
                        <tr>
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo htmlspecialchars($jadwal['nama_dokter']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['hari']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['jam_mulai']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['jam_selesai']); ?></td>
                            <td><?php echo htmlspecialchars($jadwal['status']); ?></td>
                            <td>
                                <a href="edit_jadwal.php?id=<?php echo $jadwal['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada jadwal periksa</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
