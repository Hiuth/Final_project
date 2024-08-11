<?php 
function connect(){
    $host="localhost";
    $username="root";
    $password= "";
    $dbname= "2004database";
    $port=3308;
     $conn = new mysqli($host,$username,$password,$dbname, $port);
    // $conn = new mysqli('localhost','root','','2004database');
    if ($conn->connect_error) {
        die("Kết nối không thành công". $conn->connect_error);
    }
    return $conn;
}

?>