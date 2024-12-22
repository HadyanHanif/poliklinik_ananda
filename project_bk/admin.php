<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background-color: #1a6fdc;
            color: white;
        }
        .sidebar .nav-link {
            color: white;
        }
        .sidebar .nav-link:hover {
            background-color: #155bb5;
        }
        /* Styling untuk button logout */
        .logout-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Navbar Kiri -->
            <div class="col-md-3 col-lg-2 sidebar vh-100 d-flex flex-column p-3">
                <h4 class="text-center mb-4">Menu</h4>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold" href="kelola_pasien.php">Kelola Pasien</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_dokter.php">Kelola Dokter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_obat.php">Kelola Obat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="kelola_poli.php">Kelola Poli</a>
                    </li>
                </ul>
            </div>
            
            <!-- Konten Utama -->
            <div class="col-md-9 col-lg-10 d-flex justify-content-center align-items-center vh-100">
                <h2 class="fw-bold text-center">Selamat Datang Admin</h2>
            </div>
        </div>
    </div>

    <!-- Tombol Logout -->
    <button class="logout-btn" onclick="window.location.href='index.php';">Logout</button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
