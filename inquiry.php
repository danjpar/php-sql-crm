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
        <title>Inquiries - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
<div style="overflow:auto;" >
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <?php include_once 'header.php';?>
<div class="page" style="width:99%;margin:0 auto;min-width:1000px;" >
<table>
<?php
  
  $result = mysqli_query($mysqli, "SELECT sales_persons.first_name AS s_f, sales_persons.last_name AS s_l, list_inquiries.*, list_contacts.business_name AS b_n, list_contacts.phone as p_h, list_contacts.first_name AS f_n, list_contacts.last_name AS l_n, source_type.s_name FROM list_inquiries LEFT JOIN list_contacts ON list_inquiries.contact_id = list_contacts.contact_id LEFT JOIN source_type on list_inquiries.type = source_type.s_id LEFT JOIN sales_persons ON list_inquiries.salesperson_id = sales_persons.id ");

  if (!$result) {
    echo("<P>Error performing query: " .
         mysqli_error() . "</P>");
    exit();
  }

echo "<tr><th>ID</th><th>Date</th><th>Phone</th><th>Name</th><th>Company</th><th>Type</th><th>Note</th><th>Assigned To</th></tr>";
  while ( $row = mysqli_fetch_array($result, MYSQLI_BOTH) ) {

$names =  "<td>" . $row["f_n"] . " " .  $row["l_n"] . "</td>" . "<td>" . $row["b_n"] . "</td>" ;

$salesp = $row["s_f"] . " " . $row["s_l"];
    echo("<tr>" . "<td>" . $row["inquiry_id"] . "</td>" . "<td>" . $row["date"] . "</td>" . "<td>" . $row["p_h"] . "</td>" . $names . "<td>" . $row["s_name"] . "</td>" . "<td>" . $row["note"] . "</td>" . "<td>" . $salesp . "</td>" . "</tr>");
  }



mysqli_close($mysqli);

?>
</table>
</div></div>

        <p>Return to the <a href="index.php">Home page</a>.</p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>