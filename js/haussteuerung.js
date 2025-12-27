var arrow_up = "/img/arrow_up.gif";
var arrow_down = "/img/arrow_down.gif";
var getfhem = "/admin/getfhem.php";
var needhelp = "/img/gefahrenstelle_20x20.jpg"
var w = screen.width;
var devwidth = "25%"
var but_color_old;
var but_active = '#AAAAAA';
var but_passive = '#DDDDDD';
var but_handover = '#BBBBBB';
var room_no = 0;
var dev_no = 0;

function device_switch_get_state(room, dev, fhem_HS_dev, fhem_dev) {
    var result;
    $.get(basedir+'getfhem.php',{geraet: fhem_HS_dev, eigenschaft: "state" }, function(data) {
        if (data == 0) { result = "(aus) "; } else { result = "("+data+") "; }
        if (data == 1) { result = "(ein) "; }
        if (data == 2) { result = "(auto) "; }
        switch (data) {
            case "aus":
                $("#r" + room + "sws1b").css("background-color", "#a80329");
                $("#r" + room + "sws2b").css("background-color", "grey");
                $("#r" + room + "sws3b").css("background-color", "grey");
            break;
            case "auto":
                $("#r" + room + "sws1b").css("background-color", "grey");
                $("#r" + room + "sws2b").css("background-color", "#a80329");
                $("#r" + room + "sws3b").css("background-color", "grey");
            break;
            case "ein":
                $("#r" + room + "sws1b").css("background-color", "grey");
                $("#r" + room + "sws2b").css("background-color", "grey");
                $("#r" + room + "sws3b").css("background-color", "#a80329");
            break;
        }
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
            if (data == 0) { result += "aus"; }
            if (data == 1) { result += "ein"; }
            $("#r"+room+"d"+dev+"v").html(result);
            switch(data) {
                case "1":
                case "on":
                    $("#r"+room+"sws0b").css("background-color", "yellow"); //.css("color","black");
                break;
                case "0":
                case "off":
                    $("#r"+room+"sws0b").css("background-color", "black").css("color","white");
                break;
                default:
                    $("#r"+room+"sws0b").append("-"+data);
            }
            show_sw_val(fhem_dev, fhem_HS_dev, room, dev );
        });
	});
}

function device_switch_click_func(room, dev, fhem_HS_dev, fhem_dev, dev_state) {
    $.get(basedir+'setfhem.php',{geraet: fhem_HS_dev, eigenschaft: " ", wert: dev_state }, function(data) {
        setTimeout(function() {
            device_switch_get_state(room, dev, fhem_HS_dev, fhem_dev);
        }, 5000);
            device_switch_get_state(room, dev, fhem_HS_dev, fhem_dev);
    });
}

function haus(titel) {
  // Parameter:
  // titel = Die Ueberschrift in der ersten Zeile (zentriert)
  $("#haus").html("<div class='haus_head'>" + titel + "</div>");
}

function show_val(room, dev, result, lev1, lev2, lev3) {
    $("#r"+room+"d"+dev+"v").html(result);
    if ( window.innerWidth < 600 ) {
        if (result.length > lev1 - 5) $("#r" + room + "d" + dev + "v").css("font-size","small");
        if (result.length > lev2 - 5) $("#r" + room + "d" + dev + "v").css("font-size","x-small");
        if (result.length > lev3 - 5) $("#r" + room + "d" + dev + "v").css("font-size","xx-small");
    } else {
        if (result.length > lev1) $("#r" + room + "d" + dev + "v").css("font-size","small");
        if (result.length > lev2) $("#r" + room + "d" + dev + "v").css("font-size","x-small");
        if (result.length > lev3) $("#r" + room + "d" + dev + "v").css("font-size","xx-small");
    }
}

function show_ht_val(fhem_dev, room, dev ) {
    var result;
    var mode;
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "mode" }, function(data) {
        if (data.localeCompare("manual") == 0) {
            mode = "man.";
        } else {
            mode = "auto";
        }
        result = "(" + mode + ") ";
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature" }, function(data) {
            result += parseInt(data*10)/10+" &deg;C";
            show_val(room, dev, result, 17, 22, 27);
        });
      });

}

function show_sw_val(fhem_dev, fhem_HS_dev, room, dev ) {
    var result;
    $.get(basedir+'getfhem.php',{geraet: fhem_HS_dev, eigenschaft: "state" }, function(data) {
        if (data == 0) { result = "(aus) "; } else { result = "("+data+") "; }
        if (data == 1) { result = "(ein) "; }
        if (data == 2) { result = "(auto) "; }
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
            if (data == 0) { result += "aus"; }
            if (data == 1) { result += "ein"; }
            show_val(room, dev, result, 15, 20, 25);
        });
    });
}

/*******************************************************************************
 * Im Raum werden folgende Felder angelegt:
 * r<X>     => Der Raum
 * r<X>h    => Eine Kofzeile zur Beschriftung
 * r<X>x    => Ein verstecktes Feld, hier wird eingetragen ob (>1) und welches device ein Diagramm geöffnet hat
 * r<X>a    => Ein Feld als Wrapper für Diagramm bzw. Schalter oder Regler
 * r<X>a1   => Ein Feld als Zeitdiagramm
 * r<X>d    => Ein Wrapper für die Devices
 * r<X>d<Y> => 10 Platzhalter für Devices
 *******************************************************************************/
function add_room(room_name ) {
    room_no++;
    dev_no = 0;
    $("#haus").append("<div class='room' id='r" + room_no + "'></div>");
    $("#r" + room_no).append("<div class='room_head' id='r" + room_no + "h'></div>"+
                              "<div class='room_dev' id='r" + room_no + "d'></div>"+
                              "<div class='room_dia' id='r" + room_no + "a'></div>"+
                              "<div id='r" + room_no + "x'>0</div>");
    $("#r" + room_no + "h").html(room_name);
    $("#r" + room_no + "a").hide();
    $("#r" + room_no + "x").hide();
    $("#r"+room_no+"d").append("<div class='dev dev_1' id='r" + room_no + "d1'></div>").append("<div class='dev dev_2' id='r" + room_no + "d2'></div>"+
                               "<div class='dev dev_3' id='r" + room_no + "d3'></div>").append("<div class='dev dev_4' id='r" + room_no + "d4'></div>"+
                               "<div class='dev dev_5' id='r" + room_no + "d5'></div>").append("<div class='dev dev_6' id='r" + room_no + "d6'></div>"+
                               "<div class='dev dev_7' id='r" + room_no + "d7'></div>").append("<div class='dev dev_8' id='r" + room_no + "d8'></div>");
    $("#r"+room_no+"d1").hide();
    $("#r"+room_no+"d2").hide();
    $("#r"+room_no+"d3").hide();
    $("#r"+room_no+"d4").hide();
    $("#r"+room_no+"d5").hide();
    $("#r"+room_no+"d6").hide();
    $("#r"+room_no+"d7").hide();
    $("#r"+room_no+"d8").hide();
    if ( window.innerWidth < 600 ) {
//       $("#r" + room_no).css("height","80px;");
        $("#r" + room_no + "d1").css("width",devwidth).css("left","0%");
        $("#r" + room_no + "d1l").css("font-size","small");
        $("#r" + room_no + "d1v").css("font-size","x-small");
        $("#r" + room_no + "d2").css("width",devwidth).css("left","25%");
        $("#r" + room_no + "d2l").css("font-size","small");
        $("#r" + room_no + "d2v").css("font-size","x-small");
        $("#r" + room_no + "d3").css("width",devwidth).css("left","50%");
        $("#r" + room_no + "d3l").css("font-size","small");
        $("#r" + room_no + "d3v").css("font-size","x-small");
        $("#r" + room_no + "d4").css("width",devwidth).css("left","75%");
        $("#r" + room_no + "d4l").css("font-size","small");
        $("#r" + room_no + "d4v").css("font-size","x-small");
        $("#r" + room_no + "d5").css("width",devwidth).css("left","0%");
        $("#r" + room_no + "d5l").css("font-size","small");
        $("#r" + room_no + "d5v").css("font-size","x-small");
        $("#r" + room_no + "d6").css("width",devwidth).css("left","25%");
        $("#r" + room_no + "d6l").css("font-size","small");
        $("#r" + room_no + "d6v").css("font-size","x-small");
        $("#r" + room_no + "d7").css("width",devwidth).css("left","50%");
        $("#r" + room_no + "d7l").css("font-size","small");
        $("#r" + room_no + "d7v").css("font-size","x-small");
        $("#r" + room_no + "d8").css("width",devwidth).css("left","75%");
        $("#r" + room_no + "d8l").css("font-size","small");
        $("#r" + room_no + "d8v").css("font-size","x-small");
    }
}

/*****************************************************************
 * Folgende Devices sind hinterlegt:
 *
 *
 *
 * VG - Versorgungsgrafik für z.B Gas, Strom
 *      Aufbau: Eine Zeile Historie: Tag, Monat, Jahr
 *              Diagramm: Tagesübersicht als Liniendiagramm
 *                        Monatsdiagramm und höhere als Balkendiagramm
 *
 * Aufruf ist teilweise abhängig von dem Typ (dev_typ):
 * Einheitlicher Teil:
 * dev_typ = Geräte Typ; dev_name = Beschriftung; fhem_dev = FHEM Device für den aktuellen Wert; einheit = physikalische Einheit von "fhem_dev"
 *
 * Die weiteren Parameter (p1 bis p6) sind abhängig vom Geräte Typ.
 *
 * Geräte Typ Shalter     (SW): p1 = Hauptschalterdevice p2 = SensorID p3 ... p6 = ""
 * Heizungsthermostat     (HT): p1 ... p6 = ""
 * Diagramm generisch     (DG): p1 = Sensorno; p2 = Zeitspanne (1d, 1m, 3m, 1y); p3 = Diagrammtyp; p4 = Legende;
 *                              p5 = Nachkommastellen; p6 = ""
 * Verbrauchsdiagramm     (VD)  p1 = Sensorno intraday; p2 = Sensorno monatlich und mehr; p3 = Fhem Tagesverbrauch; p4 = Fhem Monatsverbrauch;
 *                              p5 = Fhem Jahresverbrauch; p6 = Legende; p7 Einheit Diagramm
 * Multidiagramm          (MD)  p1 = Sensorno intraday; p2 = Sensorno monatlich und mehr; p3 = Legende intraday; p4 = Legende monatlich und mehr
 *                              p5 = Säulenty (bar oder rbar)
 * Ohne Pulldown          (--): p1 = Dezimalstellen p2 ... p6 = ""
 ****************************************************************/
function add_device(dev_typ, dev_name, fhem_dev, einheit, p1, p2, p3, p4, p5, p6, p7, p8) {
  dev_no++;
  var result = " ";
  var value  = 0;
  var room = room_no;
  var dev = dev_no;
  $("#r" + room_no + "d" + dev_no).append("<div class='dev_l' id='r" + room_no + "d" + dev_no + "l'>" + dev_name + "</div>")
                                  .append("<div class='dev_v' id='r" + room_no + "d" + dev_no + "v'></div>")
                                  .append("<div class='dev_p' id='r" + room_no + "d" + dev_no + "p'></div>")
                                  .show();
  $("#r" + room_no + "d" + dev_no + "p").append("<img id='r"+ room_no + "d" + dev_no + "ba' src='"+arrow_up+"' width='100%' height='100%' />");
  if ( window.innerWidth < 600 ) {
    if (dev_name.length > 10) $("#r" + room_no + "d" + dev_no + "l").css("font-size","small");
    if (dev_name.length > 15) $("#r" + room_no + "d" + dev_no + "l").css("font-size","x-small");
    if (dev_name.length > 20) $("#r" + room_no + "d" + dev_no + "l").css("font-size","xx-small");
  } else {
    if (dev_name.length > 15) $("#r" + room_no + "d" + dev_no + "l").css("font-size","small");
    if (dev_name.length > 20) $("#r" + room_no + "d" + dev_no + "l").css("font-size","x-small");
    if (dev_name.length > 25) $("#r" + room_no + "d" + dev_no + "l").css("font-size","xx-small");
  }
//-----Anzeige in Devicefeld-------
//######### HT ############
  if (dev_typ.localeCompare("HT") == 0) {
    show_ht_val(fhem_dev, room, dev );
  }
//######### SW ############
  if (dev_typ.localeCompare("SW") == 0) {
    show_sw_val(fhem_dev, p1, room, dev );
  }
//######## DG oder VG Diagramm generisch ###########
  if ((dev_typ.localeCompare("DG") == 0) || (dev_typ.localeCompare("VD") == 0) || (dev_typ.localeCompare("MD") == 0)) {
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
      if (dev_typ.localeCompare("DG") == 0) {
        if ( p5 == 0 ) value = Math.round(data);
        if ( p5 == 1 ) value = Math.round(data * 10) / 10;
        if ( p5 == 2 ) value = Math.round(data * 100) / 100;
      } else {
        value = Math.round(data * 10) / 10;
      }
      result = value + " " + einheit;
//      alert(fhem_dev+" "+data+" "+value+" "+result);
      show_val(room, dev, result, 15, 20, 25);
    });
  }
//######## -- Kein Diagramm ###########
  if (dev_typ.localeCompare("--") == 0) {
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
      if ( p2 == 0 ) value = Math.round(data);
      if ( p2 == 1 ) value = Math.round(data * 10) / 10;
      if ( p2 == 2 ) value = Math.round(data * 100) / 100;
      result = value + " " + einheit;
      show_val(room, dev, result, 15, 20, 25);
    });
    $("#r"+room_no+"d"+dev_no+"p").hide();
    $("#r"+room_no+"d"+dev_no+"l").css("width","100%");
    $("#r"+room_no+"d"+dev_no+"v").css("width","100%");
    $("#r"+room_no+"d"+dev_no).css("border-right","1px solid #a80329");
    if (window.innerWidth > 800 && dev_name.length < 15) $("#r" + room_no + "d" + dev_no + "l").css("font-size","medium");
  }
//####### ENDE ############
//-----Ende Anzeige in Devicefeld-------
  $("#r" + room_no + "d" + dev_no + "p").click(function() {
    const id = $(this).attr("id");
    const array1 = id.split("r");
    const array2 = array1[1].split("d");
    const my_room = array2[0];
    const my_dev  = array2[1].substring(0,1);
//        alert("MyRoom: "+my_room+" MyDev: "+my_dev);
    if ( ! ($("#r" + my_room + "x").html() == 0 || $("#r" + my_room + "x").html() == my_dev) ) {
      alert("Grafik geöffnet, bitte schliessen");
    } else {
      if ($("#r" + my_room + "a").is(':hidden')) {
        $("#r" + my_room + "x").html(my_dev);
        $("#r" + my_room + "a").show();
//-----Anzeige im externen Detailfeld-------
//######## DG Liniendiagramm generisch und VG Versorgerdiagramm und MD Multidiagramm ###########
        if ( (dev_typ.localeCompare("DG") == 0) || (dev_typ.localeCompare("VD") == 0) || (dev_typ.localeCompare("MD") == 0) ) {
          $("#r" + my_room + "a").html(" ");
          if (dev_typ.localeCompare("VD") == 0) {
            $("#r" + my_room + "a").append("<div id='r"+my_room+"dh' style='height:45px;'></div>");
            $("#r" + my_room + "dh").append("<div id='r"+my_room+"dh1' class='hist hist_d'>Tag</div>")
                                    .append("<div id='r"+my_room+"dh2' class='hist hist_m'>Monat</div>")
                                    .append("<div id='r"+my_room+"dh3' class='hist hist_y'>Jahr</div>");
            $("#r" + my_room + "dh1").click(function(){
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p6);
              $("#r" + my_room + "dh1").css("background",but_active)
              $("#r" + my_room + "dh2").css("background",but_passive)
              $("#r" + my_room + "dh3").css("background",but_passive)
              $("#r" + my_room + "_nav1").css("background",but_active)
              $("#r" + my_room + "_nav2").css("background",but_passive)
              $("#r" + my_room + "_nav3").css("background",but_passive)
              $("#r" + my_room + "_nav4").css("background",but_passive)
              but_color_old = but_active;
              $("#r" + my_room + "_buf1").html("1d");
              $("#r" + my_room + "_buf2").html("0");
            }).on( "mouseover", function() {
              but_color_old = $(this).css("background-color");
              $(this).css("background-color", but_handover);
            }).on( "mouseout", function() {
              $(this).css("background-color", but_color_old);
            }).css("cursor","pointer");
            $("#r" + my_room + "dh2").click(function(){
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sum=y&sizey=370&range=1m&graph=bar&sensor1legend="+p7);
              $("#r" + my_room + "dh1").css("background",but_passive)
              $("#r" + my_room + "dh2").css("background",but_active)
              $("#r" + my_room + "dh3").css("background",but_passive)
              $("#r" + my_room + "_nav1").css("background",but_passive)
              $("#r" + my_room + "_nav2").css("background",but_active)
              $("#r" + my_room + "_nav3").css("background",but_passive)
              $("#r" + my_room + "_nav4").css("background",but_passive)
              but_color_old = but_active;
              $("#r" + my_room + "_buf1").html("1m");
              $("#r" + my_room + "_buf2").html("0");
            }).on( "mouseover", function() {
              but_color_old = $(this).css("background-color");
              $(this).css("background-color", but_handover);
            }).on( "mouseout", function() {
              $(this).css("background-color", but_color_old);
            }).css("cursor","pointer");
            $("#r" + my_room + "dh3").click(function(){
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sum=y&sizey=370&range=1y&graph=bar&sensor1legend="+p7);
              $("#r" + my_room + "dh1").css("background",but_passive)
              $("#r" + my_room + "dh2").css("background",but_passive)
              $("#r" + my_room + "dh3").css("background",but_active)
              $("#r" + my_room + "_nav1").css("background",but_passive)
              $("#r" + my_room + "_nav2").css("background",but_passive)
              $("#r" + my_room + "_nav3").css("background",but_active)
              $("#r" + my_room + "_nav4").css("background",but_passive)
              but_color_old = but_active;
              $("#r" + my_room + "_buf1").html("1y");
              $("#r" + my_room + "_buf2").html("0");
            }).on( "mouseover", function() {
              but_color_old = $(this).css("background-color");
              $(this).css("background-color", but_handover);
            }).on( "mouseout", function() {
              $(this).css("background-color", but_color_old);
            }).css("cursor","pointer");
            $.get(basedir+'getfhem.php',{geraet: p3, eigenschaft: "state" }, function(data) {
              value = Math.round(data * 10) / 10;
              $("#r"+my_room+"dh1").html("Tag:<br>"+value+" KWh");
            });
            $.get(basedir+'getfhem.php',{geraet: p4, eigenschaft: "state" }, function(data) {
              value = Math.round(data);
              $("#r"+my_room+"dh2").html("Monat:<br>"+value+" KWh");
            });
            $.get(basedir+'getfhem.php',{geraet: p5, eigenschaft: "state" }, function(data) {
              value = Math.round(data);
              $("#r"+my_room+"dh3").html("Jahr:<br>"+value+" KWh");
            });
          }
          $("#r" + my_room + "a").append("<div id='r"+my_room+"dx'></div><div id='r"+my_room+"ds' style='height:70px;'></div>");
          $("#r" + my_room + "ds").append("<div id='r" + my_room + "_nav1' class='nav nav1'>Diagramm<br>1 Tag</div>")
                                  .append("<div id='r" + my_room + "_nav2' class='nav nav2'>Diagramm<br>1 Monat</div>")
                                  .append("<div id='r" + my_room + "_nav3' class='nav nav3'>Diagramm<br>1 Jahr</div>")
                                  .append("<div id='r" + my_room + "_nav4' class='nav nav4'>Diagramm<br>10 Jahre</div>")
                                  .append("<div id='r" + my_room + "_nav5' class='nav nav5'><img src='/img/arrow_left.gif' height='50' width='50'></div>")
                                  .append("<div id='r" + my_room + "_nav6' class='nav nav6'><img id='r" + my_room + "_nav6_img' src='/img/arrow_right_e.gif' height='50' width='50'></div>")
                                  .append("<div id='r" + my_room + "_buf1' style='display:none;'></div>")
                                  .append("<div id='r" + my_room + "_buf2' style='display:none;'></div>")
                                  .css("background-color","#aaaaaa");
// Initiales Diagramm
          if (dev_typ.localeCompare("DG") == 0) {
            $("#r" + my_room + "dx").html("<img id='r" + my_room + "dia' src='/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+p2+"&graph="+p3+"&sensor1legend="+p4+"'>");
          }
          if (dev_typ.localeCompare("VD") == 0) {
            $("#r" + my_room + "dx").html("<img id='r" + my_room + "dia' src='/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p6+"'>");
          }
          if (dev_typ.localeCompare("MD") == 0) {
            $("#r" + my_room + "dx").html("<img id='r" + my_room + "dia' src='/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p3+"'>");
          }
// Ende: Initiales Diagramm
// Initiale Schalterfarben
          $("#r" + my_room + "dh1").css("background",but_active)
          $("#r" + my_room + "dh2").css("background",but_passive)
          $("#r" + my_room + "dh3").css("background",but_passive)
          $("#r" + my_room + "_nav1").css("background",but_active)
          $("#r" + my_room + "_nav2").css("background",but_passive)
          $("#r" + my_room + "_nav3").css("background",but_passive)
          $("#r" + my_room + "_nav4").css("background",but_passive)
          $("#r" + my_room + "a1").show();
          $("#r" + my_room + "_buf1").html("1d");
          $("#r" + my_room + "_buf2").html("0");
// ENDE Initiale Schalterfarben
          $("#r" + my_room + "_nav1").click(function(){
            $("#r" + my_room + "_buf1").html("1d");
            $("#r" + my_room + "_buf2").html("0");
// Diagramm nach Klick auf den "1 Tag" Button
            if (dev_typ.localeCompare("DG") == 0) {
                $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p4);
            }
            if (dev_typ.localeCompare("VD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p6);
            }
            if (dev_typ.localeCompare("MD") == 0) {
                $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p3);
            }
// Ende: Diagramm nach Klick auf den "1 Tag" Button
// Schalterfarben 1 Tag
            $("#r" + my_room + "dh1").css("background",but_active)
            $("#r" + my_room + "dh2").css("background",but_passive)
            $("#r" + my_room + "dh3").css("background",but_passive)
            $("#r" + my_room + "_nav1").css("background",but_active)
            $("#r" + my_room + "_nav2").css("background",but_passive)
            $("#r" + my_room + "_nav3").css("background",but_passive)
            $("#r" + my_room + "_nav4").css("background",but_passive)
            but_color_old = but_active;
// Ende: Schalterfarben 1 Tag
          }).on( "mouseover", function() {
            but_color_old = $(this).css("background");
            $(this).css("background", but_handover);
          }).on( "mouseout", function() {
            $(this).css("background", but_color_old);
          }).css("cursor","pointer");
          $("#r" + my_room + "_nav2").click(function(){
            $("#r" + my_room + "_buf1").html("1m");
            $("#r" + my_room + "_buf2").html("0");
// Diagramm nach Klick auf den "1 Monat" Button
            if (dev_typ.localeCompare("DG") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1m&graph="+p3+"&sensor1legend="+p4);
            }
            if (dev_typ.localeCompare("VD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&sum=y&range=1m&graph=bar&sensor1legend="+p7);
            }
            if (dev_typ.localeCompare("MD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&range=1m&graph="+p5+"&sensor1legend="+p4);
            }
// Ende: Diagramm nach Klick auf den "1 Monat" Button
// Schalterfarben 1 Monat
            $("#r" + my_room + "dh1").css("background",but_passive)
            $("#r" + my_room + "dh2").css("background",but_active)
            $("#r" + my_room + "dh3").css("background",but_passive)
            $("#r" + my_room + "_nav1").css("background",but_passive)
            $("#r" + my_room + "_nav2").css("background",but_active)
            $("#r" + my_room + "_nav3").css("background",but_passive)
            $("#r" + my_room + "_nav4").css("background",but_passive)
            but_color_old = but_active;
// Ende: Schalterfarben 1 Monat
          }).on( "mouseover", function() {
            but_color_old = $(this).css("background-color");
            $(this).css("background-color", but_handover);
          }).on( "mouseout", function() {
            $(this).css("background-color", but_color_old);
          }).css("cursor","pointer");
          $("#r" + my_room + "_nav3").click(function(){
            $("#r" + my_room + "_buf1").html("1y");
            $("#r" + my_room + "_buf2").html("0");
            if (dev_typ.localeCompare("DG") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=1y&graph="+p3+"&sensor1legend="+p4);
            }
            if (dev_typ.localeCompare("VD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&sum=y&range=1y&graph=bar&sensor1legend="+p7);
            }
            if (dev_typ.localeCompare("MD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&range=1y&graph="+p5+"&sensor1legend="+p4);
            }
// Schalterfarben 1 Jahr
            $("#r" + my_room + "dh1").css("background",but_passive)
            $("#r" + my_room + "dh2").css("background",but_passive)
            $("#r" + my_room + "dh3").css("background",but_active)
            $("#r" + my_room + "_nav1").css("background",but_passive)
            $("#r" + my_room + "_nav2").css("background",but_passive)
            $("#r" + my_room + "_nav3").css("background",but_active)
            $("#r" + my_room + "_nav4").css("background",but_passive)
            but_color_old = but_active;
// Ende: Schalterfarben 1 Jahr
          }).on( "mouseover", function() {
            but_color_old = $(this).css("background-color");
            $(this).css("background-color", but_handover);
          }).on( "mouseout", function() {
            $(this).css("background-color", but_color_old);
          }).css("cursor","pointer");
          $("#r" + my_room + "_nav4").click(function(){
            $("#r" + my_room + "_buf1").html("10y");
            $("#r" + my_room + "_buf2").html("0");
            if (dev_typ.localeCompare("DG") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range=10y&graph="+p3+"&sensor1legend="+p4);
            }
            if (dev_typ.localeCompare("VD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&sum=y&range=10y&graph=bar&sensor1legend="+p7);
            }
            if (dev_typ.localeCompare("MD") == 0) {
              $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&range=10y&graph="+p5+"&sensor1legend="+p4);
            }
// Schalterfarben 10 Jahre
            $("#r" + my_room + "dh1").css("background",but_passive)
            $("#r" + my_room + "dh2").css("background",but_passive)
            $("#r" + my_room + "dh3").css("background",but_passive)
            $("#r" + my_room + "_nav1").css("background",but_passive)
            $("#r" + my_room + "_nav2").css("background",but_passive)
            $("#r" + my_room + "_nav3").css("background",but_passive)
            $("#r" + my_room + "_nav4").css("background",but_active)
            but_color_old = but_active;
// Ende: Schalterfarben 10 Jahre
          }).on( "mouseover", function() {
            but_color_old = $(this).css("background-color");
            $(this).css("background-color", but_handover);
          }).on( "mouseout", function() {
            $(this).css("background-color", but_color_old);
          }).css("cursor","pointer");
          $("#r" + my_room + "_nav5").click(function(){
            var offset=parseInt($("#r" + my_room + "_buf2").html()) +1;
            var ts=$("#r" + my_room + "_buf1").html();
            $("#r" + my_room + "_nav6_img").attr("src","/img/arrow_right.gif");
            $("#r" + my_room + "_buf2").html(offset);
            if ( ts.localeCompare("1d") == 0 ) {
              if (dev_typ.localeCompare("DG") == 0) {
                  $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p4);
              }
              if (dev_typ.localeCompare("VD") == 0) {
                $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&sum=y&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p6);
              }
              if (dev_typ.localeCompare("MD") == 0) {
                  $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p3);
              }
            } else {
              if (dev_typ.localeCompare("DG") == 0) {
                $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph="+p3+"&sensor1legend="+p4);
              }
              if (dev_typ.localeCompare("VD") == 0) {
                $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&sum=y&range="+ts+"&offset="+offset+"&graph=bar&sensor1legend="+p7);
              }
              if (dev_typ.localeCompare("MD") == 0) {
                $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph="+p5+"&sensor1legend="+p4);
              }
            }
          }).on( "mouseover", function() {
            but_color_old = $(this).css("background-color");
            $(this).css("background-color", but_handover);
          }).on( "mouseout", function() {
            $(this).css("background-color", but_color_old);
          }).css("cursor","pointer");
          $("#r" + my_room + "_nav6").click(function(){
            if (parseInt($("#r" + my_room + "_buf2").html()) > 0) {
              var offset=parseInt($("#r" + my_room + "_buf2").html()) -1;
              var ts=$("#r" + my_room + "_buf1").html();
              $("#r" + my_room + "_buf2").html(offset);
              if ( ts.localeCompare("1d") == 0 ) {
                if (dev_typ.localeCompare("DG") == 0) {
                    $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p4);
                }
                if (dev_typ.localeCompare("VD") == 0) {
                  $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&sum=y&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p6);
                }
                if (dev_typ.localeCompare("MD") == 0) {
                    $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p3);
                }
              } else {
                if (dev_typ.localeCompare("DG") == 0) {
                  $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p1+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph="+p3+"&sensor1legend="+p4);
                }
                if (dev_typ.localeCompare("VD") == 0) {
                  $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&sum=y&range="+ts+"&offset="+offset+"&graph=bar&sensor1legend="+p7);
                }
                if (dev_typ.localeCompare("MD") == 0) {
                  $("#r" + my_room + "dia").attr("src","/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph="+p5+"&sensor1legend="+p4);
                }
              }
            } else {
              $("#r" + my_room + "_nav6_img").attr("src","/img/arrow_right_e.gif");
            }
          }).on( "mouseover", function() {
            but_color_old = $(this).css("background-color");
            $(this).css("background-color", but_handover);
          }).on( "mouseout", function() {
            $(this).css("background-color", but_color_old);
          }).css("cursor","pointer");
          if ( window.innerWidth < 600 ) {
            $("#r" + my_room + "ds").css("height","130px");
            $("#r" + my_room + "_nav4").removeClass("nav4").addClass("nav4_mobile");
            $("#r" + my_room + "_nav5").removeClass("nav5").addClass("nav5_mobile");
            $("#r" + my_room + "_nav6").removeClass("nav6").addClass("nav6_mobile");
          }
        }
//####### Heizung #############
        if (dev_typ.localeCompare("HT") == 0) {
          $("#r" + my_room + "a").html("<div id='r"+my_room+"ht'></div>");
          //Ein Label und das Reglerfeld hinzufügen
          $("#r"+my_room+"ht").append("<div class='dev_ht_label' id='r"+my_room+"htl'>"+dev_name+"</div>")
                              .append("<div class='dev_ht' id='r"+my_room+"hts'></div>");
          //Das Reglerfeld hat 3 Divs: Regler; Auto/Man. Umschalter; Bestätigungsbutton
          $("#r"+my_room+"hts").append("<div class='dev_ht_temp' id='r"+my_room+"hts1'></div>")
                               .append("<div class='dev_ht_am' id='r"+my_room+"hts2'></div>")
                               .append("<div class='dev_ht_ok' id='r"+my_room+"hts3'></div>");
          //Der Regler für die Temperatur
          $("#r"+my_room+"hts1").append("<input id='r"+my_room+"hts1s' min='5' max='22' step='0.5' data-highlight='true' data-role='slider' />");
          $("#r"+my_room+"hts1s").slider();
          //Der Umschalter auto/man.
          $("#r"+my_room+"hts2").append("<select name='r"+my_room+"hts2s' id='r"+my_room+"hts2s' data-role='slider'><option value='auto'>Auto</option><option value='manual'>Man.</option></select>");
          $("#r"+my_room+"hts2s").slider();
          //Der OK Schalter
          $("#r"+my_room+"hts3").append("<input type='button' id='r"+my_room+"hts3s' value='Wert setzen' />");
          $("#r"+my_room+"hts3s").buttonMarkup({ theme: "a" });
          $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature" }, function(data) {
            $("#r"+my_room+"hts1s").val(data).slider("refresh");
          });
          $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "mode" }, function(data) {
            $("#r"+my_room+"hts2s").val(data).slider("refresh");
          });
          $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "valveposition" }, function(data) {
            $("#r"+my_room+"htl").append("  Ventil: "+data);
          });
          $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "temperature" }, function(data) {
            $("#r"+my_room+"htl").append("   Temperatur: "+data);
          });
          $("#r"+my_room+"hts3s").click(function(){
            mytemp=$("#r"+my_room+"hts1s").val();
            mymode=$("#r"+my_room+"hts2s").val();
            if ( mymode == "auto" ) {
              $.get(basedir+'setfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature", wert: mymode, wert1: mytemp }, function(data) {
                alert(data);
                show_ht_val(fhem_dev, my_room, my_dev );
              });
            } else {
              $.get(basedir+'setfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature", wert: mytemp }, function(data) {
                alert(data);
                show_ht_val(fhem_dev, my_room, my_dev );
              });
            }
          });
          if ( window.innerWidth < 600 ) {
            $("#r"+my_room+"hts").css("height","100px");
            $("#r"+my_room+"hts1").css("width","100%");
            $("#r"+my_room+"hts2").css("top","50px").css("left","10%");
            $("#r"+my_room+"hts3").css("top","40px").css("left","60%");
          }
        }
//####### Schalter #############
        if (dev_typ.localeCompare("SW") == 0) {
          $("#r" + my_room + "a").html("<div class='dev_sw' id='r"+my_room+"sw'></div>");
          //Ein Label, das Schalterfeld und ein Diagrammfeld hinzufügen
          $("#r"+my_room+"sw").append("<div class='dev_sw_label' id='r"+my_room+"swl'>"+dev_name+"</div>")
                              .append("<div class='dev_sw_switch' id='r"+my_room+"sws'></div>")
                              .append("<div class='dev_sw_dia' id='r"+my_room+"swd'></div>");
          //Das Schalterfeld aufbauen
          $("#r" + my_room + "sws").append("<div id='r" + my_room + "sws0' class='dev_sw_box dev_sw_box0'></div>")
                                   .append("<div id='r" + my_room + "sws1' class='dev_sw_box dev_sw_box1'></div>")
                                   .append("<div id='r" + my_room + "sws2' class='dev_sw_box dev_sw_box2'></div>")
                                   .append("<div id='r" + my_room + "sws3' class='dev_sw_box dev_sw_box3'></div>");
          $("#r" + my_room + "sws0").append("<button type='button' id='r" + my_room + "sws0b' class='stateicon'>X</button>");
          $("#r" + my_room + "sws1").append("<button type='button' id='r" + my_room + "sws1b' class='button_akt'>Aus</button>");
          $("#r" + my_room + "sws2").append("<button type='button' id='r" + my_room + "sws2b' class='button_akt'>Auto</button>");
          $("#r" + my_room + "sws3").append("<button type='button' id='r" + my_room + "sws3b' class='button_akt'>Ein</button>");
          //Diagrammfeld aufbauen
          if (parseInt(p2) > 0) {
            $("#r" + my_room + "swd").html("<img src='/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=100&range=1d&graph=bar&sensor1color=#000000'>");
          }
          //Abfrage des Hauptschalters und Einstellung der Schalter
          device_switch_get_state(my_room, my_dev, p1, fhem_dev);
          //Click Funktionen
          $("#r" + my_room + "sws1b").click(function(){
            device_switch_click_func(my_room, my_dev, p1, fhem_dev, "0");
          });
          $("#r" + my_room + "sws2b").click(function(){
            device_switch_click_func(my_room, my_dev, p1, fhem_dev, "2");
          });
          $("#r" + my_room + "sws3b").click(function(){
            device_switch_click_func(my_room, my_dev, p1, fhem_dev, "1");
          });
        }
//####### ENDE ############
//-----Ende Anzeige in Detailfeld-------
        $("#r" + my_room + "d" + my_dev + "ba").attr("src", arrow_down);
      } else {
        $("#r" + my_room + "x").html(0);
        $("#r" + my_room + "a").hide();
        $("#r" + my_room + "a1").hide();
        $("#r" + my_room + "d" + my_dev + "ba").attr("src", arrow_up);
      }
    }
  });
  if ( window.innerWidth < 600 ) {
    if ( dev_no < 5 ) {
      $("#r" + room_no + "d" + dev_no).css("border-bottom","1px solid #a80329");
    } else {
      $("#r" + room_no + "d").css("height","80px");
      $("#r" + room_no + "d" + dev_no).css("top","40px").css("border-bottom","1px solid #a80329").css("border-top","1px solid #a80329");
    }
  }
}
