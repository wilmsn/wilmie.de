
<script> var basedir="/admin/"; </script>

<script src="/js/rf24hub.js"></script> 

<script type="text/javascript">

$(document).ready(function() {
  header_init("Haussteuerung");
  $.get(basedir+'getfhem.php',{geraet: "Aussen_Temp", eigenschaft: "state" }, function(data) {
    header_addLine(1,"Aussentemperatur", parseInt(data*10)/10 + "°C");
  });
  add_room(1, "Wohnzimmer", "Wohnzimmer_Temp");
  add_device_ht(1, 1, "Thermostat", "HT_Wohnzimmer1");
  add_device_switch(1, 2, "Licht", "HS_WohnzimmerLicht", "MQTT2_DVES_0785A4");
  add_device_switch(1, 3, "Fenstertanne", "HS_Steckdose5", "MQTT2_DVES_F97216");
  add_device_switch(1, 4, "Schranklicht", "HS_Steckdose2", "MQTT2_DVES_C50654");
  add_room(2, "Küche", "Kueche_Temp");
  add_device_ht(2, 1, "Thermostat", "HT_Kueche1");
  add_room(3, "Bastelzimmer", "Bastelzimmer_Temp");
  add_device_ht(3, 1, "Thermostat", "HT_Bastelzimmer");
  add_room(4, "Flur", "Flur_Temp");
  add_device_switch(4, 1, "Treppenhaus", "HS_TreppenhausLicht", "MQTT2_DVES_1DD8B7");
  add_device_switch(4, 2, "Flurlicht", "HS_Flur_Licht", "Flur_Licht_");
  add_room(5, "Schlafzimmer", "Schlafzimmer_Temp");
  add_room(6, "Ankleidezimmer", "Ankleidezimmer_Temp");
  add_room(7, "Gästezimmer", "Gaestezimmer_Temp");
  add_room(8, "Draussen", " ");
  add_device_switch(8, 1, "Balkon", "HS_Balkon_Steckdose", "Balkon_Steckdose");
  add_device_switch(8, 2, "Terasse", "HS_Terasse_Steckdose", "Terasse_Steckdose");
  add_device_switch(8, 3, "Girlande", "HS_Steckdose1", "MQTT2_DVES_1DD752");
  add_device_switch(8, 4, "Teich", "HS_Teichpumpe", "MQTT2_DVES_F977E8");  
});

</script>

<link rel="stylesheet" href="/css/rf24hub.css" /> 
   
<div id="haus" class="haus">
</div>  

