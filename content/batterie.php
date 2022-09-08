<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ($webroot.'/php_inc/check_mobile.php');
$db = new mysqli($db_sh_server, $db_sh_user, $db_sh_pass, $db_sh_db);
$mobile_browser = is_mobile_browser(); 
if ( isset( $batt1_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt1_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt1_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat1=$row['value'];
} else {
    $bat1=0;
}
if ( isset( $batt2_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt2_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt2_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat2=$row['value'];
} else {
    $bat2=0;
}
if ( isset( $batt3_name ) ) {
   $stmt = "select value from sensordata where sensor_id = ".$batt3_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt3_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat3=$row['value'];
} else {
    $bat3=0;
}
if ( isset( $batt4_name ) ) {
   $stmt = "select value from sensordata where sensor_id = ".$batt4_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt4_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat4=$row['value'];
} else {
    $bat4=0;
}
if ( isset( $batt5_name ) ) {
   $stmt = "select value from sensordata where sensor_id = ".$batt5_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt5_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat5=$row['value'];
} else {
    $bat5=0;
}
if ( isset( $batt6_name ) ) {
   $stmt = "select value from sensordata where sensor_id = ".$batt6_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt6_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat6=$row['value'];
} else {
    $bat6=0;
}
if ( isset( $batt7_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt7_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt7_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat7=$row['value'];
} else {
    $bat7=0;
}
if ( isset( $batt8_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt8_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt8_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat8=$row['value'];
} else {
    $bat8=0;
}
if ( isset( $batt9_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt9_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt9_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat9=$row['value'];
} else {
    $bat9=0;
}
if ( isset( $batt10_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt10_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt10_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat10=$row['value'];
} else {
    $bat10=0;
}
if ( isset( $batt11_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt11_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt11_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat11=$row['value'];
} else {
    $bat11=0;
}
if ( isset( $batt12_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt12_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt12_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat12=$row['value'];
} else {
    $bat12=0;
}
if ( isset( $batt13_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt13_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt13_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat13=$row['value'];
} else {
    $bat13=0;
}
if ( isset( $batt14_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt14_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt14_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat14=$row['value'];
} else {
    $bat14=0;
}
if ( isset( $batt15_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt15_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt15_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat15=$row['value'];
} else {
    $bat15=0;
}
if ( isset( $batt16_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt16_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt16_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat16=$row['value'];
} else {
    $bat16=0;
}
if ( isset( $batt17_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt17_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt17_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat17=$row['value'];
} else {
    $bat17=0;
}
if ( isset( $batt18_name ) ) {
    $stmt = "select value from sensordata where sensor_id = ".$batt18_sensor." and utime = (select max(utime) from sensordata where sensor_id = ".$batt18_sensor.")";
    $results = $db->query($stmt);
    $row = $results->fetch_assoc();
    $bat18=$row['value'];
} else {
    $bat18=0;
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

#batt1 {
  left: 2%;
  top:  10px;
}
#batt2 {
  left: 35%;
  top:  10px;
}
#batt3 {
  left: 68%;
  top:  10px;
}
#batt4 {
  left: 2%;
  top:  90px;
}
#batt5 {
  left: 35%;
  top:  90px;
}
#batt6 {
  left: 68%;
  top:  90px;
}
#batt7 {
  left: 2%;
  top:  170px;
}
#batt8 {
  left: 35%;
  top:  170px;
}
#batt9 {
  left: 68%;
  top:  170px;
}
#batt10 {
  left: 2%;
  top:  250px;
}
#batt11 {
  left: 35%;
  top:  250px;
}
#batt12 {
  left: 68%;
  top:  250px;
}
#batt13 {
  left: 2%;
  top:  330px;
}
#batt14 {
  left: 35%;
  top:  330px;
}
#batt15 {
  left: 68%;
  top:  330px;
}
#batt16 {
  left: 2%;
  top:  410px;
}
#batt17 {
  left: 35%;
  top:  410px;
}
#batt18 {
  left: 68%;
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
  height: 45px;
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
 
 #batt_dia_div { 
  border: 1px solid #000; 
  background: #ddd; 
  position: absolute;
  left: 350px;
  top: 10px;
  height: 390px;
  width: 850px;	  
  }


#range_1d {
  left: 350px;
  top:  410px;
}

#range_1m {
  left: 470px;
  top:  410px;
}

#range_3m {
  left: 590px;
  top:  410px;
}

#range_6m {
  left: 710px;
  top:  410px;
}

#range_1y {
  left: 830px;
  top:  410px;
}

#range_2y {
  left: 950px;
  top:  410px;
}

#range_5y {
  left: 1070px;
  top:  410px;
}

#batt1 {
  left: 0px;
  top:  10px;
}
#batt2 {
  left: 110px;
  top:  10px;
}
#batt3 {
  left: 230px;
  top:  10px;
}
#batt4 {
  left: 0px;
  top:  90px;
}
#batt5 {
  left: 110px;
  top:  90px;
}
#batt6 {
  left: 230px;
  top:  90px;
}
#batt7 {
  left: 0px;
  top:  170px;
}
#batt8 {
  left: 110px;
  top:  170px;
}
#batt9 {
  left: 230px;
  top:  170px;
}
#batt10 {
  left: 0px;
  top:  250px;
}
#batt11 {
  left: 110px;
  top:  250px;
}
#batt12 {
  left: 230px;
  top:  250px;
}
#batt13 {
  left: 0px;
  top:  330px;
}
#batt14 {
  left: 110px;
  top:  330px;
}
#batt15 {
  left: 230px;
  top:  330px;
}
#batt16 {
  left: 0px;
  top:  410px;
}
#batt17 {
  left: 110px;
  top:  410px;
}
#batt18 {
  left: 230px;
  top:  410px;
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
var but_color_low = '#AAAA00';
var but_color_down = '#AA0000';

for ( let i=0; i<18; i++ ) {
  display.push( new SegmentDisplay("display"+i) );
  display[i].pattern         = "#.##";
  display[i].colorOn         = "#a90329";
  display[i].colorOff        = but_color2;
  display[i].digitHeight     = 17;
  display[i].digitWidth      = 10;
  display[i].draw();
}
  display[0].setValue('<?php print $bat1; ?>');
  display[1].setValue('<?php print $bat2; ?>');
  display[2].setValue('<?php print $bat3; ?>');
  display[3].setValue('<?php print $bat4; ?>');
  display[4].setValue('<?php print $bat5; ?>');
  display[5].setValue('<?php print $bat6; ?>');
  display[6].setValue('<?php print $bat7; ?>');
  display[7].setValue('<?php print $bat8; ?>');
  display[8].setValue('<?php print $bat9; ?>');
  display[9].setValue('<?php print $bat10; ?>');
  display[10].setValue('<?php print $bat11; ?>');
  display[11].setValue('<?php print $bat12; ?>');
  display[12].setValue('<?php print $bat13; ?>');
  display[13].setValue('<?php print $bat14; ?>');
  display[14].setValue('<?php print $bat15; ?>');
  display[15].setValue('<?php print $bat16; ?>');
  display[16].setValue('<?php print $bat17; ?>');
  display[17].setValue('<?php print $bat18; ?>');

  
function reset_batt() {
    $('#batt1').css('backgroundColor', but_color1);
    $('#batt2').css('backgroundColor', but_color1);
    $('#batt3').css('backgroundColor', but_color1);
    $('#batt4').css('backgroundColor', but_color1);
    $('#batt5').css('backgroundColor', but_color1);
    $('#batt6').css('backgroundColor', but_color1);
/*    if ( <?php print $bat7; ?> < <?php print $bat7_umin; ?> ) {
    $('#batt7').css('backgroundColor', but_color_warn);
    } else { */
    $('#batt7').css('backgroundColor', but_color1);
/*    }    */
    $('#batt8').css('backgroundColor', but_color1);
    $('#batt9').css('backgroundColor', but_color1);
    $('#batt10').css('backgroundColor', but_color1);
    $('#batt11').css('backgroundColor', but_color1);
    $('#batt12').css('backgroundColor', but_color1);
    $('#batt13').css('backgroundColor', but_color1);
    $('#batt14').css('backgroundColor', but_color1);
    $('#batt15').css('backgroundColor', but_color1);
    $('#batt16').css('backgroundColor', but_color1);
    $('#batt17').css('backgroundColor', but_color1);
    $('#batt18').css('backgroundColor', but_color1);
    for ( let i=0; i<18; i++ ) {
        display[i].colorOff = but_color1;
        display[i].draw();
    }
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
    
    if ( w > 846 ) { w = 846; } else { if ( w > 500 ) { w = w-50; } }
	$('#batt_dia').attr('src', '/content/diagramm.php?sensor1='+$('#batt_sensor').html()+'&sensor1color=FF0000&sensor1legend='+$('#batt_name').html()+'&sizex='+w+'&sizey=390&offset=0&range='+$('#batt_range').html()+'&ymin='+$('#batt_umin').html()+'&ymax='+$('#batt_umax').html()+'&t='+n);
}

$(window).resize(function() {
    set_divs();
});

$("#batt1").click(function(){
    $('#batt_sensor').html('<?php print $batt1_sensor; ?>');  
    $('#batt_name').html('<?php print $batt1_name; ?>');  
    reset_batt();
    $('#batt1').css('backgroundColor', but_color2);
    display[0].colorOff = but_color2;
    display[0].draw();
    $('#batt_umin').html('<?php print $batt1_umin; ?>');
    $('#batt_umax').html('<?php print $batt1_umax; ?>');
    set_divs();
});

$("#batt2").click(function(){
    $('#batt_sensor').html('<?php print $batt2_sensor; ?>');  
    $('#batt_name').html('<?php print $batt2_name; ?>');  
    reset_batt();
    $('#batt2').css('backgroundColor', but_color2);
    display[1].colorOff = but_color2;
    display[1].draw();
    $('#batt_umin').html('<?php print $batt2_umin; ?>');
    $('#batt_umax').html('<?php print $batt2_umax; ?>');
    set_divs();
});

$("#batt3").click(function(){
    $('#batt_sensor').html('<?php print $batt3_sensor; ?>');  
    $('#batt_name').html('<?php print $batt3_name; ?>');  
    reset_batt();
    $('#batt3').css('backgroundColor', but_color2);
    display[2].colorOff = but_color2;
    display[2].draw();
    $('#batt_umin').html('<?php print $batt3_umin; ?>');
    $('#batt_umax').html('<?php print $batt3_umax; ?>');
    set_divs();
});

$("#batt4").click(function(){
    $('#batt_sensor').html('<?php print $batt4_sensor; ?>');  
    $('#batt_name').html('<?php print $batt4_name; ?>');  
    reset_batt();
    $('#batt4').css('backgroundColor', but_color2);
    display[3].colorOff = but_color2;
    display[3].draw();
    $('#batt_umin').html('<?php print $batt4_umin; ?>');
    $('#batt_umax').html('<?php print $batt4_umax; ?>');
    set_divs();
});

$("#batt5").click(function(){
    $('#batt_sensor').html('<?php print $batt5_sensor; ?>');  
    $('#batt_name').html('<?php print $batt5_name; ?>');  
    reset_batt();
    $('#batt5').css('backgroundColor', but_color2);
    display[4].colorOff = but_color2;
    display[4].draw();
    $('#batt_umin').html('<?php print $batt5_umin; ?>');
    $('#batt_umax').html('<?php print $batt5_umax; ?>');
    set_divs();
});

$("#batt6").click(function(){
    $('#batt_sensor').html('<?php print $batt6_sensor; ?>');  
    $('#batt_name').html('<?php print $batt6_name; ?>');  
    reset_batt();
    $('#batt6').css('backgroundColor', but_color2);
    display[5].colorOff = but_color2;
    display[5].draw();
    $('#batt_umin').html('<?php print $batt6_umin; ?>');
    $('#batt_umax').html('<?php print $batt6_umax; ?>');
    set_divs();
});

$("#batt7").click(function(){
    $('#batt_sensor').html('<?php print $batt7_sensor; ?>');  
    $('#batt_name').html('<?php print $batt7_name; ?>');  
    reset_batt();
    $('#batt7').css('backgroundColor', but_color2);
    display[6].colorOff = but_color2;
    display[6].draw();
    $('#batt_umin').html('<?php print $batt7_umin; ?>');
    $('#batt_umax').html('<?php print $batt7_umax; ?>');
    set_divs();
});

$("#batt8").click(function(){
    $('#batt_sensor').html('<?php print $batt8_sensor; ?>');  
    $('#batt_name').html('<?php print $batt8_name; ?>');  
    reset_batt();
    $('#batt8').css('backgroundColor', but_color2);
    display[7].colorOff = but_color2;
    display[7].draw();
    $('#batt_umin').html('<?php print $batt8_umin; ?>');
    $('#batt_umax').html('<?php print $batt8_umax; ?>');
    set_divs();
});

$("#batt9").click(function(){
    $('#batt_sensor').html('<?php print $batt9_sensor; ?>');  
    $('#batt_name').html('<?php print $batt9_name; ?>');  
    reset_batt();
    $('#batt9').css('backgroundColor', but_color2);
    display[8].colorOff = but_color2;
    display[8].draw();
    $('#batt_umin').html('<?php print $batt9_umin; ?>');
    $('#batt_umax').html('<?php print $batt9_umax; ?>');
    set_divs();
});

$("#batt10").click(function(){
    $('#batt_sensor').html('<?php print $batt10_sensor; ?>');  
    $('#batt_name').html('<?php print $batt10_name; ?>');  
    reset_batt();
    $('#batt10').css('backgroundColor', but_color2);
    display[9].colorOff = but_color2;
    display[9].draw();
    $('#batt_umin').html('<?php print $batt10_umin; ?>');
    $('#batt_umax').html('<?php print $batt10_umax; ?>');
    set_divs();
});

$("#batt11").click(function(){
    $('#batt_sensor').html('<?php print $batt11_sensor; ?>');
    $('#batt_name').html('<?php print $batt11_name; ?>');
    reset_batt();
    $('#batt11').css('backgroundColor', but_color2);
    display[10].colorOff = but_color2;
    display[10].draw();
    $('#batt_umin').html('<?php print $batt11_umin; ?>');
    $('#batt_umax').html('<?php print $batt11_umax; ?>');
    set_divs();
});

$("#batt12").click(function(){
    $('#batt_sensor').html('<?php print $batt12_sensor; ?>');
    $('#batt_name').html('<?php print $batt12_name; ?>');
    reset_batt();
    $('#batt12').css('backgroundColor', but_color2);
    display[11].colorOff = but_color2;
    display[11].draw();
    $('#batt_umin').html('<?php print $batt12_umin; ?>');
    $('#batt_umax').html('<?php print $batt12_umax; ?>');
    set_divs();
});

$("#batt13").click(function(){
    $('#batt_sensor').html('<?php print $batt13_sensor; ?>');
    $('#batt_name').html('<?php print $batt13_name; ?>');
    reset_batt();
    $('#batt13').css('backgroundColor', but_color2);
    display[12].colorOff = but_color2;
    display[12].draw();
    $('#batt_umin').html('<?php print $batt13_umin; ?>');
    $('#batt_umax').html('<?php print $batt13_umax; ?>');
    set_divs();
});

$("#batt14").click(function(){
    $('#batt_sensor').html('<?php print $batt14_sensor; ?>');
    $('#batt_name').html('<?php print $batt14_name; ?>');
    reset_batt();
    $('#batt14').css('backgroundColor', but_color2);
    display[13].colorOff = but_color2;
    display[13].draw();
    $('#batt_umin').html('<?php print $batt14_umin; ?>');
    $('#batt_umax').html('<?php print $batt14_umax; ?>');
    set_divs();
});

$("#batt15").click(function(){
    $('#batt_sensor').html('<?php print $batt15_sensor; ?>');
    $('#batt_name').html('<?php print $batt15_name; ?>');
    reset_batt();
    $('#batt15').css('backgroundColor', but_color2);
    display[14].colorOff = but_color2;
    display[14].draw();
    $('#batt_umin').html('<?php print $batt15_umin; ?>');
    $('#batt_umax').html('<?php print $batt15_umax; ?>');
    set_divs();
});

$("#batt16").click(function(){
    $('#batt_sensor').html('<?php print $batt16_sensor; ?>');
    $('#batt_name').html('<?php print $batt16_name; ?>');
    reset_batt();
    $('#batt16').css('backgroundColor', but_color2);
    display[15].colorOff = but_color2;
    display[15].draw();
    $('#batt_umin').html('<?php print $batt16_umin; ?>');
    $('#batt_umax').html('<?php print $batt16_umax; ?>');
    set_divs();
});

$("#batt17").click(function(){
    $('#batt_sensor').html('<?php print $batt17_sensor; ?>');
    $('#batt_name').html('<?php print $batt17_name; ?>');
    reset_batt();
    $('#batt17').css('backgroundColor', but_color2);
    display[16].colorOff = but_color2;
    display[16].draw();
    $('#batt_umin').html('<?php print $batt17_umin; ?>');
    $('#batt_umax').html('<?php print $batt17_umax; ?>');
    set_divs();
});

$("#batt18").click(function(){
    $('#batt_sensor').html('<?php print $batt18_sensor; ?>');
    $('#batt_name').html('<?php print $batt18_name; ?>');
    reset_batt();
    $('#batt18').css('backgroundColor', but_color2);
    display[17].colorOff = but_color2;
    display[17].draw();
    $('#batt_umin').html('<?php print $batt18_umin; ?>');
    $('#batt_umax').html('<?php print $batt18_umax; ?>');
    set_divs();
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

$('#batt_sensor').html('<?php print $batt1_sensor; ?>');  
$('#batt_sensor').hide();  
$('#batt_name').html('<?php print $batt1_name; ?>');  
$('#batt_name').hide();  
$('#batt_range').html('1d');  
$('#batt_range').hide();  
$('#batt_umin').html('1d');  
$('#batt_umin').hide();  
$('#batt_umax').html('1d');  
$('#batt_umax').hide();  

<?php if ( ! isset( $batt1_name ) ) print "$('#batt1').hide();"; ?>
<?php if ( ! isset( $batt2_name ) ) print "$('#batt2').hide();"; ?>
<?php if ( ! isset( $batt3_name ) ) print "$('#batt3').hide();"; ?>
<?php if ( ! isset( $batt4_name ) ) print "$('#batt4').hide();"; ?>
<?php if ( ! isset( $batt5_name ) ) print "$('#batt5').hide();"; ?>
<?php if ( ! isset( $batt6_name ) ) print "$('#batt6').hide();"; ?>
<?php if ( ! isset( $batt7_name ) ) print "$('#batt7').hide();"; ?>
<?php if ( ! isset( $batt8_name ) ) print "$('#batt8').hide();"; ?>
<?php if ( ! isset( $batt9_name ) ) print "$('#batt9').hide();"; ?>
<?php if ( ! isset( $batt10_name ) ) print "$('#batt10').hide();"; ?>
<?php if ( ! isset( $batt11_name ) ) print "$('#batt11').hide();"; ?>
<?php if ( ! isset( $batt12_name ) ) print "$('#batt12').hide();"; ?>
<?php if ( ! isset( $batt13_name ) ) print "$('#batt13').hide();"; ?>
<?php if ( ! isset( $batt14_name ) ) print "$('#batt14').hide();"; ?>
<?php if ( ! isset( $batt15_name ) ) print "$('#batt15').hide();"; ?>
<?php if ( ! isset( $batt16_name ) ) print "$('#batt16').hide();"; ?>
<?php if ( ! isset( $batt17_name ) ) print "$('#batt17').hide();"; ?>
<?php if ( ! isset( $batt18_name ) ) print "$('#batt18').hide();"; ?>


reset_batt();
reset_range();
$('#range_1d').css('backgroundColor', but_color2);
$('#batt1').css('backgroundColor', but_color2);
display[0].colorOff = but_color2;
display[0].draw();
$('#batt_umin').html('<?php print $batt1_umin; ?>');
$('#batt_umax').html('<?php print $batt1_umax; ?>');
set_divs();

</script>	
<meta http-equiv="expires" content="0">
</head>


<div id='batt1'>
<div class='batt_text'>
<?php if(isset($batt1_name)) print $batt1_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display0" width="90" height="45"></canvas>
</div>
</div>
<div id='batt2'>
<div class='batt_text'>
<?php if(isset($batt2_name)) print $batt2_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display1" width="90" height="45"></canvas>
</div>
</div>
<div id='batt3'>
<div class='batt_text'>
<?php if(isset($batt3_name)) print $batt3_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display2" width="90" height="45"></canvas>
</div>
</div>
<div id='batt4'>
<div class='batt_text'>
<?php if(isset($batt4_name)) print $batt4_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display3" width="90" height="45"></canvas>
</div>
</div>
<div id='batt5'>
<div class='batt_text'>
<?php if(isset($batt5_name)) print $batt5_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display4" width="90" height="45"></canvas>
</div>
</div>
<div id='batt6'>
<div class='batt_text'>
<?php if(isset($batt6_name)) print $batt6_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display5" width="90" height="45"></canvas>
</div>
</div>
<div id='batt7'>
<div class='batt_text'>
<?php if(isset($batt7_name)) print $batt7_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display6" width="90" height="45"></canvas>
</div>
</div>
<div id='batt8'>
<div class='batt_text'>
<?php if(isset($batt8_name)) print $batt8_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display7" width="90" height="45"></canvas>
</div>
</div>
<div id='batt9'>
<div class='batt_text'>
<?php if(isset($batt9_name)) print $batt9_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display8" width="90" height="45"></canvas>
</div>
</div>
<div id='batt10'>
<div class='batt_text'>
<?php if(isset($batt10_name)) print $batt10_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display9" width="90" height="45"></canvas>
</div>
</div>
<div id='batt11'>
<div class='batt_text'>
<?php if(isset($batt11_name)) print $batt11_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display10" width="90" height="45"></canvas>
</div>
</div>
<div id='batt12'>
<div class='batt_text'>
<?php if(isset($batt12_name)) print $batt12_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display11" width="90" height="45"></canvas>
</div>
</div>
<div id='batt13'>
<div class='batt_text'>
<?php if(isset($batt13_name)) print $batt13_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display12" width="90" height="45"></canvas>
</div>
</div>
<div id='batt14'>
<div class='batt_text'>
<?php if(isset($batt14_name)) print $batt14_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display13" width="90" height="45"></canvas>
</div>
</div>
<div id='batt15'>
<div class='batt_text'>
<?php if(isset($batt15_name)) print $batt15_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display14" width="90" height="45"></canvas>
</div>
</div>
<div id='batt16'>
<div class='batt_text'>
<?php if(isset($batt16_name)) print $batt16_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display15" width="90" height="45"></canvas>
</div>
</div>
<div id='batt17'>
<div class='batt_text'>
<?php if(isset($batt17_name)) print $batt17_name; ?>
</div>
<div class='div_canvas'>
<canvas id="display16" width="90" height="45"></canvas>
</div>
</div>
<div id='batt18'>
<div class='batt_text'>
<?php if(isset($batt18_name)) print $batt18_name; ?>
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
