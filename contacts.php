<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Contacts - LGFC</title>
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
<colgroup>
<col style="width: 6%;">
<col style="width: 8%;">
<col style="width: 8%;">
<col style="width: 9%;">
<col style="width: 9%;">
<col style="width: 18%;">
<col style="width: 10%;">
<col style="width: 12%;">
<col style="width: 20%;">
</colgroup>
<?php
  
  $result = mysqli_query($mysqli, "SELECT * FROM list_contacts LEFT JOIN zip_codes ON list_contacts.zip = zip_codes.code");

  if (!$result) {
    echo("<P>Error performing query: " .
         mysqli_error() . "</P>");
    exit();
  }

echo "<tr><th>ID</th><th>Business Name</th><th>First</th><th>Last</th><th><dd>Phone</dd><dd>Alt Phone</dd></th><th>Address</th><th><dd>City</dd><dd>Zip</dd></th><th>Email</th><th>Note</th></tr>";
  while ( $row = mysqli_fetch_array($result) ) {

  $zips = $row["zip"];
  $city = $row["city"];
if (!empty($row["alt_phone"])){ 
$phones = '<dd>'.$row["phone"].'</dd>'.'<dd>'.$row["alt_phone"].'</dd>'; 
} else { 
$phones = $row["phone"];
}
    echo("<tr>" . "<td>" . $row["contact_id"] . "</td>" . "<td>" . $row["business_name"] . "</td>" . "<td>" . $row["first_name"] . "</td>" . "<td>" . $row["last_name"] . "</td>" . "<td>" . $phones . "</td>" . "<td>" . $row["address"] . "</td>" . "<td>" . "<dd>" . $city . "</dd>" . "<dd>" . $zips . "</dd>" . "</td>" . "<td>" . $row["email"] . "</td>" . "<td>" . $row["note"] . "</td>" . "</tr>");
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