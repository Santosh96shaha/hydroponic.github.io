<?php
// Start the session to manage user login status
session_start();
include_once "config.php";

// Function to safely escape user input
function clean_input($data) {
  global $conn;
  return mysqli_real_escape_string($conn, trim($data));
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data and clean it
  $email = clean_input($_POST['email']);
  $password = clean_input($_POST['Password']);

  // Validate the form data
  if (empty($email) || empty($password)) {
    echo "Please fill in both email and password.";
  } else {
    // Check if the provided email exists in the database
    $sql = "SELECT * FROM login WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
      // Fetch the user data from the database
      $user = mysqli_fetch_assoc($result);

      // Verify the password
      if (password_verify($password, $user['Password'])) {
        // Password is correct, set session variables and redirect to the restricted area
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['User'];
        header("Location: index.php");
        exit;
      } else {
        // Password is incorrect
        echo "Invalid password.";
      }
    } else {
      // Email does not exist in the database
      echo "Invalid email.";
    }
  }
}
?>
