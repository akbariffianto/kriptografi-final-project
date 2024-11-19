<?php
session_start();

if (!isset($_SESSION['decrypted_file']) || !isset($_SESSION['classid']) || !isset($_SESSION['file_name']) || !isset($_SESSION['mime_type'])) {
    header("Location: decrypt_form.php");
    exit();
}

$decryptedFile = $_SESSION['decrypted_file'];
$fileName = $_SESSION['file_name'];
$mimeType = $_SESSION['mime_type'];
$classid = $_SESSION['classid'];
?>

<!doctype html>
<html lang="en">

<head>
    <title>File Terdekripsi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container my-5">
        <h2>File Terdekripsi</h2>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">File berhasil didekripsi!</h5>
                <a href="data:<?= $mimeType ?>;base64,<?= $decryptedFile ?>" download="<?= $fileName ?>" class="btn btn-success">Download File</a>
                <a href="lihatcatatan.php?id=<?= $classid ?>" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>
