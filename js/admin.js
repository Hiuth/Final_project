var sortMemory = {};

function sortTable(n, type) {
  var table = document.getElementById("table");
  var swap = true;
  var shouldSwap;
  if (!sortMemory[n]) {
    sortMemory[n] = "asc";
  }

  sort = sortMemory[n];
  var rows = table.getElementsByTagName("TR");

  while (swap) {
    swap = false;
    for (var i = 1; i < rows.length - 1; i++) {
      shouldSwap = false;
      var rowTop = rows[i].getElementsByTagName("TD")[n];
      var rowBelow = rows[i + 1].getElementsByTagName("TD")[n];
      var rowTopValue, rowBelowValue;

      if (type === "number") {
        var top = rowTop.querySelector(".price").innerText;
        rowTopValue = parseInt(top.replace(/\./g, ""), 10);
        var below = rowBelow.querySelector(".price").innerText;
        rowBelowValue = parseInt(below.replace(/\./g, ""), 10);
      } else if (type === "string") {
        rowTopValue = rowTop.innerHTML.toLowerCase();
        rowBelowValue = rowBelow.innerHTML.toLowerCase();
      } else if (type === "date") {
        rowTopValue = new Date(rowTop.innerText);
        rowBelowValue = new Date(rowBelow.innerText);
      }

      if (
        (sort === "asc" && rowTopValue > rowBelowValue) ||
        (sort === "desc" && rowTopValue < rowBelowValue)
      ) {
        shouldSwap = true;
        break;
      }
    }

    if (shouldSwap) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      swap = true;
    }

    if (!shouldSwap && sort === "asc") {
      sortMemory[n] = "desc";
    } else if (!shouldSwap && sort === "desc") {
      sortMemory[n] = "asc";
    }
  }
}

// thêm đơn hàng
var OrderCart = JSON.parse(sessionStorage.getItem("productOrder")) || [];

function check(name) {
  if (OrderCart.length === 0) {
    return false;
  } else {
    for (var i = 0; i < OrderCart.length; i++) {
      if (OrderCart[i][2] === name) {
        OrderCart[i][4]++;
        sessionStorage.setItem("productOrder", JSON.stringify(OrderCart));
        return true;
      }
    }
    return false;
  }
}

function del(x) {
  var del = x.parentElement.parentElement;
  var name = del.querySelector(".product_name").innerText;
  console.log(name);
  del.remove();
  for (var i = 0; i < OrderCart.length; i++) {
    if (OrderCart[i][2] === name) {
      OrderCart.splice(i, 1);
    }
  }
  sessionStorage.setItem("productOrder", JSON.stringify(OrderCart));
  location.reload();
}

function addOrder(n) {
  var product = n.parentElement.parentElement;
  var product_id = product.querySelector(".product_id").innerText;
  var product_img = product.querySelector("img").src;
  var product_name = product.querySelector(".product_name").innerText;
  var product_price = product.querySelector(".price").innerText;
  var quantity = 1;
  var quantityInWarehouse = product.querySelector(".Quantity").innerText;
  if (check(product_name) === false) {
    var list = new Array(
      product_id,
      product_img,
      product_name,
      product_price,
      quantity,
      quantityInWarehouse
    );
    OrderCart.push(list);
    sessionStorage.setItem("productOrder", JSON.stringify(OrderCart));
  }
}

function showCartOrder() {
  var total = 0;
  var myOrder = "";
  if (OrderCart.length === 0) {
    myOrder +=
      '<tr><td class="product_id">0</td>' +
      '<td class="product_img">' +
      '<img class="img-table" src="" alt="" /> Chưa có dữ liệu sản phẩm' +
      '</td><td class = "product_name">' +
      'Chưa có dữ liệu sản phẩm, vui lòng vào mục sản phẩm để thêm dữ liệu đơn hàng </td><td><div class="price-wallpaper">' +
      '<p class="price">0</p>' +
      '<p class="unit-price">VND</p></div>' +
      '</td><td class = "Quantity">Chưa có dữ liệu</td>' +
      "<td>Chưa có dữ liệu</td>" +
      '<td><form action="" method="POST">' +
      '<input type="hidden" name="Order_id" value="">' +
      '<button class="trash" onclick="del(this)">' +
      ' <i class="fa-solid fa-trash"></i></button></form></td></tr>';
  } else {
    for (var i = 0; i < OrderCart.length; i++) {
      var price = parseInt(OrderCart[i][3].replace(/\./g, ""), 10);
      var quantity = parseInt(OrderCart[i][4], 10);
      total = price * quantity;
      myOrder +=
        '<tr><td class="product_id">' +
        OrderCart[i][0] +
        "</td>" +
        '<td class="product_img">' +
        '<img class="img-table" src="' +
        OrderCart[i][1] +
        '" alt="" /> ' +
        '</td><td class = "product_name">' +
        "" +
        OrderCart[i][2] +
        ' </td><td><div class="price-wallpaper">' +
        '<p class="price">' +
        OrderCart[i][3] +
        "</p>" +
        '<p class="unit-price">VND</p></div>' +
        '</td><td class="quantity-button">' +
        '<div class="but"> <button class="minus-btn" onclick="handleMinus(this,' +
        i +
        ')">-</button> <span>' +
        OrderCart[i][4] +
        '</span> <button class="plus-btn" onclick="handlePlus(this,' +
        i +
        ')">+</button> </div>' +
        "</td>" +
        '<td class ="total"><div class="price-wallpaper">' +
        '<p class="price">' +
        total.toLocaleString("de-DE") +
        "</p>" +
        '<p class="unit-price">VND</p></div></td>' +
        '<td><button class="trash" onclick="del(this)">' +
        ' <i class="fa-solid fa-trash"></i></button></td></tr>';
    }
  }

  document.getElementById("List").innerHTML = myOrder;
}

function showTotal() {
  var pro_total = 0;
  var order_total = "";
  for (var i = 0; i < OrderCart.length; i++) {
    var price = parseInt(OrderCart[i][3].replace(/\./g, ""), 10);
    var quantity = parseInt(OrderCart[i][4], 10);
    pro_total += price * quantity;
  }
  var Unit_change = pro_total.toLocaleString("de-DE");
  order_total +=
    '<span class="order-but-tilte">Tổng tiền</span><span class="order-total">' +
    Unit_change +
    '<span class="unit-price">VND</span>';
  document.getElementById("or-total").innerHTML = order_total;
}

//nút tăng giảm số lượng đơn hàng

function handleMinus(x, i) {
  var parent = x.parentElement;
  var number = parseInt(parent.querySelector("span").innerHTML);
  if (number > 1) {
    var newNum = number - 1;
    parent.querySelector("span").innerHTML = newNum;
    OrderCart[i][4] = newNum;
    sessionStorage.setItem("productOrder", JSON.stringify(OrderCart));
    location.reload();
  }
}

function handlePlus(x, i) {
  var parent = x.parentElement;
  var number = parseInt(parent.querySelector("span").innerHTML);
  var newNum = number + 1;
  console.log(newNum);
  parent.querySelector("span").innerHTML = newNum;
  OrderCart[i][4] = newNum;
  sessionStorage.setItem("productOrder", JSON.stringify(OrderCart));
  location.reload();
}

document.addEventListener("DOMContentLoaded", function () {
  function sendCart(event) {
    var info = document.getElementById("customer_form");
    var attention = document.getElementById("attention");
    var attention_email = document.getElementById("attention-email");
    var attention_name = document.getElementById("attention-name");
    var isFormTrue = true;
    var info_data = {
      name: info.name.value,
      gender: info.querySelector('input[name="gender"]:checked').value,
      phone: info.phone.value,
      address: info.address.value,
      email: info.email.value,
      note: info.note.value,
    };
    if (info.name.value === null) {
      attention_name.style.display = "block";
      isFormTrue = false;
    } else {
      attention_name.style.display = "none";
    }

    if (info.phone.value.length != 10) {
      attention.style.display = "block";
      isFormTrue = false;
    } else {
      attention.style.display = "none";
    }

    if (!info.email.value.endsWith("@gmail.com")) {
      attention_email.style.display = "block";
      isFormTrue = false;
    } else {
      attention_email.style.display = "none";
    }

    for (var i = 0; i < OrderCart.length; i++) {
      if (OrderCart[i][4] > OrderCart[i][5]) {
        console.log(OrderCart[i][4]);
        isFormTrue = false;
        alert(
          "Số lượng sản phẩm " +
            OrderCart[i][2] +
            " đang vượt quá số lượng sản phẩm có trong kho"
        );
        break;
      }
    }
    if (isFormTrue) {
      // hàm gửi dữ liệu từ local storage sang php
      var Data = sessionStorage.getItem("productOrder");
      var url = "themdonhang.php";
      var options = {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: "data=" + encodeURIComponent(Data), // hàm mã hoá chuỗi
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
      sessionStorage.clear();
      location.reload();
    } else {
      event.preventDefault();
    }
  }

  document.getElementById("order_button").addEventListener("click", sendCart);
});

function ChangeTotal() {
  var quantity = document.getElementById("quantity").value;
  var price = parseInt(
    document.getElementById("price").value.replace(/\./g, ""),
    10
  );

  var total = price * quantity;
  //console.log(total);
  document.getElementById("total").value = total.toLocaleString("de-DE");
}

document.getElementById("file").addEventListener("change", function (event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      document.getElementById("upload-Img").src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});

function checkQuantity() {
  var product_quantity = document.getElementById("product_quantity").value;
  var order_quantity = document.getElementById("quantity").value;
  var attention = document.getElementById("attention");
  var button = document.getElementById("submit-button");
  console.log(order_quantity);
  if (parseInt(order_quantity) > parseInt(product_quantity)) {
    attention.style.display = "block";
    button.disabled = true;
  } else {
    attention.style.display = "none";
    button.disabled = false;
  }
}

function showAlert() {
  document.getElementById("custom-alert").style.display = "block";
}

function closeAlert() {
  document.getElementById("custom-alert").style.display = "none";
  window.location.href = "sanpham.php";
}
//log_out
function accept_Log_out() {
  document.getElementById("custom-alert").style.display = "none";
  setTimeout(function () {
    window.location.href = "index.php";
  }, 1000);
}

window.addEventListener("popstate", function (event) {
  event.preventDefault();
  history.go(1);
});

function denied_Log_out() {
  document.getElementById("custom-alert").style.display = "none";
}

function TakeProduct_name() {
  var name = document.getElementById("product-name").value.trim();
  var attention = document.getElementById("attention");
  var button = document.getElementById("submit-button");
  fetch("apiCall.php") // Gọi file PHP riêng biệt
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.json();
    })
    .then((product_name) => {
      var found = false;
      product_name.forEach(function (product) {
        if (name === product.trim()) {
          found = true;
        }
      });
      if (found) {
        attention.style.display = "block";
        button.disabled = true;
      } else {
        attention.style.display = "none";
        button.disabled = false;
      }
    })
    .catch((error) => console.log("Đã xảy ra lỗi:", error));
}

function CheckEmail_Account() {
  var Email = document.getElementById("admin-email").value.trim();
  var attention = document.getElementById("attention");
  var button = document.getElementById("submit-button");
  fetch("apiCall.php")
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok " + response.statusText);
      }
      return response.json();
    })
    .then((Admin_email) => {
      var found = false;
      Admin_email.forEach(function (admin_account) {
        if (Email === admin_account.trim()) {
          found = true;
        }
      });
      if (found) {
        attention.style.display = "block";
        button.disabled = true;
      } else {
        attention.style.display = "none";
        button.disabled = false;
      }
    })
    .catch((error) => console.log("Đã xảy ra lỗi:", error));
}
