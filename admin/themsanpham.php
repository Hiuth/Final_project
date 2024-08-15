<?php
  require_once("connect-admin.php");
  include "admin.php"
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
                    <li><a href="">Thêm sản phẩm</a></li>
                    <li>
                        <a href="DonHang.php">Đơn Hàng</a>
                    </li>
                    <li><a href="themdonhang.php">Thêm đơn hàng</a></li>
                    <li><a href="Lichsudonhang.php">Lịch sử đơn hàng</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <h1>Thêm mặt hàng</h1>
            <form class="edit-product-form">
                <div class="form-row">
                    <!-- Cột bên trái cho các trường nhập liệu -->
                    <div class="form-group-wrapper">
                        <div class="form-group">
                            <label for="product-name">Tên sản phẩm</label>
                            <input type="text" id="product-name" name="product-name" required />
                        </div>
                        <div class="form-group">
                            <label for="brand">Nhãn hiệu</label>
                            <select id="brand" name="brand">
                                <option value="">Chọn nhãn hiệu</option>
                                <!-- <option value="ps5">PS5</option>
                                    <option value="ps4">PS4</option>
                                    <option value="switch">Nintendo Switch</option>
                                    <option value="xbox-series-s">Xbox Series S</option>
                                    <option value="xbox-series-x">Xbox Series X</option>  -->
                                <?php 
                                    showBrand();
                                    ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lượng</label>
                            <input type="number" id="quantity" name="quantity" value="0" required />
                        </div>
                        <div class="form-group">
                            <label for="price">Giá bán</label>
                            <input type="text" id="price" name="price" required />
                        </div>
                        <div class="form-group">
                            <label for="category">Thuộc loại</label>
                            <select id="category" name="category" required>
                                <option value="">Chọn loại</option>
                                <!-- <option value="ps5">PS5</option>
                                <option value="ps4">PS4</option>
                                <option value="switch">Nintendo Switch</option>
                                <option value="xbox-series-s">Xbox Series S</option>
                                <option value="xbox-series-x">Xbox Series X</option> -->
                                <?php
                                showCategory();
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- Cột bên phải cho phần "Chỉnh sửa ảnh" -->
                    <div class="form-group image-upload">
                        <label for="product-image">Thêm ảnh</label>
                        <div class="image-placeholder">Chọn ảnh</div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="submit-button">Thêm mặt hàng</button>
                </div>
            </form>
        </div>
    </div>
    <script src="../js/admin.js"></script>
</body>

</html>