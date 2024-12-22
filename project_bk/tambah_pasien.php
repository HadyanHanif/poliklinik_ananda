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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];

    // Ambil tahun dan bulan saat ini
    $tahun_bulan = date("Ym"); // Format: YYYYMM
    
    // Query untuk menghitung jumlah pasien yang sudah terdaftar pada bulan ini
    $sql_count = "SELECT COUNT(*) AS count FROM pasien WHERE no_rm LIKE '$tahun_bulan%'";
    $result = $conn->query($sql_count);
    $row = $result->fetch_assoc();
    $urutan = $row['count'] + 1; // Urutan pasien keberapa
    
    // Format nomor rekam medis (no_rm) misal: 202411-101
    $no_rm = $tahun_bulan . '-' . str_pad($urutan, 3, '0', STR_PAD_LEFT);
    
    // Query untuk memasukkan data ke dalam tabel pasien
    $sql = "INSERT INTO pasien (no_rm, nama, password, alamat, no_ktp, no_hp) 
            VALUES ('$no_rm', '$nama', '$password', '$alamat', '$no_ktp', '$no_hp')";

    if ($conn->query($sql) === TRUE) {
        // Jika data berhasil dimasukkan, redirect ke halaman kelola pasien
        header("Location: kelola_pasien.php");
        exit();
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
    <title>Form Tambah Pasien</title>
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
                    <h5 class="card-title mb-4 text-center">Form Tambah Pasien</h5>
                    <form action="tambah_pasien.php" method="POST">
                        <div class="mb-3">
                            <label for="namaPasien" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="namaPasien" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_ktp" class="form-label">No KTP</label>
                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                        </div>
                        
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
