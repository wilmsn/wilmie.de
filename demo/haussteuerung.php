<script> var basedir="/demo/"; </script>

<script src="/js/sensorhub.js"></script> 

<script type="text/javascript">

$(document).ready(function(){
  header_init("Haussteuerung");
  $.get(basedir+'getfhem.php',{geraet: "aussentemperatur", eigenschaft: "state" }, function(data) {
	header_addLine(1, "Aussentemperatur", parseInt(data*10)/10 +" &deg;C");
  });
// dev_init(dev#, dev Typ, dev Label, FHEM Wertequelle Objekt; FHEM Wertequelle Reading, FHEM Regler);  
  dev_init(1,"sw", "Steckdose Balkon",  "Balkon_Steckdose",     "state",       "HS_Balkon_Steckdose");
  dev_init(2,"sw", "Steckdose Terasse", "Terasse_Steckdose",    "state",       "HS_Terasse_Steckdose");
  dev_init(3,"sw", "Steckdose Flur", 	"Flur_Steckdose", 	    "Relay",       "HS_Flur_Steckdose");
  dev_init(4,"ht", "Schlafzimmer",      "HT_Schlafzimmer",       "temperature", "HT_Schlafzimmer");
  dev_init(5,"ht", "Wohnzimmer",        "HT_Wohnzimmer1",       "temperature", "HT_Wohnzimmer1");
  dev_init(6,"ht", "K&uuml;che",        "Kueche_Temp",          "state",       "HT_Kueche1");
  dev_init(7,"ht", "Bastelzimmer",      "Bastelzimmer_Temp",    "state", "HT_Bastelzimmer");
});
</script>
 
<link rel="stylesheet" href="/css/sensorhub.css" /> 
   
<div id="haus" class="haus">
</div>  
