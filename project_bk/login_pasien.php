<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Menggunakan Bootstrap 5 dari CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Menambahkan CSS untuk warna latar belakang, tombol, dan border -->
    <style>
        body {
            background-color: #eeeded; /* Latar belakang halaman */
        }

        .card {
            border: 2px solid #070707; /* Border card */
        }

        .btn-primary {
            background-color: #34de36; /* Warna tombol */
            border-color: #070707; /* Border tombol */
        }

        .btn-primary:hover {
            background-color: #2bbc2b; /* Warna tombol saat hover */
            border-color: #070707; /* Border tombol saat hover */
        }

        .card-footer {
            text-align: center; /* Memastikan teks berada di tengah */
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <!-- Menampilkan judul Login yang berada di tengah dan bold -->
        <h2 class="text-center fw-bold mb-4">Login</h2>

        <!-- Card untuk form login dan teks 'Belum punya akun?' -->
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Form Login -->
                        <form action="proses_login.php" method="POST">
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
                    <!-- Bagian bawah card untuk teks 'Belum punya akun?' -->
                    <div class="card-footer">
                        <p>Belum punya akun? <a href="regis_pasien.php">Daftar di sini</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menambahkan JS untuk Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
