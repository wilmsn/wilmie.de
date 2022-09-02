<?php
$instance="intern";

require_once ('/etc/webserver/'.$instance.'_config.php');
$rf24hub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

if (isset($_GET["sensor"]))  {
  $sensor=$_GET["sensor"];
} else { 
  $sensor=0; 
}
if (isset($_GET["num_col"]))  {
  $num_col=$_GET["num_col"];
} else { 
  $num_col=1; 
}
foreach ($rf24hub_db->query("select records / ".$num_col." / 10 from sensor_im where sensor_id = ".$sensor) as $row) {
	print floor($row[0]); 
}
//  print floor(10000/$num_col);
?>
