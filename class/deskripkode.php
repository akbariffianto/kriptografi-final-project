<?php
include '../koneksi.php';

session_start();

if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

$id = $_POST['id_code_class'];
$foto_enkrip = $_POST['foto_enkrip'];

mysqli_close($konek);
?>
