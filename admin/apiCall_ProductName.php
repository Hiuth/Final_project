<?php
    // gửi dữ liệu từ php sang js
    require_once("connect-admin.php");    
    function GetNameProduct(){
        $conn = connect();
        $sql = 'SELECT Product_name FROM product ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $product_name = array(); 
        
        while ($row = $result->fetch_assoc()) {
            $product_name[] = $row['Product_name']; 
        }
        echo json_encode($product_name);
        $stmt->close();
        $conn->close();
        
    }
    GetNameProduct();


?>