// đưa mặt hàng vào giỏ hàng
const addIntoCart = document.querySelectorAll(".add-cart-button");
//console.log(addIntoCart);

var productList = new Array(); //tạo mảng

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
      sessionStorage.setItem("productList", JSON.stringify(productList));
    } //stringify chuyển hết tất cả kiểu hết về string
  });
});

function ShowCart() {
  var addCart = sessionStorage.getItem("productList");
  var cartList = JSON.parse(addCart); //chuyển từ string về các kiểu dữ liệu mặc định
}
