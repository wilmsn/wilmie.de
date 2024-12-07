<script> var basedir="/admin/"; </script>

<script src="/js/haussteuerung.js"></script>
<link rel="stylesheet" href="/css/haussteuerung.css" />

<script type="text/javascript">

$(document).ready(function() {

  haus("Haussteuerung");
  add_room(1, "Draussen");
  add_device(1, 1, "DG", "Temp",            "Aussen_Temp",        "&deg;C", "datahub", "1", "1d", "Temperatur", "line", "1");
  add_device(1, 2, "SW", "Balkon",          "Balkon_Steckdose",   "HS_Balkon_Steckdose", "", "", "", "", "", "");
  add_device(1, 3, "SW", "Terasse",         "Terasse_Steckdose",  "HS_Terasse_Steckdose", "", "", "", "", "", "");
  add_device(1, 4, "SW", "Teich",           "TeichNode",          "HS_Teichpumpe", "", "", "", "", "", "");
  add_device(1, 5, "DG", "Terassentemp",    "Terasse_Temp",       "&deg;C", "datahub", "21", "1d", "Temperatur", "line", "1");
  add_device(1, 6, "DG", "Schuppentemp",    "Schuppen_Temp",      "&deg;C", "datahub", "22", "1d", "Temperatur", "line", "1");
  add_room(2, "Solar");
  add_device(2, 1, "SO", "Solar aktuell",   "Balkonkraftwerk_cur", "datahub", "1010", "1013", "1014", "", "", "");
  add_device(2, 2, "DG", "Solar Tag",       "Balkonkraftwerk_day", "KWh", "datahub", "1011", "1m", "KWh/Tag", "bar", "0");
  add_device(2, 3, "DG", "Solar total",     "Balkonkraftwerk_tot", "KWh", "datahub", "1011", "1y", "KWh/Tag", "bar", "0");
  add_room(3, "Keller");
  add_device(3, 1, "DG", "Gas akt.",        "GasVerbrauch_KW_aktuell", "KW", "datahub", "1004", "1d", "Gasverbrauch", "line", "0");
  add_device(3, 2, "DG", "Gas Tag",         "GasVerbrauch_KWH_Tag",    "KWh", "datahub", "1003", "1m", "Gasverbrauch", "bar", "0");
  add_device(3, 3, "--", "Gas Vortag",      "GasVerbrauch_KWH_Vortag", "KWh", "", "", "", "", "", "");
  add_device(3, 4, "DG", "Gas Monat",       "GasVerbrauch_Monat",      "KWh", "datahub", "1003", "1y", "Gasverbrauch", "bar", "0");
  add_device(3, 5, "--", "Gas Jahr",        "GasVerbrauch_Jahr",       "KWh", "", "", "", "", "", "");
  add_device(3, 6, "--", "Gaszaehler",      "GasZaehler",              "", "", "", "", "", "");
  add_device(3, 7, "DG", "Batt",            "N111_Ubatt",              "Volt", "rf24hub", "1014", "3m", "Spannung", "line", "2");
  add_room(4, "Wohnzimmer");
  add_device(4, 1, "HT", "Hzg_gr",          "HT_Wohnzimmer1",   "", "", "", "", "", "", "");
  add_device(4, 2, "HT", "Hzg_kl",          "HT_Wohnzimmer2",   "", "", "", "", "", "", "");
  add_device(4, 3, "SW", "Licht",           "WohnzimmerLicht_", "HS_WohnzimmerLicht", "", "", "", "", "", "");
  add_device(4, 4, "SW", "Display",         "WohnzimmerNode_",  "HS_WohnzimmerNode", "", "", "", "", "", "");
  add_device(4, 5, "SW", "Schranklicht",    "Steckdose1_",      "HS_Steckdose1", "", "", "", "", "", "");
  add_device(4, 6, "DG", "Temp",            "Wohnzimmer_Temp",  "&deg;C", "datahub", "24", "1d", "Temperatur", "line", "1");
  add_room(5, "Kueche");
  add_device(5, 1, "HT", "Hzg_gr",          "HT_Kueche1",   "", "", "", "", "", "", "");
  add_device(5, 2, "HT", "Hand_Hzg",        "HT_Kueche2",   "", "", "", "", "", "", "");
  add_device(5, 3, "DG", "Temp",            "Kueche_Temp",  "&deg;C", "rf24hub", "131", "1d", "Temperatur", "line", "1");
  add_device(5, 4, "DG", "Batt",            "N103_Ubatt",   "Volt",   "rf24hub", "140", "3m", "Spannung",   "line", "2");
  add_room(6, "Bastelzimmer");
  add_device(6, 1, "HT", "Heizung",         "HT_Bastelzimmer",   "", "", "", "", "", "", "");
  add_device(6, 2, "DG", "Temp",            "Bastelzimmer_Temp", "&deg;C", "datahub", "27", "1d", "Temperatur", "line", "1");
  add_device(6, 3, "DG", "Batt",            "N102_Ubatt",        "Volt",   "rf24hub", "130", "3m", "Spannung", "line", "1");
  add_room(7, "Flur");
  add_device(7, 1, "SW", "Treppenhaus",     "TreppenhausLicht_", "HS_TreppenhausLicht", "", "", "", "", "", "");
  add_device(7, 2, "SW", "Flurlicht",       "FlurLicht_",        "HS_FlurLicht", "", "", "", "", "", "");
  add_device(7, 3, "DG", "Temp",            "Flur_Temp",         "&deg;C",  "datahub", "23", "1d", "Temperatur", "line", "1");
  add_room(8, "Schlafzimmer");
  add_device(8, 1, "DG", "Temp",            "Schlafzimmer_Temp", "&deg;C",  "datahub", "26",  "1d", "Temperatur", "line", "1");
  add_device(8, 2, "DG", "Batt",            "N102_Ubatt",        "Volt",    "rf24hub", "130", "3m", "Spannung", "line", "2");
  add_room(9, "Ankleidezimmer");
  add_device(9, 1, "DG", "Temp",            "Ankleidezimmer_Temp", "&deg;C", "datahub", "28", "1d", "Temperatur", "line", "1");
  add_device(9, 2, "DG", "Batt",            "N110_Ubatt",          "Volt",   "rf24hub", "210", "3m", "Spannung", "line", "2");
  add_room(10, "Badezimmer");
  add_device(10, 1, "DG", "Temp",           "Kugelnode1_Temp",     "&deg;C", "rf24hub", "161", "1d", "Temperatur", "line", "1");
  add_device(10, 2, "DG", "Batt",           "N106_Ubatt",          "Volt",   "rf24hub", "170", "3m", "Spannung", "line", "2");
  add_room(11, "Gaestezimmer");
  add_device(11, 1, "DG", "Temp",           "Gaestezimmer_Temp",  "&deg;C", "rf24hub", "141", "1d", "Temperatur", "line", "1");
  add_device(11, 2, "DG", "Batt",           "N104_Ubatt",          "Volt",   "rf24hub", "150", "3m", "Spannung", "line", "2");
  add_room(12, "MW_Wohnzimmer");
  add_device(12, 1, "HT", "Heizung",        "HT_MW_Wohnzimmer",   "", "", "", "", "", "", "");
  add_device(12, 2, "DG", "Temp",           "MW_Wohnzimmer_Temp", "&deg;C", "datahub", "51", "1d", "Temperatur", "line", "1");
  add_device(12, 3, "DG", "Humi",           "MW_Wohnzimmer_Humi", "&#037;", "datahub", "52", "1d", "Luftfeuchtigkeit", "line", "1");
  add_device(12, 4, "DG", "Batt",           "N108_Ubatt",        "Volt",   "rf24hub", "190", "3m", "Spannung", "line", "2");
  add_room(13, "MW_Kueche");
  add_device(13, 1, "HT", "Heizung",        "HT_MW_Kueche",   "", "", "", "", "", "", "");

});

</script>

   
<div id="haus" class="haus">Test
</div>  

