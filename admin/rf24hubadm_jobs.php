<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');

error_reporting(E_ALL);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
$result = socket_connect($socket, $rf24_server, $rf24_tn_port);

$in = "html order\n";
$buf = '';

socket_write($socket, $in, strlen($in));

socket_recv($socket, $buf, 2048, MSG_WAITALL);
socket_close($socket);

$delme =array("rf24hub>", "Command received => OK");
$out = str_replace($delme, "", $buf);

echo $out . "\n";

?>
