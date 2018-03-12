<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) != true){
header("Location:./index.php");
}
if (ctype_digit($_GET['id'])) {
$inq_conid = mysqli_real_escape_string($mysqli , $_GET['id']);
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Addnew - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
        <link href="styles/jquery.datepick.css" rel="stylesheet">
<script src="js/jquery.js"></script>
<script src="js/jquery.plugin.js"></script>
<script src="js/jquery.datepick.js"></script>
<script>
$(function() {
$('#popupDatepicker').datepick({dateFormat: 'yyyy-mm-dd'});
$('#inlineDatepicker').datepick({onSelect: showDate});
});
function showDate(date) {
alert('The date chosen is ' + date);
}
</script>
    </head>
    <body>
<?php include_once 'header.php';?>
<div class="page" style="width:95%;">
        <?php
        if (!empty($error_msg) || !empty($success_msg)) { 
            echo '<h4 style="text-align:center;">'.$success_msg.$error_msg.'</h4>';
        }

if (empty($_GET)) {

echo '
<div id="search-for" style="margin:0 auto;max-width:95%;text-align:center;">
<input type="text" class="search" id="searchid" placeholder="Search for contact" /> 
<div id="result" style="max-width:640px;margin:0 auto;"></div>
</div>
<div id="new-contact">
<h3 style="text-align:center;">Add New Contact</h3>
<form action="refresh.php?new=contact" method="post" style="margin:5px 0 10px;text-align:center;" >
<table style="max-width:650px;" class="add-new">
<tr>   
<th>Business Name</th> <td>  <input type="text" name="business" maxlength="50"></input></td> 
<th style="color:red;">Email</th> 
<td>  <input type="text" name="email" maxlength="80"></input></td>

</tr>   
<tr>   
 <th style="color:red;">First Name *</th><td>  <input type="text" name="first" maxlength="30"></input></td> <th>Last Name</th><td>  <input type="text" name="last" maxlength="30"></input></td></tr>
<tr>  <th style="color:red;">Phone</th> <td>  <input type="text" name="phone" maxlength="10"></input></td> <th>Alt Phone</th> <td>  <input type="text" name="alt_phone" maxlength="10"></input></td> 
</tr>
<tr>         

<th>Address</th> <td>  <input type="text" name="address" maxlength="80"></input></td>  <th>Zip</th> <td>  <input type="text" name="zip" maxlength="5"></input></td> </tr>
<tr> 

<th style="color:red;">Note *</th>
<td colspan="3">  <input type="text" name="note" maxlength="160"></input></td> 
</tr>
</table> 
<input type="submit" value="Save" />
</form>
</div> 

<br>

<div id="hidden" style="display:none;">
<div id="new-inquiry" style="margin:0 auto;max-width:640px;">
<h3 style="text-align:center;">Add New Inquiry</h3>
<div id="div3"></div>
<hr style="margin:0;padding:0;height:0;border:none;clear:both;float:none;"/>
<form action="refresh.php?new=inquiry" method="post" style="margin:5px 0 10px;text-align:center;" >
<div style="float:left;">
<input id="con_id" name="contact" type="hidden"></input>
  <input type="text" name="date" id="popupDatepicker" placeholder="Date"></input></div>
';

$st_query = mysqli_query($mysqli, "SELECT * FROM source_type WHERE s_id <= 9");
echo '<div style="float:left;"> Source: <select name="source_type"><option value=""></option>';

while ($row = mysqli_fetch_array($st_query)) {
   echo '<div style="float:left;"><option value="'.$row['s_id'].'">'.$row['s_name'].'</option>';
}

echo '</select></div>';

$s_query = mysqli_query($mysqli, "SELECT sales_persons.first_name, sales_persons.last_name, sales_persons.id FROM sales_persons");
echo '<div style="float:left;"> Assign To: <select name="assign_to"><option value=""></option>';

while ($row = mysqli_fetch_array($s_query)) {
   echo '<option value="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
}

echo '</select></div><hr style="margin:0;padding:0;height:0;border:none;clear:both;float:none;"/>
Note: </br>
  <input type="text" name="inq_note" style="width:100%;"></input>
<input type="submit" value="Save" />
</form>
</div>
';
} elseif (!empty($inq_conid)) {
$c_id = $inq_conid;
$show_con = mysqli_query($mysqli, "select * from list_contacts where contact_id = '%$c_id%' " ) ;
while($contact =mysqli_fetch_array($show_con)){
echo $contact[first_name].' '.$contact[last_name].' '.$contact[phone].' '.$contact[address].' '.$contact[zip] ;
}

echo '
<div id="new-inquiry" style="margin:0 auto;max-width:640px;">
<h3 style="text-align:center;">Add New Inquiry</h3>
<div id="div3"></div>

<hr style="margin:0;padding:0;height:0;border:none;clear:both;float:none;"/>
<form action="refresh.php?new=inquiry" method="post" style="margin:5px 0 10px;text-align:center;" >
<div style="float:left;">Contact Id '.$inq_conid.' 
<input id="con_id" name="contact" type="hidden" value="'.$inq_conid.'"></input>
  <input type="text" name="date" id="popupDatepicker" placeholder="Date"></input>
</div>
';

$st_query = mysqli_query($mysqli, "SELECT * FROM source_type");
echo '<div style="float:left;"> Source: <select name="source_type"><option value=""></option>';

while ($row = mysqli_fetch_array($st_query)) {
   echo '<div style="float:left;"><option value="'.$row['s_id'].'">'.$row['s_name'].'</option>';
}

echo '</select></div>';

$s_query = mysqli_query($mysqli, "SELECT sales_persons.first_name, sales_persons.last_name, sales_persons.id FROM sales_persons");
echo '<div style="float:left;"> Assign To: <select name="assign_to"><option value=""></option>';

while ($row = mysqli_fetch_array($s_query)) {
   echo '<option value="'.$row['id'].'">'.$row['first_name'].' '.$row['last_name'].'</option>';
}

echo '</select></div><hr style="margin:0;padding:0;height:0;border:none;clear:both;float:none;"/>
Note: </br>
  <input type="text" name="inq_note" style="width:100%;"></input>
<input type="submit" value="Save" />
</form>
</div>
';

} else {
echo 'Sorry, invalid authorization.';
}
?>
<br/><br/>
        <p style="text-align:center;">Return to the <a href="index.php">Home page</a>.</p>
</div> 
<script>


function clicked(item) {
var cid = $(item).attr("id")
var element = $(item);

jQuery("#result").fadeOut();
        $("input[id=con_id]").val(cid) ;
        $("#div3").replaceWith(element);
        $("#new-inquiry .show").replaceWith(element);
        $("#new-inquiry .show").attr('onclick',false);
        $("#hidden").replaceWith($("#new-inquiry"));
        $("#new-contact").attr('class','hidden');
        $("#new-inquiry").attr('class','show');
   }

    $(function(){
$(".search").keyup(function() { 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid==='' || searchid.length <= 2){    
jQuery("#result").fadeOut(); 
        $("#new-contact").attr('class','show');
        $("#new-inquiry").attr('class','hidden');
        $("#new-inquiry .show").fadeOut();
}
else
{
    $.ajax({
    type: "POST",
    url: "refresh.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
    $("#result").html(html).show();
    }
    });
}return false;    
});
jQuery("#result").live("click",function(e){ 
    var $clicked = $(e.target);
    var $name = $clicked.find('.name').html();
    var decoded = $("<div/>").html($name).text();
    $('#searchid').val(decoded);
});
jQuery(document).live("click", function(e) { 
    var $clicked = $(e.target);
    if (! $clicked.hasClass("search")){
    jQuery("#result").fadeOut(); 
    }
});
$('#searchid').click(function(){
    jQuery("#result").fadeIn();
});

});


</script>
<?php mysqli_close($mysqli); ?>
    </body>
</html>