<script> var basedir="/admin/"; </script>

<script src="/js/haussteuerung.js"></script>
<link rel="stylesheet" href="/css/haussteuerung.css" />

<script type="text/javascript">

$(document).ready(function() {

  haus("Haussteuerung");
  add_room("Draussen");
  add_device("DG", "Temp",            "Aussen_Temp",                   "&deg;C",              "datahub",  "1",   "1d", "Temperatur", "line", "1");
  add_device("SW", "Balkon",          "Terassennode_Balkon",           "HS_Balkon_Steckdose",  "504",     "",     "",   "",          "",     "" );
  add_device("SW", "Terasse",         "Terassennode_Terasse",          "HS_Terasse_Steckdose", "505",     "",     "",   "",          "",     "" );
  add_device("SW", "Teich",           "TeichPumpe",                    "HS_Teichpumpe",        "500",     "",     "",   "",          "",     "" );
  add_device("DG", "Terassentemp",    "Terasse_Temp",                  "&deg;C",              "datahub",  "21",  "1d", "Temperatur", "line", "1");
  add_device("DG", "Schuppentemp",    "Schuppen_Temp",                 "&deg;C",              "datahub",  "22",  "1d", "Temperatur", "line", "1");
  add_room("Solaranlage");
  add_device("DG", "Aktuell",         "Solaranlage_Erzeugung_Aktuell",  "W",                  "datahub",  "1050", "1d", "Erzeugung", "line", "1");
  add_device("DG", "Tag",             "Solaranlage_Erzeugung_Tag",      "KWh",                "datahub",  "1053", "1m", "KWh/Tag",   "bar",  "1");
  add_device("DG", "Total",           "Solaranlage_Erzeugung_Total",    "KWh",                "datahub",  "1053", "1y", "KWh/Tag",   "bar",  "0");
  add_device("DG", "Akku Ladung",     "Solaranlage_Batt_Proz",          "%",                  "datahub",  "1056", "1d", "Ladestand", "line", "1");
  add_device("DG", "Akku Charge",     "Solaranlage_Batt_Charge",        "W",                  "datahub",  "1051", "1d", "Laden/Entladen", "line", "1");
  add_device("--", "Ladezyklen",      "Solaranlage_Ladezyklen",         "",                     "0",        "",     "",   "",          "",     "");
  add_room("Balkonkraftwerk");
  add_device("DG", "Aktuell",         "Balkonkraftwerk_cur",            "W",                  "datahub",  "1010", "1d", "Erzeugung", "line", "1");
  add_device("DG", "Tag",             "Balkonkraftwerk_ds",             "KWh",                "datahub",  "1011", "1m", "KWh/Tag",   "bar",  "1");
  add_device("DG", "Total",           "Balkonkraftwerk_tot",            "KWh",                "datahub",  "1012", "1y", "KWh/Tag",   "bar",  "0");
//  add_room("Strom");

  add_room("Gas");
  add_device("DG", "Gas akt.",        "GasVerbrauch_KW_aktuell",        "KW",                 "datahub", "1004", "1d", "Gasverbrauch", "line", "0");
  add_device("DG", "Gas Tag",         "GasVerbrauch_KWH_Tag",           "KWh",                "datahub", "1003", "1m", "Gasverbrauch", "bar",  "0");
  add_device("DG", "Gas Monat",       "GasVerbrauch_Monat",             "KWh",                "datahub", "1003", "1y", "Gasverbrauch", "bar",  "0");
  add_device("--", "Gas Jahr",        "GasVerbrauch_Jahr",              "KWh",                "0",        "",     "",    "",            "",     "" );
  add_room("Keller");
  add_device("DG", "Strom Last",      "Solaranlage_Local_Load",         "W",                  "datahub",  "1052", "1d", "Strom Last", "line", "1");
  add_device("DG", "Stromzaehler",    "Stromzaehler_in",                "KWh",                "datahub",  "1091", "1m", "Stromimport",  "bar",  "0");
  add_device("DG", "Exportzaehler",   "Stromzaehler_out",               "KWh",                "datahub",  "1092", "1m", "Stromexport" , "bar",  "0");
  add_device("--", "Gaszaehler",      "GasZaehler",                     "",                   "1",        "",     "",    "",            "",     "" );
  add_device("DG", "Temp",            "Keller_Temp",                    "&deg;C",             "datahub",  "30", "1d", "Temperatur",   "line", "1");
  add_device("DG", "Batt",            "N111_Ubatt",                     "Volt",               "datahub",  "5014", "3m", "Spannung",     "line", "2");
  add_room("Wohnzimmer");
  add_device("DG", "Temp",            "Wohnzimmer_Temp",                "&deg;C",              "datahub", "24",   "1d", "Temperatur",   "line", "1");
  add_device("HT", "Hzg_gr",          "HT_Wohnzimmer1",                 "",                    "",        "",     "",   "",             "",     "" );
  add_device("HT", "Hzg_kl",          "HT_Wohnzimmer2",                 "",                    "",        "",     "",   "",             "",     "" );
  add_device("SW", "Licht",           "WohnzimmerLicht",                "HS_WohnzimmerLicht",  "",        "",     "",   "",             "",     "" );
  add_device("SW", "Display",         "WohnzimmerDisplay",              "HS_WohnzimmerNode",   "",        "",     "",   "",             "",     "" );
  add_device("SW", "Schranklicht",    "Steckdose1_",                    "HS_Steckdose1",       "",        "",     "",   "",             "",     "" );
  add_room("Kueche");
  add_device("DG", "Temp",            "Kueche_Temp",                    "&deg;C",              "datahub", "25",   "1d", "Temperatur",   "line", "1");
  add_device("HT", "Hzg_gr",          "HT_Kueche1",                     "",                    "",        "",     "",   "",             "",     "" );
  add_device("HT", "Hzg_Handtuch",    "HT_Kueche2",                     "",                    "",        "",     "",   "",             "",     "" );
  add_device("DG", "Batt",            "N103_Ubatt",                     "Volt",                "datahub", "5006",  "3m", "Spannung",     "line", "2");
  add_room("Bastelzimmer");
  add_device("DG", "Temp",            "Bastelzimmer_Temp",              "&deg;C",              "datahub", "27",   "1d", "Temperatur",   "line", "1");
  add_device("HT", "Heizung",         "HT_Bastelzimmer",                "",                    "",        "",     "",   "",             "",     "" );
  add_device("DG", "Batt",            "N102_Ubatt",                     "Volt",                "datahub", "5003",  "3m", "Spannung",     "line", "1");
  add_room("Flur");
  add_device("DG", "Temp",            "Flur_Temp",                      "&deg;C",              "datahub", "23",   "1d", "Temperatur",   "line", "1");
  add_device("SW", "Treppenhaus",     "TreppenhausLicht_",              "HS_TreppenhausLicht", "",        "",     "",   "",             "",     "" );
  add_device("SW", "Flurlicht",       "FlurLicht",                      "HS_FlurLicht",        "501",     "",     "",   "",             "",     "" );
  add_room("Schlafzimmer");
  add_device("DG", "Temp",            "Schlafzimmer_Temp",              "&deg;C",             "datahub", "26",   "1d", "Temperatur",   "line", "1");
  add_device("DG", "Batt",            "N102_Ubatt",                     "Volt",               "datahub", "5005",  "3m", "Spannung",     "line", "2");
  add_room("Ankleidezimmer");
  add_device("DG", "Temp",            "Ankleidezimmer_Temp",            "&deg;C",             "datahub", "28",   "1d", "Temperatur",   "line", "1");
  add_device("DG", "Batt",            "N110_Ubatt",                     "Volt",               "datahub", "5013",  "3m", "Spannung",     "line", "2");
  add_room("Badezimmer");
  add_device("DG", "Temp",           "Kugelnode1_Temp",                "&deg;C",              "datahub", "31",  "1d", "Temperatur",   "line", "1");
  add_device("DG", "Batt",           "N106_Ubatt",                     "Volt",                "datahub", "5009",  "3m", "Spannung",     "line", "2");
  add_room("Gaestezimmer");
  add_device("DG", "Temp",           "Gaestezimmer_Temp",              "&deg;C",              "datahub", "29",  "1d", "Temperatur",   "line", "1");
  add_device("DG", "Batt",           "N104_Ubatt",                     "Volt",                "datahub", "5007",  "3m", "Spannung",     "line", "2");
  add_room("MW_Wohnzimmer");
  add_device("DG", "Temp",           "MW_Wohnzimmer_Temp",             "&deg;C",              "datahub", "51",   "1d", "Temperatur",   "line", "1");
  add_device("HT", "Heizung",        "HT_MW_Wohnzimmer",               "",                    "",        "",     "",   "",             "",     "" );
  add_device("DG", "Humi",           "MW_Wohnzimmer_Humi",             "&#037;",              "datahub", "52",   "1d", "Luftfeuchtigkeit", "line", "1");
  add_device("DG", "Batt",           "N108_Ubatt",                     "Volt",                "datahub", "5011",  "3m", "Spannung",     "line", "2");
  add_room("MW_Kueche");
  add_device("HT", "Heizung",        "HT_MW_Kueche",                   "",                    "",        "",     "",   "",             "",     "" );
});

</script>

   
<div id="haus" class="haus">Test
</div>  

