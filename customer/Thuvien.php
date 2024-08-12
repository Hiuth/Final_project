<?php
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
            $conn->close();
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
        $conn->close();
        $stmt->close();
    }

    function ShowProduct($category_id=[]){
        $conn= connect();
        $sort='';
        if(isset($_GET['sort'])){
            $sort=$_GET['sort'];
        }
        $placeholders = implode(',', array_fill(0, count($category_id), '?'));
        $sql = "SELECT Product_img, Product_name, Product_price, Product_link FROM product";
        

        if (!empty($category_id)) {
            $sql .= " WHERE Category_id NOT IN ($placeholders)";
        }


        if($sort == "price-asc"){
            $sql .= " ORDER BY Product_price ASC";
        }elseif ($sort == "price-desc"){
            $sql .= " ORDER BY Product_price DESC";
        }

        // $sql = "SELECT Product_img, Product_name, Product_price FROM product WHERE Category_id = ? ORDER BY Product_price ASC ";
 
        
        $stmt = $conn->prepare($sql);

        if (!empty($category_id)) {
            // Xác định kiểu dữ liệu cho các tham số
            $types = str_repeat('s', count($category_id));
            // Gán các tham số vào câu lệnh SQL
            $stmt->bind_param($types, ...$category_id);
        }


        // $stmt->bind_param("s", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-img">
                <a href="'.$row["Product_link"].'"><img class="img-console" src="'.$row["Product_img"].'" alt="ps5_slim" /></a>
                <div class="product-name">
                    <div class="name-wallpaper">
                        <p class="name">
                            <a href="'.$row["Product_link"].'">'.$row["Product_name"].'
                            </a>
                        </p>
                    </div>
                    <div class="price-wallpaper">
                        <p class="price">'.number_format($row["Product_price"],0,',','.').'</p>
                        <p class="unit-price">VND</p>
                    </div>
                    <!-- <button class="add-cart-button">Thêm vào giỏ hàng</button> -->
                    <div class="add-cart-button">
                        <a href="#">THÊM VÀO GIỎ HÀNG</a>
                    </div>
                </div>
            </div>';
            }
        }
        $conn->close();
        $stmt->close();
        
    }


    function ShowRandomProduct($category_id,$limit){ 
        //limit là số lượng sản phẩm muốn lấy ngẫu nhiên
        $conn= connect();
        $sql = "SELECT Product_img, Product_name, Product_price, Product_link FROM product WHERE Category_id= ? ORDER BY RAND() LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $category_id, $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-img">
                <a href="'.$row["Product_link"].'"><img class="img-console" src="'.$row["Product_img"].'" alt="ps5_slim" /></a>
                <div class="product-name">
                    <div class="name-wallpaper">
                        <p class="name">
                            <a href="'.$row["Product_link"].'">'.$row["Product_name"].'
                            </a>
                        </p>
                    </div>
                    <div class="price-wallpaper">
                        <p class="price">'.number_format($row["Product_price"],0,',','.').'</p>
                        <p class="unit-price">VND</p>
                    </div>
                    <!-- <button class="add-cart-button">Thêm vào giỏ hàng</button> -->
                    <div class="add-cart-button">
                        <a href="#">THÊM VÀO GIỎ HÀNG</a>
                    </div>
                </div>
            </div>';
            }
        }
        $conn->close();
        $stmt->close();
        
    }

    function SearchProduct(){
       
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

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="product-img">
                <a href="'.$row["Product_link"].'"><img class="img-console" src="'.$row["Product_img"].'" alt="ps5_slim" /></a>
                <div class="product-name">
                    <div class="name-wallpaper">
                        <p class="name">
                            <a href="'.$row["Product_link"].'">'.$row["Product_name"].'
                            </a>
                        </p>
                    </div>
                    <div class="price-wallpaper">
                        <p class="price">'.number_format($row["Product_price"],0,',','.').'</p>
                        <p class="unit-price">VND</p>
                    </div>
                    <!-- <button class="add-cart-button">Thêm vào giỏ hàng</button> -->
                    <div class="add-cart-button">
                        <a href="#">THÊM VÀO GIỎ HÀNG</a>
                    </div>
                </div>
            </div>';
            }
        }else{
               echo"Không tìm thấy sản phẩm nào khớp với lựa chọn của bạn!!!";
        }
        $conn->close();
    }

?>