<?php
include '../koneksi.php';

session_start();

// Redirect jika belum login
if (empty($_SESSION['email'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

// Ambil data dari form
$id = $_POST['id_code_class'];
$status = $_POST['status'];
$kode = $_POST['kode'];
$shiftkunci = $_POST['shiftkunci']; // Kunci untuk Caesar cipher
$key_input = $_POST['key_input'];   // Kunci untuk AES
$iv_input = $_POST['iv_input'];     // IV untuk AES

// Validasi kunci Caesar Cipher: Harus angka dan <= 26
if (!ctype_digit($shiftkunci)) {
    $_SESSION['notification'] = "Kunci Caesar Cipher harus berupa angka.";
    header("Location: konfirmasi.php?id=$id");
    exit();
}

$shiftkunci = (int)$shiftkunci; // Konversi ke integer

if ($shiftkunci > 26 || $shiftkunci < 0) {
    $_SESSION['notification'] = "Kunci Caesar Cipher harus berupa angka antara 0-26.";
    header("Location: konfirmasi.php?id=$id");
    exit();
}

// Fungsi Caesar Cipher untuk enkripsi
function caesar_encrypt($plaintext, $shift)
{
    $result = "";
    $shift = $shift % 26; // Batasi pergeseran antara 0-25
    foreach (str_split($plaintext) as $char) {
        if (ctype_alpha($char)) {
            $offset = ctype_upper($char) ? 65 : 97;
            $result .= chr((ord($char) - $offset + $shift) % 26 + $offset);
        } else {
            $result .= $char; // Biarkan karakter non-huruf tetap
        }
    }
    return $result;
}

// Fungsi AES untuk enkripsi
function aes_encrypt_custom($plaintext, $key_input, $iv_input)
{
    $key = hash('sha256', $key_input, true);
    $iv = substr(hash('sha256', $iv_input), 0, 16);
    return openssl_encrypt($plaintext, 'AES-256-CBC', $key, 0, $iv);
}

// Fungsi untuk menyisipkan data ke dalam gambar
function embed_text_in_image($image_path, $text)
{
    $image_data = file_get_contents($image_path);
    $stego_image = $image_data . "\n<!--$text-->"; // Sisipkan teks di akhir file
    return $stego_image;
}

// Langkah 1: Enkripsi dengan Caesar cipher
$kode_caesar = caesar_encrypt($kode, $shiftkunci);

// Langkah 2: Enkripsi hasil Caesar cipher dengan AES
$kode_encrypted = aes_encrypt_custom($kode_caesar, $key_input, $iv_input);

// Langkah 3: Gabungkan ciphertext dengan kunci-kunci yang digunakan
$data_to_embed = json_encode([
    'ciphertext' => $kode_encrypted,
    'caesar_key' => $shiftkunci,
    'aes_key'    => $key_input,
    'aes_iv'     => $iv_input
]);

// Langkah 4: Periksa file gambar yang diunggah
if (!empty($_FILES['fotoenkrip']['name'])) {
    $targetDir = "../foto_stego/";
    $targetFile = $targetDir . basename($_FILES["fotoenkrip"]["name"]);
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fotoenkrip"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['notification'] = "File yang diupload bukan gambar.";
        header("Location: konfirmasi.php?id=$id");
        exit();
    }

    // Validasi tipe file
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowedExtensions)) {
        $_SESSION['notification'] = "Hanya file JPG, JPEG, PNG, dan GIF yang diperbolehkan.";
        header("Location: konfirmasi.php?id=$id");
        exit();
    }

    // Validasi ukuran file
    if ($_FILES['fotoenkrip']['size'] > 2000000) { // Maksimal 2 MB
        $_SESSION['notification'] = "Ukuran file terlalu besar (maksimal 2 MB).";
        header("Location: konfirmasi.php?id=$id");
        exit();
    }

    if (!move_uploaded_file($_FILES["fotoenkrip"]["tmp_name"], $targetFile)) {
        $_SESSION['notification'] = "Maaf, terjadi kesalahan saat mengupload gambar.";
        header("Location: konfirmasi.php?id=$id");
        exit();
    }

    // Langkah 5: Sisipkan ciphertext dan kunci ke dalam gambar
    $stego_image = embed_text_in_image($targetFile, $data_to_embed);
    file_put_contents($targetFile, $stego_image); // Simpan gambar dengan teks terenkripsi
}

// Query untuk memperbarui data di database
$query = "UPDATE classes_access ca 
    INNER JOIN foto f ON ca.fotoid = f.id_foto
    SET 
        f.status = '$status',
        ca.code_access = '$kode_encrypted'
    WHERE ca.id_code_class = '$id'";

$queryFotoenkrip = "INSERT INTO fotoenkrip (id_code_classes, fotoenkrip) 
              VALUES ('$id',  '" . basename($_FILES["fotoenkrip"]["name"]) . "')";

// Gunakan transaksi SQL untuk konsistensi data
mysqli_begin_transaction($konek);
try {
    mysqli_query($konek, $query); // Update classes_access
    if (!mysqli_query($konek, $queryFotoenkrip)) {
        throw new Exception("Error: " . mysqli_error($konek));
    }
    mysqli_commit($konek);
    $_SESSION['notification'] = "Kode redeem berhasil dikonfirmasi!";
    header("Location: pesanan.php");
    exit();
} catch (Exception $e) {
    mysqli_rollback($konek);
    echo "Gagal memproses data: " . $e->getMessage(); // Tampilkan error
    exit();
}

// Tutup koneksi
mysqli_close($konek);
