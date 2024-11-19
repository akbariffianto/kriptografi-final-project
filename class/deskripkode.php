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
$query = "
SELECT 
    ca.id_code_class,
    ca.classid, 
    c.nama_class, 
    u.email_user AS email_user, 
    f.foto, 
    f.status,
    fe.fotoenkrip
FROM 
    classes_access ca
INNER JOIN 
    foto f ON ca.fotoid = f.id_foto
INNER JOIN 
    class c ON ca.classid = c.classid
INNER JOIN 
    users u ON ca.uid = u.uid
INNER JOIN 
    fotoenkrip fe ON ca.id_code_class = fe.id_code_classes
WHERE 
    ca.id_code_class = $id
";

$embedded_text = isset($_SESSION['embedded_text']) ? $_SESSION['embedded_text'] : "Pesan tidak ditemukan.";

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
            <a class="navbar-brand fs-3 text-center text-white fw-bold" href="#">Penukaran Redeem</a>
        </div>
    </nav>

    <div class="container p-2 my-5 border border-5 border-primary-subtle rounded-5">
    <?php
          if (isset($_GET['pesan'])) {
            if ($_GET["pesan"] == 'akses_ditolak') {
              require '../notifikasi/aksesditolak.php';
            }
          }
          ?>
        <form action="cekdeskripsikode.php" method="post" enctype="multipart/form-data" class="mt-5 px-5">
            <a href="redeemtoken.php?id=<?= $row['classid'] ?>" class="fw-bold">
                <h3 class="fw-bold">Kembali</h3>
            </a>
            <input type="hidden" name="id_code_class" value="<?php echo htmlspecialchars($row["id_code_class"]); ?>">
            <input type="hidden" name="classid" value="<?php echo htmlspecialchars($row["classid"]); ?>">
            <div class="mb-3 row">
            <?php echo htmlspecialchars($embedded_text); ?>
            </div>

            <div class="mb-3 row">
                <h6>Kunci Caesar Cipher</h6>
                <label for="shiftkunci" class="col-sm-3 col-form-label fw-bold">Shift Caesar:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="shiftkunci" placeholder="Inputkan Shift Caesar" required>
                </div>
            </div>

            <div class="mb-3 row">
                <h6>Kunci AES</h6>
                <label for="key_input" class="col-sm-3 col-form-label fw-bold">Kunci Key:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="key_input" placeholder="Inputkan Kunci Key" required>
                </div>
                <label for="iv_input" class="col-sm-3 col-form-label fw-bold">IV Input:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="iv_input" placeholder="Inputkan IV input" required>
                </div>
            </div>

            <div class="mb-3 row">
            <h6>Kode Redeem</h6>
                <label for="Kode" class="col-sm-3 col-form-label fw-bold">Kode:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" name="kode" placeholder="Inputkan Kode" required>
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