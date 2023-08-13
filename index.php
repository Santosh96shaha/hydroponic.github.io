<?php
include_once ('findvalue.php');
if (isset($_GET["readingsCount"])) {
  $data = $_GET["readingsCount"];
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $readings_count = $_GET["readingsCount"];
}
else { // default readings count set to 10
    $readings_count = 10;
}
session_start();
$_SESSION['limits'] = $readings_count;
$limit = $readings_count;

$last_reading = getLastReadings();
if ($last_reading){
    $last_reading_time = $last_reading["Time"];
    $last_reading_Temperature = $last_reading["Temperature"];
    $last_reading_Himidity = $last_reading["Humidity"];
    $last_reading_pH = $last_reading["pH"];
    $last_reading_EC = $last_reading["EC"];
    $last_reading_Light = $last_reading["Light"];
} else {
    // Handle the case when no data is available
    $last_reading_time = "--";
    $last_reading_Temperature = "--";
    $last_reading_Himidity = "--";
    $last_reading_pH = "--";
    $last_reading_EC = "--";
    $last_reading_Light = "--";
}
$min_temp= minReading('Temperature', $readings_count);
$avg_temp = calculateAverage('Temperature', $readings_count);
$max_temp = maxReading('Temperature', $readings_count);

$min_humi= minReading('Humidity', $readings_count);
$avg_humi = calculateAverage('Humidity', $readings_count);
$max_humi = maxReading('Humidity', $readings_count);

$min_pH= minReading('pH', $readings_count);
$avg_pH = calculateAverage('pH', $readings_count);
$max_pH = maxReading('pH', $readings_count);

$min_EC= minReading('EC', $readings_count);
$avg_EC = calculateAverage('EC', $readings_count);
$max_EC = maxReading('EC', $readings_count);

$min_Light= minReading('Light', $readings_count);
$avg_Light = calculateAverage('Light', $readings_count);
$max_Light = maxReading('Light', $readings_count);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title> create layout of html page</title>
    <meta http-equiv="refresh" content="1000">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
    <script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel= "stylesheet" href ="style.css">
</head>
<body>
    <div class="header">
      <a href="index.php" class="logo">Hydro<span class="ponic">ponic</span></a>
      <div class="header-right">
        <a id="datetime">Loading...</a>
        <a class="active"href="index.php">Home</a>
        <a href="#About">About</a>
        <a href="chart.php">Chart</a>
        <a href="table.php">Table</a>
        <a href="logout.php">Logout</a>
        <a class = "searchbar"><form method="GET">
            <input type = "number" name="readingsCount" min= "1" placeholder=" Number of readings (<?php echo $limit;?>)" required>
            <button class = "btn btn-sm" type="submit"> Search</button>
        </form>
    </a>
    <a class="user"> <?php echo ($_SESSION['username'])?> </a>
</div>
</div> 


<div class="wrapper">
  <div class="box1">
   <div class="details">
    <div class="farmers-box">
        <table id= "farmersTable">
            <tr class=" headingtable"> 
                <th colspan="2"> Farmers Details </th>
            </tr>
            <tr>
                <td>Farmer Name</td>
                <td><?php echo ($_SESSION['username'])?></td>
            </tr>
            <tr class = "even-row">
                <td>Farm ID</td>
                <td><?php echo ($_SESSION['user_id'])?></td>
            </tr>
            <tr>
                <td>Land Area</td>
                <td>10 Anna </td>
            </tr>
            <tr class= "even-row">
                <td>Location</td>
                <td>KU</td>
            </tr>
            <tr>
                <td>Crops</td>
                <td>Tomato, Lettuce</td>
            </tr>
            <tr class= "even-row">
                <td>Experience</td>
                <td>10 years</td>
            </tr>
        </table>
    </div>
</div>

</div>


<div class="box2">
 <div class = boxinside> 
    <div class = "temp">
     <div class="box gauge--1">
        <h3>TEMPERATURE</h3>
        <div class="mask">
            <div class="semi-circle"></div>
            <div class="semi-circle--mask"></div>
        </div>
        <p style="font-size: 30px;" id="temp">--</p>
        <table cellspacing="4" cellpadding="4">
            <tr>
               <th colspan="3">Temperature <?php $today=date('Y-m-d'); echo $today; ?> readings</th>
           </tr>
           <tr>
            <td>Min</td>
            <td>Max</td>
            <td>Average</td>
        </tr>
        <tr>
            <td><?php echo $min_temp;?>&deg;C</td>
            <td><?php echo $max_temp;?>&deg;C</td>
            <td><?php echo number_format($avg_temp,2, '.')?>&deg;C</td>
        </tr>
    </table>
</div>
</div>

<div class = "humi" >
  <div class="box gauge--2">
    <h3>HUMIDITY</h3>
    <div class="mask">
        <div class="semi-circle"></div>
        <div class="semi-circle--mask"></div>
    </div>
    <p style="font-size: 30px;" id="humi">--</p>
    <table cellspacing="4" cellpadding="4">
        <tr>
            <th colspan="3">Humidity <?php echo $today?> readings</th>
        </tr>
        <tr>
            <td>Min</td>
            <td>Max</td>
            <td>Average</td>
        </tr>
        <tr>
            <td><?php echo $min_humi;?>%</td>
            <td><?php echo $max_humi;?>%</td>
            <td><?php echo number_format($avg_humi,2,'.')?>%</td>
        </tr>
    </table>
</div>
</div>

<div class = "ph">
   <div class="box gauge--3">
    <h3>pH</h3>
    <div class="mask">
        <div class="semi-circle"></div>
        <div class="semi-circle--mask"></div>
    </div>
    <p style="font-size: 30px;" id="pHvalue">--</p>
    <table cellspacing="4" cellpadding="4">
        <tr>
            <th colspan="3">pH <?php echo $today?> readings</th>
        </tr>
        <tr>
            <td>Min</td>
            <td>Max</td>
            <td>Average</td>
        </tr>
        <tr>
            <td><?php echo $min_pH;?> pH</td>
            <td><?php echo $max_pH;?> pH</td>
            <td><?php echo number_format($avg_pH,2,'.')?> pH</td>
        </tr>
    </table>
</div> 
</div>

<div class = "ec">
   <div class="box gauge--4">
    <h3>EC</h3>
    <div class="mask">
        <div class="semi-circle"></div>
        <div class="semi-circle--mask"></div>
    </div>
    <p style="font-size: 30px;" id="EC_value">--</p>
    <table cellspacing="5" cellpadding="5">
        <tr>
            <th colspan="3">EC <?php echo $today?> readings</th>
        </tr>
        <tr>
            <td>Min</td>
            <td>Max</td>
            <td>Average</td>
        </tr>
        <tr>
            <td><?php echo $min_EC;?> ppm</td>
            <td><?php echo $max_EC;?> ppm</td>
            <td><?php echo number_format($avg_EC,2,'.')?> ppm </td>
        </tr>
    </table>
</div>     
</div>

<div class = "light">
    <div class="box gauge--5">
       <h3>Light</h3>
       <div class="mask">
        <div class="semi-circle"></div>
        <div class="semi-circle--mask"></div>
    </div>
    <p style="font-size: 30px;" id="Light_value">--</p>
    <table cellspacing="4" cellpadding="0">
        <tr>
            <th colspan="3">Light <?php echo $today?> readings</th>
        </tr>
        <tr>
            <td>Min</td>
            <td>Max</td>
            <td>Average</td>
        </tr>
        <tr>
            <td><?php echo $min_Light;?></td>
            <td><?php echo $max_Light;?></td>
            <td><?php echo number_format($avg_Light,2,'.')?></td>
        </tr>
    </table>
</div>
</div>
</div>
</div>
<div class="box3">Three</div>
<div class="box4">
   <p colspan="2"> Farm View </p>
   <img src="image/1.jpg" alt= "hydroponic">
</div>


<div class="box5">
    <form method ="POST" action = threshold_set.php>
        <div class= "set">
            <div class="set_temp"> <p>Temperature</p>  
             <img src="tem.png" alt="Logo3" class="logo3">
             <input type = "number" step ="0.1" name = "threshold_temp" id = "threshold_temp" required> <br> 
         </div>
         <div class = "set_humi"> <p> Humidity </p> 
            <img src="hum.png" alt="Logo4" class="logo3">
            <input type = "number" step ="0.1" name= "threshold_humi" id = "threshodld_humi" required > <br> 
        </div>
        <div class = "set_ph"> <p> ph </p>
            <img src="ph.png" alt="Logo5" class="logo3">
            <input type = "number" step ="0.1" name= "threshold_ph" id = "threshodld_ph" required > <br> 
        </div>
        <div class = "set_ec"> <p> EC </p>
           <img src="ec.jpg" alt="Logo6" class="logo3">
           <input type = "number" step ="0.1" name= "threshold_ec" id= "threshodld_ec" required > <br> 
       </div>
       <div class= "set_light"> <p> Light </p>
        <img src="sun.png" alt="Logo7" class="logo3">
        <input type = "number" step ="0.1" name= "threshold_light" id= "threshodld_light" required > <br> 
    </div>
</div>
<h2> Set The Threshold Value of Sensor  <input class = "bt" type = "submit" value ="Submit"> </h2>
</form>

</div>
<div class="box6">Six

</div>
<div class="box7">
   <video width="450" height="180" controls >
       <source src="movie.mp4" type="video/mp4">
       </video>
   </div>
   <div class="box8">
    <div class="google-map">
       <iframe src="https://www.google.com/maps/d/embed?mid=18d0Zmb1Qjebpkh-hyp-e0IkHsv4&hl=en&ehbc=2E312F" width="640" height="200"></iframe>
   </div>
</div>
</div>
</body>
<?php include 'footer.html';?>
</html>
<script>
    var value1 = <?php echo $last_reading_Temperature; ?>;
    var value2 = <?php echo $last_reading_Himidity; ?>;
    var value3 = <?php echo $last_reading_pH; ?>;
    var value4 = <?php echo $last_reading_EC; ?>;
    var value5 = <?php echo $last_reading_Light; ?>;
    

    
    function setTemperature(curVal){
        //set range for Temperature in Celsius -5 Celsius to 38 Celsius
        var minTemp = -35.0;
        var maxTemp = 38.0;
        //set range for Temperature in Fahrenheit 23 Fahrenheit to 100 Fahrenheit
        //var minTemp = 23;
        //var maxTemp = 100;

        var newVal = scaleValue(curVal, [minTemp, maxTemp], [0, 180]);
        $('.gauge--1 .semi-circle--mask').attr({
            style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
        });
        $("#temp").text(curVal + ' ºC');
         //setInterval(setTemperature, 5000);
    }

    function setHumidity(curVal){
        //set range for Humidity percentage 0 % to 100 %
        var minHumi = 0;
        var maxHumi = 100;

        var newVal = scaleValue(curVal, [minHumi, maxHumi], [0, 180]);
        $('.gauge--2 .semi-circle--mask').attr({
            style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
        });
        $("#humi").text(curVal + ' %');
    }

    function setpH(curVal){
        //set range for Humidity percentage 0 % to 100 %
        var minpH = 0;
        var maxpH = 14;

        var newVal = scaleValue(curVal, [minpH, maxpH], [0, 180]);
        $('.gauge--3 .semi-circle--mask').attr({
            style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
        });
        $("#pHvalue").text(curVal + ' pH');
    }

    function setEC(curVal){
        //set range for Humidity percentage 0 % to 100 %
        var minEC = 0;
        var maxEC = 1000;

        var newVal = scaleValue(curVal, [minEC, maxEC], [0, 180]);
        $('.gauge--4 .semi-circle--mask').attr({
            style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
        });
        $("#EC_value").text(curVal + ' ppm');
    }

    function setLight(curVal){
        //set range for Humidity percentage 0 % to 100 %
        var minLight = 0;
        var maxLight = 1000;

        var newVal = scaleValue(curVal, [minLight, maxLight], [0, 180]);
        $('.gauge--5 .semi-circle--mask').attr({
            style: '-webkit-transform: rotate(' + newVal + 'deg);' +
            '-moz-transform: rotate(' + newVal + 'deg);' +
            'transform: rotate(' + newVal + 'deg);'
        });
        $("#Light_value").text(curVal + ' lux');
    }

    function scaleValue(value, from, to) {
        var scale = (to[1] - to[0]) / (from[1] - from[0]);
        var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
        return ~~(capped * scale + to[0]);
    }
    setTemperature(value1);
    setHumidity(value2);
    setpH(value3);
    setEC(value4);
    setLight(value5);
</script>


<script>
    // Function to update the date and time
    function updateDateTime() {
      const now = new Date();
      const dateTimeString = now.toLocaleString(); // Convert date and time to a human-readable string
      document.getElementById("datetime").textContent = dateTimeString;
  }

    // Call the function once when the page loads
  updateDateTime();

    // Update the date and time every second (1000ms)
  setInterval(updateDateTime, 1000);
</script>