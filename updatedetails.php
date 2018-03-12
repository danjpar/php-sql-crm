<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();

if (login_check($mysqli) != true){
header("Location:./index.php");
}

if (!empty($_POST['contact'])) {
$contact = $_POST['contact'];
$bn = $_POST["business_name"];
$fn = $_POST["first_name"];
$ln = $_POST["last_name"];
$ar = $_POST["address"];
$ct = $_POST["city"];
$zp = $_POST["zip"];
$pn = $_POST["phone"];
$ap = $_POST["alt_phone"];
$em = $_POST["email"];
$no = $_POST["note"];

$sql_q = "UPDATE list_contacts SET zip_codes ON list_contacts.zip = zip_codes.code WHERE contact_id LIKE '%$contact%' ";
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
$ct = $row["city"];
$zp = $row["zip"];
$pn = $row["phone"];
$ap = $row["alt_phone"];
$em = $row["email"];
$no = $row["note"];

echo '
<input id="id" type="hidden" value="'.$row[contact_id].'"></input>
<input value="'.$bn.'" ></input>
<input id="first" value="'.$fn.'" ></input>
<input value="'.$ln.'" ></input>
<input value="'.$ar.'" ></input>
<input value="'.$ct.'" ></input>
<input value="'.$zp.'" ></input>
<input value="'.$pn.'" ></input>
<input value="'.$ap.'" ></input>
<input value="'.$em.'" ></input>
<input value="'.$no.'" ></input>
<button id="c_save"> </button>

<div id="edit_msg"></div>
<script>

    $("#c_save").click(function(){

        $("#edit_msg").load("details.php .result", {
contact : $("#id").val(),

}
);
}
);
}
</script>
';
<

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