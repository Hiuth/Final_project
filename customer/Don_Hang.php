<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- reset các định dạng mặc định -->
    <link rel="stylesheet" href="Css/reset.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
      integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.0/css/all.min.css"
      integrity="sha512-3PN6gfRNZEX4YFyz+sIyTF6pGlQiryJu9NlGhu9LrLMQ7eDjNgudQoFDK3WSNAayeIKc6B8WXXpo4a7HqxjKwg=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
      integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    ></script>
    <link rel="stylesheet" href="Css/style.css" />
    <link rel="stylesheet" href="Css/screen.css" />
    <link rel="stylesheet" href="css/DonHang.css" />
    <title>2004'S Store</title>
  </head>
  <body>
    <!-- js dùng cho menu-->
    <script>
      $(document).ready(function () {
        $("#toggle").click(function () {
          $("nav").slideToggle();
        });
      });
    </script>
    <!-- check -->
    <!-- Header -->
    <div class="header-wallpaper">
      <div class="header">
        <div class="left-selection">
          <a href="index.html">
            <img
              class="Logo_website"
              src="Picture\Logo_web_3.png"
              alt="logo_web"
          /></a>
        </div>
        <!-- search bar -->
        <div class="middle-selection">
          <input
            class="search-bar"
            type="search"
            placeholder="Tìm kiếm sản phẩm ..."
          />
          <button class="search-button">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </div>
        <div class="right-selection">
          <div class="cart-wallpaper" id="cart-1">
            <a class="Cart" href="#"
              ><span class="text-header">Giỏ Hàng /</span
              ><i class="fa-solid fa-cart-shopping"></i
            ></a>
          </div>
          <div class="cart_wallpaper_2" id="cart-2">
            <a class="Cart_2" href="#">
              <i class="fa-solid fa-cart-shopping"></i
            ></a>
          </div>
        </div>
      </div>
      <!-- Thanh điều hướng (menu) -->
      <div id="toggle">
        <!-- cái nút menu 3 gạch -->
        <i class="fa-solid fa-bars"></i>
      </div>
      <nav>
        <ul class="main-menu">
          <li>
            <a href="">
              <i class="fa-brands fa-playstation"></i>
              <span>PLAYSTATION</span></a
            >
          </li>
          <li>
            <a href="">
              <i class="fa-brands fa-xbox"></i><span>MICROSOFT XBOX</span></a
            >
          </li>
          <li>
            <a href="">
              <i class="fab fa-nintendo-switch"></i>
              <span>NITENDO SWITCH</span></a
            >
          </li>
          <li>
            <a href="">
              <i class="fa-solid fa-gamepad"></i><span>TAY CẦM GAME</span></a
            >
          </li>
          <li>
            <a href="">
              <i class="fa-solid fa-paper-plane"></i><span>LIÊN HỆ</span></a
            >
          </li>
        </ul>
      </nav>
    </div>

    <!-- Thân trang -->
        <div class="main-content">
          <form class="input-form" id="customer_form">
            <h2>THÔNG TIN KHÁCH MUA HÀNG</h2>
            <div class="form-content">
              <div class="input-info">
                <label for="name">Họ và tên*</label>
                <input type="text" name="name" id="name" required/>
              </div>
              <div class="input-info">
                <label for="sex">Giới Tính* :</label>
                <input name="gender" type="radio" value="Nam" checked /> Nam
                <input name="gender" type="radio" value="Nữ" /> Nữ
              </div>
              <div class="input-info">
                <label for="phone_nubmer">Số điện thoại*</label>
                <input type="tel" name="phone" id="phone" required/>
              </div>
              <div class="input-info">
                <label for="address">Địa chỉ*</label>
                <input type="text" name="address" id="address" required />
              </div>
              <div class="input-info">
                <label for="email_address">Địa chỉ email*</label>
                <input type="email" name="email" id="email" required/>
              </div>
    
              <div class="input-info">
                <label for="notes">Ghi chú đơn hàng*</label>
                <textarea name="note" id="note"></textarea
                >
              </div>
            </div>
            <div class="add-order-button" >
                <div class="add-order-title" id="or-total">

                    </div>
                    <div class="add-order-bottom" >
                        <a  href="#" id="order_button">ĐẶT HÀNG NGAY</a>
                    </div>
          </form>
    
            </div>
          </div>
        </div>
    <!-- Chân trang -->
    <footer class="footer">
      <div class="footer-content">
        <div class="about">
          <span class="footer-text-title">Giới Thiệu</span>
          <p>
            - 2004’S Store là đơn vị bán lẻ các sản phẩm máy chơi game, tay cầm,
            đĩa game Sony PS4, PS5, Nintendo Switch, Microsoft Xbox One uy tín.
          </p>
          <br />
          <span class="footer-text-title">ĐỊA CHỈ</span>
          <p>- 02 Võ Oanh, Phường 25, Bình Thạnh, Hồ Chí Minh</p>
          <p>- 9 Nguyễn Thị Định, An Phú, Quận 2, Thành phố Hồ Chí Minh</p>
        </div>
        <div class="contact">
          <span class="footer-text-title">LIÊN HỆ</span>
          <p>- Hotline: 0898.176.914 (Hồ Chí Minh)</p>
          <p>- 0901.497.185 (TP.HCM)</p>
          <p>- Email: 2004’sstore@gmail.com</p>
          <br />
          <span class="footer-text-title">THỜI GIAN LÀM VIỆC</span>
          <p>- 9h00 Sáng – 22h00 Tối</p>
        </div>
        <div class="follow-us">
          <span class="footer-text-title">Theo dõi 2004'S Store tại</span>
          <a
            href="https://youtu.be/dQw4w9WgXcQ?si=QiFbp9tAmNxaVkpt"
            target="_blank"
          >
            <img src="Picture\Logo_youtube.png" alt="YouTube" width="180px" />
          </a>
          <a href="https://www.tiktok.com" target="_blank">
            <img src="Picture\Logo_tiktok.png" alt="TikTok" width="180px" />
          </a>
          <a href="https://www.facebook.com" target="_blank">
            <img src="Picture\Logo_facebook.png" alt="Facebook" width="180px" />
          </a>
          <a href="https://www.facebook.com/groups/ps5vietnam">
            <img
              src="Picture\Logo_Ps5_Group.png"
              alt="Hội PS5 Việt Nam"
              width="180px"
            />
          </a>
        </div>
        <div class="info">
          <span class="footer-text-title">Thông tin</span>
          <p>- Quy định chung</p>
          <p>- Quy định đặt cọc</p>
          <p>- Quy định bảo hành</p>
          <p>- Chính sách vận chuyển</p>
          <p>- Chính sách đổi trả</p>
          <br />
          <img
            src="Picture\Logo_BoCongthuong.png"
            alt="Đã thông báo bộ công thương"
            width="200"
          />
        </div>
      </div>
    </footer>
    <script src="js/main.js"></script>
    <script src="js/button.js"></script>
    <script >
        ShowTotal_2();
    </script>
  </body>
</html>
