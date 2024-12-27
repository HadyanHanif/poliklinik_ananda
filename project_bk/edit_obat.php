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

// Mendapatkan ID obat yang akan diedit
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query untuk mendapatkan data obat berdasarkan ID
    $sql = "SELECT * FROM obat WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        die("Data obat tidak ditemukan.");
    }
} else {
    die("ID obat tidak ditemukan.");
}

// Menyimpan perubahan data obat
if (isset($_POST['submit'])) {
    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'];
    $harga = $_POST['harga'];

    $update_sql = "UPDATE obat SET nama_obat = '$nama_obat', kemasan = '$kemasan', harga = '$harga' WHERE id = $id";
    
    if ($conn->query($update_sql) === TRUE) {
        header("Location: kelola_obat.php"); // Redirect ke halaman kelola_obat.php
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Obat</title>
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
                    <h5 class="card-title mb-4 text-center">Form Edit Obat</h5>
                    <form method="POST">
                        <div class="mb-3">
                            <label for="nama_obat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="<?= $row['nama_obat']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kemasan" class="form-label">Kemasan</label>
                            <select class="form-select" id="kemasan" name="kemasan" required>
                                <option value="Kapsul" <?= $row['kemasan'] == 'Kapsul' ? 'selected' : ''; ?>>Kapsul</option>
                                <option value="Tablet" <?= $row['kemasan'] == 'Tablet' ? 'selected' : ''; ?>>Tablet</option>
                                <option value="Cair" <?= $row['kemasan'] == 'Cair' ? 'selected' : ''; ?>>Cair</option>
                                <option value="Bubuk" <?= $row['kemasan'] == 'Bubuk' ? 'selected' : ''; ?>>Bubuk</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" value="<?= $row['harga']; ?>" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
