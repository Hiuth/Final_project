<?php
  require_once("connect-admin.php");
  include "admin.php";
  if (isset($_POST["btn-5"]) && $_POST["btn-5"]) {
    $account_id = $_POST['account-id'];
    $admin_name = $_POST['admin-name'];
    $admin_email= $_POST['admin-email'];
    $admin_pass = $_POST['account-pass'];
    $account_power=$_POST['account-power'];
    $admin_birthday = $_POST['admin-birthday'];
    $account_img = $_FILES['image']['name'];

    if(empty($account_img)){
      $account_img = null;
      
      echo '<script>window.location.href="sanpham.php?";</script>';

    }else{
          // Đường dẫn thư mục đích trên xampp
        $target_dir = "/Xampp/htdocs/WebBanMayChoiGame/Picture/";
        $target_file = $target_dir . basename($account_img);
      if (file_exists($target_file)) {
        } else {
        // Di chuyển tệp đến thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        }
    }
    $img="/WebBanMayChoiGame/Picture/". basename($account_img);
    // echo $img;
    echo '<script>window.location.href="sanpham.php?";</script>';
  }

    
}

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Css/reset.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css"
        integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="../Css/admin.css" />
    <link rel="stylesheet" href="../Css/them-suasanpham.css" />
    <title>Sản phẩm</title>
</head>

<body>
    <header>
        <div class="left-selection">
            <a href=""><img class="Logo_website" src="/WebBanMayChoiGame/Picture/Logo_web_3.png" alt="" /></a>
        </div>
        <div class="middle-selection"></div>
        <div class="right-selection">
            <a href=""><img class="avatar" src="/WebBanMayChoiGame/Picture/Human.png" alt="" /></a>
        </div>
    </header>
    <div class="container-wrapper">
        <div class="sidebar">
            <nav>
                <ul>
                    <li>
                        <a href="sanpham.php">Sản Phẩm</a>
                    </li>
                    <li><a href="themsanpham.php">Thêm sản phẩm</a></li>
                    <li>
                        <a href="DonHang.php">Đơn Hàng</a>
                    </li>
                    <li><a href="themdonhang.php">Thêm đơn hàng</a></li>
                    <li><a href="Lichsudonhang.php">Lịch sử đơn hàng</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <!-- <h1>Chỉnh sửa tài khoản</h1>
            <form class="edit-product-form" action="themsanpham.php" method="POST" enctype="multipart/form-data">
                <div class="form-row">
        
                    <div class="form-group-wrapper">
                        <div class="form-group">
                            <label for="product-name">Tên tài khoản</label>
                            <input type="text" id="admin-name" name="admin-name" required />
                            <input type="hidden" name = "account-id" value="">
                        </div>
                        <div class="form-group">
                            <label for="brand">Email</label>
                            <input type="text" id="admin-email" name="admin-email" readonly />
                        </div>
                        <div class="form-group">
                            <label for="quantity">Mật khẩu tài khoản</label>
                            <input type="text" id="account-pass" name="admin-pass" required />
                        </div>
                        <div class="form-group">
                            <label for="quantity">Ngày tháng năm sinh</label>
                            <input type="date" id="admin-birthday" name="admin-birthday" value ="" required />
                        </div>
                        <div class="form-group">
                            <label for="category">Phân cấp tài khoản</label>
                            <select id="account-power" name="account-power" required>
                                <option value="">Chọn loại</option>
                                <option value="Quản lý">Quản lý</option>
                                <option value="Nhân viên">Nhân viên</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="picture">Thêm hình ảnh</label>
                            <input type="file" accept="image/*" id="file" name="image" required>
                        </div>
                    </div>
                    
         
                    <div class="form-group image-upload">
                        <label for="product-image">Thêm ảnh</label>
                        <div class="image-placeholder">
                            <img class="image-placeholder" id ="upload-Img" src="">
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="submit-button" name="btn-5" id="submit-button"
                        value="Chỉnh sửa tài khoản">Chỉnh sửa tài khoản</button>
                </div>
            </form> -->
            <?php
                if(isset($_POST["btn-8"])&&$_POST["btn-8"]){
                    $account_id = $_POST["account-id"];
                    showAccountEdit($account_id);
                } 
            ?>       
        </div>
    </div>
    <script src="../js/admin.js"></script>

    <?php

    ?>
</body>

</html>