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

// Cek apakah ID dokter ada dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data dokter berdasarkan ID
    $sql = "SELECT * FROM dokter WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Ambil data dokter
        $row = $result->fetch_assoc();
        $nama_dokter = $row['nama'];
        $password = $row['password'];
        $no_hp = $row['no_hp'];
        $id_poli = $row['id_poli'];
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak valid!";
    exit();
}

// Query untuk mengambil data poli untuk dropdown
$sql_poli = "SELECT id, nama_poli FROM poli";
$result_poli = $conn->query($sql_poli);

// Proses pembaruan data ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_dokter = $_POST['nama_dokter'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $id_poli = $_POST['id_poli'];

    // Query untuk mengupdate data dokter
    $sql = "UPDATE dokter SET nama = '$nama_dokter', password = '$password', no_hp = '$no_hp', id_poli = '$id_poli' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman kelola dokter
        header("Location: kelola_dokter.php");
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
    <title>Form Edit Dokter</title>
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
                    <h5 class="card-title mb-4 text-center">Form Edit Dokter</h5>
                    <form action="edit_dokter.php?id=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="namaDokter" class="form-label">Nama Dokter</label>
                            <input type="text" class="form-control" id="namaDokter" name="nama_dokter" value="<?php echo $nama_dokter; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $password; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="noHp" class="form-label">No Hp</label>
                            <input type="text" class="form-control" id="noHp" name="no_hp" value="<?php echo $no_hp; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="idPoli" class="form-label">ID Poli</label>
                            <select class="form-control" id="idPoli" name="id_poli" required>
                                <option value="" disabled selected>Pilih Poli</option>
                                <?php
                                // Menampilkan daftar poli untuk dropdown
                                while ($row_poli = $result_poli->fetch_assoc()) {
                                    $selected = ($id_poli == $row_poli['id']) ? "selected" : "";
                                    echo "<option value='" . $row_poli['id'] . "' $selected>" . $row_poli['nama_poli'] . "</option>";
                                }
                                ?>
                            </select>
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
