<?php // content="text/plain; charset=utf-8"
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_bar.php');
require_once ('jpgraph/jpgraph_utils.inc.php');
//Default settings
date_default_timezone_set('Europe/Berlin');
$mindata = 10;
$range = "1d";
$sizex=650;
$sizey=370;
$database = "rf24hub";
$gtype = "line";
//sensor1
$sensor1color = "#000000";
$sensor1legend = "unbekannt";
$sensor1 = 1;
$offset = 0;
$ymin_set = false;
$ymax_set = false;
$hasSensor1a = false;
$hasSensor1b = false;
//sensor2
$hasSecondGrah=false;
$sensor2 = 2;
$sensor2legend = "unbekannt";
$sensor2color = "#00ffff";
$y2min_set = false;
$y2max_set = false;

function set_title($input) {
    switch ($input) {
    case "Temperatur":
        $einheit="Grad C ->";
        break;
    case "Luftdruck":
        $einheit="hPa ->";
        break;
    case "Luftfeuchte":
        $einheit="% ->";
        break;
    case "Batterie":
        $einheit="V ->";
        break;
    case "Gasverbrauch":
        $einheit="KW ->";
        break;
    default:
        $einheit= " ";
    }
    return $einheit;
}

function mk_starttime($my_offset, $my_range) {
    $akttime=time();
    $year=intval(date("Y",$akttime));
    $mon=intval(date("n",$akttime));
    $day=intval(date("d",$akttime)); 
    if ( $my_offset == 0 ) {
        switch ($my_range) {
		case '10y':
            $retval = $akttime - (86400*3650);
		break;
        case '5y':
            $retval = $akttime - (86400*1825);
		break;
		case '2y':
            $retval = $akttime - (86400*730);
		break;
		case '1y':
            $retval = $akttime - (86400*365);
		break;
		case '6m':
            $retval = $akttime - (86400*180);
        break;    
		case '3m':
            $retval = $akttime - (86400*90);
        break;    
		case '1m':
            $retval = $akttime - (86400*30);
		break;
		default:
            $retval = $akttime - (86400);
        }
    } else {
        switch ($my_range) {
		case '10y':
            $year=$year-($my_offset*10);
            $retval = mktime(0, 0, 0, 1, 1, $year);
		break;
        case '5y':
            $year=$year-($my_offset*5);
            $retval = mktime(0, 0, 0, 1, 1, $year);
		break;
		case '2y':
            $year=$year-($my_offset*2);
            $retval = mktime(0, 0, 0, 1, 1, $year);
		break;
		case '1y':
            $year=$year-$my_offset;
            $retval = mktime(0, 0, 0, 1, 1, $year);
		break;
		case '6m':
		case '3m':
		case '1m':
            for($i=$my_offset;$i>0;$i--) {
                if ($mon > 1) {
                    $mon--;
                } else {
                    $year--;
                    $mon=12;
                }
            }
            $retval = mktime(0, 0, 0, $mon, 1, $year);
		break;
		default:
            $retval = strtotime(gmdate("Y-m-d", strtotime("- ".$my_offset." days")));
        }
	}
	return $retval;
}	

function  TimeCallbackY( $aVal) {
   return Date ('Y',$aVal);
}
function  TimeCallbackYM( $aVal) {
   return Date ('y/m',$aVal);
}
function  TimeCallbackM( $aVal) {
   return Date ('d.m',$aVal);
}
function  TimeCallbackD( $aVal) {
   return Date ('d',$aVal);
}
function  TimeCallbackH( $aVal) {
   return Date ('H',$aVal);
}


if (isset($_GET["graph"])) {
	$gtype = $_GET["graph"];
}	
if (isset($_GET["sizex"])) {
	$sizex = $_GET["sizex"];
}	
if ($sizex > 1200) { $sizex = 1200; }
if (isset($_GET["sizey"])) {
	$sizey = $_GET["sizey"];
}	
if (isset($_GET["database"])) {
    $database = $_GET["database"];
}
if (isset($_GET["sensor1color"])) {
    $sensor1color = "#".$_GET["sensor1color"];
}
if (isset($_GET["sensor1legend"])) {
    $sensor1legend = $_GET["sensor1legend"];
}
$einheit = set_title($sensor1legend);

if (isset($_GET["sensor1"])) {
    $sensor1 = $_GET["sensor1"];
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
if (isset($_GET["sensor1a"])) {
    $sensor1a = $_GET["sensor1a"];
    $hasSensor1a = true;
}
if (isset($_GET["sensor1alegend"])) {
    $sensor1alegend = $_GET["sensor1alegend"];
    $hassensor1legend = true;
} else {
    $hassensor1legend = false;
}
if (isset($_GET["sensor1b"])) {
    $sensor1b = $_GET["sensor1b"];
    $hasSensor1b = true;
}
if (isset($_GET["sensor1blegend"])) {
    $sensor1blegend = $_GET["sensor1blegend"];
}

if (isset($_GET["sensor2"])) {
    $sensor2 = $_GET["sensor2"];
    $hasSecondGrah = true;
}
if ($hasSecondGrah) {
    if (isset($_GET["sensor2legend"])) {
        $sensor2legend = $_GET["sensor2legend"];
    }
    if (isset($_GET["sensor2color"])) {
        $sensor2color = "#".$_GET["sensor2color"];
    }
    if (isset($_GET["sensor2legend"])) {
        $sensor2legend = $_GET["sensor2legend"];
    }
    if (isset($_GET["y2min"])) {
        $y2min = $_GET["y2min"];
        $y2min_set = true;
    }
    if (isset($_GET["y2max"])) {
        $y2max = $_GET["y2max"];
        $y2max_set = true;
    }
    $einheit2 = set_title($sensor2legend);
}
if (isset($_GET["range"])) $range = $_GET["range"];
//$by_range = True;
switch ($range) {
    case '10y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalenderjahr ->';
	$diagramtime = 315360000;
	$table = $sensordata_agg_tab;
	$minData = 100;
    break;
    case '5y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalenderjahr ->';
	$diagramtime = 157680000;
	$table = $sensordata_agg_tab;
	$minData = 100;
    break;
    case '2y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendermonat ->';
	$diagramtime = 63072000;
	$table = $sensordata_agg_tab;
	$minData = 100;
    break;
    case '1y':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendermonat ->';
	$diagramtime = 31536000;
	$table = $sensordata_agg_tab;
	$minData = 100;
    break;
    case '6m':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendermonat ->';
	$diagramtime = 16070400;
	$table = $sensordata_agg_tab;
	$minData = 100;
    break;
    case '3m':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendertag ->';
	$diagramtime = 8035200;
	$table = $sensordata_agg_tab;
	$minData = 50;
    break;
    case '1m':
	$label_date_format = '%d.%m.%y'; 
	$label_2 = ' Kalendertag ->';
	$diagramtime = 2678400;
    if ( $gtype == "line" )	$table = $sensordata_tab;
    if ( $gtype == "bar" || $gtype == "rbar" )	$table = $sensordata_agg_tab;
	$minData = 20;
    break;
    default:
	$label_date_format = '%d.%m.%y %H:%i'; 
	if ($sizey > 100) $label_2 = " Uhrzeit ->";
	$diagramtime = 86400;
	$table = $sensordata_tab;
	$minData = 5;
}

$xdata = array();
$ydata = array();
$monate = array(1=>"Januar", 2=>"Februar", 3=>"M&auml;rz", 4=>"April", 5=>"Mai", 6=>"Juni",7=>"Juli", 8=>"August", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Dezember");
if (strcmp($database,"rf24hub")==0) 
     $db = new mysqli($db_sh_server, $db_sh_user, $db_sh_pass, $database);
if (strcmp($database,"datahub")==0) 
     $db = new mysqli($db_dh_server, $db_dh_user, $db_dh_pass, $database);
$starttime = mk_starttime($offset, $range);
#Starttag für Label ermitteln
	switch ($range) {
		case '10y':
        case '5y':
		case '2y':
            $label_1 = 'Verlauf seit '.date("Y", $starttime); 
		break;
		case '1y':
		    if ( $offset == 0 ) {
                $label_1 = 'Verlauf des letzten Jahres'; 
			} else {
                $label_1 = 'Verlauf im Jahr '.date("Y", $starttime); 
			}
		break;
		case '6m':
		    if ( $offset == 0 ) {
                $label_1 = 'Verlauf der letzten 180 Tage'; 
			} else {
            $monat = intval(date("m", $starttime));
			$label_1 = 'Verlauf seit Monat '.$monate[$monat]." ".date("Y", $starttime); 
			}
		break;
		case '3m':
		    if ( $offset == 0 ) {
                $label_1 = 'Verlauf der letzten 90 Tage'; 
			} else {
             $monat = intval(date("m", $starttime));
			$label_1 = 'Verlauf seit Monat '.$monate[$monat]." ".date("Y", $starttime); 
			}
		break;
		case '1m':
		    if ( $offset == 0 ) {
                $label_1 = 'Verlauf der letzten 30 Tage'; 
			} else {
            $monat = intval(date("m", $starttime));
			$label_1 = 'Verlauf im Monat '.$monate[$monat]." ".date("Y", $starttime); 
			}
		break;
		default:
		    if ( $offset == 0 ) {
                $label_1 = 'Verlauf der letzten 24 Stunden'; 
			} else {
                $label_1 = 'Verlauf am '.date("d.m.Y", $starttime); 
			}
	}
if ( $gtype == "rbar" ) {
  $stmt = " select min(value) as lval, max(value) as hval, UNIX_TIMESTAMP(FROM_UNIXTIME(utime,'%Y%m%d')) as ut from ".$table." where sensor_id = ".$sensor1." and utime > ".$starttime." and utime < (".$starttime." + ".$diagramtime.") group by UNIX_TIMESTAMP(FROM_UNIXTIME(utime,'%Y%m%d')) order by UNIX_TIMESTAMP(FROM_UNIXTIME(utime,'%Y%m%d')) asc";
} else {
  $stmt = " select value, utime as ut from ".$table." where sensor_id = ".$sensor1." and utime > ".$starttime." and utime < (".$starttime." + ".$diagramtime.") order by utime asc";
}
error_log($stmt);
$results = $db->query($stmt);
$last_utime=0;
$minTickPos=array();
$tickPos=array();
$firstOfHour=0;
while ($row = $results->fetch_assoc()) {
if ( $gtype == "rbar" ) {
	$ydata[]=$row['hval'];
	$ydata1[]=$row['lval'];
} else {
	$ydata[]=$row['value'];
}
	$xdata[]=$row['ut'];
	if ($range == '1d') {
	    if ( count($minTickPos) == 0 ) { $minTickPos[] = $row['ut']; }
            if ( $last_utime > 0 and date('H',$row['ut']) <> date('H',$last_utime) ) {
                $tickPos[]=$row['ut'];
                $firstOfHour=1;
            } else {
                $firstOfHour=0;
            }
        $last_utime=$row['ut'];
   }
}
$results->close();
if ($hasSensor1a) {
    $yadata = array();
    $xadata = array();
    $stmt = " select value, utime from ".$table." where sensor_id = ".$sensor1a." and utime > ".$starttime." and utime < ".$starttime." + ".$diagramtime." order by utime asc";
    $results = $db->query($stmt);
    while ($row = $results->fetch_assoc()) {
        $yadata[]=$row['value'];
        $xadata[]=$row['utime'];
    }
    $results->close();
}
if ($hasSensor1b) {
    $ybdata = array();
    $xbdata = array();
    $stmt = " select value, utime from ".$table." where sensor_id = ".$sensor1b." and utime > ".$starttime." and utime < ".$starttime." + ".$diagramtime." order by utime asc";
    $results = $db->query($stmt);
    while ($row = $results->fetch_assoc()) {
        $ybdata[]=$row['value'];
        $xbdata[]=$row['utime'];
    }
    $results->close();
}

if ( $gtype == "bar" || $gtype == "rbar" ) {
  $max_utime = max($xdata);
  if ($range == "1m") {
    array_push($xdata, $max_utime + 24*60*60);
    array_push($ydata, 0);
    if ( $gtype == "rbar" ) array_push($ydata1, 0);
  }
}

if ($hasSecondGrah) {
  $y2data = array();
  $x2data = array();
  $stmt = " select value, utime from ".$table." where sensor_id = ".$sensor2." and utime > ".$starttime." and utime < ".$starttime." + ".$diagramtime." order by utime asc";
  $results = $db->query($stmt);
  $last_utime2=0;
  $minTickPos2=array();
  $tickPos2=array();
  $firstOfHour2=0;
  while ($row = $results->fetch_assoc()) {
	$y2data[]=$row['value'];
	$x2data[]=$row['utime'];
	if ($range == '1d') {
	    if ( count($minTickPos2) == 0 ) { $minTickPos2[] = $row['utime']; }
            if ( $last_utime2 > 0 and date('H',$row['utime']) <> date('H',$last_utime2) ) {
                $tickPos2[]=$row['utime'];
                $firstOfHour2=1;
            } else {
                $firstOfHour2=0;
            }
        $last_utime2=$row['utime'];
    }
  }
  $results->close();
}
$db->close();
$graph = new Graph($sizex, $sizey);
if ($hasSecondGrah) {
    $graph->SetMargin(50,50,0,0);
} else {
    if ($sizey > 100) {
        $graph->SetMargin(50,20,0,0);
    } else {
        $graph->SetMargin(30,20,0,0);
    }
}
$graph->title->Set($label_1);

if ($hasSecondGrah) {
  $secondGraphOK = ( count($y2data) > $mindata );
} else{
  $secondGraphOK = true;
}
if (count($ydata) < $minData and ! $secondGraphOK ) {
    $graph->SetScale('intlin',0,1,0,1);
    $dummydata=array();
    $dummydata[]=0;
    $line = new LinePlot($dummydata,$dummydata);
    $line->SetLegend("No valid Data");
    $graph->Add($line);
    $graph->legend->SetFrameWeight(2);
    $graph->legend->SetShadow();
    $graph->legend->SetColor('darkred');
    $graph->legend->SetFillColor('lightyellow');
} else {
    if ( $ymin_set and $ymax_set ) {
        $graph->SetScale('intlin',$ymin,$ymax,min($xdata),max($xdata));
    } else {
        if ( $gtype == "rbar" ) {
            $ydataMin=min($ydata1);
        } else {
            $ydataMin=min($ydata);
        }
        $ydataMax=max($ydata);
        $yscaleMin=$ydataMin;
        $yscaleMax=$ydataMax;
//  TODO Überarbeiten
//        if ( $y2dataMin >= 0 && $y2dataMax <= 1.1) {
//            $y2scaleMin = 0;
//            $y2scaleMax = 1.1;
//        } else
          if ($ydataMax > 0) {
            if ($ydataMax-$ydataMin > 5 ) {
//  TODO Überarbeiten
//                if ($ydataMin > 0) {
                    $yscaleMin=floor($ydataMin/10)*10;
//                } else {
//                    $yscaleMin=floor($ydataMin/10)*10;
//                }
                if ($ydataMax > 0) {
                    $yscaleMax=ceil($ydataMax/10)*10;
                } else {
                    $yscaleMax=ceil($ydataMax/10)*10;
                }
            } else {
                if ($ydataMin >= 0) {
                    $yscaleMin=floor($ydataMin);
                } else {
                    $yscaleMin=floor($ydataMin)-1;
                }
                if ($ydataMax > 0) {
                    $yscaleMax=floor($ydataMax)+1;
                } else {
                    $yscaleMax=floor($ydataMax);
                }
            }	
        } else {
            $yscaleMin=floor($ydataMin/10)*10;
            $yscaleMax=ceil($ydataMax/10)*10;
        }	
        $graph->SetScale('intlin',$yscaleMin,$yscaleMax,min($xdata),max($xdata));
    }
    if ($hasSecondGrah) {
        if ( $y2min_set and $y2max_set ) {
            $graph->SetY2Scale('lin',$ymin,$ymax);
        } else {
            $y2dataMin=min($y2data);
            $y2dataMax=max($y2data);
            if ($y2dataMax > 0) {
                if ($y2dataMax-$y2dataMin > 3 ) {
                    if ($y2dataMin > 0) {
                        $y2scaleMin=floor($y2dataMin/10)*10;
                    } else {
                        $y2scaleMin=floor($y2dataMin/10)*10;
                    }
                    if ($y2dataMax > 0) {
                        $y2scaleMax=ceil($y2dataMax/10)*10;
                    } else {
                        $y2scaleMax=ceil($y2dataMax/10)*10;
                    }
                } else {
                    if ($y2dataMin > 0) {
                        $y2scaleMin=floor($y2dataMin);
                    } else {
                        $y2scaleMin=floor($y2dataMin)-1;
                    }
                    if ($y2dataMax > 0) {
                        $y2scaleMax=floor($y2dataMax)+1;
                    } else {
                        $y2scaleMax=floor($y2dataMax);
                    }
                }
            } else {
                $y2scaleMin=floor($y2dataMin/10)*10;
                $y2scaleMax=ceil($y2dataMax/10)*10;
            }
            $graph->SetY2Scale('lin',$yscaleMin,$yscaleMax);
        }
    }
    $dateUtils = new DateScaleUtils();
    $graph->xaxis->SetColor('black','black');
    $graph->xgrid->Show();
    switch ($range) {
        case '10y':
        case '5y':
            $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackY'); 
            list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_YEAR1);
            $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
        break;
        case '2y':
            $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackM'); 
            list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_MONTH2);
            $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
        break;
        case '1y':
        case '6m':
            $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackM'); 
            list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_MONTH1);
            $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
        break;
        case '3m':
            $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackM'); 
            list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_WEEK1);
            $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
        break;
        case '1m':
            $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackD'); 
            list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_DAY1);
            $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
        break;
        default:
            $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackH'); 
            $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
    }
    if ($sizex < 500 ) {
        $graph->xaxis->SetTextLabelInterval(2);
    }
    $graph->xaxis->SetLabelAlign(1);
    $graph->xaxis->SetLabelSide(SIDE_BOTTOM);
    if ( $gtype == "line" ) {
        $line = new LinePlot($ydata,$xdata);
        $line->SetLegend($sensor1legend);
        $graph->Add($line);
        $line->SetColor($sensor1color);
    }
    if ( $gtype == "bar" ) {
        $bar = new BarPlot($ydata,$xdata);
        if ( $hassensor1legend ) {
          $bar->SetLegend($sensor1legend);
        }
        $bar->SetWidth(5);
        $graph->Add($bar);
        $bar->SetColor($sensor1color);
    }
    if ( $gtype == "rbar" ) {
        $bar = new BarPlot($ydata1,$xdata);
        $bar1 = new BarPlot($ydata,$xdata);
        if ( $hassensor1legend ) {
          $bar->SetLegend($sensor1legend);
        }
        $bar1->SetWidth(5);
        $graph->Add($bar1);
        $bar1->SetColor($sensor1color);
        $bar1->SetFillColor($sensor1color);
        $bar->SetWidth(5);
        $graph->Add($bar);
        $bar->SetFillColor("white");
        $bar->SetColor("white");
    }
//    $graph->yaxis->SetColor("red");
    $graph->yaxis->title->Set($einheit);
    $graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->yaxis->SetTitleMargin(30);
    if ($hasSensor1a) {
        $line1 = new LinePlot($yadata,$xadata);
        $line1->SetLegend($sensor1alegend);
        $graph->Add($line1);
    }
    if ($hasSensor1b) {
        $line2 = new LinePlot($ybdata,$xbdata);
        $line2->SetLegend($sensor1blegend);
        $graph->Add($line2);
    }
    if ($hasSecondGrah) {
        $line2 = new LinePlot($y2data,$x2data);
        $line2->SetLegend($sensor2legend);
        $graph->Add($line2);
        $line2->SetColor($sensor2color);
        $graph->y2axis->title->Set($einheit2);
        $graph->y2axis->title->SetFont(FF_FONT1,FS_BOLD);
        $graph->y2axis->SetTitleMargin(30);
//      $graph->SetY2Scale("lin",0,10);
    }
    $graph->xaxis->title->Set($label_2); 
    $graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
    $graph->xaxis->SetTitleMargin(10);
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
