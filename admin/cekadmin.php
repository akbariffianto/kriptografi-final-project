<?php
session_start();
include "../koneksi.php";

$email = $_POST["email"];
$password = $_POST["password"];
$hashedPassword = hash('sha256', $password);

$hasil = mysqli_query($konek, "SELECT * FROM admin WHERE email='$email' AND password='$hashedPassword'");
$data = mysqli_fetch_array($hasil);
$cek = mysqli_num_rows($hasil);

if ($cek > 0) {
    $_SESSION['adminid'] = $data['adminid'];
    $_SESSION['email'] = $email;
    $_SESSION['password'] = $hashedPassword;
    
    header('location:pesanan.php'); 
} else {
    header('location:loginadmin.php?pesan=gagal');
}

mysqli_close($konek);
?>
