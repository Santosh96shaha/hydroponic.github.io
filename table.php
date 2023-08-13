<?php
include_once ('findvalue.php');
//include_once('server.php');
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
$_SESSION['limit'] = $readings_count;
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
<link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet" type="text/css">
<script src ="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<link rel= "stylesheet" href ="style.css">
</head>
<style>
	h1{
		text-transform: uppercase;
		text-align: center;
		padding: 5px;
		background-color: green;
		margin-top: 10px;
		margin-bottom: 10px;
		color: white;
	}
	
</style>

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
        <input type = "number" name="readingsCount" min= "1" placeholder=" Number of readings (<?php echo $readings_count;?>)" required>
        <button class = "btn btn-sm" type="submit"> Search</button>
      </form>
    </a>
    <a class="user"> <?php echo ($_SESSION['username'])?> </a>
  </div>
</div> 

	<div id= "wrapper">
		<h1> Hydroponic Monitoring Sensor Data Table </h1>
	</div>
	
	<div id= "main-content">
	</div> 
<script>
	function loadXMLDoc(){
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				document.getElementById("main-content").innerHTML = this.responseText;
			}
		};
		//xhttp.open("GET", "server.php?readingsCount=" + readingsCount, true);
		xhttp.open("GET", "server.php", true); // Pass readingsCount as the limit parameter
		//xhttp.open("GET", "server.php", true);
		xhttp.send();
	}
	setInterval(function(){
		loadXMLDoc();
	}, 1000);
	window.onload= loadXMLDoc;
</script>
</body>
</html


