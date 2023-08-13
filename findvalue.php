  <?php
 // session_start();
include 'config.php';
function minReading($columnName, $limit) {
    global $servername, $username, $password, $database;
    $conn = mysqli_connect($servername, $username, "", $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $today = date('Y-m-d');
    $sql = "SELECT Min($columnName) AS min_temperature FROM " . $_SESSION['username'] . " WHERE DATE(Time)='$today'";

    try {
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $min_temperature = $row['min_temperature'];
            return $min_temperature;
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Handle the exception here
        // You can log the error or return a default value
        return null;
    } finally {
        $conn->close();
    }
}


function maxReading($columnName, $limit) {
    global $servername, $username, $password, $database;

    $conn1 = mysqli_connect($servername, $username, "", $database) or die("Connection Failed");
   $today = date('Y-m-d');
    //SQL query to find the maximum temperature value
    //$sql = "SELECT MAX($columnName) AS max_amount FROM hydroponic WHERE DATE(Time)= '$today'";
    $sql = "SELECT MAX($columnName) AS max_amount FROM " . $_SESSION['username'] . " WHERE DATE(Time)= '$today'";
    
    $result1 = $conn1->query($sql);
    if ($result1->num_rows > 0) {
        // Fetch the result as an associative array
        $row = $result1->fetch_assoc();
        $maximum = $row['max_amount'];
        return $maximum;
         $conn1->close();
    } else {
        return null;
         $conn1->close();
    }  
  } 

function calculateAverage($columnName, $limit) {
    global $servername, $username, $password, $database;

    $conn = mysqli_connect($servername, $username, "", $database) or die("Connection Failed");
    $today = date('Y-m-d');
    // Build the SQL query
    
    //$sql = "SELECT AVG($columnName) AS avg_amount FROM (SELECT  $columnName  FROM hydroponic order by Time desc LIMIT  $limit ) AS avg";
    //$sql = "SELECT AVG($columnName) AS avg_amount FROM hydroponic WHERE DATE(time) = '$today'";
    $sql = "SELECT AVG($columnName) AS avg_amount FROM " . $_SESSION['username'] . " WHERE DATE(time) = '$today'";

    // Execute the query
    $result4 = $conn->query($sql);

    // Check if the query was successful
    if ($result4->num_rows > 0) {
        // Fetch the average value
        $row = $result4->fetch_assoc();
        $average = $row["avg_amount"];

        // Close the database connection
        $conn->close();

        return $average;
    } else {
        // Close the database connection
        $conn->close();
        return null; // or return a default value if no rows were found
    }
}


function getLastReadings() {
    global $servername, $username, $password, $database;

    $conn = new mysqli($servername, $username, "", $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT Time, Temperature, Humidity, pH, EC, Light FROM " . $_SESSION['username'] . "  ORDER BY Time DESC LIMIT 1";

    try {
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return false;
        }
    } catch (Exception $e) {
        // Handle the exception here
        // You can log the error or return a default value
        return null;
    } finally {
        $conn->close();
    }
}

function getAllReadings($limit) {
    global $servername, $username, $password, $database;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    //$sql = "SELECT Time, Temperature, Humidity, pH, EC, Light FROM hydroponic order by time desc limit " . $limit;
    $sql = "SELECT Time, Temperature, Humidity, pH, EC, Light FROM  " . $_SESSION['username'] . " order by time desc limit " . $limit;
    if ($result = $conn->query($sql)) {
      return $result;
    }
    else {
      return false;
    }
    $conn->close();
  }  
?>