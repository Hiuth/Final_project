<?php 
    $host="localhost";
    $username="root";
    $password= "";
    $dbname= "2004'sstore_database";
    $conn = new mysqli($host,$username,$password,$dbname);
    if ($conn->connect_error) {
        die("Kết nối không thành công". $conn->connect_error);
    }
?>