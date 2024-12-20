<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ($webroot.'/php_inc/check_mobile.php');

function set_pas_bg ( $in ) {
  if ( strncmp($in,"y",1) === 0 ) {
    echo "but_color_help1";
  } else {
    echo "but_color1";
  }
}

function set_akt_bg ( $in ) {
  if ( strncmp($in,"y",1) === 0 ) {
    echo "but_color_help2";
  } else {
    echo "but_color2";
  }
}

//$www_db = new PDO("mysql:host=$db_www_server;dbname=$db_www_db", $db_www_user, $db_www_pass);
$rf24_db = new mysqli($db_rf24_server, $db_rf24_user, $db_rf24_pass, $db_rf24_db);
$mobile_browser = is_mobile_browser(); 
$bat_name = array();
$bat_val = array();
$bat_min = array();
$bat_max = array();
$bat_sens = array();
$bat_nh = array();
$stmt = "select bat_name, c.sensor_id, dia_min, dia_max, last_value, need_help from node a, battery b, sensor c, sensor_im d
         where a.battery_id = b.battery_id and a.node_id = c.node_id and bat_channel = c.channel and c.sensor_id = d.sensor_id and bat_mon = 'y'
         order by bat_order";
foreach ( $rf24_db->query($stmt) as $row )  {
  array_push($bat_name,$row['bat_name']);
  array_push($bat_sens,$row['sensor_id']);
  array_push($bat_min,$row['dia_min']);
  array_push($bat_max,$row['dia_max']);
  array_push($bat_val,$row['last_value']);
  array_push($bat_nh,$row['need_help']);
}

?>
<html>
  <head>
    <meta charset="utf-8">
    <style>
    
.batt_text {
    font-family: Arial, Helvetica, sans-serif;
    font-size: small;
    position: absolute;
    text-align: center;
    width: 100px;	  
    top: -1px;
}
 
.div_canvas {
    position: absolute;
    top: 20px;
    left: 5px;
}

<?php
if($mobile_browser) { 
?>

 #batt_dia_div { 
  border: 1px solid #000; 
  background: #ddd; 
  position: absolute;
  left: 0px;
  top: 500px;
  height: 390px;
  width: 100%;	  
  }

#range_1d, #range_1m, #range_3m, #range_6m, #range_1y, #range_2y, #range_5y {  
  height: 45px;
  width: 30%;	  
  position: absolute;
  text-align: center;
  border: 1px solid #000; 
}	  
    
#batt1, #batt2, #batt3, #batt4, #batt5, #batt6, #batt7, #batt8, #batt9, #batt10, #batt11, #batt12, #batt13, #batt14, #batt15, #batt16, #batt17, #batt18 {
  height: 70px;
  width: 30%;	  
  position: absolute;
  text-align: center;
  border: 1px solid #000; 
}	  

#batt1, #batt4, #batt7, #batt10, #batt13, #batt16 {
  left: 2%;
}
#batt2, #batt5, #batt8, #batt11, #batt14, #batt17 {
  left: 35%;
}
#batt3, #batt6, #batt9, #batt12, #batt15, #batt18 {
  left: 68%;
}
#batt1, #batt2, #batt3 {
  top:  10px;
}
#batt4, #batt5, #batt6 {
  top:  90px;
}
#batt7, #batt8, #batt9 {
  top:  170px;
}
#batt10, #batt11, #batt12 {
  top:  250px;
}
#batt13, #batt14, #batt15 {
  top:  330px;
}
#batt16, #batt17, #batt18 {
  top:  410px;
}

#range_1d {
  left: 2%;
  top:  900px;
}

#range_1m {
  left: 35%;
  top:  900px;
}

#range_3m {
  left: 68%;
  top:  900px;
}

#range_6m {
  left: 2%;
  top:  950px;
}

#range_1y {
  left: 35%;
  top:  950px;
}

#range_2y {
  left: 68%;
  top:  950px;
}

#range_5y {
  left: 2%;
  top:  1000px;
}

<?php
} else { 
?>

#range_1d, #range_1m, #range_3m, #range_6m, #range_1y, #range_2y, #range_5y {  
  height: 60px;
  width: 110px;	  
  position: absolute;
  text-align: center;
  border: 1px solid #000; 
  }	  
    
#batt1, #batt2, #batt3, #batt4, #batt5, #batt6, #batt7, #batt8, #batt9, #batt10, #batt11, #batt12, #batt13, #batt14, #batt15, #batt16, #batt17, #batt18 {
  height: 70px;
  width: 100px;	  
  position: absolute;
  text-align: center;
  border: 1px solid #000; 
  }	  

#batt1, #batt4, #batt7, #batt10, #batt13, #batt16 {
  left: 0px;
}
#batt2, #batt5, #batt8, #batt11, #batt14, #batt17 {
  left: 110px;
}
#batt3, #batt6, #batt9, #batt12, #batt15, #batt18 {
  left: 220px;
}
#batt1, #batt2, #batt3 {
  top:  10px;
}
#batt4, #batt5, #batt6 {
  top:  90px;
}
#batt7, #batt8, #batt9 {
  top:  170px;
}
#batt10, #batt11, #batt12 {
  top:  250px;
}
#batt13, #batt14, #batt15 {
  top:  330px;
}
#batt16, #batt17, #batt18 {
  top:  410px;
}
 
 #batt_dia_div { 
  border: 1px solid #000; 
  background: #ddd; 
  position: absolute;
  left: 350px;
  top: 10px;
  height: 390px;
  width: 850px;	  
  }

#range_1d, #range_1m, #range_3m, #range_6m, #range_1y, #range_2y, #range_5y {
  top:  410px;
}
  
#range_1d {
  left: 350px;
}

#range_1m {
  left: 470px;
}

#range_3m {
  left: 590px;
}

#range_6m {
  left: 710px;
}

#range_1y {
  left: 830px;
}

#range_2y {
  left: 950px;
}

#range_5y {
  left: 1070px;
}

<?php
}
?>
</style>

<script type="text/javascript" src="js/segment-display.js"></script>
<script type="text/javascript">

var display = [];
var d = new Date();
var n = d.getTime();
var but_color2 = '#DDDDDD';
var but_color1 = '#AAAAAA';
var but_color_help1 = '#AAAA00';
var but_color_help2 = '#FFFF00';
var but_color_down = '#AA0000';
const but_col1 = new Array(<?php set_pas_bg($bat_nh[0]); ?>, <?php set_pas_bg($bat_nh[1]); ?>, <?php set_pas_bg($bat_nh[2]); ?>,
                           <?php set_pas_bg($bat_nh[3]); ?>, <?php set_pas_bg($bat_nh[4]); ?>, <?php set_pas_bg($bat_nh[5]); ?>,
                           <?php set_pas_bg($bat_nh[6]); ?>, <?php set_pas_bg($bat_nh[7]); ?>, <?php set_pas_bg($bat_nh[8]); ?>,
                           <?php set_pas_bg($bat_nh[9]); ?>, <?php set_pas_bg($bat_nh[10]); ?>, <?php set_pas_bg($bat_nh[11]); ?>,
                           <?php set_pas_bg($bat_nh[12]); ?>, <?php set_pas_bg($bat_nh[13]); ?>, <?php set_pas_bg($bat_nh[14]); ?>,
                           <?php set_pas_bg($bat_nh[15]); ?>, <?php set_pas_bg($bat_nh[16]); ?>, <?php set_pas_bg($bat_nh[17]); ?>);
const but_col2 = new Array(<?php set_akt_bg($bat_nh[0]); ?>, <?php set_akt_bg($bat_nh[1]); ?>, <?php set_akt_bg($bat_nh[2]); ?>,
                           <?php set_akt_bg($bat_nh[3]); ?>, <?php set_akt_bg($bat_nh[4]); ?>, <?php set_akt_bg($bat_nh[5]); ?>,
                           <?php set_akt_bg($bat_nh[6]); ?>, <?php set_akt_bg($bat_nh[7]); ?>, <?php set_akt_bg($bat_nh[8]); ?>,
                           <?php set_akt_bg($bat_nh[9]); ?>, <?php set_akt_bg($bat_nh[10]); ?>, <?php set_akt_bg($bat_nh[11]); ?>,
                           <?php set_akt_bg($bat_nh[12]); ?>, <?php set_akt_bg($bat_nh[13]); ?>, <?php set_akt_bg($bat_nh[14]); ?>,
                           <?php set_akt_bg($bat_nh[15]); ?>, <?php set_akt_bg($bat_nh[16]); ?>, <?php set_akt_bg($bat_nh[17]); ?>);

for ( let i=0; i<18; i++ ) {
  display.push( new SegmentDisplay("display"+i) );
  display[i].pattern         = "#.##";
  display[i].colorOn         = "#a90329";
  display[i].colorOff        = but_color2;
  display[i].digitHeight     = 17;
  display[i].digitWidth      = 10;
  display[i].draw();
}
display[0].setValue('<?php if(isset($bat_val[0]))  print $bat_val[0]; ?>');
display[1].setValue('<?php if(isset($bat_val[1]))  print $bat_val[1]; ?>');
display[2].setValue('<?php if(isset($bat_val[2]))  print $bat_val[2]; ?>');
display[3].setValue('<?php if(isset($bat_val[3]))  print $bat_val[3]; ?>');
display[4].setValue('<?php if(isset($bat_val[4]))  print $bat_val[4]; ?>');
display[5].setValue('<?php if(isset($bat_val[5]))  print $bat_val[5]; ?>');
display[6].setValue('<?php if(isset($bat_val[6]))  print $bat_val[6]; ?>');
display[7].setValue('<?php if(isset($bat_val[7]))  print $bat_val[7]; ?>');
display[8].setValue('<?php if(isset($bat_val[8]))  print $bat_val[8]; ?>');
display[9].setValue('<?php if(isset($bat_val[9]))  print $bat_val[9]; ?>');
display[10].setValue('<?php if(isset($bat_val[10]))  print $bat_val[10]; ?>');
display[11].setValue('<?php if(isset($bat_val[11]))  print $bat_val[11]; ?>');
display[12].setValue('<?php if(isset($bat_val[12]))  print $bat_val[12]; ?>');
display[13].setValue('<?php if(isset($bat_val[13]))  print $bat_val[13]; ?>');
display[14].setValue('<?php if(isset($bat_val[14]))  print $bat_val[14]; ?>');
display[15].setValue('<?php if(isset($bat_val[15]))  print $bat_val[15]; ?>');
display[16].setValue('<?php if(isset($bat_val[16]))  print $bat_val[16]; ?>');
display[17].setValue('<?php if(isset($bat_val[17]))  print $bat_val[17]; ?>');

  
function reset_batt(akt_but) {
  for ( let i=0; i<18; i++ ) {
    $('#batt'+String(i+1)).css('backgroundColor', but_col1[i]);
    display[i].colorOff = but_col1[i];
    display[i].draw();
  }
  $('#batt'+String(akt_but+1)).css('backgroundColor', but_col2[akt_but]);
  display[akt_but].colorOff = but_col2[akt_but];
  display[akt_but].draw();
  set_divs();
}

function reset_range() {
    $('#range_1d').css('backgroundColor', but_color1);
    $('#range_1m').css('backgroundColor', but_color1);
    $('#range_3m').css('backgroundColor', but_color1);
    $('#range_6m').css('backgroundColor', but_color1);
    $('#range_1y').css('backgroundColor', but_color1);
    $('#range_2y').css('backgroundColor', but_color1);
    $('#range_5y').css('backgroundColor', but_color1);
}

function set_divs() {
    var w = screen.width;

<?php
if($mobile_browser) { 
?>

    if ( w > 600 ) {
        $('#batt1').css('left', '1%');
        $('#batt1').css('top', '5px');
        $('#batt1').css('width', '30%');
        $('#batt2').css('left', '35%');
        $('#batt2').css('top', '5px');
        $('#batt2').css('width', '30%');

        $('#batt3').css('left', '69%');
        $('#batt3').css('top', '5px');
        $('#batt3').css('width', '30%');
        $('#batt4').css('left', '1%');
        $('#batt4').css('top', '80px');
        $('#batt4').css('width', '30%');

        $('#batt5').css('left', '35%');
        $('#batt5').css('top', '80px');
        $('#batt5').css('width', '30%');
        $('#batt6').css('left', '69%');
        $('#batt6').css('top', '80px');
        $('#batt6').css('width', '30%');

        $('#batt7').css('left', '1%');
        $('#batt7').css('top', '155px');
        $('#batt7').css('width', '30%');
        $('#batt8').css('left', '35%');
        $('#batt8').css('top', '155px');
        $('#batt8').css('width', '30%');

        $('#batt9').css('left', '69%');
        $('#batt9').css('top', '155px');
        $('#batt9').css('width', '30%');
        $('#batt10').css('left', '1%');
        $('#batt10').css('top', '230px');
        $('#batt10').css('width', '30%');

        $('#batt11').css('left', '69%');
        $('#batt11').css('top', '155px');
        $('#batt11').css('width', '30%');
        $('#batt12').css('left', '1%');
        $('#batt12').css('top', '230px');
        $('#batt12').css('width', '30%');

        $('#batt13').css('left', '69%');
        $('#batt13').css('top', '155px');
        $('#batt13').css('width', '30%');
        $('#batt14').css('left', '1%');
        $('#batt14').css('top', '230px');
        $('#batt14').css('width', '30%');

        
        $('#batt_dia_div').css('top', '305px');
    
        $('#range_1d').css('top', '700px');
        $('#range_1m').css('top', '700px');
        $('#range_3m').css('top', '700px');

        $('#range_6m').css('top', '750px');
        $('#range_1y').css('top', '750px');
        $('#range_2y').css('top', '750px');
    }

<?php
}  
?>
    
    if ( w > 846 ) { w = 846; } else { if ( w > 400 ) { w = w-60; } }
	$('#batt_dia').attr('src', '/content/diagramm.php?sensor1='+$('#batt_sensor').html()+'&sensor1color=FF0000&sensor1legend='+$('#batt_name').html()+'&sizex='+w+'&sizey=390&offset=0&range='+$('#batt_range').html()+'&ymin='+$('#batt_umin').html()+'&ymax='+$('#batt_umax').html()+'&t='+n);
}

$(window).resize(function() {
    set_divs();
});

$("#batt1").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[0])) print $bat_sens[0]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[0])) print $bat_name[0]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[0])) print  $bat_min[0]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[0])) print  $bat_max[0]; ?>');
    reset_batt(0);
});

$("#batt2").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[1])) print $bat_sens[1]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[1])) print $bat_name[1]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[1])) print  $bat_min[1]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[1])) print  $bat_max[1]; ?>');
    reset_batt(1);
});

$("#batt3").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[2])) print $bat_sens[2]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[2])) print $bat_name[2]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[2])) print  $bat_min[2]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[2])) print  $bat_max[2]; ?>');
    reset_batt(2);
});

$("#batt4").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[3])) print $bat_sens[3]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[3])) print $bat_name[3]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[3])) print  $bat_min[3]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[3])) print  $bat_max[3]; ?>');
    reset_batt(3);
});

$("#batt5").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[4])) print $bat_sens[4]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[4])) print $bat_name[4]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[4])) print  $bat_min[4]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[4])) print  $bat_max[4]; ?>');
    reset_batt(4);
});

$("#batt6").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[5])) print $bat_sens[5]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[5])) print $bat_name[5]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[5])) print  $bat_min[5]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[5])) print  $bat_max[5]; ?>');
    reset_batt(5);
});

$("#batt7").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[6])) print $bat_sens[6]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[6])) print $bat_name[6]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[6])) print  $bat_min[6]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[6])) print  $bat_max[6]; ?>');
    reset_batt(6);
});

$("#batt8").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[7])) print $bat_sens[7]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[7])) print $bat_name[7]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[7])) print  $bat_min[7]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[7])) print  $bat_max[7]; ?>');
    reset_batt(7);
});

$("#batt9").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[8])) print $bat_sens[8]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[8])) print $bat_name[8]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[8])) print  $bat_min[8]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[8])) print  $bat_max[8]; ?>');
    reset_batt(8);
});

$("#batt10").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[9])) print $bat_sens[9]; ?>');
    $('#batt_name').html('<?php   if(isset($bat_name[9])) print $bat_name[9]; ?>');
    $('#batt_umin').html('<?php   if(isset( $bat_min[9])) print  $bat_min[9]; ?>');
    $('#batt_umax').html('<?php   if(isset( $bat_max[9])) print  $bat_max[9]; ?>');
    reset_batt(9);
});

$("#batt11").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[10])) print $bat_sens[10]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[10])) print $bat_name[10]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[10])) print $bat_min[10]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[10])) print $bat_max[10]; ?>');
    reset_batt(10);
});

$("#batt12").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[11])) print $bat_sens[11]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[11])) print $bat_name[11]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[11])) print $bat_min[11]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[11])) print $bat_max[11]; ?>');
    reset_batt(11);
});

$("#batt13").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[12])) print $bat_sens[12]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[12])) print $bat_name[12]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[12])) print $bat_min[12]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[12])) print $bat_max[12]; ?>');
    reset_batt(12);
});

$("#batt14").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[13])) print $bat_sens[13]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[13])) print $bat_name[13]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[13])) print $bat_min[13]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[13])) print $bat_max[13]; ?>');
    reset_batt(13);
});

$("#batt15").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[14])) print $bat_sens[14]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[14])) print $bat_name[14]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[14])) print $bat_min[14]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[14])) print $bat_max[14]; ?>');
    reset_batt(14);
});

$("#batt16").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[15])) print $bat_sens[15]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[15])) print $bat_name[15]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[15])) print $bat_min[15]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[15])) print $bat_max[15]; ?>');
    reset_batt(15);
});

$("#batt17").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[16])) print $bat_sens[16]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[16])) print $bat_name[16]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[16])) print $bat_min[16]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[16])) print $bat_max[16]; ?>');
    reset_batt(16);
});

$("#batt18").click(function(){
    $('#batt_sensor').html('<?php if(isset($bat_sens[17])) print $bat_sens[17]; ?>');
    $('#batt_name').html('<?php if(isset($bat_name[17])) print $bat_name[17]; ?>');
    $('#batt_umin').html('<?php if(isset($bat_min[17])) print $bat_min[17]; ?>');
    $('#batt_umax').html('<?php if(isset($bat_max[17])) print $bat_max[17]; ?>');
    reset_batt(17);
});

$("#range_1d").click(function(){
    reset_range();
    $('#batt_range').html('1d');  
    $('#range_1d').css('backgroundColor', but_color2);
    set_divs();
});

$("#range_1m").click(function(){
    reset_range();
    $('#batt_range').html('1m');  
    $('#range_1m').css('backgroundColor', but_color2);
    set_divs();
});

$("#range_3m").click(function(){
    reset_range();
    $('#batt_range').html('3m');  
    $('#range_3m').css('backgroundColor', but_color2);
    set_divs();
});

$("#range_6m").click(function(){
    reset_range();
    $('#batt_range').html('6m');  
    $('#range_6m').css('backgroundColor', but_color2);
    set_divs();
});

$("#range_1y").click(function(){
    reset_range();
    $('#batt_range').html('1y');  
    $('#range_1y').css('backgroundColor', but_color2);
    set_divs();
});

$("#range_2y").click(function(){
    reset_range();
    $('#batt_range').html('2y');  
    $('#range_2y').css('backgroundColor', but_color2);
    set_divs();
});

$("#range_5y").click(function(){
    reset_range();
    $('#batt_range').html('5y');  
    $('#range_5y').css('backgroundColor', but_color2);
    set_divs();
});

$('#batt_sensor').html('<?php print $bat_sens[0]; ?>');
$('#batt_sensor').hide();  
$('#batt_name').html('<?php print $bat_name[0]; ?>');
$('#batt_name').hide();  
$('#batt_range').html('1d');  
$('#batt_range').hide();  
$('#batt_umin').html('1d');  
$('#batt_umin').hide();  
$('#batt_umax').html('1d');  
$('#batt_umax').hide();  

<?php if ( ! isset( $bat_name[0] ) ) print "$('#batt1').hide();"; ?>
<?php if ( ! isset( $bat_name[1] ) ) print "$('#batt2').hide();"; ?>
<?php if ( ! isset( $bat_name[2] ) ) print "$('#batt3').hide();"; ?>
<?php if ( ! isset( $bat_name[3] ) ) print "$('#batt4').hide();"; ?>
<?php if ( ! isset( $bat_name[4] ) ) print "$('#batt5').hide();"; ?>
<?php if ( ! isset( $bat_name[5] ) ) print "$('#batt6').hide();"; ?>
<?php if ( ! isset( $bat_name[6] ) ) print "$('#batt7').hide();"; ?>
<?php if ( ! isset( $bat_name[7] ) ) print "$('#batt8').hide();"; ?>
<?php if ( ! isset( $bat_name[8] ) ) print "$('#batt9').hide();"; ?>
<?php if ( ! isset( $bat_name[9] ) ) print "$('#batt10').hide();"; ?>
<?php if ( ! isset( $bat_name[10] ) ) print "$('#batt11').hide();"; ?>
<?php if ( ! isset( $bat_name[11] ) ) print "$('#batt12').hide();"; ?>
<?php if ( ! isset( $bat_name[12] ) ) print "$('#batt13').hide();"; ?>
<?php if ( ! isset( $bat_name[13] ) ) print "$('#batt14').hide();"; ?>
<?php if ( ! isset( $bat_name[14] ) ) print "$('#batt15').hide();"; ?>
<?php if ( ! isset( $bat_name[15] ) ) print "$('#batt16').hide();"; ?>
<?php if ( ! isset( $bat_name[16] ) ) print "$('#batt17').hide();"; ?>
<?php if ( ! isset( $bat_name[17] ) ) print "$('#batt18').hide();"; ?>


reset_batt(0);
reset_range();
$('#range_1d').css('backgroundColor', but_color2);
$('#batt_umin').html('<?php print $bat_min[0]; ?>');
$('#batt_umax').html('<?php print $bat_max[0]; ?>');

</script>	
<meta http-equiv="expires" content="0">
</head>


<div id='batt1'>
<div class='batt_text'>
<?php if(isset($bat_name[0])) print $bat_name[0]; ?>
</div>
<div class='div_canvas'>
<canvas id="display0" width="90" height="45"></canvas>
</div>
</div>
<div id='batt2'>
<div class='batt_text'>
<?php if(isset($bat_name[1])) print $bat_name[1]; ?>
</div>
<div class='div_canvas'>
<canvas id="display1" width="90" height="45"></canvas>
</div>
</div>
<div id='batt3'>
<div class='batt_text'>
<?php if(isset($bat_name[2])) print $bat_name[2]; ?>
</div>
<div class='div_canvas'>
<canvas id="display2" width="90" height="45"></canvas>
</div>
</div>
<div id='batt4'>
<div class='batt_text'>
<?php if(isset($bat_name[3])) print $bat_name[3]; ?>
</div>
<div class='div_canvas'>
<canvas id="display3" width="90" height="45"></canvas>
</div>
</div>
<div id='batt5'>
<div class='batt_text'>
<?php if(isset($bat_name[4])) print $bat_name[4]; ?>
</div>
<div class='div_canvas'>
<canvas id="display4" width="90" height="45"></canvas>
</div>
</div>
<div id='batt6'>
<div class='batt_text'>
<?php if(isset($bat_name[5])) print $bat_name[5]; ?>
</div>
<div class='div_canvas'>
<canvas id="display5" width="90" height="45"></canvas>
</div>
</div>
<div id='batt7'>
<div class='batt_text'>
<?php if(isset($bat_name[6])) print $bat_name[6]; ?>
</div>
<div class='div_canvas'>
<canvas id="display6" width="90" height="45"></canvas>
</div>
</div>
<div id='batt8'>
<div class='batt_text'>
<?php if(isset($bat_name[7])) print $bat_name[7]; ?>
</div>
<div class='div_canvas'>
<canvas id="display7" width="90" height="45"></canvas>
</div>
</div>
<div id='batt9'>
<div class='batt_text'>
<?php if(isset($bat_name[8])) print $bat_name[8]; ?>
</div>
<div class='div_canvas'>
<canvas id="display8" width="90" height="45"></canvas>
</div>
</div>
<div id='batt10'>
<div class='batt_text'>
<?php if(isset($bat_name[9])) print $bat_name[9]; ?>
</div>
<div class='div_canvas'>
<canvas id="display9" width="90" height="45"></canvas>
</div>
</div>
<div id='batt11'>
<div class='batt_text'>
<?php if(isset($bat_name[10])) print $bat_name[10]; ?>
</div>
<div class='div_canvas'>
<canvas id="display10" width="90" height="45"></canvas>
</div>
</div>
<div id='batt12'>
<div class='batt_text'>
<?php if(isset($bat_name[11])) print $bat_name[11]; ?>
</div>
<div class='div_canvas'>
<canvas id="display11" width="90" height="45"></canvas>
</div>
</div>
<div id='batt13'>
<div class='batt_text'>
<?php if(isset($bat_name[12])) print $bat_name[12]; ?>
</div>
<div class='div_canvas'>
<canvas id="display12" width="90" height="45"></canvas>
</div>
</div>
<div id='batt14'>
<div class='batt_text'>
<?php if(isset($bat_name[13])) print $bat_name[13]; ?>
</div>
<div class='div_canvas'>
<canvas id="display13" width="90" height="45"></canvas>
</div>
</div>
<div id='batt15'>
<div class='batt_text'>
<?php if(isset($bat_name[14])) print $bat_name[14]; ?>
</div>
<div class='div_canvas'>
<canvas id="display14" width="90" height="45"></canvas>
</div>
</div>
<div id='batt16'>
<div class='batt_text'>
<?php if(isset($bat_name[15])) print $bat_name[15]; ?>
</div>
<div class='div_canvas'>
<canvas id="display15" width="90" height="45"></canvas>
</div>
</div>
<div id='batt17'>
<div class='batt_text'>
<?php if(isset($bat_name[16])) print $bat_name[16]; ?>
</div>
<div class='div_canvas'>
<canvas id="display16" width="90" height="45"></canvas>
</div>
</div>
<div id='batt18'>
<div class='batt_text'>
<?php if(isset($bat_name[17])) print $bat_name[17]; ?>
</div>
<div class='div_canvas'>
<canvas id="display17" width="90" height="45"></canvas>
</div>
</div>

<div id='batt_dia_div'> 
<img id='batt_dia' />
</div>
<div id='range_1d'>Diagramm<br>1 Tag</div>
<div id='range_1m'>Diagramm<br>1 Monat</div>
<div id='range_3m'>Diagramm<br>3 Monate</div>
<div id='range_6m'>Diagramm<br>6 Monate</div>
<div id='range_1y'>Diagramm<br>1 Jahr</div>
<div id='range_2y'>Diagramm<br>2 Jahre</div>
<div id='range_5y'>Diagramm<br>5 Jahre</div>
<div id='batt_sensor'></div>
<div id='batt_name'></div>
<div id='batt_range'></div>
<div id='batt_umin'>0</div>
<div id='batt_umax'>2</div>
