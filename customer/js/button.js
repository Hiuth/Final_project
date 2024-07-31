//xử lý chuyển đổi giữa file giỏ hàng
document.addEventListener("DOMContentLoaded", function () {
  function handleClick(event) {
    var url;
    var productList = JSON.parse(localStorage.getItem("productList")) || [];
    if (productList.length > 0) {
      window.location.assign("Gio_Hang_Co_Hang.html");
    } else {
      window.location.assign("Gio_Hang.html");
    }
  }
  document.getElementById("cart-1").addEventListener("click", handleClick);
  document.getElementById("cart-2").addEventListener("click", handleClick);
});

//xử lý tăng giảm đơn hàng
function handlePlus(x, i) {
  var parent = x.parentElement; //i dùng để định vị xem nút tăng số lượng đang ở chỗ nào

  var quantity = parseInt(parent.childNodes[3].innerHTML);
  // td = x.parentElement; sẽ đi tới vị trí cha của thằng handlePlus nhờ this (div class =but).
  // sau đó bằng thuộc tính childNodes mà chúng ta có thể lấy được số lượng hiện tại
  var new_quantity = quantity + 1;
  parent.childNodes[3].innerHTML = new_quantity;
  //cập nhật lại số lượng trong mảng
  productList[i][2] = new_quantity;
  localStorage.setItem("productList", JSON.stringify(productList));
  location.reload();
}

function handleMinus(x, i) {
  var parent = x.parentElement; //i dùng để định vị xem nút tăng số lượng đang ở chỗ nào

  var quantity = parseInt(parent.childNodes[3].innerHTML);
  // td = x.parentElement; sẽ đi tới vị trí cha của thằng handlePlus nhờ this (div class =but).
  // sau đó bằng thuộc tính childNodes mà chúng ta có thể lấy được số lượng hiện tại
  if (quantity > 1) {
    var new_quantity = quantity - 1;
    parent.childNodes[3].innerHTML = new_quantity;
    productList[i][2] = new_quantity;
    localStorage.setItem("productList", JSON.stringify(productList));
    location.reload();
  }
}
