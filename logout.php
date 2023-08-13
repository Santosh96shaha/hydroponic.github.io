<?php
// Start the session to manage user login status
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
  // Clear all session variables
  session_unset();

  // Destroy the session
  session_destroy();

  // Redirect the user to the login page or any other page as needed
  header("Location: login.php");
  exit;
} else {
  // If the user is not logged in, redirect them to the login page
  header("Location: login.php");
  exit;
}
?>
