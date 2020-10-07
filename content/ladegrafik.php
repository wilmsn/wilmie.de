<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ($webroot.'/php_inc/check_mobile.php');
$mobile_browser = is_mobile_browser(); 
?>
<html>
  <head>
    <meta charset="utf-8">
  </head>
<?php
if($mobile_browser) { 
    $sizex = 400;
} else {
    $sizex = 1200;
}
if(isset($batt1_name)) {
  print "<h1>Batteriespannung ".$batt1_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt1_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt1_umin."&ymax=".$batt1_umax."&sizex=".$sizex."'>";
}
if(isset($batt2_name)) {
  print "<h1>Batteriespannung ".$batt2_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt2_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt2_umin."&ymax=".$batt2_umax."&sizex=".$sizex."'>";
}
if(isset($batt3_name)) {
  print "<h1>Batteriespannung ".$batt3_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt3_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt3_umin."&ymax=".$batt3_umax."&sizex=".$sizex."'>";
}
if(isset($batt4_name)) {
  print "<h1>Batteriespannung ".$batt4_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt4_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt4_umin."&ymax=".$batt4_umax."&sizex=".$sizex."'>";
}
if(isset($batt5_name)) {
  print "<h1>Batteriespannung ".$batt5_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt5_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt5_umin."&ymax=".$batt5_umax."&sizex=".$sizex."'>";
}
if(isset($batt6_name)) {
  print "<h1>Batteriespannung ".$batt6_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt6_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt6_umin."&ymax=".$batt6_umax."&sizex=".$sizex."'>";
}
if(isset($batt7_name)) {
  print "<h1>Batteriespannung ".$batt7_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt7_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt7_umin."&ymax=".$batt7_umax."&sizex=".$sizex."'>";
}
if(isset($batt8_name)) {
  print "<h1>Batteriespannung ".$batt8_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt8_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt8_umin."&ymax=".$batt8_umax."&sizex=".$sizex."'>";
}
if(isset($batt9_name)) {
  print "<h1>Batteriespannung ".$batt9_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt9_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt9_umin."&ymax=".$batt9_umax."&sizex=".$sizex."'>";
}
if(isset($batt10_name)) {
  print "<h1>Batteriespannung ".$batt10_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt10_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt10_umin."&ymax=".$batt10_umax."&sizex=".$sizex."'>";
}
if(isset($batt11_name)) {
  print "<h1>Batteriespannung ".$batt11_name."</h1>";
  print "<img src='/content/diagramm.php?sensor1=".$batt11_sensor."&range=6m&sensor1legend=Batterie&ymin=".$batt11_umin."&ymax=".$batt11_umax."&sizex=".$sizex."'>";
}

?>
