<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');

if (isset($_GET["tn_in"])) {  $tn_in=$_GET["tn_in"]; }

error_reporting(E_ALL);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$result = socket_connect($socket, $rf24_server, $rf24_tn_port);

//$in = "html order\n";
$buf = '';

socket_write($socket, $tn_in, strlen($tn_in));

socket_recv($socket, $buf, 2048, MSG_WAITALL);
socket_close($socket);

$delme =array("rf24hub>", "Command received => OK");
$out = str_replace($delme, "", $buf);

echo $out . "\n";

?>
