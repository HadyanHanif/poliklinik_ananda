<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
    </style>
</head>
<body>
    <div class="container min-vh-100 d-flex flex-column justify-content-center align-items-center">
        <h2 class="text-center fw-bold mb-4">Register</h2>
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <!-- Form Register mengarah ke proses_register.php -->
                        <form action="proses_register.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_ktp" class="form-label">No. KTP</label>
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" required>
                            </div>
                            <div class="mb-3">
                                <label for="no_hp" class="form-label">No. HP</label>
                                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
