<?php
session_start();
include '../koneksi.php';
if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

$classid = $_GET['id'];
$uid = $_SESSION['uid'];

// Query untuk mendapatkan daftar file catatan dan kode akses
$queryNotes = "SELECT * FROM notes WHERE classid = '$classid'";
$resultNotes = mysqli_query($konek, $queryNotes);

?>

<!doctype html>
<html lang="en">

<head>
    <title>Dekripsi File</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container-fluid px-4 justify-content-center">
            <a class="navbar-brand fs-3 text-center text-white fw-bold" href="#">Dekripsi File</a>
        </div>
    </nav>

    <div class="container my-5">
        <a href="belajarkelas.php?id=<?= htmlspecialchars($classid); ?>" class="btn btn-secondary mb-3">Kembali</a>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5>Masukkan Kode Akses untuk Mendekripsi</h5>
            </div>
            <div class="card-body">
                <?php if (isset($_SESSION['notification'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= htmlspecialchars($_SESSION['notification']); unset($_SESSION['notification']); ?>
                    </div>
                <?php endif; ?>

                <form action="dekripcatatan.php" method="post">
                    <div class="mb-3">
                        <input type="hidden" name="classid" value="<?= htmlspecialchars($classid); ?>">
                        <label for="note" class="form-label">Pilih File:</label>
                        <select class="form-select" name="noteid" required>
                            <option value="" disabled selected>Pilih File</option>
                            <?php if ($resultNotes && mysqli_num_rows($resultNotes) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($resultNotes)): ?>
                                    <option value="<?= htmlspecialchars($row['noteid']); ?>">
                                        <?= htmlspecialchars($row['file']); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <option value="" disabled>Tidak ada file yang tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="key_input" class="form-label">Masukkan Kode Akses:</label>
                        <input type="text" class="form-control" name="key_input" placeholder="Kode Akses" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Dekripsi File</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
