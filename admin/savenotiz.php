<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$www_db = new PDO("mysql:host=$db_www_server;dbname=$db_www_db", $db_www_user, $db_www_pass);

$valid=false;
if (isset($_GET["mytext"])) { $mytext=$_GET["mytext"]; $valid=true;} else { $mytext="";}
if (isset($_GET["myid"])) { $myid=$_GET["myid"];} else { $myid=0;}
if (isset($_GET["lfdnr"])) { $lfdnr=$_GET["lfdnr"];} else { $lfdnr=0;}

if ( $valid ) {
	$sql ="insert into notizen (id, lfdnr, text) values(".$myid.",".$lfdnr.",'".$mytext."')";
    echo "  ".$sql." ";
	$www_db->query($sql);
	$www_db = NULL;
}
?>

