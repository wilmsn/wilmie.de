<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$sensorhub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

$sensorhub_db->exec("insert into sensordata(sensor_id, utime, value) select sensor_id, utime, value from sensordata_im where (sensor_id,utime) not in (select sensor_id, utime from sensordata)"); 

print "inMemory Tabellen &uuml;bertragen";

?>
