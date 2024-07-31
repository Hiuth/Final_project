// nút tăng giảm số lượng mặt hàng trong giỏ hàng

// đưa mặt hàng vào giỏ hàng
const addIntoCart = document.querySelectorAll(".add-cart-button");
//console.log(addIntoCart);

var productList = JSON.parse(localStorage.getItem("productList")) || [];

//thêm sản phẩm vào giỏ hàng
addIntoCart.forEach(function (button, index) {
  //tạo ra sự kiện nhấn vào nút thêm giỏ hàng
  button.addEventListener("click", function (event) {
    {
      event.preventDefault();
      var btnItem = event.target; //xác định đúng phần tử đang click vào
      var product = btnItem.closest(".product-img"); //chọn thẻ cha đang chưa cái nút thêm vào
      var productImg = product.querySelector("img").src;
      var productName = product.querySelector(".name").children[0].innerText;
      var productPrice = product.querySelector(".price").innerText;
      //console.log(productImg, productName, productPrice);
      //lưu giỏ hàng lên sessionStorage
      var list = new Array(productImg, productName, productPrice);
      productList.push(list);
      localStorage.setItem("productList", JSON.stringify(productList));
    } //stringify chuyển hết tất cả kiểu hết về string
    window.location.assign("Gio_Hang_Co_Hang.html");
  });
});

function changeUnit(x) {
  var Unit_change = x.toLocaleString("vi-VN", {
    style: "currency",
    currency: "VND",
    minimumFractionDigits: 0,
    maximumFractionDigits: 0,
  });
  return Unit_change;
}

function ShowCart() {
  var addCart = localStorage.getItem("productList");
  var cartList = JSON.parse(addCart); //chuyển từ string về các kiểu dữ liệu mặc định
  var myCart = "";
  for (var i = 0; i < cartList.length; i++) {
    myCart +=
      '<tr> <td class="product-in-cart"> <button class="delete">X</button> <a href=""> <img class="img-cart" src="' +
      cartList[i][0] +
      '"></a><p> ' +
      cartList[i][1] +
      ' </p></td> <td class="product-price"> <div class="price-wallpaper"> <p class="price"> ' +
      cartList[i][2] +
      '</p> <p class="unit-price">VND</p> </div></td>' +
      '<td class="quantity-button">' +
      '<div class="but"> <button>-</button>' +
      '<input type="text" name="" id="quantity" value="1"> <button>+</button> </div> </td>' +
      '<td class="product-subtotal">' +
      '<div class="price-wallpaper">' +
      '<p class="price">' +
      cartList[i][2] +
      '</p><p class="unit-price">VND </p> </div> </td> </tr>';
  }
  document.getElementById("List").innerHTML = myCart;
}

function ShowTotal() {
  var addCart = localStorage.getItem("productList");
  var cartList = JSON.parse(addCart);
  var pro_total = 0;
  var cartTotal = "";
  for (var i = 0; i < cartList.length; i++) {
    pro_total += parseInt(cartList[i][2].replace(/\./g, ""), 10);
  }
  var Unit_change = pro_total.toLocaleString("de-DE");
  cartTotal +=
    '<tr><th>Tạm tính</th><td class="product-price"><div class="price-wallpaper"> <p class="price">' +
    Unit_change +
    '</p><p class="unit-price">VND</p></div>' +
    '</td> </tr><tr><th>Giao hàng</th><td class="delivery"> <p>  Chi phí được tính theo phí của Giao Hàng Tiết Kiệm. Quý khách vui lòng thanh toán khi nhận hàng</p>' +
    '</td></tr><tr> <th>Tổng</th> <td class="product-price"> <div class="price-wallpaper"><p class="price">' +
    Unit_change +
    '</p> <p class="unit-price">VND</p> </div></td></tr>';
  document.getElementById("total").innerHTML = cartTotal;
}
