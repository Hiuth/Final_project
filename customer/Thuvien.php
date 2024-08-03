<?php
     function Create_Customer_Info($username, $gender, $phone_number, $address, $email){
        $conn= connect();
        $stmt = $conn->prepare("SELECT Customer_id FROM Customer WHERE Customer_phone = ? OR Customer_email = ? OR Customer_name=? OR Customer_sex=? OR Customer_address = ?");
        $stmt->bind_param("issss", $phone_number, $email,$username,$gender,$address);//i là kiểu số nguyên,s là kiểu string
        $stmt->execute();
        $result = $stmt->get_result();  
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customer_id = $row['Customer_id'];
            $conn =null;
            return $customer_id;
        } else {
            //echo "Khách hàng không tồn tại trong cơ sở dữ liệu.";
            $sql = "INSERT INTO Customer (Customer_name, Customer_sex, Customer_phone, Customer_address, Customer_email)
            VALUES ('$username', '$gender', '$phone_number', '$address', '$email')";
            $conn->query($sql);
            $last_id = $conn->insert_id;
            $conn =null;
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
        if(sizeof($_SESSION['productList'])>0){
            for($i=0;$i<sizeof($_SESSION['productList']);$i++)
            {
                // $formatNumber = $_SESSION['productList'][$i][3];
                // $cleanNumber= str_replace('.','', $formatNumber);
                // $Number= (int)$cleanNumber;
                $Number = FormatNumber($_SESSION['productList'][$i][3]);
                $total = $_SESSION['productList'][$i][2]*$Number;
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
            $conn =null;
            return $last_id;
    }

    function Create_orders_details($orders_id){
        $conn= connect();
        for($i= 0;$i<sizeof($_SESSION['productList']);$i++){
            $stmt = $conn->prepare("SELECT Product_id FROM product WHERE Product_name = ? ");
            $product_name= $_SESSION['productList'][$i][1];
            $product_quantity=$_SESSION['productList'][$i][2];
            $product_price= $_SESSION['productList'][$i][3];

            $Number = FormatNumber($_SESSION['productList'][$i][3]);

            $unit_price= $_SESSION['productList'][$i][2]*$Number;
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
        $conn =null;
    }
?>