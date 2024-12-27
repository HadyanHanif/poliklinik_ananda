<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Poliklinik Sehat Bahagia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #eeeded;
        }
        .center-screen {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
        .card {
            background-color: #1a6fdc;
            border-color: #070707;
            color: white;
        }
        .btn-login {
            background-color: #34de36;
            border-color: #070707;
        }
        .btn-login:hover {
            background-color: #2cb92f;
            border-color: #070707;
        }
    </style>
</head>
<body>
    <div class="container center-screen text-center">
        <h2 class="fw-bold">Selamat Datang di Poliklinik Sehat Bahagia</h2>
        
        <div class="row mt-5 justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login Sebagai Pasien</h5>
                        <p class="card-text">Klik tombol di bawah untuk masuk sebagai pasien.</p>
                        <a href="login_pasien.php" class="btn btn-login">Login</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login Sebagai Dokter</h5>
                        <p class="card-text">Klik tombol di bawah untuk masuk sebagai dokter.</p>
                        <a href="login_dokter.php" class="btn btn-login">Login</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Login Sebagai Admin</h5>
                        <p class="card-text">Klik tombol di bawah untuk masuk sebagai admin.</p>
                        <a href="login_admin.php" class="btn btn-login">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
