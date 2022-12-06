var arrow_up = "/img/arrow_up.gif";
var arrow_down = "/img/arrow_down.gif";
var getfhem = "/admin/getfhem.php";
var needhelp = "/img/gefahrenstelle_20x20.jpg"
//var getfhem = "https://rpi2.fritz.box/demo/getfhem.php";
//var getfhem = "https://www.wilmie.myhome-server.de/demo/getfhem.php";

function header_init(titel) {
  // Parameter:
  // titel = Die Ueberschrift in der ersten Zeile (zentriert)
  $("#haus").append("<div class='content_header' id='content_header'>");
  $("#content_header").append("<div class='content_header_head' id='content_header_head'>" + titel + "</div>");
}

function header_addLine(line_no, text_l, text_r) {
  // Parameter: 
  // line_no = Zeilennummer (nur fuer ID verwendet) muss unique sein!
  // text_l = linksbuendiger Text
  // text_r = rechtsbuendiger Text
  $("#content_header").append("<div class='content_header_line' id='content_header_line" + line_no + "'></div>");
  $("#content_header_line" + line_no).append("<div class='content_header_line_l' id='content_header_line_l" + line_no + "'>" + text_l + "</div>");
  $("#content_header_line" + line_no).append("<div class='content_header_line_r' id='content_header_line_r" + line_no + "'>" + text_r + "</div>");
}

function add_room( room_no, room_name, fhem_dev, fhem_reading ) {
    $("#haus").append("<div class='room' id='r" + room_no + "'></div>");
    $("#r" + room_no).append("<div class='room_status' id='r" + room_no + "h'></div>");
    $("#r" + room_no).append("<div class='room_addinfo' id='r" + room_no + "m'></div>");
    $("#r" + room_no + "m").append("<img id='r" + room_no + "m_i1' src=" + needhelp + " width='20' height='20' />");
    $("#r" + room_no).append("<div class='room_value' id='r" + room_no + "v'></div>");
    $("#r" + room_no).append("<div class='room_switch' id='r" + room_no + "s'></div>");
    $("#r" + room_no).append("<div class='room_dev' id='r" + room_no + "d'></div>");
    $("#r" + room_no + "s").append("<img id='r" + room_no + "i' src=" + arrow_up + " width='48' height='60' />");
    $("#r" + room_no + "i").css("display", "none");
    $("#r" + room_no + "h").append("<div class='room_label' id='r" + room_no + "hl'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status1' id='r" + room_no + "hd1'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status2' id='r" + room_no + "hd2'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status3' id='r" + room_no + "hd3'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status4' id='r" + room_no + "hd4'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status5' id='r" + room_no + "hd5'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status6' id='r" + room_no + "hd6'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status7' id='r" + room_no + "hd7'></div>");
    $("#r" + room_no + "h").append("<div class='dev_status dev_status8' id='r" + room_no + "hd8'></div>");
    $("#r" + room_no + "hd1").append("<div class='dev_statuslabel dev_status1label' id='r" + room_no + "hd1l'></div>");
    $("#r" + room_no + "hd1").append("<div class='dev_statusvalue dev_status1value' id='r" + room_no + "hd1v'></div>");
    $("#r" + room_no + "hd2").append("<div class='dev_statuslabel dev_status2label' id='r" + room_no + "hd2l'></div>");
    $("#r" + room_no + "hd2").append("<div class='dev_statusvalue dev_status2value' id='r" + room_no + "hd2v'></div>");
    $("#r" + room_no + "hd3").append("<div class='dev_statuslabel dev_status3label' id='r" + room_no + "hd3l'></div>");
    $("#r" + room_no + "hd3").append("<div class='dev_statusvalue dev_status3value' id='r" + room_no + "hd3v'></div>");
    $("#r" + room_no + "hd4").append("<div class='dev_statuslabel dev_status4label' id='r" + room_no + "hd4l'></div>");
    $("#r" + room_no + "hd4").append("<div class='dev_statusvalue dev_status4value' id='r" + room_no + "hd4v'></div>");
    $("#r" + room_no + "hd5").append("<div class='dev_statuslabel dev_status5label' id='r" + room_no + "hd5l'></div>");
    $("#r" + room_no + "hd5").append("<div class='dev_statusvalue dev_status5value' id='r" + room_no + "hd5v'></div>");
    $("#r" + room_no + "hd6").append("<div class='dev_statuslabel dev_status6label' id='r" + room_no + "hd6l'></div>");
    $("#r" + room_no + "hd6").append("<div class='dev_statusvalue dev_status6value' id='r" + room_no + "hd6v'></div>");
    $("#r" + room_no + "hd7").append("<div class='dev_statuslabel dev_status7label' id='r" + room_no + "hd7l'></div>");
    $("#r" + room_no + "hd7").append("<div class='dev_statusvalue dev_status7value' id='r" + room_no + "hd7v'></div>");
    $("#r" + room_no + "hd8").append("<div class='dev_statuslabel dev_status8label' id='r" + room_no + "hd8l'></div>");
    $("#r" + room_no + "hd8").append("<div class='dev_statusvalue dev_status8value' id='r" + room_no + "hd8v'></div>");
    
    $("#r" + room_no + "hl").html(room_name);

    $.get(basedir+'getfhem.php',{geraet: room_name+"_Status", eigenschaft: "state" }, function(data) {
        if ( data == 0 ) {
            $("#r" + room_no + "m_i1").hide();
        } else {
            $("#r" + room_no + "m_i1").show();
        }
    });
    
    var str1 = " ";
    var str2 = str1.concat(fhem_dev);
    if ( str2.length > 3 ) {
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: fhem_reading }, function(data) {
            $("#r" + room_no + "v").html(parseInt(data*10)/10+" &deg;C");
        });
    }
    
    $("#r" + room_no + "s").click(function() {
        if ($("#r" + room_no + "d").is(':hidden')) {
            $("#r" + room_no + "d").show();
            document.getElementById("r" + room_no + "i").src = arrow_down;
        } else {
            $("#r" + room_no + "d").hide();
            document.getElementById("r" + room_no + "i").src = arrow_up;
        }
    });

    if ( window.innerWidth < 600 ) {
        $("#r" + room_no + "hd1").css("width","25%").css("left","75%");
        $("#r" + room_no + "hd1l").css("font-size","small");
        $("#r" + room_no + "hd1v").css("font-size","x-small");
        $("#r" + room_no + "hd2").css("width","25%").css("left","50%");
        $("#r" + room_no + "hd2l").css("font-size","small");
        $("#r" + room_no + "hd2v").css("font-size","x-small");
        $("#r" + room_no + "hd3").css("width","25%").css("left","25%");
        $("#r" + room_no + "hd3l").css("font-size","small");
        $("#r" + room_no + "hd3v").css("font-size","x-small");
        $("#r" + room_no + "hd4").css("width","25%").css("left","0%");
        $("#r" + room_no + "hd4l").css("font-size","small");
        $("#r" + room_no + "hd4v").css("font-size","x-small");
        $("#r" + room_no + "hd5").css("width","25%").css("left","75%");
        $("#r" + room_no + "hd5l").css("font-size","small");
        $("#r" + room_no + "hd5v").css("font-size","x-small");
        $("#r" + room_no + "hd6").css("width","25%").css("left","50%");
        $("#r" + room_no + "hd6l").css("font-size","small");
        $("#r" + room_no + "hd6v").css("font-size","x-small");
        $("#r" + room_no + "hd7").css("width","25%").css("left","25%");
        $("#r" + room_no + "hd7l").css("font-size","small");
        $("#r" + room_no + "hd7v").css("font-size","x-small");
        $("#r" + room_no + "hd8").css("width","25%").css("left","0%");
        $("#r" + room_no + "hd8l").css("font-size","small");
        $("#r" + room_no + "hd8v").css("font-size","x-small");
    }
}

function device_enable_switch(room_no) {
    $("#r" + room_no +"s").css("height", "60px");
    $("#r" + room_no +"h").css("height", "60px");
    $("#r" + room_no +"i").css("display", "inline");
}

function device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev) {
    $.get(basedir+'getfhem.php',{geraet: fhem_HS_dev, eigenschaft: "state" }, function(data) {
        $("#r"+room_no+"hd"+dev_no+"v").html("("+data+") ");
        switch (data) {
            case "aus":
                $("#r" + room_no + "d" + dev_no + "b1g").css("background-color", "#a80329");
                $("#r" + room_no + "d" + dev_no + "b2g").css("background-color", "grey");
                $("#r" + room_no + "d" + dev_no + "b3g").css("background-color", "grey");
            break;
            case "auto":
                $("#r" + room_no + "d" + dev_no + "b1g").css("background-color", "grey");
                $("#r" + room_no + "d" + dev_no + "b2g").css("background-color", "#a80329");
                $("#r" + room_no + "d" + dev_no + "b3g").css("background-color", "grey");
            break;
            case "ein":
                $("#r" + room_no + "d" + dev_no + "b1g").css("background-color", "grey");
                $("#r" + room_no + "d" + dev_no + "b2g").css("background-color", "grey");
                $("#r" + room_no + "d" + dev_no + "b3g").css("background-color", "#a80329");
            break;
        }	
    });			
	$.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
	// alert(fhem_dev + " state: " + data + "#");
	    switch(data) {
			case "1":
			case "on":
				$("#r"+room_no+"hd"+dev_no+"v").append("Ein");
				$("#r"+room_no+"d"+dev_no+"b0g").css("background-color", "yellow"); //.css("color","black");
			break;	
			case "0":
			case "off":
				$("#r"+room_no+"hd"+dev_no+"v").append("Aus");
				$("#r"+room_no+"d"+dev_no+"b0g").css("background-color", "black").css("color","white");
			break;	
			default:
				$("#r"+room_no+"hd"+dev_no+"v").append("-"+data);					
		}
	});
//	alert("Test");
}

function device_switch_click_func(room_no, dev_no, fhem_HS_dev, fhem_dev, dev_state) {
    $.get(basedir+'setfhem.php',{geraet: fhem_HS_dev, eigenschaft: " ", wert: dev_state }, function(data) {
        // alert(data);
        setTimeout(function() {
            //alert(dev_no + " " + dev_disp_name + " " + dev_disp_read + " " + dev_fhem_name);
            device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev);
        }, 5000);
            //alert(data);
            device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev);
    });
}

function add_device_switch(room_no, dev_no, dev_name, fhem_HS_dev, fhem_dev) {
    device_enable_switch(room_no);
    $("#r" + room_no + "d").append("<div class='dev' id='r" + room_no + "d" + dev_no + "'></div>");
    $("#r" + room_no + "d" + dev_no).append("<div class='dev_label' id='r" + room_no + "d" + dev_no + "l'></div>");
    $("#r" + room_no + "d" + dev_no + "l").html(dev_name);
    $("#r" + room_no + "d" + dev_no + "a").html("action");
    $("#r" + room_no + "hd" + dev_no).css("display","inline");
    $("#r" + room_no + "hd" + dev_no + "l").html(dev_name);
    $("#r" + room_no + "d" + dev_no).append("<div class='dev_sw' id='r" + room_no + "d" + dev_no + "a'></div>");
    $("#r" + room_no + "d" + dev_no + "a").append("<div id='r" + room_no + "d" + dev_no + "a1' class='dev_sw_box0'></div>");
    $("#r" + room_no + "d" + dev_no + "a1").append("<button type='button' id='r" + room_no + "d" + dev_no + "b0g' class='stateicon'>X</button>");
    $("#r" + room_no + "d" + dev_no + "a").append("<div id='r" + room_no + "d" + dev_no + "a2' class='dev_sw_box1'></div>");
    $("#r" + room_no + "d" + dev_no + "a2").append("<button type='button' id='r" + room_no + "d" + dev_no + "b1g' class='button_akt'>Aus</button>");
    $("#r" + room_no + "d" + dev_no + "a").append("<div id='r" + room_no + "d" + dev_no + "a3' class='dev_sw_box2'></div>");
    $("#r" + room_no + "d" + dev_no + "a3").append("<button type='button' id='r" + room_no + "d" + dev_no + "b2g' class='button_akt'>Auto</button>");
    $("#r" + room_no + "d" + dev_no + "a").append("<div id='r" + room_no + "d" + dev_no + "a4' class='dev_sw_box3'></div>");
    $("#r" + room_no + "d" + dev_no + "a4").append("<button type='button' id='r" + room_no + "d" + dev_no + "b3g' class='button_akt'>Ein</button>");
    device_switch_get_state(room_no, dev_no, fhem_HS_dev, fhem_dev);
    $("#r" + room_no + "d" + dev_no + "b1g").click(function(){
        device_switch_click_func(room_no, dev_no, fhem_HS_dev, fhem_dev, "aus");
    }); 
    $("#r" + room_no + "d"+dev_no+"b2g").click(function(){
        device_switch_click_func(room_no, dev_no, fhem_HS_dev, fhem_dev, "auto");
    }); 
    $("#r" + room_no + "d"+dev_no+"b3g").click(function(){
        device_switch_click_func(room_no, dev_no, fhem_HS_dev, fhem_dev, "ein");
    }); 
    if ( window.innerWidth < 600 ) {
        $("#r" + room_no + "hd" + dev_no).css("border-bottom","1px solid #a80329");
        if ( dev_no > 4 ) {
            $("#r" + room_no + "s").css("height","100px");
            $("#r" + room_no + "h").css("height","100px");
            $("#r" + room_no + "hd" + dev_no).css("top","60px");
        }
    }
}

function add_device_ht(room_no, dev_no, dev_name, fhem_dev) {
    device_enable_switch(room_no);
    $("#r"+room_no+"d").append("<div class='dev' id='r" + room_no + "d" + dev_no + "'></div>");
    $("#r"+room_no+"d"+dev_no).append("<div class='dev_label' id='r" + room_no + "d" + dev_no + "l'></div>");
    $("#r"+room_no+"d"+dev_no+"l").append("<div class='dev_label' id='r" + room_no + "d" + dev_no + "l1'></div><div class='dev_label' id='r" + room_no + "d" + dev_no + "l2'></div><div class='dev_label' id='r" + room_no + "d" + dev_no + "l3'></div>");
    $("#r"+room_no+"hd"+dev_no).css("display","inline");
    $("#r"+room_no+"d"+dev_no + "l1").html(dev_name).css("display","inline");
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "valveposition" }, function(data) {
	$("#r"+room_no+"d"+dev_no + "l2").html("Ventil: "+data).css("display","inline");
    });
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "temperature" }, function(data) {
	$("#r"+room_no+"d"+dev_no + "l3").html("Temperatur: "+data).css("display","inline");
    });
    if (dev_name.length > 7) $("#r" + room_no + "hd" + dev_no + "l").css("font-size","70%");
    $("#r"+room_no+"d"+dev_no + "a").html("action");
    $("#r"+room_no+"hd" + dev_no + "l").html(dev_name);
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "mode" }, function(data) {
        $("#r"+room_no+"hd"+dev_no+"v").append("("+data+") ");
        $("#r"+room_no+"hd"+dev_no+"v").css("font-size","xx-small");
        $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature" }, function(data) {
            $("#r"+room_no+"hd"+dev_no+"v").append(parseInt(data*10)/10+" &deg;C");
        });
    });
    $("#r"+room_no+"d"+dev_no).append("<div class='dev_ht' id='r"+room_no+"d"+dev_no+"d'></div>");
    $("#r"+room_no+"d"+dev_no+"d").append("<div class='dev_ht_temp' id='r"+room_no+"d"+dev_no+"d1'></div>");
    $("#r"+room_no+"d"+dev_no+"d1").append("<input id='r"+room_no+"d"+dev_no+"s1' min='5' max='22' step='0.5' data-highlight='true' data-role='slider' />");   
    $("#r"+room_no+"d"+dev_no+"s1").slider();
    $("#r"+room_no+"d"+dev_no+"d").append("<div class='dev_ht_am' id='r"+room_no+"d"+dev_no+"d2'></div>");
    $("#r"+room_no+"d"+dev_no+"d2").append("<select name='room"+room_no+"d"+dev_no+"s2' id='r"+room_no+"d"+dev_no+"s2' data-role='slider'><option value='auto'>Auto</option><option value='manual'>Man.</option></select>");
    $("#r"+room_no+"d"+dev_no+"s2").slider();
    $("#r"+room_no+"d"+dev_no+"d").append("<div class='dev_ht_ok' id='r"+room_no+"d"+dev_no+"d3'></div>");
    $("#r"+room_no+"d"+dev_no+"d3").append("<input type='button' id='r"+room_no+"d"+dev_no+"s3' value='Wert setzen' />");
    $("#r"+room_no+"d"+dev_no+"s3").buttonMarkup({ theme: "a" });
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature" }, function(data) {
        $("#r"+room_no+"d"+dev_no+"s1").val(data).slider("refresh");
    });
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "mode" }, function(data) {
        $("#r"+room_no+"d"+dev_no+"s2").val(data).slider("refresh");	
    });
    $("#r"+room_no+"d"+dev_no+"s3").click(function(){
        mytemp=$("#r"+room_no+"d"+dev_no+"s1").val();
        mymode=$("#r"+room_no+"d"+dev_no+"s2").val();
        if ( mymode == "auto" ) { 
            $.get(basedir+'setfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature", wert: mymode, wert1: mytemp }, function(data) {
                alert(data);
            });	
        } else {
            $.get(basedir+'setfhem.php',{geraet: fhem_dev, eigenschaft: "desiredTemperature", wert: mytemp }, function(data) {
                alert(data);
            });
        }	
    }); 
    if ( window.innerWidth < 600 ) {
       //alert("mobile"); 
        $("#r"+room_no+"d"+dev_no+"d1").css("width","100%");
        $("#r"+room_no+"d"+dev_no+"d2").css("width","40%").css("top","50px").css("left","10%");
        $("#r"+room_no+"d"+dev_no+"d3").css("width","50%").css("top","45px").css("left","50%");
        $("#r"+room_no+"d"+dev_no+"d").css("height","100px");
        $("#r" + room_no + "hd" + dev_no).css("border-bottom","1px solid #a80329");
        if ( dev_no > 4 ) {
            $("#r" + room_no + "s").css("height","100px");
            $("#r" + room_no + "h").css("height","100px");
            $("#r" + room_no + "hd" + dev_no).css("top","60px");
        }
    }
}

function add_device_measure(room_no, dev_no, dev_name, fhem_dev, fhem_reading, unit) {
    $("#r" + room_no + "hd" + dev_no).css("display","inline");
    $("#r" + room_no + "hd" + dev_no + "l").html(dev_name);
    if (dev_name.length > 7) $("#r" + room_no + "hd" + dev_no + "l").css("font-size","xx-small");
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: fhem_reading }, function(data) {
        $("#r"+room_no+"hd"+dev_no+"v").append(parseInt(data*10)/10+" "+unit);
    });
    if ( window.innerWidth < 600 ) {
        $("#r" + room_no + "hd" + dev_no).css("border-bottom","1px solid #a80329");
        if ( dev_no > 4 ) {
            $("#r" + room_no + "s").css("height","100px");
            $("#r" + room_no + "h").css("height","100px");
            $("#r" + room_no + "hd" + dev_no).css("top","60px");
        }
    }
}

function add_sw_field( room_no ) {
    $("#haus").append("<div class='room' id='r" + room_no + "'></div>");
}

function add_switch(room_no, sw_no, sw_name, fhem_hs_dev, fhem_dev) {
    $("#r"+room_no).append("<div class='dev_sx' id='r"+room_no+"d"+sw_no+"'></div>");
    $("#r"+room_no+"d"+sw_no).append("<div class='dev_sx_s' id='r"+room_no+"d"+sw_no+"s'></div>")
                             .append("<div class='dev_sx_t' id='r"+room_no+"d"+sw_no+"t'></div>");
    $("#r"+room_no+"d"+sw_no+"t").append("<div class='dev_sx_touch' id='r"+room_no+"d"+sw_no+"t1' style='left: 0px;'></div>")
                                 .append("<div class='dev_sx_touch' id='r"+room_no+"d"+sw_no+"t2' style='left: 66px;'></div>")
                                 .append("<div class='dev_sx_touch' id='r"+room_no+"d"+sw_no+"t3' style='left: 132px;'></div>");
    $("#r"+room_no+"d"+sw_no+"t1").click(function(){
        // Set device off
        $.get(basedir+'setfhem.php',{geraet: fhem_hs_dev, wert: "0" }, function(data) {
            //alert(data);
        });
        //alert("Feld links");
        set_switch(room_no, sw_no, sw_name, fhem_hs_dev, fhem_dev);
    });
    $("#r"+room_no+"d"+sw_no+"t2").click(function(){
        // Set device on
        $.get(basedir+'setfhem.php',{geraet: fhem_hs_dev, wert: "1" }, function(data) {
            //alert(data);
        });
        //alert("Feld mitte");
        set_switch(room_no, sw_no, sw_name, fhem_hs_dev, fhem_dev);
    });
    $("#r"+room_no+"d"+sw_no+"t3").click(function(){
        // Set device auto
        $.get(basedir+'setfhem.php',{geraet: fhem_hs_dev, wert: "2" }, function(data) {
            //alert(data);
        });
        //alert("Feld rechts");
        set_switch(room_no, sw_no, sw_name, fhem_hs_dev, fhem_dev);
    });
    $("#r"+room_no+"d"+sw_no+"s").append("<div class='dev_sx_head' id='r"+room_no+"d"+sw_no+"s1'>" + sw_name + "</div>");
    $("#r"+room_no+"d"+sw_no+"s").append("<div class='dev_sx_sw'   id='r"+room_no+"d"+sw_no+"s2'><img id='r"+room_no+"d"+sw_no+"s2i' src='/content/schalter.php?st=0&sw=0'></div>");
    set_switch(room_no, sw_no, sw_name, fhem_hs_dev, fhem_dev);
    if ( window.innerWidth < 600 ) {

    }
}

function set_switch(room_no, sw_no, sw_name, fhem_hs_dev, fhem_dev) {
    var sw_st = 0;
    var sw_sw = 0;
    $.get(basedir+'getfhem.php',{geraet: fhem_dev, eigenschaft: "state" }, function(data) {
//        alert(data);
        if ( data == "on" || data == "set_on" ) { sw_st = 1; } else { sw_st = 0; }
        $.get(basedir+'getfhem.php',{geraet: fhem_hs_dev, eigenschaft: "state" }, function(data) {
//            alert(data);
            if ( data == "auto" ) sw_sw = "A";
            if ( data == "ein" ) sw_sw = "1";
            if ( data == "aus" ) sw_sw = "0";
//            alert("ST:" + sw_st + " SW:" + sw_sw);
            $("#r"+room_no+"d"+sw_no+"s2i").attr("src", "/content/schalter.php?st="+sw_st+"&sw="+sw_sw);
        });
    });
}
