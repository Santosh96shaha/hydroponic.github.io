<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["otp"], $_POST["new_password"], $_POST["confirm_password"], $_GET["email"])) {
        $user_otp = $_POST["otp"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];
        $email = filter_var($_GET["email"], FILTER_SANITIZE_EMAIL);

        // Connect to your database (replace with your actual database credentials)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "hydroponic";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepare and execute the SQL query to validate the OTP and fetch the expiration time
            $stmt = $conn->prepare("SELECT expiration_time FROM password_reset WHERE email = :email AND otp = :otp");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':otp', $user_otp);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result && $result["expiration_time"] >= time()) {
                // Valid OTP and not expired
                if ($new_password === $confirm_password) {
                    // Hash the new password before storing it in the database
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

                    // Update the user's password in the database (replace 'users' with your actual table name)
                    $stmt = $conn->prepare("UPDATE login SET password = :password WHERE email = :email");
                    $stmt->bindParam(':password', $hashed_password);
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    // Optionally, you can delete the used OTP from the password_reset table to prevent further use
                    $stmt = $conn->prepare("DELETE FROM password_reset WHERE email = :email");
                    $stmt->bindParam(':email', $email);
                    $stmt->execute();

                    echo "Password reset successful. You can now login with your new password.";
                    header("Location: login.php");
                } else {
                    echo "Passwords do not match.";
                }
            } else {
                echo "Invalid or expired OTP.";
            }

            // Close the database connection
            $conn = null;
        } catch (PDOException $e) {
            echo "Database error: " . $e->getMessage();
            exit;
        }
    } else {
        echo "Invalid request.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        h2 {
            text-align: center;
            margin-top: 30px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="number"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .message {
            text-align: center;
            margin-top: 20px;
        }
        .message a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>Reset Password</h2>
    <form action="" method="post">
        <label for="otp">Enter the OTP sent to your email:</label>
        <input type="number" id="otp" name="otp" required><br>
        <label for="new_password">New Password:</label>
        <input type="password" id="new_password" name="new_password" required><br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" id="confirm_password" name="confirm_password" required><br>
        <input type="submit" value="Reset Password">
    </form>
</body>
</html>
