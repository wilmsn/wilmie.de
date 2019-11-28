<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$sensorhub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

if (isset($_GET["onid"])) { $onid=$_GET["onid"]; } else { $onid=999999999; }
if (isset($_GET["nid"])) { $nid=$_GET["nid"]; } else { $nid=999999999; }
if (isset($_GET["nn"])) { $nn=$_GET["nn"]; } else { $nn=" "; }
if (isset($_GET["ni"])) { $ni=$_GET["ni"]; } else { $ni=" "; }
if (isset($_GET["hb"])) { $hb=$_GET["hb"]; }
if (isset($_GET["bid"])) { $bid=$_GET["bid"]; } 
$bid=$bid*1;

if ( $onid == 0 ) {
$sql ="insert into node (node_id, node_name, add_info, battery_id, heartbeat) values('".$nid."', '".$nn."', '".$ni."', ".$bid.", '".$hb. "')";
	$sensorhub_db->query($sql);
	print "Neuen Node angelegt, NodeID: ".$nid;
} else {
	$sql = " update node set node_name = '".$nn."', add_info = '".$ni."', battery_id = ".$bid.", heartbeat = '". $hb."'  where node_id = '".$onid."' ";
        $sensorhub_db->query($sql);
	print "Update erfolgt für NodeID: ".$onid;
}		
print "  ".$sql." ";
?>

