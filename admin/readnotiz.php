<?php
$instance="test";
require_once ('/etc/webserver/'.$instance.'_config.php');
$www_db = new PDO("mysql:host=$db_www_server;dbname=$db_www_db", $db_www_user, $db_www_pass);
foreach ($www_db->query("select text, id, lfdnr from notizen where status = 0 order by id, lfdnr") as $row) {
  if (strlen($row[0]) > 0) {
    echo $row[0];
  } else {
    echo "<br>";
  }
}
?>

