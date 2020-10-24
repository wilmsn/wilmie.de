<?php
$instance="intern";
require_once ('/etc/webserver/'.$instance.'_config.php');
require_once ($webroot."/php_inc/check_mobile.php");
$db = new PDO("mysql:host=$db_sh_server;dbname=$db_sh_db", $db_sh_user, $db_sh_pass);
$reg_array = "";


if (isset($_GET["node"]))  {
  $node=$_GET["node"];
} else { 
  $node=0; 
}

if ( $node > 0 ) { 
	foreach ($db->query("select node_id, node_name, add_info, battery_id, heartbeat from node where node_id = '".$node."'") as $row) {
        if ( $row[4] == 'y' ) { $nor=""; $hb="checked"; } else { $nor="checked"; $hb=""; }
        print "<div class='node'><p>Node: ".$row[0]."&nbsp;&nbsp;<input id='nodename' value='".$row[1]."'></p></div>".
            "<div class='hb'>".
            "<div class='hb'>Heartbeat <input type='radio' name='nodetyp' value='y' ".$hb."></div>".
            "<div class='hb'>Normal <input type='radio' name='nodetyp' value='n' ".$nor."></div>".
            "<div class='hb'>Batterie <select id='bat' name='bat'>";
        foreach ($db->query("select battery_id, battery_sel_txt from battery where battery_id = ".$row[3] ) as $brow) {
            print "<option value='".$brow[0]."' selected>".$brow[1]."</option>"; 
        }
        foreach ($db->query("select battery_id, battery_sel_txt from battery where battery_id > 0 and battery_id != ".$row[3] ) as $brow) {
            print "<option value='".$brow[0]."'>".$brow[1]."</option>"; 
        }
        print "</option></select></div>";
        print "<div class='hb'>&nbsp;&nbsp;&nbsp;HTML Pos&nbsp;&nbsp;&nbsp;<select id='sort' name='sort'>";
        foreach ($db->query("select html_order from node where node_id = ". $node) as $srow) {
            print "<option value='".$srow[0]."' selected>".$srow[0]."</option>"; 
        }
        foreach ($db->query("select number from numbers where number not in ( select html_order from node where html_order is not null)") as $srow) {
            print "<option value='".$srow[0]."'>".$srow[0]."</option>"; 
        }
        
        print "</select></div>".
            "</div>".
            "<textarea id='nodeinfo' class='textarea'>".$row[2]."</textarea>".
            "<input id='onid' type=hidden value=".$node.">".
            "<div class='container'>";
            
    }
    $i = 0;
    $reg_array = "var reg_array = [";
    $reg_val=0;
    $sql = "select a.channel, itemname, value, min, max, readonly from (select node_id, channel, itemname, min, max, readonly, x.html_order from node x, node_configitem y) a left join node_configdata_im b on ( a.node_id = b.node_id and a.channel = b.channel) where a.node_id = ".$node." order by html_order";
	foreach ($db->query($sql) as $crow) { 
        $i1 = $i + 1;
        $i2 = $i + 2;
        if ( $crow[5] == 'n' ) {
            print "<div class='reg'><div id='d".$i1."' class='reg_label'>".$crow[1]."</div><div id='d".$i2."' class='reg_value'><input type='number' id='".$crow[0]."' size='8' min='".$crow[3]."' max='".$crow[4]."' value='".$crow[2]."'><input type='hidden' id='o".$crow[0]."' value='".$crow[2]."'></div></div>";
        } else {
            print "<div class='reg'><div id='d".$i1."' class='reg_label'>".$crow[1]."</div><div id='d".$i2."' class='reg_value'><input readonly id='".$crow[0]."' size='8' value='".$crow[2]."'><input type='hidden' id='o".$crow[0]."' value='".$crow[2]."'></div></div>";
        }
        switch ( $i) {
          case 0: $i = 2; 
          break;
          case 2: $i = 4;
          break;
          case 4: $i = 0;
        }
        if ( $reg_val > 0 ) $reg_array = $reg_array.", ";
        $reg_array = $reg_array .$crow[0];
        $reg_val++;
	} 				
    $reg_array = $reg_array."];";
    switch ( $i) {
        case 2: print "<div></div><div></div>";
        break;
        case 4: print "<div></div>";
    }
    print "<div><button class='ui-btn' onclick='init_window()'>abbrechen</button></div><div></div>".
          "<div><button class='ui-btn' onclick='savenode($node)'>Werte speichern</button></div><div></div>".
          "</div>";
}
?>

<script>

var dirty;
$(document).ready(function(){
  dirty = false;
$('#nodename').on('input', function() {
    dirty=true;
//    alert("nodename dirty");
});
$("input[name='nodetyp']").on('input', function() {
    dirty=true;
//    alert("nodetyp dirty");
});
$('#nodeinfo').on('input', function() {
    dirty=true;
//    alert("nodeinfo dirty");
});
$('#bat').on('input', function() {
    dirty=true;
//    alert("bat dirty");
});
$('#sort').on('input', function() {
    dirty=true;
//    alert("bat dirty");
});

});

function savenode(mynodeid){
   <?php print $reg_array; ?>
    var value;
    var tn_in;
    var onid;
    var nodename;
    var nodetyp;
    var nodeinfo;
    var batid;
    var hsort;
    for ( var i = 0; i < reg_array.length; i++ ) {
        value = reg_array[i];
        if ($("#"+value).val() != $("#o"+value).val() ) {
            tn_in = "push "+mynodeid+" "+value+" "+$("#"+value).val();
            alert(tn_in);
            $.get(mydir+'/rf24hubadm_tn.php',{tn_in: tn_in }, function(data) { 
                // alert(data);
            });
        }
    }  
    onid=$("#onid").val();
    nodename=$("#nodename").val();
    nodetyp=$("input[name='nodetyp']:checked").val();
    nodeinfo=$("#nodeinfo").val();
    batid=$("#bat").val();
    hsort=$("#sort").val();
    if ( dirty ) {
       alert("saving Node: "+onid);
        $.get(mydir+'/savenode.php',{onid: onid, nid: onid, nn: nodename, ni: nodeinfo, hb: nodetyp, bid: batid, sort: hsort }, function(data) { 
    //$.get(mydir+'/savenode.php',{onid: onid }, function(data) { 
            alert(data);
        });
    }
    init_window();
}

</script>

<?php if( is_mobile_browser() ): ?>

<style type=text/css>
#nodename {
  width: 90%;
}

.reg {
    border-radius: .5em;
	border: 1px solid;
	padding: .5em;
	margin: .5em; 
}

.reg_label {
    float: left;
	width: 60%;
}

.reg_value {
  float: left;
  width: 30%;
}

.node {
/*  float: left;
  width: 70%; */
}
.hb {
  float: left;
  padding: 10px;
}



.container {
    display: grid;
    grid-template-columns: auto;
/*    grid-template-rows: 100px 100px 100px 100px; */
    grid-column-gap: 20px
    grid-row-gap: 20px
    justify-items: stretch
    align-items: stretch
 }


textarea {
	caret-color: red;  
	width: 90%;
	height: 15em;
	border: 1px solid #cccccc;
	padding: 0.5em;
	/*font-family: Tahoma, sans-serif;*/
}
textarea:focus {
      background: #FFC;
}

input {
	caret-color: red;  
/*	width: 100%;
	height: 15em; */
	border: 1px solid #cccccc;
	padding: 0.5em;
	/*font-family: Tahoma, sans-serif;*/
}
input:focus {
      background: #FFC;
}

</style>

<?php 
// End mobile Browser
else: 
// Start Desktop Browser
?>

<style type=text/css>

.reg {
    border-radius: .5em;
	border: 1px solid;
	padding: .5em;
	margin: .5em; 
}

.reg_label {
    float: left;
	width: 60%;
}

.reg_value {
  float: left;
  width: 30%;
}

.node {
  float: left;
  width: 50%;
}
.hb {
  float: left;
  padding-top: 10px; 
}


.container {
    display: grid;
    grid-template-columns: auto auto auto;
/*    grid-template-rows: 100px 100px 100px 100px; */
    grid-column-gap: 20px
    grid-row-gap: 20px
    justify-items: stretch
    align-items: stretch
 }


textarea {
	caret-color: red;  
	width: 100%;
	height: 15em;
	border: 1px solid #cccccc;
	padding: 0.5em;
	/*font-family: Tahoma, sans-serif;*/
}
textarea:focus {
      background: #FFC;
}

input {
	caret-color: red;  
	width: 80%;
	border: 1px solid #cccccc;
	padding: 0.5em;
}
input:focus {
      background: #FFC;
}



</style>
<?php endif; ?>		
