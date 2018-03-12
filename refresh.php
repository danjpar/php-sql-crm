<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

if(!empty($_POST))
{

$phone = mysqli_real_escape_string($mysqli , $_POST['phone']);
$a_phone = mysqli_real_escape_string($mysqli , $_POST['alt_phone']);
$first = stripslashes(mysqli_real_escape_string($mysqli , $_POST['first']));
$last = stripslashes(mysqli_real_escape_string($mysqli , $_POST['last']));
$business = stripslashes(mysqli_real_escape_string($mysqli , $_POST['business']));
$note = stripslashes(mysqli_real_escape_string($mysqli , $_POST['note']));
$email = mysqli_real_escape_string($mysqli , $_POST['email']);
$address = stripslashes(mysqli_real_escape_string($mysqli , $_POST['address']));
if (strlen($_POST['zip']) != 5) {
$zip = NULL;
} else { $zip = mysqli_real_escape_string($mysqli , $_POST['zip']); }
$new = mysqli_real_escape_string($mysqli , $_GET['new']);

$date = mysqli_real_escape_string($mysqli , $_POST['date']);
$c_id = $_POST['contact'];
$s_pid = $_POST['assign_to'];
$so_ty = $_POST['source_type'];
$inq_no = mysqli_real_escape_string($mysqli , $_POST['inq_note']);

if ($new === 'inquiry' && !empty($c_id)) {

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql_q = "INSERT INTO list_inquiries (contact_id, date, type, note, salesperson_id) VALUES ('$c_id', '$date', '$so_ty', '$inq_no', '$s_pid')";

if ($mysqli->query($sql_q) === TRUE) {

header("Location:./success-add.php");
exit;
} else {
    echo "Error: " . $sql_q . "<br>" . $mysqli->error;
}
}

if (!empty($phone) && (strlen($phone) === 10)) {
$ph = ctype_digit($phone);
}

if (!empty($a_phone) && (strlen($a_phone) === 10)) {
$pha = ctype_digit($a_phone);
}

$phl = ($ph || $pha);


if (!empty($email)){
$ema = filter_var($email, FILTER_VALIDATE_EMAIL);
}

$c = (!empty($first) && !empty($note));

if ($new === 'contact') {

if ($c) {
if ($phl || $ema) {

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$sql_q = "INSERT INTO list_contacts (business_name, first_name, last_name, phone, alt_phone, address, zip, email, note) VALUES ('$business', '$first', '$last', '$phone', '$a_phone', '$address', '$zip', '$email', '$note')";


if ($mysqli->query($sql_q) === TRUE) {
$newIdQuery = mysqli_query($mysqli, "SELECT LAST_INSERT_ID() AS contactId FROM list_contacts");
$newId = mysqli_fetch_assoc($newIdQuery);

header("Location:./addnew.php?id=$newId[contactId]");

exit;
} else {
    echo "Error: " . $sql_q . "<br>" . $mysqli->error;
}

exit;
} else { $error_msg = 'Please enter a 10 digit phone number or valid email address'; }
} else { $error_msg = 'Please enter at least First Name, a note, and a phone number or email address.'; }
}


if(!empty($_POST['search']))
{
$q=mysqli_real_escape_string($mysqli, $_POST['search']);
$sql_res=mysqli_query($mysqli, "select * from list_contacts where first_name like '%$q%' or last_name like '%$q%' or address like '%$q%' or phone like '%$q%' or alt_phone like '%$q%' order by first_name LIMIT 5");
while($row=mysqli_fetch_array($sql_res))
{
$first=$row['first_name'];
$last=$row['last_name'];
$name= ($first.' '.$last );
$address=$row['address'];
$phone=$row['phone'];
$aphone=$row['alt_phone'];
$bold='<strong>'.$q.'</strong>';
$final_phone = str_ireplace($q, $bold, $phone);
$final_aphone = str_ireplace($q, $bold, $aphone);
$final_name = str_ireplace($q, $bold, $name);
$final_address = str_ireplace($q, $bold, $address);


?>
<div onclick="clicked(this);" class="show" align="left" id="<?php echo $row[contact_id];?>" style="float:left;">
<span class="name"><?php echo $final_name; ?></span>&nbsp;&nbsp;<span class="phones"><?php echo $final_phone; ?></span>&nbsp;<span class="phones"><?php echo $final_aphone; ?></span>&nbsp;<span class='address'><?php echo $final_address; ?>&nbsp;<?php echo $row['zip']; ?></span>
</div><hr style="margin:0;padding:0;height:0;border:none;clear:both;float:none;"/>

<?php
}
}
}else{
header("Location:./addnew.php");
}
?>