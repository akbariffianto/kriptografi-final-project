<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="login/cek-login.php" class="sign-in-form" method="POST">
        <?php
          if (isset($_GET['pesan'])) {
            if ($_GET["pesan"] == 'belum_login') {
              require 'notifikasi/notifBelum.php';
            }
          }
          ?>
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="email" placeholder="Email" id="email_signin" name="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" id="psw_signin" autocomplete="new-password" name="password" />
          </div>
          <input type="submit" value="Login" id="signin-button" class="btn solid" />
          <a href="admin/loginadmin.php">Login Sebagai Admin</a>
          <?php
          if (isset($_GET['pesan'])) {
            if ($_GET["pesan"] == 'gagal') {
              require 'notifikasi/notifGagal.php';
            }
            if ($_GET["pesan"] == 'logout') {
              require 'notifikasi/notifLogout.php';
            }
          }
          ?>
        </form>

        <form action="registrasi/cek-regist.php" class="sign-up-form" method="POST">
          <h2 class="title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Name" id="name" name="name" />
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" id="email_signup" name="email" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" id="psw_signup" autocomplete="new-password" name="password" />
          </div>
          <input type="submit" class="btn" id="signup-button" value="Sign up" />
          <?php
          if (isset($_GET['pesan'])) {
            if ($_GET["pesan"] == 'gagal') {
              require 'notifikasi/notifDataExist.php';
            } else if ($_GET["pesan"] == 'emailValid') {
              require 'notifikasi/emailValid.php';
            } else if ($_GET["pesan"] == 'pesan') {
              require 'notifikasi/emailTerdaftar.php';
            }
          }
          ?>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3>Ingin Belajar hal baru? ?</h3>
          <p>Segera registrasi akun kamu untuk mengakses beragam course!</p>
          <button class="btn transparent" id="sign-up-btn">Sign up</button>
        </div>
        <img src="img/log.svg" class="image" alt="" />
      </div>
      <div class="panel right-panel">
        <div class="content">
          <h3>Ingin melanjutkan pelajaran ?</h3>
          <p>Segera Login untuk melanjutkan pencapain kamu!</p>
          <button class="btn transparent" id="sign-in-btn">Sign in</button>
        </div>
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="app.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>