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
    function ShowOder(){
        $conn= connect();
        $sql = 'SELECT Order_id,Customer_id, Order_date, Order_total, Shipping_address, Payment_Status, Shipping_status, Order_status FROM orders';
        $stmt= $conn->prepare($sql);
        $stmt->execute();
        $result=$stmt->get_result();
        if($result->num_rows > 0){
            while($row=$result->fetch_assoc()){
                $info = FindCustomerInfo($row["Customer_id"]);
                echo' <tr>
                            <td>'.$row["Order_id"].'</td>
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
                                    <p class="price">'.$row["Order_total"].'</p>
                                    <p class="unit-price">VND</p>
                                </div>
                            </td>
                            <td>
                                <button class="details">
                                    <a href="chitietsanpham.php" target="table">
                                        <i class="fa-solid fa-file-invoice"></i></a>
                                </button>
                            </td>
                            <td>
                                <button class="fix-product">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </td>
                        </tr>';
            }
        }
    }
?>