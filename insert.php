<?php
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the required keys are set
    if (isset($_GET['user'], $_GET['Temperature'], $_GET['Humidity'], $_GET['pH'], $_GET['EC'], $_GET['Light'])) {
        $user = $_GET['user'];
        $Temperature = $_GET['Temperature'];
        $Humidity = $_GET['Humidity'];
        $pH = $_GET['pH'];
        $EC = $_GET['EC'];
        $Light = $_GET['Light'];

        include 'config.php';

        // Check if the user table exists
        $user_table_name = $user;
        $check_table_query = "SHOW TABLES LIKE '$user_table_name'";
        $table_exists = mysqli_query($conn, $check_table_query);

        if ($table_exists && mysqli_num_rows($table_exists) > 0) {
            // Insert data into the user's table
            $sql = "INSERT INTO $user_table_name (`Temperature`, `Humidity`, `pH`, `EC`, `Light`) 
                    VALUES ('$Temperature', '$Humidity', '$pH', '$EC', '$Light')";
            $result = mysqli_query($conn, $sql) or die("Query Unsuccessful: " . mysqli_error($conn));

            if ($result) {
                echo "Inserted Successfully";
            } else {
                echo "Failed to insert data into the user table.";
            }
        } else {
            echo "User table does not exist.";
        }
    } else {
        echo "One or more required fields are missing.";
    }
}
?>
