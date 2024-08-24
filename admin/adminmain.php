<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Css/reset.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link rel="stylesheet" href="../Css/admin.css">
    <link rel="stylesheet" href="../Css/adminmain.css" />
    <title>Thông tin cá nhân</title>
  </head>
  <body>
    <header>
      <div class="left-selection">
        <a href="">
          <img
            class="Logo_website"
            src="/WebBanMayChoiGame/Picture/Logo_web_3.png"
            alt="Logo Website"
          />
        </a>
      </div>
      <div class="middle-selection"></div>
      <div class="right-selection">
        <a href="">
          <img
            class="avatar"
            src="/WebBanMayChoiGame/Picture/ps5_game_HelldriversII_4.jpg"
            alt="Avatar"
          />
        </a>
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
          <div class="employee-card">
            <div class="employee-photo">
              <img
                src="/WebBanMayChoiGame/Picture/ps5_slim.jpg"
                alt="Employee Photo"
              />
            </div>
            <div class="employee-details">
              <div class="detail-row">
                <span class="label">Họ và tên:</span>
                <span class="value">Nguyễn Huỳnh Quốc Tuấn</span>
              </div>
              <div class="detail-row">
                <span class="label">Email:</span>
                <span class="value">tuandeptraikocodon@gmail.com</span>
              </div>
              <div class="detail-row">
                <span class="label">Ngày sinh:</span>
                <span class="value">14/03/2004</span>
              </div>
              <div class="detail-row">
                <span class="label">Phân cấp tài khoản:</span>
                <span class="value">Admin</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="../js/admin.js"></script>
  </body>
</html>
