<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        <h2 class="text-center fw-bold mb-4">Login</h2>
        <div class="row justify-content-center w-100">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="loginForm">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').onsubmit = function(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (username === 'adminpoli' && password === 'poli123') {
                window.location.href = 'admin.php';
            } else {
                alert('Username atau password salah');
            }
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
