<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    table {
      margin-left: 10%;
      width: 80%;
      border-collapse: collapse;
    }

    table th, table td {
      padding: 7px;
      text-align: center;
      border: 1px solid black;

    }
    th{
      background-color: red;
      font: bold;
    }
    th:hover {background-color: green;}
    td:hover {background-color: gray;}
  </style>
</head>
<body>

<table cellpadding="7px" style="width:80%" >
  <thead> 
    <th>Time</th>
    <th>Temperature </th>
    <th>Humidity </th>
    <th>pH </th>
    <th>EC </th>
    <th>Light </th>
  </thead>
  <?php  
  include 'config.php';
  session_start();
  $limits1=$_SESSION['limit'];
  //$sql = "SELECT * FROM `hydroponic` ORDER BY Time DESC LIMIT $limits1";
  $sql = "SELECT * FROM " . $_SESSION['username'] . "  ORDER BY Time DESC LIMIT $limits1";
  $result = mysqli_query($conn, $sql) or die("Query Unsuccessful:" .mysqli_error($conn));    
  while($row = mysqli_fetch_assoc($result)){          
    $Time = $row['Time'];
    $Temperature = $row['Temperature'];
    $Humidity = $row['Humidity'];
    $pH = $row['pH'];
    $EC = $row['EC'];
    $Light = $row['Light'];
  ?>
  <tbody>
  <tr>
  <td align="center"><?php echo $Time;  ?></td>
  <td align="center"><?php echo $Temperature; ?></td>
  <td align="center"><?php echo $Humidity; ?></td>
  <td align="center"><?php echo $pH; ?></td>
  <td align="center"><?php echo $EC; ?></td>
  <td align="center"><?php echo $Light; ?> </td>
  </tr>
  </tbody>

  <?php  }
  mysqli_close($conn);
  ?>

</table>
</body>
</html>
