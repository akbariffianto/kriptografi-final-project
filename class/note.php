<!doctype html>
<html lang="en">

<?php
session_start();
include '../koneksi.php';
if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

$id = $_GET['id'];
$query = "SELECT classid FROM class WHERE classid = '$id'";

$result = mysqli_query($konek, $query);
$row = mysqli_fetch_array($result);
?>

<head>
    <title>Data Pesanan: Input Kode</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid px-4  justify-content-center">
            <a class="navbar-brand fs-3 text-center text-white fw-bold" href="#">Tambahkan catatan</a>
        </div>
    </nav>

    <div class="container p-2 my-5 border border-5 border-primary-subtle rounded-5">
        <?php
        if (isset($_SESSION['notification'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error:</strong> <?= $_SESSION['notification'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            unset($_SESSION['notification']);
        endif;
        ?>
        <form action="enkripnote.php" method="post" enctype="multipart/form-data" class="mt-5 px-5">
            <a href="belajarkelas.php?id=<?= $row['classid'] ?>" class="fw-bold">
                <h3 class="fw-bold">Kembali</h3>
            </a>
            <input type="hidden" name="classid" value="<?php echo htmlspecialchars($row["classid"]); ?>">

            <div class="mb-3 row">
                <label for="note" class="col-sm-3 col-form-label fw-bold">Unggah File Catatan:</label>
                <div class="col-sm-9">
                    <input type="file" class="form-control" name="note">
                </div>
            </div>

            <div class="mb-3 row">
                <h6>Kunci RC4</h6>
                <label for="key_input" class="col-sm-3 col-form-label fw-bold">Kunci Key:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="key_input" placeholder="Inputkan Kunci Key" required>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary fw-bold">Lanjutkan Progress</button>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>