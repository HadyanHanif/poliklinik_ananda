<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "poli";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$poliQuery = "SELECT id, nama_poli FROM poli";
$poliResult = $conn->query($poliQuery);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan ID Pasien tersedia
    if (!isset($_SESSION['id_pasien']) && !empty($_POST['no_rm'])) {
        $no_rm = $_POST['no_rm'];

        // Cari id_pasien berdasarkan no_rm
        $query = "SELECT id FROM pasien WHERE no_rm = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $no_rm);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if ($row) {
            $id_pasien = $row['id'];
        } else {
            die("Nomor Rekam Medis tidak ditemukan.");
        }
    } elseif (isset($_SESSION['id_pasien'])) {
        $id_pasien = $_SESSION['id_pasien'];
    } else {
        die("ID Pasien atau Nomor Rekam Medis harus tersedia.");
    }

    $id_jadwal = $_POST['id_jadwal'];
    $keluhan = $_POST['keluhan'];

    // Mendapatkan nomor antrian berikutnya berdasarkan jadwal yang dipilih
    $antrianQuery = "SELECT MAX(no_antrian) AS max_antrian FROM daftar_poli WHERE id_jadwal = ? AND no_antrian IS NOT NULL";
    $stmt = $conn->prepare($antrianQuery);
    $stmt->bind_param("i", $id_jadwal);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $no_antrian = ($row['max_antrian'] ?? 0) + 1;

    // Menyimpan pendaftaran ke dalam tabel daftar_poli
    $insertQuery = "INSERT INTO daftar_poli (id_pasien, id_jadwal, keluhan, no_antrian) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("iisi", $id_pasien, $id_jadwal, $keluhan, $no_antrian);

    if ($stmt->execute()) {
        echo "<p>Pendaftaran berhasil! Nomor antrian Anda: $no_antrian</p>";
    } else {
        echo "<p>Gagal mendaftar: " . $stmt->error . "</p>";
    }
}

if (isset($_GET['poli_id']) && is_numeric($_GET['poli_id'])) {
    $poli_id = $_GET['poli_id'];

    $query = "
        SELECT jp.id, jp.hari, jp.jam_mulai, jp.jam_selesai
        FROM jadwal_periksa jp
        JOIN dokter d ON jp.id_dokter = d.id
        WHERE d.id_poli = ? AND jp.status = 'aktif'
        ORDER BY jp.hari, jp.jam_mulai
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $poli_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $jadwal = "{$row['hari']}, {$row['jam_mulai']} - {$row['jam_selesai']}";
            echo "<option value=\"{$row['id']}\">$jadwal</option>";
        }
    } else {
        echo "<option value=\"\">Tidak ada jadwal tersedia</option>";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function loadJadwal(poliId) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', `?poli_id=${poliId}`, true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    document.getElementById('jadwal').innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }
    </script>
</head>
<body style="background-color: #f4f4f9;">
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4 text-center">Form Pendaftaran</h5>
                    <form method="POST">
                        <?php if (!isset($_SESSION['id_pasien'])): ?>
                            <div class="mb-3">
                                <label for="no_rm" class="form-label">Nomor Rekam Medis (No. RM):</label>
                                <input type="text" name="no_rm" id="no_rm" class="form-control" required>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="poli" class="form-label">Pilih Poli:</label>
                            <select name="poli" id="poli" class="form-control" onchange="loadJadwal(this.value)" required>
                                <option value="">-- Pilih Poli --</option>
                                <?php while ($row = $poliResult->fetch_assoc()): ?>
                                    <option value="<?php echo $row['id']; ?>">
                                        <?php echo $row['nama_poli']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Pilih Jadwal:</label>
                            <select name="id_jadwal" id="jadwal" class="form-control" required>
                                <option value="">-- Pilih Jadwal --</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Keluhan:</label>
                            <textarea name="keluhan" id="keluhan" class="form-control" rows="4" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Daftar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
