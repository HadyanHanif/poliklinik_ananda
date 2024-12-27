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

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['dokter_id'])) {
    header('Location: login_dokter.php');
    exit();
}

// Ambil data jadwal berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM jadwal_periksa WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $jadwal = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$jadwal) {
        echo "Jadwal tidak ditemukan.";
        exit();
    }
} else {
    echo "ID jadwal tidak ditemukan.";
    exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $status = $_POST['status'];

    $updateStmt = $pdo->prepare("UPDATE jadwal_periksa SET hari = :hari, jam_mulai = :jam_mulai, jam_selesai = :jam_selesai, status = :status WHERE id = :id");
    $updateStmt->bindParam(':hari', $hari);
    $updateStmt->bindParam(':jam_mulai', $jam_mulai);
    $updateStmt->bindParam(':jam_selesai', $jam_selesai);
    $updateStmt->bindParam(':status', $status);
    $updateStmt->bindParam(':id', $id);

    if ($updateStmt->execute()) {
        echo "<script>alert('Jadwal berhasil diperbarui!'); window.location.href = 'dokter.php';</script>";
    } else {
        echo "Terjadi kesalahan saat memperbarui jadwal.";
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>
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
    </style>
</head>
<body>
    <div class="container center-card">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 text-center">Edit Jadwal Periksa</h5>
                    <form action="edit_jadwal.php?id=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select class="form-control" id="hari" name="hari" required>
                                <option value="Senin" <?php echo ($jadwal['hari'] == 'Senin') ? 'selected' : ''; ?>>Senin</option>
                                <option value="Selasa" <?php echo ($jadwal['hari'] == 'Selasa') ? 'selected' : ''; ?>>Selasa</option>
                                <option value="Rabu" <?php echo ($jadwal['hari'] == 'Rabu') ? 'selected' : ''; ?>>Rabu</option>
                                <option value="Kamis" <?php echo ($jadwal['hari'] == 'Kamis') ? 'selected' : ''; ?>>Kamis</option>
                                <option value="Jumat" <?php echo ($jadwal['hari'] == 'Jumat') ? 'selected' : ''; ?>>Jumat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jamMulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jamMulai" name="jam_mulai" value="<?php echo $jadwal['jam_mulai']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="jamSelesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jamSelesai" name="jam_selesai" value="<?php echo $jadwal['jam_selesai']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Aktif" <?php echo ($jadwal['status'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                                <option value="Tidak Aktif" <?php echo ($jadwal['status'] == 'Tidak Aktif') ? 'selected' : ''; ?>>Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
