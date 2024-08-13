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
        return true;
      }
    }
    return false;
  }
}

function del(x) {}

function addOrder(n) {
  var product = n.parentElement.parentElement;
  var product_id = product.querySelector(".product_id").innerText;
  var product_img = product.querySelector("img").src;
  var product_name = product.querySelector(".product_name").innerText;
  var product_price = product.querySelector(".price").innerText;
  var quantity = 1;
  if (check(product_name) === false) {
    var list = new Array(
      product_id,
      product_img,
      product_name,
      product_price,
      quantity
    );
    OrderCart.push(list);
    sessionStorage.setItem("productOrder", JSON.stringify(OrderCart));
  }
}

function showCartOrder() {
  var total = 0;
  var myOrder = "";
  console.log(OrderCart);
  if (OrderCart.length === 0) {
    myOrder +=
      '<tr><td class="product_id">1</td>' +
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
        '</td><td class = "Quantity">' +
        OrderCart[i][4] +
        "</td>" +
        '<td class ="total"><div class="price-wallpaper">' +
        '<p class="price">' +
        total.toLocaleString("de-DE") +
        "</p>" +
        '<p class="unit-price">VND</p></div></td>' +
        '<td><form action="" method="POST">' +
        '<input type="hidden" name="Order_id" value="">' +
        '<button class="trash" onclick="del(this)">' +
        ' <i class="fa-solid fa-trash"></i></button></form></td></tr>';
    }
  }

  document.getElementById("List").innerHTML = myOrder;
}
