<script> var basedir="/admin/"; </script>

<script src="/js/haussteuerung.js"></script>
<link rel="stylesheet" href="/css/haussteuerung.css" />

<script type="text/javascript">

$(document).ready(function() {

  haus("Haussteuerung");
  add_room(1, "Draussen");
  add_device(1, 1, "DG", "Temp",            "Aussen_Temp",                   "&deg;C",              "datahub",  "1",   "1d", "Temperatur", "line", "1");
  add_device(1, 2, "SW", "Balkon",          "Terassennode_Balkon",           "HS_Balkon_Steckdose",  "504",     "",     "",   "",          "",     "" );
  add_device(1, 3, "SW", "Terasse",         "Terassennode_Terasse",          "HS_Terasse_Steckdose", "505",     "",     "",   "",          "",     "" );
  add_device(1, 4, "SW", "Teich",           "TeichPumpe",                    "HS_Teichpumpe",        "500",     "",     "",   "",          "",     "" );
  add_device(1, 5, "DG", "Terassentemp",    "Terasse_Temp",                  "&deg;C",              "datahub",  "21",  "1d", "Temperatur", "line", "1");
  add_device(1, 6, "DG", "Schuppentemp",    "Schuppen_Temp",                 "&deg;C",              "datahub",  "22",  "1d", "Temperatur", "line", "1");
  add_room(2, "Solaranlage");
  add_device(2, 1, "DG", "Aktuell",         "Solaranlage_Erzeugung_Aktuell",  "W",                  "datahub",  "1050", "1d", "Erzeugung", "line", "1");
  add_device(2, 2, "DG", "Tag",             "Solaranlage_Erzeugung_Tag",      "KWh",                "datahub",  "1053", "1m", "KWh/Tag",   "bar",  "1");
  add_device(2, 3, "DG", "Total",           "Solaranlage_Erzeugung_Total",    "KWh",                "datahub",  "1053", "1y", "KWh/Tag",   "bar",  "0");
  add_device(2, 4, "DG", "Akku Ladung",     "Solaranlage_Batt_Proz",          "%",                  "datahub",  "1056", "1d", "Ladestand", "line", "1");
  add_device(2, 5, "DG", "Akku Charge",     "Solaranlage_Batt_Charge",        "W",                  "datahub",  "1051", "1d", "Laden/Entladen", "line", "1");
  add_device(2, 6, "--", "Ladezyklen",      "Solaranlage_Ladezyklen",         "",                     "0",        "",     "",   "",          "",     "");
  add_room(3, "Balkonkraftwerk");
  add_device(3, 1, "DG", "Aktuell",         "Balkonkraftwerk_cur",            "W",                  "datahub",  "1010", "1d", "Erzeugung", "line", "1");
  add_device(3, 2, "DG", "Tag",             "Balkonkraftwerk_ds",             "KWh",                "datahub",  "1011", "1m", "KWh/Tag",   "bar",  "1");
  add_device(3, 3, "DG", "Total",           "Balkonkraftwerk_tot",            "KWh",                "datahub",  "1012", "1y", "KWh/Tag",   "bar",  "0");
  add_room(4, "Gas");
  add_device(4, 1, "DG", "Gas akt.",        "GasVerbrauch_KW_aktuell",        "KW",                 "datahub", "1004", "1d", "Gasverbrauch", "line", "0");
  add_device(4, 2, "DG", "Gas Tag",         "GasVerbrauch_KWH_Tag",           "KWh",                "datahub", "1003", "1m", "Gasverbrauch", "bar",  "0");
  add_device(4, 3, "DG", "Gas Monat",       "GasVerbrauch_Monat",             "KWh",                "datahub", "1003", "1y", "Gasverbrauch", "bar",  "0");
  add_device(4, 4, "--", "Gas Jahr",        "GasVerbrauch_Jahr",              "KWh",                "0",        "",     "",    "",            "",     "" );
  add_room(5, "Keller");
  add_device(5, 1, "DG", "Strom Last",      "Solaranlage_Local_Load",         "W",                  "datahub",  "1052", "1d", "Strom Last", "line", "1");
  add_device(5, 2, "DG", "Stromzaehler",    "Stromzaehler_in",                "KWh",                "datahub",  "1091", "1m", "Stromimport",  "bar",  "0");
  add_device(5, 3, "DG", "Exportzaehler",   "Stromzaehler_out",               "KWh",                "datahub",  "1092", "1m", "Stromexport" , "bar",  "0");
  add_device(5, 4, "--", "Gaszaehler",      "GasZaehler",                     "",                   "1",        "",     "",    "",            "",     "" );
  add_device(5, 5, "DG", "Temp",            "Keller_Temp",                    "&deg;C",             "datahub",  "30", "1d", "Temperatur",   "line", "1");
  add_device(5, 6, "DG", "Batt",            "N111_Ubatt",                     "Volt",               "datahub",  "5014", "3m", "Spannung",     "line", "2");
  add_room(6, "Wohnzimmer");
  add_device(6, 1, "DG", "Temp",            "Wohnzimmer_Temp",                "&deg;C",              "datahub", "24",   "1d", "Temperatur",   "line", "1");
  add_device(6, 2, "HT", "Hzg_gr",          "HT_Wohnzimmer1",                 "",                    "",        "",     "",   "",             "",     "" );
  add_device(6, 3, "HT", "Hzg_kl",          "HT_Wohnzimmer2",                 "",                    "",        "",     "",   "",             "",     "" );
  add_device(6, 4, "SW", "Licht",           "wohnzimmerlicht_",               "HS_WohnzimmerLicht",  "",        "",     "",   "",             "",     "" );
  add_device(6, 5, "SW", "Display",         "WohnzimmerDisplay",              "HS_WohnzimmerNode",   "",        "",     "",   "",             "",     "" );
  add_device(6, 6, "SW", "Schranklicht",    "Steckdose1_",                    "HS_Steckdose1",       "",        "",     "",   "",             "",     "" );
  add_room(7, "Kueche");
  add_device(7, 1, "DG", "Temp",            "Kueche_Temp",                    "&deg;C",              "datahub", "25",   "1d", "Temperatur",   "line", "1");
  add_device(7, 2, "HT", "Hzg_gr",          "HT_Kueche1",                     "",                    "",        "",     "",   "",             "",     "" );
  add_device(7, 3, "HT", "Hzg_Handtuch",    "HT_Kueche2",                     "",                    "",        "",     "",   "",             "",     "" );
  add_device(7, 4, "DG", "Batt",            "N103_Ubatt",                     "Volt",                "datahub", "5006",  "3m", "Spannung",     "line", "2");
  add_room(8, "Bastelzimmer");
  add_device(8, 1, "DG", "Temp",            "Bastelzimmer_Temp",              "&deg;C",              "datahub", "27",   "1d", "Temperatur",   "line", "1");
  add_device(8, 2, "HT", "Heizung",         "HT_Bastelzimmer",                "",                    "",        "",     "",   "",             "",     "" );
  add_device(8, 3, "DG", "Batt",            "N102_Ubatt",                     "Volt",                "datahub", "5003",  "3m", "Spannung",     "line", "1");
  add_room(9, "Flur");
  add_device(9, 1, "DG", "Temp",            "Flur_Temp",                      "&deg;C",              "datahub", "23",   "1d", "Temperatur",   "line", "1");
  add_device(9, 2, "SW", "Treppenhaus",     "TreppenhausLicht_",              "HS_TreppenhausLicht", "",        "",     "",   "",             "",     "" );
  add_device(9, 3, "SW", "Flurlicht",       "FlurLicht_",                     "HS_FlurLicht",        "501",     "",     "",   "",             "",     "" );
  add_room(10, "Schlafzimmer");
  add_device(10, 1, "DG", "Temp",            "Schlafzimmer_Temp",              "&deg;C",             "datahub", "26",   "1d", "Temperatur",   "line", "1");
  add_device(10, 2, "DG", "Batt",            "N102_Ubatt",                     "Volt",               "datahub", "5005",  "3m", "Spannung",     "line", "2");
  add_room(11, "Ankleidezimmer");
  add_device(11, 1, "DG", "Temp",            "Ankleidezimmer_Temp",            "&deg;C",             "datahub", "28",   "1d", "Temperatur",   "line", "1");
  add_device(11, 2, "DG", "Batt",            "N110_Ubatt",                     "Volt",               "datahub", "5013",  "3m", "Spannung",     "line", "2");
  add_room(12, "Badezimmer");
  add_device(12, 1, "DG", "Temp",           "Kugelnode1_Temp",                "&deg;C",              "datahub", "31",  "1d", "Temperatur",   "line", "1");
  add_device(12, 2, "DG", "Batt",           "N106_Ubatt",                     "Volt",                "datahub", "5009",  "3m", "Spannung",     "line", "2");
  add_room(13, "Gaestezimmer");
  add_device(13, 1, "DG", "Temp",           "Gaestezimmer_Temp",              "&deg;C",              "datahub", "29",  "1d", "Temperatur",   "line", "1");
  add_device(13, 2, "DG", "Batt",           "N104_Ubatt",                     "Volt",                "datahub", "5007",  "3m", "Spannung",     "line", "2");
  add_room(14, "MW_Wohnzimmer");
  add_device(14, 1, "DG", "Temp",           "MW_Wohnzimmer_Temp",             "&deg;C",              "datahub", "51",   "1d", "Temperatur",   "line", "1");
  add_device(14, 2, "HT", "Heizung",        "HT_MW_Wohnzimmer",               "",                    "",        "",     "",   "",             "",     "" );
  add_device(14, 3, "DG", "Humi",           "MW_Wohnzimmer_Humi",             "&#037;",              "datahub", "52",   "1d", "Luftfeuchtigkeit", "line", "1");
  add_device(14, 4, "DG", "Batt",           "N108_Ubatt",                     "Volt",                "datahub", "5011",  "3m", "Spannung",     "line", "2");
  add_room(15, "MW_Kueche");
  add_device(15, 1, "HT", "Heizung",        "HT_MW_Kueche",                   "",                    "",        "",     "",   "",             "",     "" );

});

</script>

   
<div id="haus" class="haus">Test
</div>  

