<?php
session_start();
include "../koneksi.php";

$email = $_POST["email"];
$password = $_POST["password"];

// Menyiapkan query untuk memeriksa kredensial pengguna di tabel admin
$hasil = mysqli_query($konek, "SELECT * FROM users WHERE email_user='$email' AND password='$password'");

// Mengambil data dari hasil query
$data = mysqli_fetch_array($hasil);

$cek = mysqli_num_rows($hasil);

if ($cek > 0) {
    $_SESSION['uid'] = $data['uid'];
    $_SESSION['email_user'] = $email;
    
    header('location:../class/class.php'); 
} else {
    header('location:../index.php?pesan=gagal');
}

mysqli_close($konek);
?>
