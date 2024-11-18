<!DOCTYPE html>
<html>

<head>
    <title>Data Pegawai</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="../img/icon.png" type="image/x-icon">
</head>

<body>
    <div class="container">
        <div class="login-content">
            <!-- Formulir pendaftaran pengguna -->
            <form id="" class="login-form" action="cekregadmin.php" method="POST">
                <a href="../index.php">
                    <h3 class="text-success">Kembali</h3>
                </a>
                <h2 class="title">Register Here</h2>
                <?php
                if (isset($_GET['pesan'])) {
                    if ($_GET["pesan"] == 'gagal') {
                        require '../notifikasi/notifDataExist.php';
                    } else if (isset($_GET['pesan'])) {
                        require '../notifikasi/emailValid.php';
                    }
                }
                ?>
                <div class="input-div name">
                    <div class="i">
                        <i class="bx bxl-gmail"></i>
                    </div>
                    <div class="div">
                        <h5>Email</h5>
                        <input type="text" class="input" name="email" />
                    </div>
                </div>
                <div class="input-div pass">
                    <div class="i">
                        <i class="bx bx-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input
                            type="password"
                            class="input"
                            required
                            autocomplete="off" name="password" />
                        <i class="bx bxs-hide pass-icon"></i>
                    </div>
                </div>
                <input type="submit" class="btn fw-bold" value="Register" required />
                <div class="notHave" id="links">

                    <?php
                    include '../koneksi.php';
                    session_start();
                    if (isset($_SESSION['notification'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> <?= $_SESSION['notification'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php
                        unset($_SESSION['notification']);
                    endif;
                    ?>

                    <h5>
                        Sudah Mempunyai Akun?
                        <a href="loginadmin.php" id="linkRegist"><strong>Login Here</strong></a>
                    </h5>
                </div>
            </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>