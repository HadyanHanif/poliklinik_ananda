<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "poli"; // Nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data dari form
$nama = $_POST['username'];
$password = $_POST['password'];
$alamat = $_POST['alamat'];
$no_ktp = $_POST['no_ktp'];
$no_hp = $_POST['no_hp'];

// Generate no_rm berdasarkan tahun, bulan, dan urutan pasien
$year_month = date('Ym'); // Format: TahunBulan (contoh: 202412)
$query = "SELECT COUNT(*) AS total FROM pasien WHERE no_rm LIKE '$year_month%'"; // Hitung jumlah pasien dengan no_rm yang dimulai dengan tahun-bulan
$result = $conn->query($query);
$row = $result->fetch_assoc();
$urutan = str_pad($row['total'] + 1, 3, '0', STR_PAD_LEFT); // Urutan pasien ke-berapa, padding dengan 0

$no_rm = $year_month . '-' . $urutan;

// Query untuk memasukkan data ke dalam database
$sql = "INSERT INTO pasien (no_rm, nama, password, alamat, no_ktp, no_hp) 
        VALUES ('$no_rm', '$nama', '$password', '$alamat', '$no_ktp', '$no_hp')";

// Mengeksekusi query
if ($conn->query($sql) === TRUE) {
    // Redirect ke halaman dashboard_pasien.php setelah berhasil
    header("Location: login_pasien.php");
    exit(); // Pastikan proses ini selesai dan tidak ada lagi kode yang dijalankan
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


// Menutup koneksi
$conn->close();
?>
