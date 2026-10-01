<script> var basedir="/admin/"; </script>

<script src="/js/haussteuerung.js"></script>
<link rel="stylesheet" href="/css/haussteuerung.css" />

<script type="text/javascript">

$(document).ready(function() {

  haus("Haussteuerung");
  add_room("Draussen");
  add_device("DG", "Temp",         "Aussen_Temp",                   "°C",   "1",   "1d", "line", "Temperatur", "1");
  add_device("DG", "Feuchte",      "Aussen_Humi",                   "%",    "3",   "1d", "line", "Luftfeuchte", "0");
  add_device("SW", "Balkon",       "Terassennode_Balkon",           "",     "HS_Balkon_Steckdose",  "504");
  add_device("SW", "Terasse",      "Terassennode_Terasse",          "",     "HS_Terasse_Steckdose", "505");
  add_device("SW", "Teich",        "TeichPumpe",                    "",     "HS_Teichpumpe",        "500");
  add_device("DG", "Terassentemp", "Terasse_Temp",                  "°C",   "21",  "1d", "line", "Temperatur", "1");
  add_device("DG", "Schuppentemp", "Schuppen_Temp",                 "°C",   "22",  "1d", "line", "Temperatur", "1");

  add_room("Solaranlage");
  add_device("VD", "PV Anlage",    "Solaranlage_Erzeugung_Aktuell", "W",  "1050", "1053", "Solaranlage_Erzeugung_Tag", "Solaranlage_Erzeugung_Monat", "Solaranlage_Erzeugung_Jahr", "Stromerzeugung", "kWh" );
  add_device("MD", "Akku Ladung",  "Solaranlage_Batt_Proz",         "%",  "1056", "1056", "Ladestand", "rbar");
  add_device("DG", "Akku Zyklen",  "Solaranlage_Ladezyklen",        "",   "1051", "1",    "line",      "Laden/Entladen", "1");
  add_device("VD", "Balkon KW",    "Balkonkraftwerk_cur",           "W",  "1010", "1011", "Balkonkraftwerk_Tag", "Balkonkraftwerk_Monat", "Balkonkraftwerk_Jahr", "Stromerzeugung", "kWh");

  add_room("Strom");
  add_device("VD", "Stromverbr.",  "Solaranlage_Local_Load",      "W",    "1052", "1058", "Stromverbrauch_tag", "Stromverbrauch_monat", "Stromverbrauch_jahr", "Stromverbrauch", "kWh");
  add_device("VD", "Strom in",     "Stromzaehler_in",             "W",    "1094", "1091", "Stromverbrauch_zaehler_tag", "Stromverbrauch_zaehler_monat",  "Stromverbrauch_zaehler_jahr",   "Stromverbrauch", "kWh");
  add_device("VD", "Strom out",    "Stromzaehler_out",            "W",    "1095", "1092", "Stromexport_tag", "Stromexport_monat", "Stromexport_jahr", "Stromexport", "kWh" );

  add_room("Wärmepumpe");
  add_device("DG", "WW-Temp",      "WP_ww_ist",                   "°C",   "1100",   "1d", "line", "Temperatur", "1");
  add_device("VD", "Strom in",     "WP_el",                       "",     "1103",  "1106", "WP_el_Tag", "WP_el_Monat",  "WP_el_Jahr",   "Stromverbrauch", "kWh");
  add_device("VD", "Heat out",     "WP_th",                       "",     "1102",  "1105", "WP_th_Tag", "WP_th_Monat",  "WP_th_Jahr",   "Wärmeleistung", "kWh");
  add_device("VD", "Heat Hzg out", "WP_hzg_th",                   "",     "1102",  "1113", "WP_hzg_th_Tag", "WP_hzg_th_Monat",  "WP_hzg_th_Jahr",   "Wärmeleistung", "kWh");
  add_device("VD", "Heat WW out",  "WP_ww_th",                    "",     "1102",  "1112", "WP_ww_th_Tag", "WP_ww_th_Monat",  "WP_ww_th_Jahr",   "Wärmeleistung", "kWh");
  add_device("DG", "AZ aktuell",   "WP_pow_arbeitszahl",          "",     "1107",   "1d", "line", " ", "1");
  add_device("DG", "Hzg. VL",      "WP_hzg_vl_temp",              "°C",   "1110",   "1d", "line", "Temperatur", "1");
  add_device("DG", "Hzg. RL",      "WP_hzg_rl_temp",              "°C",   "1111",   "1d", "line", "Temperatur", "1");


  add_room("Keller");
  add_device("DG", "Temp",         "Keller_Temp",                  "°C",   "30",   "1d", "line",    "Temperatur", "1");
  add_device("DG", "Batt",         "N111_Ubatt",                   "Volt", "5014", "1y", "line",    "Spannung", "2", "2", "3.3");

  add_room("Wohnzimmer");
  add_device("DG", "Temp",         "Wohnzimmer_Temp",              "°C",  "24",   "1d",   "line", "Temperatur", "1");
  add_device("DG", "Humi",         "Wohnzimmer_Humi",              "%",   "61",   "1d",   "line", "Luftfeuchtigkeit", "0");
  add_device("HT", "Hzg_gr",       "HT_Wohnzimmer1");
  add_device("HT", "Hzg_kl",       "HT_Wohnzimmer2");
  add_device("SW", "Licht",        "WohnzimmerLicht",              "",         "HS_WohnzimmerLicht",  "0");
  add_device("SW", "Display",      "WohnzimmerDisplay",            "",         "HS_WohnzimmerNode",   "0");

  add_room("Kueche");
  add_device("DG", "Temp",         "Kueche_Temp",                  "°C",    "25",   "1d",   "line", "Temperatur", "1");
  add_device("DG", "Humi",         "Kueche_Humi",                  "%",     "62",   "1d",   "line", "Luftfeuchtigkeit", "0");
  add_device("HT", "Hzg_gr",       "HT_Kueche1");
  add_device("HT", "Hzg_Handtuch", "HT_Kueche2");
  add_device("DG", "Batt",         "N103_Ubatt",                   "Volt",      "5006",  "1y",  "line", "Spannung",   "2");

  add_room("Bastelzimmer");
  add_device("DG", "Temp",         "Bastelzimmer_Temp",            "&deg;C",    "27",   "1d",   "line", "Temperatur", "1");
  add_device("DG", "Humi",         "Bastelzimmer_Humi",            "&percnt;",  "64",   "1d",   "line", "Luftfeuchtigkeit", "0");
  add_device("HT", "Heizung",      "HT_Bastelzimmer");
  add_device("DG", "Batt",         "N102_Ubatt",                   "Volt",      "5003",  "1y",  "line", "Spannung",  "1");

  add_room("Flur");
  add_device("DG", "Temp",         "Flur_Temp",                    "&deg;C",    "23",   "1d",   "line", "Temperatur", "1");
  add_device("SW", "Treppenhaus",  "TreppenhausLicht",             "",         "HS_TreppenhausLicht",  "0");
  add_device("SW", "Flurlicht",    "FlurLicht",                    "",         "HS_FlurLicht",        "501");

  add_room("Schlafzimmer");
  add_device("DG", "Temp",         "Schlafzimmer_Temp",           "&deg;C",     "26",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Batt",         "N102_Ubatt",                  "Volt",       "5005",  "1y",   "line", "Spannung",   "2");

  add_room("Ankleidezimmer");
  add_device("DG", "Temp",         "Ankleidezimmer_Temp",         "&deg;C",     "28",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Humi",         "Ankleidezimmer_Humi",         "&#037;",     "63",    "1d",   "line", "Luftfeuchtigkeit",  "0");
  add_device("DG", "Batt",         "N110_Ubatt",                  "Volt",       "5013",  "1y",   "line", "Spannung",   "2");

  add_room("Badezimmer");
  add_device("DG", "Temp",         "Kugelnode1_Temp",             "&deg;C",     "31",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Batt",         "N106_Ubatt",                  "Volt",       "5009",  "1y",   "line", "Spannung",   "2");

  add_room("Gaestezimmer");
  add_device("DG", "Temp",         "Gaestezimmer_Temp",           "&deg;C",     "29",    "1d",   "line", "Temperatur", "1");
  add_device("DG", "Humi",         "Gaestezimmer_humi_aht",       "&percnt;",   "60",    "1d",   "line", "Luftfeuchtigkeit", "0");
  add_device("DG", "Batt",         "N104_Ubatt",                  "Volt",       "5007",  "1y",   "line", "Spannung",   "2");

  add_room("MW_Wohnzimmer");
  add_device("DG", "Temp",         "MW_Wohnzimmer_Temp",          "&deg;C",     "51",   "1d",    "line", "Temperatur", "1");
  add_device("HT", "Heizung",      "HT_MW_Wohnzimmer");
  add_device("DG", "Humi",         "MW_Wohnzimmer_Humi",          "&#037;",     "52",   "1d",    "line", "Luftfeuchtigkeit", "1");
  add_device("DG", "Batt",         "N108_Ubatt",                  "Volt",       "5011", "1y",    "line", "Spannung",   "2");

  add_room("MW_Kueche");
  add_device("HT", "Heizung",      "HT_MW_Kueche");

  add_room("MW_Schlafzimmer");
  add_device("HT", "Heizung",      "HT_MW_Schlafzimmer");

  add_room("Batterien");
  add_device("DG", "A-Therm o.",   "N200_Ubatt",                  "Volt",       "5001", "1y",    "line", "Spannung",   "2");
  add_device("DG", "A-Therm u.",   "N201_Ubatt",                  "Volt",       "5002", "1y",    "line", "Spannung",   "2");
  add_device("DG", "Therm Bad",    "N106_Ubatt",                  "Volt",       "5009", "1y",    "line", "Spannung",   "2");
  add_device("DG", "Kugel Flur",   "N107_Ubatt",                  "Volt",       "5010", "1y",    "line", "Spannung",   "2");
  add_device("DG", "SN Akz.",      "N124_Ubatt",                  "Volt",       "5024", "1y",    "line", "Spannung",   "2");
  add_device("DG", "SN 1.",        "N121_Ubatt",                  "Volt",       "5021", "1y",    "line", "Spannung",   "2");
  add_device("DG", "SN 2.",        "N122_Ubatt",                  "Volt",       "5022", "1y",    "line", "Spannung",   "2");
  add_device("DG", "SN 3.",        "N123_Ubatt",                  "Volt",       "5023", "1y",    "line", "Spannung",   "2");


});

</script>

   
<div id="haus" class="haus">Test
</div>  

