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
