<!doctype html>
<html lang="en">

<?php
session_start();
include '../koneksi.php';

if (empty($_SESSION['email_user'])) {
    header("location:../index.php?pesan=belum_login");
}

$classid = $_GET['id'];
$uid = $_SESSION['uid'];

$queryUser = "SELECT nama_lengkap FROM users WHERE uid='$uid'";
$resultUser = mysqli_query($konek, $queryUser);
$userData = mysqli_fetch_assoc($resultUser);

$namaLengkap = $userData ? $userData['nama_lengkap'] : "Pengguna";

$queryClass = "SELECT * FROM class WHERE classid='$classid'";
$resultClass = mysqli_query($konek, $queryClass);
$classData = mysqli_fetch_assoc($resultClass);

$queryClassAccess = "SELECT * FROM classes_access WHERE classid='$classid'";
$resultClassAccess = mysqli_query($konek, $queryClassAccess);

if (isset($_SESSION['notification'])) {
    echo "<script>alert('" . $_SESSION['notification'] . "');</script>";
    unset($_SESSION['notification']);
}
?>

<head>
    <title>Class Course</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid px-4 justify-content-between ">
            <h3 class="navbar-brand fs-3 text-center text-white fw-bold">Course Online</h3>
            <a href="../logout.php" class="btn btn-warning fw-bold">Logout</a>
        </div>
    </nav>
    <div class="container p-5 my-5 border border-5 border-success-subtle rounded-5">
        <a href="../class/courses/redeemtoken.php?id=<?= $classData['classid'] ?>" class="fw-bold">Kembali</a>
        <h2 class="fw-bold">Silahkan Input Foto</h2>
        <h4>Foto yang diinput akan diselipkan sebuah kode akses oleh admin</h4>
        <div class="row mt-3 gx-5 gy-5">
            <h5>Nama Kelas yang akan dipesan: <?= $classData['nama_class'] ?></h5>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="mb-3 row">
                    <form action="simpanfoto.php?id=<?= $classData['classid'] ?>" method="POST" enctype="multipart/form-data" class="mt-5 px-5">
                        <label for="gambar" class="col-sm-3 col-form-label fw-bold">Unggah Foto:</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="gambar" required accept="image/*">
                        </div>
                </div>
            </div><button type="submit" class="btn btn-primary">Kirim Foto</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>