<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
  $u = $_POST['username'];
  $p = $_POST['password'];

  $q = mysqli_query($conn,"SELECT * FROM admin WHERE username='$u' AND password='$p'");
  if(mysqli_num_rows($q) > 0){
    $_SESSION['admin'] = true;
    header("location:admin.php");
  } else {
    $error = "Username atau Password salah";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Admin OUTTREN</title>
  <link rel="stylesheet" href="login.css">
</head>
<body>

<div class="login-wrapper">

  <form method="POST" class="login-box">
    <img src="img/logo.png" class="logo">

    <h2>Login Admin</h2>

    <?php if(isset($error)){ ?>
      <p class="error"><?= $error; ?></p>
    <?php } ?>

    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>

    <button name="login">Login</button>
  </form>

</div>

</body>
</html>