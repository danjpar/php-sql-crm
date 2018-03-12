<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
sec_session_start();
if (login_check($mysqli) != true){
header("Location:./index.php");
}
header("Refresh: 3;url=./addnew.php");

$success_msg = 'Success! Thank you for being a good sport.';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Addnew - LGFC</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
<?php include_once 'header.php';?>
        <?php
        if (!empty($error_msg) || !empty($success_msg)) { 
            echo '<h4 style="text-align:center;">'.$success_msg.$error_msg.'</h4>';
        }

?>


        <p>Return to the <a href="index.php">Home page</a>.</p>
<?php mysqli_close($mysqli); ?>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="index.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>