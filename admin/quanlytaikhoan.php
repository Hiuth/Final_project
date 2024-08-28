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
            <a href=""><img class="Logo_website" src="/WebBanMayChoiGame/Picture/Logo_web_3.png" alt="" /></a>
        </div>
        <div class="middle-selection"></div>
        <div class="right-selection">
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
            <div class="table-wrapper">
            <div class="title">
                <div class="title-left">TÀI KHOẢN</div>
                <div class="title-right">
                    <form action="themtaikhoan.php" method="POST">
                        <button id ="add_account" name="add_account" value="Thêm tài khoản" <?php  echo ($_SESSION['admin']['Admin_power'] != "Quản lý") ? 'disabled' : ''; ?>>THÊM TÀI KHOẢN</button>
                    </form>
                </div>
            </div>
                <table id="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th >Tên tài khoản</th>
                            <th>Email</th>
                            <th>Mật khẩu</th>
                            <th>Quyền tài khoản</th>
                            <th>Chỉnh sửa</th>
                            <th>Xoá tài khoản</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            ShowAccountList();
                            if(isset($_POST["btn-3"])&&$_POST["btn-3"]){
                                $account_id = $_POST["Del_admin_id"];
                                DeleteAdmin_Account($account_id);
                            }
                      ?>
                    </tbody>
                </table>
                <div id="custom-alert">
                        <p>CẢNH BÁO! NÚT XOÁ SẢN PHẨM RẤT NHẠY, HÃY CẨN THẬN KHI LÀM VIỆC VỚI NÓ ! </br>
                             BẤM XOÁ LÀ XOÁ LUÔN! KHÔNG CÓ ĐƯỜNG QUAY ĐẦU ĐÂU !!!!!
                              </p>
                        <div class="button-group-2"> 
                            <button id ="accept_delete_product" onclick="denied_Log_out()" value = "yes">Đã hiểu</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <script src="../js/admin.js"></script>
    <script>

        showAlert();
</script>
</body>

</html>