<?php
include "../koneksi.php";

$username = $_POST['username'];
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
    header('location:regist.php?pesan=emailValid');
    exit();
}

$query_email = "SELECT * FROM admin WHERE email='$email'";
$result_email = mysqli_query($konek, $query_email);

if (mysqli_num_rows($result_email) > 0) {
    header('location:registadmin.php?pesan=gagal');
    exit();
}

$query = "INSERT INTO admin (email, password) VALUES ('$email', '$password')";
$result = mysqli_query($konek, $query);

if ($result) {
    header("Location:loginadmin.php");
    exit();
} else {
    header('location:registadmin.php?pesan=gagal');
}
mysqli_close($konek);
?>
