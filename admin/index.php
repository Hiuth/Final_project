<?php
  require_once("connect-admin.php");
  session_start();
  include "admin.php";
  if (isset($_POST["login-btn"])&&$_POST["login-btn"]) {
    $username = $_POST["email"];
    $password = $_POST["password"];
    if(Login($username,$password)){
      echo '<script>window.location.href="sanpham.php";</script>';
    }else{
      //echo '<script>alert("Đăng nhập không thành công. Vui lòng kiểm tra lại email hoặc mật khẩu.");</script>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>2004'S Store Admin</title>
    <link rel="stylesheet" href="../Css/login.css" />
    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
  </head>

  <body>
    <div class="wrapper">
      <form action="index.php" method="POST">
        <h1>2004'S STORE - ADMIN</h1>
        <div class="input-box">
          <input type="text" placeholder="Email" name ="email" required />
          <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
          <input type="password" placeholder="Password" name="password" required />
          <i class="bx bxs-lock-alt"></i>
        </div>
        <button type="submit" class="btn" name="login-btn" value="login">Login</button>
      </form>
    </div>
  </body>
</html>
