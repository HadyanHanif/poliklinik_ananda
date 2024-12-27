<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Obat</title>
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
                    <h5 class="card-title mb-4 text-center">Form Tambah Obat</h5>
                    <form action="proses_tambah_obat.php" method="POST">
                        <div class="mb-3">
                            <label for="namaObat" class="form-label">Nama Obat</label>
                            <input type="text" class="form-control" id="namaObat" name="nama_obat" required>
                        </div>
                        <div class="mb-3">
                            <label for="kemasan" class="form-label">Kemasan</label>
                            <select class="form-select" id="kemasan" name="kemasan" required>
                                <option value="">Pilih Kemasan</option>
                                <option value="Kapsul">Kapsul</option>
                                <option value="Tablet">Tablet</option>
                                <option value="Cair">Cair</option>
                                <option value="Bubuk">Bubuk</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="harga" name="harga" required>
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

