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

// Mendapatkan ID obat yang akan dihapus
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Query untuk menghapus data obat berdasarkan ID
    $sql = "DELETE FROM obat WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: kelola_obat.php"); // Redirect ke halaman kelola_obat.php
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    die("ID obat tidak ditemukan.");
}

$conn->close();
?>
