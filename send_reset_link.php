<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate the email address
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Connect to your database (replace with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "hydroponic";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare and execute the SQL query to check if the email exists in the users table
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM login WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the email exists in the users table
        if ($result['count'] > 0) {
            // Generate a random OTP (6-digit number)
            $otp = rand(100000, 999999);

            // Store the OTP, email, and expiration time in a password_reset table in the database
            $expiration_time = time() + 300; // OTP expires in 5 minutes (adjust as needed)

            // Prepare and execute the SQL query to store the OTP, email, and expiration time
            $stmt = $conn->prepare("INSERT INTO password_reset (email, otp, expiration_time) VALUES (:email, :otp, :expiration_time)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':otp', $otp);
            $stmt->bindParam(':expiration_time', $expiration_time);
            $stmt->execute();

            // Send the OTP via email using PHPMailer
            $mail = new PHPMailer(true);

            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'esp32serverdata@gmail.com';
            $mail->Password   = 'ahmgytwezbphnxip';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('esp32serverdata@gmail.com', 'santosh');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'OTP for Password Reset';
            $mail->Body    = "Your OTP for password reset is: $otp";
            $mail->AltBody = "Your OTP for password reset is: $otp";

            $mail->send();
            
            // Redirect to the reset password page after sending the OTP
            header("Location: reset_password.php?email=" . urlencode($email));
            exit();
        } else {
            echo "Email not found in the database.";
        }

        // Close the database connection
        $conn = null;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }
}
?>
