<!doctype html>
<html lang="en">

<?php
session_start();
include '../koneksi.php';

// Cek apakah user sudah login
if (empty($_SESSION['email'])) {
    header("location:../index.php?pesan=belum_login");
}

// Check apakah ada notifikasi yang disimpan di session
if (isset($_SESSION['notification'])) {
    echo "<script>alert('" . $_SESSION['notification'] . "');</script>";
    unset($_SESSION['notification']);
}

// Ambil data dari tabel pegawai
$query = "
SELECT 
    ca.id_code_class, 
    c.nama_class, 
    u.email_user AS email_user, 
    f.foto, 
    f.status
FROM 
    classes_access ca
INNER JOIN 
    foto f ON ca.fotoid = f.id_foto
INNER JOIN 
    class c ON ca.classid = c.classid
INNER JOIN 
    users u ON ca.uid = u.uid
";

$result = mysqli_query($konek, $query);
?>

<head>
    <title>Data Pesanan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../allstyle.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid px-4 justify-content-between ">
            <h3 class="navbar-brand fs-3 text-center text-white fw-bold">Daftar Pesanan</h3>
            <a href="../logout.php" class="btn btn-warning fw-bold">Logout</a>
        </div>
    </nav>
    <div class="container p-5 my-5 border border-5 border-primary-subtle rounded-5">
        <table class="table table-striped table-bordered table-hover border-secondary">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Kelas</th>
                    <th scope="col">Email User</th>
                    <th scope="col">Foto Pesanan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Konfirmasi</th>
                    <th scope="col">Hapus</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $no = 1;
                    foreach ($result as $row) {
                        // Periksa apakah status adalah "Terkonfirmasi"
                        $isConfirmed = strtolower($row['status']) === 'terkonfirmasi';
                ?>
                        <tr>
                            <th scope='row'><?= $no++ ?></th>
                            <td><?= $row['nama_class'] ?></td>
                            <td><?= $row['email_user'] ?></td>
                            <td>
                                <img src="../fotouser/<?= $row['foto'] ?>" alt="Foto Pegawai" style="width: 100px; height: 100px;">
                            </td>
                            <td><?= $row['status'] ?></td>
                            <td>
                                <button type="button" class="btn btn-primary" <?= $isConfirmed ? 'disabled' : '' ?>>
                                    <a href="konfirmasi.php?id=<?= $row['id_code_class'] ?>" class="fw-bold text-white">Konfirmasi</a>
                                </button>

                            </td>
                            <td>
                                <a href="hapus.php?id=<?= $row['id_code_class'] ?>">
                                    <button type="button" class="btn btn-danger">Hapus</button>
                                </a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>

        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>