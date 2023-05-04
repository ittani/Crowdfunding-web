<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get user input
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $city = $_POST['city'];
  $code = $_POST['code'];

  // Validate user input
  $errors = [];
  if (empty($firstName)) {
    $errors[] = 'First name is required.';
  }
  if (empty($lastName)) {
    $errors[] = 'Last name is required.';
  }
  if (empty($email)) {
    $errors[] = 'Email is required.';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format.';
  }
  if (empty($password)) {
    $errors[] = 'Password is required.';
  }
  if (empty($city)) {
    $errors[] = 'City is required.';
  }
  if (empty($code)) {
    $errors[] = 'Code is required.';
  }

  // If there are errors, display them and stop processing
  if (!empty($errors)) {
    echo '<ul>';
    foreach ($errors as $error) {
      echo '<li>' . $error . '</li>';
    }
    echo '</ul>';
    exit;
  }

  // Insert user data into the database
  $servername = 'localhost';
  $username = 'root';
  $db_password = '';
  $dbname = 'test';

  // Create database connection
  $conn = new mysqli($servername, $username, $db_password, $dbname);

  // Check connection
  if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
  }

  // Prepare and bind the insert statement
  $stmt = $conn->prepare("INSERT INTO ittani (firstName, lastName, email, password, city, code) VALUES (?, ?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssss", $firstName, $lastName, $email, $password, $city, $code);

  // Execute the statement
  if ($stmt->execute()) {
    // Step 4: Congratulate the user
    echo '<h2>Congratulations, ' . $firstName . ' ' . $lastName . '!</h2>';
    echo '<p>You have successfully registered with the following details:</p>';
    echo '<ul>';
    echo '<li>First name: ' . $firstName . '</li>';
    echo '<li>Last name: ' . $lastName . '</li>';
    echo '<li>Email: ' . $email . '</li>';
    echo '<li>City: ' . $city . '</li>';
    echo '<li>Code: ' . $code . '</li>';
    echo '</ul>';
    echo '<button><a href="login.html">Go to Login Page</a></button>';
  } else {
    echo 'Error: ' . $stmt->error;
  }

  // Close the database connection
  $stmt->close();
  $conn->close();
}
?>
