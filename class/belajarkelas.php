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

$queryNotes = "SELECT n.noteid, n.classid, u.nama_lengkap FROM notes n INNER JOIN class c ON n.classid = c.classid INNER JOIN users u ON n.uid = u.uid WHERE n.classid='$classid'";
$resultNotes = mysqli_query($konek, $queryNotes);
$notesData = mysqli_fetch_assoc($resultNotes);

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
        <a href="class.php" class="fw-bold">
            <h3 class="fw-bold">Kembali</h3>
        </a>
        <h2 class="fw-bold"><?= $classData['nama_class'] ?>!</h2>
        <h4><?= $classData['deskripsi'] ?></h4>
        <div class="row mt-3 gx-5 gy-5">
            <h5>Catatan kelas yang tersedia:</h5>
            <div class="col-sm-6 mb-3 mb-sm-0">
                <div class="card">
                    <div class="card-body">
                        <?php if (empty($notesData) || is_null($notesData['noteid'])) { ?>
                            <p class="text-warning">Catatan belum ada.</p>
                        <?php } else { ?>
                            <a href="lihatcatatan.php?id=<?= $classid ?>" class="btn btn-primary">Lihat Catatan</a>
                        <?php } ?>
                    </div>
                </div>
            </div>

        </div>
        <a href="note.php?id=<?= $classData['classid'] ?>"><button type="button" class="btn btn-primary mt-5">Tambahkan Catatan</button></a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>