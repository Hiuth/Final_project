<?php
    
    function ShowProductAdmin(){
        $conn= connect();
        $sql = "SELECT Product_id,Product_img, Product_name, Product_price, Quantity FROM product";
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                echo '  <tr>
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
                                <form action="chitietsanpham.php" method="GET">
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
                            <form action="chitietsanpham.php" method="GET">
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
        $sql = 'DELETE FROM orderdetails WHERE OrderDetails_id = ?';
        UpdateTotalOrdersTotal($orderDetails_id);
        $stmt= $conn->prepare($sql);
        $stmt->bind_param('i',$orderDetails_id);
        $stmt->execute();
        if($stmt->affected_rows > 0){
        }
        $conn->close();
        $stmt->close();
        
    }

?>