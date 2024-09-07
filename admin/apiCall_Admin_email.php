<?php
     function GetEmailAccount(){
            $conn = connect();
            $sql = 'SELECT Admin_email FROM admin_account';
            $stmt = $conn->prepare($sql);                   
            $stmt->execute();                              
            $result = $stmt->get_result();
            
            $email = array(); 
            
            while ($row = $result->fetch_assoc()) {
                $email[] = $row['Admin_email']; 
            }
            echo json_encode($email);
            $stmt->close();
            $conn->close();
    }
    
    GetEmailAccount();
?>