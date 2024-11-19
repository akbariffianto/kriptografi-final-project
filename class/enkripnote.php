<?php
session_start();
include '../koneksi.php';
if (empty($_SESSION['email_user'])) {
    header("location:../index.php?pesan=belum_login");
}

// Fungsi RC4
function rc4($key, $data)
{
    $s = range(0, 255);
    $j = 0;
    $keyLength = strlen($key);
    
    // KSA (Key Scheduling Algorithm)
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $s[$i] + ord($key[$i % $keyLength])) % 256;
        $temp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $temp;
    }

    // PRGA (Pseudo-Random Generation Algorithm)
    $i = 0;
    $j = 0;
    $output = '';
    $dataLength = strlen($data);

    for ($k = 0; $k < $dataLength; $k++) {
        $i = ($i + 1) % 256;
        $j = ($j + $s[$i]) % 256;
        $temp = $s[$i];
        $s[$i] = $s[$j];
        $s[$j] = $temp;

        $output .= chr(ord($data[$k]) ^ $s[($s[$i] + $s[$j]) % 256]);
    }

    return $output;
}

// Proses unggah dan enkripsi
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $classId = $_POST['classid'];
    $uid = $_SESSION['uid']; // Pastikan UID pengguna tersimpan di session
    $keyInput = $_POST['key_input'];

    // Validasi file
    if (!isset($_FILES['note']) || $_FILES['note']['error'] !== UPLOAD_ERR_OK) {
        $_SESSION['notification'] = 'Gagal mengunggah file. Silakan coba lagi.';
        header("Location: belajarkelas.php?id=$classId");
        exit();
    }

    $fileTmpPath = $_FILES['note']['tmp_name'];
    $fileName = $_FILES['note']['name'];
    $fileSize = $_FILES['note']['size'];

    // Validasi ukuran file (max 5 MB)
    if ($fileSize > 5 * 1024 * 1024) {
        $_SESSION['notification'] = 'Ukuran file terlalu besar. Maksimal 5 MB.';
        header("Location: belajarkelas.php?id=$classId");
        exit();
    }

    // Membaca konten file
    $fileContent = file_get_contents($fileTmpPath);

    // Enkripsi file dengan RC4
    try {
        $encryptedContent = rc4($keyInput, $fileContent);
    } catch (Exception $e) {
        $_SESSION['notification'] = 'Terjadi kesalahan saat mengenkripsi file.';
        header("Location: belajarkelas.php?id=$classId");
        exit();
    }

    // Menyimpan file yang telah dienkripsi
    $encryptedFileName = $fileName;
    $uploadPath = '../note/' . $encryptedFileName;

    if (file_put_contents($uploadPath, $encryptedContent) === false) {
        $_SESSION['notification'] = 'Gagal menyimpan file yang telah dienkripsi.';
        header("Location: belajarkelas.php?id=$classId");
        exit();
    }

    // Simpan informasi ke database
    $query = "INSERT INTO notes (classid, uid, file) VALUES ('$classId', '$uid', '$encryptedFileName')";
    if (!mysqli_query($konek, $query)) {
        $_SESSION['notification'] = 'Gagal menyimpan data ke database.';
        header("Location: belajarkelas.php?id=$classId");
        exit();
    }

    // Redirect ke halaman sukses
    $_SESSION['notification'] = 'File berhasil dienkripsi dan disimpan.';
    header("Location: belajarkelas.php?id=$classId");
    exit();
} else {
    $_SESSION['notification'] = 'Akses halaman tidak valid.';
    header("Location: ../index.php");
    exit();
}
?>
