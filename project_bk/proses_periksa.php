<?php
session_start();
$host = 'localhost';
$dbname = 'poli';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Periksa apakah dokter sudah login
if (!isset($_SESSION['dokter_id'])) {
    header('Location: login_dokter.php');
    exit();
}

// Periksa apakah ada data yang dikirimkan melalui POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_pasien = $_POST['id_pasien'];
    $keluhan = $_POST['keluhan'];
    $catatan = $_POST['catatan'];
    $biaya_periksa = $_POST['biaya_periksa'];
    $status = $_POST['status'];
    $obat_id = $_POST['obat'];

    // Dapatkan ID Daftar Poli terkait dengan Pasien
    $stmt_daftar_poli = $pdo->prepare("SELECT id FROM daftar_poli WHERE id_pasien = :id_pasien ORDER BY id DESC LIMIT 1");
    $stmt_daftar_poli->bindParam(':id_pasien', $id_pasien);
    $stmt_daftar_poli->execute();
    $daftar_poli = $stmt_daftar_poli->fetch(PDO::FETCH_ASSOC);

    if (!$daftar_poli) {
        echo "Data daftar poli tidak ditemukan.";
        exit();
    }

    $id_daftar_poli = $daftar_poli['id'];

    // Simpan data periksa ke dalam tabel periksa
    $stmt_periksa = $pdo->prepare("INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa, id_pasien) 
                                  VALUES (:id_daftar_poli, NOW(), :catatan, :biaya_periksa, :id_pasien)");
    $stmt_periksa->bindParam(':id_daftar_poli', $id_daftar_poli);
    $stmt_periksa->bindParam(':catatan', $catatan);
    $stmt_periksa->bindParam(':biaya_periksa', $biaya_periksa);
    $stmt_periksa->bindParam(':id_pasien', $id_pasien);
    $stmt_periksa->execute();

    // Update status pasien di tabel daftar_poli
    $stmt_update_status = $pdo->prepare("UPDATE daftar_poli SET status = :status WHERE id = :id_daftar_poli");
    $stmt_update_status->bindParam(':status', $status);
    $stmt_update_status->bindParam(':id_daftar_poli', $id_daftar_poli);
    $stmt_update_status->execute();

    // Redirect ke halaman periksa atau halaman lain setelah berhasil
    header('Location: periksa_pasien.php');
    exit();
}
?>
