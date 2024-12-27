<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$database = "poli";

$conn = new mysqli($servername, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data dokter untuk dropdown
$sql_dokter = "SELECT id, nama FROM dokter";
$result_dokter = $conn->query($sql_dokter);

// Proses saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_dokter = $_POST['id_dokter'];
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'];
    $jam_selesai = $_POST['jam_selesai'];
    $status = $_POST['status']; // Ambil nilai status dari form

    // Query untuk menambah jadwal ke dalam database
    $sql = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai, status) 
            VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Jadwal berhasil ditambahkan!');</script>";
        // Redirect ke halaman dokter.php setelah data berhasil ditambahkan
        header('Location: dokter.php');
        exit();  // Pastikan script berhenti setelah redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal</title>
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
                    <h5 class="card-title mb-4 text-center">Tambah Jadwal Periksa</h5>
                    <form action="jadwal.php" method="POST">
                        <div class="mb-3">
                            <label for="idDokter" class="form-label">Pilih Dokter</label>
                            <select class="form-control" id="idDokter" name="id_dokter" required>
                                <option value="" disabled selected>Pilih Dokter</option>
                                <?php
                                // Menampilkan daftar dokter untuk dropdown
                                while ($row_dokter = $result_dokter->fetch_assoc()) {
                                    echo "<option value='" . $row_dokter['id'] . "'>" . $row_dokter['nama'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="hari" class="form-label">Hari</label>
                            <select class="form-control" id="hari" name="hari" required>
                                <option value="" disabled selected>Pilih Hari</option>
                                <option value="Senin">Senin</option>
                                <option value="Selasa">Selasa</option>
                                <option value="Rabu">Rabu</option>
                                <option value="Kamis">Kamis</option>
                                <option value="Jumat">Jumat</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jamMulai" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="jamMulai" name="jam_mulai" required>
                        </div>
                        <div class="mb-3">
                            <label for="jamSelesai" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="jamSelesai" name="jam_selesai" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Tambah Jadwal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
