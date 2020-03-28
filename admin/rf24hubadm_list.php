<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$sensorhub_db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);

function node_details($db,$node) {
	print "<div ID=dn".$node." style='background: #AAAAAA; color: black; display: none;'>";
	$sql = " select node_id, node_name, add_info, battery_id, heartbeat from node where node_id = '".$node."' ";
	foreach ( $db->query($sql) as $row) { 
		print "<center><table border=0>".
			  "<tr><td width=150>Nodename:</td><td width=350 colspan=2><input type='hidden' id='in_nid_".$node."' value='".$node."'><input size=30 id='in_nn_".$node."' value='".$row[1]."'></td></tr>".
			  "<tr><td width=200>Nodeinfo:</td><td width=350 colspan=2><textarea id='in_ni_".$node."' rows=4 cols=30>".$row[2]."</textarea></td></tr>".
			  "<tr><td width=200>Battery:</td><td width=350 colspan=2><center>&nbsp;<select id='in_bid_".$node."'>";
		foreach ($db->query(" select battery_id, battery_sel_txt from battery where battery_id = '".$row[3]."' ") as $bat_row) { 
				print "<option value=".$bat_row[0]." selected>".$bat_row[1]."</option>";
			} 				  
		foreach ($db->query(" select battery_id, battery_sel_txt from battery where battery_id != '".$row[3]."' ") as $bat_row) { 
				print "<option value=".$bat_row[0].">".$bat_row[1]."</option>";
			} 				  
		print "</select>&nbsp;</center></td></tr>".
			  "<tr><td width=200>Heartbeat:</td><td width=350 colspan=2><center>&nbsp;<select id='in_hb_".$node."'>";
        if ($row[4] == "y") {
            print "<option value='y' selected>yes</option>".
                  "<option value='n'>no</option>";
        } else {
            print "<option value='y'>yes</option>".
                  "<option value='n' selected>no</option>";
        }            
        print "</select>&nbsp;</center></td></tr>";	  
	}
	$value111 = "";
	$value114 = "";
	$value116 = "";
	$value117 = "";
	$stmt = " select channel, value from node_config_v where node_id = '".$node."' ";
	foreach ($db->query(" select channel, value from node_config_v where node_id = '".$node."' ") as $conf_row) { 
		if ($conf_row[0] == "111") { $value111 = $conf_row[1]; }
		if ($conf_row[0] == "114") { $value114 = $conf_row[1]; }
		if ($conf_row[0] == "116") { $value116 = $conf_row[1]; }
		if ($conf_row[0] == "117") { $value117 = $conf_row[1]; }
	} 				  
	print "<tr><td width=200>voltagefactor:</td><td width=100><input size=8 id='in_vf_".$node."' value='".$value116."'></td>".
          "<td><button class='ui-btn' onclick=\"send_vf('$node')\">Wert setzen</button></td></tr>".
	      "<tr><td width=200>voltageadded:</td><td width=100><input size=8 id='in_va_".$node."' value='".$value117."'></td>".
          "<td><button class='ui-btn' onclick=\"send_va('$node')\">Wert setzen</button></td></tr>".
	      "<tr><td width=200>sleeptime:</td><td width=100><input size=8 id='in_st_".$node."' value='".$value111."'></td>".
          "<td><button class='ui-btn' onclick=\"send_st('$node')\">Wert setzen</button></td></tr>".
	      "<tr><td width=200>emptyloopcount:</td><td width=100><input size=8 id='in_el_".$node."' value='".$value114."'></td>".
          "<td><button class='ui-btn' onclick=\"send_el('$node')\">Wert setzen</button></td></tr>".
	      "</table><button class='ui-btn' onclick=\"savenode('$node')\">Werte speichern</button></center></div>";
}
#######################
#
# Nodes auflisten
#
#######################
foreach ($sensorhub_db->query(" select node_id, node_name, add_info from node where html_show = 'y' ".
						   " order by html_sort ") as $row_node) { 
    $mynode="'".$row_node[0]."'";					   
    print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
          "<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' ";
    foreach ($sensorhub_db->query("select unix_timestamp() - max(utime) from sensordata ".
                                  "where sensor_id in (select sensor_id from sensor where node_id = ".$mynode.")") as $node_age ) {
        $myage = $node_age[0]+1;
        if ( $myage > 70000 ) { 
            print "style='background: #991111; color: white;'></li>";
        } else {
            print "style='background: #119911; color: white;'></li>";
        }
    }
    print "<li><a id='n".$row_node[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	  " href='#' onclick=editnode(".$mynode."); ".
	  " data-rel='popup' style='background: #666666; color: black; ' ><center>".$row_node[1]."(".$row_node[0].")</center></a>";	
    node_details($sensorhub_db, $row_node[0]);
    foreach ($sensorhub_db->query("select Sensor_id, Sensor_name ".
	                              " from sensor where node_id = '$row_node[0]' and html_show = 'y' order by html_sort asc ") as $row_sensor) {   
        print "<a id='ss".$row_sensor[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
              " href='#' onclick='showsensor(".$row_sensor[0].");' ".
              " data-rel='popup' style='background: #AAAAAA; color: white;' >".$row_sensor[1]."(".$row_sensor[0].")</a>";
	}	  
    print "<li class='ui-li-divider ui-bar-inherit ui-last-child' data-role='list-divider' role='heading'></li></ul>";	
}
#######################
#
# Neuen Node anlegen
#
#######################
print "<ul class='ui-listview ui-listview-inset ui-corner-all ui-shadow' data-inset='true' data-role='listview'>".
      "<li class='ui-li-divider ui-bar-inherit ui-first-child' data-role='list-divider' role='heading' ".
      "style='background: #111111; color: white;'></li>".
	  "<li><a id='n0' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	  " href='#' onclick=editnode(0); ".
	  " data-rel='popup' style='background: #666666; color: black; ' ><center>Neuen Node anlegen</center></a>".
	  "<div ID='dn0' style='background: #AAAAAA; color: black; display: none;'>".
	  "<center><table>".
	  "<tr><td width=200>NodeID:</td><td width=300><input size=30 id='in_nid_0' ></td></tr>".
	  "<tr><td width=200>Nodename:</td><td width=300><input size=30 id='in_nn_0' ></td></tr>".
	  "<tr><td width=200>Nodeinfo:</td><td width=300><textarea id='in_ni_0' rows=4 cols=30></textarea></td></tr>".
	  "<tr><td width=200>Battery:</td><td width=300><select id='in_bid_0'>";
	foreach ($sensorhub_db->query(" select battery_id, battery_sel_txt from battery ") as $bat_row) { 
		print "<option value=".$bat_row[0]." selected>".$bat_row[1]."</option>";
	} 				  
print "</select></td></tr>".	  
	  "</table><button class='ui-btn' onclick=\"savenode('0')\">Werte speichern</button></center></div>".
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
foreach ($sensorhub_db->query("select sensor_id, sensor_name, add_info, node_id, channel, html_show, store_days, fhem_dev, html_sort from sensor order by node_id, sensor_id") as $row_sensor) {   
	print "<a id='sa".$row_sensor[0]."' class='ui-btn ui-btn-icon-right ui-icon-carat-r ui-shadow' data-theme='a' ".
	      " href='#' onclick=\"editsensor('".$row_sensor[0]."');\" ".
	      " data-rel='popup' style='background: #AAAAAA; color: white;'> (".$row_sensor[0].") ".$row_sensor[1]." [".$row_sensor[3]."-".$row_sensor[4]."] </a>".
		  "<div id='se".$row_sensor[0]."' style='display:none;'><center><table>".
		  "<tr><td width=200>Sensornummer:</td><td width=300><input type=hidden id='is_sid_".$row_sensor[0]."'>".$row_sensor[0]."</td></tr>".
		  "<tr><td width=200>Sensorname:</td><td width=300><input size=25 id='is_sn_".$row_sensor[0]."' value='".$row_sensor[1]."'></td></tr>".
		  "<tr><td width=200>Sensorinfo:</td><td width=300><textarea id='is_si_".$row_sensor[0]."' height=175>".$row_sensor[2]."</textarea></td></tr>".		  
		  "<tr><td width=200>Node (ID):</td><td width=300><select id='is_nid_".$row_sensor[0]."'>";
	foreach ($sensorhub_db->query("select node_id, node_name from node where node_id = '".$row_sensor[3]."' ") as $rn) {
        print "<option value='".$rn[0]."' selected>".$rn[1]." (".$rn[0].")</option>";
	}		
	foreach ($sensorhub_db->query("select node_id, node_name from node where node_id != '".$row_sensor[3]."' ") as $rn) {
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
	  "<tr><td width=200>Sensornummer:</td><td width=300><input size=6 id='is_sid_0'></td></tr>".
	  "<tr><td width=200>Sensorname:</td><td width=300><input size=25 id='is_sn_0'></td></tr>".
	  "<tr><td width=200>Sensorinfo:</td><td width=300><textarea id='is_si_0'></textarea></td></tr>".
	  "<tr><td width=200>Node_ID:</td><td width=300><select id='is_nid_0'>";
foreach ($sensorhub_db->query("select node_id, node_name from node ") as $rn) {
    print "<option value='".$rn[0]."'>".$rn[1]." (".$rn[0].")</option>";
}		
print "</select></td></tr>".
	  "<tr><td width=200>Channel:</td><td width=300><input size=6 id='is_ch_0'></td></tr>".
	  "<tr><td width=200>Typ:</td><td width=300><select id='is_ty_0' >".
	  "<option value='s' selected>Sensor</option><option value='a'>Actor</option>".
      "</select></td></tr>".
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

