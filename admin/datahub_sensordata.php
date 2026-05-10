<?php
$instance = "intern";

require_once ('/etc/webserver/'.$instance.'_config.php');
$dh_db = new PDO("mysql:host=$db_dh_server;dbname=$db_dh_db", $db_dh_user, $db_dh_pass);

if (isset($_GET["sensor"]))  {
  $sensor=$_GET["sensor"];
} else {
  $sensor=0;
}
if (isset($_GET["page"]))  {
  $page=$_GET["page"];
} else {
  $page=1;
}

if ( $sensor > 0 ) {
    $nextpage=$page+1;
    $prevpage=$page-1;
    $limit1=($page-1)*10;
    $limit2=10;
	print "<h1><center>&nbsp;Verlauf Sensor ";
	foreach ($dh_db->query("select sensor_id, sensor_name from sensor where sensor_id = ".$sensor." ") as $row) {
        print $row[1]." (".$row[0].")";
	}
	print "&nbsp;</center></h1>\n".
	      "<center><table class=noborder><tr><td class=noborder>";
	if ($page <= 1) {
		print "<img src='/img/arrow_left_e.gif' height='100' width='40'>";
    } else {
		print "<a href='#' onclick='show_detail($sensor,$prevpage);'><img src='/img/arrow_left.gif' height='100' width='40'></a>";
    }
    print "</td>\n<td><center>&nbsp;<table class=noborder><tr><td>";
    print "<table><tr><th>Zeitpunkt</th><th>Wert</th><th>&nbsp;</th></tr>\n";
    foreach ($dh_db->query("select date_format(from_unixtime(utime),'%d.%m.%y %H:%i'), value, utime from sensordata " .
                       " where sensor_id = ".$sensor." order by utime desc LIMIT ".$limit1.", ".$limit2) as $row) {
        $erg = substr($row[1],0,6);
        $ut = $row[2];
        print "<tr><td>$row[0]</td><td><input id='$ut' value='".$erg."' size=4></td>".
              "<td><button onclick='upd_ds($sensor,$ut);'>ändern</button><button onclick='del_ds($sensor,$ut,$page);'>löschen</button></td></tr>\n";
    }
    print "<tr><td colspan=3><center>Gehe zu Seite: <input id='to_page' size=6></input><button  onclick='goto_page($sensor);'>Go</button></center></td></tr>".
          "<tr><td colspan=3><center><button class='button' onclick='show_list();'>Zurück zur Übersicht</button></center></td></tr>\n".
          "</table>&nbsp;</center></td>\n<td>".
          "<a href='#' onclick='show_detail($sensor,$nextpage);'><img src='/img/arrow_right.gif' height='100' width='40'></a>".
          "</td></tr></table>&nbsp;</center>";
}
?>
