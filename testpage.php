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
        <meta charset="UTF-8">
        <title>Addnew - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
<script src="js/jquery.js"></script>
    </head>
    <body>

<div class="content" style="margin:0 auto;max-width:95%;">
<input type="text" class="search" id="searchid" placeholder="Search for contact" /><br /> 
<div id="result"></div>
</div>
<div id="div3"></div>


<script>



function clicked(item) {
var cid = $(item).attr("id")
jQuery("#result").fadeOut();
        $("#div3").load("details.php .result", {contact : cid} );
   }

    $(function(){
$(".search").keyup(function() { 
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid==='' || searchid.length <= 2){    
jQuery("#result").fadeOut(); 
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
</body>
</html>