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

// Cek apakah ID poli ada dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data poli berdasarkan ID
    $sql = "SELECT * FROM poli WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data poli
        $row = $result->fetch_assoc();
        $nama_poli = $row['nama_poli'];
        $keterangan = $row['keterangan'];
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak valid!";
    exit();
}

// Proses pembaruan data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];

    // Query untuk mengupdate data poli
    $sql = "UPDATE poli SET nama_poli = '$nama_poli', keterangan = '$keterangan' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman kelola poli
        header("Location: kelola_poli.php");
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
    <title>Form Edit Poli</title>
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
                    <h5 class="card-title mb-4 text-center">Form Edit Poli</h5>
                    <form action="edit_poli.php?id=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="namaPoli" class="form-label">Nama Poli</label>
                            <input type="text" class="form-control" id="namaPoli" name="nama_poli" value="<?php echo $nama_poli; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required><?php echo $keterangan; ?></textarea>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
