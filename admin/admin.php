<?php
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
        $sql_customer = 'SELECT Product_img,Product_name,Product_price FROM product WHERE Product_id = ?';
        $stmt_customer = $conn->prepare($sql_customer);
        $stmt_customer->bind_param("i",$id);
        $stmt_customer->execute();
        $result_customer=$stmt_customer->get_result();
        if($result_customer->num_rows > 0){
            $row=$result_customer->fetch_assoc();
            $Product_img = $row['Product_img'];
            $Product_name = $row['Product_name'];
            $Product_price = $row['Product_price'];
            $Product_info=[ $Product_img, $Product_name, $Product_price];
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
                             <form action="" method="POST">
                                <input type="hidden" name="Order_id" value="'.$row["Product_id"].'">
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
                        </tr>';
            }
        }
        $conn->close();
        $stmt->close();
    }
    function ShowOder(){
        $conn= connect();
        $sql = 'SELECT Order_id,Customer_id, Order_date, Order_total, Shipping_address, Payment_Status, Shipping_status, Order_status FROM orders';
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $count=1;
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){

                $info = FindCustomerInfo($row["Customer_id"]);
                if($row["Order_status"] !="Đã xác nhận" && $row["Shipping_status"] !="Gửi hàng thành công" && $row["Payment_Status"] != "Đã thanh toán"){
                    echo' <tr>
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
                }
                
            }
        }
        $conn->close();
        $stmt->close();
    }


    function ShowOrderDetailsHistory($orders_id){
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


    function ShowOderHistory(){
        $conn= connect();
        $sql = 'SELECT Order_id,Customer_id, Order_date, Order_total, Shipping_address, Payment_Status, Shipping_status, Order_status FROM orders';
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        $count=1;
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){

                $info = FindCustomerInfo($row["Customer_id"]);
                if($row["Order_status"] =="Đã xác nhận" && $row["Shipping_status"] =="Gửi hàng thành công" && $row["Payment_Status"] == "Đã thanh toán"){
                    echo' <tr>
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




    //Delete function zone
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
        $sql = 'DELETE FROM orderdetails WHERE Order_id = ? ';
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$orders_id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
            DeleteOrder($orders_id);

        }
        $conn->close();
        $stmt->close();
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
        }

       

        $conn->close();
        $stmt->close();
        
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
        } else {
            $text = '';
        } 
        $sql = 'SELECT * FROM orders WHERE Order_date LIKE ? OR Shipping_address LIKE ? OR Payment_Status LIKE ? OR Shipping_status LIKE ? OR Order_status LIKE ? ';
        $stmt = $conn->prepare($sql);
        $search = "%$text%";
        //$search = "%$text%";: Thêm ký tự % trước và sau từ khóa tìm kiếm để tìm các chuỗi chứa từ khóa này ở bất kỳ vị trí nào.
        $stmt->bind_param("sssss",  $search,  $search, $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $count=1;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                $info = FindCustomerInfo($row["Customer_id"]);
                echo '  <tr>
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
            }
        }
        $conn->close();
        $stmt->close();
        
    }

    function SearchOrderCustomer(){
        $conn= connect(); 
        if (isset($_GET['searchOrder'])) {
            $text = $conn->real_escape_string($_GET['searchOrder']);
        } else {
            $text = '';
        } 
        $sql = 'SELECT * FROM customer WHERE Customer_name LIKE ?  OR Customer_phone LIKE ? OR Customer_email LIKE ? ';
        $stmt = $conn->prepare($sql);
        $search = "%$text%";
        //$search = "%$text%";: Thêm ký tự % trước và sau từ khóa tìm kiếm để tìm các chuỗi chứa từ khóa này ở bất kỳ vị trí nào.
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();
        $count=1;
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if(FindOrderInfoWithCustomer($row["Customer_id"]) != null){
                    $info = FindOrderInfoWithCustomer($row["Customer_id"]);
                    echo '<tr>
                                <td>'.$count++.'</td>
                                <td>'.$row["Customer_name"].'</td>
                                <td>'.$row["Customer_phone"].'</td>
                                <td>'.$row["Customer_email"].'</td>
                                <td>'.$row["Customer_address"].'</td>
                                <td>'.$info[5].'</td>
                                <td>'.$info[4].'</td>
                                <td>'.$info[3].'</td>
                                <td>'.$info[2].'</td>
                                <td>
                                    <div class="price-wallpaper">
                                        <p class="price">'.number_format($info[1],0,',','.').'</p>
                                        <p class="unit-price">VND</p>
                                    </div>
                                </td>
                                <td>
                                    <form action="chitietdonhang.php" method="GET">
                                        <input type="hidden" name="Order_id" value="'.$info[0].'">
                                        <button class="details" type="submit" name="btn" value="details">
                                            <i class="fa-solid fa-file-invoice"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="setting">
                                    <form action="" method="POST">
                                        <input type="hidden" name="Order_id" value="'.$info[0].'">
                                        <button class="fix-product" type="submit" name="btn-2" value="fix">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </form>
                                </td>
                                <td>
                                 <form action="DonHang.php" method="POST">
                                        <input type="hidden" name="Order_id" value="'.$info[0].'">
                                        <button class="trash" type="submit" name="btn-3" value="delete">
                                            <i class="fa-solid fa-trash"></i></i>
                                        </button>
                                    </form> 
                                    </td>
                            </tr>';
                }
               
            }
        }
    }

?>