<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$dh_db = new PDO("mysql:host=$db_dh_server;dbname=$db_dh_db", $db_dh_user, $db_dh_pass);

#######################
#
# Sensoren auflisten
#
#######################
foreach ($dh_db->query(" select sensor_id, sensor_name from sensor ") as $row_sensor) {
    $mysensorname = "'".$row_sensor[1]."'";
    $mysensorid = $row_sensor[0];
    $bgcolor = "#119911";
    foreach ($dh_db->query("select ifnull(unix_timestamp() - max(utime), 100000) from sensordata where sensor_id = ".$mysensorid." group by sensor_id") as $sensor_age ) {
        $myage = $sensor_age[0]+1;
    }
    if ( $myage > 70000 ) { $bgcolor = "#991111"; }
    print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
          "<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' style='background: ".$bgcolor."; color: white;'></li>".
          "<li><a id='xxxhead".$mysensorid."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
          " href='#' onclick=alert($mysensorid); ".
          " data-rel='popup' style='background: #666666; color: black; ' ><center>".$mysensorname."(".$mysensorid.
          ")</center></a></li><div ID='node".$mysensorid."' style='background: #AAAAAA; color: black; display: none;'>";
}

