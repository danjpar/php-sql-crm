<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();

if (login_check($mysqli) != true){
header("Location:./index.php");
}

if (!empty($_POST['contact'])) {
$contact = $_POST['contact'];


$sql_q = "SELECT * FROM list_contacts LEFT JOIN zip_codes ON list_contacts.zip = zip_codes.code WHERE contact_id LIKE '%$contact%' ";
$search_db = mysqli_query($mysqli, $sql_q);
}


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Search Results - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>

<div class="result" style="width:99%;margin:0 auto;">

<?php 

$row = mysqli_fetch_array($search_db);
$cid = $row["contact_id"];
$bn = $row["business_name"];
$fn = $row["first_name"];
$ln = $row["last_name"];
$ar = $row["address"];
$zp = $row["zip"];
$pn = $row["phone"];
$ap = $row["alt_phone"];
$em = $row["email"];
$no = $row["note"];

echo '

<table style="max-width:650px;" class="add-new">   
<tr>   
<th>Business Name</th> <td>  <input type="text" name="business" value="'.$bn.'" disabled></input></td> 
<th>Email</th> 
<td>  <input type="text" name="email" value="'.$em.'" disabled></input></td>

</tr>   
<tr>   
 <th>First Name</th><td>  <input type="text" name="first" value="'.$fn.'" disabled></input></td> <th>Last Name</th><td>  <input type="text" name="last" value="'.$ln.'" disabled></input></td></tr>
<tr>  <th>Phone</th> <td>  <input type="text" name="phone" value="'.$pn.'" disabled></input></td> <th>Alt Phone</th> <td>  <input type="text" name="alt_phone" value="'.$ap.'" disabled></input></td> 
</tr>
<tr>         

<th>Address</th> <td>  <input type="text" name="address" value="'.$ar.'" disabled></input></td>  <th>Zip</th> <td>  <input type="text" name="zip" value="'.$zp.'" disabled></input></td> </tr>
<tr> 

<th>Note</th>
<td colspan="3">  <input type="text" name="note" value="'.$no.'" disabled></input></td> 
</tr>
<tr>   <td>
<input id="contact_id" type="hidden" value="'.$row[contact_id].'"></input>
</td></tr>
</table>


<div id="edit_msg"></div>
<script>

    $("#c_save").click(function(){

        $("#edit_msg").load( "details.php .result", {contact : $("#id").val()} );
}
);
}
</script>

';


mysqli_close($mysqli);
?>

</div>
        <p>Return to the <a href="index.php">Home page</a>.</p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>