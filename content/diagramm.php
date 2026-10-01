<?php // content="text/plain; charset=utf-8"
/* Generisches Diagramm, folgende Anwendungsmöglichkeiten sind eingebaut:
 * 1) Liniendiagramm:
 * Folgende Parameter müssen gesetzt werden:
 *   sensor1=<sensornummer>
 *   graph=line
 * 2) Balkendiagramm (Balken von 0 bis X)
 * Folgende Parameter müssen gesetzt werden:
 *   sensor1=<sensornummer>
 *   graph=bar
 *   sum=<y|n>  //Zeigt die Summe aller Balken an
 * Optional können weitere Sensoren dargestellt werden:
 *   sensor2=<sensornummer>
 *   sensor3=<sensornummer>
 * 3) Balkendiagramm (Balken von X bis Y)
 * Folgende Parameter müssen gesetzt werden:
 *   sensor1=<sensornummer>
 *   graph=rbar
 *
 */
$instance="test";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_utils.inc.php');
//Default settings
date_default_timezone_set('Europe/Berlin');
$monate = array(1=>"Januar", 2=>"Februar", 3=>"M&auml;rz", 4=>"April", 5=>"Mai", 6=>"Juni",7=>"Juli", 8=>"August", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Dezember");
// Default Parameters
$mindata = 10;
$range = "1d";
$sizex=650;
$sizey=370;
$database = "datahub";
$gtype = "line";
$offset = 0;
$ymin_set = false;
$ymax_set = false;
$starttime = 0;
$endtime = time();
$show_sum = false;
$ymin = 0;
//sensor1
$sensor1_used = false;
$sensor1name = "unbekannt";
$sensor1name_used = false;
$sensor1unit = "";
$sensor1unit_used = false;
$sensor1color = "#000000";
//sensor2
$sensor2_used = false;
$sensor2name = "unbekannt";
$sensor2name_used = false;
$sensor2unit = "";
$sensor2unit_used = false;
$sensor2color = "#00ffff";
//sensor3
$sensor3_used = false;
$sensor3name = "unbekannt";
$sensor3name_used = false;
$sensor3unit = "";
$sensor3unit_used = false;
$sensor3color = "#00ff00";

function mk_dia_time($my_offset, $my_range) {
    function mk_ts_by_year($my_year, $offset, $period) {
      $erg_year = $my_year - ($offset * $period);
      return strtotime('1/1/'.$erg_year);
    }
    function mk_ts_by_month($my_year, $my_month, $offset, $period) {
      $my_sum = (($my_year * 12) + $my_month) - ($offset * $period);
      $erg_year = intdiv($my_sum, 12);
      $erg_month = $my_sum - ($erg_year * 12);
      if ($erg_month == 0) {
          $erg_year--;
          $erg_month = 12;
      }
#      error_log("Sum: ".$my_sum." Year: ".$erg_year." Month: ".$erg_month);
      return strtotime($erg_month.'/1/'.$erg_year);
    }
    global $starttime, $endtime;
    $akttime = time();
    $aktyear = gmdate("Y", $akttime);
    $aktmonth = gmdate("m", $akttime);
    $aktday = gmdate("d", $akttime);
    $startyear = $aktyear;
    $startmonth = $aktmonth;
    $startday = $aktday;
    $endyear = $aktyear;
    $endmonth = $aktmonth;
    $endday = $aktday;
    if ( $my_offset == 0 ) {
      $endtime = $akttime;
      switch ($my_range) {
		case '10y':
            $starttime = $akttime - (86400*3650);
		break;
        case '5y':
            $starttime = $akttime - (86400*1825);
		break;
		case '2y':
            $starttime = $akttime - (86400*730);
		break;
		case '1y':
            $starttime = $akttime - (86400*365);
		break;
		case '6m':
            $starttime = $akttime - (86400*180);
        break;
		case '3m':
            $starttime = $akttime - (86400*90);
        break;
		case '1m':
            $starttime = $akttime - (86400*30);
		break;
		default:
            $starttime = $akttime - 86400;
        }
    } else {
      switch ($my_range) {
		case '10y':
            $starttime = mk_ts_by_year($startyear, $my_offset, 10);
            $endtime = mk_ts_by_year($startyear, $my_offset -1, 10);
        break;
        case '5y':
            $starttime = mk_ts_by_year($startyear, $my_offset, 5);
            $endtime = mk_ts_by_year($startyear, $my_offset -1, 5);
        break;
		case '2y':
            $starttime = mk_ts_by_year($startyear, $my_offset, 2);
            $endtime = mk_ts_by_year($startyear, $my_offset -1, 2);
        break;
		case '1y':
            $starttime = mk_ts_by_year($startyear, $my_offset, 1);
            $endtime = mk_ts_by_year($startyear, $my_offset -1, 1);
        break;
		case '6m':
            $starttime = mk_ts_by_month($startyear, $startmonth, $my_offset, 6);
            $endtime = mk_ts_by_month($startyear, $startmonth, $my_offset -1, 6);
        break;
		case '3m':
            $starttime = mk_ts_by_month($startyear, $startmonth, $my_offset, 3);
            $endtime = mk_ts_by_month($startyear, $startmonth, $my_offset -1, 3);
        break;
		case '1m':
            $starttime = mk_ts_by_month($startyear, $startmonth, $my_offset, 1);
            $endtime = mk_ts_by_month($startyear, $startmonth, $my_offset -1, 1);
        break;
        default:
            $starttime = strtotime($startmonth.'/'.$startday.'/'.$startyear) - ($my_offset * 24 * 60 * 60);
            $endtime = $starttime + (24 * 60 * 60);
        break;
      }
	}
}	

if (isset($_GET["graph"])) {
	$gtype = $_GET["graph"];
}	
if (isset($_GET["sizex"])) {
	$sizex = $_GET["sizex"];
    if ($sizex > 1200) { $sizex = 1200; }
}
if (isset($_GET["sizey"])) {
	$sizey = $_GET["sizey"];
}	
if (isset($_GET["database"])) {
    $database = $_GET["database"];
}
if (isset($_GET["sensor1"])) {
    $sensor1 = $_GET["sensor1"];
    $sensor1_used = true;
}
if (isset($_GET["sensor1color"])) {
    $sensor1color = "#".$_GET["sensor1color"];
}
if (isset($_GET["sensor1name"])) {
    $sensor1name = $_GET["sensor1name"];
    $sensor1name_used = true;
}
if (isset($_GET["sensor1unit"])) {
    $sensor1unit = $_GET["sensor1unit"];
    $sensor1unit_used = true;
}
if (isset($_GET["sensor2"])) {
    $sensor2 = $_GET["sensor2"];
    $sensor2_used = true;
}
if (isset($_GET["sensor2color"])) {
    $sensor2color = "#".$_GET["sensor2color"];
}
if (isset($_GET["sensor2name"])) {
    $sensor2name = $_GET["sensor2name"];
    $sensor2name_used = true;
}
if (isset($_GET["sensor2unit"])) {
    $sensor2unit = $_GET["sensor2unit"];
    $sensor2unit_used = true;
}
if (isset($_GET["sensor3"])) {
    $sensor3 = $_GET["sensor3"];
    $sensor3_used = true;
}
if (isset($_GET["sensor3color"])) {
    $sensor3color = "#".$_GET["sensor3color"];
}
if (isset($_GET["sensor3name"])) {
    $sensor3name = $_GET["sensor3name"];
    $sensor3name_used = true;
}
if (isset($_GET["sensor3unit"])) {
    $sensor3unit = $_GET["sensor3unit"];
    $sensor3unit_used = true;
}
if (isset($_GET["offset"])) {
    $offset = $_GET["offset"];
}
if (isset($_GET["ymin"])) {
    $ymin = $_GET["ymin"];
    $ymin_set = true;
}
if (isset($_GET["ymax"])) {
    $ymax = $_GET["ymax"];
    $ymax_set = true;
}
if (isset($_GET["sum"])) {
    $show_sum = $_GET["sum"];
    $show_sum = true;
}
if (isset($_GET["range"])) {
    $range = $_GET["range"];
}

mk_dia_time($offset, $range);
#Starttag für Label ermitteln

switch ($range) {
    case '10y':
    case '5y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalenderjahr ->';
	$table = $sensordata_agg_tab;
	$minData = 100;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf der letzten 10 Jahre';
	} else {
      $label_1 = 'Verlauf seit '.date("Y", $starttime);
    }
    $date_str = 'Y';
    break;
    case '2y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendermonat ->';
	$table = $sensordata_agg_tab;
	$minData = 100;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf der letzten 2 Jahre';
	} else {
      $label_1 = 'Verlauf seit '.date("Y", $starttime);
    }
    $date_str = 'Y';
    break;
    case '1y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendermonat ->';
	$table = $sensordata_agg_tab;
	$minData = 100;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf des letzten Jahres';
	} else {
      $label_1 = 'Verlauf im Jahr '.date("Y", $starttime);
	}
    $date_str = 'M';
    break;
    case '6m':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendermonat ->';
	$table = $sensordata_agg_tab;
	$minData = 100;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf der letzten 180 Tage';
	} else {
      $monat = intval(date("m", $starttime));
      $label_1 = 'Verlauf seit Monat '.$monate[$monat]." ".date("Y", $starttime);
    }
    break;
    case '3m':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendertag ->';
	$table = $sensordata_agg_tab;
	$minData = 50;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf der letzten 90 Tage';
	} else {
      $monat = intval(date("m", $starttime));
      $label_1 = 'Verlauf seit Monat '.$monate[$monat]." ".date("Y", $starttime);
	}
    break;
    case '1m':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendertag ->';
    if ( $gtype == "line" )	$table = $sensordata_tab;
    if ( $gtype == "bar" || $gtype == "rbar" || $gtype == "mbar" )	$table = $sensordata_agg_tab;
	$minData = 2;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf der letzten 30 Tage';
	} else {
      $monat = intval(date("m", $starttime));
      $label_1 = 'Verlauf im Monat '.$monate[$monat]." ".date("Y", $starttime);
    }
    $date_str = 'd';
    break;
    default:
	$label_date_format = '%d.%m.%y %H:%i'; 
	if ($sizey > 100) $label_2 = " Uhrzeit ->";
	$table = $sensordata_tab;
	$minData = 5;
    if ( $offset == 0 ) {
      $label_1 = 'Verlauf der letzten 24 Stunden';
    } else {
      $label_1 = 'Verlauf am '.date("d.m.Y", $starttime);
    }
    $date_str = 'H';
}

// Connnect to database
if (strcmp($database,"rf24hub")==0)
     $db = new mysqli($db_sh_server, $db_sh_user, $db_sh_pass, $database);
if (strcmp($database,"datahub")==0)
     $db = new mysqli($db_dh_server, $db_dh_user, $db_dh_pass, $database);


if ($sensor1_used) {
  $x1data = array();
  $y1data = array();
  $last_utime=0;
  $minTickPos=array();
  $tickPos=array();
  $firstOfHour=0;
  $label_alt = date($date_str , $starttime-1000);
  $rowcount = 0;
  $mtickscount = 0;
  if ( $gtype == "rbar" ) {
    $stmt1 = " select min(value) as lval, max(value) as hval, UNIX_TIMESTAMP(FROM_UNIXTIME(utime,'%Y%m%d')) as ut from ".$table." where sensor_id = ".$sensor1." and utime >= ".$starttime." and utime < ".$endtime."-10 group by UNIX_TIMESTAMP(FROM_UNIXTIME(utime,'%Y%m%d')) order by UNIX_TIMESTAMP(FROM_UNIXTIME(utime,'%Y%m%d')) asc";
  } else {
    $stmt1 = " select value, utime as ut from ".$table." where sensor_id = ".$sensor1." and utime >= ".$starttime." and utime < ".$endtime."-10 order by utime asc";
  }
//  error_log($stmt1);
  $results1 = $db->query($stmt1);
  while ($row1 = $results1->fetch_assoc()) {
    if ( $gtype == "rbar" ) {
      $y1data[]=$row1['lval'];
      $y1data1[]=$row1['hval'];
    } else {
      $y1data[]=$row1['value'];
    }
    $label = date($date_str, $row1['ut']);
    if ( $label != $label_alt ) {
//      if ( $mtickscount == 0 ) {
        $labels[] = $label;
        $majorTicks[] = $rowcount;
//      }
//      $mtickscount++;
//      if ( $mtickscount > $skiplabels) $mtickscount = 0;
    }
    $label_alt = $label;
    $rowcount++;
  }
  $results1->close();
}

if ($sensor2_used) {
  $x2data = array();
  $y2data = array();
  $stmt2 = " select value, utime as ut from ".$table." where sensor_id = ".$sensor2." and utime >= ".$starttime." and utime < ".$endtime."-10 order by utime asc";
  $results2 = $db->query($stmt2);
  while ($row2 = $results2->fetch_assoc()) {
    $y2data[]=$row2['value'];
    $x2data[]=$row2['ut'];
  }
  $results2->close();
}

if ($sensor3_used) {
  $x3data = array();
  $y3data = array();
  $stmt3 = " select value, utime as ut from ".$table." where sensor_id = ".$sensor3." and utime >= ".$starttime." and utime < ".$endtime."-10 order by utime asc";
  $results3 = $db->query($stmt3);
  while ($row3 = $results3->fetch_assoc()) {
    $y3data[]=$row3['value'];
    $x3data[]=$row3['ut'];
  }
  $results3->close();
}

if ($show_sum == "y") {
  if ( $sensor1_used ) {
    $stmt = " select sum(value) as mysum from ".$table." where sensor_id = ".$sensor1." and utime >= ".$starttime." and utime < ".$endtime;
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $sum1 = round($row['mysum']*10)/10;
    $results->close();
  }
  if ( $sensor2_used ) {
    $stmt = " select sum(value) as mysum from ".$table." where sensor_id = ".$sensor2." and utime >= ".$starttime." and utime < ".$endtime;
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $sum2 = round($row['mysum']*10)/10;
    $results->close();
  }
  if ( $sensor3_used ) {
    $stmt = " select sum(value) as mysum from ".$table." where sensor_id = ".$sensor3." and utime >= ".$starttime." and utime < ".$endtime;
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $sum3 = round($row['mysum']*10)/10;
    $results->close();
  }
}

$db->close();

$graph = new Graph($sizex, $sizey);
if ($sizey > 100) {
    $graph->SetMargin(50,20,0,0);
} else {
    $graph->SetMargin(30,20,0,0);
}
$graph->title->Set($label_1);
if (count($y1data) < $minData ) {
  $graph->SetScale('intlin',0,1,0,1);
  $dummy1data=array();
  $dummy1data[]=0;
  $line = new LinePlot($dummy1data,$dummy1data);
  $line->SetLegend("No valid Data");
  $graph->Add($line);
  $graph->legend->SetFrameWeight(2);
  $graph->legend->SetShadow();
  $graph->legend->SetColor('darkred');
  $graph->legend->SetFillColor('lightyellow');
} else {
  if ( $gtype != "rbar" ) {
    $yall = array();
    if ( $sensor1_used ) $yall = array_merge($yall,$y1data);
    if ( $sensor2_used ) $yall = array_merge($yall,$y2data);
    if ( $sensor3_used ) $yall = array_merge($yall,$y3data);
    $yall_max = max($yall);
    $yall_min = min($yall);
  }
  if ( $ymin_set ) {
    $dia_ymin = $ymin;
  } else {
    if ( $gtype == "rbar" ) {
      $dia_ymin = 0; //  max($y1data);
    } else {
      if ( $yall_min > 0 ) {
        if ($yall_min < 200 ) {
          $dia_ymin = floor($yall_min/10)*10;
        } else {
          $dia_ymin = floor($yall_min/100)*100;
        }
      } else {
        if ($yall_min > -200 ) {
          $dia_ymin = floor($yall_min/10)*10;
        } else {
          $dia_ymin = floor($yall_min/100)*100;
        }
      }
    }
  }
  if ( $ymax_set ) {
    $dia_ymax = $ymax;
  } else {
    if ( $gtype == "rbar" ) {
      $dia_ymax = 100;  //max($y1data1);
    } else {
      if ( $yall_max > 0 ) {
        if ( $yall_max < 10 ) {
          $dia_ymax = ceil($yall_max);
        } else if ( $yall_max < 200 ) {
          $dia_ymax = ceil($yall_max/10)*10;
        } else {
          $dia_ymax = ceil($yall_max/100)*100;
        }
      } else {
        if ( $yall_max > -10 ) {
          $dia_ymax = ceil($yall_max);
        } else if ( $yall_max > -200) {
          $dia_ymax = ceil($yall_max/10)*10;
        } else {
          $dia_ymax = ceil($yall_max/100)*100;
        }
      }
    }
  }
  $graph->SetScale('textlin',$dia_ymin,$dia_ymax);
  $graph->xgrid->Show(true);
  $graph->xgrid->SetColor('lightgray');
  $graph->xgrid->SetLineStyle('dotted');
  $graph->xaxis->SetTickPositions($majorTicks, NULL, $labels);
  if ( $gtype == "line" ) {
    $line = new LinePlot($y1data);
    $graph->Add($line);
    $line->SetColor($sensor1color);
    if ($sensor1name_used) $line->SetLegend($sensor1name);
  }
  if ( $gtype == "bar" ) {
    $gbar = array();
    $text = "";
    if ( $sensor1_used ) {
      $bar1 = new BarPlot($y1data);
      if ( $show_sum or $sensor1unit_used or $sensor1name_used ) {
        if ( $sensor1name_used ) $text = $sensor1name;
        if ( $show_sum ) $text = $text . " Summe: " . $sum1;
        if ( $sensor1unit_used ) $text = $text . " " . $sensor1unit;
        $bar1->SetLegend($text);
      }
      $gbar[] = $bar1;
    }
    if ( $sensor2_used ) {
      $bar2 = new BarPlot($y2data);
      if ( $show_sum or $sensor2unit_used or $sensor2name_used ) {
        if ( $sensor2name_used ) $text = $sensor2name;
        if ( $show_sum ) $text = $text . " Summe: " . $sum2;
        if ( $sensor2unit_used ) $text = $text . " " . $sensor2unit;
        $bar2->SetLegend($text);
      }
      $gbar[] = $bar2;
    }
    if ( $sensor3_used ) {
      $bar3 = new BarPlot($y3data);
      if ( $show_sum or $sensor3unit_used or $sensor3name_used ) {
        if ( $sensor3name_used ) $text = $sensor3name;
        if ( $show_sum ) $text = $text . " Summe: " . $sum3;
        if ( $sensor3unit_used ) $text = $text . " " . $sensor3unit;
        $bar3->SetLegend($text);
      }
      $gbar[] = $bar3;
    }
    $gbplot = new GroupBarPlot($gbar);
    $graph->Add($gbplot);
  }
  if ( $gtype == "rbar" ) {
    // Der Basis-Plot (wird unsichtbar gemacht)
    $bplot_min = new BarPlot($y1data);
    // Der Spannen-Plot (der sichtbare Balken)
    $bplot_max = new BarPlot($y1data1);
    // Dem Graphen hinzufügen und anzeigen: Erst die Spa
    $graph->Add($bplot_max);
    $graph->Add($bplot_min);
    $bplot_min->SetFillColor('white');  // Farbe des Hintergrunds wählen
    $bplot_min->SetColor('white');      // Rahmenlinie ebenfalls weiß
    $bplot_max->SetFillColor($sensor1color);
    $bplot_max->SetColor($sensor1color);
  }
  if ($sensor1unit_used) {
    $graph->yaxis->title->Set("-> ".$sensor1unit);
  }
  $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
  $graph->yaxis->SetTitleMargin(30);
  $graph->xaxis->title->Set($label_2);
  $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
  $graph->xaxis->SetLabelAlign('left', 'top');
  $graph->xaxis->SetTitleMargin(100);
  if ($sizex < 500 ) {
      $graph->xaxis->SetTextLabelInterval(2);
  }
  if ($sizey > 100) {
    $graph->legend->SetAbsPos(80,20,'left','top');
  } else {
    $graph->legend->SetAbsPos(20,2,'left','top');
  }
  $graph->legend->SetFrameWeight(2);
  $graph->legend->SetShadow();
  $graph->legend->SetColor('darkgreen');
  $graph->legend->SetFillColor('lightyellow');
}
$graph->xaxis->SetPos('min');
# Achtung: Folgende Zeile verhindert Abstand unter Grafik !!!
$graph->graph_theme=null;
$graph->SetMarginColor('#dddddd');
$graph->SetFrame(true,'#dddddd', 0);
$graph->Stroke();
 
?>
