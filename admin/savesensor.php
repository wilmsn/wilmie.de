<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$sensorhub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

if (isset($_GET["osid"])) { $osid=$_GET["osid"]; } else { $osid=999999999; }
if (isset($_GET["sid"])) { $sid=$_GET["sid"]; } else { $sid=999999999; }
if (isset($_GET["sn"])) { $sn=$_GET["sn"]; } else { $sn=" "; }
if (isset($_GET["si"])) { $si=$_GET["si"]; } else { $si=" "; }
if (isset($_GET["nid"])) { $nid=$_GET["nid"]; } else { $nid="00"; }
if (isset($_GET["ch"])) { $ch=$_GET["ch"]; } else { $ch=0; }
$ch=$ch*1;
if (isset($_GET["ty"])) { $ty=$_GET["ty"]; } else { $ty='s'; }
if (isset($_GET["fh"])) { $fh=$_GET["fh"]; } else { $fh='not_set'; }
if (isset($_GET["sd"])) { $sd=$_GET["sd"]; } else { $sd='-1'; }

if ( $osid == 0 ) {
	$sql = "insert into sensor (sensor_id, sensor_name, add_info, node_id, channel, s_type, fhem_dev, store_days) values(".$sid.",'".$sn."', '".$si."', '".$nid."', ".$ch.", '".$ty."' , '" .$fh. "' , ".$sd.")";
	$sensorhub_db->query($sql);
	print "Neuen Sensor angelegt: ".$sid;
} else {
	$sql = "update sensor set sensor_name = '".$sn."', add_info = '".$si."', node_id = '".$nid."', channel = ".$ch.", s_type = '".$ty."', fhem_dev = '". $fh ."', store_days = ".$sd. " where sensor_id = ".$osid;
        $sensorhub_db->query($sql);
	print "Update erfolgt für SensorID: ".$osid;
}
?>