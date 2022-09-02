<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$rf24hub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

#######################
#
# Nodes auflisten
#
#######################
foreach ($rf24hub_db->query(" select node_id, node_name, add_info, volt_lv, lv_flag from node where html_show = 'y' order by html_order ") as $row_node) {
    $mynode="'".$row_node[0]."'";					   
    $mynodeid=$row_node[0];
    $volt_lv=$row_node[3];
    if ($row_node[4]) $lv_flag=$row_node[4][0]; else $lv_flag="n";
    $myage = 100000;
    if ( $row_node[4] == "n" ) { $bgcolor = "#fefe04";  } else { $bgcolor = "#119911"; }
    foreach ($rf24hub_db->query("select ifnull(unix_timestamp() - last_utime, 100000) from sensor_im where sensor_id in (select sensor_id from sensor where node_id = ".$mynode." ) limit 1") as $node_age ) {
        $myage = $node_age[0]+1;
    }
    if ( $myage > 70000 ) { $bgcolor = "#991111"; } else {$bgcolor = "#119911"; }
    if ( $lv_flag == "y" ) { $bgcolor = "#fefe04"; }
/*    if ( $mynodeid < 10 ) {
	print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
		"<li class='ui-li-divider ui-first-child' data-role='list-divider' role='heading' style='background: ".$bgcolor."; color: white;'></li>".
		"<li><a id='n".$row_node[0]."' class='ui-btn' data-theme='a' ".
		" href='#' onclick=nothing(); ".
		" data-rel='popup' style='background: #666666; color: black; ' ><center>".$row_node[1]."(".$row_node[0].")</center></li>";	
    } else {*/
	print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
		"<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' style='background: ".$bgcolor."; color: white;'></li>".
		"<li><a id='n".$row_node[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
		" href='#' onclick=editnode(".$mynode."); ".
		" data-rel='popup' style='background: #666666; color: black; ' ><center>".$row_node[1]."(".$row_node[0].")</center></a></li>";	
//    }    
    foreach ($rf24hub_db->query("select Sensor_id, Sensor_name ".
	                              " from sensor where node_id = '$row_node[0]' and html_show = 'y' order by html_order asc ") as $row_sensor) {
        print "<a id='ss".$row_sensor[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
              " href='#' onclick='showsensor(".$row_sensor[0].");' ".
              " data-rel='popup' style='background: #AAAAAA; color: white;' >".$row_sensor[1]."(".$row_sensor[0].")</a>";
	}	  
    print "<li class='ui-li-divider ui-bar-inherit ui-last-child' data-role='list-divider' role='heading' style='background: ".$bgcolor."; color: white;'></li></ul>";
}
#######################
#
# Nodes editieren (ein- oder ausblenden)
#
#######################
print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
      "<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' ".
      "style='background: #111111; color: white;'></li>".
	  "<li><a id='n0' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	  " href='#' onclick=newnode(); ".
	  " data-rel='popup' style='background: #666666; color: black; ' ><center>Nodes editieren</center></a>".
	  "<div ID='dn0' style='background: #AAAAAA; color: black; display: none;'>";
foreach ($rf24hub_db->query("select node_id, node_name, html_show from node order by node_id") as $row_node1) {
    print "<a id='na".$row_node1[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
          " href='#' onclick=\"editnode('".$row_node1[0]."');\" ".
          " data-rel='popup' style='background: #AAAAAA; color: white;'> (".$row_node1[0].") ".$row_node1[1]."</a>";
    }
    print  "<center><table><tr><td colspan=2>Neuen Node anlegen:</td></tr>".
           "<tr><td width=200>NodeID:</td><td width=300><select id='in_nid_0' >";
    foreach ($rf24hub_db->query(" select number from numbers where number < 251 and number not in ( select node_id from node) ") as $node_row) {
	print "<option value=".$node_row[0]." selected>".$node_row[0]."</option>";
    }
print "</select></td></tr>".
	  "<tr><td width=200>Nodename:</td><td width=300><input size=30 id='in_nn_0' ></td></tr>".
	  "<tr><td width=200>Nodeinfo:</td><td width=300><textarea id='in_ni_0' rows=4 cols=30></textarea></td></tr>".
	  "<tr><td width=200>Battery:</td><td width=300><select id='in_bid_0'>";
	foreach ($rf24hub_db->query(" select battery_id, battery_sel_txt from battery ") as $bat_row) {
		print "<option value=".$bat_row[0]." selected>".$bat_row[1]."</option>";
	} 				  
print "</select></td></tr>".	  
	  "</table><button class='ui-btn' onclick=\"savenewnode('0')\">Werte speichern</button></center></div>".
      "<li class='ui-li-divider ui-bar-inherit ui-last-child' data-role='list-divider' role='heading'></li></ul>";	

#######################
#
# Sensoren editieren
#
#######################
print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
      "<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' ".
	  "style='background: #111111; color: white;'></li>".
	  "<li><a id='senshead' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	  " href='#' onclick=\"enablesensor();\" ".
	  " data-rel='popup' style='background: #666666; color: black; '><center>Sensoren editieren</center></a><div id='sensoren' style='display:none;'>";			  
foreach ($rf24hub_db->query("select sensor_id, sensor_name, add_info, node_id, channel, html_show, store_days, fhem_dev, html_order from sensor order by node_id, sensor_id") as $row_sensor) {
	print "<a id='sa".$row_sensor[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	      " href='#' onclick=\"editsensor('".$row_sensor[0]."');\" ".
	      " data-rel='popup' style='background: #AAAAAA; color: white;'> (".$row_sensor[0].") ".$row_sensor[1]." [".$row_sensor[3]."-".$row_sensor[4]."] </a>".
		  "<div id='se".$row_sensor[0]."' style='display:none;'><center><table>".
		  "<tr><td width=200>Sensornummer:</td><td width=300><input type=hidden id='is_sid_".$row_sensor[0]."'>".$row_sensor[0]."</td></tr>".
		  "<tr><td width=200>Sensorname:</td><td width=300><input size=25 id='is_sn_".$row_sensor[0]."' value='".$row_sensor[1]."'></td></tr>".
		  "<tr><td width=200>Sensorinfo:</td><td width=300><textarea id='is_si_".$row_sensor[0]."' height=175>".$row_sensor[2]."</textarea></td></tr>".		  
		  "<tr><td width=200>Node (ID):</td><td width=300><select id='is_nid_".$row_sensor[0]."'>";
	foreach ($rf24hub_db->query("select node_id, node_name from node where node_id = '".$row_sensor[3]."' ") as $rn) {
        print "<option value='".$rn[0]."' selected>".$rn[1]." (".$rn[0].")</option>";
	}		
	foreach ($rf24hub_db->query("select node_id, node_name from node where node_id != '".$row_sensor[3]."' ") as $rn) {
        print "<option value='".$rn[0]."'>".$rn[1]." (".$rn[0].")</option>";
	}		
    print "</select></td></tr>".
	      "<tr><td width=200>Channel:</td><td width=300><input size=6 id='is_ch_".$row_sensor[0]."' value='".$row_sensor[4]."'></td></tr>".
	      "<tr><td width=200>In Auflistung:</td><td width=300><select id='is_sh_".$row_sensor[0]."' >";
	if ( $row_sensor[5] == "y" ) {
		print "<option value='y' selected>anzeigen</option><option value='n'>nicht anzeigen</option>";
	} else {
		print "<option value='y'>anzeigen</option><option value='n' selected>nicht anzeigen</option>";
	}
	print "</select></td></tr>".
		  "<tr><td width=200>Sortierung:</td><td width=300><input size=25 id='is_so_".$row_sensor[0]."' value='".$row_sensor[8]."'></td></tr>".
		  "<tr><td width=200>Device FHEM:</td><td width=300><input size=25 id='is_fh_".$row_sensor[0]."' value='".$row_sensor[7]."'></td></tr>".
		  "<tr><td width=200>Speicherdauer:</td><td width=300><input size=10 id='is_sd_".$row_sensor[0]."' value='".$row_sensor[6]."'></td></tr>".	
		  "</table><button class='ui-btn' onclick='savesensor(".$row_sensor[0].")'>Werte speichern</button></center></div>";
}	
print "<a class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
      " href='#' onclick=\"$('#sen').toggle();\" ".
      " data-rel='popup' style='background: #AAAAAA; color: white;'>Neuer Sensor</a>".
	  "<div id='sen' style='display:none;'><center><table>".
	  "<tr><td width=200>Sensornummer:</td><td width=300><select id='is_sid_0'>";
foreach ($rf24hub_db->query("select number from numbers where number < 2000 and number not in (select sensor_id from sensor) order by number desc ") as $sens) {
    print "<option value='".$sens[0]."'>".$sens[0]."</option>";
}		
print "</select></td></tr>".
	  "<tr><td width=200>Sensorname:</td><td width=300><input size=25 id='is_sn_0'></td></tr>".
	  "<tr><td width=200>Sensorinfo:</td><td width=300><textarea id='is_si_0'></textarea></td></tr>".
	  "<tr><td width=200>Node_ID:</td><td width=300><select id='is_nid_0'>";
foreach ($rf24hub_db->query("select node_id, node_name from node ") as $rn) {
    print "<option value='".$rn[0]."'>".$rn[1]." (".$rn[0].")</option>";
}		
print "</select></td></tr>".
	  "<tr><td width=200>Channel:</td><td width=300><input size=6 id='is_ch_0'></td></tr>".
      "<tr><td width=200>In Auflistung:</td><td width=300><select id='is_sh_0' ><option value='y' selected>anzeigen</option><option value='n'>nicht anzeigen</option></select></td></tr>".
      "<tr><td width=200>Sortierung:</td><td width=300><input size=25 id='is_so_0' value='1'></td></tr>".
      "<tr><td width=200>Device FHEM:</td><td width=300><input size=25 id='is_fh_0' value=''></td></tr>".
      "<tr><td width=200>Speicherdauer:</td><td width=300><input size=10 id='is_sd_0' value='-1'></td></tr>".	
	  "</table><button class='ui-btn' onclick='savesensor(0)'>Werte speichern</button></center></div>".
	  "</div><li class='ui-li-divider ui-bar-inherit ui-last-child' data-role='list-divider' role='heading'></li></ul>";	
	
#######################
#
# offene Jobs auflisten
#
#######################
print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
      "<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' ".
	  "style='background: #111111; color: white;'></li>".
	  "<li><a id='jobshead' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	  " href='#' onclick=\"listjobs();\" ".
	  " data-rel='popup' style='background: #666666; color: black; '><center>offene Jobs</center></a><div id='jobs' style='display:none;'></div>";			  
print "<li class='ui-li-divider ui-bar-inherit ui-last-child' data-role='list-divider' role='heading'></li></ul>";	

