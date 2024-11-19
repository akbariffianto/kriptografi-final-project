<?php
include '../koneksi.php';

session_start();

// Periksa apakah user sudah login
if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

$id = $_POST['id_code_class'];
$classid = $_POST['classid'];
$kode = $_POST['kode']; // Input kode dari user
$shiftkunci = $_POST['shiftkunci']; // Kunci Caesar
$key_input = $_POST['key_input']; // Kunci AES
$iv_input = $_POST['iv_input']; // IV AES

// Fungsi Caesar Cipher untuk dekripsi
function caesar_decrypt($ciphertext, $shift) {
    $result = "";
    $shift = $shift % 26; // Batasi pergeseran antara 0-25
    foreach (str_split($ciphertext) as $char) {
        if (ctype_alpha($char)) {
            $offset = ctype_upper($char) ? 65 : 97;
            $result .= chr((ord($char) - $offset - $shift + 26) % 26 + $offset);
        } else {
            $result .= $char; // Biarkan karakter non-huruf tetap
        }
    }
    return $result;
}

// Fungsi AES untuk dekripsi
function aes_decrypt_custom($ciphertext, $key_input, $iv_input) {
    $key = hash('sha256', $key_input, true);
    $iv = substr(hash('sha256', $iv_input), 0, 16);
    return openssl_decrypt($ciphertext, 'AES-256-CBC', $key, 0, $iv);
}

// Lakukan dekripsi super (AES -> Caesar)
$step1_aes = aes_decrypt_custom($kode, $key_input, $iv_input);
$final_decrypted = caesar_decrypt($step1_aes, $shiftkunci);

// Periksa apakah hasil dekripsi cocok dengan id_code_class di database
$query = "SELECT ca.code_access, ca.classid  FROM classes_access ca INNER JOIN fotoenkrip fe ON ca.id_code_class = fe.id_code_classes WHERE ca.id_code_class = '$id'";
$result = mysqli_query($konek, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Cocokkan hasil dekripsi
    if ($final_decrypted === $row['code_access']) {
        // Jika cocok, arahkan ke halaman selanjutnya
        header("Location: belajarkelas.php?id=$classid");
        exit();
    } else {
        // Jika tidak cocok
        header("Location: deskripkode.php?id=$id&pesan=akses_ditolak");
        exit();
    }
} else {
    // Jika id_code_class tidak ditemukan
    header("Location: deskripkode.php?id=$id&pesan=id_tidak_ditemukan");
    exit();
}

mysqli_close($konek);
?>
