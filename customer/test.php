<?php
require_once 'connect.php';
session_start();
if (isset($_POST['data'])) {
    // Xử lý dữ liệu sản phẩm
    $receivedData = json_decode($_POST['data'], true);
    $_SESSION['productList'] = $receivedData;
} 
    echo "<pre>";
    print_r($_SESSION);
    echo "</pre>";
    $product_name= $_SESSION['productList'][0][1];
    $product_price= $_SESSION['productList'][0][3];
    $product_quantity=$_SESSION['productList'][0][2];





if (isset($_POST['btn-submit'])&&$_POST['btn-submit']) {
    $username=$_POST['name'];
    $gender=$_POST['gender'];
    $email=$_POST['email'];
    $phone_number= $_POST['phone'];
    $address=$_POST['address'];
    $note=$_POST['note'];
    
echo "tên: {$username}";
echo "tên: {$gender}";
echo "tên: { $email}";
echo "tên: {$phone_number}";
echo "tên: {$note}";

    if(!empty($username) && !empty($gender) && !empty($email) && !empty($phone_number) && !empty($address)) {
        // $sql="INSERT INTO `Customer` (`Customer_name`,`Customer_sex`,`Customer_phone`,`Customer_address`,`Customer_email`)
        // VALUES('$username','$gender',$phone_number',''$address','$email')";
        // $sql = "INSERT INTO Customer (Customer_name, Customer_sex, Customer_phone, Customer_address, Customer_email)
        //         VALUES ('$username', '$gender', '$phone_number', '$address', '$email')";
        //         $conn->query($sql);
        $conn=connect();
        $stmt = $conn->prepare("SELECT Customer_id FROM Customer WHERE Customer_name=? AND Customer_phone = ?  AND Customer_sex=? AND Customer_address = ? AND Customer_email = ?");
        $stmt->bind_param("sisss", $username, $phone_number,$gender,$address,$email);
        $stmt->execute();
        $result = $stmt->get_result();  
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $customer_id = $row['Customer_id'];
            echo "Khách hàng đã tồn tại với ID: " . $customer_id;
        } else {
            echo "Khách hàng không tồn tại trong cơ sở dữ liệu.";
            $sql = "INSERT INTO Customer (Customer_name, Customer_sex, Customer_phone, Customer_address, Customer_email)
            VALUES ('$username', '$gender', '$phone_number', '$address', '$email')";
            $conn->query($sql);
            $last_id = $conn->insert_id;
            $conn =null;
        }

        // $stmt = $conn->prepare("SELECT Product_id FROM product WHERE Product_name = ? ");
        // $stmt->bind_param("s", $product_name);
        // $stmt->execute();
        // $result = $stmt->get_result();  
        // if ($result->num_rows > 0) {
        //     $row = $result->fetch_assoc();
        //     $customer_id = $row['Product_id'];
        //     echo "sản phẩm đã tồn tại với ID: " . $customer_id;
        // } else {
        //     echo "Khách hàng không tồn tại trong cơ sở dữ liệu.";
        // }
 }else{
    
 }
}


?>