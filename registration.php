<?php
include_once "config.php";

// Function to safely escape user input
function clean_input($data) {
  global $conn;
  return mysqli_real_escape_string($conn, trim($data));
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data and clean it
  $username = clean_input($_POST['username']);
  $email = clean_input($_POST['email']);
  $password = clean_input($_POST['Password']);
  $confirm_password = clean_input($_POST['confirm_password']);

  // Validate the form data
  if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
    echo "Please fill in all the required fields.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email address.";
  } elseif ($password !== $confirm_password) {
    echo "Passwords do not match.";
  } else {
    // Check if the username and email are not already taken
    $sql = "SELECT * FROM login WHERE User='$username' OR email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
      // The username or email is already taken
      echo "Username or email already taken";
    } else {
      // Hash the password before storing it in the database
      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

      // Insert the user into the database
      $sql = "INSERT INTO login (User, email, Password) VALUES ('$username', '$email', '$hashed_password')";
      mysqli_query($conn, $sql);
      $sensor_data_table_name = $username; 
      $sql = "CREATE TABLE IF NOT EXISTS $sensor_data_table_name (
              Time datetime DEFAULT CURRENT_TIMESTAMP,
              Temperature FLOAT NOT NULL,
              Humidity FLOAT NOT NULL,
              pH FLOAT NOT NULL,
              EC FLOAT NOT NULL,
              Light FLOAT NOT NULL)";

if ($conn->query($sql) === TRUE) {
    echo "Sensor data table created successfully for user $new_user_id";
} else {
    echo "Error creating sensor data table: " . $conn->error;
}
      // The user has been registered, redirect to the login page
      header("Location: login.php");
      exit;
    }
  }
}
?>
