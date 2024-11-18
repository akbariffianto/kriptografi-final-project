<!doctype html>
<html lang="en">

<?php
session_start();
include '../koneksi.php';

if (empty($_SESSION['email_user'])) {
    header("location:../index.php?pesan=belum_login");
}

$uid = $_SESSION['uid'];

$queryUser = "SELECT nama_lengkap FROM users WHERE uid='$uid'";
$resultUser = mysqli_query($konek, $queryUser);
$userData = mysqli_fetch_assoc($resultUser);

$namaLengkap = $userData ? $userData['nama_lengkap'] : "Pengguna";

$queryClass = "SELECT * FROM class";
$resultClass = mysqli_query($konek, $queryClass);

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
        <h2 class="fw-bold">Halo <?php echo $namaLengkap; ?>!</h2>
        <h4>Ayoo segera buat pencapaianmu di pilihan kelas berikut!!</h4>
        <div class="row mt-3 gx-5 gy-5">
            <?php
            if (mysqli_num_rows($resultClass) > 0) {
                $no = 1;
                foreach ($resultClass as $row) {
            ?>
                    <div class="col-sm-6 mb-3 mb-sm-0">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $row['nama_class'] ?></h5>
                                <p class="card-text"><?= $row['deskripsi'] ?></p>
                                <a href="redeemtoken.php?id=<?= $row['classid'] ?>" class="btn btn-primary">Go To Class</a>
                            </div>
                        </div>

                    </div>
            <?php
                }
            } else {
                echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
            }
            ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>