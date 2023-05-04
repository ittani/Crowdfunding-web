<?php      
    include('connection.php');  
    $email = "";
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
      } else {
        // Handle the case when the email key is not present in $_POST
      }
      
      if (isset($_POST['password'])) {
        $password = $_POST['password'];
      } else {
        // Handle the case when the password key is not present in $_POST
      }
        //to prevent from mysqli injection  
        $email = stripcslashes($email);  
        $password = stripcslashes($password);  
        $email= mysqli_real_escape_string($con, $email);  
        $password = mysqli_real_escape_string($con, $password);  
      
        $sql = "select *from ittani where email = '$email' and password = '$password'";  
        $result = mysqli_query($con, $sql);  
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
        $count = mysqli_num_rows($result);  
          
        if($count == 1){  
          header("Location: successful.html");
          exit();
           
        }  
        else{  
            echo "<h1> Login failed. Invalid username or password.</h1>";  
        }     
?>  