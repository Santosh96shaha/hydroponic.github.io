<?php
include_once "config.php";
// Your PHP code to handle user registration and inserting into the 'users' table goes here...

// After successfully registering the user and inserting into the 'users' table, get the newly created user's ID.
//$new_user_id = $conn->insert_id;

// Create a new table for sensor data associated with the new user
$sensor_data_table_name = "ensor_datas";// . $new_user_id;
$sql = "CREATE TABLE IF NOT EXISTS $sensor_data_table_name (
        Time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        Temperature FLOAT NOT NULL,
        Humidity FLOAT NOT NULL,
        pH FLOAT NOT NULL,
        EC FLOAT NOT NULL,
        LIGHT FLOAT NOT NULL)";

if ($conn->query($sql) === TRUE) {
    echo "Sensor data table created successfully for user new_user_id";
} else {
    echo "Error creating sensor data table: " . $conn->error;
}

// Close the database connection
$conn->close();
?>
