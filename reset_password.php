<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create a database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Sanitize the user's email address and new password from the form
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Update the user's password in the database
  $sql = "UPDATE ittani SET password='$password' WHERE email='$email'";
  $result = mysqli_query($conn, $sql);

  // Check if the query was successful
  if ($result) {
    // Show a success message to the user
    echo '<h2>Congratulations, ' . $email .  '!</h2>';
    echo 'Your password has been reset.';
    echo '<button><a href="login.html">Go to Login Page</a></button>';
  } else {
    // Show an error message to the user
    die("Error updating password: " . mysqli_error($conn));
  }
}

// Close the database connection
mysqli_close($conn);
?>
