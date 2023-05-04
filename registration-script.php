<?php

require_once('database.php'); 
// by default, error messages are empty
$register=$valid=$fnameErr=$lnameErr=$emailErr=$passErr=$cpassErr='';
 // by default,set input values are empty
 $set_firstName=$set_lastName=$set_email='';

extract($_POST);
if(isset($_POST['submit']))
{
  

   //input fields are Validated with regular expression
   $validName="/^[a-zA-Z ]*$/";
   $validEmail="/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
   $uppercasePassword = "/(?=.*?[A-Z])/";
   $lowercasePassword = "/(?=.*?[a-z])/";
   $digitPassword = "/(?=.*?[0-9])/";
   $spacesPassword = "/^$|\s+/";
   $symbolPassword = "/(?=.*?[#?!@$%^&*-])/";
   $minEightPassword = "/.{8,}/";

 //  First Name Validation
if(empty($first_name)){
   $fnameErr="First Name is Required"; 
}
else if (!preg_match($validName,$first_name)) {
   $fnameErr="Digits are not allowed";
}else{
   $fnameErr=true;
}

//  Last Name Validation
if(empty($last_name)){
   $lnameErr="Last Name is required"; 
}
else if (!preg_match($validName,$last_name)) {
   $lnameErr="Digit are not allowed";
}
else{
   $lnameErr=true;
}

//Email Address Validation
if(empty($email)){
  $emailErr="Email is Required"; 
}
else if (!preg_match($validEmail,$email)) {
  $emailErr="Invalid Email Address";
}
else{
  $emailErr=true;
}
    
// password validation 
if(empty($password)){
  $passErr="Password is Required"; 
} 
elseif (!preg_match($uppercasePassword,$password) || !preg_match($lowercasePassword,$password) || !preg_match($digitPassword,$password) || !preg_match($symbolPassword,$password) || !preg_match($minEightPassword,$password) || preg_match($spacesPassword,$password)) {
  $passErr="Password must be at least one uppercase letter, lowercase letter, digit, a special character with no spaces and minimum 8 length";
}
else{
   $passErr=true;
}

// form validation for confirm password
if($cpassword!=$password){
   $cpassErr="Confirm Password doest Matched";
}
else{
   $cpassErr=true;
}

// check all fields are valid or not
if($fnameErr==1 && $lnameErr==1 && $emailErr==1 && $passErr==1 && $cpassErr==1)
{

   
    $firstName =legal_input($first_name);
    $lastName  =legal_input($last_name);
    $email     =legal_input($email);
    $password  =legal_input(md5($password));
   
    // check unique email
    $checkEmail=unique_email($email);
    if($checkEmail)
    {
      $register=$email." is already exist";
    }else{

       // Insert data
      $register=register($firstName,$lastName,$email,$password);

    }




}else{

     // set input values is empty until input field is invalid
    $set_firstName=$first_name;
    $set_lastName= $last_name;
    $set_email=    $email;
}
// check all fields are vakid or not
}


// convert illegal input value to ligal value formate
function legal_input($value) {
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  return $value;
}

function unique_email($email){
  
  global $db;
  $sql = "SELECT email FROM users WHERE email='".$email."'";
  $check = $db->query($sql);

 if ($check->num_rows > 0) {
   return true;
 }else{
   return false;
 }
}

// function to insert user data into database table
function register($firstName,$lastName,$email,$password){

   global $db;
   $sql="INSERT INTO users(first_name,last_name,email,password) VALUES(?,?,?,?)";
   $query=$db->prepare($sql);
   $query->bind_param('ssss',$firstName,$lastName,$email,$password);
   $exec= $query->execute();
    if($exec==true)
    {
     return "You are registered successfully";
    }
    else
    {
      return "Error: " . $sql . "<br>" .$db->error;
    }
}
?>