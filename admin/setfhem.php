<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');

if (isset($_GET["geraet"])) {  $geraet=$_GET["geraet"]; }
if (isset($_GET["eigenschaft"])) {  $eigenschaft=$_GET["eigenschaft"]; }
if (isset($_GET["wert"])) {  $wert=$_GET["wert"]; } else { $wert=""; }
if (isset($_GET["wert1"])) {  $wert1=$_GET["wert1"]; } else { $wert1=""; }
//Socket öffnen
$fhemsock = fsockopen($fhem_server, $fhem_port, $errno, $errstr, 30);
$fhemcmd = "set ".$geraet." ".$eigenschaft." ".$wert." ".$wert1." \r\nquit\r\n";
//print $fhemcmd."<br>";
fwrite($fhemsock, $fhemcmd);
while(!feof($fhemsock)) {
	$ergebnis=fgets($fhemsock, 128);
}
#print $geraet." gesetzt auf ".$eigenschaft." = ".$wert." ".$wert1." ";
echo $fhemcmd;

?>
