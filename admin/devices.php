
<script> var basedir="/admin/"; </script>

<script src="/js/sensorhub.js"></script> 

<script type="text/javascript">

$(document).ready(function(){
  header_init("Geräteübersicht");
//  $.get(basedir+'getfhem.php',{geraet: "aussentemperatur", eigenschaft: "state" }, function(data) {
//	header_addLine(1, "Aussentemperatur", parseInt(data*10)/10 +" &deg;C");
//  });
// dev_init(dev#, dev Typ, dev Label, FHEM Wertequelle Objekt; FHEM Wertequelle Reading, FHEM Regler);  
  dev_status_init( 1, "Node Aussen", 100, "aussentemperatur");
  dev_status(1,1,"Temperatur","aussentemperatur", "state");
  dev_status(1,3,"Luftdruck", "aussenluftdruck", "state");
  dev_status(1,4,"Feuchte", "aussenfeuchte", "state");
  dev_status(1,2,"Batteriespannung", "aussenthermometer_ubatt", "state");
  dev_status_init( 2, "Node Wohnzimmer", 100, "Wohnzimmer_Temp");
  dev_status(2,1,"Temperatur","Wohnzimmer_Temp", "state");
  dev_status(2,3,"Luftdruck", "Wohnzimmer_Luftdruck", "state");
  dev_status(2,4,"Feuchte", "Wohnzimmer_Luftfeuchtigkeit", "state");
  dev_status(2,2,"Batteriespannung", "Wohnzimmer_Ubatt", "state");
  dev_status_init( 3, "Node Küche", 60, "Kueche_Temp");
  dev_status(3,1,"Temperatur","Kueche_Temp", "state");
  dev_status(3,2,"Batteriespannung", "Kueche_Ubatt", "state");
  dev_status_init( 4, "Node Schlafzimmer", 60, "Schlafzimmer_Temp");
  dev_status(4,1,"Temperatur","Schlafzimmer_Temp", "state");
  dev_status(4,2,"Batteriespannung", "Schlafzimmer_Ubatt", "state");
  dev_status_init( 5, "Node Bastelzimmer", 60, "Bastelzimmer_Temp");
  dev_status(5,1,"Temperatur","Bastelzimmer_Temp", "state");
  dev_status(5,2,"Batteriespannung", "Bastelzimmer_Ubatt", "state");
  dev_status_init( 6, "Node Ankleidezimmer", 60, "Ankleidezimmer_Temp");
  dev_status(6,1,"Temperatur","Ankleidezimmer_Temp", "state");
  dev_status(6,2,"Batteriespannung", "Ankleidezimmer_Ubatt", "state");
});
</script>
 
<link rel="stylesheet" href="/css/sensorhub.css" /> 
   
<div id="haus" class="haus">
</div>  

