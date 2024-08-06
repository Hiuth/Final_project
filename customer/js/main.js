//thanh nav di chuyển theo màn ảnh

// đưa mặt hàng vào giỏ hàng
var productList = JSON.parse(localStorage.getItem("productList")) || [];

//
function check(name) {
  if (productList.length === 0) {
    return false;
  } else {
    for (var i = 0; i < productList.length; i++) {
      if (productList[i][1] == name) {
        productList[i][2]++;
        localStorage.setItem("productList", JSON.stringify(productList));
        return true;
      }
    }
    return false;
  }
}
window.addEventListener("pageshow", function (event) {
  if (event.persisted) {
    // Nếu trang được tải từ cache, làm mới trang
    window.location.reload();
  }
});

//thêm sản phẩm vào giỏ hàng
const addIntoCart = document.querySelectorAll(".add-cart-button");
addIntoCart.forEach(function (button, index) {
  //tạo ra sự kiện nhấn vào nút thêm giỏ hàng
  button.addEventListener("click", function (event) {
    {
      event.preventDefault();
      var btnItem = event.target; //xác định đúng phần tử đang click vào
      var product = btnItem.closest(".product-img"); //chọn thẻ cha đang chưa cái nút thêm vào
      var productImg = product.querySelector("img").src;
      var productName = product.querySelector(".name").children[0].innerText;
      var productQuantity = 1;
      var productPrice = product.querySelector(".price").innerText;
      console.log(productImg, productName, productPrice);
      //lưu giỏ hàng lên sessionStorage
      var list = new Array(
        productImg,
        productName,
        productQuantity,
        productPrice
      );
      if (check(productName) == false) {
        productList.push(list);
        localStorage.setItem("productList", JSON.stringify(productList));
      }
    } //stringify chuyển hết tất cả kiểu hết về string
    window.location.assign("/Final_project/customer/Gio_Hang_Co_Hang.html");
  });
});

//bỏ hàng vô giỏ khi đang ở trong chi tiết sản phẩm

// document.addEventListener("DOMContentLoaded", function () {
//   function addIntoCart_2(event) {
//     event.preventDefault();
//     var addItem = event.target;
//     var product = addItem.closest(".product");
//     var productImg = product.querySelector(".product-image").children[0].src;
//     console.log(productImg);
//   }
//   document.getElementById("add-cart").addEventListener("click", addIntoCart_2);
// });

function del(x) {
  //xoá hàng
  var del = x.parentElement.parentElement;
  var pro_Name = del.children[0].querySelector("p").innerText;
  del.remove();
  for (var i = 0; i < productList.length; i++) {
    if (productList[i][1] == pro_Name) {
      productList.splice(i, 1); //xoá đơn hàng trong local
    }
  }
  localStorage.setItem("productList", JSON.stringify(productList));
  if (productList.length > 0) {
    location.reload();
  } else {
    window.location.assign("Gio_Hang.html");
  }
}

function ShowCart() {
  var addCart = localStorage.getItem("productList");
  var cartList = JSON.parse(addCart); //chuyển từ string về các kiểu dữ liệu mặc định
  var myCart = "";
  var total = 0;
  for (var i = 0; i < cartList.length; i++) {
    var unitPrice = parseInt(cartList[i][3].replace(/\./g, ""), 10);
    var quantity = parseInt(cartList[i][2], 10);
    total = unitPrice * quantity;
    myCart +=
      '<tr> <td class="product-in-cart"> <button class="delete" onclick="del(this)">X</button> <a href=""> <img class="img-cart" src="' +
      cartList[i][0] +
      '"></a><p> ' +
      cartList[i][1] +
      ' </p></td> <td class="product-price"> <div class="price-wallpaper"> <p class="price"> ' +
      cartList[i][3] +
      '</p> <p class="unit-price">VND</p> </div></td>' +
      '<td class="quantity-button">' +
      '<div class="but"> <button class="minus-btn" onclick="handleMinus(this,' +
      i +
      ')">-</button> <span>' +
      cartList[i][2] +
      '</span> <button class="plus-btn" onclick="handlePlus(this,' +
      i +
      ')">+</button> </div> </td>' +
      '<td class="product-subtotal">' +
      '<div class="price-wallpaper">' +
      '<p class="price">' +
      total.toLocaleString("de-DE") +
      '</p><p class="unit-price">VND </p> </div> </td> </tr>';
  }
  document.getElementById("List").innerHTML = myCart;
}

function ShowTotal() {
  var addCart = localStorage.getItem("productList");
  var cartList = JSON.parse(addCart);
  var pro_total = 0;
  var cartTotal = "";
  var order_total = "";
  for (var i = 0; i < cartList.length; i++) {
    var unitPrice = parseInt(cartList[i][3].replace(/\./g, ""), 10);
    var quantity = parseInt(cartList[i][2], 10);
    pro_total += unitPrice * quantity;
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

function ShowTotal_2() {
  var addCart = localStorage.getItem("productList");
  var cartList = JSON.parse(addCart);
  var pro_total = 0;
  var order_total = "";
  for (var i = 0; i < cartList.length; i++) {
    var unitPrice = parseInt(cartList[i][3].replace(/\./g, ""), 10);
    var quantity = parseInt(cartList[i][2], 10);
    pro_total += unitPrice * quantity;
  }
  var Unit_change = pro_total.toLocaleString("de-DE");
  order_total +=
    '<span class="order-but-tilte">Tổng tiền</span><span class="order-total">' +
    Unit_change +
    '<span class="unit-price">VND</span>';
  document.getElementById("or-total").innerHTML = order_total;
}

//Thêm đợt đặt hàng
//Lấy dữ liệu từ form
// var Customer_info = [];

document.addEventListener("DOMContentLoaded", function () {
  function sendCart(event) {
    var info = document.getElementById("customer_form");
    var isFormTrue = true;
    var info_data = {
      name: info.name.value,
      gender: info.querySelector('input[name="gender"]:checked').value,
      phone: info.phone.value,
      address: info.address.value,
      email: info.email.value,
      note: info.note.value,
    };
    var checkPhone = document.getElementById("phone");
    var checkEmail = document.getElementById("email");
    if (info.phone.value.length !== 10) {
      checkPhone.classList.add("input-error");
      isFormTrue = false;
    } else {
      checkPhone.classList.remove("input-error");
    }

    if (!info.email.value.endsWith("@gmail.com")) {
      checkPhone.classList.add("input-error");
      isFormTrue = false;
    } else {
      checkPhone.classList.remove("input-error");
    }

    if (isFormTrue) {
      // hàm gửi dữ liệu từ local storage sang php
      var localStorageData = localStorage.getItem("productList");
      var url = "test.php";
      var options = {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "data=" + encodeURIComponent(localStorageData), // hàm mã hoá chuỗi
      };

      fetch(url, options)
        .then((response) => response.text()) // Đổi từ json sang text
        .then((data) => {
          console.log("Phản hồi từ server:", data);
          return JSON.parse(data);
        })
        .then((parsedData) => {
          console.log(":", parsedData);
        })
        .catch((error) => {
          console.error("Lỗi khi gửi yêu cầu:", error);
        });
      localStorage.clear();
      location.reload();
    }
  }
  document.getElementById("order_button").addEventListener("click", sendCart);
});
