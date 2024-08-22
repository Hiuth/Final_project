<?php
    //xử lý đăng nhập
    function Login($username, $password) {
        $conn= connect();
        $sql = "SELECT Admin_id, Admin_email, Admin_name, Admin_password, Admin_power FROM admin_account WHERE Admin_email =? AND Admin_password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username,$password);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc(); 
            $_SESSION["admin"] = $row;
            return true;
        }else{
            return false;
        }

    }

    //xử lý đơn hàng
    function Create_Customer_Info($username, $gender, $phone_number, $address, $email){
        $conn= connect();
        $stmt = $conn->prepare("SELECT Customer_id FROM Customer WHERE Customer_name=? AND Customer_phone = ?  AND Customer_sex=? AND Customer_address = ? AND Customer_email = ?");
        $stmt->bind_param("sisss", $username, $phone_number,$gender,$address,$email);
        $stmt->execute();
        $result = $stmt->get_result();  
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customer_id = $row['Customer_id'];
            $conn->close();
            $stmt->close();
            return $customer_id;
        } else {
            //echo "Khách hàng không tồn tại trong cơ sở dữ liệu.";
            $sql = "INSERT INTO Customer (Customer_name, Customer_sex, Customer_phone, Customer_address, Customer_email)
            VALUES ('$username', '$gender', '$phone_number', '$address', '$email')";
            $conn->query($sql);
            $last_id = $conn->insert_id;
            $conn->close();
            $stmt->close();
            return $last_id;
        }
       
    }

    function FormatNumber($number){
        $formatNumber = $number;
        $cleanNumber= str_replace('.','', $formatNumber);
        $Number= (int)$cleanNumber;
        return $Number;
    }
    function Cart_total(){
        $cart_total = 0;
        if(sizeof($_SESSION['productOrder'])>0){
            for($i=0;$i<sizeof($_SESSION['productOrder']);$i++)
            {
                // $formatNumber = $_SESSION['productList'][$i][3];
                // $cleanNumber= str_replace('.','', $formatNumber);
                // $Number= (int)$cleanNumber;
                $Number = FormatNumber($_SESSION['productOrder'][$i][3]);
                $total = $_SESSION['productOrder'][$i][4]*$Number;
                $cart_total+=$total;
            }
        }
        return $cart_total;
    }


    function Create_orders($Customer_id,$cart_total,$note,$address){
        $conn= connect();
        $today=date('Y-m-d');
        $shipping_status= "Chưa được gửi";
        $payment_status="Chưa thanh toán";
        $order_status="Chưa xác nhận";
        $sql="INSERT INTO orders(Customer_id,Order_date,Order_total,Order_note,Shipping_address, Payment_status,Shipping_status,Order_status)
        VALUES ('$Customer_id','$today','$cart_total','$note','$address','$payment_status','$shipping_status','$order_status')";
            $conn->query($sql);
            $last_id = $conn->insert_id;
            $conn->close();
            return $last_id;
    }

    function Create_orders_details($orders_id){
        $conn= connect();
        for($i= 0;$i<sizeof($_SESSION['productOrder']);$i++){
            $stmt = $conn->prepare("SELECT Product_id FROM product WHERE Product_name = ? ");
            $product_name= $_SESSION['productOrder'][$i][2];
            $product_quantity=$_SESSION['productOrder'][$i][4];
            $Number = FormatNumber($_SESSION['productOrder'][$i][3]);

            $unit_price= $_SESSION['productOrder'][$i][4]*$Number;
            $stmt->bind_param("s", $product_name);
            $stmt->execute();
            $result = $stmt->get_result();  
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $product_id = $row['Product_id'];
            }


            $sql = "INSERT INTO orderdetails(Order_id,Product_id,Quantity,UnitPrice)
            VALUES ('$orders_id','$product_id','$product_quantity','$unit_price')";
             $conn->query($sql);
        }
        $conn->close();
        $stmt->close();
    }


    function create_product($product_img,$product_name,$product_price,$product_brand,$product_category,$product_quantity){
            $conn= connect();
            $number = FormatNumber($product_price);
            $img= "/WebBanMayChoiGame/Picture/".$product_img;
            $name = strtoupper($product_name);
            $sql = "INSERT INTO product(Product_img,Product_name,Product_price,Brand_id,Category_id,Quantity)
            VALUES ('$img','$name','$number','$product_brand','$product_category','$product_quantity')";
            $conn->query($sql);
            $conn->close();
    }



    //Find Function zone

    function FindCustomerInfo($id){
        $conn= connect();
        $sql_customer = 'SELECT Customer_name,Customer_phone,Customer_email FROM customer WHERE Customer_id = ?';
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("i",$id);
        $stmt_customer->execute();
        $result_customer=$stmt_customer->get_result();
        if($result_customer->num_rows > 0){
            $row=$result_customer->fetch_assoc();
            $customer_name = $row['Customer_name'];
            $customer_phone = $row['Customer_phone'];
            $customer_email = $row['Customer_email'];
            $customer_info=[ $customer_name, $customer_phone, $customer_email];
        }

        
        $conn->close();
        $stmt_customer->close();
        return $customer_info;
    }

    function FindProductInfo($id){
        $conn= connect();
        $sql_customer = 'SELECT Product_img,Product_name,Product_price, Brand_id, Category_id FROM product WHERE Product_id = ?';
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("i",$id);
        $stmt_customer->execute();
        $result_customer=$stmt_customer->get_result();
        if($result_customer->num_rows > 0){
            $row=$result_customer->fetch_assoc();
            $Product_img = $row['Product_img'];
            $Product_name = $row['Product_name'];
            $Product_price = $row['Product_price'];
            $Brand_id = $row['Brand_id'];
            $Category_id = $row['Category_id'];
            $Product_info=[ $Product_img, $Product_name, $Product_price, $Brand_id,$Category_id];
        }

        
        $conn->close();
        $stmt_customer->close();
        return $Product_info;
    }

    function FindOrderInfo($id){
        $conn= connect();
        $sql_customer = 'SELECT Order_id,Order_total,Order_status,Payment_Status, Shipping_status FROM orders WHERE Order_id = ?';
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("i",$id);
        $stmt_customer->execute();
        $result_customer=$stmt_customer->get_result();
        if($result_customer->num_rows > 0){
            $row=$result_customer->fetch_assoc();
            $Order_id = $row['Order_id'];
            $Order_total = $row['Order_total'];
            $Order_status = $row['Order_status'];
            $Payment_Status= $row['Payment_Status'];
            $Shipping_status= $row['Shipping_status'];
            $order_info=[ $Order_id,$Order_total,$Order_status,$Payment_Status,$Shipping_status ];
        }

        
        $conn->close();
        $stmt_customer->close();
        return $order_info;
    }

    function FindOrderInfoWithCustomer($id){
        $conn= connect();
        $order_info = null;
        $sql_customer = 'SELECT Order_id,Order_date,Order_total,Order_status,Payment_Status, Shipping_status FROM orders WHERE Customer_id = ?';
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("i",$id);
        $stmt_customer->execute();
        $result_customer=$stmt_customer->get_result();
        if($result_customer->num_rows > 0){
            $row=$result_customer->fetch_assoc();
            if($row["Order_total"] != null){
                $Order_id = $row['Order_id'];
                $Order_total = $row['Order_total'];
                $Order_status = $row['Order_status'];
                $Payment_Status= $row['Payment_Status'];
                $Shipping_status= $row['Shipping_status'];
                $Order_date = $row['Order_date'];
                $order_info=[ $Order_id,$Order_total,$Order_status,$Payment_Status,$Shipping_status,$Order_date ];
            }
        }

        
        $conn->close();
        $stmt_customer->close();
        return $order_info;
    }

    function FindOrderDetailsInfo( $id ){
        $conn= connect();
        $sql_customer = 'SELECT Order_id, Product_id, Quantity,UnitPrice FROM orderdetails WHERE OrderDetails_id = ?';
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("i",$id);
        $stmt_customer->execute();
        $result_customer=$stmt_customer->get_result();
        if($result_customer->num_rows > 0){
            $row=$result_customer->fetch_assoc();
            $Order_id = $row['Order_id'];
            $Product_id = $row['Product_id'];
            $Quantity = $row['Quantity'];
            $UnitPrice = $row['UnitPrice'];
            $orderDetails_info=[ $Order_id,$Product_id, $Quantity, $UnitPrice ];
        }

        
        $conn->close();
        $stmt_customer->close();
        return $orderDetails_info;
    }

    //show function zone
    function ShowProductAdmin(){
        $conn= connect();
        $sql = "SELECT Product_id,Product_img, Product_name, Product_price, Quantity FROM product";
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $count=1;
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                echo '  <tr>
                            <td class="product_id">'.$row["Product_id"].'</td>
                            <td class="product_img">
                                <img class="img-table" src="'.$row["Product_img"].'" alt="" />
                            </td>
                            <td class = "product_name">
                                '.$row["Product_name"].'
                            </td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">'.number_format($row["Product_price"],0,',','.').'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td class = "Quantity">'.$row["Quantity"].'</td>
                            <td>
                             <form action="chinhsuasanpham.php" method="POST">
                                <input type="hidden" name="Product_id" value="'.$row["Product_id"].'">
                            <button class="fix-product" type="submit" name="btn-2" value="fix">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                            </form>
                            </td>
                            <td>
                                <button class="cart" onclick = "addOrder(this)" >
                                  <i class="fa-solid fa-cart-plus"></i>
                                </button>
                            </td>
                            <td>
                        <form action="sanpham.php" method="POST">
                            <input type="hidden" name="Del_product_id" value="'.$row["Product_id"].'">
                            <button class="trash" type="submit" name="btn-3" value="delete">
                                <i class="fa-solid fa-trash"></i></i>
                            </button>
                        </form> 
                        </td>
                        </tr>';
            }
        }
        $conn->close();
        $stmt->close();
    }
    function ShowOrder($isHistory = false) {
        $conn = connect();
        $sql = 'SELECT Order_id, Customer_id, Order_date, Order_total, Order_note, Shipping_address, Payment_Status, Shipping_status, Order_status FROM orders';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = 1;
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $info = FindCustomerInfo($row["Customer_id"]);
    
                // Điều kiện để hiển thị trong lịch sử đơn hàng
                $isHistoryCondition = ($row["Order_status"] == "Đã xác nhận" && $row["Shipping_status"] == "Gửi hàng thành công" && $row["Payment_Status"] == "Đã thanh toán");
    
                // Điều kiện để hiển thị trong đơn hàng
                $isOrderCondition = !($isHistoryCondition);
    
                // Kiểm tra nếu là lịch sử đơn hàng
                if ($isHistory && $isHistoryCondition) {
                    echo '<tr>
                        <td>'.$count++.'</td>
                        <td>'.$info[0].'</td>
                        <td>'.$info[1].'</td>
                        <td>'.$info[2].'</td>
                        <td>'.$row["Shipping_address"].'</td>
                        <td>'.$row["Order_date"].'</td>
                        <td>'.$row["Shipping_status"].'</td>
                        <td>'.$row["Payment_Status"].'</td>
                        <td>'.$row["Order_status"].'</td>
                        <td>
                            <div class="price-wallpaper">
                                <p class="price">'.number_format($row["Order_total"], 0, ',', '.').'</p>
                                <p class="unit-price">VND</p>
                            </div>
                        </td>
                        <td>
                            <form action="chitietlichsudonhang.php" method="GET">
                                <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                                <button class="details" type="submit" name="btn" value="details">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </button>
                            </form>
                        </td>
                    </tr>';
                } 
                // Kiểm tra nếu là đơn hàng
                elseif (!$isHistory && $isOrderCondition) {
                    echo '<tr>
                        <td>'.$count++.'</td>
                        <td>'.$info[0].'</td>
                        <td>'.$info[1].'</td>
                        <td>'.$info[2].'</td>
                        <td>'.$row["Shipping_address"].'</td>
                        <td>'.$row["Order_date"].'</td>
                        <td>'.$row["Shipping_status"].'</td>
                        <td>'.$row["Payment_Status"].'</td>
                        <td>'.$row["Order_status"].'</td>
                        <td>'.$row["Order_note"].'</td>
                        <td>
                            <div class="price-wallpaper">
                                <p class="price">'.number_format($row["Order_total"], 0, ',', '.').'</p>
                                <p class="unit-price">VND</p>
                            </div>
                        </td>
                        <td>
                            <form action="chitietdonhang.php" method="GET">
                                <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                                <button class="details" type="submit" name="btn" value="details">
                                    <i class="fa-solid fa-file-invoice"></i>
                                </button>
                            </form>
                        </td>
                        <td class="setting">
                            <form action="suatrangthai.php" method="POST">
                                <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                                <button class="fix-product" type="submit" name="btn-2" value="fix">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </form>
                        </td>
                        <td>
                            <form action="DonHang.php" method="POST">
                                <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                                <button class="trash" type="submit" name="btn-3" value="delete">
                                    <i class="fa-solid fa-trash"></i></i>
                                </button>
                            </form> 
                        </td>
                    </tr>';
                }
            }
        }
    
        $stmt->close();
        $conn->close();
    }
    


    function ShowOrderDetailsHistory($orders_id){
        $conn= connect();
        $sql = 'SELECT History_id, Product_img,Product_name,Product_price,Quantity, UnitPrice FROM historyorder_details WHERE Order_id = ?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$orders_id);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
        while($row=$result->fetch_assoc()){
            echo '<tr>
                            <td>'.$row["History_id"].'</td>
                            <td>
                                <img class="img-table" src="'.$row["Product_img"].'" alt="" />
                            </td>
                            <td>
                                '.$row["Product_name"].'
                            </td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">'.number_format($row["Product_price"],0,',','.').'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>'.$row["Quantity"].'</td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">'.number_format($row["UnitPrice"],0,',','.').'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                        </tr>';
            }
        }
        $conn->close();
        $stmt->close();
    }
    function ShowOrderDetails($orders_id){
        $conn= connect();
        $sql = 'SELECT OrderDetails_id, Product_id,Quantity, UnitPrice FROM orderdetails WHERE Order_id = ?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$orders_id);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
        while($row=$result->fetch_assoc()){
            $info = FindProductInfo($row['Product_id']);
            echo '<tr>
                            <td>'.$row["OrderDetails_id"].'</td>
                            <td>
                                <img class="img-table" src="'.$info[0].'" alt="" />
                            </td>
                            <td>
                                '.$info[1].'
                            </td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">'.number_format($info[2],0,',','.').'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>'.$row["Quantity"].'</td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">'.number_format($row["UnitPrice"],0,',','.').'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td class="setting">
                                 <form action="chinhsuachitietdonhang.php" method="POST">
                                <input type="hidden" name="OrderDetailsEdit_id" value="'.$row["OrderDetails_id"].'">
                                <button class="fix-product" type="submit" name="btn-2" value="fix">
                                <i class="fa-solid fa-pen"></i>
                                </button>
                            </form>
                              </td>
                            <td>
                            <form action="chitietdonhang.php" method="GET">
                                    <input type="hidden" name="OrderDetails_id" value="'.$row["OrderDetails_id"].'">
                                    <button class="trash" type="submit" name="btn-4" value="deleteProduct">
                                        <i class="fa-solid fa-trash"></i></i>
                                    </button>
                                </form> 
                            </td>
                        </tr>';
            }
        }
        $conn->close();
        $stmt->close();
    }



    function showProduct_edit($id){
        
        $conn= connect();
        $sql = 'SELECT Product_img, Product_name, Product_price, Brand_id, Category_id, Quantity FROM product WHERE product_id = ?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        // $brand = showBrand();
        // $category = showCategory();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();

            echo'<div class="form-row">
                    <!-- Cột bên trái cho các trường nhập liệu -->
                    <div class="form-group-wrapper">
                        <div class="form-group">
                            <label for="product-name">Tên sản phẩm</label>
                            <input type="hidden" name="product_id" value ="'.$id.'"/>
                            <input type="text" id="product-name" name="product-name" value ="'.$row["Product_name"].'" required />
                        </div>
                        <div class="form-group">
                            <label for="brand">Nhãn hiệu</label>
                            <select id="brand" name="brand"  ">
                            <option value="">Chọn nhãn hiệu</option>';
                                showBrand($row["Brand_id"]) ;
                          echo  '</select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Số lượng còn trong kho</label>
                            <input type="number" id="quantity" name="quantity" value="'.$row["Quantity"].'" min="0" required />
                        </div>
                        <div class="form-group">
                            <label for="price">Giá bán</label>
                            <input type="text" id="price" name="price" value= "'.number_format($row["Product_price"],0,',','.').'" required />
                        </div>
                        <div class="form-group">
                            <label for="category">Thuộc loại</label>
                            <select id="category" name="category" required>
                                <option value="">Chọn loại</option>';
                                
                                showCategory($row["Category_id"]);
                              
                           echo '</select>
                        </div>
                        <div class="form-group">
                            <label for="picture">Thêm hình ảnh</label>
                            <input type="file" accept="image/*" id="file" name="image" required>
                        </div>
                    </div>

                    <!-- Cột bên phải cho phần "Chỉnh sửa ảnh" -->
                    <div class="form-group image-upload">
                        <label for="product-image">Thêm ảnh</label>
                        <div class="image-placeholder">
                            <img class="image-placeholder" id ="upload-Img" src="">
                        </div>
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit" class="submit-button" name="btn-5" id="submit-button"
                        value="Edit_product">Chỉnh sửa sản phẩm</button>
                </div>';
        }
        $conn->close();
        $stmt->close();
    }


    function ShowOrderDetails_edit($id){
        $conn= connect();
        $sql = 'SELECT Product_id, Quantity, UnitPrice FROM orderdetails WHERE OrderDetails_id = ?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $info = FindProductInfo($row['Product_id']);
            echo'<div class="form-row">
            <!-- Cột bên trái cho các trường nhập liệu -->
            <div class="form-group-wrapper">
                <div class="form-group">
                    <label for="product-name">Tên sản phẩm</label>
                    <input type="hidden" name="OrderDetails_id" value ="'.$id.'"/>
                    <input type="text" id="product-name" name="product-name" value ="'.$info['1'].'" readonly />
                </div>
                <div class="form-group">
                    <label for="brand">Nhãn hiệu</label>
                    <select id="brand" name="brand" disabled ">
                    <option value="">Chọn nhãn hiệu</option>';
                        showBrand($info[3]) ;
                  echo  '</select>
                </div>
                <div class="form-group">
                    <label for="price">Giá bán</label>
                    <input type="text" id="price" name="price" value= "'.number_format($info['2'],0,',','.').'"  readonly />
                </div>
                <div class="form-group">
                    <label for="quantity">Số lượng sản phẩm mua</label>
                    <input type="number" id="quantity" name="quantity" value="'.$row["Quantity"].'" min="1" oninput="ChangeTotal()" required />
                </div>
                 <div class="form-group">
                    <label for="price">Tổng tiền</label>
                    <input type="text" id="total" name="total" value= "'.number_format($info['2']*$row["Quantity"],0,',','.').'" readonly />
                </div>
                <div class="form-group">
                    <label for="category">Thuộc loại</label>
                    <select id="category" name="category" disabled>
                        <option value="">Chọn loại</option>';
                        
                        showCategory($info[4]);
                      
                   echo '</select>
                </div>
            </div>

            <!-- Cột bên phải cho phần "Chỉnh sửa ảnh" -->
            <div class="form-group image-upload">
                <label for="product-image">Ảnh sản phẩm</label>
           
                    <img class="image-placeholder"src = "'.$info[0].'" width = 100%>
               
            </div>
        </div>
        <div class="button-container">
            <button type="submit" class="submit-button" name="btn-5" id="submit-button"
                value="Edit_OrderDetails">Chỉnh sửa sản phẩm</button>
        </div>';
        }
    }
    

    function showOrderStatus_edit($id){
        $conn = connect();
        $sql = 'SELECT Customer_id, Order_date, Order_total, Order_note, Shipping_address,Payment_Status, Shipping_status, Order_status FROM orders WHERE Order_id = ?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$id);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
            $row=$result->fetch_assoc();
            $info=FindCustomerInfo($row["Customer_id"]);
            $CheckOrder_status = ($row["Order_status"] == "Chưa xác nhận") ? 'disabled' : '' ;
            $CheckPayment_status = ($row["Shipping_status"] != "Gửi hàng thành công") ? 'disabled' : '';
            echo '  <div class="form-row">
            <div class="form-group">
              <label for="customer-name">Tên khách hàng</label>
              <input type="text" id="customer-name" name="customer-name" value ="'.$info[0].'" readonly/>
            </div>
            <div class="form-group">
              <label for="shipping-status">Trạng thái giao hàng</label>
              <select id="shipping-status" name="shipping-status" '.$CheckOrder_status.'>
                <option value="Chưa được gửi" '.($row["Shipping_status"] == "Chưa được gửi" ? 'selected' : '' ).'>Chưa được gửi</option>
                <option value="Đang gửi hàng" '.($row["Shipping_status"] == "Đang gửi hàng" ? 'selected' : '' ).'>Đang gửi hàng</option>
                <option value="Gửi hàng thành công" '.($row["Shipping_status"] == "Gửi hàng thành công" ? 'selected' : '' ).'>Gửi hàng thành công</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="phone">Số điện thoại</label>
              <input type="text" id="phone" name="phone" value="'.$info[1].'" readonly />
            </div>
            <div class="form-group">
              <label for="payment-status">Trạng thái thanh toán</label>
              <select id="payment-status" name="payment-status" '.$CheckPayment_status.'>
                <option value="Chưa thanh toán" '.($row["Payment_Status"] == "Chưa thanh toán" ? 'selected' : '' ).'>Chưa thanh toán</option>
                <option value="Đã thanh toán" '.($row["Payment_Status"] == "Đa thanh toán" ? 'selected' : '' ).'>Đã thanh toán</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" id="email" name="email" value="'.$info[2].'" readonly/>
            </div>
            <div class="form-group">
              <label for="order-status">Trạng thái đơn hàng</label>
              <select id="order-status" name="order-status">
                <option value="Chưa xác nhận" '.($row["Order_status"] == "Chưa xác nhận" ? 'selected' : '' ).'>Chưa xác nhận</option>
                <option value="Đã xác nhận" '.($row["Order_status"] == "Đã xác nhận" ? 'selected' : '' ).'>Đã xác nhận</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="address">Địa chỉ</label>
              <input type="text" id="address" name="address" value = "'.$row["Shipping_address"].'" />
            </div>
            <div class="form-group">
              <label for="note">Ghi chú</label>
              <input type="text" id="note" name="note" value="'.$row["Order_note"].'" />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label for="order-date">Ngày đặt</label>
              <input type="text" id="order-date" name="order-date" value= "'.$row["Order_date"].'" readonly/>
            </div>
            <div class="form-group">
              <label for="total-value">Tổng giá trị đơn hàng</label>
              <input type="text" id="total-value" name="total-value" value="'.number_format($row["Order_total"],0,',','.').'" readonly />
            </div>
          </div>
          <div class="button-container">
          <input type="hidden" name = "shipping_edit" id ="shipping_edit" value ="'.$row["Payment_Status"].'">
            <input type="hidden" name = "payment_edit" value ="'.$row["Payment_Status"].'">
          <input type="hidden" value="'.$id.'" name="Order_id"/>
            <button type="submit" class="submit-button" name="btn-7" value="Edit_order">
              Xác nhận chỉnh sửa
            </button>
          </div>';
        }
    }



    //check, count Function zone



    function CountOrderDetails($orders_id){
        $conn= connect();
        $sql = 'SELECT COUNT(Order_id) AS total FROM orderdetails WHERE order_id =?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$orders_id);
        $stmt->execute();
        $stmt->bind_result($count); //gán biến count vào biến mà sql đang truy vấn là order_id
        $stmt->fetch();//gán giá trị của total vào biến count
        $conn->close();
        $stmt->close();
        return $count;
    }   

    function CountProductID_InOrderDetails($product_id){
        $conn= connect();
        $sql = 'SELECT COUNT(Product_id) AS total FROM orderdetails WHERE Product_id =?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$product_id);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $conn->close();
        $stmt->close();
        return $count;
    }

    function GetOrderDetailsID($id){
        $conn = connect();
        $sql = 'SELECT OrderDetails_id FROM orderdetails WHERE Order_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $orderDetailsIds = array(); 
        
        while ($row = $result->fetch_assoc()) {
            $orderDetailsIds[] = $row['OrderDetails_id']; 
        }
        
        $stmt->close();
        $conn->close();
        
        return $orderDetailsIds;
    }

    


    //Delete function zone
    function DeleteProduct($id){
        $conn = connect();
        //echo CountProductID_InOrderDetails($id);
        if(CountProductID_InOrderDetails($id) > 0){
            echo '<script>alert("Sản phẩm đang có đơn hàng! Không thể xoá");</script>';
            $conn->close();
            return;
        }else{
            $sql = 'DELETE FROM product WHERE product_id =?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('i', $id);
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        
    }
    function DeleteOrder( $orders_id ){
        $conn= connect();
        $sql = 'DELETE FROM Orders WHERE Order_id = ? ';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$orders_id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
         
        }
        $conn->close();
        $stmt->close();
    }
    function DeleteOrderDetails($orders_id){
        $conn= connect();
        $info = FindOrderInfo($orders_id);
        if($info[4] == "Đang gửi hàng" || $info[4] == "Gửi hàng thành công" ){
            echo '<script>alert("Đơn hàng đang ở trạng thái '.$info[4].' không thể huỷ đơn !!! ");</script>';
            $conn->close();
           return;
        }else{
            $sql = 'DELETE FROM orderdetails WHERE Order_id = ? ';
            $stmt= $conn->prepare($sql);
            $stmt->bind_param('i',$orders_id);
            $stmt->execute();
            if($stmt->affected_rows > 0){
                DeleteOrder($orders_id);
    
            }
        }

        $conn->close();
       // $stmt->close();
    }

    
    function UpdateTotalOrdersTotal($orderDetails_id){
        $conn= connect();
        $orderDetailsInfo=FindOrderDetailsInfo($orderDetails_id);
        if($orderDetailsInfo==null){
            $conn->close();
            return;
        }
        $orderInfo=FindOrderInfo($orderDetailsInfo[0]);
        if($orderInfo==null){
            $conn->close();
            return;
        }

        
        $newTotal = $orderInfo[1] - $orderDetailsInfo[3];
        $sql = 'UPDATE orders SET Order_total = ? WHERE Order_id = ?';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('di',$newTotal,$orderInfo[0]);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){}
        $conn->close();
        $stmt->close();
    }

    function DeleteProductInOrders($orderDetails_id){
        $conn= connect(); 
        $orderDetailsInfo=FindOrderDetailsInfo($orderDetails_id);
        $info=FindOrderInfo( $orderDetailsInfo[0] );
        if($info[4] == "Đang vận chuyển" || $info[4] == "Gửi hàng thành công"){
           //echo 'Đơn hàng đang ở trạng thái '.$info[4].' không thể huỷ đơn !!! ';
          // echo '<script>window.location.href="chitietdonhang.php?Order_id=' . $info[0]. '&btn=details";</script>';
            $conn->close();
            return;
        }else{
            if(CountOrderDetails($orderDetailsInfo[0]) == 1){
                $check = CountOrderDetails($orderDetails_id);
               echo'<script>window.location.href="DonHang.php";</script>';
               DeleteOrderDetails($orderDetailsInfo[0]);
            }else{
                $sql = 'DELETE FROM orderdetails WHERE OrderDetails_id = ?';
                UpdateTotalOrdersTotal($orderDetails_id);
                $stmt= $conn->prepare($sql);
                $stmt->bind_param('i',$orderDetails_id);
                $stmt->execute();
                if($stmt->affected_rows > 0){
                }
                echo '<script>window.location.href="chitietdonhang.php?Order_id=' . $info[0] . '&btn=details";</script>';
            }
            $conn->close();
            $stmt->close();
        }
       
        
    }


    function updateOrder( $order_id, $Order_status,$Payment_status, $Shipping_status, $note,$address){
        $conn = connect();
        $sql ='UPDATE orders SET Order_Status =?, Payment_Status = ?, Shipping_status = ?, Order_note = ?, Shipping_address = ? WHERE Order_id = ? ';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('sssssi',$Order_status,$Payment_status,$Shipping_status,$note,$address,$order_id);
        $stmt->execute();
        if($stmt->affected_rows>0){}
        $conn->close();
        $stmt->close();
    }

    // chuyển đổi vị trí từ order_Details sang HistoryOrder_details
    function changeLocation($order_id){
        $conn = connect();
        $info = GetOrderDetailsID($order_id);
        for($i = 0; $i < count($info);$i++){
            $orderDetails_info = FindOrderDetailsInfo($info[$i]);
            $product_info = FindProductInfo($orderDetails_info[1]);
            $product_img = mysqli_real_escape_string($conn, $product_info[0]);
            $sql = 'INSERT INTO historyorder_details (Order_id, Product_img, Product_name, Product_price, Quantity, UnitPrice)
                VALUES ('.$order_id.', \''.$product_img.'\', \''.$product_info[1].'\', \''.$product_info[2].'\', '.$orderDetails_info[2].', '.$orderDetails_info[3].')';
            $conn->query($sql);
        }
        $sql_2 = 'DELETE FROM orderdetails WHERE Order_id = ? ';
        $stmt= $conn->prepare($sql_2);
        $stmt->bind_param('i',$order_id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
        }
        $conn->close();
        $stmt->close();   
    }



    function UpdateProduct($product_img,$product_name,$product_price,$Brand_id,$product_category,$product_quantity,$product_id){
        $conn= connect();
        $number = FormatNumber($product_price);
        $name = strtoupper($product_name);
        if($product_img == null){
            $sql = 'UPDATE product SET Product_name = ?, Product_price = ?, Brand_id = ?, Category_id = ? , Quantity = ? WHERE Product_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('sissss',$name,$number,$Brand_id, $product_category,$product_quantity,$product_id);
            $stmt->execute();
            if($stmt->affected_rows > 0){}
            
        }else{
            $sql = 'UPDATE product SET Product_img = ?,Product_name = ?, Product_price = ?, Brand_id = ?, Category_id = ? , Quantity = ? WHERE Product_id = ?';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssissss',$product_img,$name,$number,$Brand_id, $product_category,$product_quantity,$product_id);
            $stmt->execute();
            if($stmt->affected_rows > 0){}
        }
        
        $conn->close();
        $stmt->close();
    }



    function UpdateOrderDetails($id,$quantity, $total,$Order_id){
        $conn= connect();
        $number_quantity = FormatNumber($quantity);
        $number_total = FormatNumber($total);
        $sql = 'UPDATE orderdetails SET Quantity = ?, UnitPrice = ? WHERE OrderDetails_id = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iii',$number_quantity,$number_total,$id);
        $stmt->execute();
        if($stmt->affected_rows > 0){}
        $info = GetOrderDetailsID($Order_id);
        $total=0;
        for($i= 0;$i<count($info);$i++){
            $info_2 = FindOrderDetailsInfo($info[$i]);
            $total += $info_2[3];
        }
        $sql_2 = 'UPDATE orders SET Order_total = ? WHERE Order_id = ?';
        $stmt_2 = $conn->prepare($sql_2);
        $stmt_2->bind_param('ii',$total, $Order_id);
        $stmt_2->execute();
        if($stmt_2->affected_rows > 0){}
        $conn->close();
        $stmt->close();
        $stmt_2->close();
    }
    // search Function zone


    function searchProduct(){
        $conn= connect(); 
        if (isset($_GET['query'])) {
            $text = $conn->real_escape_string($_GET['query']);
        } else {
            $text = '';
        } 
        $sql = "SELECT * FROM product WHERE Product_name LIKE ? OR Category_id LIKE ? OR Brand_id LIKE ?";
        $stmt = $conn->prepare($sql);
        $search = "%$text%";
        //$search = "%$text%";: Thêm ký tự % trước và sau từ khóa tìm kiếm để tìm các chuỗi chứa từ khóa này ở bất kỳ vị trí nào.
        $stmt->bind_param("sss",  $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo ' <tr>
                            <td>'.$row["Product_id"].'</td>
                            <td>
                                <img class="img-table" src="'.$row["Product_img"].'" alt="" />
                            </td>
                            <td>
                                '.$row["Product_name"].'
                            </td>
                            <td>
                                <div class="price-wallpaper">
                                    <p class="price">'.number_format($row["Product_price"],0,',','.').'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>'.$row["Quantity"].'</td>
                            <td>
                                <button class="fix-product">
                                    <a href=""><i class="fa-solid fa-pen"></i></a>
                                    </i>
                                </button>
                            </td>
                        </tr>';
            }
        }
        $conn->close();
        $stmt->close();
        
    }

    
    function SearchOrder(){
        $conn= connect(); 
        if (isset($_GET['searchOrder'])) {
            $text = $conn->real_escape_string($_GET['searchOrder']);
            $type = $_GET["typeSearch"];
        } else {
            $text = '';
            $type = $_GET["typeSearch"];
        } 
       // $sql = 'SELECT * FROM orders WHERE Order_date LIKE ? OR Shipping_address LIKE ? OR Payment_Status LIKE ? OR Shipping_status LIKE ? OR Order_status LIKE ? ';
       $sql = 'SELECT orders.*, customer.*
               FROM orders
               JOIN customer ON orders.Customer_id = customer.Customer_id
               WHERE 
                    Order_date LIKE ? OR 
                    Shipping_address LIKE ? OR 
                    Payment_Status LIKE ? OR 
                    Shipping_status LIKE ? OR 
                    Order_status LIKE ? OR
                    Customer_name LIKE ? OR 
                    Customer_phone LIKE ? OR 
                    Customer_email LIKE ? OR
                    Customer_sex LIKE ? ' ;
        $stmt = $conn->prepare($sql);
        $search = "%$text%";
        //$search = "%$text%";: Thêm ký tự % trước và sau từ khóa tìm kiếm để tìm các chuỗi chứa từ khóa này ở bất kỳ vị trí nào.
        $stmt->bind_param("sssssssss",  $search,  $search, $search, $search, $search, $search, $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $count=1;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $History_order = ($row["Order_status"] == "Đã xác nhận" && $row["Shipping_status"] == "Gửi hàng thành công" && $row["Payment_Status"] == "Đã thanh toán" );
                $order = !($History_order);

                if($type == "donHang" && $order){

                    echo '  <tr>
                    <td>'.$count++.'</td>
                    <td>'.$row["Customer_name"].'</td>
                    <td>'.$row["Customer_phone"].'</td>
                    <td>'.$row["Customer_email"].'</td>
                    <td>'.$row["Customer_address"].'</td>
                    <td>'.$row["Order_date"].'</td>
                    <td>'.$row["Shipping_status"].'</td>
                    <td>'.$row["Payment_Status"].'</td>
                    <td>'.$row["Order_status"].'</td>
                    <td>
                        <div class="price-wallpaper">
                            <p class="price">'.number_format($row["Order_total"],0,',','.').'</p>
                            <p class="unit-price">VND</p>
                        </div>
                    </td>
                    <td>
                        <form action="chitietdonhang.php" method="GET">
                            <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                            <button class="details" type="submit" name="btn" value="details">
                                <i class="fa-solid fa-file-invoice"></i>
                            </button>
                        </form>
                    </td>
                    <td class="setting">
                        <form action="" method="POST">
                            <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                            <button class="fix-product" type="submit" name="btn-2" value="fix">
                                <i class="fa-solid fa-pen"></i>
                            </button>
                        </form>
                    </td>
                    <td>
                     <form action="DonHang.php" method="POST">
                            <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                            <button class="trash" type="submit" name="btn-3" value="delete">
                                <i class="fa-solid fa-trash"></i></i>
                            </button>
                        </form> 
                        </td>
                </tr>';

                }elseif($type == "lichSu"&& $History_order){
                    echo '  <tr>
                    <td>'.$count++.'</td>
                    <td>'.$row["Customer_name"].'</td>
                    <td>'.$row["Customer_phone"].'</td>
                    <td>'.$row["Customer_email"].'</td>
                    <td>'.$row["Customer_address"].'</td>
                    <td>'.$row["Order_date"].'</td>
                    <td>'.$row["Shipping_status"].'</td>
                    <td>'.$row["Payment_Status"].'</td>
                    <td>'.$row["Order_status"].'</td>
                    <td>
                        <div class="price-wallpaper">
                            <p class="price">'.number_format($row["Order_total"],0,',','.').'</p>
                            <p class="unit-price">VND</p>
                        </div>
                    </td>
                    <td>
                        <form action="chitietlichsudonhang.php" method="GET">
                            <input type="hidden" name="Order_id" value="'.$row["Order_id"].'">
                            <button class="details" type="submit" name="btn" value="details">
                                <i class="fa-solid fa-file-invoice"></i>
                            </button>
                        </form>
                    </td>
                </tr>';
                }
               
            }
        }
        $conn->close();
        $stmt->close();
        
    }

    //Add Product
    function showBrand($selectedBrand = null) {
        $conn = connect();
        $sql = 'SELECT Brand_id FROM brand';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($row["Brand_id"] == $selectedBrand) {
                    $selected = ' selected';
                } else {
                    $selected = '';
                }
                
                echo '<option value="' . $row["Brand_id"] . '"' . $selected . '>' . $row["Brand_id"] . '</option>';
            }
        } else {
            echo '<option value="">Không có nhãn hiệu nào</option>';
        }
        
        $stmt->close();
        $conn->close();
    }
    

    function showCategory($selectedCategory = null){
        $conn = connect();
        $sql = 'SELECT Category_id FROM category';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if ($row['Category_id'] == $selectedCategory) {
                    $selected = ' selected';
                } else {
                    $selected = '';
                }
                echo '<option value="'.$row["Category_id"].'" ' . $selected . '>'.$row["Category_id"].'</option>';
            }
            
        } else {
            echo '<option value="">Không có nhãn hiệu nào</option>';
        }
        
        $conn->close();
        $stmt->close();
    }


?>