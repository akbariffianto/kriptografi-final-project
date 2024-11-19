<?php
include '../koneksi.php';

session_start();
if (empty($_SESSION['email_user'])) {
    header("location:../index.php?pesan=belum_login");
}
$id = $_POST['id_code_class'];

if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

if (isset($_FILES['foto_enkrip'])) {
    $image_path = $_FILES['foto_enkrip']['tmp_name'];
    $image_data = file_get_contents($image_path);

    // Ekstrak pesan dari data gambar
    if (preg_match('/<!--(.*?)-->/', $image_data, $matches)) {
        $embedded_text = $matches[1]; // Pesan yang disisipkan
    } else {
        $embedded_text = "Tidak ada pesan yang ditemukan di dalam gambar.";
    }

    // Tampilkan pesan pada halaman berikutnya
    $_SESSION['embedded_text'] = $embedded_text; // Simpan untuk digunakan di halaman lain
    header("Location: deskripkode.php?id=$id"); // Redirect ke halaman untuk menampilkan pesan
    exit();
}
?>
