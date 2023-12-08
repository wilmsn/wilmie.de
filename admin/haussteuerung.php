<script> var basedir="/admin/"; </script>

<script src="/js/rf24hub.js"></script> 

<script type="text/javascript">

$(document).ready(function() {
  header_init("Haussteuerung");
  $.get(basedir+'getfhem.php',{geraet: "Aussen2_Temp", eigenschaft: "state" }, function(data) {
    header_addLine(1,"Aussentemperatur", parseInt(data*10)/10 + "°C");
  });
  add_room(1, "Wohnzimmer", "Wohnzimmernode", "Temperatur", true);
  add_device_ht(1, 1, "Hzg_gross", "HT_Wohnzimmer1");
  add_device_ht(1, 2, "Hzg_klein", "HT_Wohnzimmer2");
  add_device_switch(1, 3, "Licht", "HS_WohnzimmerLicht", "WohnzimmerLicht");
  add_device_switch(1, 4, "Display", "HS_Wohnzimmer_Display", "Wohnzimmer_Display");
//  add_device_switch(1, 3, "Fenstertanne", "HS_Steckdose5", "MQTT2_DVES_F97216");
  add_device_switch(1, 5, "Schranklicht", "HS_Steckdose5", "Steckdose5_");
  add_room(2, "Kueche", "Kueche_Temp", "state", true);
  add_device_ht(2, 1, "Hzg_gross", "HT_Kueche1");
  add_device_ht(2, 2, "Handtuchheizung", "HT_Kueche2");
  add_room(3, "Bastelzimmer", "Bastelzimmer_Temp", "state", true);
  add_device_ht(3, 1, "Thermostat", "HT_Bastelzimmer");
  add_room(4, "Flur", "FlurNode", "Temperatur", true);
  add_device_switch(4, 1, "Treppenhaus", "HS_TreppenhausLicht", "TreppenhausLicht_");
  add_device_switch(4, 2, "Flurlicht", "HS_FlurLicht", "FlurLicht_");
  add_room(5, "Schlafzimmer", "Schlafzimmer_Temp", "state", false);
  add_room(6, "Ankleidezimmer", "Kugelnode2_Temp", "state", false);
  add_room(7, "Gaestezimmer", "Gaestezimmer_Temp", "state", false);
  add_room(8, "Keller", "Keller_Temp", "state", false);
  add_device_measure(8, 1, "Gaszaehler", "GasZaehler", "state", " ");
  add_device_measure_dia(8, 2, "akt. Verbrauch", "GasVerbrauch_KW_aktuell", "state", "KW", "datahub", "1004", "FF7000", "Gasverbrauch");
  add_device_measure(8, 3, "Verbrauch Tag", "GasVerbrauch_KWH_Tag", "state", "KWh");
  add_device_measure(8, 4, "Verbrauch Vortag", "GasVerbrauch_KWH_Vortag", "state", "KWh");
//  add_device_ht(8, 2, "Hzg_gross", "HT_Kueche1");
  add_room(9, "Draussen", "Aussen2_Temp", "state", true);
  add_device_switch(9, 1, "Balkon", "HS_Balkon_Steckdose", "Balkon_Steckdose");
  add_device_switch(9, 2, "Terasse", "HS_Terasse_Steckdose", "Terasse_Steckdose");
  add_device_measure_dia(9, 3, "Terassentemp", "Terassennode", "Temp", "&deg;C", "datahub", "1", "FF0000", "Temperatur");
//  add_device_switch(8, 3, "Girlande", "HS_Steckdose1", "MQTT2_DVES_1DD752");
//  add_device_switch(8, 3, "Teich", "HS_Teichpumpe", "MQTT2_DVES_814318");  
  add_device_switch(9, 4, "Teich", "HS_Teichpumpe", "TeichNode");
  add_device_measure(9, 5, "Schuppentemp", "TeichNode", "Temp", "&deg;C");
  add_room(10, "MW_Wohnzimmer", "MW_Wohnzimmer_Temp", "state", true);
  add_device_ht(10,1,"Thermostat","HT_MW_Wohnzimmer");
  add_device_measure(10, 2, "Feuchte", "MW_Wohnzimmer_Humi", "state", "&#037;");
  add_room(11, "MW_Kueche", "HT_MW_Kueche", "temperature", true);
  add_device_ht(11,1,"Thermostat","HT_MW_Kueche");
//  add_room(11, "Weihnachtsbeleuchtung", "", "");
//  add_device_switch(11,1,"Thermostat","HT_MW_Kueche");

});

</script>

<link rel="stylesheet" href="/css/rf24hub.css" /> 
   
<div id="haus" class="haus">
</div>  

