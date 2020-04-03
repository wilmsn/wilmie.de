<?php // content="text/plain; charset=utf-8"
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_utils.inc.php');

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

if (isset($_GET["sizex"])) {
	$sizex = $_GET["sizex"];
} else {
    $sizex=650;
}	
if ($sizex > 1000) { $sizex = 1000; }
if (isset($_GET["sizey"])) {
	$sizey = $_GET["sizey"];
} else {
    $sizey=370;
}	
if (isset($_GET["sensor1color"])) {
    $sensor1color = "#".$_GET["sensor1color"];
} else {
    $sensor1color = "#ff0000";
}
if (isset($_GET["sensor1legend"])) {
    $sensor1legend = $_GET["sensor1legend"];
} else {
    $sensor1legend = "unbekannt";
}
switch ($sensor1legend) {
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
   default:
    $einheit= " ";
}	

if (isset($_GET["sensor1"])) {
    $sensor1 = $_GET["sensor1"];
} else {
    $sensor1 = 1;
}
if (isset($_GET["offset"])) {
    $offset = $_GET["offset"];
} else {
    $offset = 0;
}
error_log("offset: ".$offset." range: ".$range."\n");
	$range = $_GET["range"];
	$by_range = True;
	switch ($range) {
		case '10y':
			$label_date_format = '%d.%m.%y'; 
			$label_2 = ' Kalenderjahr ->';
			$diagramtime = 315360000;
			$table = 'sensordata_d';
		break;
        case '5y':
			$label_date_format = '%d.%m.%y'; 
            $label_2 = ' Kalenderjahr ->';
            $diagramtime = 157680000;
            $table = 'sensordata_d';
        break;
		case '2y':
			$label_date_format = '%d.%m.%y'; 
			$label_2 = ' Kalendermonat ->';
			$diagramtime = 63072000;
			$table = 'sensordata_d';
		break;
		case '1y':
			$label_date_format = '%d.%m.%y'; 
			$label_2 = ' Kalendermonat ->';
			$diagramtime = 31536000;
			$table = 'sensordata_d';
		break;
		case '1m':
			$label_date_format = '%d.%m.%y'; 
			$label_2 = ' Kalendertag ->';
			$diagramtime = 2678400;
			$table = 'sensordata_im';
		break;
		default:
			$label_date_format = '%d.%m.%y %H:%i'; 
			$label_2 = " Uhrzeit ->"; 
			$diagramtime = 86400;
                	$table = 'sensordata_im';
    }

$xdata = array();
$ydata = array();
$db = new mysqli($db_sh_server, $db_sh_user, $db_sh_pass, $db_sh_db);
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
		case '1m':
		    if ( $offset == 0 ) {
                $label_1 = 'Verlauf der letzten 30 Tage'; 
			} else {
            $monate = array(1=>"Januar", 2=>"Februar", 3=>"M&auml;rz", 4=>"April", 5=>"Mai", 6=>"Juni",
                            7=>"Juli", 8=>"August", 9=>"September", 10=>"Oktober", 11=>"November", 12=>"Dezember");
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

$stmt = " select value, utime ". 
	    " from ".$table.
	    " where sensor_id = ".$sensor1. 
	    " and utime > ".$starttime." and utime < ".$starttime." + ".$diagramtime.
	    " order by utime asc";
error_log("\n".$stmt."\n");	    
$results = $db->query($stmt);
$last_utime=0;
$minTickPos=array();
$tickPos=array();
$firstOfHour=0;
while ($row = $results->fetch_assoc()) {
	$ydata[]=$row['value'];
	$xdata[]=$row['utime'];
	if ($range == '1d') {
	    if ( count($minTickPos) == 0 ) { $minTickPos[] = $row['utime']; }
            if ( $last_utime > 0 and date('H',$row['utime']) <> date('H',$last_utime) ) {
                $tickPos[]=$row['utime'];
                $firstOfHour=1;
            } else {
                $firstOfHour=0;
            }
        $last_utime=$row['utime'];
   }
}	
$results->close();
$db->close();

$ydataMin=min($ydata);
$ydataMax=max($ydata);
if ($ydataMax-$ydataMin > 2 ) { 
	if ($ydataMin > 0) {
		$yscaleMin=floor($ydataMin/10)*10;
	} else {
		$yscaleMin=floor($ydataMin/10)*10;
	}	
	if ($ydataMax > 0) {
		$yscaleMax=ceil($ydataMax/10)*10;
	} else {
		$yscaleMax=ceil($ydataMax/10)*10;
	}	
} else {
	if ($ydataMin > 0) {
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
$dateUtils = new DateScaleUtils();
$graph = new Graph($sizex, $sizey);
$graph->SetScale('intlin',$yscaleMin,$yscaleMax,min($xdata),max($xdata));
$graph->SetMargin(70,20,0,0);
$graph->title->Set($label_1);
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
        $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackYM'); 
        list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_MONTH2);
        $graph->xaxis->SetTickPositions($tickPos,$minTickPos);
    break;
    case '1y':
        $graph->xaxis->SetLabelFormatCallback( 'TimeCallbackYM'); 
        list($tickPos,$minTickPos) = $dateUtils->getTicks($xdata,DSUTILS_MONTH1);
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
$line = new LinePlot($ydata,$xdata);
$line->SetLegend($sensor1legend);
$graph->Add($line);
$line->SetColor($sensor1color); 
$graph->yaxis->title->Set($einheit);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->SetTitleMargin(50);
$graph->xaxis->title->Set($label_2); 
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->SetTitleMargin(10);
$graph->legend->SetAbsPos(10,30,'right','top');
$graph->legend->SetFrameWeight(2);
$graph->legend->SetShadow();
$graph->legend->SetColor('darkgreen');
$graph->legend->SetFillColor('lightyellow');
$graph->xaxis->SetPos('min');
# Achtung: Folgende Zeile verhindert Abstand unter Grafik !!!
$graph->graph_theme=null;
$graph->SetMarginColor('#dddddd');
$graph->SetFrame(true,'#dddddd', 0);
$graph->Stroke();
 
?>
