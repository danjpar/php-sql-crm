<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) != true){
header("Location:./index.php");
}


?>
<!DOCTYPE html>
<html>
    <head>
<style>
#submit {font-weight:bold;}
#mats td {display:inline-flex;}
#mats input {text-align:center;}
#mats {margin:5px auto;}
.button{font-size:.77rem;padding:2px;background-color:#bbb;border:1px solid;border-radius:5px;box-shadow:#777 2px 2px 2px;cursor:pointer;}
.button:hover{background-color:#eee;box-shadow:#aaa -2px 2px 2px;}
#wood-list {text-align:center;position:relative;}
td:first-child {width:88px;}
td:nth-child(2) {width:115px;}
select {text-align:center;margin:0 auto;}
</style>
        <meta charset="UTF-8">
        <title>Addnew - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
        <link href="styles/jquery.datepick.css" rel="stylesheet">
<script src="js/jquery.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>

    </head>
    <body>
<?php include_once 'header.php';?>
<div class="page" style="width:95%;">
        <?php
        if (!empty($error_msg) || !empty($success_msg)) { 
            echo '<h4 style="text-align:center;">'.$success_msg.$error_msg.'</h4>';
        }
?>
<div id='wood-list'>
<h7 id="add" class="button">Add More</h7>
<form id="mats">

<table id='wood-mats1' class="attendee">

<tr><td>
<select id="type1" class="cat" name="type1">
<?php
$ty_res=mysqli_query($mysqli, "SELECT * FROM types WHERE ID BETWEEN 10 and 20");
             while($row=mysqli_fetch_array($ty_res))
             {
              echo '<option value="'.$row['ID'].'">'.$row['Name'].'</option>';
             }
?>
</select>
</td><td>
<select id="item1" class="items"></select>
</td><td>
<input id="cost1" disabled size="3" />
</td><td>
<input class="quantity" size="1" placeholder="QTY" id="qty1"/>
</td><td>
<input id="tot1" disabled size="4" />
</td>
</tr>
</table>
</form>

<h7 id="submit" class="button">Submit</h7>

</div>


<br/><br/>
        <p style="text-align:center;">Return to the <a href="index.php">Home page</a>.</p>
</div> 


<script type="text/javascript">

jQuery(document).ready(function(){

var result = { };
$.each($('form').serializeArray(), function() {
result[this.name] = this.value;
});

   $.ajax({
     type: 'post',
     url: 'wood-calc.php',
     data: {type:result.type1},
     success: function (response) {
       document.getElementById("item1").innerHTML=response; 
     }
   });
setTimeout(
  function() 
  {
$("#cost1").replaceWith(
'<input id="cost1" disabled placeholder="'+$("#item1").val()+'" size="3" />'
);
  }, 430);


  $("#mats").on("change", ".cat", function() {

var get_num = this.id.substring(this.id.length - 1)

var result = { };
$.each($('form').serializeArray(), function() {
    result[this.name] = this.value;
});
var fin = eval("result.type" + get_num);

   $.ajax({
     type: 'post',
     url: 'wood-calc.php',
     data: {type:fin},
     success: function (response) {
       document.getElementById("item" + get_num).innerHTML=response; 
     }
   });
  });
$('#mats').on("change", "select", function() {
var get_num = this.id.substring(this.id.length - 1);

setTimeout(
  function() 
  {
$("#cost"+get_num).replaceWith(
'<input id="cost'+get_num+'" disabled placeholder="'+$("#item"+get_num).val()+'" size="3" />'
);
  }, 500);
});


$("#mats").on("keyup", ".quantity", function() { 

var q_num = $(this).val();
var get_num = $(this).attr('id').substring(this.id.length - 1);
var cost = $('#item'+get_num).val();

if(Math.floor(q_num) == q_num && $.isNumeric(q_num)) {
var tcost = cost * q_num;
$('#tot'+get_num).attr('placeholder', tcost.toFixed(2));
} else {
return false;
}
});


$(function(){
    var template = $('#mats .attendee:first').clone(),
        attendeesCount = 1;

    var addAttendee = function(){
        attendeesCount++;
        var get_num = attendeesCount;
        var attendee = template.clone().find(':input').each(function(){
            var newId = this.id.substring(0, this.id.length-1) + attendeesCount;
            $(this).prev().attr('for', newId); // update label for (assume prev sib is label)
            this.name = this.id = newId; // update id and name (assume the same)
        }).end() // back to .attendee
        .attr('id', 'wood-mats' + attendeesCount) // update attendee id
        .appendTo('#mats'); // add to container



var result = { };
$.each($('form').serializeArray(), function() {
    result[this.name] = this.value;
});
var fin = eval("result.type" + get_num);

   $.ajax({
     type: 'post',
     url: 'wood-calc.php',
     data: {type:fin},
     success: function (response) {
       document.getElementById("item" + get_num).innerHTML=response; 
     }
   });
  

setTimeout(
  function() 
  {
$("#cost"+get_num).replaceWith(
'<input id="cost'+get_num+'" disabled placeholder="'+$("#item"+get_num).val()+'" size="3" />'
);
  }, 800);


    };

    $('#add').click(addAttendee); // attach event
});


});
</script>
<?php mysqli_close($mysqli); ?>
    </body>
</html>