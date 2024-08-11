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
                    <li><a href="">Thêm đơn hàng</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <div class="table-wrapper">
                <div class="title">
                    <div class="title-left">Chi tiết sản phẩm</div>
                    <div class="title-right">
                        <form id="searchForm" action="search.php" method="GET">
                            <input class="search-bar" type="search" name="query" placeholder="Tìm kiếm sản phẩm ..." />
                            <button class="search-button" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá bán</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Xoá sản phẩm</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>1</td>
                            <td>
                                <img class="img-table" src="/Final_project/Picture/ps5_slim_st_1.jpg" alt="" />
                            </td>
                            <td>
                                MÁY PS5 SLIM / PLAYSTATION 5 DIGITAL EDITION PHIÊN BẢN CÓ Ổ
                                ĐĨA
                            </td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">11.490.000</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>10</td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">11.490.000</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>
                                <button class="trash">
                                    <i class="fa-solid fa-trash"></i></i>
                                </button>
                            </td>
                        </tr> -->

                        <?php
                        if(isset($_POST['btn']) && $_POST['btn']){
                          $orders_id=$_POST['Order_id'];
                          // echo '{'.$orders_id.'}';
                          ShowOrderDetails($orders_id);
                        }
                        if(isset($_POST['btn-4']) && $_POST['btn-4']){
                          $orderDetails_id=$_POST['OrderDetails_id'];
                          
                          DeleteProductInOrders($orderDetails_id);
                          echo "<script>
                          window.location.href = 'DonHang.php';
                      </script>";
                          exit();
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/admin.js"></script>
</body>

</html>