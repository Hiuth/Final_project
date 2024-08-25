<?php
  require_once("connect-admin.php");
  include "admin.php";
  if(isset($_POST["btn-7"])&&$_POST["btn-7"]){
    $order_id = $_POST['Order_id'];
    $Order_status = $_POST['order-status'];
    $Payment_status= $_POST['payment-status'];
    $Payment_status_2 = $_POST['payment_edit'];
    $Shipping_status = $_POST['shipping-status'];
    $Shipping_status_2 = $_POST['shipping_edit'];
    $note = $_POST['note'];
    $address = $_POST['address'];
    if(empty($Order_status)){
      $Order_status = "Đã xác nhận";
    }

    if(empty($Shipping_status) ){
       echo'hello'; 
       updateOrder($order_id, $Order_status,$Payment_status_2, $Shipping_status_2, $note,$address);
      echo '<script>window.location.href="donhang.php?";</script>';
    }elseif(empty($Payment_status)){
      updateOrder($order_id, $Order_status,$Payment_status_2, $Shipping_status, $note,$address);
     echo '<script>window.location.href="donhang.php?";</script>';
    }elseif(empty($Shipping_status) && empty($Payment_status)){
      updateOrder($order_id, $Order_status,$Payment_status_2, $Shipping_status_2, $note,$address);
     echo '<script>window.location.href="donhang.php?";</script>';
    }elseif(!empty($Shipping_status) && !empty($Payment_status) ){
      updateOrder($order_id, $Order_status,$Payment_status, $Shipping_status, $note,$address);
      echo '<script>window.location.href="donhang.php?";</script>';
    }

    if($Shipping_status == "Gửi hàng thành công" && $Payment_status =="Đã thanh toán"){
      changeLocation($order_id);
    }

    if($Order_status == "Đã xác nhận"){
      UpdateProduct_Quantity($order_id,"minus",$Order_status);
    }
  }
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Css/reset.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    />
    <link rel="stylesheet" href="../Css/suatrangthai.css" />
    <title>Quản lý Đơn hàng</title>
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
      <div class="main-content">
        <h1>Chỉnh sửa trạng thái</h1>
        <form action ="suatrangthai.php" method = "POST">
          <!-- <div class="form-row">
            <div class="form-group">
              <label for="customer-name">Tên khách hàng</label>
              <input type="text" id="customer-name" name="customer-name" />
            </div>
            <div class="form-group">
              <label for="shipping-status">Trạng thái giao hàng</label>
              <select id="shipping-status" name="shipping-status">
                <option value="Chưa được gửi">Chưa được gửi</option>
                <option value="Đã gửi hàng">Đang gửi hàng</option>
                <option value="Gửi hàng thành công">Gửi hàng thành công</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="phone">Số điện thoại</label>
              <input type="text" id="phone" name="phone" />
            </div>
            <div class="form-group">
              <label for="payment-status">Trạng thái thanh toán</label>
              <select id="payment-status" name="payment-status">
                <option value="Chưa thanh toán">Chưa thanh toán</option>
                <option value="Đã thanh toán">Đã thanh toán</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" />
            </div>
            <div class="form-group">
              <label for="order-status">Trạng thái đơn hàng</label>
              <select id="order-status" name="order-status">
                <option value="Chưa xác nhận">Chưa xác nhận</option>
                <option value="Đã xác nhận">Đã xác nhận</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="address">Địa chỉ</label>
              <input type="text" id="address" name="address" />
            </div>
            <div class="form-group">
              <label for="note">Ghi chú</label>
              <input type="text" id="note" name="note" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="order-date">Ngày đặt</label>
              <input type="text" id="order-date" name="order-date" />
            </div>
            <div class="form-group">
              <label for="total-value">Tổng giá trị đơn hàng</label>
              <input type="text" id="total-value" name="total-value" />
            </div>
          </div>
          <div class="button-container">
            <button type="submit" class="submit-button">
              Xác nhận chỉnh sửa
            </button>
          </div> -->
          <?php
            if(isset($_POST["btn-2"])&&$_POST["btn-2"]){
              $order_id= $_POST["Order_id"];
              showOrderStatus_edit($order_id);
            }
          ?>
        </form>
      </div>
    </div>
    <script src="../js/admin.js"></script>
  </body>
</html>
