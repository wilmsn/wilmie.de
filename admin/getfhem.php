<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');

if (isset($_GET["geraet"])) {  $geraet=$_GET["geraet"]; }
if (isset($_GET["eigenschaft"])) {  $eigenschaft=$_GET["eigenschaft"]; }

switch ($eigenschaft) {
case "age":
    $fhemcmd = "{ time() - time_str2num(ReadingsTimestamp(\"".$geraet."\", \"state\",0));; }\r\nquit\r\n";
    break;
case "timestamp":
    $fhemcmd = "{ ReadingsTimestamp(\"".$geraet."\", \"state\",0);; }\r\nquit\r\n";
    break;
default:
    $fhemcmd = "{ ReadingsVal(\"".$geraet."\",\"".$eigenschaft."\",0);; }\r\nquit\r\n";
}

//Socket öffnen
$fhemsock = fsockopen($fhem_server, $fhem_port, $errno, $errstr, 30);
#$fhemcmd = "{ ReadingsVal(\"".$geraet."\",\"".$eigenschaft."\",0);; }\r\nquit\r\n";
//print $fhemcmd."<br>";
fwrite($fhemsock, $fhemcmd);
#while(!feof($fhemsock)) {
if(!feof($fhemsock)) {
    $ergebnis=fgets($fhemsock, 128);
	if ( strlen($ergebnis) > 2 ) {
		$zustand=explode(" ",$ergebnis);
        print trim($zustand[0]);
	}
}
?>
