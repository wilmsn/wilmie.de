<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$dh_db = new PDO("mysql:host=$db_dh_server;dbname=$db_dh_db", $db_dh_user, $db_dh_pass);

if (isset($_GET["utime"])) { $utime=$_GET["utime"]; } else { $utime=0; }
if (isset($_GET["sensorno"])) { $sensor_id=$_GET["sensorno"]; } else { $sensor_id=0; }
if (isset($_GET["value"])) { $value=$_GET["value"]; } else { $value="0"; }
if (isset($_GET["action"])) { $action=$_GET["action"]; } else { $action="nothing"; }

if ( $action === "delete" ) {
  if ( $utime > 0 and $sensor_id > 0 ) {
    $sql ="delete from sensordata where sensor_id = ".$sensor_id." and utime = ".$utime;
	$dh_db->query($sql);
	print "SQL: ".$sql;
  } else {
    print "Error: utime or sensor_id not set!";
  }
}
if ( $action === "update" ) {
  if ( $utime > 0 and $sensor_id > 0 ) {
    $sql ="update sensordata set value = ".$value." where sensor_id = ".$sensor_id." and utime = ".$utime;
	$dh_db->query($sql);
	print "SQL: ".$sql;
  } else {
    print "Error: utime or sensor_id not set!";
  }
}

?>

