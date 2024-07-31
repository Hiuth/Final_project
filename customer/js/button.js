// // nút tăng giảm số lượng mặt hàng trong giỏ hàng
// var amountElement = document.getElementById("quantity");
// var amount = amountElement.value;
// console.log(amount);

// //xử lý việc tăng lên
// function handlePlus() {
//   amount++;
//   Update(amount); //cập nhật lại amount
// }

// //cập nhật lại biến đang hiển thị
// function Update(amount) {
//   amountElement.value = amount;
// }

// //Xử lý việc giảm dần
// function handleMinus() {
//   if (amount > 1) {
//     amount--;
//   }
//   Update(amount);
// }
// //xử lý việc nhập chữ hoặc số vào trong ô
// amountElement.addEventListener("input", function () {
//   amount = amountElement.value; //cập nhật lại giá trị cho amount
//   //amountElement sẽ lấy những gì mình đang nhập vô hiện tại và gán cho amount
//   amount = parseInt(amount); //chuyển về kiểu số nguyên, nếu không phải số thì nó sẽ xuất ra NaN là 1 text
//   // amount = isNaN(amount) ? 1 : amount;
//   Update(amount);
//   if (isNaN(amount)) {
//     amount = 1;
//     Update(amount);
//   }
// });
