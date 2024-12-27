<?php
session_start();

// Koneksi ke database
$host = 'localhost';
$dbname = 'poli';
$username = 'root';  // Sesuaikan dengan username database Anda
$password = '';  // Sesuaikan dengan password database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data dokter
    $stmt = $pdo->prepare("SELECT * FROM dokter WHERE nama = :username AND password = :password");
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $password);
    $stmt->execute();

    $dokter = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($dokter) {
        // Login berhasil
        $_SESSION['dokter_id'] = $dokter['id'];
        $_SESSION['dokter_nama'] = $dokter['nama'];
        header('Location: dokter.php');
        exit();
    } else {
        // Login gagal
        echo "<script>alert('Username atau Password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Dokter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eeeded;
        }
        .card {
            border: 2px solid #070707;
        }
        .btn-primary {
            background-color: #34de36;
            border-color: #070707;
        }
        .btn-primary:hover {
            background-color: #2bbc2b;
            border-color: #070707;
        }
        .card-footer {
            text-align: center;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-center fw-bold mb-4">Login Dokter</h2>
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="login_dokter.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
