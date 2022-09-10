<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ($webroot.'/php_inc/check_mobile.php');
//$db_dh = new mysqli($db_dh_server, $db_dh_user, $db_dh_pass, $db_dh_db);
$db_sh = new mysqli($db_sh_server, $db_sh_user, $db_sh_pass, $db_sh_db);
$mobile_browser = is_mobile_browser(); 
?>
<html>
  <head>
    <meta charset="utf-8">
    <style>

<?php
if($mobile_browser) { 
  echo "
  #zeit { 
  height: 70px;
  width: 100%;
  font-weight: bold;
  text-align: center;
  border: 1px solid #000;
  background: #ddd;
  position: absolute;
  padding: 10px;
  }
  #wetter1a, #wetter1b, #wetter1c, #wetter1d {
  height: 40px;
  width: 30%;
  background: #ddd;
  position: absolute;
  text-align: center;
  border: 1px solid #000;
  padding: 5px;
  }
  #wetter1a {
  left: 0%;
  top: 90px;
  }
  #wetter1b { 
  left: 33%;
  top: 90px;
  }
  #wetter1c {
  left: 66%;
  top: 90px;
  }
  #wetter1d {
  left: 0%;
  top: 140px;
  }
  #wetter4 {
  border: 1px solid #000;
  background: #ddd;
  position: absolute;
  width: 100%;
  left: 0px;
  top: 190px;
  }
  #wetter_s1, #wetter_s2, #wetter_s3 {
  height: 50px;
  width: 33%;
  background: #dddddd;
  position: absolute;
  text-align: center;
  border: 1px solid #000;
  padding: 3px;
  top: 570px;
  }
  #wetter_s1 {
  left: 0%;
  }
  #wetter_s2 {
  left: 33%;
  }
  #wetter_s3 {
  left: 67%;
  }
  #wetter_s5, #wetter_s6, #wetter_s7, #wetter_s8 {
  visibility: hidden;
  }
  .label {
  font-size: 10px;
  }
  .wert {
  font-size: 15px;
  }
  \n";
} else {
  echo "
  #zeit {
  left: 10px;
  top: 30px;
  height: 80px;
  width: 300px;
  font-weight: bold;
  text-align: center;
  border: 1px solid #000;
  position: absolute;
  padding: 10px;
  }
  #wetter1a, #wetter1b, #wetter1c, #wetter1d, #wetter3 {
  height: 50px;
  width: 130px;
  background: #ddd;
  position: absolute;
  text-align: center;
  border: 1px solid #000;
  padding: 10px;
  }
  #wetter1a {
  left: 10px;
  top: 150px;
  }
  #wetter1b {
  left: 180px;
  top: 150px;
  }
  #wetter1c {
  left: 10px;
  top: 250px;
  }
  #wetter1d {
  left: 180px;
  top: 250px;
  }
  #wetter3 {
  left: 10px;
  top: 350px;
  }
  #wetter4 {
  border: 1px solid #000;
  background: #ddd;
  position: absolute;
  left: 350px;
  top: 30px;
  }
  #wetter_s1, #wetter_s2, #wetter_s3, #wetter_s4, #wetter_s5, #wetter_s6, #wetter_s7, #wetter_s8{
  height: 50px;
  width: 100px;
  background: #dddddd;
  position: absolute;
  text-align: center;
  border: 1px solid #000;
  padding: 3px;
  top: 430px;
  }
  #wetter_s1 {
  left: 350px;
  }
  #wetter_s2 {
  left: 470px;
  }
  #wetter_s3 {
  left: 590px;
  }
  #wetter_s4 {
  left: 710px;
  }
  #wetter_s5 {
  left: 830px;
  }
  #wetter_s6 {
  left: 950px;
  }
  #wetter_s7 {
  left: 1080px;
  width: 50px;
  font-size: 28px;
  background: #AAAAAA;
  }
  #wetter_s8 {
  left: 1140px;
  width: 50px;
  font-size: 28px;
  background: #AAAAAA;
  }
  .label {
  font-size: 15px;
  }
  .wert {
  font-size: 20px;
  }
  \n";
}

?>
</style>
<script>
  var d = new Date();
  var n = d.getTime();
  var mycolor = '#FF0000';
  var but_color2 = '#DDDDDD';
  var but_color1 = '#AAAAAA';

function rgb2hex(rgb) {
    rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);
    function hex(x) {
        return ("0" + parseInt(x).toString(16)).slice(-2);
    }
    return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
}

function swipeleftHandler( event ) {
    if (parseInt($('#wetter_t4').html()) > 0) {
        var offset=parseInt($('#wetter_t4').html()) -1;
        $('#wetter_t4').html(offset);
        set_divs();
    }
}

function swiperightHandler( event ) {
    var offset=parseInt($('#wetter_t4').html()) +1;
    $('#wetter_t4').html(offset);
    set_divs();
}

function md_wetter_s7() {
    $('#wetter_s7').css('backgroundColor', but_color2);
}

function mu_wetter_s7() {
    $('#wetter_s7').css('backgroundColor', but_color1);
}

function md_wetter_s8() {
    $('#wetter_s8').css('backgroundColor', but_color2);
}

function mu_wetter_s8() {
    $('#wetter_s8').css('backgroundColor', but_color1);
}

$(window).resize(function() {
    set_divs();
});

$( "#wetter_dia" ).on( "swipeleft", swipeleftHandler );
$( "#wetter_dia" ).on( "swiperight", swiperightHandler );

function set_divs() {
//    alert($('#wetter_t1').html());
	var d = new Date();
	var n = d.getTime();
	var w = screen.width;
	var add_param = "";
	if ( w > 846 ) { w = 846; } else { if ( w > 500 ) { w = w-50; } }
    switch($('#wetter_t1').html()) {
    case "1m":
		$('#wetter_s1').css('backgroundColor', but_color1);
		$('#wetter_s2').css('backgroundColor', but_color2);
		$('#wetter_s3').css('backgroundColor', but_color1);
		$('#wetter_s4').css('backgroundColor', but_color1);
        $('#wetter_s5').css('backgroundColor', but_color1);
        $('#wetter_s6').css('backgroundColor', but_color1);
        break;
    case "1y":
		$('#wetter_s1').css('backgroundColor', but_color1);
		$('#wetter_s2').css('backgroundColor', but_color1);
		$('#wetter_s3').css('backgroundColor', but_color2);
		$('#wetter_s4').css('backgroundColor', but_color1);
        $('#wetter_s5').css('backgroundColor', but_color1);
        $('#wetter_s6').css('backgroundColor', but_color1);
        break;
    case "2y":
		$('#wetter_s1').css('backgroundColor', but_color1);
		$('#wetter_s2').css('backgroundColor', but_color1);
		$('#wetter_s3').css('backgroundColor', but_color1);
		$('#wetter_s4').css('backgroundColor', but_color2);
        $('#wetter_s5').css('backgroundColor', but_color1);
        $('#wetter_s6').css('backgroundColor', but_color1);
        break;
    case "5y":
        $('#wetter_s1').css('backgroundColor', but_color1);
        $('#wetter_s2').css('backgroundColor', but_color1);
        $('#wetter_s3').css('backgroundColor', but_color1);
        $('#wetter_s4').css('backgroundColor', but_color1);
        $('#wetter_s5').css('backgroundColor', but_color2);
        $('#wetter_s6').css('backgroundColor', but_color1);
        break;
    case "10y":
        $('#wetter_s1').css('backgroundColor', but_color1);
        $('#wetter_s2').css('backgroundColor', but_color1);
        $('#wetter_s3').css('backgroundColor', but_color1);
        $('#wetter_s4').css('backgroundColor', but_color1);
        $('#wetter_s5').css('backgroundColor', but_color1);
        $('#wetter_s6').css('backgroundColor', but_color2);
        break;
    default:
		$('#wetter_s1').css('backgroundColor', but_color2);
		$('#wetter_s2').css('backgroundColor', but_color1);
		$('#wetter_s3').css('backgroundColor', but_color1);
		$('#wetter_s4').css('backgroundColor', but_color1);
        $('#wetter_s5').css('backgroundColor', but_color1);
        $('#wetter_s6').css('backgroundColor', but_color1);
	} 

    switch($('#wetter_t2').html()) {
    case "1b":
		$('#wetter1a').css('backgroundColor', but_color1);
		$('#wetter1b').css('backgroundColor', but_color2);
		$('#wetter1c').css('backgroundColor', but_color1);
		$('#wetter1d').css('backgroundColor', but_color1);
		$('#wetter3').css('backgroundColor', but_color1);
		mycolor='0000FF';
		mylegend='Luftdruck';
		mydatabase='rf24hub';
        break;
    case "1c":
		$('#wetter1a').css('backgroundColor', but_color1);
		$('#wetter1b').css('backgroundColor', but_color1);
		$('#wetter1c').css('backgroundColor', but_color2);
		$('#wetter1d').css('backgroundColor', but_color1);
		$('#wetter3').css('backgroundColor', but_color1);
		mycolor='00FFFF';
		mylegend='rel. Luftfeuchte';
		mydatabase='rf24hub';
        break;
    case "1d":
		$('#wetter1a').css('backgroundColor', but_color1);
		$('#wetter1b').css('backgroundColor', but_color1);
		$('#wetter1c').css('backgroundColor', but_color1);
		$('#wetter1d').css('backgroundColor', but_color2);
		$('#wetter3').css('backgroundColor', but_color1);
		mycolor='FFFF00';
		mylegend='Solarzelle';
		mydatabase='rf24hub';
		add_param ='&ymin=0&ymax=110';
        break;
    case "3":
		$('#wetter1a').css('backgroundColor', but_color1);
		$('#wetter1b').css('backgroundColor', but_color1);
		$('#wetter1c').css('backgroundColor', but_color1);
		$('#wetter3').css('backgroundColor', but_color2);
		mycolor='00FF00';
		mylegend='Batterie';
		mydatabase='rf24hub';
        break;
    default:
		$('#wetter1a').css('backgroundColor', but_color2);
		$('#wetter1b').css('backgroundColor', but_color1);
		$('#wetter1c').css('backgroundColor', but_color1);
		$('#wetter1d').css('backgroundColor', but_color1);
		$('#wetter3').css('backgroundColor', but_color1);
		mycolor='FF0000';
		mylegend='Temperatur';
		mydatabase='rf24hub';
	} 
//	alert(mycolor);
	$('#wetter_dia').attr('src', '/content/diagramm.php?database='+mydatabase+'&sensor1='+$('#wetter_t3').html()+'&sensor1color='+mycolor+'&sensor1legend='+mylegend+'&sizex='+w+'&sizey=370&offset='+$('#wetter_t4').html()+'&range='+$('#wetter_t1').html()+add_param+'&t='+n);
} 
$('#zeit').css('backgroundColor', but_color1);
$('#wetter_t1').hide();  
$('#wetter_t2').hide();  
$('#wetter_t3').hide(); 
$('#wetter_t4').hide(); 
set_divs();
$("#wetter_s1").click(function(){
  $('#wetter_t1').html('1d')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s2").click(function(){
  $('#wetter_t1').html('1m')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s3").click(function(){
  $('#wetter_t1').html('1y')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s4").click(function(){
  $('#wetter_t1').html('2y')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s5").click(function(){
  $('#wetter_t1').html('5y')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s6").click(function(){
  $('#wetter_t1').html('10y')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s7").click(function(){
    var offset=parseInt($('#wetter_t4').html()) +1;
    $('#wetter_t4').html(offset);
    set_divs();
});  
$("#wetter1a").click(function(){
  $('#wetter_t2').html('1a')
  $('#wetter_t3').html('<?php echo $wetter_temp_sensor; ?>')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter_s8").click(function(){
    if (parseInt($('#wetter_t4').html()) > 0) {
        var offset=parseInt($('#wetter_t4').html()) -1;
        $('#wetter_t4').html(offset);
        set_divs();
    }
});  
$("#wetter1b").click(function(){
  $('#wetter_t2').html('1b')
  $('#wetter_t3').html('<?php echo $wetter_pres_sensor; ?>')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter1c").click(function(){
  $('#wetter_t2').html('1c')
  $('#wetter_t3').html('<?php echo $wetter_humi_sensor; ?>')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter1d").click(function(){
  $('#wetter_t2').html('1d')
  $('#wetter_t3').html('<?php echo $wetter_sol_sensor; ?>')
  $('#wetter_t4').html('0')
  set_divs();
});  
$("#wetter3").click(function(){
  $('#wetter_t2').html('3')
  $('#wetter_t3').html('<?php echo $wetter_ubat_sensor; ?>')
  $('#wetter_t4').html('0')
  set_divs();
});  

</script>	
<meta http-equiv="expires" content="0">
</head>
<div id="seitenbereich">
<div id='zeit'>
Die aktuellen Werte aus Nottuln: <br>
<!--
Kostenlose, frei konfigurierbare Homepage-Uhr von www.schnelle-online.info/Homepage/Tools.html. Ohne Gewähr, ohne Haftung.
Nutzungbedingung: Dieser Kommentar und der Link unten dürfen nicht entfernt oder (nofollow) modifiziert werden.
-->
<a style="text-decoration:none;border-style:none;color:black;" target="_blank" href="http://www.schnelle-online.info/Atomuhr-Uhrzeit.html" id="soitime121693632552">Uhrzeit</a><br/>
<a style="text-decoration:none;border-style:none;color:black;" target="_blank" href="http://www.schnelle-online.info/Kalender.html" id="soidate121693632552">Kalender</a>
<script type="text/javascript">
SOI = (typeof(SOI) != 'undefined') ? SOI : {};
(SOI.ac21fs = SOI.ac21fs || []).push(function() {
(new SOI.DateTimeService("121693632552", "DE")).appendTime(" Uhr").setWeekdayMode(1).setMonthMode(1).start();});
(function() {
  if (typeof(SOI.scrAc21) == "undefined") {
    SOI.scrAc21=document.createElement('script');
    SOI.scrAc21.type='text/javascript';
    SOI.scrAc21.async=true;
    SOI.scrAc21.src=((document.location.protocol == 'https:') ? 'https://' : 'http://') + 'homepage-tools.schnelle-online.info/Homepage/atomicclock2_1.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(SOI.scrAc21, s);
  }
})();
</script>
</div>
<div id='wetter1a'><center><div class='label'>Temperatur:</div><div class='wert'>
<?php
  $results = $db_sh->query("SELECT last_value FROM sensor_im where sensor_id = ".$wetter_temp_sensor);
  $row = $results->fetch_assoc();
  echo number_format($row['last_value'],1, ",", ".");
?>
 C</b></center></div>
<div id='wetter1b'><center><div class='label'>Luftdruck:</div><div class='wert'>
<?php
  $results = $db_sh->query("SELECT last_value FROM sensor_im where sensor_id = ".$wetter_pres_sensor);
  $row = $results->fetch_assoc();
  echo number_format($row['last_value'],0, ",", ".");
?>
 hPa</b></center></div>
<div id='wetter1c'><center><div class='label'>rel. Luftfeuchte:</div><div class='wert'>
<?php
  $results = $db_sh->query("SELECT last_value FROM sensor_im where sensor_id = ".$wetter_humi_sensor);
  $row = $results->fetch_assoc();
  echo number_format($row['last_value'],1, ",", ".");
?>
 &#37;</div></center></div>
<div id='wetter1d'><center><div class='label'>Solarzelle:</div><div class='wert'>
<?php
  $results = $db_sh->query("SELECT last_value FROM sensor_im where sensor_id = ".$wetter_sol_sensor);
  $row = $results->fetch_assoc();
  echo number_format($row['last_value'],1, ",", ".");
?>
 &percnt;</div></center></div>
<div id='wetter4'><img id='wetter_dia' /></div>
<div id='wetter_s1'>Diagramm<br>1 Tag</div>
<div id='wetter_s2'>Diagramm<br>1 Monat</div>
<div id='wetter_s3'>Diagramm<br>1 Jahr</div>
<div id='wetter_s4'>Diagramm<br>2 Jahre</div>
<div id='wetter_s5'>Diagramm<br>5 Jahre</div>
<div id='wetter_s6'>Diagramm<br>10 Jahre</div>
<div id='wetter_s7' onmousedown="md_wetter_s7()" onmouseup="mu_wetter_s7()" ><img src="/img/arrow_left.gif" height="50" width="50">
</div>
<div id='wetter_s8' onmousedown="md_wetter_s8()" onmouseup="mu_wetter_s8()" ><img src="/img/arrow_right.gif" height="50" width="50">
</div>
<div id='wetter_t1'>1d</div>
<div id='wetter_t2'>1a</div>
<div id='wetter_t3'><?php echo $wetter_temp_sensor; ?></div>
<div id='wetter_t4'>0</div>

</center>
</div>
<?php
$db_dh->close(); 
$db_sh->close(); 
?>

