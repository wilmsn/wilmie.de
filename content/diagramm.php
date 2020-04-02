<?php // content="text/plain; charset=utf-8"
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ('jpgraph/jpgraph.php');
require_once ('jpgraph/jpgraph_line.php');
require_once ('jpgraph/jpgraph_utils.inc.php');

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
if (isset($_GET["ymin"])) {
	$ymin = $_GET["ymin"];
} else {
    $ymin='auto';
}	
if (isset($_GET["ymax"])) {
	$ymax = $_GET["ymax"];
} else {
    $ymax='auto';
}	
if (isset($_GET["sizex"])) {
	$sizex = $_GET["sizex"];
} else {
    $sizex=650;
}	
if ($sizex > 1200) { $sizex = 1200; }
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

	$range = $_GET["range"];
	$by_range = True;
	switch ($range) {
		case '10y':
			$label_1 = 'Verlauf der letzten 10 Jahre'; 
			$label_2 = ' Kalenderjahr ->';
			$utime_back = "3600 * 24 *365 *10";
			$table = " sensordata_d ";
		break;
        case '5y':
            $label_1 = 'Verlauf der letzten 5 Jahre';
            $label_2 = ' Kalenderjahr ->';
            $utime_back = "3600 * 24 *365 *5";
            $table = " sensordata_d ";
        break;
		case '2y':
			$label_1 = 'Verlauf der letzten 2 Jahre'; 
			$label_2 = ' Kalendermonat ->';
			$utime_back = "3600 * 24 *365 *2";
			$table = " sensordata_d ";
		break;
		case '1y':
			$label_1 = 'Verlauf des letzten Jahres'; 
			$label_2 = ' Kalendermonat ->';
			$utime_back = "3600 * 24 *365";
			$table = " sensordata_d ";
		break;
		case '6m':
			$label_1 = 'Verlauf der letzten 180 Tage'; 
			$label_2 = ' Kalendertag ->';
			$utime_back = "3600 * 24 *30 *6";
			$table = " sensordata_d ";
		break;
		case '3m':
			$label_1 = 'Verlauf der letzten 90 Tage'; 
			$label_2 = ' Kalendertag ->';
			$utime_back = "3600 * 24 *30 *3";
			$table = " sensordata_d ";
		break;
		case '1m':
			$label_1 = 'Verlauf der letzten 30 Tage'; 
			$label_2 = ' Kalendertag ->';
			$utime_back = "3600 * 24 *30";
			$table = " sensordata_d ";
		break;
		default:
			$label_1 = "Verlauf der letzten 24 Stunden"; 
			$label_2 = " Uhrzeit ->"; 
			$utime_back = " 3600 * 24";
			$table = " sensordata_im ";
	}

$xdata = array();
$xdataTick = array();
$ydata = array();
$db = new mysqli($db_sh_server, $db_sh_user, $db_sh_pass, $db_sh_db);
	$stmt = " select value, utime ". 
		    " from ".$table.
		    " where sensor_id = ".$sensor1. 
		    " and utime > unix_timestamp() - ".$utime_back.
		    " order by utime asc";
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
//if ( $firstOfHour == 1 ) { array_shift($tickPos); }
if ( $ymin == 'auto' ) {
    $ydataMin=min($ydata);
} else {
    $ydataMin=$ymin;
}
if ( $ymax == 'auto' ) {
    $ydataMax=max($ydata);
} else {
    $ydataMax=$ymax;
}
if ( $ymin == 'auto' ) {
    if ($ydataMax-$ydataMin > 2 ) { 
        if ($ydataMin > 0) {
            $yscaleMin=floor($ydataMin/10)*10;
        } else {
            $yscaleMin=floor($ydataMin/10)*10;
        }
    } else {
        if ($ydataMin > 0) {
            $yscaleMin=floor($ydataMin);
        } else {
            $yscaleMin=floor($ydataMin)-1;
        }
	}	
} else {
    $yscaleMin=$ydataMin;
}
if ( $ymax == 'auto' ) {
    if ($ydataMax-$ydataMin > 2 ) { 
        if ($ydataMax > 0) {
            $yscaleMax=ceil($ydataMax/10)*10;
        } else {
            $yscaleMax=ceil($ydataMax/10)*10;
        }	
    } else {
        if ($ydataMax > 0) {
            $yscaleMax=floor($ydataMax)+1;
        } else {
            $yscaleMax=floor($ydataMax);
        }
    }
} else {
    $yscaleMax=$ydataMax;
}
array_pop($xdataTick);
$dateUtils = new DateScaleUtils();
$graph = new Graph($sizex, $sizey);
$graph->title->Set($label_1);
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
    case '6m':
    case '3m':
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
//        $graph->xaxis->SetTickPositions($xdataTick);
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