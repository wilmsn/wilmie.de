<script> var basedir="/admin/"; </script>

<script src="/js/haussteuerung.js"></script>
<link rel="stylesheet" href="/css/haussteuerung.css" />

<script type="text/javascript">

$(document).ready(function() {

  haus("Haussteuerung");
  add_room("Draussen");
  add_device("DG", "Temp",         "Aussen_Temp",                   "&deg;C",   "1",   "1d", "line", "Temperatur", "1");
  add_device("SW", "Balkon",       "Terassennode_Balkon",           " ",        "HS_Balkon_Steckdose",  "504");
  add_device("SW", "Terasse",      "Terassennode_Terasse",          " ",        "HS_Terasse_Steckdose", "505");
  add_device("SW", "Teich",        "TeichPumpe",                    " ",        "HS_Teichpumpe",        "500");
  add_device("DG", "Terassentemp", "Terasse_Temp",                  "&deg;C",   "21",  "1d", "line", "Temperatur", "1");
  add_device("DG", "Schuppentemp", "Schuppen_Temp",                 "&deg;C",   "22",  "1d", "line", "Temperatur", "1");

  add_room("Solaranlage");
  add_device("VD", "PV Anlage",    "Solaranlage_Erzeugung_Aktuell",  "W",       "1050", "1053", "Solaranlage_Erzeugung_Tag", "Solaranlage_Erzeugung_Monat", "Solaranlage_Erzeugung_Jahr", "Stromerzeugung" );
  add_device("MD", "Akku Ladung",  "Solaranlage_Batt_Proz",          "%",       "1056", "1056", "Ladestand", "Ladestand", "rbar");
  add_device("DG", "Akku",         "Solaranlage_Ladezyklen",        "Zyklen",   "1051", "1", "line", "Laden/Entladen", "1");
  add_device("VD", "Balkon KW",    "Balkonkraftwerk_cur",            "W",       "1010", "1011", "Balkonkraftwerk_Tag", "Balkonkraftwerk_Monat", "Balkonkraftwerk_Jahr", "Stromerzeugung");

  add_room("Keller");
  add_device("VD", "Stromverbr.",  "Solaranlage_Local_Load",         "W",       "1052", "1058", "Stromverbrauch_tag", "Stromverbrauch_monat", "Stromverbrauch_jahr", "Stromverbrauch");
  add_device("VD", "Strom in",     "Stromzaehler_in",               "KWh",      "1094", "1091", "Stromverbrauch_zaehler_tag", "Stromverbrauch_zaehler_monat",  "Stromverbrauch_zaehler_jahr",   "Stromverbrauch");
  add_device("VD", "Strom out",    "Stromzaehler_out",             "KWh",       "1095", "1092", "Stromexport_tag", "Stromexport_monat", "Stromexport_jahr", "Stromexport");
  add_device("VD", "Gaszäher",     "GasZaehler",                   "",          "1004", "1003", "GasVerbrauch_KWH_Tag", "GasVerbrauch_Monat", "GasVerbrauch_Jahr", "Gasverbrauch");
  add_device("DG", "Temp",         "Keller_Temp",                  "&deg;C",    "30",   "1d", "Temperatur",   "line", "1");
  add_device("DG", "Batt",         "N111_Ubatt",                   "Volt",      "5014", "3m", "Spannung",     "line", "2");

  add_room("Wohnzimmer");
  add_device("DG", "Temp",         "Wohnzimmer_Temp",              "&deg;C",    "24",   "1d",   "line", "Temperatur", "1");
  add_device("HT", "Hzg_gr",       "HT_Wohnzimmer1");
  add_device("HT", "Hzg_kl",       "HT_Wohnzimmer2");
  add_device("SW", "Licht",        "WohnzimmerLicht",              " ",         "HS_WohnzimmerLicht",  "0");
  add_device("SW", "Display",      "WohnzimmerDisplay",              " ",       "HS_WohnzimmerNode",   "0");

  add_room("Kueche");
  add_device("DG", "Temp",         "Kueche_Temp",                  "&deg;C",    "25",   "1d",   "line", "Temperatur", "1");
  add_device("HT", "Hzg_gr",       "HT_Kueche1");
  add_device("HT", "Hzg_Handtuch", "HT_Kueche2");
  add_device("DG", "Batt",         "N103_Ubatt",                   "Volt",      "5006",  "3m",  "line", "Spannung",   "2");

  add_room("Bastelzimmer");
  add_device("DG", "Temp",         "Bastelzimmer_Temp",            "&deg;C",    "27",   "1d",   "line", "Temperatur", "1");
  add_device("HT", "Heizung",      "HT_Bastelzimmer");
  add_device("DG", "Batt",         "N102_Ubatt",                   "Volt",      "5003",  "3m",  "line", "Spannung",  "1");

  add_room("Flur");
  add_device("DG", "Temp",         "Flur_Temp",                    "&deg;C",    "23",   "1d",   "line", "Temperatur", "1");
  add_device("SW", "Treppenhaus",  "TreppenhausLicht",             " ",         "HS_TreppenhausLicht",  "0");
  add_device("SW", "Flurlicht",    "FlurLicht",                    " ",         "HS_FlurLicht",        "501");

  add_room("Schlafzimmer");
  add_device("DG", "Temp",         "Schlafzimmer_Temp",           "&deg;C",     "26",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Batt",         "N102_Ubatt",                  "Volt",       "5005",  "3m",   "line", "Spannung",   "2");

  add_room("Ankleidezimmer");
  add_device("DG", "Temp",         "Ankleidezimmer_Temp",         "&deg;C",     "28",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Batt",         "N110_Ubatt",                  "Volt",       "5013",  "3m",   "line", "Spannung",   "2");

  add_room("Badezimmer");
  add_device("DG", "Temp",         "Kugelnode1_Temp",             "&deg;C",     "31",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Batt",         "N106_Ubatt",                  "Volt",       "5009",  "3m",   "line", "Spannung",   "2");

  add_room("Gaestezimmer");
  add_device("DG", "Temp",         "Gaestezimmer_Temp",           "&deg;C",     "29",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Batt",         "N104_Ubatt",                  "Volt",       "5007",  "3m",   "line", "Spannung",   "2");

  add_room("MW_Wohnzimmer");
  add_device("DG", "Temp",         "MW_Wohnzimmer_Temp",          "&deg;C",     "51",   "1d",    "line", "Temperatur", "1");
  add_device("HT", "Heizung",      "HT_MW_Wohnzimmer");
  add_device("DG", "Humi",         "MW_Wohnzimmer_Humi",          "&#037;",     "52",   "1d",    "line", "Luftfeuchtigkeit", "1");
  add_device("DG", "Batt",         "N108_Ubatt",                  "Volt",       "5011", "3m",    "line", "Spannung",   "2");

  add_room("MW_Kueche");
  add_device("HT", "Heizung",      "HT_MW_Kueche");

});

</script>

   
<div id="haus" class="haus">Test
</div>  

