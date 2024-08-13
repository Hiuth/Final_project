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
