<?php
session_start();
include '../koneksi.php';

if (empty($_SESSION['email_user'])) {
    header("Location: ../index.php?pesan=belum_login");
    exit();
}

// Fungsi RC4 untuk enkripsi dan dekripsi
function rc4($key, $data)
{
    $key = array_values(unpack('C*', $key));
    $data = array_values(unpack('C*', $data));
    $keyLength = count($key);
    $dataLength = count($data);
    $S = range(0, 255);

    // Inisialisasi S-box
    $j = 0;
    for ($i = 0; $i < 256; $i++) {
        $j = ($j + $S[$i] + $key[$i % $keyLength]) % 256;
        [$S[$i], $S[$j]] = [$S[$j], $S[$i]]; // Swap
    }

    // Enkripsi atau Dekripsi
    $i = $j = 0;
    $result = [];
    for ($n = 0; $n < $dataLength; $n++) {
        $i = ($i + 1) % 256;
        $j = ($j + $S[$i]) % 256;
        [$S[$i], $S[$j]] = [$S[$j], $S[$i]]; // Swap
        $K = $S[($S[$i] + $S[$j]) % 256];
        $result[] = $data[$n] ^ $K;
    }

    return pack('C*', ...$result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $noteid = $_POST['noteid'];
    $keyInput = $_POST['key_input'];
    $classid = $_POST['classid']; // Ambil classid dari form

    // Ambil file dari database berdasarkan noteid
    $query = "SELECT file FROM notes WHERE noteid = ?";
    $stmt = $konek->prepare($query);
    $stmt->bind_param("i", $noteid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = '../note/' . $row['file'];

        if (file_exists($filePath)) {
            // Baca isi file terenkripsi
            $encryptedData = file_get_contents($filePath);

            // Dekripsi menggunakan RC4
            $decryptedData = rc4($keyInput, $encryptedData);

            // Simpan data dekripsi dalam sesi
            $_SESSION['decrypted_file'] = base64_encode($decryptedData);
            $_SESSION['file_name'] = $row['file']; // Nama file asli
            $_SESSION['mime_type'] = mime_content_type($filePath); // Tentukan tipe MIME
            $_SESSION['classid'] = $classid;

            // Arahkan ke halaman hasil
            header("Location: filedekrip.php");
            exit();
        } else {
            $_SESSION['notification'] = "File tidak ditemukan.";
        }
    } else {
        $_SESSION['notification'] = "File dengan ID tersebut tidak ditemukan.";
    }

    header("Location: lihatcatatan.php?id=$classid");
    exit();
}
?>
