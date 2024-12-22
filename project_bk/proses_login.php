<?php
// Memulai session
session_start();

// Menghubungkan ke database
$servername = "localhost"; // Ganti dengan server database Anda
$username = "root";        // Ganti dengan username database Anda
$password = "";            // Ganti dengan password database Anda
$dbname = "poli";          // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan input username dan password dari form
$user = $_POST['username'];
$pass = $_POST['password'];

// Menyiapkan query untuk mencari username dan password dari tabel pasien
$sql = "SELECT * FROM pasien WHERE nama = ? AND password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $user, $pass); // Mengikat parameter untuk menghindari SQL injection
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah ada data yang ditemukan
if ($result->num_rows > 0) {
    // Login berhasil, simpan data session
    $_SESSION['username'] = $user;
    // Arahkan ke halaman pasien.php
    header("Location: pasien.php");
    exit();
} else {
    // Login gagal, tampilkan pesan error
    echo "<script>alert('Username atau Password salah!'); window.location.href='login_pasien.php';</script>";
}

// Menutup koneksi
$stmt->close();
$conn->close();
?>
