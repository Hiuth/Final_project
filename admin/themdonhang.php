<?php
  require_once("connect-admin.php");
  include "admin.php";

  if (isset($_POST['data'])) {
    $receivedData = json_decode($_POST['data'], true);
    $_SESSION['productOrder'] = $receivedData;
} 

 if (isset($_POST['btn-submit'])&&$_POST['btn-submit']) {
     $username=$_POST['name'];
     $gender=$_POST['gender'];
     $email=$_POST['email'];
     $phone_number= $_POST['phone'];
     $address=$_POST['address'];
     $note=$_POST['note'];
     $total =Cart_total();
     if(!empty($username) && !empty($gender) && !empty($email) && !empty($phone_number) && !empty($address)) {
        $customer_id=Create_Customer_Info($username, $gender, $phone_number, $address, $email);
        //tạo đơn hàng
        $orders_id = Create_orders($customer_id,$total,$note,$address);
        //tạo chi tiết đơn hàng
        Create_orders_details($orders_id);
     }
     unset( $_SESSION['productOrder']);
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
    <link rel="stylesheet" href="../Css/donhang_admin.css" />
    <title>Sản phẩm</title>
</head>

<body>
    <header>
        <div class="left-selection">
            <a href=""><img class="Logo_website" src="/WebBanMayChoiGame/Picture/Logo_web_3.png" alt="" /></a>
        </div>
        <div class="middle-selection"></div>
        <div class="right-selection">
            <!-- <a href="adminmain.php"><img class="avatar" id ="avatar" src="/WebBanMayChoiGame/Picture/Human.png" alt="" /></a> -->
             <?php printAvatar()?>
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
                    <li><a href="quanlytaikhoan.php">Quản lý tài khoản</a></li>
                </ul>
            </nav>
        </div>

        <div class="content-wrapper">
            <div class="title">
                <div class="title-left">Thêm đơn hàng</div>
                <div class="title-right">
                    <form id="searchForm" action="search.php" method="GET">
                        <input class="search-bar" type="search" name="query" placeholder="Tìm kiếm sản phẩm ..." />
                        <button class="search-button" type="submit">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="main-content">
                <div class="table-wrapper">

                    <table id="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ảnh</th>
                                <th onclick="sortTable(2,'string')">Tên sản phẩm</th>
                                <th onclick="sortTable(3,'number')">Giá bán</th>
                                <th onclick="sortTable(4,'number')">Số lượng</th>
                                <th>Tạm tính</th>
                                <th>Xoá</th>
                            </tr>
                        </thead>
                        <tbody id="List">
                        </tbody>
                    </table>
                </div>
                <form class="input-form" id="customer_form" action="themdonhang.php" method="post">
                    <h2>THÔNG TIN KHÁCH MUA HÀNG</h2>
                    <div class="form-content">
                        <div class="input-info">
                            <label for="name">Họ và tên*</label>
                            <input type="text" name="name" id="name" required />
                            <p id="attention-name">Tên không được để trống</p>
                        </div>
                        <div class="input-info">
                            <label for="sex">Giới Tính* :</label>
                            <input name="gender" type="radio" value="Nam" checked /> Nam
                            <input name="gender" type="radio" value="Nữ" /> Nữ
                        </div>
                        <div class="input-info ">
                            <label for="phone_nubmer">Số điện thoại*</label>
                            <input class="input-error" type="tel" name="phone" id="phone" required />
                            <p id="attention">Số điện thoại phải đủ 10 số</p>
                        </div>
                        <div class="input-info">
                            <label for="address">Địa chỉ*</label>
                            <input type="text" name="address" id="address" required />
                        </div>
                        <div class="input-info">
                            <label for="email_address">Địa chỉ email*</label>
                            <input type="email" name="email" id="email" required />
                            <p id="attention-email">Địa chỉ email không đúng quy cách</p>
                        </div>

                        <div class="input-info">
                            <label for="notes">Ghi chú đơn hàng*</label>
                            <textarea name="note" id="note"></textarea>
                        </div>
                    </div>
                    <div class="add-order-button">
                        <div class="add-order-title" id="or-total">
                        </div>
                        <div class="add-order-bottom">
                            <input type="submit" name="btn-submit" value="ĐẶT HÀNG NGAY" id="order_button">
                        </div>
                </form>
            </div>
        </div>
    </div>
    <script src="../js/admin.js"></script>
    <script>
    showCartOrder();
    showTotal();
    </script>
</body>

</html>