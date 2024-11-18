<?php
include '../koneksi.php';

session_start();
if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

$classid = $_GET['id'];
$uid = $_SESSION['uid'];

// Memproses upload gambar
$targetDir = "../fotouser/";
$targetFile = $targetDir . basename($_FILES["gambar"]["name"]);
$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

// Debugging path folder
if (!is_dir($targetDir)) {
    $_SESSION['notification'] = "Folder target tidak ditemukan: $targetDir";
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Debugging informasi file upload
if (!isset($_FILES['gambar'])) {
    $_SESSION['notification'] = "Tidak ada file yang diupload.";
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Validasi gambar
$check = getimagesize($_FILES["gambar"]["tmp_name"]);
if ($check === false) {
    $_SESSION['notification'] = "File yang diupload bukan gambar.";
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Validasi tipe file
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
if (!in_array($imageFileType, $allowedExtensions)) {
    $_SESSION['notification'] = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Validasi ukuran file
if ($_FILES["gambar"]["size"] > 2000000) {
    $_SESSION['notification'] = "Ukuran file terlalu besar. Maksimal 2MB.";
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Pindahkan file
if (!move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
    $_SESSION['notification'] = "Gagal memindahkan file: " . error_get_last()['message'];
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Query untuk tabel foto
$queryFoto = "INSERT INTO foto (classid, uid, foto, status) 
              VALUES ('$classid', '$uid', '" . basename($_FILES["gambar"]["name"]) . "', 'Belum Terpenuhi')";

if (mysqli_query($konek, $queryFoto)) {
    // Dapatkan fotoid dari query terakhir
    $fotoid = mysqli_insert_id($konek);

    // Query untuk tabel classes_access
    $queryAccess = "INSERT INTO classes_access (classid, uid, fotoid) 
                    VALUES ('$classid', '$uid', '$fotoid')";
    if (mysqli_query($konek, $queryAccess)) {
        $_SESSION['notification'] = "Data berhasil ditambahkan ke tabel foto dan classes_access!";
        header("Location: ../class/redeemtoken.php?id=$classid");
        exit();
    } else {
        $_SESSION['notification'] = "Gagal menambahkan data ke tabel classes_access: " . mysqli_error($konek);
        header("Location: inputfoto.php?id=$classid");
        exit();
    }
} else {
    $_SESSION['notification'] = "Gagal menambahkan data ke tabel foto: " . mysqli_error($konek);
    header("Location: inputfoto.php?id=$classid");
    exit();
}

// Tutup koneksi
mysqli_close($konek);
