<!DOCTYPE html>
<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
?>
<html>
 
<head>

<meta content="text/html; charset=UTF-8" http-equiv="content-type">

</head>

<?php

if (isset($_GET["geraet"])) {
    $geraet = $_GET["geraet"];
} else {
    $geraet = " ";
}
if (isset($_GET["zustand"])) {
    $zustand = $_GET["zustand"];
} else {
    $zustand = " ";
}

switch($geraet) {
    case "flur":
        if ( $zustand == "ein" ) {
            $fhemcmd="{ switch('RF24','Flur_Steckdose','ein');; }";
        }
        if ( $zustand == "aus" ) {
            $fhemcmd="{ switch('RF24','Flur_Steckdose','aus');; }";
        }
    break;
    case "balkon":
        if ( $zustand == "ein" ) {
            $fhemcmd="{ switch('RF24','Balkon_Steckdose','ein');; }";
        }
        if ( $zustand == "aus" ) {
            $fhemcmd="{ switch('RF24','Balkon_Steckdose','aus');; }";
        }
    break;
}
  
$fhemsock = fsockopen($fhem_server, $fhem_port, $errno, $errstr, 30);
$fhemcmd = $fhemcmd." \r\nquit\r\n";
fwrite($fhemsock, $fhemcmd);
while(!feof($fhemsock)) {
	$ergebnis=fgets($fhemsock, 128);
}
  //print $geraet." gesetzt auf ".$eigenschaft." = ".$wert." ".$wert1." ";
  //echo $fhemcmd;
  echo "OK";
?>

</html>
