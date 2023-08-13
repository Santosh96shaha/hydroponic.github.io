    <?php
    // Include the database connection and other necessary files
    session_start();
    include 'config.php';
    if (isset($_GET["readingsCount"])) {
        $data = $_GET["readingsCount"];
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $readings_chart = $_GET["readingsCount"];
    } else {
        // default readings count set to 10
        $readings_chart = 100;
    }

    // Fetch sensor data from the database (limited to the last 100 records)
    $query = "SELECT Time, Temperature, Humidity, pH, EC, Light FROM " . $_SESSION['username'] . " ORDER BY Time DESC LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $readings_chart);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        die("Query failed: " . mysqli_error($conn));
    }

    // Prepare the data for the chart
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data['Time'][] = $row['Time'];
        $data['Temperature'][] = $row['Temperature'];
        $data['Humidity'][] = $row['Humidity'];
        $data['pH'][] = $row['pH'];
        $data['EC'][] = $row['EC'];
        $data['Light'][] = $row['Light'];
    }

    // Reverse the order of the data arrays
    $data['Time'] = array_reverse($data['Time'] ?? []);
    $data['Temperature'] = array_reverse($data['Temperature'] ?? []);
    $data['Humidity'] = array_reverse($data['Humidity'] ?? []);
    $data['pH'] = array_reverse($data['pH'] ?? []);
    $data['EC'] = array_reverse($data['EC'] ?? []);
    $data['Light'] = array_reverse($data['Light'] ?? []);

    // Close the statement
    $stmt->close();

    // Close the database connection
    mysqli_close($conn);
    ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Sensor Data Chart</title>
        <meta http-equiv="refresh" content="30"> 
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link rel="stylesheet" href="style.css">
        <style>
            *{
              margin:0px;
              box-sizing: border-box;
              padding: 0px;
          }
          body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .chart-container {
            width: 100%;
            margin-top: 20px;
        }

        .sensor-checkboxes {
            margin-bottom: 10px;
            padding-left: 20px;
            text-align: center;

        }
        .chart-container {
            width: 1000px;
            margin: 0 auto;
            background-color: #f5f5f5;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        header{
          background-color: green;
          color: #fff;
          padding: 5px;
          text-align: center;
          margin-bottom: 10px;
      }
      #sensorChart {
        /*background-image: url('path/to/image.jpg');*/ /* Replace 'path/to/image.jpg' with the actual path to your image file */
            /* or */
            background-color: lightgray; /* Replace #f2f2f2 with the desired background color */
        }
    </style>
</head>
<body>

    <div class="header">
      <a href="index.php" class="logo">Hydro<span class="ponic">ponic</span></a>
      <div class="header-right">
        <a class="active"href="index.php">Home</a>
        <a href="#About">About</a>
        <a href="chart.php">Chart</a>
        <a href="table.php">Table</a>
        <a href="logout.php">Logout</a>
        <a class = "searchbar"><form method="GET">
            <input type = "number" name="readingsCount" min= "1" placeholder=" Number of readings (<?php echo $readings_chart;?>)" required>
            <button class = "btn btn-sm" type="submit"> Search</button>
        </form>
    </a>
    <a class="user"> <?php echo ($_SESSION['username'])?> </a>
</div>
</div> 
<header>
    <h1>Hydroponic Live Sensor Data Plot</h1>
</header>
<div class="sensor-checkboxes">
 <form action="" method = "post" if ="chartForm" name = "sensor">
    <input type="checkbox" name="Sensor[]" value="Temperature" />Temperautre
    <input type="checkbox" name="Sensor[]" value="Humidity" />Humidity
    <input type="checkbox" name="Sensor[]" value="pH"  />pH
    <input type="checkbox" name="Sensor[]" value="EC"  />EC
    <input type="checkbox" name="Sensor[]" value="Light" />Light
    <input type="submit" name ="submit" value="Submit">
</form>
</div>

<div class="chart-container">
    <canvas id="sensorChart"></canvas>
</div>


</body>
</html>

<?php
    // Initialize the selected sensors array
$selectedSensors = array();
    // Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Sensor'])) {
        // Retrieve the selected sensors from the form
    $selectedSensors = $_POST["Sensor"];
} else {
        // Default: All sensors selected
    $selectedSensors = array("Temperature", "Humidity", "pH", "EC", "Light");
}
?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('sensorChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($data['Time']); ?>,
                datasets: [
                    <?php if (in_array('Temperature', $selectedSensors)) { ?>
                        {
                            label: 'Temperature',
                            data: <?php echo json_encode($data['Temperature']); ?>,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 2,
                            fill: true
                        },
                    <?php } ?>
                    <?php if (in_array('Humidity', $selectedSensors)) { ?>
                        {
                            label: 'Humidity',
                            data: <?php echo json_encode($data['Humidity']); ?>,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            fill: true
                        },
                    <?php } ?>
                    <?php if (in_array('pH', $selectedSensors)) { ?>
                        {
                            label: 'pH',
                            data: <?php echo json_encode($data['pH']); ?>,
                            borderColor: 'rgba(54, 50, 50, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 2,
                            fill: true
                        },
                    <?php } ?>
                    <?php if (in_array('EC', $selectedSensors)) { ?>
                        {
                            label: 'EC',
                            data: <?php echo json_encode($data['EC']); ?>,
                            borderColor: 'rgba(100, 162, 235, 1)',
                            backgroundColor: 'rgba(100, 162, 235, 0.2)',
                            borderWidth: 2,
                            fill: true
                        },
                    <?php } ?>
                    <?php if (in_array('Light', $selectedSensors)) { ?>
                        {
                            label: 'Light',
                            data: <?php echo json_encode($data['Light']); ?>,
                            borderColor: 'rgba(54, 162, 100, 1)',
                            backgroundColor: 'rgba(54, 162, 100, 0.2)',
                            borderWidth: 2,
                            fill: true
                        }
                    <?php } ?>

                    ]
            },

            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true,
                        reverse: false,
                        title: {
                            display: true,
                            text: 'Date and Time '
                        }
                    },
                    y: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Value'
                        }
                    }
                },
                animations: {
                  tension: {
                    duration: 1000,
                    easing: 'easeInOutElastic',
                    from:1,
                    to: 0,
                    loop: true
                }
            },
            plugins: {
                tooltip:{
                    mode: 'index',
                    intersect: false
                },
                crosshair:{
                    line: {
                        color: 'rgb(0.5,0,0,0.5)',
                        width:1
                    }
                }
            }
        }
    });

                // Update the chart when the form is submitted
        document.getElementById('chartForm').addEventListener('submit', function(event) {
            event.preventDefault();
                chart.destroy(); // Destroy the current chart instance
                this.submit(); // Submit the form to update the chart
            });
    });
</script>
</body>
</html>
