var arrow_up = "/img/arrow_up.gif";
var arrow_down = "/img/arrow_down.gif";
var getfhem = "/admin/getfhem.php";
var needhelp = "/img/gefahrenstelle_20x20.jpg"
var w = screen.width;
var devwidth = "25%"
var but_color2 = '#DDDDDD';
var but_color1 = '#AAAAAA';


function device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev) {
    var result;
    $.get(basedir+'getfhem.php',{geraet: fhem_HS_dev, eigenschaft: "state" }, function(data) {
        if (data == 0) { result = "(aus) "; } else { result = "("+data+") "; }
        if (data == 1) { result = "(ein) "; }
        if (data == 2) { result = "(auto) "; }
        switch (data) {
            case "aus":
                $("#r" + room_no + "sws1b").css("background-color", "#a80329");
                $("#r" + room_no + "sws2b").css("background-color", "grey");
                $("#r" + room_no + "sws3b").css("background-color", "grey");
            break;
            case "auto":
                $("#r" + room_no + "sws1b").css("background-color", "grey");
                $("#r" + room_no + "sws2b").css("background-color", "#a80329");
                $("#r" + room_no + "sws3b").css("background-color", "grey");
            break;
            case "ein":
                $("#r" + room_no + "sws1b").css("background-color", "grey");
                $("#r" + room_no + "sws2b").css("background-color", "grey");
                $("#r" + room_no + "sws3b").css("background-color", "#a80329");
            break;
        }
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
            if (data == 0) { result += "aus"; }
            if (data == 1) { result += "ein"; }
            $("#r"+room_no+"d"+dev_no+"v").html(result);
            switch(data) {
                case "1":
                case "on":
                    $("#r"+room_no+"sws0b").css("background-color", "yellow"); //.css("color","black");
                break;
                case "0":
                case "off":
                    $("#r"+room_no+"sws0b").css("background-color", "black").css("color","white");
                break;
                default:
                    $("#r"+room_no+"sws0b").append("-"+data);
            }
            show_sw_val(fhem_dev, fhem_HS_dev, room_no, dev_no );
        });
	});
}

function device_switch_click_func(room_no, dev_no, fhem_HS_dev, fhem_dev, dev_state) {
    $.get(basedir+'setfhem.php',{geraet: fhem_HS_dev, eigenschaft: " ", wert: dev_state }, function(data) {
        setTimeout(function() {
            device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev);
        }, 5000);
            device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev);
    });
}

function haus(titel) {
  // Parameter:
  // titel = Die Ueberschrift in der ersten Zeile (zentriert)
  $("#haus").html("<div class='haus_head'>" + titel + "</div>");
}

function show_val(room_no, dev_no, result, lev1, lev2, lev3) {
    $("#r"+room_no+"d"+dev_no+"v").html(result);
    if ( window.innerWidth < 600 ) {
        if (result.length > lev1 - 5) $("#r" + room_no + "d" + dev_no + "v").css("font-size","small");
        if (result.length > lev2 - 5) $("#r" + room_no + "d" + dev_no + "v").css("font-size","x-small");
        if (result.length > lev3 - 5) $("#r" + room_no + "d" + dev_no + "v").css("font-size","xx-small");
    } else {
        if (result.length > lev1) $("#r" + room_no + "d" + dev_no + "v").css("font-size","small");
        if (result.length > lev2) $("#r" + room_no + "d" + dev_no + "v").css("font-size","x-small");
        if (result.length > lev3) $("#r" + room_no + "d" + dev_no + "v").css("font-size","xx-small");
    }
}

function show_ht_val(fhem_dev, room_no, dev_no ) {
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
            show_val(room_no, dev_no, result, 17, 22, 27);
        });
      });

}

function show_sw_val(fhem_dev, fhem_HS_dev, room_no, dev_no ) {
    var result;
    $.get(basedir+'getfhem.php',{geraet: fhem_HS_dev, eigenschaft: "state" }, function(data) {
        if (data == 0) { result = "(aus) "; } else { result = "("+data+") "; }
        if (data == 1) { result = "(ein) "; }
        if (data == 2) { result = "(auto) "; }
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
            if (data == 0) { result += "aus"; }
            if (data == 1) { result += "ein"; }
            show_val(room_no, dev_no, result, 15, 20, 25);
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
function add_room( room_no, room_name ) {
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
 * Aufruf ist teilweise abhängig von dem Typ (dev_typ):
 * Einheitlicher Teil:
 * room_no = Raum Nummer; dev_no = Geräte Nummer; dev_typ = Geräte Typ; dev_name = Beschriftung; fhem_dev = FHEM Device für den aktuellen Wert
 *
 * Die weiteren Parameter (p1 bis p6) sind abhängig vom Geräte Typ.
 *
 * Geräte Typ Shalter     (SW): p1 = Hauptschalterdevice p2 = SensorID p3 ... p7 = ""
 * Heizungsthermostat     (HT): p1 ... p7 = ""
 * Generisches Diagramm   (DG): p1 = Einheit; p2 = Datenbank; p3 = Sensorno; p4 = Zeitspanne (1d, 1m, 3m, 1y); p5 = Legende; p6 = Diagrammtyp; p7 = Nachkommastellen
 * Solar                  (SO): p1 = Datenbank; p2 = Sensor1; p3 = Sensor2; p4 = Sensor3; p5 ... p7 = ""
 * Ohne Pulldown          (--): p1 = Einheit; p2 = Dezimalstellen p3 ... p7 = ""
 ****************************************************************/
function add_device(room_no, dev_no, dev_typ, dev_name, fhem_dev, p1, p2, p3, p4, p5, p6, p7) {
    var result = " ";
    var value  = 0;
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
        show_ht_val(fhem_dev, room_no, dev_no );
    }
//######### SW ############
    if (dev_typ.localeCompare("SW") == 0) {
        show_sw_val(fhem_dev, p1, room_no, dev_no );
    }
//######## DG Diagramm generisch ###########
    if (dev_typ.localeCompare("DG") == 0) {
      $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
        if ( p7 == 0 ) value = Math.round(data);
        if ( p7 == 1 ) value = Math.round(data * 10) / 10;
        if ( p7 == 2 ) value = Math.round(data * 100) / 100;
        result = value + " " + p1;
        show_val(room_no, dev_no, result, 15, 20, 25);
      });
    }
//######## -- Kein Diagramm ###########
    if (dev_typ.localeCompare("--") == 0) {
      $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
        if ( p2 == 0 ) value = Math.round(data);
        if ( p2 == 1 ) value = Math.round(data * 10) / 10;
        if ( p2 == 2 ) value = Math.round(data * 100) / 100;
        result = value + " " + p1;
        show_val(room_no, dev_no, result, 15, 20, 25);
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
        if ( ! ($("#r" + room_no + "x").html() == 0 || $("#r" + room_no + "x").html() == dev_no) ) {
            alert("Grafik geöffnet, bitte schliessen");
        } else {
            if ($("#r" + room_no + "a").is(':hidden')) {
                $("#r" + room_no + "x").html(dev_no);
                $("#r" + room_no + "a").show();
//-----Anzeige im externen Detailfeld-------
//######## DG Liniendiagramm generisch ###########
                if (dev_typ.localeCompare("DG") == 0) {
                    $("#r" + room_no + "a").html("<div id='r"+room_no+"dx'></div><div id='r"+room_no+"ds' style='height:70px;'></div>");
                    $("#r" + room_no + "ds").append("<div id='r" + room_no + "_nav1' class='nav nav1'>Diagramm<br>1 Tag</div>")
                                            .append("<div id='r" + room_no + "_nav2' class='nav nav2'>Diagramm<br>1 Monat</div>")
                                            .append("<div id='r" + room_no + "_nav3' class='nav nav3'>Diagramm<br>1 Jahr</div>")
                                            .append("<div id='r" + room_no + "_nav4' class='nav nav4'>Diagramm<br>10 Jahre</div>")
                                            .append("<div id='r" + room_no + "_nav5' class='nav nav5'><img src='/img/arrow_left.gif' height='50' width='50'></div>")
                                            .append("<div id='r" + room_no + "_nav6' class='nav nav6'><img id='r" + room_no + "_nav6_img' src='/img/arrow_right_e.gif' height='50' width='50'></div>")
                                            .append("<div id='r" + room_no + "_buf1' style='display:none;'></div>")
                                            .append("<div id='r" + room_no + "_buf2' style='display:none;'></div>")
                                            .css("background-color","#aaaaaa");
                    if (p4.localeCompare("1m") == 0) {
                        $("#r" + room_no + "_nav1").css("display","none");
                    }
                    if ((p4.localeCompare("3m") == 0) || (p4.localeCompare("1y") == 0)) {
                        $("#r" + room_no + "_nav1").css("display","none");
                        $("#r" + room_no + "_nav2").css("display","none");
                    }
                    $("#r" + room_no + "dx").html("<img id='r" + room_no + "dia' src='/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range="+p4+"&graph="+p6+"&sensor1legend="+p5+"'>");
                    $("#r" + room_no + "a1").show();
                    $("#r" + room_no + "_buf1").html(p4);
                    $("#r" + room_no + "_buf2").html("0");
                    $("#r" + room_no + "_nav1").click(function(){
                        $("#r" + room_no + "_buf1").html("1d");
                        $("#r" + room_no + "_buf2").html("0");
                        $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range=1d&graph=line&sensor1legend="+p5+"");
                    }).on( "mouseover", function() {
                        $(this).css("background-color", but_color1);
                    }).on( "mouseout", function() {
                        $(this).css("background-color", but_color2);
                    }).css("cursor","pointer");
                    $("#r" + room_no + "_nav2").click(function(){
                        $("#r" + room_no + "_buf1").html("1m");
                        $("#r" + room_no + "_buf2").html("0");
                        $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range=1m&graph="+p6+"&sensor1legend="+p5+"");
                    }).on( "mouseover", function() {
                        $(this).css("background-color", but_color1);
                    }).on( "mouseout", function() {
                        $(this).css("background-color", but_color2);
                    }).css("cursor","pointer");
                    $("#r" + room_no + "_nav3").click(function(){
                        $("#r" + room_no + "_buf1").html("1y");
                        $("#r" + room_no + "_buf2").html("0");
                        $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range=1y&graph="+p6+"&sensor1legend="+p5+"");
                    }).on( "mouseover", function() {
                        $(this).css("background-color", but_color1);
                    }).on( "mouseout", function() {
                        $(this).css("background-color", but_color2);
                    }).css("cursor","pointer");
                    $("#r" + room_no + "_nav4").click(function(){
                        $("#r" + room_no + "_buf1").html("10y");
                        $("#r" + room_no + "_buf2").html("0");
                        $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range=10y&graph="+p6+"&sensor1legend="+p5+"");
                    }).on( "mouseover", function() {
                        $(this).css("background-color", but_color1);
                    }).on( "mouseout", function() {
                        $(this).css("background-color", but_color2);
                    }).css("cursor","pointer");
                    $("#r" + room_no + "_nav5").click(function(){
                        var offset=parseInt($("#r" + room_no + "_buf2").html()) +1;
                        var ts=$("#r" + room_no + "_buf1").html();
                        $("#r" + room_no + "_nav6_img").attr("src","/img/arrow_right.gif");
                        $("#r" + room_no + "_buf2").html(offset);
                        if ( ts.localeCompare("1d") == 0 ) {
                            $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p5+"");
                        } else {
                            $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph="+p6+"&sensor1legend="+p5+"");
                       }
                    }).on( "mouseover", function() {
                        $(this).css("background-color", but_color1);
                    }).on( "mouseout", function() {
                        $(this).css("background-color", but_color2);
                    }).css("cursor","pointer");
                    $("#r" + room_no + "_nav6").click(function(){
                        if (parseInt($("#r" + room_no + "_buf2").html()) > 0) {
                            var offset=parseInt($("#r" + room_no + "_buf2").html()) -1;
                            var ts=$("#r" + room_no + "_buf1").html();
                            $("#r" + room_no + "_buf2").html(offset);
                            if ( ts.localeCompare("1d") == 0 ) {
                                $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph=line&sensor1legend="+p5+"");
                            } else {
                                $("#r" + room_no + "dia").attr("src","/content/diagramm.php?database="+p2+"&sensor1="+p3+"&sizex="+w+"&sizey=370&range="+ts+"&offset="+offset+"&graph="+p6+"&sensor1legend="+p5+"");
                            }
                        } else {
                            $("#r" + room_no + "_nav6_img").attr("src","/img/arrow_right_e.gif");
                        }
                    }).on( "mouseover", function() {
                        $(this).css("background-color", but_color1);
                    }).on( "mouseout", function() {
                        $(this).css("background-color", but_color2);
                    }).css("cursor","pointer");
                    if ( window.innerWidth < 600 ) {
                        $("#r" + room_no + "ds").css("height","130px");
                        $("#r" + room_no + "_nav4").removeClass("nav4").addClass("nav4_mobile");
                        $("#r" + room_no + "_nav5").removeClass("nav5").addClass("nav5_mobile");
                        $("#r" + room_no + "_nav6").removeClass("nav6").addClass("nav6_mobile");
                    }
                }
//####### Heizung #############
                if (dev_typ.localeCompare("HT") == 0) {
                    $("#r" + room_no + "a").html("<div id='r"+room_no+"ht'></div>");
                    //Ein Label und das Reglerfeld hinzufügen
                    $("#r"+room_no+"ht").append("<div class='dev_ht_label' id='r"+room_no+"htl'>"+dev_name+"</div>")
                                        .append("<div class='dev_ht' id='r"+room_no+"hts'></div>");
                    //Das Reglerfeld hat 3 Divs: Regler; Auto/Man. Umschalter; Bestätigungsbutton
                    $("#r"+room_no+"hts").append("<div class='dev_ht_temp' id='r"+room_no+"hts1'></div>")
                                         .append("<div class='dev_ht_am' id='r"+room_no+"hts2'></div>")
                                         .append("<div class='dev_ht_ok' id='r"+room_no+"hts3'></div>");
                    //Der Regler für die Temperatur
                    $("#r"+room_no+"hts1").append("<input id='r"+room_no+"hts1s' min='5' max='22' step='0.5' data-highlight='true' data-role='slider' />");
                    $("#r"+room_no+"hts1s").slider();
                    //Der Umschalter auto/man.
                    $("#r"+room_no+"hts2").append("<select name='r"+room_no+"hts2s' id='r"+room_no+"hts2s' data-role='slider'><option value='auto'>Auto</option><option value='manual'>Man.</option></select>");
                    $("#r"+room_no+"hts2s").slider();
                    //Der OK Schalter
                    $("#r"+room_no+"hts3").append("<input type='button' id='r"+room_no+"hts3s' value='Wert setzen' />");
                    $("#r"+room_no+"hts3s").buttonMarkup({ theme: "a" });
                    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature" }, function(data) {
                        $("#r"+room_no+"hts1s").val(data).slider("refresh");
                    });
                    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "mode" }, function(data) {
                        $("#r"+room_no+"hts2s").val(data).slider("refresh");
                    });
                    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "valveposition" }, function(data) {
                        $("#r"+room_no+"htl").append("  Ventil: "+data);
                    });
                    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "temperature" }, function(data) {
                        $("#r"+room_no+"htl").append("   Temperatur: "+data);
                    });
                    $("#r"+room_no+"hts3s").click(function(){
                        mytemp=$("#r"+room_no+"hts1s").val();
                        mymode=$("#r"+room_no+"hts2s").val();
                        if ( mymode == "auto" ) {
                            $.get(basedir+'setfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature", wert: mymode, wert1: mytemp }, function(data) {
                                alert(data);
                                show_ht_val(fhem_dev, room_no, dev_no );
                            });
                        } else {
                            $.get(basedir+'setfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature", wert: mytemp }, function(data) {
                                alert(data);
                                show_ht_val(fhem_dev, room_no, dev_no );
                            });
                        }
                    });
                    if ( window.innerWidth < 600 ) {
                        $("#r"+room_no+"hts").css("height","100px");
                        $("#r"+room_no+"hts1").css("width","100%");
                        $("#r"+room_no+"hts2").css("top","50px").css("left","10%");
                        $("#r"+room_no+"hts3").css("top","40px").css("left","60%");
                    }
                }
//####### Schalter #############
                if (dev_typ.localeCompare("SW") == 0) {
                    $("#r" + room_no + "a").html("<div class='dev_sw' id='r"+room_no+"sw'></div>");
                    //Ein Label, das Schalterfeld und ein Diagrammfeld hinzufügen
                    $("#r"+room_no+"sw").append("<div class='dev_sw_label' id='r"+room_no+"swl'>"+dev_name+"</div>")
                                        .append("<div class='dev_sw_switch' id='r"+room_no+"sws'></div>")
                                        .append("<div class='dev_sw_dia' id='r"+room_no+"swd'></div>");
                    //Das Schalterfeld aufbauen
                    $("#r" + room_no + "sws").append("<div id='r" + room_no + "sws0' class='dev_sw_box dev_sw_box0'></div>")
                                             .append("<div id='r" + room_no + "sws1' class='dev_sw_box dev_sw_box1'></div>")
                                             .append("<div id='r" + room_no + "sws2' class='dev_sw_box dev_sw_box2'></div>")
                                             .append("<div id='r" + room_no + "sws3' class='dev_sw_box dev_sw_box3'></div>");
                    $("#r" + room_no + "sws0").append("<button type='button' id='r" + room_no + "sws0b' class='stateicon'>X</button>");
                    $("#r" + room_no + "sws1").append("<button type='button' id='r" + room_no + "sws1b' class='button_akt'>Aus</button>");
                    $("#r" + room_no + "sws2").append("<button type='button' id='r" + room_no + "sws2b' class='button_akt'>Auto</button>");
                    $("#r" + room_no + "sws3").append("<button type='button' id='r" + room_no + "sws3b' class='button_akt'>Ein</button>");
                    //Diagrammfeld aufbauen
                    if (p2.length > 0) {
                        $("#r" + room_no + "swd").html("<img src='/content/diagramm.php?database=datahub&sensor1="+p2+"&sizex="+w+"&sizey=100&range=1d&graph=bar&sensor1color=#000000'>");
                    }
                    //Abfrage des Hauptschalters und Einstellung der Schalter
                    device_switch_get_state(room_no, dev_no, p1, fhem_dev);
                    //Click Funktionen
                    $("#r" + room_no + "sws1b").click(function(){
                        device_switch_click_func(room_no, dev_no, p1, fhem_dev, "0");
                    });
                    $("#r" + room_no + "sws2b").click(function(){
                        device_switch_click_func(room_no, dev_no, p1, fhem_dev, "2");
                    });
                    $("#r" + room_no + "sws3b").click(function(){
                        device_switch_click_func(room_no, dev_no, p1, fhem_dev, "1");
                    });
                }
//####### ENDE ############
//-----Ende Anzeige in Detailfeld-------
                $("#r" + room_no + "d" + dev_no + "ba").attr("src", arrow_down);
            } else {
                $("#r" + room_no + "x").html(0);
                $("#r" + room_no + "a").hide();
                $("#r" + room_no + "a1").hide();
                $("#r" + room_no + "d" + dev_no + "ba").attr("src", arrow_up);
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
