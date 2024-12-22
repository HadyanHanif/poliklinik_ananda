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

// Cek apakah ID poli ada dalam URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data poli berdasarkan ID
    $sql = "DELETE FROM poli WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, redirect ke halaman kelola poli
        header("Location: kelola_poli.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak valid!";
    exit();
}

$conn->close();
?>
