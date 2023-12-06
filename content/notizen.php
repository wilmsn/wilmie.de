<link rel='stylesheet' type='text/css' href='style.css' />
<script type="text/javascript">

let myid = 0;

$(document).ready(function(){
  fill_history();
  fill_id();
});

function save_notiz(){
    let mysubstring;
    let mytext = $("#mynote").val();
    let numrec = 0;
    let numrec_max = 0;
    let textlength = mytext.length;
    let startpos = 0;
    let lfdnr = 0;
    while ( (textlength > 0) && ( (textlength - (numrec*250)) > 0 ) ) {
        numrec++;
    }
//    alert(textlength);
//    alert( (textlength - (numrec*250)) );
    numrec_max = numrec;
//    alert(numrec);
    while (numrec > 0) {
//        alert(numrec);
        startpos = (numrec_max-numrec)*250;
//        alert("Substring Start:"+startpos);
        mysubstring = mytext.substr(startpos,250);
//        alert( mysubstring );
        $.get('/admin/savenotiz.php',{ myid : myid, lfdnr: lfdnr, mytext: mysubstring }, function(data) {
//            alert(numrec);
        });
        numrec--;
        lfdnr++;
        if (numrec == 0) {
            $("#mynote").val("");
//            lfdnr++;
            $.get('/admin/savenotiz.php',{  myid : myid, lfdnr: lfdnr,mytext: "" }, function(data) {
                fill_id();
                fill_history();
            });
        }
    }
}

function fill_history() {
    $.get('/admin/readnotiz.php', function(data) {
        $("#oldtext").html(data);
    });
}

function fill_id() {
    $.get('/admin/readnotizid.php', function(data) {
//        alert("#"+data.trim()+"#");
        myid = 1*parseInt(data.trim(),10);
//        alert(myid);
    });
}

</script>

<div id="oldtext"></div>

<hr>

<textarea id="mynote" name="mynote" rows="10" cols="50">
</textarea>
<br>

<button onclick="save_notiz()">Speichern</button>

