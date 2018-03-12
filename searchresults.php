<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();

if (login_check($mysqli) != true){
header("Location:./index.php");
}
if (empty($_POST['search'])) {
header("Location:./search.php");
}

if (!empty($_POST['search_in'])) {
$search_in = $_POST['search_in'];
$search_in = mysqli_real_escape_string($mysqli, $search_in);
} else $search_in = 'contacts';


if (!empty($_POST['search_by'])) {
$search_by = $_POST['search_by'];
$search_by = mysqli_real_escape_string($mysqli, $search_by);
} else $search_by = 'first_name';



$search_q = $_POST['search'];
$search_q = mysqli_real_escape_string($mysqli, $search_q);

if ($search_in == 'contacts') {
$t_head = "<tr>"."<th>" . "Business Name" . "</th>"."<th>" . "First Name" . "</th>"."<th>" . "Last Name" . "</th>"."<th>" . "Address" . "</th>"."<th>" . "City" . "</th>"."<th>" . "Zip" . "</th>"."<th>" . "Phone" . "</th>"."<th>" . "Email" . "</th>"."<th>" . "Note" . "</th>"."</tr>";

$sql_q = "SELECT * FROM list_".$search_in." LEFT JOIN zip_codes ON list_contacts.zip = zip_codes.code WHERE ".$search_by." LIKE '%$search_q%' ";
if (ctype_digit($search_q) && ($search_by == 'phone')) { $sql_q .= "OR list_contacts.alt_phone LIKE '%$search_q%'";  }
}

if ($search_in == 'inquiries') {

$sql_q = "SELECT list_inquiries.*, list_contacts.phone AS ph, list_contacts.alt_phone AS a_ph, list_contacts.business_name AS bn, list_contacts.first_name AS fn, list_contacts.last_name AS ln, source_type.s_name, sales_persons.first_name AS sf, sales_persons.last_name AS sl FROM list_inquiries LEFT JOIN list_contacts ON list_inquiries.contact_id = list_contacts.contact_id LEFT JOIN source_type on list_inquiries.type = source_type.s_id LEFT JOIN sales_persons ON list_inquiries.salesperson_id = sales_persons.id WHERE list_contacts.".$search_by." LIKE '%$search_q%' ";
if (ctype_digit($search_q) && ($search_by == 'phone')) { $sql_q .= "OR list_contacts.alt_phone LIKE '%$search_q%'";  }

$t_head = "<tr>"."<th>"."ID"."</th>"."<th>"."Date"."</th>"."<th>"."Business Name"."</th>"."<th>"."First Name"."</th>"."<th>"."Last Name"."</th>"."<th>"."Phone"."</th>"."<th>"."Type"."</th>"."<th>"."Note"."</th>"."<th>"."Assigned To"."</th>"."</tr>" ;
}



$search_db = mysqli_query($mysqli, $sql_q);

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
<?php include_once 'header.php';?>


<div class="results" style="width:60%;margin:0 auto;text-align:center;">
                <h3>Search Results </h3>
<p><?php echo ('   You searched for '.ucwords($search_q).' in '.ucwords($search_in).' by '.ucwords(str_replace("_"," ",$search_by)).'.');?></p>


</div>
<div class="results" style="width:99%;margin:0 auto;min-width:1000px;">
<table >
<?php 




if (mysqli_num_rows($search_db) != 0){
echo $t_head;

if ($search_in == 'inquiries') {

while ( $row = mysqli_fetch_array($search_db)) {
if (!empty($row["a_ph"])){ 
$phones = '<dd>'.$row["ph"].'</dd>'.'<dd>'.$row["a_ph"].'</dd>'; 
} else { 
$phones = $row["ph"];
}
$salesp = $row["sf"] . " " . $row["sl"];
echo ("<tr>" . "<td>" . $row["inquiry_id"] . "</td>" . "<td>" . $row["date"] . "</td>" . "<td>" . $row["bn"] . "</td>" . "<td>" . $row["fn"] . "</td>" . "<td>" . $row["ln"] . "</td>" . "<td>" . $phones . "</td>" . "<td>" . $row["s_name"] . "</td>" . "<td>" . $row["note"] . "</td>" . "<td>" . $salesp . "</td>" . "</tr>") ;
}

} elseif ($search_in == 'contacts') {

while ( $row = mysqli_fetch_array($search_db)) {

echo ("<tr>"."<td>" . $row["business_name"] . "</td>"."<td>" . $row["first_name"] . "</td>"."<td>" . $row["last_name"] . "</td>"."<td>" . $row["address"] . "</td>"."<td>" . $row["city"] . "</td>"."<td>" . $row["zip"] . "</td>"."<td>" ."<dd>" . $row["phone"] . "</dd>"."<dd>" . $row["alt_phone"] . "</dd>"."</td>"."<td>" . $row["email"] . "</td>"."<td>" . $row["note"] . "</td>"."</tr>") ;
}

}

} else {

echo ('<p style="text-align:center;">Your search for '.$search_q.' did not return any results.</p>');


}


mysqli_close($mysqli);
?>
</table>
</div>
        <p>Return to the <a href="index.php">Home page</a>.</p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>