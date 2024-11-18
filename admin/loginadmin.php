<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="../img/icon.png" type="image/x-icon">
</head>
</head>

<body>
    <div class="container">
        <div class="login-content">
            <!-- Formulir login dengan metode POST -->
            <form id="" class="login-form" action="cekadmin.php" method="POST">
                <a href="../index.php">
                    <h3 class="text-success">Kembali</h3>
                </a>

                <h2 class="title">Login Here</h2>

                <!-- Input untuk username -->
                <div class="input-div name">
                    <div class="i">
                        <i class="bx bxl-gmail"></i>
                    </div>
                    <div class="div">
                        <h5>Username</h5>
                        <input type="text" class="input" name="email" />
                    </div>
                </div>

                <!-- Input untuk password -->
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
                <input type="submit" class="btn fw-bold" value="Login" required />
                <?php
                if (isset($_GET['pesan'])) {
                    if ($_GET["pesan"] == 'gagal') {
                        require '../notifikasi/notifGagal.php';
                    }
                }
                ?>
            </form>
        </div>
        <div class="notHave" id="links">
            <h5>
                Belum Mempunyai Akun?
                <a href="registadmin.php" id="linkRegist"><strong>Regist Here</strong></a>
            </h5>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>