<?php
// Konfigurasi database
$host = 'localhost';
$dbname = 'poli';
$username = 'root';
$password = '';

try {
    // Membuat koneksi ke database menggunakan PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query untuk mengambil data dari tabel-tabel
    $query = "
        SELECT 
            pasien.nama AS nama_pasien,
            periksa.biaya_periksa AS biaya,
            daftar_poli.status AS status
        FROM 
            daftar_poli
        INNER JOIN pasien ON daftar_poli.id_pasien = pasien.id
        INNER JOIN periksa ON periksa.id_daftar_poli = daftar_poli.id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Mendapatkan hasil
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pemeriksaan</title>
    <!-- Add Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #000; /* Set header background color to black */
            color: black; /* Set text color to black */
        }
        td {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
        }
        .container {
            margin-top: 30px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="fw-bold mb-4 text-center">Riwayat Pemeriksaan</h1>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>Biaya</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($results)): ?>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                                <td><?php echo htmlspecialchars(number_format($row['biaya'] ?? 0, 2)); ?></td>
                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="no-data">Tidak ada data ditemukan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
