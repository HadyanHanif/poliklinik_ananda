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

// Ambil data dari form
$nama_obat = $_POST['nama_obat'];
$kemasan = $_POST['kemasan'];
$harga = $_POST['harga'];

// Query untuk insert data ke dalam tabel obat
$sql = "INSERT INTO obat (nama_obat, kemasan, harga) VALUES ('$nama_obat', '$kemasan', '$harga')";

// Eksekusi query dan cek hasilnya
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='tambah_obat.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Tutup koneksi
$conn->close();
?>
