<?php
  require_once("connect-admin.php");
  include "admin.php";
  if (isset($_POST["btn-5"]) && $_POST["btn-5"]) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product-name'];
    $product_brand = $_POST['brand'];
    $product_quantity = $_POST['quantity'];
    $product_price = $_POST['price'];
    $product_category = $_POST['category'];
    $product_img = $_FILES['image']['name'];

    if(empty($product_img)){
      $product_img = null;
      UpdateProduct($product_img,$product_name,$product_price,$product_brand,$product_category,$product_quantity,$product_id);
      echo '<script>window.location.href="sanpham.php?";</script>';

    }else{
          // Đường dẫn thư mục đích trên xampp
        $target_dir = "/Xampp/htdocs/Final_project/Picture/";
        $target_file = $target_dir . basename($product_img);
      if (file_exists($target_file)) {
        } else {
        // Di chuyển tệp đến thư mục đích
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
        }
    }
    $img="/Final_project/Picture/". basename($product_img);
    // echo $img;
    UpdateProduct($img,$product_name,$product_price,$product_brand,$product_category,$product_quantity,$product_id);
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
            <a href=""><img class="Logo_website" src="/Final_project/Picture/Logo_web_3.png" alt="" /></a>
        </div>
        <div class="middle-selection"></div>
        <div class="right-selection">
            <a href=""><img class="avatar" src="/Final_project/Picture/Human.png" alt="" /></a>
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
            <h1>Chỉnh sửa sản phẩm</h1>
            <form class="edit-product-form" action="chinhsuasanpham.php" method="POST" enctype="multipart/form-data">
                <?php
            if (isset($_POST['btn-2'])&&$_POST['btn-2']) {
              $product_id= $_POST["Product_id"];
              showProduct_edit($product_id);
              
            }
            
          ?>
            </form>

        </div>
    </div>
    <script src="../js/admin.js"></script>
</body>

</html>