<?php
$instance="demo";
require_once ('/etc/webserver/'.$instance.'_config.php');
$sensorhub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

function one_col($sensorhub_db,$mypage,$id) {
	$limit1=($mypage)*10;
	$limit2=10;
	$returnstr="<table><tr><th>Zeitpunkt</th><th>Wert</th></th></tr>";
	foreach ($sensorhub_db->query("select date_format(from_unixtime(utime),'%d.%m.%y %H:%i'), substr(value,1,4) from sensordata ".
	               " where sensor_id = ".$id." order by utime desc LIMIT ".$limit1.", ".$limit2) as $row) {
  	    $returnstr=$returnstr."<tr><td>$row[0]</td><td>$row[1]</td></tr>";
	}
	$returnstr=$returnstr."</table>";
	return $returnstr;
}

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
if (isset($_GET["page"]))  {
  $page=$_GET["page"]*$num_col;
} else { 
  $page=1; 
}

if ( $sensor > 0 ) { 
	$id=$sensor;
	print "<center>&nbsp<b>";
	foreach ($sensorhub_db->query("select sensor_id, sensor_name, s_type, node_name from node, sensor where node.node_id = sensor.node_id and sensor_id = ".$id." ") as $row) {
		if ( $row[2] == "s" ) {
			print "Sensor: ". $row[0]. "<br>".$row[3]."<br>".$row[1]." ";
		} else {
			print "Actor: ". $row[0]. "<br>".$row[3]."<br>".$row[1]." ";
		}
	}
	echo "</b></center>".
		 "<center>&nbsp;<table class=noborder><tr><td>".one_col($sensorhub_db,$page,$id);
    if ($num_col > 1) {
    	echo "</td><td>".one_col($sensorhub_db,$page+1,$id);
	}
    if ($num_col > 2) {
    	echo "</td><td>".one_col($sensorhub_db,$page+2,$id);
	}
    if ($num_col > 3) {
    	echo "</td><td>".one_col($sensorhub_db,$page+3,$id);
	}
    if ($num_col > 4) {
    	echo "</td><td>".one_col($sensorhub_db,$page+4,$id);
	}
    if ($num_col > 5) {
    	echo "</td><td>".one_col($sensorhub_db,$page+5,$id);
	}
	echo "</td></tr></table>&nbsp;</center>"; 
}
?>
