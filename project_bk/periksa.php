<?php
session_start();
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

// Periksa apakah ada ID pasien di URL
if (!isset($_GET['id'])) {
    echo "Pasien tidak ditemukan.";
    exit();
}

$id_pasien = $_GET['id'];

// Ambil data pasien
$stmt = $pdo->prepare("SELECT pasien.nama, daftar_poli.keluhan, daftar_poli.status FROM daftar_poli JOIN pasien ON daftar_poli.id_pasien = pasien.id WHERE pasien.id = :id_pasien");
$stmt->bindParam(':id_pasien', $id_pasien);
$stmt->execute();
$pasien = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pasien) {
    echo "Data pasien tidak ditemukan.";
    exit();
}

// Ambil data obat dari database
$stmt_obat = $pdo->query("SELECT id, nama_obat, harga FROM obat");
$obat_list = $stmt_obat->fetchAll(PDO::FETCH_ASSOC);
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
                    <h5 class="card-title mb-4 text-center">Periksa Pasien</h5>
                    <form action="proses_periksa.php" method="POST">
                        <input type="hidden" name="id_pasien" value="<?php echo htmlspecialchars($id_pasien); ?>">
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama" value="<?php echo htmlspecialchars($pasien['nama']); ?>" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Keluhan</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3" disabled><?php echo htmlspecialchars($pasien['keluhan']); ?></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="obat" class="form-label">Obat</label>
                            <select class="form-control" id="obat" name="obat" onchange="hitungBiaya()">
                                <option value="">Pilih Obat</option>
                                <?php foreach ($obat_list as $obat): ?>
                                    <option value="<?php echo $obat['id']; ?>" data-harga="<?php echo $obat['harga']; ?>">
                                        <?php echo htmlspecialchars($obat['nama_obat']) . ' - Rp' . number_format($obat['harga'], 0, ',', '.'); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="biaya_periksa" class="form-label">Biaya Periksa</label>
                            <input type="text" class="form-control" id="biaya_periksa" name="biaya_periksa" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" name="status" id="status">
                                <option value="Menunggu" <?php if($pasien['status'] == 'Menunggu') echo 'selected'; ?>>Menunggu</option>
                                <option value="Diperiksa" <?php if($pasien['status'] == 'Diperiksa') echo 'selected'; ?>>Diperiksa</option>
                                <option value="Selesai" <?php if($pasien['status'] == 'Selesai') echo 'selected'; ?>>Selesai</option>
                            </select>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        <a href="periksa_pasien.php" class="btn btn-secondary mt-3">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function hitungBiaya() {
            const biayaDokter = 150000;
            const selectObat = document.getElementById('obat');
            const hargaObat = selectObat.options[selectObat.selectedIndex].dataset.harga || 0;
            const totalBiaya = parseInt(hargaObat) + biayaDokter;
            document.getElementById('biaya_periksa').value = totalBiaya;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
