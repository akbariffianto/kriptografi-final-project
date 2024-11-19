<?php
include "../koneksi.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$emailHandling = ['@gmail.com', '@yahoo.com', '@outlook.com'];
$validEmail = false;
foreach ($emailHandling as $domain) {
    if (strpos($email, $domain) !== false) {
        $validEmail = true;
        break;
    }
}

if (!$validEmail) {
    header('Location: ../index.php?pesan=emailValid');
    exit();
}

$query_email = "SELECT * FROM users WHERE email_user='$email'";
$result_email = mysqli_query($konek, $query_email);

if (mysqli_num_rows($result_email) > 0) {
    header('location:../index.php?pesan=emailTerdaftar');
    exit();
}

$query = "INSERT INTO users (nama_lengkap, email_user, password) VALUES ('$name', '$email', '$password')";
$result = mysqli_query($konek, $query);

if ($result) {
    header("Location: ../index.php?pesan=berhasil");
    exit();
} else {
    header('Location: ../index.php?pesan=gagal');
}

mysqli_close($konek);
?>
