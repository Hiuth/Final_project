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
    }
?>