<?php
include '../../connect/koneksi.php';
session_start();
if (empty($_SESSION['username'])) {
    header("Location: ../../dashboard/index.php?pesan=belum_login");
    exit();
}

// Mengambil parameter 'idPegawai' dari URL
$id = $_GET['idPegawai'];

// Menjalankan query SQL untuk menghapus data pegawai berdasarkan ID
$query = mysqli_query($konek, "DELETE FROM datapegawai WHERE id = '$id'");

// Mengecek apakah query berhasil dijalankan
if ($query) {
    $_SESSION['notification'] = 'Data Pegawai berhasil dihapus';
} else {
    $_SESSION['notification'] = 'Gagal menghapus Data Pegawai';
}

header('location:../tampilanAdmin.php');
?>
