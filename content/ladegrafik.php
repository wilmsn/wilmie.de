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
?>
<h1>Batteriespannung Wohnzimmer</h1>
<img src="/content/diagramm.php?sensor1=133&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=400">
<h1>Batteriespannung Küche</h1>
<img src="/content/diagramm.php?sensor1=12&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=400">
<h1>Batteriespannung Bastelzimmer</h1>
<img src="/content/diagramm.php?sensor1=10&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=400">
<h1>Batteriespannung Schlafzimmer</h1>
<img src="/content/diagramm.php?sensor1=161&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=400">
<?php
} else { 
?>
<h1>Batteriespannung Wohnzimmer</h1>
<img src="/content/diagramm.php?sensor1=133&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=1200">
<h1>Batteriespannung Küche</h1>
<img src="/content/diagramm.php?sensor1=12&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=1200">
<h1>Batteriespannung Bastelzimmer</h1>
<img src="/content/diagramm.php?sensor1=10&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=1200">
<h1>Batteriespannung Schlafzimmer</h1>
<img src="/content/diagramm.php?sensor1=161&range=6m&sensor1legend=Batterie&ymin=3.5&ymax=4.2&sizex=1200">
<?php
} 
?>
