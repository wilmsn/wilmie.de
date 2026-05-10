<?php
$instance="test";
$id=0;
require_once ('/etc/webserver/'.$instance.'_config.php');
$www_db = new PDO("mysql:host=$db_www_server;dbname=$db_www_db", $db_www_user, $db_www_pass);
foreach ($www_db->query("select max(id) + 1 from notizen") as $row) {
  if (strlen($row[0]) > 0) {
    $id = $row[0];
  }
}
echo $id;

?>

