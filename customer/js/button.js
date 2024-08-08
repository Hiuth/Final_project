document.addEventListener("DOMContentLoaded", function () {
  var productList = JSON.parse(localStorage.getItem("productList")) || [];
  //xử lý chuyển đổi giữa file giỏ hàng
  // cập nhật số lượng sản phẩm có trong giỏ hàng
  function updateCartCount() {
    var count = productList.length;
    var links = document.querySelectorAll(".Cart, .Cart_2");
    links.forEach(function (links) {
      links.setAttribute("count", count);
    });
  }
  updateCartCount();
  function handleClick(event) {
    console.log(productList.length);
    if (productList.length > 0) {
      window.location.assign("/Final_project/customer/Gio_Hang_Co_Hang.html");
    } else {
      window.location.assign("/Final_project/customer/Gio_Hang.html");
    }
  }
  document.getElementById("cart-1").addEventListener("click", handleClick);
  document.getElementById("cart-2").addEventListener("click", handleClick);
});

var productList = JSON.parse(localStorage.getItem("productList")) || [];
//xử lý chuyển đổi giữa file giỏ hàng
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

// nút bấm di chuyển qua lại ảnh

document.addEventListener("DOMContentLoaded", function () {
  var mainImage = document.getElementById("main-image");
  var thumbnails = document.querySelectorAll(".product-thumbnails img");
  var currentPictureIndex = 0;

  // cập nhật ảnh to và cập nhật khung viền cho ảnh nhỏ bên dưới
  function updateMainImg(Index) {
    mainImage.src = thumbnails[Index].src;
    document
      .querySelector(".product-thumbnails img.active")
      .classList.remove("active");
    thumbnails[Index].classList.add("active");
  }
  // sao lại -1 ? đơn giản thôi length nó đếm từ 1 trở đi. nhưng số thứ tự nó đếm từ 0 nên thành ra -1. giống như mảng z đó
  document.getElementById("prev-button").addEventListener("click", function () {
    if (currentPictureIndex > 0) {
      currentPictureIndex = currentPictureIndex - 1;
    } else {
      currentPictureIndex = thumbnails.length - 1;
    }
    updateMainImg(currentPictureIndex);
  });

  document.getElementById("next-button").addEventListener("click", function () {
    if (currentPictureIndex < thumbnails.length - 1) {
      currentPictureIndex = currentPictureIndex + 1;
    } else {
      currentPictureIndex = 0;
    }
    updateMainImg(currentPictureIndex);
  });

  //bấm chuột vào ảnh nào thì cập nhật lại chỉ số

  thumbnails.forEach(function (thumbnails, index) {
    thumbnails.addEventListener("click", function () {
      currentPictureIndex = index;
      updateMainImg(currentPictureIndex);
    });
  });
});
