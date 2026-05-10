<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
$dh_db = new PDO("mysql:host=$db_dh_server;dbname=$db_dh_db", $db_dh_user, $db_dh_pass);
?>

<script type="text/javascript">
var mydir = '/admin';

$(document).ready(function() {
  $("#datahub").html("<div id='list'></div>"+
                     "<div id='detail'></div>");
//  init_window();
    show_list();
});

function del_ds(sensorno,utime,page) {
//  alert("Delete Sensor: "+sensor+" Utime: "+utime);
  $.get(mydir+'/datahub_update.php',{sensorno: sensorno, utime: utime, action: "delete"}, function(data) {
    alert(data);
    show_detail(sensorno,page);
  });

}

function upd_ds(sensorno,utime,page) {
  var val = $("#"+utime).val();
  $.get(mydir+'/datahub_update.php',{sensorno: sensorno, utime: utime, value: val, action: "update"}, function(data) {
    alert(data);
    show_detail(sensorno,page);
  });
//  alert("Update Sensor: "+sensor+" Utime: "+utime+" Val: "+val);
}

function goto_page(sensor) {
  show_detail(sensor,$("#to_page").val());
}

function show_list() {
  $("#detail").hide();
  $.get(mydir+'/datahub_sensorlist.php', function(data) {
    $('#list').append(data);
  });
  $("#list").show();
}

function show_detail(sensorno, page) {
  $("#list").hide();
//  $("#detail").html("<h1>Detail zu Sensor<br>"+sensorno+"</h1><hr>");
    $.get(mydir+'/datahub_sensordata.php',{sensor: sensorno, page: page}, function(data) {
        $('#detail').html(data);
    });
  $("#detail").show();
}
</script>

<div id="datahub">Datahub
</div>
