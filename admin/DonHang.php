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
                    <div class="title-left">Đơn hàng</div>
                    <div class="title-right">
                        <form id="searchForm" action="search.php" method="GET">
                            <input class="search-bar" type="search" name="query" placeholder="Tìm kiếm đơn hàng ..." />
                            <button class="search-button" type="submit">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách hàng</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Địa Chỉ</th>
                            <th>Ngày đặt</th>
                            <th>Trạng thái giao hàng</th>
                            <th>Trạng thái thanh toán</th>
                            <th>Trạng thái đơn hàng</th>
                            <th>Tổng giá trị đơn hàng</th>
                            <th>Chi tiết</th>
                            <th>Tùy chỉnh</th>
                            <th>Xoá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                            <td>1
                            </td>
                            <td>Tuấn Cô Đơn</td>
                            <td>0123456789</td>
                            <td>tuancodon@gmail.com</td>
                            <td>114/116 Tô Ngọc vân, phường 15 Quận Gò Vấp, TPHCM</td>
                            <td>21/12/2004</td>
                            <td>Chưa giao hàng</td>
                            <td>Chưa thanh toán</td>
                            <td>Chưa xác nhận</td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">11.490.000</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>
                                <form action="chitietsanpham.php" method="POST">
                                    <input type="hidden" name="Order_id" value="1">
                                    <button class="details" type="submit">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="" method="POST">
                                    <input type="hidden" name="Order_id" value="1">
                                    <button class="fix-product">
                                        <i class="fa-solid fa-pen"></i>
                                    </button>
                                </form>
                            </td>
                        </tr> -->
                        <?php
                        ShowOder();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="../js/admin.js"></script>
</body>

</html>